/*
 * UTM builder engine. Renders any builder defined in configs.js into #utm-app.
 * Runs entirely in the browser; nothing is sent anywhere.
 */
(function () {
  'use strict';
  var cfg = window.UTM_BUILDER;
  var MACROS = window.UTM_MACROS || {};
  var GA4 = window.UTMGA4;
  var root = document.getElementById('utm-app');
  if (!cfg || !root || !GA4) return;

  /* ---------- storage (per-viewer conveniences only) ---------- */
  var store = {
    get: function (k, d) { try { var v = localStorage.getItem(k); return v ? JSON.parse(v) : d; } catch (e) { return d; } },
    set: function (k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) { /* storage unavailable */ } }
  };
  var settings = Object.assign({ lower: true, space: '-', strip: true, joiner: '_' }, store.get('utmb:settings', {}));
  var state = { manual: { campaign: cfg.kind === 'basic', content: cfg.kind === 'basic' }, preset: null, lastUrl: '' };

  var PARAMS = [
    ['source', 'utm_source'], ['medium', 'utm_medium'], ['campaign', 'utm_campaign'], ['id', 'utm_id'],
    ['term', 'utm_term'], ['content', 'utm_content'], ['platform', 'utm_source_platform'],
    ['format', 'utm_creative_format'], ['tactic', 'utm_marketing_tactic']
  ];
  var CLICK_IDS = ['gclid', 'gbraid', 'wbraid', 'dclid', 'fbclid', 'msclkid', 'ttclid', 'li_fat_id', 'twclid', 'sccid', 'epik'];
  var MACRO_RE = /(\{\{[^{}]+\}\}|\{[^{}]+\}|__[A-Z0-9_]+__)/g;

  /* ---------- helpers ---------- */
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function $(sel, el) { return (el || root).querySelector(sel); }
  function $all(sel, el) { return Array.prototype.slice.call((el || root).querySelectorAll(sel)); }
  function opt(o) { return Array.isArray(o) ? { v: o[0], l: o[1] } : { v: o, l: o }; }
  function pad(n) { return n < 10 ? '0' + n : '' + n; }

  function norm(v) {
    v = String(v == null ? '' : v).trim();
    if (!v) return '';
    return v.split(MACRO_RE).map(function (seg, i) {
      if (i % 2 === 1) return seg; // platform macro, leave untouched
      if (settings.lower) seg = seg.toLowerCase();
      if (settings.space !== 'keep') seg = seg.replace(/\s+/g, settings.space);
      if (settings.strip) {
        seg = seg.replace(settings.space === 'keep' ? /[^\p{L}\p{N}\-_.~ ]/gu : /[^\p{L}\p{N}\-_.~]/gu, '');
        seg = seg.replace(/-{2,}/g, '-').replace(/_{2,}/g, '_');
      }
      return seg;
    }).join('').replace(/^[-_]+|[-_]+$/g, '');
  }

  function dateOptions() {
    var d = new Date(), y = d.getFullYear(), m = d.getMonth() + 1;
    var nm = m === 12 ? 1 : m + 1, ny = m === 12 ? y + 1 : y;
    var q = Math.floor((m - 1) / 3) + 1;
    return [
      ['' + y + pad(m), y + pad(m) + ' (this month)'],
      ['' + ny + pad(nm), ny + pad(nm) + ' (next month)'],
      [y + 'q' + q, y + 'q' + q + ' (this quarter)'],
      ['' + y, y + ' (this year)']
    ];
  }

  /* ---------- rendering ---------- */
  function paramKey(name) {
    var p = PARAMS.filter(function (x) { return x[0] === name; })[0];
    return '<span class="pkey p-' + name + '">' + p[1] + '</span>';
  }

  function textField(name, label, o) {
    o = o || {};
    return '<div class="field" data-field="' + name + '">' +
      '<label for="f-' + name + '">' + paramKey(name) + '<span class="flabel">' + esc(label) + '</span>' + (o.req ? '<span class="req">required</span>' : '') + '</label>' +
      '<input id="f-' + name + '" name="' + name + '" type="text" autocomplete="off" spellcheck="false" placeholder="' + esc(o.ph || '') + '"' + (o.list ? ' list="' + o.list + '"' : '') + '>' +
      (o.help ? '<p class="help" id="h-' + name + '">' + esc(o.help) + '</p>' : '') +
      (o.extra || '') + '</div>';
  }

  function partControl(group, p) {
    var id = 'pt-' + group + '-' + p.key;
    var html = '<div class="part"><label for="' + id + '">' + esc(p.label) + (p.optional ? ' <span class="opt">optional</span>' : '') + '</label>';
    if (p.type === 'text') {
      html += '<input id="' + id + '" type="text" data-part="' + group + '" data-key="' + p.key + '" placeholder="' + esc(p.placeholder || '') + '" autocomplete="off" spellcheck="false">';
    } else {
      var opts = p.type === 'date' ? dateOptions() : p.options;
      html += '<select id="' + id + '" data-part="' + group + '" data-key="' + p.key + '">';
      if (p.optional || p.type === 'date') html += '<option value="">' + (p.type === 'date' ? 'No date' : 'None') + '</option>';
      opts.forEach(function (o, i) {
        o = opt(o);
        var sel = (!p.optional && i === 0) ? ' selected' : '';
        html += '<option value="' + esc(o.v) + '"' + sel + '>' + esc(o.l) + '</option>';
      });
      html += '<option value="__other">Other…</option></select>' +
        '<input type="text" class="other" data-other="' + group + ':' + p.key + '" placeholder="Type a value" aria-label="' + esc(p.label) + ' (other)" hidden>';
    }
    if (p.help) html += '<p class="help">' + esc(p.help) + '</p>';
    return html + '</div>';
  }

  function conventionText(parts) {
    return parts.map(function (p) { return '{' + p.key + '}'; }).join(settings.joiner);
  }

  function render() {
    var industry = cfg.kind === 'industry';
    var h = '<form class="builder" novalidate onsubmit="return false">';

    // 1. Page
    h += '<section class="step" aria-labelledby="s-url"><h2 id="s-url" class="step-title">Landing page</h2>' +
      '<div class="field field-url"><label for="f-url"><span class="flabel">Website URL</span><span class="req">required</span></label>' +
      '<input id="f-url" type="url" inputmode="url" autocomplete="url" spellcheck="false" placeholder="https://example.com/landing-page">' +
      '<p class="help">Paste a link that already has UTM tags to load and edit them.</p>' +
      '<div class="import" id="import" hidden>This link already has UTM tags. <button type="button" class="linkbtn" id="a-import">Load them into the form</button></div></div></section>';

    // 2. Channel
    h += '<section class="step" aria-labelledby="s-ch"><h2 id="s-ch" class="step-title">Channel</h2>';
    if (industry) {
      h += '<div class="field"><label for="f-preset"><span class="flabel">Where will this link be used?</span></label><select id="f-preset"><option value="">Custom source and medium</option>';
      var groups = {};
      cfg.channels.forEach(function (c, i) { (groups[c.group] = groups[c.group] || []).push([c, i]); });
      Object.keys(groups).forEach(function (g) {
        h += '<optgroup label="' + esc(g) + '">';
        groups[g].forEach(function (pair) { h += '<option value="' + pair[1] + '">' + esc(pair[0].label) + '</option>'; });
        h += '</optgroup>';
      });
      h += '</select></div>';
    } else {
      h += '<div class="chips" role="group" aria-label="Channel shortcuts">';
      cfg.quick.forEach(function (c, i) { h += '<button type="button" class="chip" data-quick="' + i + '">' + esc(c.label) + '</button>'; });
      h += '</div>';
    }
    h += '<div class="note" id="ch-note" hidden></div>';
    h += '<div class="grid2">' +
      textField('source', 'Source', { req: true, ph: 'google, facebook, newsletter', help: 'The site or sender, e.g. google, facebook, newsletter.' }) +
      textField('medium', 'Medium', { req: true, ph: 'cpc, paid_social, email', help: 'The type of traffic, e.g. cpc, paid_social, email, social.', list: 'mediums' }) +
      '</div><datalist id="mediums">' + ['cpc', 'paid_social', 'display', 'cpv', 'cpm', 'email', 'social', 'organic', 'referral', 'affiliate', 'sms', 'push', 'audio', 'video', 'qr'].map(function (m) { return '<option value="' + m + '">'; }).join('') + '</datalist></section>';

    // 3. Campaign
    h += '<section class="step" aria-labelledby="s-camp"><h2 id="s-camp" class="step-title">Campaign</h2>';
    if (industry) {
      h += '<p class="convention">Naming convention <code id="conv-campaign">' + esc(conventionText(cfg.campaign)) + '</code></p>';
      h += '<div class="parts">' + cfg.campaign.map(function (p) { return partControl('campaign', p); }).join('') + '</div>';
      h += textField('campaign', 'Campaign name', { req: true, help: 'Builds from the parts above. Edit it directly if you need to.', extra: '<button type="button" class="linkbtn" data-reset="campaign" hidden>Rebuild from the naming convention</button>' });
    } else {
      h += textField('campaign', 'Campaign', { req: true, ph: 'e.g. spring-sale_202610', help: 'The name of the promotion or campaign.' });
    }
    h += '</section>';

    // 4. Content + term
    h += '<section class="step" aria-labelledby="s-ad"><h2 id="s-ad" class="step-title">Ad and keyword <span class="opt">optional</span></h2>';
    if (industry) {
      h += '<div class="parts">' + cfg.content.map(function (p) { return partControl('content', p); }).join('') + '</div>';
      h += textField('content', 'Content', { help: 'Tells apart ads or links that point to the same page.', extra: '<button type="button" class="linkbtn" data-reset="content" hidden>Rebuild from the parts above</button>' });
      h += textField('term', cfg.term.label, { ph: cfg.term.placeholder, help: cfg.term.help });
    } else {
      h += '<div class="grid2">' + textField('content', 'Content', { ph: 'e.g. hero-banner', help: 'Ad, CTA or link variation.' }) +
        textField('term', 'Term', { ph: 'e.g. running shoes', help: 'Paid search keyword or audience.' }) + '</div>';
    }
    h += '</section>';

    // 5. Extra GA4 fields + formatting
    h += '<details class="more"><summary>Extra GA4 fields</summary><div class="grid2">' +
      textField('id', 'Campaign ID', { ph: 'e.g. 1234567 or {campaignid}', help: 'Joins imported cost data in GA4.' }) +
      textField('platform', 'Source platform', { ph: 'e.g. google ads, dv360, manual', help: 'The platform the campaign was bought on.' }) +
      textField('format', 'Creative format', { ph: 'e.g. video, carousel', help: 'The type of creative.' }) +
      textField('tactic', 'Marketing tactic', { ph: 'e.g. prospecting, remarketing', help: 'The targeting approach.' }) +
      '</div></details>';

    h += '<details class="more" id="fmt"><summary>Formatting rules</summary><div class="fmt">' +
      '<label class="check"><input type="checkbox" id="s-lower"> Make everything lowercase</label>' +
      '<label class="check"><input type="checkbox" id="s-strip"> Remove special characters</label>' +
      '<label class="inline" for="s-space">Replace spaces with <select id="s-space"><option value="-">hyphens (-)</option><option value="_">underscores (_)</option><option value="keep">keep spaces (%20)</option></select></label>' +
      (industry ? '<label class="inline" for="s-joiner">Join name parts with <select id="s-joiner"><option value="_">underscores (_)</option><option value="-">hyphens (-)</option></select></label>' : '') +
      '<p class="help">Saved in this browser for every builder.</p></div></details>';

    h += '</form>';

    // Output panel
    h += '<aside class="out" aria-label="Your UTM link"><div class="out-inner">' +
      '<h2 class="out-title">Your link</h2>' +
      '<div class="url" id="o-url" aria-live="polite"><span class="ph">Your link appears here as you type.</span></div>' +
      '<div class="actions">' +
      '<button type="button" class="btn primary" id="a-copy" disabled>Copy link</button>' +
      '<button type="button" class="btn" id="a-tags" disabled title="For Google Ads final URL suffix or Meta URL parameters">Copy tags only</button>' +
      '<button type="button" class="btn" id="a-open" disabled>Test link</button>' +
      '<button type="button" class="btn" id="a-qr" disabled aria-expanded="false">QR code</button>' +
      '<button type="button" class="btn" id="a-row" disabled title="Tab-separated, ready to paste into Sheets or Excel">Copy as sheet row</button>' +
      '</div>' +
      '<div class="qr" id="o-qr" hidden><canvas id="qr-canvas" width="240" height="240" aria-label="QR code for your link"></canvas>' +
      '<div><p class="help">Scan it to test before printing. Long links make denser codes; shorten them first for small print.</p>' +
      '<button type="button" class="btn" id="a-qrdl">Download PNG</button></div></div>' +
      '<div class="ga4" id="o-ga4"><p class="ga4-label">GA4 default channel</p><p class="ga4-ch" id="o-ch">—</p><p class="ga4-why" id="o-why">Add a source and medium to see where GA4 will report this link.</p></div>' +
      '<div class="checks"><h3>Checks</h3><ul id="o-checks"><li class="ok">Nothing to check yet.</li></ul></div>' +
      (cfg.privacy ? '<p class="privacy">' + esc(cfg.privacy) + '</p>' : '') +
      '<details class="history" id="hist"><summary>Recent links <span id="h-count"></span></summary><div id="h-list"></div>' +
      '<div class="hist-actions"><button type="button" class="linkbtn" id="h-export">Export CSV</button><button type="button" class="linkbtn" id="h-clear">Clear</button></div>' +
      '<p class="help">Stored only in this browser.</p></details>' +
      '</div></aside>' +
      '<div class="dock" id="dock" hidden><span class="dock-url" id="dock-url"></span><button type="button" class="btn primary" id="d-copy">Copy link</button></div>' +
      '<div class="sr" aria-live="polite" id="live"></div>';

    root.innerHTML = h;
  }

  /* ---------- reading the form ---------- */
  function field(name) { var el = $('#f-' + name); return el ? el.value : ''; }
  function setField(name, v) { var el = $('#f-' + name); if (el) el.value = v; }

  function partValue(el) {
    if (el.tagName === 'SELECT') {
      if (el.value === '__other') { var o = $('[data-other="' + el.dataset.part + ':' + el.dataset.key + '"]'); return o ? o.value : ''; }
      return el.value;
    }
    return el.value;
  }

  function compose(group) {
    var vals = $all('[data-part="' + group + '"]').map(function (el) { return norm(partValue(el)); }).filter(Boolean);
    if (group === 'campaign' && state.preset && state.preset.prefix && vals.indexOf(state.preset.prefix) === -1) vals.unshift(state.preset.prefix);
    return vals.join(settings.joiner);
  }

  function values() {
    var v = {};
    PARAMS.forEach(function (p) { v[p[0]] = norm(field(p[0])); });
    return v;
  }

  /* ---------- URL building ---------- */
  function enc(v) { return encodeURIComponent(v).replace(/%7B/gi, '{').replace(/%7D/gi, '}'); }

  function parseBase(raw) {
    raw = String(raw || '').trim();
    if (!raw) return { empty: true };
    if (!/^[a-z][a-z0-9+.-]*:\/\//i.test(raw)) raw = 'https://' + raw.replace(/^\/+/, '');
    var u;
    try { u = new URL(raw); } catch (e) { return { error: 'That doesn’t look like a web address. Use the full link, like https://example.com/page.' }; }
    if (u.protocol !== 'http:' && u.protocol !== 'https:') return { error: 'Use a link that starts with https:// or http://.' };
    if (u.hostname.indexOf('.') === -1 && u.hostname !== 'localhost') return { error: 'Add the full domain, like example.com.' };
    var pairs = u.search ? u.search.slice(1).split('&').filter(Boolean) : [];
    var keep = [], utm = {}, clicks = [];
    pairs.forEach(function (p) {
      var k = p.split('=')[0], kl = k.toLowerCase();
      if (/^utm_/.test(kl)) { try { utm[kl] = decodeURIComponent((p.split('=')[1] || '').replace(/\+/g, ' ')); } catch (e) { utm[kl] = p.split('=')[1] || ''; } }
      else { if (CLICK_IDS.indexOf(kl) !== -1) clicks.push(k); keep.push(p); }
    });
    return { base: u.origin + u.pathname, keep: keep, hash: u.hash, utm: utm, clicks: clicks, host: u.hostname };
  }

  function build(parsed, v) {
    var ours = [];
    PARAMS.forEach(function (p) { if (v[p[0]]) ours.push(p[1] + '=' + enc(v[p[0]])); });
    var q = parsed.keep.concat(ours);
    return { url: parsed.base + (q.length ? '?' + q.join('&') : '') + parsed.hash, tags: ours.join('&') };
  }

  /* ---------- checks ---------- */
  function checks(parsed, v, ga) {
    var out = [];
    var add = function (level, text) { out.push({ level: level, text: text }); };
    if (parsed.error) add('error', parsed.error);
    if (parsed.empty) add('error', 'Add the website URL people should land on.');
    if (!v.source) add('error', 'Add a source (utm_source).');
    if (!v.medium) add('error', 'Add a medium (utm_medium).');
    if (!v.campaign) add('error', 'Add a campaign name (utm_campaign), or GA4 shows the campaign as (not set).');
    if (parsed.utm && Object.keys(parsed.utm).length) add('info', 'The UTM tags already on your link are replaced by the ones you build here.');
    if (parsed.clicks && parsed.clicks.length) add('warn', 'Your link contains ' + parsed.clicks.join(', ') + '. Click IDs belong to one click; remove them before reusing the link.');

    var all = PARAMS.map(function (p) { return p[0] === 'id' ? '' : v[p[0]]; }).join(' ');
    var plain = all.replace(MACRO_RE, '');
    if (/[^\s@]+@[^\s@]+\.[a-z]{2,}/i.test(plain) || /(\+|00)\d[\d\-]{7,}/.test(plain) || /(^|[^\d])0\d{8,}/.test(plain)) {
      add('error', 'This looks like an email address or phone number. Remove it: GA4’s terms don’t allow personal data in URLs.');
    }
    if (/[^\x00-\x7F]/.test(plain)) add('warn', 'Non-Latin characters (such as Arabic) are percent-encoded and can show up garbled in reports. Use a transliterated value, e.g. eid instead of عيد.');
    if (!settings.lower && /[A-Z]/.test(plain)) add('warn', 'Uppercase letters split one campaign into several rows in GA4 (Facebook and facebook are different sources).');
    if (settings.space === 'keep' && / /.test(plain)) add('info', 'Spaces are kept and sent as %20. Hyphens are easier to read in reports.');
    if (v.source === 'meta') add('warn', 'GA4 doesn’t recognise “meta” as a social site, so paid traffic lands in Paid Other. Use facebook or instagram.');
    if (v.source === 'x') add('warn', 'Use “twitter” as the source. It’s the value GA4’s social list is built on.');
    if (v.source && v.medium && v.source === v.medium && v.source !== 'sms') add('info', 'Source and medium are the same. Usually the source is the site or sender and the medium is the type of traffic.');
    if (ga && ga.channel === 'Unassigned') add('warn', 'GA4 will put this in Unassigned. Use a standard medium (cpc, paid_social, email, social, referral, affiliate, display) or add a custom channel group rule for it.');
    if (v.term && v.medium && !/cp|ppc|paid|display/.test(v.medium) && cfg.kind === 'basic') add('info', 'utm_term is mainly for paid search keywords; for other channels utm_content is usually clearer.');
    if (state.lastUrl.length > 2000) add('warn', 'This link is over 2,000 characters, which some browsers and platforms cut off.');
    if (new RegExp(MACRO_RE.source).test(all)) add('info', 'Platform placeholders like {keyword} or {{ad.name}} are filled in by the ad platform. Paste this link into the ad, not straight into a browser.');
    return out;
  }

  /* ---------- output ---------- */
  function renderUrl(parsed, v) {
    var box = $('#o-url');
    if (parsed.empty || parsed.error) { box.innerHTML = '<span class="ph">' + (parsed.error ? esc(parsed.error) : 'Your link appears here as you type.') + '</span>'; return; }
    var parts = [];
    parsed.keep.forEach(function (p) { parts.push('<span class="seg p-other">' + esc(p) + '</span>'); });
    PARAMS.forEach(function (p) {
      if (!v[p[0]]) return;
      parts.push('<span class="seg p-' + p[0] + '"><span class="k">' + p[1] + '=</span><span class="v">' + esc(enc(v[p[0]])) + '</span></span>');
    });
    box.innerHTML = '<span class="base">' + esc(parsed.base) + '</span>' + (parts.length ? '<span class="sep">?</span>' + parts.join('<span class="sep">&amp;</span>') : '') + (parsed.hash ? '<span class="base">' + esc(parsed.hash) + '</span>' : '');
  }

  var current = null;
  function update() {
    if (cfg.kind === 'industry') {
      if (!state.manual.campaign) setField('campaign', compose('campaign'));
      if (!state.manual.content) setField('content', compose('content'));
      $all('[data-reset]').forEach(function (b) { b.hidden = !state.manual[b.dataset.reset]; });
    }
    var parsed = parseBase(field('url'));
    var v = values();
    var ga = (v.source || v.medium) ? GA4.classify(v.source, v.medium, v.campaign) : null;
    var built = (!parsed.empty && !parsed.error) ? build(parsed, v) : null;
    state.lastUrl = built ? built.url : '';
    current = built ? { url: built.url, tags: built.tags, v: v, base: parsed.base, channel: ga ? ga.channel : '' } : null;

    renderUrl(parsed, v);
    var ready = !!built && !!(v.source && v.medium && v.campaign);
    ['#a-copy', '#a-tags', '#a-open', '#a-qr', '#a-row'].forEach(function (s) { $(s).disabled = !built || (s === '#a-tags' && !built.tags); });
    $('#a-copy').classList.toggle('incomplete', !!built && !ready);

    $('#o-ch').textContent = ga ? ga.channel : '—';
    $('#o-why').textContent = ga ? ga.reason : 'Add a source and medium to see where GA4 will report this link.';
    $('#o-ga4').dataset.state = !ga ? '' : (ga.channel === 'Unassigned' ? 'bad' : (/^Paid Other$|^Direct$/.test(ga.channel) ? 'meh' : 'good'));

    var list = checks(parsed, v, ga);
    var started = !parsed.empty || v.source || v.medium || v.campaign;
    $('#o-checks').innerHTML = !started ? '<li class="ok">Nothing to check yet.</li>' :
      (list.length ? list.map(function (c) { return '<li class="' + c.level + '">' + esc(c.text) + '</li>'; }).join('') : '<li class="ok">Looks clean. Ready to use.</li>');

    // Import notice for links that already carry UTMs
    $('#import').hidden = !(parsed.utm && Object.keys(parsed.utm).length);

    // Dock + QR
    var dock = $('#dock');
    dock.hidden = !built;
    document.body.classList.toggle('has-dock', !!built);
    if (built) $('#dock-url').textContent = built.url;
    if (!$('#o-qr').hidden) drawQR();
  }

  /* ---------- actions ---------- */
  function announce(t) { var l = $('#live'); l.textContent = ''; setTimeout(function () { l.textContent = t; }, 30); }
  function copyText(text, btn, label) {
    var done = function () {
      if (btn) { var old = btn.dataset.label || btn.textContent; btn.dataset.label = old; btn.textContent = 'Copied'; btn.classList.add('done'); setTimeout(function () { btn.textContent = old; btn.classList.remove('done'); }, 1600); }
      announce(label || 'Copied to clipboard');
    };
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).then(done, function () { fallback(); });
    } else fallback();
    function fallback() {
      var ta = document.createElement('textarea'); ta.value = text; ta.setAttribute('readonly', ''); ta.style.position = 'fixed'; ta.style.opacity = '0';
      document.body.appendChild(ta); ta.select();
      try { document.execCommand('copy'); done(); } catch (e) { announce('Copy failed. Select the link and copy it manually.'); }
      document.body.removeChild(ta);
    }
  }

  function remember() {
    if (!current) return;
    var h = store.get('utmb:history', []).filter(function (x) { return x.url !== current.url; });
    h.unshift({ t: new Date().toISOString(), b: cfg.nav, url: current.url, page: current.base, source: current.v.source, medium: current.v.medium, campaign: current.v.campaign, content: current.v.content, term: current.v.term, channel: current.channel });
    store.set('utmb:history', h.slice(0, 50));
    renderHistory();
  }

  function renderHistory() {
    var h = store.get('utmb:history', []);
    $('#h-count').textContent = h.length ? '(' + h.length + ')' : '';
    $('#h-list').innerHTML = h.length ? '<ul>' + h.slice(0, 12).map(function (x, i) {
      return '<li><div><span class="h-camp">' + esc(x.campaign || '(no campaign)') + '</span><span class="h-meta">' + esc(x.source + ' / ' + x.medium) + ' • ' + esc(x.b) + '</span></div><button type="button" class="linkbtn" data-hcopy="' + i + '">Copy</button></li>';
    }).join('') + '</ul>' : '<p class="help">Links you copy, test or turn into QR codes show up here.</p>';
  }

  function csvCell(s) { s = String(s == null ? '' : s); return /[",\n]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s; }
  function exportCSV() {
    var h = store.get('utmb:history', []);
    if (!h.length) { announce('No links to export yet'); return; }
    var rows = [['date', 'builder', 'landing_page', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'ga4_channel', 'url']]
      .concat(h.map(function (x) { return [x.t.slice(0, 10), x.b, x.page, x.source, x.medium, x.campaign, x.content, x.term, x.channel, x.url]; }));
    var blob = new Blob([rows.map(function (r) { return r.map(csvCell).join(','); }).join('\n')], { type: 'text/csv' });
    var a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'utm-links.csv';
    document.body.appendChild(a); a.click(); setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
  }

  function drawQR(size) {
    if (!current || typeof qrcode !== 'function') return null;
    var qr = qrcode(0, 'M'); qr.addData(current.url); qr.make();
    var n = qr.getModuleCount(), margin = 4;
    var canvas = size ? document.createElement('canvas') : $('#qr-canvas');
    var px = size || 240;
    canvas.width = px; canvas.height = px;
    var ctx = canvas.getContext('2d'), cell = px / (n + margin * 2);
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, px, px); ctx.fillStyle = '#000000';
    for (var r = 0; r < n; r++) for (var c = 0; c < n; c++) if (qr.isDark(r, c)) ctx.fillRect(Math.floor((c + margin) * cell), Math.floor((r + margin) * cell), Math.ceil(cell), Math.ceil(cell));
    return canvas;
  }

  function applyPreset(p) {
    state.preset = p || null;
    if (p) { setField('source', p.source); setField('medium', p.medium); }
    var note = $('#ch-note');
    var m = p && p.macros && MACROS[p.macros];
    if (p && (p.note || m)) {
      note.hidden = false;
      note.innerHTML = (p.note ? '<p>' + esc(p.note) + '</p>' : '') + (m ? '<button type="button" class="linkbtn" id="a-macros">Fill in ' + esc(m.label) + '</button>' : '');
    } else { note.hidden = true; note.innerHTML = ''; }
  }

  function applyMacros() {
    var m = state.preset && MACROS[state.preset.macros];
    if (!m) return;
    Object.keys(m.fields).forEach(function (k) {
      setField(k, m.fields[k]);
      if (k === 'campaign' || k === 'content') state.manual[k] = true;
    });
    if (m.fields.id) { var d = $('details.more'); if (d) d.open = true; }
    update();
    announce(m.label + ' added');
  }

  function importTags() {
    var parsed = parseBase(field('url'));
    if (!parsed.utm) return;
    var map = { utm_source: 'source', utm_medium: 'medium', utm_campaign: 'campaign', utm_content: 'content', utm_term: 'term', utm_id: 'id', utm_source_platform: 'platform', utm_creative_format: 'format', utm_marketing_tactic: 'tactic' };
    Object.keys(parsed.utm).forEach(function (k) { if (map[k]) setField(map[k], parsed.utm[k]); });
    state.manual.campaign = true; state.manual.content = true;
    if (cfg.kind === 'industry') { $('#f-preset').value = ''; applyPreset(null); }
    setField('url', parsed.base + (parsed.keep.length ? '?' + parsed.keep.join('&') : '') + parsed.hash);
    update();
    announce('UTM tags loaded into the form');
  }

  function syncSettingsUI() {
    $('#s-lower').checked = settings.lower; $('#s-strip').checked = settings.strip; $('#s-space').value = settings.space;
    if ($('#s-joiner')) $('#s-joiner').value = settings.joiner;
    var conv = $('#conv-campaign'); if (conv) conv.textContent = conventionText(cfg.campaign);
  }

  /* ---------- events ---------- */
  function bind() {
    root.addEventListener('input', function (e) {
      var t = e.target;
      if (t.id === 'f-campaign' && cfg.kind === 'industry') state.manual.campaign = true;
      if (t.id === 'f-content' && cfg.kind === 'industry') state.manual.content = true;
      if ((t.id === 'f-source' || t.id === 'f-medium') && cfg.kind === 'industry' && state.preset) {
        if (field('source').trim().toLowerCase() !== state.preset.source || field('medium').trim().toLowerCase() !== state.preset.medium) { $('#f-preset').value = ''; applyPreset(null); }
      }
      update();
    });
    root.addEventListener('change', function (e) {
      var t = e.target;
      if (t.id === 'f-preset') { applyPreset(t.value === '' ? null : cfg.channels[+t.value]); }
      if (t.matches('select[data-part]')) {
        var o = $('[data-other="' + t.dataset.part + ':' + t.dataset.key + '"]');
        if (o) { o.hidden = t.value !== '__other'; if (!o.hidden) o.focus(); }
      }
      if (t.id && t.id.indexOf('s-') === 0) {
        settings.lower = $('#s-lower').checked; settings.strip = $('#s-strip').checked; settings.space = $('#s-space').value;
        if ($('#s-joiner')) settings.joiner = $('#s-joiner').value;
        store.set('utmb:settings', settings); syncSettingsUI();
      }
      update();
    });
    root.addEventListener('click', function (e) {
      var t = e.target.closest('button'); if (!t) return;
      if (t.dataset.quick != null) {
        var p = cfg.quick[+t.dataset.quick];
        $all('.chip').forEach(function (c) { c.setAttribute('aria-pressed', c === t ? 'true' : 'false'); });
        applyPreset(p); update(); return;
      }
      if (t.dataset.reset) { state.manual[t.dataset.reset] = false; update(); return; }
      if (t.dataset.hcopy != null) { var h = store.get('utmb:history', [])[+t.dataset.hcopy]; if (h) copyText(h.url, t, 'Link copied'); return; }
      switch (t.id) {
        case 'a-macros': applyMacros(); break;
        case 'a-import': importTags(); break;
        case 'a-copy': case 'd-copy': if (current) { copyText(current.url, t, 'Link copied'); remember(); } break;
        case 'a-tags': if (current) { copyText(current.tags, t, 'Tags copied'); remember(); } break;
        case 'a-open': if (current) { window.open(current.url, '_blank', 'noopener'); remember(); } break;
        case 'a-row':
          if (current) {
            var v = current.v;
            copyText([new Date().toISOString().slice(0, 10), current.base, v.source, v.medium, v.campaign, v.content, v.term, current.channel, current.url].join('\t'), t, 'Row copied. Paste it into your sheet');
            remember();
          }
          break;
        case 'a-qr':
          var box = $('#o-qr'); box.hidden = !box.hidden; t.setAttribute('aria-expanded', String(!box.hidden));
          if (!box.hidden) drawQR();
          break;
        case 'a-qrdl':
          var c = drawQR(1024);
          if (c) { var a = document.createElement('a'); a.href = c.toDataURL('image/png'); a.download = 'qr-' + (current.v.campaign || 'utm-link').slice(0, 60) + '.png'; document.body.appendChild(a); a.click(); a.remove(); remember(); }
          break;
        case 'h-export': exportCSV(); break;
        case 'h-clear': store.set('utmb:history', []); renderHistory(); announce('Recent links cleared'); break;
      }
    });
  }

  render();
  syncSettingsUI();
  renderHistory();
  bind();
  update();
})();
