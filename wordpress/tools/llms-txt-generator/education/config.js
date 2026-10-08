/* llms.txt generator: Education. Universities, colleges, schools, nurseries, training institutes and learning platforms. */
window.VVLLMS = {
	slug: 'education',
	step1: 'Institution',
	nameLabel: 'Institution name', namePh: 'Gulf Bridge University',
	typeLabel: 'Institution type',
	types: [
		[ 'university', 'University', 'university' ],
		[ 'college', 'College', 'college' ],
		[ 'k12_school', 'K-12 school', 'school' ],
		[ 'nursery', 'Nursery', 'nursery' ],
		[ 'training_institute', 'Training institute', 'training institute' ],
		[ 'online_platform', 'Online learning platform', 'online learning platform' ],
		[ 'edtech', 'Edtech', 'education technology company' ],
		[ 'other', 'Other', 'education provider' ],
	],
	fields: [
		{ key: 'curriculum', label: 'Curriculum / main fields', ph: 'business, engineering, computing' },
		{ key: 'campuses', label: 'Campuses / delivery', ph: 'Dubai, online' },
	],
	licenceLabel: 'Accreditation / licensing', licencePh: 'Licensed by the Commission for Academic Accreditation (CAA)',
	factsPh: 'Named rankings with their source, curriculum authorisations — only verifiable facts.',
	sections: [
		[ 'about', 'About' ], [ 'programmes', 'Programmes' ], [ 'admissions', 'Admissions' ], [ 'life', 'Student Life' ],
		[ 'faculty', 'Faculty & Research' ], [ 'campuses', 'Campuses & Locations' ], [ 'parents', 'Parents & Students' ], [ 'contact', 'Contact' ],
		[ 'policies', 'Policies & Compliance' ], [ 'optional', 'Optional' ],
	],
	sectionOptionLabel: function ( key, label ) { return 'programmes' === key ? 'Programmes / Curriculum / Courses' : label; },
	sectionLabel: function ( key, label, f ) {
		if ( 'programmes' !== key ) { return label; }
		if ( 'k12_school' === f.type || 'nursery' === f.type ) { return 'Curriculum'; }
		if ( 'training_institute' === f.type || 'online_platform' === f.type || 'edtech' === f.type ) { return 'Courses'; }
		return 'Programmes';
	},
	pagesHelp: 'Add the about and accreditation pages, faculty or department hubs, the programme or course catalogue, admissions, fees and scholarship pages, student support and contact. With more than 40 programmes, add the hubs plus up to 20 flagship programmes. Portals, LMS pages and filtered course searches are left out automatically.',
	urlRules: [
		{ re: /\/(lms|moodle|blackboard|canvas|intranet|portal|student-portal|myportal|sis)(\/|$)/i, hard: true, msg: 'Excluded: portal, LMS or intranet page.' },
		{ re: /\/(apply|application)\/.+(step|form|submit)/i, hard: true, msg: 'Excluded: application form step. Link the How to Apply page instead.' },
		{ re: /\/(events?|open-days?)\/.+\d{4}/i, msg: 'Single dated events and open-day sessions date quickly — usually left out.' },
	],
	superlatives: /\b(top[- ]ranked|prestigious|dream|elite|renowned)\b/i,
	descRules: [
		{ re: /(AED|USD|EUR|GBP|INR|SAR|\$|€|£|₹)\s?\d|\b\d[\d,.]*\s?(aed|usd|sar)\b|\b\d+\s?%|\bdeadline\b|\bacceptance rate\b|\bsalar(y|ies)\b|\bintake (in|on)\b/i, msg: 'Leave out fees, deadlines, intake dates and rates — point to the page.' },
		{ re: /\bguarantee[sd]?\b|\b(job|visa|placement)s? (guaranteed|assured)\b|\b100% (pass|placement|employment)\b/i, msg: 'Remove outcome promises (jobs, visas, placements, pass rates).' },
	],
	limits: [ { keys: [ 'programmes' ], max: 40, msg: 'More than 40 programmes: list the hubs plus up to 20 flagship programmes.' } ],
	summary: function ( f, H, name ) {
		var t = H.type( f ), c = H.list( f.curriculum ), camp = H.list( f.campuses );
		var online = camp.some( function ( x ) { return /online|remote|virtual/i.test( x ); } );
		var places = camp.filter( function ( x ) { return ! /online|remote|virtual/i.test( x ); } );
		var s = name + ' is ' + H.a( t ) + ' ' + t + ( places.length ? ' based in ' + H.joinAnd( H.places( places ) ) : '' ) + '.';
		if ( c.length ) {
			if ( 'k12_school' === f.type || 'nursery' === f.type ) { s += ' It follows the ' + H.joinAnd( c ) + ' curriculum.'; }
			else if ( 'training_institute' === f.type || 'online_platform' === f.type || 'edtech' === f.type ) { s += ' It offers courses in ' + H.joinAnd( c ) + '.'; }
			else { s += ' It offers programmes in ' + H.joinAnd( c ) + '.'; }
		}
		if ( online ) { s += places.length ? ' Some learning is also delivered online.' : ' Learning is delivered online.'; }
		return s;
	},
	facts: function ( f, H ) {
		var camp = H.list( f.campuses );
		return camp.length > 1 ? [ 'Campuses and delivery: ' + camp.join( ', ' ) ] : [];
	},
	langFact: 'Taught and published in ',
	example: {
		name: 'Gulf Bridge University', url: 'https://gbu.example', type: 'university', curriculum: 'business, engineering, computing', campuses: 'Dubai',
		lang: 'English', founded: '2011', licences: 'Licensed by the Commission for Academic Accreditation (CAA), UAE Ministry of Education',
		pages: [
			[ 'about', 'About the University', 'https://gbu.example/about/', 'History, mission, leadership team and governance of the university.' ],
			[ 'about', 'Accreditation', 'https://gbu.example/about/accreditation/', 'Licensing and programme accreditation status issued by the UAE Ministry of Education.' ],
			[ 'programmes', 'Undergraduate Programmes', 'https://gbu.example/undergraduate/', 'Bachelor’s degrees in business, engineering and computing, taught full-time.' ],
			[ 'programmes', 'Postgraduate Programmes', 'https://gbu.example/postgraduate/', 'Master’s degrees and MBA programmes, offered full-time and part-time.' ],
			[ 'programmes', 'BSc Computer Science | GBU', 'https://gbu.example/undergraduate/computer-science/', 'Four-year degree with specialisations in AI and cybersecurity.' ],
			[ 'programmes', 'Online courses', 'https://gbu.example/programmes?level=ug&mode=online', '' ],
			[ 'admissions', 'How to Apply', 'https://gbu.example/admissions/apply/', 'Application steps, required documents and contacts for the admissions team.' ],
			[ 'admissions', 'Tuition Fees', 'https://gbu.example/admissions/fees/', 'Fees by programme, payment plans and the refund policy.' ],
			[ 'admissions', 'Scholarships', 'https://gbu.example/admissions/scholarships/', 'Merit and need-based scholarship types and eligibility criteria.' ],
			[ 'life', 'Student Services', 'https://gbu.example/student-life/services/', 'Counselling, disability support, careers advice and housing assistance.' ],
			[ 'faculty', 'Research Centres', 'https://gbu.example/research/', 'Research centres and labs in AI, sustainable engineering and business analytics.' ],
			[ 'contact', 'Admissions Office', 'https://gbu.example/contact/admissions/', 'Phone, email and campus visit booking for prospective students.' ],
			[ 'policies', 'Academic Integrity', 'https://gbu.example/policies/academic-integrity/', 'Rules on plagiarism and assessment conduct, and how integrity cases are handled.' ],
			[ 'optional', 'News', 'https://gbu.example/news/', 'University announcements, events and research news from each faculty.' ],
			[ 'optional', 'Alumni', 'https://gbu.example/alumni/', 'Alumni network, events and services for graduates.' ],
		],
	},
};
