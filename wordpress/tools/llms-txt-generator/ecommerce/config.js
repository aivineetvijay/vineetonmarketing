/* llms.txt generator: E-commerce. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'ecommerce', label: 'e-commerce', where: 'shipping to',
	shareWith: 'someone who runs an online store', reviewWhen: 'or whenever a category, collection or policy changes',
	typeLabel: 'Store type',
	types: [
		[ 'd2c', 'D2C brand', 'direct-to-consumer brand', 'Direct-to-consumer brand' ],
		[ 'retailer', 'Multi-brand retailer', 'multi-brand retailer', 'Multi-brand retailer' ],
		[ 'marketplace', 'Marketplace', 'online marketplace', 'Online marketplace' ],
		[ 'subscription', 'Subscription', 'subscription brand', 'Subscription brand' ],
	],
	fields: {
		name: { label: 'Store or brand name', ph: 'Saffa Athletics' },
		site: { label: 'Website', ph: 'https://saffa.ae' },
		markets: { label: 'Ships to', ph: 'UAE, Saudi Arabia, Kuwait', fact: 'Ships to' },
		licence: { label: 'Certifications', ph: 'Certified B Corporation', fact: 'Certifications' },
		summary: { ph: 'What the store sells, to whom, and where it ships.' },
	},
	groups: [
		{ key: 'categories', label: 'Categories', heading: 'Shop by category', hint: 'Top-level and main sub-category pages. Not filtered or sorted URLs.', ph: [ 'Running shoes', 'https://…/running-shoes', 'Road and trail running shoes for men and women' ] },
		{ key: 'collections', label: 'Collections', heading: { retailer: 'Collections & brands', marketplace: 'Collections & brands', _: 'Collections & featured products' }, hint: 'Permanent collections, brand pages and up to 10 flagship products.', ph: [ 'Trail collection', 'https://…/collections/trail', 'Trail shoes and weather-resistant apparel' ] },
		{ key: 'help', label: 'Help', heading: 'Guides, shipping & returns', hint: 'Size and buying guides, shipping, returns, payments and the help centre.', ph: [ 'Returns & exchanges', 'https://…/returns', 'Return window and how to start a return' ] },
		{ key: 'trust', label: 'Trust', heading: 'About, policies & contact', hint: 'Brand story, certifications, terms of sale, privacy, store locator and contact.', ph: [ 'Our story', 'https://…/about', 'Brand background and how products are made' ] },
	],
	urlRules: [
		{ re: /\/(filter|filters)\//i, hard: true, msg: 'Filtered category URLs are left out. Link the main category.' },
		{ re: /(black-?friday|white-?friday|cyber-?monday|flash-?sale|clearance|\/sale(\/|$)|promo|coupon|voucher)/i, msg: 'Sale and promo pages are left out unless they are permanent.' },
		{ re: /\/(products?|p)\/[^/]+-(xxs|xs|s|m|l|xl|xxl|\d{2,3}(ml|g)?)\/?$/i, msg: 'This looks like a product variant. Link the category or the main product page.' },
	],
	superlatives: /\b(premium|must[- ]have|bestsellers?|hottest|trendy|shop now)\b/i,
	descRules: [
		{ re: /\b(aed|usd|sar)\b|\$|\b\d+\s?%|% off|\bdiscount|\bsale\b|\bfree (shipping|delivery|returns)\b/i, msg: 'Leave prices, discounts and shipping fees out.' },
		{ re: /\b\d+[- ]?(day|days|hour|hours)\b|\bnext[- ]day\b|\bsame[- ]day\b/i, msg: 'Point to the policy page instead of quoting delivery times or return windows.' },
		{ re: /\b(eco[- ]friendly|organic|sustainable|non[- ]toxic|clinically proven)\b/i, msg: 'Use product claims only when they are formal certifications.' },
	],
	example: {
		f: { type: 'd2c', name: 'Saffa Athletics', site: 'https://saffa.ae', markets: 'UAE, Saudi Arabia, Kuwait, Qatar', licence: '', summary: 'Saffa Athletics is a direct-to-consumer sportswear brand selling running shoes, training apparel and accessories online, shipping across the GCC with two stores in Dubai.' },
		rows: {
			categories: [
				{ t: 'Running shoes', u: 'https://saffa.ae/running-shoes', n: 'Road and trail running shoes for men and women' },
				{ t: 'Training apparel', u: 'https://saffa.ae/apparel', n: 'Tops, shorts, leggings and outerwear for training' },
				{ t: 'Accessories', u: 'https://saffa.ae/accessories', n: 'Socks, bags, bottles and caps' },
			],
			collections: [
				{ t: 'Trail collection', u: 'https://saffa.ae/collections/trail', n: 'Trail shoes and weather-resistant apparel' },
			],
			help: [
				{ t: 'Size guide', u: 'https://saffa.ae/size-guide', n: 'Shoe and apparel size charts with measuring tips' },
				{ t: 'Shipping & delivery', u: 'https://saffa.ae/shipping', n: 'Delivery options, regions served and order tracking' },
				{ t: 'Returns & exchanges', u: 'https://saffa.ae/returns', n: 'Return window and how to start a return' },
			],
			trust: [
				{ t: 'Our story', u: 'https://saffa.ae/about', n: 'Brand background and the materials used across the range' },
				{ t: 'Store locator', u: 'https://saffa.ae/stores', n: 'Addresses and opening hours of the Dubai stores' },
			],
		},
	},
};
