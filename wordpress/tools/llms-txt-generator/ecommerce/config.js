/* llms.txt generator: E-commerce. D2C brands, multi-brand retailers, marketplaces and subscription stores. */
window.VVLLMS = {
	slug: 'ecommerce',
	step1: 'Store',
	nameLabel: 'Store or brand name', namePh: 'Saffa Athletics',
	typeLabel: 'Store type',
	types: [
		[ 'd2c_brand', 'D2C brand', 'direct-to-consumer brand' ],
		[ 'multi_brand_retailer', 'Multi-brand retailer', 'multi-brand retailer' ],
		[ 'marketplace', 'Marketplace', 'online marketplace' ],
		[ 'subscription', 'Subscription', 'subscription brand' ],
		[ 'other', 'Other', 'online store' ],
	],
	fields: [
		{ key: 'sells', label: 'What it sells', ph: 'running shoes, training apparel and accessories' },
		{ key: 'shipsTo', label: 'Ships to (markets)', ph: 'UAE, Saudi Arabia, Kuwait' },
		{ key: 'stores', label: 'Physical stores (optional)', ph: 'two stores in Dubai' },
	],
	licenceLabel: 'Certifications', licencePh: 'Certified B Corporation',
	factsPh: 'Currencies, store count, named awards — only verifiable facts.',
	sections: [
		[ 'about', 'About' ], [ 'categories', 'Shop by Category' ], [ 'collections', 'Collections & Brands' ], [ 'featured', 'Featured Products' ],
		[ 'guides', 'Buying Guides' ], [ 'shipping', 'Shipping, Returns & Payments' ], [ 'stores', 'Stores & Services' ], [ 'help', 'Help & Contact' ],
		[ 'legal', 'Legal' ], [ 'optional', 'Optional' ],
	],
	startSections: [ 'about', 'help' ],
	pagesHelp: 'Add category and collection pages, size and buying guides, and the shipping, returns and help pages shoppers ask about. Don’t list the catalogue: add at most 10 flagship products. Cart, account, filter and sale-campaign URLs are left out automatically.',
	urlRules: [
		{ re: /\/(filter|filters)\//i, hard: true, msg: 'Excluded: filtered or faceted URL.' },
		{ re: /(black-?friday|white-?friday|cyber-?monday|flash-?sale|clearance|\/sale(\/|$)|promo|coupon|voucher|discount-code)/i, msg: 'Time-limited sale and promo pages are left out unless they are permanent hubs.' },
		{ re: /\/(order|orders|track-order|order-tracking)\/.+/i, hard: true, msg: 'Excluded: order page.' },
	],
	superlatives: /\b(premium|must[- ]have|bestsellers?|hottest|trendy|shop now)\b/i,
	descRules: [
		{ re: /(AED|USD|EUR|GBP|INR|SAR|\$|€|£|₹)\s?\d|\b\d[\d,.]*\s?(aed|usd|sar)\b|\b\d+\s?%|% off|\bdiscount|\bsale\b|\bfree (shipping|delivery|returns)\b/i, msg: 'Leave out prices, discounts and shipping fees — they change often.' },
		{ re: /\b\d+[- ]?(day|days|hour|hours|hr)\b|\bnext[- ]day\b|\bsame[- ]day\b|\bover \d/i, msg: 'Point to the policy page instead of quoting delivery times or policy figures.' },
		{ re: /\b(eco[- ]friendly|organic|sustainable|non[- ]toxic|clinically proven|hypoallergenic)\b/i, msg: 'Use product claims only when they are formal certifications you’ve listed.' },
	],
	limits: [ { keys: [ 'featured' ], max: 10, msg: 'More than 10 featured products: keep only flagship, permanently stocked items.' } ],
	summary: function ( f, H, name ) {
		var t = H.type( f ), sells = f.sells.trim(), ships = H.list( f.shipsTo ), stores = f.stores.trim();
		var s = name + ' is ' + H.a( t ) + ' ' + t + ( sells ? ' selling ' + sells + ' online' : '' ) + '.';
		if ( ships.length ) { s += ' It ships to ' + H.joinAnd( H.places( ships ) ) + '.'; }
		if ( stores ) { s += ( ships.length ? ' It also has ' : ' It has ' ) + H.lcFirst( stores ).replace( /\.$/, '' ) + '.'; }
		return s;
	},
	facts: function ( f, H ) {
		var ships = H.list( f.shipsTo );
		return ships.length > 3 ? [ 'Ships to: ' + ships.join( ', ' ) ] : [];
	},
	langFact: 'Online store in ',
	example: {
		name: 'Saffa Athletics', url: 'https://saffa.example', type: 'd2c_brand', sells: 'running shoes, training apparel and accessories',
		shipsTo: 'UAE, Saudi Arabia, Kuwait, Qatar, Bahrain, Oman', stores: 'two stores in Dubai', lang: 'English', otherLangs: 'Arabic', founded: '2018',
		pages: [
			[ 'about', 'Our Story', 'https://saffa.example/about/', 'Brand background, design approach and the materials used across the range.' ],
			[ 'categories', 'Running Shoes | Saffa Athletics', 'https://saffa.example/running-shoes/', 'Road and trail running shoes for men and women, with fit and cushioning filters.' ],
			[ 'categories', 'Training Apparel', 'https://saffa.example/apparel/', 'Tops, shorts, leggings and outerwear for gym and outdoor training.' ],
			[ 'categories', 'Accessories', 'https://saffa.example/accessories/', 'Socks, bags, bottles and caps for running and training.' ],
			[ 'categories', 'Running shoes, size 42', 'https://saffa.example/running-shoes?size=42', '' ],
			[ 'collections', 'Trail Collection', 'https://saffa.example/collections/trail/', 'Trail running shoes and weather-resistant apparel for off-road running.' ],
			[ 'guides', 'Size Guide', 'https://saffa.example/size-guide/', 'Shoe and apparel size charts with instructions for measuring at home.' ],
			[ 'guides', 'How to Choose Running Shoes', 'https://saffa.example/guides/choosing-running-shoes/', 'Guide to cushioning, drop and fit for different running styles and surfaces.' ],
			[ 'shipping', 'Shipping & Delivery', 'https://saffa.example/shipping/', 'Delivery options, regions served and how order tracking works.' ],
			[ 'shipping', 'Returns & Exchanges', 'https://saffa.example/returns/', 'Return window, item condition requirements and how to start a return.' ],
			[ 'stores', 'Store Locator', 'https://saffa.example/stores/', 'Addresses and opening hours of the two Dubai stores.' ],
			[ 'help', 'Help Centre', 'https://saffa.example/help/', 'Answers on orders, payments, delivery and product care.' ],
			[ 'legal', 'Terms of Sale', 'https://saffa.example/terms/', 'Terms covering orders, payments, delivery and returns.' ],
			[ 'optional', 'Journal', 'https://saffa.example/journal/', 'Training tips, race guides and stories behind the products.' ],
			[ 'optional', 'العربية', 'https://saffa.example/ar/', 'Arabic version of the store.' ],
		],
	},
};
