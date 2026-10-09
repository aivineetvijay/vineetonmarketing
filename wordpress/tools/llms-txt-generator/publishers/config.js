/* llms.txt generator: Content & Publishers. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'publishers', label: 'publishers and content', where: 'covering',
	shareWith: 'someone who runs a publication or newsletter', reviewWhen: 'or whenever a section, series or policy changes',
	typeLabel: 'Publication type',
	types: [
		[ 'news', 'News outlet', 'news outlet', 'News outlet' ],
		[ 'magazine', 'Magazine', 'magazine', 'Magazine' ],
		[ 'digital', 'Digital publisher', 'digital publication', 'Digital publisher' ],
		[ 'trade', 'Trade publication', 'trade publication', 'Trade publication' ],
		[ 'blog', 'Blog', 'blog', 'Blog' ],
		[ 'newsletter', 'Newsletter', 'newsletter', 'Newsletter' ],
	],
	fields: {
		name: { label: 'Publication name', ph: 'The Gulf Ledger' },
		site: { label: 'Website', ph: 'https://gulfledger.com' },
		markets: { label: 'Coverage / region', ph: 'Business news across the GCC', fact: 'Coverage' },
		licence: { label: 'Owner / standards body', ph: 'Member of the regional press standards body', fact: 'Standards' },
		summary: { ph: 'What the publication covers, for whom, and how often it publishes.' },
	},
	groups: [
		{ key: 'sections', label: 'Sections', heading: 'Sections & topics', hint: 'Main section and topic hubs. Not tag pages or date archives.', ph: [ 'Markets', 'https://…/markets', 'Coverage of GCC stock exchanges and listed companies' ] },
		{ key: 'standards', label: 'Standards', heading: 'Editorial standards', hint: 'Editorial policy, corrections, AI use, ownership and sponsored content policies.', ph: [ 'Corrections', 'https://…/corrections', 'How errors are reported and corrected' ] },
		{ key: 'evergreen', label: 'Evergreen', heading: 'Evergreen guides & series', hint: 'Up to 30 durable explainers, guides and named series. No dated news.', ph: [ 'UAE corporate tax, explained', 'https://…/guides/corporate-tax', 'Who it applies to and the main filing steps' ] },
		{ key: 'about', label: 'About', heading: 'About, subscribe & contact', hint: 'About, masthead, authors directory, newsletter, subscriptions and contact.', ph: [ 'Masthead', 'https://…/masthead', 'Editors and reporters with their beats' ] },
	],
	urlRules: [
		{ re: /\/(19|20)\d{2}\/(0?[1-9]|1[0-2])(\/|$)/, hard: true, msg: 'Dated articles and date archives are left out.' },
		{ re: /\/(tag|tags)\//i, hard: true, msg: 'Tag pages are left out.' },
		{ re: /\/amp(\/|$)|\/print(\/|$)/i, hard: true, msg: 'AMP and print duplicates are left out.' },
		{ re: /\/(live|liveblog|live-blog|live-updates|breaking)(\/|-|$)/i, msg: 'Live blogs and breaking news date quickly. Leave them out.' },
		{ re: /\/(sponsored|partner-content|advertorial|deals?|coupons?|giveaways?)(\/|$)/i, msg: 'Sponsored, deal and giveaway pages are left out.' },
	],
	superlatives: /\b(most trusted|award[- ]winning|must[- ]read|essential reading|definitive)\b/i,
	descRules: [
		{ re: /\b\d[\d,.]*\s?(million|m|k)?\s?(readers|subscribers|visitors|views|followers)\b/i, msg: 'Leave readership and traffic numbers out.' },
		{ re: /\b(says|said|claims|reveals|warns|announced)\b/i, msg: 'Describe what the page covers, not what an article claims.' },
	],
	example: {
		f: { type: 'digital', name: 'The Gulf Ledger', site: 'https://gulfledger.com', markets: 'Business news across the GCC', licence: '', summary: 'The Gulf Ledger is a digital business publication covering markets, startups and policy across the GCC, published daily online with a weekday morning newsletter.' },
		rows: {
			sections: [
				{ t: 'Markets', u: 'https://gulfledger.com/markets', n: 'Coverage of GCC stock exchanges, IPOs and listed companies' },
				{ t: 'Startups', u: 'https://gulfledger.com/startups', n: 'Startup, venture funding and technology policy news' },
			],
			standards: [
				{ t: 'Editorial policy', u: 'https://gulfledger.com/editorial-policy', n: 'Sourcing, independence and conflict-of-interest rules' },
				{ t: 'Corrections', u: 'https://gulfledger.com/corrections', n: 'How errors are reported, reviewed and corrected' },
				{ t: 'Use of AI', u: 'https://gulfledger.com/ai-policy', n: 'How AI tools are used in reporting and production' },
			],
			evergreen: [
				{ t: 'UAE corporate tax, explained', u: 'https://gulfledger.com/guides/uae-corporate-tax', n: 'Who it applies to, key definitions and filing steps' },
				{ t: 'Gulf 100 startups', u: 'https://gulfledger.com/gulf-100', n: 'Annual list with methodology and past editions' },
			],
			about: [
				{ t: 'Masthead', u: 'https://gulfledger.com/masthead', n: 'Editors, reporters and contributors with their beats' },
				{ t: 'Morning Brief newsletter', u: 'https://gulfledger.com/newsletter', n: 'Weekday email with the main business stories' },
			],
		},
	},
};
