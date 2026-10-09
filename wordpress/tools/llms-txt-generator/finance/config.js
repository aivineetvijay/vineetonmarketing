/* llms.txt generator: Finance & Fintech. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'finance', label: 'finance and fintech', where: 'in',
	shareWith: 'someone who manages a bank or fintech website', reviewWhen: 'or whenever a product, licence or set of terms changes',
	typeLabel: 'Company type',
	types: [
		[ 'bank', 'Bank', 'bank', 'Bank' ],
		[ 'digital_bank', 'Digital bank', 'digital bank', 'Digital bank' ],
		[ 'payments', 'Payments', 'payments company', 'Payments company' ],
		[ 'lending', 'Lending', 'lending company', 'Lending company' ],
		[ 'insurance', 'Insurance', 'insurance company', 'Insurance company' ],
		[ 'investment', 'Investment', 'investment firm', 'Investment and wealth firm' ],
	],
	fields: {
		name: { label: 'Company name', ph: 'Falcon Pay' },
		site: { label: 'Website', ph: 'https://falconpay.ae' },
		markets: { label: 'Markets / jurisdictions', ph: 'UAE', fact: 'Markets' },
		licence: { label: 'Regulator and licence', ph: 'Licensed by the Central Bank of the UAE', fact: 'Regulation' },
		summary: { ph: 'What the company is, its main products, who it serves and where it is licensed.' },
	},
	groups: [
		{ key: 'regulation', label: 'Regulation', heading: 'Regulation & licensing', hint: 'Regulatory status, licences, deposit or investor protection and complaints.', ph: [ 'Regulatory information', 'https://…/regulation', 'Licensing status and complaints process' ] },
		{ key: 'products', label: 'Products', heading: 'Products', hint: 'Product hubs and product pages. Describe them; never quote rates.', ph: [ 'Business account', 'https://…/business-account', 'Multi-currency account for SMEs and how to open one' ] },
		{ key: 'help', label: 'Help', heading: 'Fees, security & help', hint: 'The fees page (described, not quoted), developer docs, security and fraud guidance, help centre.', ph: [ 'Report fraud', 'https://…/security/report-fraud', 'How to report suspicious activity' ] },
		{ key: 'legal', label: 'Legal', heading: 'Contact & legal', hint: 'Contact, terms, privacy and risk disclosures.', ph: [ 'Terms & conditions', 'https://…/legal/terms', 'Terms governing accounts and payment services' ] },
	],
	urlRules: [
		{ re: /(online-?banking|netbanking|ibanking|\/onboarding|\/apply\/.+|\/dashboard|\/transfers?\/.+)/i, hard: true, msg: 'Login, onboarding and transaction flows are left out.' },
		{ re: /(\/quotes?\/|ticker|live-rates?|market-data)/i, msg: 'Live rate and quote pages change daily. Usually left out.' },
		{ re: /(promo|cashback|referral|campaign|limited-time)/i, msg: 'Promotional pages are left out unless permanent.' },
	],
	superlatives: /\b(lowest|cheapest|top)\b/i,
	descRules: [
		{ re: /\b\d+(\.\d+)?\s?%|\b(apr|apy|aer)\b|\b(aed|usd|sar)\b|\$|\bzero fees?\b|\bno fees?\b/i, msg: 'Leave rates, fees, returns and limits out. Describe the page.' },
		{ re: /\b(free|instant(ly)?|guaranteed|risk[- ]free|safe returns?|hassle[- ]free|cashback)\b/i, msg: 'Keep it neutral. No promotional words.' },
		{ re: /\b(you should|we recommend|grow your (money|wealth|savings)|high returns|beat inflation)\b/i, msg: 'Remove advice or outcome language.' },
	],
	example: {
		f: { type: 'payments', name: 'Falcon Pay', site: 'https://falconpay.ae', markets: 'UAE', licence: 'Licensed by the Central Bank of the UAE as a retail payment service provider', summary: 'Falcon Pay is a payments company in the UAE providing business accounts, card acceptance and cross-border payouts for SMEs and online merchants.' },
		rows: {
			regulation: [
				{ t: 'Regulatory information', u: 'https://falconpay.ae/regulation', n: 'Licensing status, safeguarding of funds and complaints process' },
			],
			products: [
				{ t: 'Business account', u: 'https://falconpay.ae/business-account', n: 'Multi-currency account for SMEs, eligibility and how to open one' },
				{ t: 'Card acceptance', u: 'https://falconpay.ae/accept-payments', n: 'In-store and online card acceptance for merchants' },
				{ t: 'Cross-border payouts', u: 'https://falconpay.ae/payouts', n: 'Paying suppliers and staff abroad, supported currencies' },
			],
			help: [
				{ t: 'Pricing', u: 'https://falconpay.ae/pricing', n: 'Fee schedule for accounts, card processing and payouts' },
				{ t: 'API documentation', u: 'https://docs.falconpay.ae', n: 'Payments, payouts and webhooks APIs, with sandbox setup' },
				{ t: 'Report fraud', u: 'https://falconpay.ae/security/report-fraud', n: 'How to report suspicious activity' },
			],
			legal: [
				{ t: 'Contact', u: 'https://falconpay.ae/contact', n: 'Sales and support contact options and service hours' },
				{ t: 'Terms & conditions', u: 'https://falconpay.ae/legal/terms', n: 'Terms governing business accounts and payment services' },
			],
		},
	},
};
