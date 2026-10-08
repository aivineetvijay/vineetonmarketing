/* llms.txt generator: Finance & Fintech. Banks, payments, lending, insurance, investment, crypto, B2B fintech, exchange houses. */
window.VVLLMS = {
	slug: 'finance',
	step1: 'Company',
	nameLabel: 'Company or brand name', namePh: 'Falcon Pay',
	typeLabel: 'Company type',
	types: [
		[ 'bank', 'Bank', 'bank' ],
		[ 'digital_bank', 'Digital bank', 'digital bank' ],
		[ 'payments', 'Payments', 'payments company' ],
		[ 'lending', 'Lending', 'lending company' ],
		[ 'insurance', 'Insurance', 'insurance company' ],
		[ 'investment_brokerage', 'Investment / brokerage', 'investment and brokerage firm' ],
		[ 'wealth', 'Wealth management', 'wealth management firm' ],
		[ 'crypto', 'Crypto-asset services', 'crypto-asset service provider' ],
		[ 'b2b_fintech', 'B2B fintech', 'B2B fintech company' ],
		[ 'exchange_house', 'Exchange house', 'exchange house' ],
		[ 'other', 'Other', 'financial services company' ],
	],
	fields: [
		{ key: 'markets', label: 'Markets / jurisdictions', ph: 'UAE' },
		{ key: 'products', label: 'Main products', ph: 'business accounts, card acceptance, cross-border payouts' },
	],
	chips: { label: 'Customer segments', options: [ 'Retail', 'SME', 'Corporate', 'Developers' ] },
	licenceLabel: 'Regulators and licence numbers', licencePh: 'Licensed by the Central Bank of the UAE as a retail payment service provider',
	factsPh: 'Parent company, protection scheme membership — only verifiable facts, exactly as stated.',
	sections: [
		[ 'about', 'About' ], [ 'regulation', 'Regulation & Licensing' ], [ 'products', 'Products' ], [ 'personal', 'Personal' ], [ 'business', 'Business' ],
		[ 'corporate', 'Corporate' ], [ 'pricing', 'Pricing & Fees' ], [ 'developers', 'For Developers' ], [ 'security', 'Security & Trust' ],
		[ 'help', 'Help & Guides' ], [ 'contact', 'Contact' ], [ 'legal', 'Legal' ], [ 'optional', 'Optional' ],
	],
	sectionOptionLabel: function ( key, label ) { return { products: 'Products', personal: 'Products: Personal', business: 'Products: Business', corporate: 'Products: Corporate' }[ key ] || label; },
	startSections: [ 'about', 'regulation', 'contact' ],
	pagesHelp: 'Add the about and regulatory pages, product hubs and product pages, the fees page (described, never quoted), developer docs, security and fraud guidance, help and contact. Login, onboarding, live rates and promotional campaign pages are left out automatically.',
	urlRules: [
		{ re: /(online-?banking|netbanking|ibanking|\/onboarding|\/apply\/.+|\/dashboard|\/transfers?\/.+)/i, hard: true, msg: 'Excluded: login, onboarding or transaction flow.' },
		{ re: /(\/quotes?\/|ticker|live-rates?|market-data|stock-of-the-day)/i, msg: 'Live rate, quote and market data pages change daily — usually left out.' },
		{ re: /(promo|cashback|referral|campaign|limited-time)/i, msg: 'Promotional campaign pages are left out unless permanent.' },
	],
	superlatives: /\b(lowest|cheapest|top)\b/i,
	descRules: [
		{ re: /\b\d+(\.\d+)?\s?%|\b(apr|apy|aer)\b|(AED|USD|EUR|GBP|INR|SAR|\$|€|£|₹)\s?\d|\b\d[\d,.]*\s?(aed|usd|sar)\b|\bzero fees?\b|\bno fees?\b/i, msg: 'Leave out rates, fees, returns and limits — describe the page instead.' },
		{ re: /\b(free|instant(ly)?|guaranteed|risk[- ]free|safe returns?|hassle[- ]free|cashback)\b/i, msg: 'Remove promotional words — keep it neutral and factual.' },
		{ re: /\b(you should|we recommend|grow your (money|wealth|savings)|high returns|beat inflation|earn more)\b/i, msg: 'Remove advice or outcome language.' },
	],
	summary: function ( f, H, name ) {
		var t = H.type( f ), m = H.list( f.markets ), p = H.list( f.products );
		var seg = { Retail: 'individuals', SME: 'SMEs', Corporate: 'corporates', Developers: 'developers' };
		var who = f.chips.map( function ( x ) { return seg[ x ]; } ).filter( Boolean );
		return name + ' is ' + H.a( t ) + ' ' + t + ( m.length ? ' in ' + H.joinAnd( H.places( m ) ) : '' ) +
			( p.length ? ' providing ' + H.joinAnd( p ) : '' ) + ( who.length ? ' for ' + H.joinAnd( who ) : '' ) + '.';
	},
	facts: function ( f, H ) {
		var m = H.list( f.markets );
		return m.length > 1 ? [ 'Markets: ' + m.join( ', ' ) ] : [];
	},
	example: {
		name: 'Falcon Pay', url: 'https://falconpay.example', type: 'payments', markets: 'UAE', products: 'business accounts, card acceptance, cross-border payouts',
		chips: [ 'SME', 'Developers' ], lang: 'English', otherLangs: 'Arabic', founded: '2020',
		licences: 'Licensed by the Central Bank of the UAE as a retail payment service provider',
		pages: [
			[ 'about', 'About Falcon Pay', 'https://falconpay.example/about/', 'Company background, leadership team and ownership structure.' ],
			[ 'regulation', 'Regulatory Information', 'https://falconpay.example/regulation/', 'Licensing status, safeguarding of customer funds and the complaints process.' ],
			[ 'business', 'Business Account', 'https://falconpay.example/business-account/', 'Multi-currency account for SMEs, covering eligibility, required documents and how to open one.' ],
			[ 'business', 'Card Acceptance', 'https://falconpay.example/accept-payments/', 'In-store and online card acceptance for merchants, including supported card schemes.' ],
			[ 'business', 'Cross-border Payouts', 'https://falconpay.example/payouts/', 'Sending payments to suppliers and staff abroad, with supported currencies and corridors.' ],
			[ 'pricing', 'Pricing | Falcon Pay', 'https://falconpay.example/pricing/', 'Fee schedule for business accounts, card processing and payouts.' ],
			[ 'pricing', 'Live exchange rates', 'https://falconpay.example/rates?from=AED&to=USD', '' ],
			[ 'developers', 'API Documentation', 'https://docs.falconpay.example/', 'Reference for payments, payouts and webhooks APIs, with sandbox setup.' ],
			[ 'security', 'Report Fraud', 'https://falconpay.example/security/report-fraud/', 'How to report suspicious activity and what information to provide.' ],
			[ 'help', 'Help Centre', 'https://falconpay.example/help/', 'Guides on opening an account, accepting payments and managing payouts.' ],
			[ 'contact', 'Contact Us', 'https://falconpay.example/contact/', 'Sales and support contact options, with customer service hours.' ],
			[ 'legal', 'Terms & Conditions', 'https://falconpay.example/legal/terms/', 'Terms governing business accounts and payment services.' ],
			[ 'legal', 'Privacy Notice', 'https://falconpay.example/legal/privacy/', 'How customer and transaction data is collected, used and protected.' ],
			[ 'optional', 'Blog', 'https://falconpay.example/blog/', 'Articles on payments, cash flow and running an online business.' ],
		],
	},
};
