/* llms.txt generator: Real Estate. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'real-estate', label: 'real estate', where: 'in',
	shareWith: 'someone who manages a property site', reviewWhen: 'or whenever a project launches or hands over',
	types: [
		[ 'developer', 'Developer', 'real estate developer', 'Real estate developer' ],
		[ 'brokerage', 'Brokerage', 'real estate brokerage', 'Real estate brokerage' ],
		[ 'agency', 'Agency', 'real estate agency', 'Real estate agency' ],
		[ 'portal', 'Portal', 'property portal', 'Property portal' ],
	],
	fields: {
		name: { label: 'Business name', ph: 'Harbourline Properties' },
		site: { label: 'Website', ph: 'https://harbourline.ae' },
		markets: { label: 'Markets served', ph: 'Dubai, Abu Dhabi', fact: 'Markets' },
		licence: { label: 'Licence / registration', ph: 'RERA ORN 12345', fact: 'Licence' },
		summary: { ph: 'What the business does, for whom, and where.' },
	},
	groups: [
		{ key: 'projects', label: { developer: 'Projects', portal: 'Hubs', _: 'Areas' }, heading: { developer: 'Projects & communities', portal: 'Search hubs', _: 'Areas covered' },
			hint: { developer: 'One line per project or master community. Skip individual units.', portal: 'City and property-type hubs, not filtered searches.', _: 'Area or community pages, not listings.' },
			ph: [ 'Marina Heights', 'https://…/projects/marina-heights', 'Waterfront apartments, handover Q4 2027' ] },
		{ key: 'services', label: 'Services', heading: 'Services', hint: 'What the business does, and how fees or payment plans work.', ph: [ 'Payment plans', 'https://…/payment-plans', 'How instalments work, up to handover' ] },
		{ key: 'guides', label: 'Guides', heading: 'Guides & resources', hint: 'Evergreen pages buyers and tenants read before they enquire.', ph: [ 'Buying off-plan in Dubai', 'https://…/guides/off-plan', 'Steps, fees, escrow, timelines' ] },
		{ key: 'trust', label: 'Trust', heading: 'Licensing, policies & contact', hint: 'Regulator licence, escrow, privacy and office contact pages.', ph: [ 'Licence & regulation', 'https://…/licence', 'RERA registration and escrow details' ] },
	],
	urlRules: [ { re: /\/(listing|listings|property|unit|units)\/[^/]*\d{3,}/i, msg: 'This looks like a single listing. Link the project or area page instead.' } ],
	superlatives: /\b(luxurious|luxury|iconic|prestigious)\b/i,
	descRules: [ { re: /\b(aed|usd|price[ds]?|from \d|per sq|yields?|roi)\b|\$|\d{2,3},\d{3}/i, msg: 'Leave prices and yields out. They go stale and AI tools repeat them.' } ],
	example: {
		f: { type: 'developer', name: 'Harbourline Properties', site: 'https://harbourline.ae', markets: 'Dubai, Abu Dhabi', licence: 'RERA ORN 12345', summary: 'Harbourline Properties is a Dubai developer of waterfront residential communities, selling off-plan and ready homes to end users and investors.' },
		rows: {
			projects: [
				{ t: 'Marina Heights', u: 'https://harbourline.ae/projects/marina-heights', n: 'Waterfront apartments, handover Q4 2027' },
				{ t: 'Palm Grove Villas', u: 'https://harbourline.ae/projects/palm-grove', n: 'Townhouses and villas, ready to move in' },
				{ t: 'Creekside Residences', u: 'https://harbourline.ae/projects/creekside', n: 'Off-plan apartments near Dubai Creek' },
			],
			services: [
				{ t: 'Payment plans', u: 'https://harbourline.ae/payment-plans', n: 'How instalments work, up to handover' },
				{ t: 'After-sales & handover', u: 'https://harbourline.ae/handover', n: 'Snagging, keys and service charges' },
			],
			guides: [
				{ t: 'Buying off-plan in Dubai', u: 'https://harbourline.ae/guides/off-plan', n: 'Steps, fees, escrow and timelines' },
				{ t: 'Golden Visa through property', u: 'https://harbourline.ae/guides/golden-visa', n: 'Eligibility and process' },
			],
			trust: [
				{ t: 'Licence & escrow', u: 'https://harbourline.ae/licence', n: 'RERA registration and escrow accounts' },
				{ t: 'Contact', u: 'https://harbourline.ae/contact', n: 'Sales centre and office hours' },
			],
		},
	},
};
