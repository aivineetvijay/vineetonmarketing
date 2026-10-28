// Builds pages.json, the page copy for the UTM builder pages on vineetonmarketing.com.
// Usage: node build.mjs
//
// One entry per builder in src/configs.js: SEO title and description, H1, intro, FAQs and the content
// section below the tool (what UTM tags do, how to use it, naming convention, channel cheat sheet, tips,
// developer brief, FAQs, links to the other builders). The vv-utm mu-plugin prints this HTML on the page,
// so search engines see it without running JavaScript. {{YYYYMM}} is replaced with the current month when
// the page is served, so the examples never go stale.
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

const BLURBS = {
  basic: 'The five UTM fields, extra GA4 fields and channel shortcuts.',
  healthcare: 'Service line and objective for hospitals and clinics.',
  ecommerce: 'Campaign type and category for online stores.',
  'real-estate': 'Project and objective for property launches.',
  'travel-tourism': 'Destination and product for hotels and travel.',
  b2b: 'Product, campaign type and funnel stage for B2B and SaaS.',
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

const LEARN = '<h2>What UTM tags do</h2><p>UTM tags are short labels added to the end of a link. When someone clicks, your analytics reads the labels and records exactly where the visit came from. No extra code is needed for GA4 to read them.</p>' +
  '<div class="table-wrap"><table><thead><tr><th scope="col">Tag</th><th scope="col">Answers</th><th scope="col">Example</th></tr></thead><tbody>' +
  P5.map((r) => '<tr><td><code>' + r[0] + '</code></td><td>' + r[1] + '</td><td><code>' + r[2] + '</code></td></tr>').join('') + '</tbody></table></div>' +
  '<h2>Why UTM tags matter</h2><ul><li><strong>Credit goes to the right campaign.</strong> Without tags, a click from an email or WhatsApp message often shows up as Direct, and the campaign that earned it gets no credit.</li><li><strong>Channels are compared fairly.</strong> One naming convention across every channel means paid, owned and partner traffic line up in the same report.</li><li><strong>Leads and revenue connect to marketing.</strong> Stored with each lead, UTM tags show which campaign produced customers, not just clicks.</li><li><strong>Budget follows results.</strong> Clean data shows which ads and messages to scale and which to stop.</li></ul>';

const devSection = () => '<h2>Getting UTM data into your database</h2><p>GA4 counts visits. Your CRM or database records who became a lead or customer. Unless the UTM tags are saved with each record, the two never meet, and you can\'t tell which campaign produced which sale. Share this brief with your website developer.</p>' +
  '<h3>What to ask for</h3><ol>' + DEVSTEPS.map((s) => '<li>' + esc(s) + '</li>').join('') + '</ol>' +
  '<h3>Fields to add to each lead or order</h3><div class="table-wrap"><table><thead><tr><th scope="col">Field</th><th scope="col">What it holds</th></tr></thead><tbody>' +
  DEVF.map((f) => '<tr><td><code>' + esc(f[0]) + '</code></td><td>' + esc(f[1]) + '</td></tr>').join('') + '</tbody></table></div>' +
  '<h3>A starting point for the developer</h3><pre class="snip"><code>' + esc(SNIP) + '</code></pre>' +
  '<div class="brief-actions"><button type="button" class="pill" id="copy-brief">Copy brief for your developer</button></div>' +
  '<pre hidden id="utm-brief">' + esc(brief()) + '</pre>' +
  '<p class="fine">Never put names, emails or phone numbers in UTM tags. Store them only in your own database, under your privacy policy.</p>';

function rows(b) {
  return (b.kind === 'basic' ? b.quick : b.channels).map((c) => {
    const g = GA4.classify(c.source, c.medium, c.prefix || '');
    return '<tr><td>' + esc(c.label) + '</td><td><code>' + esc(c.source) + '</code></td><td><code>' + esc(c.medium) + '</code></td><td class="ga-' + g.channel.replace(/\s/g, '') + '">' + esc(g.channel) + '</td></tr>';
  }).join('');
}

function content(b) {
  const conv = b.kind === 'industry'
    ? '<div class="conv-block"><p>Pattern: <code>' + esc(b.campaign.map((p) => '{' + p.key + '}').join('_')) + '</code></p><p>Example: <code>' + esc(sample(b)) + '</code></p></div><p>Parts are joined with underscores and words inside a part use hyphens, so you can split the name back into columns in a spreadsheet or Looker Studio. Optional parts are skipped when empty. You can switch the separator under Formatting rules.</p>'
    : '<div class="conv-block"><p>Pattern: <code>{offer-or-theme}_{product-or-audience}_{market}_{yyyymm}</code></p><p>Example: <code>spring-sale_running-shoes_uae_' + YM + '</code></p></div><p>Pick the parts your reports need, keep them in the same order every time, and write them down where the whole team can see them. Need a ready-made convention? The industry builders below each come with one.</p>';
  const others = builders.filter((x) => x.id !== b.id).map((x) => '<a href="' + href(x) + '"><strong>' + esc(x.name) + '</strong><span>' + esc(BLURBS[x.id]) + '</span><em>Open builder ›</em></a>').join('');
  return LEARN +
    '<h2>How to use this builder</h2><ol>' + b.steps.map((s) => '<li>' + esc(s) + '</li>').join('') + '</ol>' +
    '<h2>The naming convention</h2>' + conv +
    '<h2>Channel cheat sheet</h2><p>The source and medium each preset uses, and the GA4 default channel it reports under.</p><div class="table-wrap"><table><thead><tr><th scope="col">Channel</th><th scope="col">utm_source</th><th scope="col">utm_medium</th><th scope="col">GA4 channel</th></tr></thead><tbody>' + rows(b) + '</tbody></table></div>' +
    '<h2>Tips' + (b.kind === 'industry' ? ' for ' + esc(b.nav.toLowerCase()) + ' marketers' : '') + '</h2><ul>' + b.tips.map((t) => '<li>' + esc(t) + '</li>').join('') + '</ul>' +
    devSection() +
    '<h2>Frequently asked questions</h2><div class="faq">' + b.faqs.map((f) => '<details><summary>' + esc(f[0]) + '</summary><p>' + esc(f[1]) + '</p></details>').join('') + '</div>' +
    '<h2>More UTM builders</h2><div class="others">' + others + '</div>';
}

const pages = builders.map((raw) => {
  const b = simplify(raw);
  return {
    id: b.id, slug: b.slug, nav: b.nav, name: b.name, kind: b.kind,
    title: b.title.replace(/\s*\|\s*Vineet on Marketing$/, ''),
    description: b.description,
    h1: b.h1.charAt(0).toUpperCase() + b.h1.slice(1) + '.',
    intro: b.intro,
    faqs: b.faqs,
    content: content(b),
  };
});

writeFileSync(join(here, 'pages.json'), JSON.stringify({ base: BASE, pages }, null, 1) + '\n');
console.log('pages.json:', pages.map((p) => p.id).join(', '));
