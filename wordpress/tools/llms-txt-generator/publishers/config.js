/* llms.txt generator: Content & Publishers. News sites, magazines, digital and trade publishers, blogs, newsletters. */
window.VVLLMS = {
	slug: 'publishers',
	step1: 'Publication',
	nameLabel: 'Publication name', namePh: 'The Gulf Ledger',
	typeLabel: 'Publication type',
	types: [
		[ 'news', 'News outlet', 'news outlet' ],
		[ 'magazine', 'Magazine', 'magazine' ],
		[ 'digital_publisher', 'Digital publisher', 'digital publication' ],
		[ 'trade_publication', 'Trade publication', 'trade publication' ],
		[ 'blog', 'Blog', 'blog' ],
		[ 'newsletter', 'Newsletter', 'newsletter' ],
		[ 'content_network', 'Content network', 'content network' ],
		[ 'other', 'Other', 'publication' ],
	],
	fields: [
		{ key: 'topics', label: 'Coverage / topics', ph: 'markets, startups, policy' },
		{ key: 'region', label: 'Region / audience', ph: 'across the GCC' },
		{ key: 'frequency', label: 'Publishing frequency', ph: 'daily online, with a weekday newsletter' },
	],
	licenceLabel: 'Owner / standards memberships', licencePh: 'Member of the Independent Press Standards body',
	factsPh: 'Editions, parent company — only verifiable facts. No readership numbers unless you can source them.',
	sections: [
		[ 'about', 'About' ], [ 'standards', 'Editorial Standards' ], [ 'sections', 'Sections & Topics' ], [ 'evergreen', 'Evergreen Guides' ],
		[ 'flagship', 'Flagship Series & Investigations' ], [ 'authors', 'Authors & Contributors' ], [ 'formats', 'Formats' ],
		[ 'subscribe', 'Subscribe & Membership' ], [ 'contact', 'Contact' ], [ 'legal', 'Legal' ], [ 'optional', 'Optional' ],
	],
	startSections: [ 'about', 'standards', 'sections' ],
	pagesHelp: 'Map the publication, not the news: about and masthead, editorial standards (always include corrections and AI-use policies), section hubs, up to 30 evergreen guides or flagship series, the authors directory and up to 15 key editors, formats, subscriptions and contact. Dated articles, tag and date archives and sponsored posts are left out automatically.',
	urlRules: [
		{ re: /\/(19|20)\d{2}\/(0?[1-9]|1[0-2])(\/|$)/, hard: true, msg: 'Excluded: date archive or dated article URL.' },
		{ re: /\/(tag|tags)\//i, hard: true, msg: 'Excluded: tag page.' },
		{ re: /\/amp(\/|$)|\/print(\/|$)/i, hard: true, msg: 'Excluded: AMP or print duplicate.' },
		{ re: /\/(live|liveblog|live-blog|live-updates|breaking)(\/|-|$)/i, msg: 'Live blogs and breaking news date quickly — leave them out.' },
		{ re: /\/(sponsored|partner-content|advertorial|deals?|coupons?|giveaways?|contests?)(\/|$)/i, msg: 'Sponsored, deal and giveaway pages are left out.' },
	],
	superlatives: /\b(most trusted|award[- ]winning|must[- ]read|essential reading|definitive)\b/i,
	descRules: [
		{ re: /\b\d[\d,.]*\s?(million|m|k)?\s?(readers|subscribers|visitors|views|followers)\b/i, msg: 'Leave out readership, traffic and subscriber numbers.' },
		{ re: /\b(says|said|claims|reveals|warns|announced|according to)\b/i, msg: 'Describe what the page covers, not the claims or findings in it.' },
	],
	limits: [
		{ keys: [ 'evergreen', 'flagship' ], max: 30, msg: 'More than 30 evergreen and flagship items: keep only clearly durable explainers and named series.' },
		{ keys: [ 'authors' ], max: 15, msg: 'More than 15 author entries: keep the directory plus key editors and regular columnists.' },
	],
	summary: function ( f, H, name ) {
		var t = H.type( f ), topics = H.list( f.topics ), region = f.region.trim(), freq = f.frequency.trim();
		var s = name + ' is ' + H.a( t ) + ' ' + t + ( topics.length ? ' covering ' + H.joinAnd( topics ) : '' ) + ( region ? ' ' + region : '' ) + '.';
		if ( freq ) { s += ' It publishes ' + H.lcFirst( freq ).replace( /\.$/, '' ) + '.'; }
		return s;
	},
	langFact: 'Published in ',
	example: {
		name: 'The Gulf Ledger', url: 'https://gulfledger.example', type: 'digital_publisher', topics: 'markets, startups, policy', region: 'across the GCC',
		frequency: 'daily online, with a weekday morning newsletter', lang: 'English', founded: '2016',
		pages: [
			[ 'about', 'About Us', 'https://gulfledger.example/about/', 'Mission, ownership and history of the publication.' ],
			[ 'about', 'Masthead', 'https://gulfledger.example/masthead/', 'Editors, reporters and contributors with their beats.' ],
			[ 'standards', 'Editorial Policy', 'https://gulfledger.example/editorial-policy/', 'Sourcing, independence and conflict-of-interest rules for journalists.' ],
			[ 'standards', 'Corrections', 'https://gulfledger.example/corrections/', 'How errors are reported, reviewed and corrected.' ],
			[ 'standards', 'Use of AI', 'https://gulfledger.example/ai-policy/', 'How and where AI tools are used in reporting and production.' ],
			[ 'sections', 'Markets | The Gulf Ledger', 'https://gulfledger.example/markets/', 'Coverage of GCC stock exchanges, IPOs and listed companies.' ],
			[ 'sections', 'Startups', 'https://gulfledger.example/startups/', 'Startup, venture funding and technology policy news from the region.' ],
			[ 'sections', 'October markets news', 'https://gulfledger.example/2026/10/', '' ],
			[ 'evergreen', 'UAE Corporate Tax, Explained', 'https://gulfledger.example/guides/uae-corporate-tax-explained/', 'Who corporate tax applies to, key definitions and the main filing steps.' ],
			[ 'flagship', 'Gulf 100 Startups', 'https://gulfledger.example/gulf-100/', 'Annual list of GCC startups, with the selection methodology and past editions.' ],
			[ 'authors', 'Authors', 'https://gulfledger.example/authors/', 'Directory of the publication’s reporters, editors and columnists.' ],
			[ 'formats', 'Morning Brief Newsletter', 'https://gulfledger.example/newsletter/', 'Weekday email newsletter with the day’s main business stories.' ],
			[ 'subscribe', 'Subscribe', 'https://gulfledger.example/subscribe/', 'Subscription plans, group access and gift subscriptions.' ],
			[ 'contact', 'Send a Tip', 'https://gulfledger.example/tips/', 'Secure ways to share information with the newsroom.' ],
			[ 'legal', 'Terms of Use', 'https://gulfledger.example/terms/', 'Terms covering use of the website, newsletters and republishing.' ],
			[ 'optional', 'Careers', 'https://gulfledger.example/careers/', 'Open roles in the newsroom and business teams.' ],
		],
	},
};
