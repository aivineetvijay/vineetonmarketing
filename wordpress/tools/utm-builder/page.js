/*
 * UTM builder page glue for vineetonmarketing.com. Loads after configs.js, ga4.js and qrcode.js, and before
 * engine.js. Picks the builder for this page (window.UTM_PAGE.id, printed by the vv-utm mu-plugin), trims the
 * industry builders to their required parts, and hands it to the engine. Also wires the "Copy brief for your
 * developer" button and centres the current tab on narrow screens.
 */
(function () {
  'use strict';
  var mod = window.UTM_CFG_MODULE;
  var C = mod && mod.exports;
  if (!C || !C.builders) return;
  var id = (window.UTM_PAGE || {}).id || 'basic';
  var b = C.builders.filter(function (x) { return x.id === id; })[0] || C.builders[0];

  // Industry builders show only the required campaign parts and the first content part (same as build.mjs).
  if (b.kind === 'industry') {
    b = Object.assign({}, b);
    b.campaign = b.campaign.filter(function (p) { return !p.optional; });
    b.content = b.content.filter(function (p) { return !p.optional; }).slice(0, 1);
  }
  var rt = Object.assign({}, b);
  ['title', 'description', 'intro', 'steps', 'tips', 'faqs', 'h1'].forEach(function (k) { delete rt[k]; });
  window.UTM_BUILDER = rt;
  window.UTM_MACROS = C.MACROS;
  document.body.classList.toggle('is-industry', b.kind === 'industry');

  function copy(text, done) {
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).then(done, function () { fallback(text); done(); });
    } else { fallback(text); done(); }
  }
  function fallback(text) {
    var t = document.createElement('textarea');
    t.value = text; t.setAttribute('readonly', ''); t.style.position = 'fixed'; t.style.opacity = '0';
    document.body.appendChild(t); t.select();
    try { document.execCommand('copy'); } catch (e) { /* nothing more to try */ }
    document.body.removeChild(t);
  }

  document.addEventListener('click', function (e) {
    var cb = e.target.closest && e.target.closest('#copy-brief');
    var src = document.getElementById('utm-brief');
    if (!cb || !src) return;
    copy(src.textContent, function () {
      var live = document.getElementById('live'); // the engine's screen-reader live region
      if (live) { live.textContent = ''; setTimeout(function () { live.textContent = 'Developer brief copied to clipboard'; }, 30); }
      cb.textContent = 'Copied';
      setTimeout(function () { cb.textContent = 'Copy brief for your developer'; }, 1600);
    });
  });

  var tabs = document.querySelector('.vvu .tabs__links');
  var cur = tabs && tabs.querySelector('[aria-current]');
  if (cur && tabs.scrollWidth > tabs.clientWidth) tabs.scrollLeft = cur.offsetLeft - tabs.clientWidth / 2 + cur.clientWidth / 2;
})();
