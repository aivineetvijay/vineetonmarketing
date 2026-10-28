// Builds pages.json, the page copy for the UTM builder pages on vineetonmarketing.com.
// Usage: node build.mjs
//
// One entry per builder in src/configs.js: SEO title and description, hero fields, intro, FAQs and the
// sections below the tool, in the site's section pattern (the basics, why it matters, how it works and the
// naming convention, channel cheat sheet, tips, developer brief, questions, more builders). The vv-utm
// mu-plugin prints this HTML on the page, so search engines see it without running JavaScript. {{YYYYMM}}
// becomes the current month and {{UPDATED}} the page's modified date when the page is served.
import { createRequire } from 'node:module';
import { writeFileSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const require = createRequire(import.meta.url);
const here = dirname(fileURLToPath(import.meta.url));
const { builders } = require('./src/configs.js');
const GA4 = require('./src/ga4.js');

const BASE = '/ai-tools/utm-builder/';
const YM = '{{YYYYMM}}';

// Hero meta strip: who each builder is for.
const AUDIENCE = {
  basic: 'Marketers and agencies',
  healthcare: 'Hospitals and clinics',
  ecommerce: 'Online stores and D2C brands',
  'real-estate': 'Developers and brokers',
  'travel-tourism': 'Hotels and tour operators',
  b2b: 'B2B and SaaS teams',
};

const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
const href = (b) => BASE + (b.slug ? b.slug + '/' : '');

// Industry builders show only the required campaign parts and the first content part (same as page.js).
function simplify(b) {
  if (b.kind !== 'industry') return b;
  const s = { ...b };
  s.campaign = b.campaign.filter((p) => !p.optional);
  s.content = b.content.filter((p) => !p.optional).slice(0, 1);
  const l = s.campaign.filter((p) => p.type !== 'date').map((p) => p.label.toLowerCase());
  s.intro = 'Pick a channel, choose the ' + (l.length > 1 ? l.slice(0, -1).join(', ') + ' and ' + l[l.length - 1] : l[0]) + ', and the campaign name follows one convention every time.';
  return s;
}

function sample(b) {
  return b.campaign.map((p) => {
    if (p.type === 'date') return YM;
    if (p.type === 'text') return (p.placeholder || p.key).replace(/^e\.g\.\s*/, '').split(' or ')[0];
    const o = p.options[p.optional ? 1 % p.options.length : 0];
    return Array.isArray(o) ? o[0] : o;
  }).join('_');
}

const P5 = [
  ['utm_source', 'Where did the click come from?', 'google, facebook, newsletter'],
  ['utm_medium', 'What type of traffic is it?', 'cpc, paid_social, email'],
  ['utm_campaign', 'Which campaign was it?', 'spring-sale_' + YM],
  ['utm_content', 'Which ad or link was clicked?', 'hero-banner, video-a'],
  ['utm_term', 'Which keyword or audience?', 'running shoes'],
];
const DEVF = [
  ['first_utm_source … first_utm_term', 'First tagged visit. Set once, never overwritten.'],
  ['last_utm_source … last_utm_term', 'Most recent tagged visit before the form was sent.'],
  ['gclid, fbclid, msclkid', 'Ad click IDs, for offline conversion uploads.'],
  ['landing_page', 'Full URL of the first page seen.'],
  ['referrer', 'The site the visitor came from.'],
  ['first_touch_at, last_touch_at', 'Timestamps of both visits.'],
];
const DEVSTEPS = [
  'Read the UTM tags and ad click IDs from the URL on every page load.',
  'Save them in a first-party cookie for 90 days. Keep a first-touch copy that is never overwritten, and a last-touch copy that updates on each new tagged visit.',
  'Ignore visits without UTM tags, so an untagged return visit never wipes the saved values.',
  'Add hidden fields for every value to every form: contact, booking, sign-up and checkout.',
  'Fill the hidden fields from the cookie when the form is sent.',
  'Store each value in its own column on the lead or order record, and map the same fields into the CRM.',
  'Test it: open a tagged link, send a form, and check the record shows the right values.',
];
const SNIP = "const KEYS=['utm_source','utm_medium','utm_campaign','utm_content','utm_term','gclid','fbclid','msclkid'];\nconst q=new URLSearchParams(location.search);\nconst hit={};KEYS.forEach(k=>{if(q.get(k))hit[k]=q.get(k);});\nif(Object.keys(hit).length){\n  hit.landing_page=location.href;hit.referrer=document.referrer;hit.at=new Date().toISOString();\n  const save=(n,v)=>document.cookie=n+'='+encodeURIComponent(JSON.stringify(v))+';path=/;max-age=7776000;SameSite=Lax';\n  if(!document.cookie.includes('utm_first='))save('utm_first',hit);\n  save('utm_last',hit);\n}";

const brief = () => 'Request: store UTM data with every lead and order\n\nWhy: GA4 shows visits. Our database shows leads and sales. Saving the UTM tags with each record tells us which campaign produced each lead and how much revenue it brought in.\n\nSteps:\n' +
  DEVSTEPS.map((s, i) => (i + 1) + '. ' + s).join('\n') + '\n\nFields to add:\n' + DEVF.map((f) => '- ' + f[0] + ': ' + f[1]).join('\n') + '\n\nStarting point:\n' + SNIP;

// ---- Page sections below the builder, in the site's section pattern ----
// Each section: a numbered label row, a two-line display title (second line light italic), then the content.
// Backgrounds alternate the way the rest of the site does: canvas, ink, parchment.
const WHY = [
  ['Credit goes to the right campaign.', 'Without tags, a click from an email or WhatsApp message often shows up as Direct, and the campaign that earned it gets no credit.'],
  ['Channels are compared fairly.', 'One naming convention across every channel means paid, owned and partner traffic line up in the same report.'],
  ['Leads and revenue connect to marketing.', 'Stored with each lead, UTM tags show which campaign produced customers, not just clicks.'],
  ['Budget follows results.', 'Clean data shows which ads and messages to scale and which to stop.'],
];

const pad2 = (n) => (n < 10 ? '0' : '') + n;
// "First sentence. The rest." → [title, body]. A single sentence becomes the title alone.
const split = (s) => { const m = String(s).match(/^(.+?[.?!])\s+(.+)$/); return m ? [m[1], m[2]] : [s, '']; };

function section(bg, idx, label, note, main, aside, inner, id) {
  return '<section class="vvu-sec vvu-' + bg + '"' + (id ? ' id="' + id + '"' : '') + '><div class="vvu-wrap">' +
    '<div class="vvu-sec-head"><div class="vvu-sec-l"><span class="vvu-idx">' + idx + '</span><span class="vvu-label">' + esc(label) + '</span></div><p class="vvu-note">' + esc(note) + '</p></div>' +
    '<h2 class="vvu-disp">' + esc(main) + ' <span class="vvu-disp-aside">' + esc(aside) + '</span></h2>' +
    inner + '</div></section>';
}
// Grids whose titles run long (full sentences) use the smaller card title, so no item towers over the others.
const items = (list, label) => '<div class="vvu-grid3' + (list.some((it) => it[0].length > 60) ? ' vvu-grid-sm' : '') + '">' + list.map((it, i) =>
  '<div class="vvu-item"><p class="vvu-mono">' + (label ? label + ' ' : '') + pad2(i + 1) + '</p><h3 class="vvu-card-t">' + esc(it[0]) + '</h3>' + (it[1] ? '<p class="vvu-body">' + esc(it[1]) + '</p>' : '') + '</div>').join('') + '</div>';
const table = (head, rowsHtml) => '<div class="vvu-table"><table><thead><tr>' + head.map((h) => '<th scope="col">' + h + '</th>').join('') + '</tr></thead><tbody>' + rowsHtml + '</tbody></table></div>';

function rows(b) {
  return (b.kind === 'basic' ? b.quick : b.channels).map((c) => {
    const g = GA4.classify(c.source, c.medium, c.prefix || '');
    return '<tr><td>' + esc(c.label) + '</td><td><code>' + esc(c.source) + '</code></td><td><code>' + esc(c.medium) + '</code></td><td class="ga-' + g.channel.replace(/\s/g, '') + '">' + esc(g.channel) + '</td></tr>';
  }).join('');
}

function content(b) {
  const industry = b.kind === 'industry';
  const pattern = industry ? b.campaign.map((p) => '{' + p.key + '}').join('_') : '{offer-or-theme}_{product-or-audience}_{market}_{yyyymm}';
  const example = industry ? sample(b) : 'spring-sale_running-shoes_uae_' + YM;
  const convNote = industry
    ? 'Parts are joined with underscores and words inside a part use hyphens, so you can split the name back into columns in a spreadsheet or Looker Studio. Optional parts are skipped when empty. You can switch the separator under Formatting rules.'
    : 'Pick the parts your reports need, keep them in the same order every time, and write them down where the whole team can see them. Need a ready-made convention? Each industry builder comes with one.';
  const others = builders.filter((x) => x.id !== b.id);

  return [
    section('canvas', '02', 'The basics', 'Five tags, one link', 'What UTM tags', 'actually do.',
      '<div class="vvu-split"><div class="vvu-split-l">' +
        '<p class="vvu-body">UTM tags are short labels added to the end of a link. When someone clicks, your analytics reads the labels and records exactly where the visit came from.</p>' +
        '<p class="vvu-body">No extra code is needed for GA4 to read them. The five standard tags answer five questions about every visit, and GA4 uses the source and medium to decide which channel the visit belongs to.</p>' +
      '</div><div class="vvu-split-r"><p class="vvu-mono">The five tags</p>' +
        table(['Tag', 'Answers', 'Example'], P5.map((r) => '<tr><td><code>' + r[0] + '</code></td><td>' + r[1] + '</td><td><code>' + r[2] + '</code></td></tr>').join('')) +
      '</div></div>'),

    section('ink', '03', 'Why it matters', 'Four reasons to tag every link', 'Why it matters', 'for reporting.', items(WHY)),

    section('parch', '04', 'How it works', 'From link to report', 'Tag the link.', 'Then trust the report.',
      '<p class="vvu-mono vvu-group">Use the builder</p>' + items(b.steps.map(split), 'Step') +
      '<p class="vvu-mono vvu-group">The naming convention</p>' +
      '<div class="vvu-callout"><p><span class="vvu-mono">Pattern</span><code>' + esc(pattern) + '</code></p><p><span class="vvu-mono">Example</span><code>' + esc(example) + '</code></p></div>' +
      '<p class="vvu-body vvu-measure">' + esc(convNote) + '</p>', 'how'),

    section('canvas', '05', 'Cheat sheet', 'Source, medium and GA4 channel', 'Every channel,', 'mapped to GA4.',
      '<p class="vvu-body vvu-measure">The source and medium each preset uses, and the GA4 default channel it reports under. Unassigned means GA4 has no default rule for it; add a custom channel group rule.</p>' +
      table(['Channel', 'utm_source', 'utm_medium', 'GA4 channel'], rows(b))),

    section('ink', '06', 'Tips', industry ? 'For ' + b.nav.toLowerCase().replace(/^b2b$/, 'B2B') + ' marketers' : 'Habits that keep reports clean', 'Tips that keep', 'the data clean.', items(b.tips.map(split))),

    section('parch', '07', 'For your developer', 'Store UTMs with every lead', 'Get UTM data', 'into your CRM.',
      '<p class="vvu-body vvu-measure">GA4 counts visits. Your CRM or database records who became a lead or customer. Unless the UTM tags are saved with each record, the two never meet, and you can\'t tell which campaign produced which sale. Share this brief with your website developer.</p>' +
      '<p class="vvu-mono vvu-group">What to ask for</p>' + items(DEVSTEPS.map(split), 'Step') +
      '<div class="vvu-split vvu-group"><div class="vvu-split-l"><p class="vvu-mono">Fields to add to each lead or order</p>' +
        table(['Field', 'What it holds'], DEVF.map((f) => '<tr><td><code>' + esc(f[0]) + '</code></td><td>' + esc(f[1]) + '</td></tr>').join('')) +
      '</div><div class="vvu-split-r"><p class="vvu-mono">A starting point for the developer</p><pre class="vvu-code"><code>' + esc(SNIP) + '</code></pre>' +
        '<div class="vvu-btns vvu-mt"><button type="button" class="vvu-btn vvu-btn-filled" id="copy-brief">Copy brief for your developer</button></div>' +
        '<pre hidden id="utm-brief">' + esc(brief()) + '</pre>' +
        '<p class="vvu-fine">Never put names, emails or phone numbers in UTM tags. Store them only in your own database, under your privacy policy.</p>' +
      '</div></div>'),

    section('canvas', '08', 'Questions', 'The ones that come up most', 'Common', 'questions.',
      '<div class="vvu-faq">' + b.faqs.map((f, i) => '<details' + (i === 0 ? ' open' : '') + '><summary><span class="vvu-faq-n">' + pad2(i + 1) + '</span><span class="vvu-faq-q">' + esc(f[0]) + '</span></summary><p class="vvu-body">' + esc(f[1]) + '</p></details>').join('') + '</div>'),

    '<section class="vvu-sec vvu-ink vvu-cta"><div class="vvu-wrap">' +
      '<h2 class="vvu-huge">More UTM <span class="vvu-aside">builders.</span></h2>' +
      '<div class="vvu-btns vvu-mt">' + others.map((x, i) => '<a class="vvu-btn vvu-btn-dark' + (i === 0 ? ' vvu-btn-dark-filled' : '') + '" href="' + href(x) + '">' + esc(x.name) + '<span aria-hidden="true"> ↗</span></a>').join('') + '</div>' +
      '<p class="vvu-note vvu-byline">By <a href="/experience/">Vineet Vijay</a> · Updated {{UPDATED}} · Runs in your browser. Nothing is uploaded.</p>' +
    '</div></section>',
  ].join('');
}

const pages = builders.map((raw) => {
  const b = simplify(raw);
  return {
    id: b.id, slug: b.slug, nav: b.nav, name: b.name, kind: b.kind,
    title: b.title.replace(/\s*\|\s*Vineet on Marketing$/, ''),
    description: b.description,
    h1: b.h1.charAt(0).toUpperCase() + b.h1.slice(1) + '.',
    // Site hero headline: "UTM Builder" plus a light italic tail on the industry pages.
    hero: { main: 'UTM Builder', aside: b.kind === 'industry' ? 'for ' + (/^[A-Z0-9]+$/.test(b.nav) ? b.nav : b.nav.toLowerCase()) + '.' : '', audience: AUDIENCE[b.id] },
    intro: b.intro,
    faqs: b.faqs,
    content: content(b),
  };
});

writeFileSync(join(here, 'pages.json'), JSON.stringify({ base: BASE, pages }, null, 1) + '\n');
console.log('pages.json:', pages.map((p) => p.id).join(', '));
