/* llms.txt generator: Real Estate. Developers, brokerages, agencies, portals and property managers. */
window.VVLLMS = {
	slug: 'real-estate',
	step1: 'Business',
	nameLabel: 'Business name', namePh: 'Palmera Bay Developments',
	typeLabel: 'Business type',
	types: [
		[ 'developer', 'Developer', 'residential property developer' ],
		[ 'brokerage', 'Brokerage', 'real estate brokerage' ],
		[ 'agency', 'Agency', 'real estate agency' ],
		[ 'portal', 'Property portal', 'property portal' ],
		[ 'property_manager', 'Property manager', 'property management company' ],
		[ 'other', 'Other', 'real estate business' ],
	],
	fields: [ { key: 'markets', label: 'Markets / cities', ph: 'Dubai Creek Harbour, Dubai South' } ],
	chips: { label: 'Property types', options: [ 'Residential', 'Commercial', 'Off-plan', 'Ready', 'Villas', 'Apartments', 'Townhouses', 'Land', 'Holiday homes' ] },
	licenceLabel: 'Licence / registration', licencePh: 'RERA ORN 12345',
	factsPh: 'Named awards, offices, completed units — only verifiable facts.',
	sections: [
		[ 'about', 'About' ], [ 'projects', 'Projects' ], [ 'sale', 'Properties for Sale' ], [ 'rent', 'Properties for Rent' ],
		[ 'areas', 'Communities & Areas' ], [ 'services', 'Services' ], [ 'guides', 'Buyer & Investor Guides' ], [ 'insights', 'Market Insights' ],
		[ 'contact', 'Contact' ], [ 'legal', 'Legal & Compliance' ], [ 'optional', 'Optional' ],
	],
	sectionOptionLabel: function ( key, label ) { return 'projects' === key ? 'Projects / Featured Developments' : label; },
	sectionLabel: function ( key, label, f ) { return 'projects' === key && 'developer' !== f.type ? 'Featured Developments' : label; },
	pagesHelp: 'Add hub and evergreen pages: about, projects, area guides, services, buyer guides, contact. Skip individual listings, filter URLs and login pages — they are left out automatically.',
	urlRules: [ { re: /\/(listing|listings|property|properties)\/[^/]+\/?.*\d{4,}/i, msg: 'Looks like an individual listing — link the index or category page instead.' } ],
	superlatives: /\b(luxurious|iconic|prestigious)\b/i,
	descRules: [ { re: /(AED|USD|EUR|GBP|INR|\$|€|£|₹)\s?\d|\b\d[\d,.]*\s?(aed|usd|million|mn|k)\b|\byields?\b|% off|\bdiscount|\boffer\b/i, msg: 'Avoid prices, yields or offers — they go stale.' } ],
	summary: function ( f, H, name ) {
		var lc = function ( a ) { return a.map( function ( x ) { return x.toLowerCase(); } ); };
		var pick = function ( list ) { return lc( f.chips.filter( function ( x ) { return list.indexOf( x ) > -1; } ) ); };
		var cats = pick( [ 'Residential', 'Commercial' ] ), units = pick( [ 'Villas', 'Apartments', 'Townhouses', 'Land', 'Holiday homes' ] ), status = pick( [ 'Off-plan', 'Ready' ] );
		var markets = H.list( f.markets ), t = H.type( f );
		var s = name + ' is ' + H.a( t ) + ' ' + t + ( markets.length ? ' operating in ' + H.joinAnd( H.places( markets ) ) : '' ) + '.';
		var verb = 'developer' === f.type ? 'builds' : 'property_manager' === f.type ? 'manages' : 'offers';
		var what = units.length ? ( cats.length ? H.joinAnd( cats ) + ' ' : '' ) + H.joinAnd( units ) : cats.length ? H.joinAnd( cats ) + ' property' : '';
		if ( what || status.length ) {
			s += ' It ' + verb + ' ' + ( what || 'property' ) + ( status.length ? ', including ' + H.joinAnd( status ) + ( 'developer' === f.type ? ' projects' : ' homes' ) : '' ) + '.';
		}
		return s;
	},
	facts: function ( f, H ) {
		var out = [], m = H.list( f.markets );
		if ( m.length ) { out.push( 'Markets: ' + m.join( ', ' ) ); }
		if ( f.chips.length ) { out.push( 'Property types: ' + f.chips.join( ', ' ) ); }
		return out;
	},
	example: {
		name: 'Palmera Bay Developments', url: 'https://palmerabay.example', type: 'developer', markets: 'Dubai Creek Harbour, Dubai South',
		lang: 'English', otherLangs: 'Arabic', chips: [ 'Residential', 'Off-plan', 'Ready', 'Apartments', 'Townhouses' ],
		founded: '2012', licences: 'Registered developer with the Dubai Land Department',
		pages: [
			[ 'about', 'About Palmera Bay', 'https://palmerabay.example/about/', 'Company background, leadership team and history of completed projects since 2012.' ],
			[ 'about', 'Sustainability', 'https://palmerabay.example/sustainability/', 'Approach to energy-efficient design and green building certification across projects.' ],
			[ 'projects', 'Creekside Residences | Palmera Bay', 'https://palmerabay.example/projects/creekside-residences/', 'Off-plan 1–3 bedroom apartments in Dubai Creek Harbour with waterfront promenade access.' ],
			[ 'projects', 'Sahara Gardens', 'https://palmerabay.example/projects/sahara-gardens/', 'Completed townhouse community in Dubai South with 3–4 bedroom family homes.' ],
			[ 'guides', 'How to Buy Off-Plan in Dubai', 'https://palmerabay.example/guides/buying-off-plan/', 'Step-by-step guide to off-plan purchases, escrow, payment plans and handover.' ],
			[ 'guides', 'Fees When Buying Property', 'https://palmerabay.example/guides/buying-fees/', 'Explanation of registration, agency and service charges payable by buyers.' ],
			[ 'contact', 'Contact Us', 'https://palmerabay.example/contact/', 'Sales enquiry form, phone, email and sales centre location.' ],
			[ 'sale', 'Apartments for sale', 'https://palmerabay.example/listings?beds=2&sort=price', '' ],
			[ 'optional', 'News', 'https://palmerabay.example/news/', 'Company announcements and project launch updates.' ],
			[ 'optional', 'العربية', 'https://palmerabay.example/ar/', 'Arabic version of the website.' ],
		],
	},
};
