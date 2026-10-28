/*
 * Builder definitions. Everything industry-specific lives here:
 * channel presets, campaign-name and content conventions, page copy and FAQs.
 * build.mjs turns each entry into a page; engine.js renders the form from it.
 */

// Dynamic parameters each ad platform fills in at click time.
const MACROS = {
  google: { label: 'Google Ads ValueTrack', fields: { term: '{keyword}', content: '{creative}', id: '{campaignid}' } },
  meta: { label: 'Meta dynamic parameters', fields: { campaign: '{{campaign.name}}', term: '{{adset.name}}', content: '{{ad.name}}', id: '{{campaign.id}}' } },
  tiktok: { label: 'TikTok dynamic parameters', fields: { campaign: '__CAMPAIGN_NAME__', term: '__AID_NAME__', content: '__CID_NAME__' } },
};

const ADS_NOTE = 'With auto-tagging on, GA4 reads Google Ads data from the gclid. Keep these UTMs anyway: your CRM, call tracking and other tools only see the UTMs.';
const QR_NOTE = 'GA4 has no default rule for offline mediums, so this lands in Unassigned. Add a custom channel group rule (medium exactly matches "qr") to report it as Offline.';
const META_NOTE = 'Use facebook or instagram as the source. GA4 doesn\'t recognise "meta", so Meta ads tagged that way fall into Paid Other.';

// Reusable channel presets. [label, source, medium, extras]
const ch = (label, source, medium, extra = {}) => ({ label, source, medium, ...extra });
const P = {
  gSearch: ch('Google Ads: Search', 'google', 'cpc', { macros: 'google', note: ADS_NOTE }),
  gPmax: ch('Google Ads: Performance Max', 'google', 'cpc', { macros: 'google', note: ADS_NOTE }),
  gShopping: ch('Google Ads: Shopping', 'google', 'cpc', { macros: 'google', prefix: 'shopping', note: 'The convention adds "shopping" to the campaign name. Without it, GA4 reports Shopping clicks as Paid Search instead of Paid Shopping.' }),
  gDisplay: ch('Google Ads: Display', 'google', 'display', { macros: 'google' }),
  gDemandGen: ch('Google Ads: Demand Gen', 'google', 'cpc', { macros: 'google', note: ADS_NOTE }),
  bing: ch('Microsoft Advertising', 'bing', 'cpc'),
  youtube: ch('YouTube ads', 'youtube', 'cpv', { macros: 'google' }),
  facebook: ch('Facebook ads', 'facebook', 'paid_social', { macros: 'meta', note: META_NOTE }),
  instagram: ch('Instagram ads', 'instagram', 'paid_social', { macros: 'meta', note: META_NOTE }),
  linkedin: ch('LinkedIn ads', 'linkedin', 'paid_social'),
  tiktok: ch('TikTok ads', 'tiktok', 'paid_social', { macros: 'tiktok' }),
  snapchat: ch('Snapchat ads', 'snapchat', 'paid_social'),
  pinterest: ch('Pinterest ads', 'pinterest', 'paid_social'),
  x: ch('X (Twitter) ads', 'twitter', 'paid_social', { note: '"twitter" is the value GA4\'s social list is built on, so it\'s the safe choice after the rebrand.' }),
  fbOrganic: ch('Facebook post', 'facebook', 'social'),
  igOrganic: ch('Instagram bio or story', 'instagram', 'social'),
  liOrganic: ch('LinkedIn post', 'linkedin', 'social'),
  ytOrganic: ch('YouTube description', 'youtube', 'video'),
  whatsapp: ch('WhatsApp message or broadcast', 'whatsapp', 'social'),
  newsletter: ch('Email newsletter', 'newsletter', 'email'),
  sms: ch('SMS', 'sms', 'sms'),
  push: ch('Push notification', 'app', 'push'),
  gbp: ch('Google Business Profile', 'google', 'organic', { prefix: 'gbp', note: 'Tag the website link on your Business Profile so map and local-pack visits stop hiding inside generic Organic Search.' }),
  printQr: ch('Print or poster QR code', 'print', 'qr', { note: QR_NOTE }),
};
const grp = (group, items) => items.map((c) => ({ ...c, group }));

const DATE_PART = { key: 'date', label: 'Date', type: 'date' };

/* ------------------------------------------------------------------ */

const basic = {
  id: 'basic',
  slug: '',
  kind: 'basic',
  nav: 'Basic',
  name: 'UTM Builder',
  h1: 'UTM builder',
  title: 'Free UTM Builder with GA4 Channel Check | Vineet on Marketing',
  description: 'Build clean UTM links in seconds. See which GA4 channel each link lands in before you publish, catch naming mistakes, and download a QR code.',
  intro: 'Add your page and campaign details. Your link builds as you type, and you can see which GA4 channel it will report under before you publish it.',
  quick: [P.gSearch, P.facebook, P.instagram, P.linkedin, P.tiktok, P.newsletter, P.liOrganic, P.whatsapp, P.sms, P.printQr],
  steps: [
    'Paste the page you want people to land on. Existing UTM tags are picked up so you can edit them.',
    'Pick a channel shortcut or type your own source, medium and campaign. Values are lowercased and cleaned as you type.',
    'Check the GA4 channel and any warnings, then copy the link, open it to test, or download a QR code.',
  ],
  tips: [
    'Keep everything lowercase. GA4 treats Facebook and facebook as two different sources, so one campaign splits into two rows.',
    'Never tag internal links on your own site. A UTM click starts a new session and overwrites the original source.',
    'Use utm_content to tell apart ads or links that point to the same page, and utm_term for keywords or audiences.',
    'Agree a separator rule: hyphens inside a value, underscores between parts of a campaign name, so names can be split back out in a spreadsheet.',
  ],
  faqs: [
    ['What is a UTM link?', 'A UTM link is a normal web address with tracking tags added after a question mark. The tags (utm_source, utm_medium, utm_campaign, utm_content and utm_term) tell GA4 and other analytics tools where a visit came from, so you can compare campaigns that send people to the same page.'],
    ['Which UTM parameters are required?', 'utm_source, utm_medium and utm_campaign. Without all three, GA4 reports the campaign as (not set) or files the visit in the wrong channel. utm_content and utm_term are optional and are mostly used for ad variations and keywords.'],
    ['Why does my campaign traffic show as Unassigned in GA4?', 'GA4 sorts visits into channels using fixed rules on the source and medium. A medium it doesn\'t recognise, such as "paid-ads" or "influencer" from an unknown source, matches no rule and ends up in Unassigned. The channel check in this builder runs the same rules, so you can fix the link before it goes live.'],
    ['What are utm_id, utm_source_platform, utm_creative_format and utm_marketing_tactic?', 'These are extra parameters GA4 can collect. utm_id is a campaign ID that lets you join cost data imported into GA4. The other three describe the buying platform, the creative format and the targeting tactic. They are optional and sit under Extra GA4 fields.'],
    ['Is anything I type saved or sent anywhere?', 'No. The builder runs entirely in your browser. Your recent links are stored only in this browser so you can copy or export them later, and you can clear them at any time.'],
  ],
};

/* ------------------------------------------------------------------ */

const healthcare = {
  id: 'healthcare',
  slug: 'healthcare',
  kind: 'industry',
  nav: 'Healthcare',
  name: 'Healthcare UTM Builder',
  h1: 'UTM builder for hospitals and clinics',
  title: 'Healthcare UTM Builder for Hospitals & Clinics | Vineet on Marketing',
  description: 'A free UTM builder for hospitals, clinics and healthcare marketers. Name campaigns by service line, objective and language, and see the GA4 channel before you publish.',
  intro: 'Built around how hospital marketing is reported: by service line, objective and language. Pick a channel, fill in the campaign parts and the name follows one convention every time.',
  channels: [
    ...grp('Paid search', [P.gSearch, P.gPmax, P.bing]),
    ...grp('Paid social', [P.facebook, P.instagram, P.snapchat, P.tiktok, P.linkedin]),
    ...grp('Display and video', [P.gDisplay, P.youtube]),
    ...grp('Owned channels', [
      ch('Patient newsletter', 'newsletter', 'email'),
      ch('Physician referral email', 'physician-newsletter', 'email'),
      ch('Appointment or recall SMS', 'sms', 'sms'),
      P.whatsapp,
      ch('Patient app push', 'patient-app', 'push'),
      P.fbOrganic, P.igOrganic, P.liOrganic, P.ytOrganic,
    ]),
    ...grp('Listings and partners', [
      P.gbp,
      ch('Doctor booking platform (e.g. Okadoc)', 'okadoc', 'referral', { note: 'Swap in the platform you list on. Tag the profile\'s website link so booking-platform visits are counted as their own source.' }),
      ch('Insurance partner portal', 'insurer-portal', 'referral'),
      ch('Corporate wellness partner', 'corporate-partner', 'referral'),
    ]),
    ...grp('Offline', [
      ch('Clinic poster or brochure QR', 'print', 'qr', { note: QR_NOTE }),
      ch('Health camp or event QR', 'health-event', 'qr', { note: QR_NOTE }),
      ch('Radio spot vanity URL', 'radio', 'audio'),
    ]),
  ],
  campaign: [
    { key: 'facility', label: 'Hospital or clinic', type: 'text', placeholder: 'e.g. main-campus', optional: true, help: 'Leave blank if you only run one location.' },
    { key: 'service', label: 'Service line', type: 'select', options: ['brand', 'cardiology', 'oncology', 'orthopaedics', 'obstetrics-gynaecology', 'paediatrics', 'fertility-ivf', 'bariatric', 'neurology', 'urology', 'gastroenterology', 'endocrinology', 'dermatology', 'ophthalmology', 'ent', 'dental', 'mental-health', 'physiotherapy', 'executive-health', 'emergency', 'telehealth', 'pharmacy', 'diagnostics-lab', 'radiology'] },
    { key: 'objective', label: 'Objective', type: 'select', options: ['appointments', 'awareness', 'screening', 'consultation-leads', 'second-opinion', 'event-registration', 'physician-referral', 'app-downloads', 'recruitment', 'community'] },
    { key: 'audience', label: 'Audience', type: 'select', optional: true, options: ['patients', 'caregivers', 'women', 'parents', 'seniors', 'expats', 'medical-tourists', 'physicians', 'corporate', 'insured'] },
    { key: 'lang', label: 'Language', type: 'select', optional: true, options: [['en', 'English (en)'], ['ar', 'Arabic (ar)'], ['bi', 'Bilingual (bi)'], ['ru', 'Russian (ru)'], ['hi', 'Hindi (hi)'], ['ur', 'Urdu (ur)'], ['tl', 'Tagalog (tl)']] },
    DATE_PART,
  ],
  content: [
    { key: 'format', label: 'Format', type: 'select', options: ['rsa', 'image', 'carousel', 'video', 'reel', 'story', 'lead-form', 'email-hero', 'email-footer', 'sms-link', 'poster', 'brochure', 'gbp-website'] },
    { key: 'angle', label: 'Message or CTA', type: 'select', optional: true, options: ['book-appointment', 'find-a-doctor', 'call-now', 'whatsapp-us', 'second-opinion', 'insurance-accepted', 'same-day', 'female-doctor', 'cost-estimate', 'symptom-awareness', 'patient-story', 'doctor-video', 'learn-more'] },
    { key: 'variant', label: 'Variant', type: 'text', optional: true, placeholder: 'e.g. v1 or a' },
  ],
  term: { label: 'Keyword or audience', placeholder: 'e.g. cardiologist near me', help: 'Keyword for search, audience or ad set for social.' },
  privacy: 'Keep UTMs at campaign level. Never put patient names, record numbers, emails, phone numbers or an individual\'s diagnosis in a link: URLs are stored in analytics, ad platforms and browser history.',
  steps: [
    'Paste the landing page, such as the service page or the booking page.',
    'Choose the channel. Source and medium fill in with values GA4 recognises, and you can still edit them.',
    'Build the campaign name from the service line, objective, audience, language and date, then add the format and CTA as content.',
    'Check the GA4 channel and warnings, then copy the link or download a QR code for print.',
  ],
  tips: [
    'Put the service line near the front of the campaign name. It\'s the dimension leadership asks about most, and it lets you roll up cardiology spend and leads across every channel.',
    'Tag Arabic and English versions separately with the language part. Bilingual markets almost always show different cost per booking by language.',
    'Tag your Google Business Profile website link. Map and local-pack visits are often a large share of appointment requests and otherwise disappear into Organic Search.',
    'For booking platforms such as Okadoc, tag the website link on your profile so referrals are counted as their own source, then compare them with your own booking funnel.',
    'Capture UTMs into hidden fields on appointment forms so the source reaches your call centre or CRM, not just GA4.',
  ],
  faqs: [
    ['Can I put a medical condition in a campaign name?', 'Service-line and campaign-level names such as "cardiology" or "fertility-ivf" are common and fine. What must never go in a link is anything about an individual: names, record numbers, contact details or a specific patient\'s condition. Check your hospital\'s privacy policy and local health advertising rules for anything more sensitive.'],
    ['How should a hospital structure UTM campaign names?', 'Start with the parts you report on most. A common order is facility, service line, objective, audience, language and date, for example "main-campus_cardiology_appointments_patients_ar_202610". Underscores separate the parts, so you can split them into columns in Looker Studio or a spreadsheet.'],
    ['How do I track appointments that come from Google Business Profile?', 'Add a UTM link to the website field of each profile, with source google, medium organic and a campaign name that starts with gbp. GA4 keeps the visit in Organic Search, and the campaign name lets you separate it from regular search results.'],
    ['Why should Arabic and English campaigns be tagged separately?', 'Language changes audience, competition and conversion rates. Tagging language in the campaign name lets you compare cost per lead and booking rates by language without relying on ad platform labels.'],
    ['Do UTMs work for phone calls and WhatsApp enquiries?', 'UTMs only travel with the click. To connect calls or WhatsApp chats to campaigns, use call tracking numbers that change based on the UTM source, or pass the UTMs into a pre-filled WhatsApp message or form.'],
  ],
};

/* ------------------------------------------------------------------ */

const ecommerce = {
  id: 'ecommerce',
  slug: 'ecommerce',
  kind: 'industry',
  nav: 'Ecommerce',
  name: 'Ecommerce UTM Builder',
  h1: 'UTM builder for ecommerce stores',
  title: 'Ecommerce UTM Builder for Online Stores | Vineet on Marketing',
  description: 'A free UTM builder for online stores. Tag Shopping, PMax, Meta, TikTok, email flows and influencers with one naming convention, and check the GA4 channel before launch.',
  intro: 'Tag every sale, flow and creator with one convention. Shopping campaigns get the "shopping" marker GA4 needs, and email flows are kept apart from campaigns.',
  channels: [
    ...grp('Paid search and shopping', [P.gShopping, P.gPmax, P.gSearch, P.bing]),
    ...grp('Paid social', [P.facebook, P.instagram, P.tiktok, P.snapchat, P.pinterest]),
    ...grp('Display, video and retargeting', [P.gDisplay, P.gDemandGen, P.youtube, ch('Criteo retargeting', 'criteo', 'retargeting')]),
    ...grp('Owned channels', [
      ch('Email campaign', 'newsletter', 'email'),
      ch('Email automation (flow)', 'automation', 'email', { note: 'Keep flows (welcome, abandoned cart, win-back) on their own source so you can compare them with one-off sends.' }),
      P.sms, ch('App push', 'app', 'push'), P.whatsapp, P.fbOrganic, P.igOrganic,
    ]),
    ...grp('Partners and creators', [
      ch('Affiliate network', 'affiliate-network', 'affiliate'),
      ch('Coupon or cashback site', 'coupon-site', 'affiliate'),
      ch('Influencer (Instagram)', 'instagram', 'influencer', { note: 'GA4 reports this as Organic Social. Put the creator\'s handle in utm_content so each creator gets their own row.' }),
      ch('Influencer (TikTok)', 'tiktok', 'influencer', { note: 'GA4 reports this as Organic Social. Put the creator\'s handle in utm_content.' }),
      ch('Marketplace store link', 'amazon', 'referral'),
    ]),
    ...grp('Offline', [ch('Package insert QR', 'package-insert', 'qr', { note: QR_NOTE }), P.printQr]),
  ],
  campaign: [
    { key: 'type', label: 'Campaign type', type: 'select', options: ['sale', 'launch', 'evergreen', 'prospecting', 'retargeting', 'abandoned-cart', 'browse-abandon', 'welcome', 'post-purchase', 'win-back', 'loyalty', 'clearance', 'bundle', 'restock'] },
    { key: 'event', label: 'Season or event', type: 'select', optional: true, options: ['black-friday', 'white-friday', 'cyber-monday', 'singles-day', 'dsf', 'ramadan', 'eid-al-fitr', 'eid-al-adha', 'national-day', 'back-to-school', 'valentines', 'mothers-day', 'fathers-day', 'diwali', 'christmas', 'new-year', 'summer'] },
    { key: 'category', label: 'Product or category', type: 'text', placeholder: 'e.g. womens-shoes' },
    { key: 'offer', label: 'Offer', type: 'text', optional: true, placeholder: 'e.g. upto-50-off' },
    { key: 'market', label: 'Market', type: 'select', optional: true, options: ['uae', 'ksa', 'gcc', 'kuwait', 'qatar', 'bahrain', 'oman', 'egypt', 'india', 'uk', 'us', 'eu', 'global'] },
    DATE_PART,
  ],
  content: [
    { key: 'format', label: 'Format', type: 'select', options: ['shopping', 'rsa', 'image', 'carousel', 'catalog', 'video', 'reel', 'story', 'ugc', 'email-hero', 'email-product-grid', 'sms-link', 'creator-post'] },
    { key: 'angle', label: 'Angle or creator', type: 'text', optional: true, placeholder: 'e.g. free-delivery or @creatorhandle' },
    { key: 'variant', label: 'Variant', type: 'text', optional: true, placeholder: 'e.g. v1' },
  ],
  term: { label: 'Keyword or audience', placeholder: 'e.g. lookalike-purchasers', help: 'Keyword for search, audience for social.' },
  steps: [
    'Paste the product, collection or landing page.',
    'Pick the channel. Shopping presets add the "shopping" marker so GA4 files clicks under Paid Shopping.',
    'Build the campaign name from type, event, category, offer, market and date. Add the creative format and angle (or creator) as content.',
    'Copy the link, log it as a spreadsheet row, or download a QR code for package inserts.',
  ],
  tips: [
    'Give email flows their own source, such as "automation", so always-on revenue is not mixed with one-off campaign sends.',
    'Tag every influencer link, and put the creator handle in utm_content. Discount codes alone miss everyone who clicks and buys without the code.',
    'Use "shopping" in Shopping and PMax feed campaigns where you want GA4 to separate product-ad revenue from search ads.',
    'Name sale events the same way every year (white-friday, not wf or whitefriday) so you can compare year on year.',
    'Check that your checkout keeps the UTMs. Third-party payment pages often show up as referrals and steal the credit unless they are excluded.',
  ],
  faqs: [
    ['Why do my Google Shopping clicks show as Paid Search in GA4?', 'GA4 only reports Paid Shopping when the source is a known shopping site or the campaign name contains "shop" or "shopping". Google is a search engine, so a campaign called "summer-sale" from google / cpc becomes Paid Search. Adding "shopping" to the campaign name fixes it, which is what the Shopping preset in this builder does.'],
    ['Should I use UTMs and discount codes for influencers?', 'Use both. Codes catch buyers who type them in later, and UTMs catch people who click and buy without a code. Put the creator handle in utm_content so each creator has their own row in GA4.'],
    ['Do UTMs conflict with Meta\'s fbclid or Google\'s gclid?', 'No. Click IDs are added automatically by the platforms and work alongside your UTMs. Just don\'t paste a click ID into a link you are building, because it belongs to one specific click.'],
    ['How do I tag email flows such as abandoned cart?', 'Use medium email, a dedicated source such as "automation", and a campaign name that describes the flow, for example "abandoned-cart_all-products_uae". Many email platforms can add UTMs automatically; match their settings to the same convention.'],
    ['What should I use for marketplace links such as Amazon?', 'Links from your marketplace store to your own site can use source amazon and medium referral. GA4 recognises Amazon as a shopping site and reports it as Organic Shopping.'],
  ],
};

/* ------------------------------------------------------------------ */

const realestate = {
  id: 'real-estate',
  slug: 'real-estate',
  kind: 'industry',
  nav: 'Real estate',
  name: 'Real Estate UTM Builder',
  h1: 'UTM builder for real estate developers and brokers',
  title: 'Real Estate UTM Builder for Developers & Brokers | Vineet on Marketing',
  description: 'A free UTM builder for property launches. Track leads by project, unit type, market and channel, including portals, brokers, billboards and roadshows.',
  intro: 'Track launches the way sales teams ask about them: by project, unit type and buyer market. Portals, brokers, billboards and roadshows all get their own tags.',
  channels: [
    ...grp('Paid search', [P.gSearch, P.gPmax, P.bing]),
    ...grp('Paid social', [ch('Facebook lead or traffic ads', 'facebook', 'paid_social', { macros: 'meta', note: META_NOTE }), P.instagram, P.tiktok, P.snapchat, ch('LinkedIn ads (investors)', 'linkedin', 'paid_social')]),
    ...grp('Display and video', [P.gDisplay, P.gDemandGen, P.youtube]),
    ...grp('Property portals', [
      ch('Bayut', 'bayut', 'referral'),
      ch('Property Finder', 'propertyfinder', 'referral'),
      ch('Dubizzle', 'dubizzle', 'referral'),
      ch('99acres', '99acres', 'referral'),
      ch('MagicBricks', 'magicbricks', 'referral'),
      ch('Other portal', 'portal-name', 'referral', { note: 'Replace the source with the portal name.' }),
    ]),
    ...grp('Brokers and owned channels', [
      ch('Broker or agency partner', 'agency-name', 'referral', { note: 'Give each broker their own source so leads can be matched to commission.' }),
      ch('Broker network email', 'broker-newsletter', 'email'),
      ch('Buyer database email', 'newsletter', 'email'),
      P.whatsapp, P.sms, P.igOrganic, P.liOrganic,
    ]),
    ...grp('Offline', [
      ch('Billboard or OOH QR', 'billboard', 'qr', { note: QR_NOTE }),
      ch('Brochure or print ad QR', 'print', 'qr', { note: QR_NOTE }),
      ch('Roadshow or exhibition QR', 'roadshow', 'qr', { note: QR_NOTE }),
      ch('Sales gallery QR', 'sales-gallery', 'qr', { note: QR_NOTE }),
      ch('Radio spot vanity URL', 'radio', 'audio'),
    ]),
  ],
  campaign: [
    { key: 'developer', label: 'Developer or brand', type: 'text', optional: true, placeholder: 'e.g. brand-name', help: 'Useful for brokers and agencies handling several developers.' },
    { key: 'project', label: 'Project', type: 'text', placeholder: 'e.g. palm-heights' },
    { key: 'phase', label: 'Phase or tower', type: 'text', optional: true, placeholder: 'e.g. tower-b or phase-2' },
    { key: 'unit', label: 'Unit type', type: 'select', optional: true, options: ['studio', '1br', '2br', '3br', '4br-plus', 'villa', 'townhouse', 'penthouse', 'duplex', 'plot', 'office', 'retail', 'mixed'] },
    { key: 'objective', label: 'Objective', type: 'select', options: ['launch', 'eoi', 'lead-gen', 'site-visit', 'open-house', 'event-registration', 'retargeting', 'last-units', 'handover', 'resale', 'rental', 'brand'] },
    { key: 'market', label: 'Buyer market', type: 'select', optional: true, options: ['local', 'uae', 'ksa', 'gcc', 'india', 'nri', 'uk', 'europe', 'russia-cis', 'china', 'pakistan', 'africa', 'global'] },
    DATE_PART,
  ],
  content: [
    { key: 'format', label: 'Format', type: 'select', options: ['rsa', 'image', 'carousel', 'video', 'reel', 'story', 'lead-form', 'listing', 'email-hero', 'whatsapp-msg', 'billboard', 'brochure', 'print-ad'] },
    { key: 'angle', label: 'Selling angle', type: 'select', optional: true, options: ['payment-plan', 'post-handover-plan', 'golden-visa', 'roi', 'rental-yield', 'location', 'amenities', 'price', 'floor-plan', 'virtual-tour', 'launch-offer', 'register-interest'] },
    { key: 'variant', label: 'Variant or location', type: 'text', optional: true, placeholder: 'e.g. szr-north or v2' },
  ],
  term: { label: 'Keyword or audience', placeholder: 'e.g. off plan apartments dubai', help: 'Keyword for search, audience for social.' },
  steps: [
    'Paste the project page or launch landing page.',
    'Choose the channel, including portals, brokers and offline placements.',
    'Build the campaign name from project, phase, unit type, objective, buyer market and date. Add the selling angle as content.',
    'Copy the link for ads and brokers, or download the QR code for billboards and brochures.',
  ],
  tips: [
    'Give every broker their own source. When leads arrive in the CRM, you can match them to the right agency without arguing over spreadsheets.',
    'Use a different QR link per billboard location, with the location in utm_content. It\'s the cheapest way to compare outdoor sites.',
    'Tag the buyer market, not just the ad targeting. India, UK and GCC buyers respond to different angles and close at very different rates.',
    'Pass the UTMs into hidden fields on your enquiry form and into your CRM. Real estate sales cycles are long, so first-touch source has to live with the lead.',
    'Keep the project name identical across every channel and every phase so lead reports add up.',
  ],
  faqs: [
    ['How do I track leads from property portals like Bayut or Property Finder?', 'Portal enquiries usually arrive directly in your CRM or the portal\'s dashboard. UTMs track the visits portals send to your own website, such as clicks on your developer page link. Tag those links with the portal as the source and referral as the medium.'],
    ['How should I track billboards and print ads?', 'Use a QR code with UTM tags, or a short vanity URL that redirects to a tagged link. Put the billboard location in utm_content. GA4 will report medium qr as Unassigned unless you add a custom channel group, which takes a couple of minutes in GA4 admin.'],
    ['How do I compare the same project across different buyer markets?', 'Add the market to the campaign name, for example "palm-heights_2br_launch_india_202610". You can then filter or split the campaign name to compare cost per lead and site visits by market.'],
    ['Can I track leads from WhatsApp?', 'UTMs track the click to your website. For WhatsApp-first funnels, use a tagged landing page with a WhatsApp button that passes the campaign into the pre-filled message, so sales can see where the chat came from.'],
    ['Should brokers use their own UTM links?', 'Yes. Give each broker a tagged link with their agency as the source. It keeps their traffic separate from your own campaigns and makes commission disputes easier to settle.'],
  ],
};

/* ------------------------------------------------------------------ */

const travel = {
  id: 'travel-tourism',
  slug: 'travel-tourism',
  kind: 'industry',
  nav: 'Travel & tourism',
  name: 'Travel & Tourism UTM Builder',
  h1: 'UTM builder for hotels, travel and tourism',
  title: 'Travel & Tourism UTM Builder for Hotels and Tour Operators | Vineet on Marketing',
  description: 'A free UTM builder for hotels, tour operators and destinations. Tag metasearch, OTAs, seasonal offers and source markets, and check the GA4 channel before launch.',
  intro: 'Built for hotels, tour operators and destination marketers. Tag by destination, product, season and source market, including metasearch, OTAs and in-room QR codes.',
  channels: [
    ...grp('Paid search', [P.gSearch, ch('Google Hotel Ads', 'google', 'cpc', { macros: 'google', prefix: 'hotel-ads', note: ADS_NOTE }), P.gPmax, P.bing]),
    ...grp('Metasearch', [
      ch('Tripadvisor', 'tripadvisor', 'cpc'),
      ch('Trivago', 'trivago', 'cpc'),
      ch('Kayak', 'kayak', 'cpc'),
      ch('Skyscanner', 'skyscanner', 'cpc'),
    ]),
    ...grp('Paid social', [P.facebook, P.instagram, P.tiktok, P.snapchat, P.pinterest]),
    ...grp('Display and video', [P.gDisplay, P.gDemandGen, P.youtube]),
    ...grp('Owned channels', [
      ch('Email newsletter', 'newsletter', 'email'),
      ch('Pre-arrival email', 'pre-arrival', 'email'),
      ch('Post-stay email', 'post-stay', 'email'),
      P.whatsapp, P.sms, ch('Loyalty app push', 'loyalty-app', 'push'), P.igOrganic, P.fbOrganic, P.ytOrganic,
    ]),
    ...grp('Partners', [
      ch('OTA listing link', 'booking.com', 'referral'),
      ch('Travel agent or DMC', 'agent-name', 'referral'),
      ch('Travel blogger or affiliate', 'blogger-name', 'affiliate'),
      ch('Influencer', 'instagram', 'influencer', { note: 'GA4 reports this as Organic Social. Put the creator handle in utm_content.' }),
      P.gbp,
    ]),
    ...grp('Offline', [
      ch('In-room or lobby QR', 'in-room', 'qr', { note: QR_NOTE }),
      ch('Trade show QR (e.g. ATM, ITB)', 'trade-show', 'qr', { note: QR_NOTE }),
      ch('Brochure or print QR', 'print', 'qr', { note: QR_NOTE }),
    ]),
  ],
  campaign: [
    { key: 'brand', label: 'Property or brand', type: 'text', optional: true, placeholder: 'e.g. beach-resort' },
    { key: 'destination', label: 'Destination', type: 'text', placeholder: 'e.g. dubai or maldives' },
    { key: 'product', label: 'Product', type: 'select', options: ['room-stay', 'suite', 'holiday-package', 'flight-hotel', 'tour', 'activity', 'day-pass', 'staycation', 'spa', 'dining', 'wedding', 'mice', 'cruise', 'visa', 'brand'] },
    { key: 'occasion', label: 'Season or occasion', type: 'select', optional: true, options: ['summer', 'winter', 'school-holidays', 'long-weekend', 'ramadan', 'eid', 'diwali', 'christmas', 'new-year', 'valentines', 'national-day', 'golden-week', 'off-peak'] },
    { key: 'market', label: 'Source market', type: 'select', optional: true, options: ['uae', 'ksa', 'gcc', 'india', 'uk', 'germany', 'europe', 'russia-cis', 'china', 'us', 'domestic', 'global'] },
    { key: 'window', label: 'Booking window', type: 'select', optional: true, options: ['early-bird', 'last-minute', 'flash-sale', 'always-on'] },
    DATE_PART,
  ],
  content: [
    { key: 'format', label: 'Format', type: 'select', options: ['rsa', 'hotel-ad', 'meta-listing', 'image', 'carousel', 'video', 'reel', 'story', 'email-hero', 'whatsapp-msg', 'qr-card', 'brochure'] },
    { key: 'angle', label: 'Offer or angle', type: 'select', optional: true, options: ['book-now', 'price-from', 'percent-off', 'free-night', 'kids-stay-free', 'all-inclusive', 'room-upgrade', 'best-rate-guarantee', 'experience', 'destination-video', 'reviews'] },
    { key: 'variant', label: 'Variant', type: 'text', optional: true, placeholder: 'e.g. v1' },
  ],
  term: { label: 'Keyword or audience', placeholder: 'e.g. beach resort dubai', help: 'Keyword for search, audience for social.' },
  steps: [
    'Paste the offer page, room page or booking engine link.',
    'Choose the channel, including metasearch, OTAs, partners and in-room placements.',
    'Build the campaign name from property, destination, product, season, source market and booking window.',
    'Copy the link, then test that the tags survive the jump to your booking engine.',
  ],
  tips: [
    'Check your booking engine. If it runs on a different domain, set up cross-domain measurement in GA4 or the booking will be credited to your own site as a referral.',
    'Tag source market separately from targeting. The same offer often converts very differently for GCC, India and European travellers.',
    'Use "early-bird" and "last-minute" consistently so you can compare booking windows across seasons.',
    'Put in-room and lobby QR codes on their own source. They show which on-property placements drive direct rebookings and upsells.',
    'Tag the Google Business Profile website link for each property to separate map traffic from regular search.',
  ],
  faqs: [
    ['Why do my bookings show up as referrals from my booking engine?', 'If the booking engine is on another domain, GA4 starts a new session when visitors move to it and credits the booking engine as the source. Set up cross-domain measurement in GA4 and add the booking domain to the unwanted referrals list so the original campaign keeps the credit.'],
    ['How should I tag metasearch like Tripadvisor or Trivago?', 'Use the metasearch site as the source and cpc as the medium. GA4 doesn\'t have these sites on its search list, so they appear as Paid Other, which keeps them separate from Google Ads.'],
    ['Should I tag links on OTA listings?', 'Where the OTA lets you add a website link, yes. Tag it with the OTA as the source and referral as the medium, so you can see how many travellers check your own site before booking.'],
    ['How do I compare source markets?', 'Add the market to the campaign name, for example "beach-resort_maldives_holiday-package_summer_india_early-bird_202610". You can split it into columns later to compare cost per booking by market.'],
    ['Can I track QR codes in rooms and lobbies?', 'Yes. Use a source such as "in-room" and medium "qr", with the placement in utm_content. GA4 reports qr as Unassigned by default, so add a custom channel group rule if you want an Offline channel.'],
  ],
};

/* ------------------------------------------------------------------ */

const b2b = {
  id: 'b2b',
  slug: 'b2b',
  kind: 'industry',
  nav: 'B2B',
  name: 'B2B UTM Builder',
  h1: 'UTM builder for B2B marketing',
  title: 'B2B UTM Builder for SaaS and Lead Generation | Vineet on Marketing',
  description: 'A free UTM builder for B2B and SaaS teams. Tag LinkedIn, webinars, content offers, review sites, events and sales outreach by funnel stage and segment.',
  intro: 'For long sales cycles, where the first touch has to survive all the way into the CRM. Tag by product, offer, funnel stage and segment.',
  channels: [
    ...grp('Paid social', [P.linkedin, P.facebook, P.x]),
    ...grp('Paid search', [P.gSearch, P.bing, P.gPmax]),
    ...grp('Display and video', [P.gDisplay, P.youtube, ch('ABM or programmatic display', 'abm-platform', 'display', { note: 'Replace the source with your ABM or DSP platform name.' })]),
    ...grp('Review sites', [
      ch('G2', 'g2', 'cpc'),
      ch('Capterra', 'capterra', 'cpc'),
      ch('Review profile link (organic)', 'g2', 'referral'),
    ]),
    ...grp('Owned channels', [
      ch('Nurture email', 'nurture', 'email'),
      ch('Newsletter', 'newsletter', 'email'),
      ch('Sales outreach email', 'sales-outreach', 'email', { note: 'Keep sales sequences on their own source so marketing and sales sourced pipeline can be told apart.' }),
      ch('LinkedIn company page post', 'linkedin', 'social'),
      ch('Employee advocacy post', 'linkedin', 'social', { note: 'Put the employee or team name in utm_content.' }),
      P.ytOrganic,
    ]),
    ...grp('Partners and events', [
      ch('Partner co-marketing', 'partner-name', 'referral'),
      ch('Content syndication', 'syndication-vendor', 'syndication', { note: 'GA4 has no rule for syndication, so this lands in Unassigned. Add a custom channel group rule if you report on it.' }),
      ch('Podcast sponsorship', 'podcast-name', 'audio'),
      ch('Webinar platform link', 'webinar', 'referral'),
      ch('Event or booth QR (e.g. GITEX)', 'event-name', 'qr', { note: QR_NOTE }),
    ]),
  ],
  campaign: [
    { key: 'product', label: 'Product or solution', type: 'text', placeholder: 'e.g. analytics-suite' },
    { key: 'type', label: 'Offer type', type: 'select', options: ['webinar', 'ebook', 'whitepaper', 'report', 'case-study', 'checklist', 'demo', 'free-trial', 'assessment', 'product-launch', 'event', 'newsletter', 'abm', 'brand'] },
    { key: 'stage', label: 'Funnel stage', type: 'select', options: [['tofu', 'Awareness (tofu)'], ['mofu', 'Consideration (mofu)'], ['bofu', 'Decision (bofu)'], ['retention', 'Retention'], ['expansion', 'Expansion']] },
    { key: 'segment', label: 'Segment or persona', type: 'select', optional: true, options: ['smb', 'mid-market', 'enterprise', 'cxo', 'it', 'marketing', 'sales', 'finance', 'hr', 'operations', 'procurement', 'public-sector'] },
    { key: 'region', label: 'Region', type: 'select', optional: true, options: ['uae', 'ksa', 'gcc', 'mena', 'india', 'uk', 'emea', 'na', 'apac', 'global'] },
    DATE_PART,
  ],
  content: [
    { key: 'format', label: 'Format', type: 'select', options: ['single-image', 'carousel', 'document-ad', 'video', 'conversation-ad', 'lead-gen-form', 'thought-leader-ad', 'rsa', 'display', 'email-cta', 'email-signature', 'post', 'qr'] },
    { key: 'angle', label: 'Asset or message', type: 'text', optional: true, placeholder: 'e.g. roi-calculator or customer-story' },
    { key: 'variant', label: 'Variant', type: 'text', optional: true, placeholder: 'e.g. v1' },
  ],
  term: { label: 'Keyword, job title or audience', placeholder: 'e.g. it-directors-uae', help: 'Keyword for search, job title or matched audience for LinkedIn.' },
  steps: [
    'Paste the landing page, gated asset page or demo page.',
    'Choose the channel, including review sites, partners, events and sales outreach.',
    'Build the campaign name from product, offer type, funnel stage, segment, region and date.',
    'Copy the link, and make sure your forms pass the UTMs into the CRM.',
  ],
  tips: [
    'Capture UTMs in hidden form fields and store them on the contact in HubSpot, Salesforce or your CRM. GA4 alone can\'t tell you which campaign became pipeline.',
    'Keep sales outreach on its own source. It\'s the cleanest way to split marketing-sourced and sales-sourced pipeline.',
    'Tag the funnel stage. It stops a cheap top-of-funnel ebook from being judged against a demo campaign on cost per lead.',
    'Use utm_term for job title or matched audience on LinkedIn so you can see which roles convert, not just which ads.',
    'Tag employee advocacy links separately from the company page. Personal profiles usually drive more clicks than brand posts.',
  ],
  faqs: [
    ['How do I get UTM data into HubSpot or Salesforce?', 'Add hidden fields for each UTM to your forms and fill them from the page URL, or use your CRM\'s built-in tracking. Store first-touch and last-touch values separately so long sales cycles keep the original source.'],
    ['Should LinkedIn paid and organic posts use different UTMs?', 'Yes. Use medium paid_social for ads and social for company page and employee posts. GA4 then reports them as Paid Social and Organic Social, and you can compare them fairly.'],
    ['How do I tag webinars?', 'Tag the registration links in every promotion channel, with the webinar name in the campaign. Then tag the follow-up and replay emails with the same campaign name so registrations and attendance stay connected.'],
    ['How should review sites like G2 and Capterra be tagged?', 'Use the review site as the source. Use cpc for paid placements and referral for organic profile links. GA4 reports the paid ones as Paid Other, which keeps them out of your search numbers.'],
    ['What about content syndication leads?', 'Syndication vendors usually send leads directly, not website visits. Tag any links in the syndicated asset with the vendor as the source so follow-up visits are attributed correctly.'],
  ],
};

module.exports = { builders: [basic, healthcare, ecommerce, realestate, travel, b2b], MACROS };
