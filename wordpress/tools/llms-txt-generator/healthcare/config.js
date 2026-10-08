/* llms.txt generator: Healthcare. Hospitals, clinics, specialist practices, diagnostic centres, telehealth, pharmacies. */
window.VVLLMS = {
	slug: 'healthcare',
	step1: 'Organisation',
	nameLabel: 'Organisation name', namePh: 'Al Noor Specialty Hospital',
	typeLabel: 'Organisation type',
	types: [
		[ 'hospital', 'Hospital', 'hospital' ],
		[ 'clinic', 'Clinic', 'clinic' ],
		[ 'specialist_practice', 'Specialist practice', 'specialist practice' ],
		[ 'diagnostic_centre', 'Diagnostic centre', 'diagnostic centre' ],
		[ 'telehealth', 'Telehealth', 'telehealth provider' ],
		[ 'pharmacy', 'Pharmacy', 'pharmacy' ],
		[ 'health_system', 'Health system', 'health system' ],
		[ 'other', 'Other', 'healthcare provider' ],
	],
	fields: [
		{ key: 'locations', label: 'Locations (cities / areas)', ph: 'Abu Dhabi, Al Ain' },
		{ key: 'specialties', label: 'Main specialties', ph: 'Cardiology, Orthopaedics, Paediatrics' },
	],
	licenceLabel: 'Accreditations / licence numbers', licencePh: 'Accredited by Joint Commission International',
	factsPh: 'Number of locations, named awards — only verifiable facts.',
	sections: [
		[ 'about', 'About' ], [ 'specialties', 'Specialties & Services' ], [ 'conditions', 'Conditions & Treatments' ], [ 'doctors', 'Doctors' ],
		[ 'locations', 'Locations' ], [ 'patients', 'Patients & Visitors' ], [ 'info', 'Health Information' ], [ 'contact', 'Contact' ],
		[ 'legal', 'Legal & Compliance' ], [ 'optional', 'Optional' ],
	],
	pagesHelp: 'Add hub and evergreen pages: about, specialties, conditions and treatments, the doctor directory, locations, insurance and appointment pages, contact. If you list 30 or fewer doctors you may add their profiles; otherwise add the directory only. Booking steps, portals and filter URLs are left out automatically.',
	urlRules: [
		{ re: /\/(book|booking|appointments?)\/.+(slot|time|step|confirm|select)/i, hard: true, msg: 'Excluded: appointment booking step. Link the first booking page instead.' },
		{ re: /\/(patient-portal|portal|myhealth|my-health)(\/|$)/i, hard: true, msg: 'Excluded: patient portal page.' },
		{ re: /\/(offer|offers|promo|promotion|campaign|packages?-offer)(\/|-|$)/i, msg: 'Time-limited offer pages are usually left out.' },
	],
	superlatives: /\b(top|renowned|expert care|state[- ]of[- ]the[- ]art|cutting[- ]edge|trusted)\b/i,
	descRules: [
		{ re: /\b(cures?d?|guarantee[sd]?|painless|pain[- ]free|risk[- ]free|safe(st)?|success(ful)? rates?|recovery time|miracle|permanent(ly)?|proven)\b/i, msg: 'Remove outcome or safety claims — describe what the page covers.' },
		{ re: /(AED|USD|EUR|GBP|INR|SAR|\$|€|£|₹)\s?\d|\b\d[\d,.]*\s?(aed|usd|sar)\b|\b\d+\s?%|\bwait(ing)? times?\b|\bbeds?\b.*\d|\d.*\bbeds?\b/i, msg: 'Leave out prices, waiting times, bed counts and success figures.' },
		{ re: /\b(\d+\+?\s?years'? (of )?experience|patients treated|5[- ]star|rated)\b/i, msg: 'Doctor entries: name, title, specialty and location only.' },
	],
	limits: [ { keys: [ 'doctors' ], max: 30, msg: 'More than 30 doctor entries: list the doctor directory and department pages instead of individual profiles.' } ],
	summary: function ( f, H, name ) {
		var t = H.type( f ), loc = H.list( f.locations ), sp = H.list( f.specialties );
		var s = name + ' is ' + H.a( t ) + ' ' + t + ( loc.length ? ' in ' + H.joinAnd( H.places( loc ) ) : '' ) + '.';
		if ( sp.length ) { s += ' Its main specialties are ' + H.joinAnd( sp ) + '.'; }
		return s;
	},
	facts: function ( f, H ) {
		var loc = H.list( f.locations );
		return loc.length > 1 ? [ 'Locations: ' + loc.join( ', ' ) ] : [];
	},
	langFact: 'Services and website available in ',
	example: {
		name: 'Al Noor Specialty Hospital', url: 'https://alnoor.example', type: 'hospital', locations: 'Abu Dhabi, Al Ain',
		specialties: 'Cardiology, Orthopaedics, Paediatrics, Emergency care', lang: 'English', otherLangs: 'Arabic',
		founded: '2009', licences: 'Accredited by Joint Commission International',
		pages: [
			[ 'about', 'About Us | Al Noor', 'https://alnoor.example/about/', 'History, leadership team and the hospital’s quality and patient safety programmes.' ],
			[ 'specialties', 'Cardiology', 'https://alnoor.example/specialties/cardiology/', 'Diagnostics, interventional cardiology and cardiac rehabilitation for adults.' ],
			[ 'specialties', 'Orthopaedics', 'https://alnoor.example/specialties/orthopaedics/', 'Joint replacement, sports injuries and spine care for adults and children.' ],
			[ 'specialties', 'Cardiology doctors', 'https://alnoor.example/doctors?specialty=cardiology', '' ],
			[ 'conditions', 'Knee Replacement Surgery', 'https://alnoor.example/treatments/knee-replacement/', 'What knee replacement involves, who it is for and how to prepare for surgery.' ],
			[ 'doctors', 'Find a Doctor', 'https://alnoor.example/doctors/', 'Directory of doctors searchable by specialty, language and location.' ],
			[ 'locations', 'Abu Dhabi Hospital', 'https://alnoor.example/locations/abu-dhabi/', 'Main hospital with emergency department, inpatient wards and outpatient clinics.' ],
			[ 'locations', 'Al Ain Clinic', 'https://alnoor.example/locations/al-ain/', 'Outpatient clinic in Al Ain offering family medicine, paediatrics and diagnostics.' ],
			[ 'patients', 'Insurance Accepted', 'https://alnoor.example/insurance/', 'List of insurance providers and networks accepted at each location.' ],
			[ 'patients', 'Book an Appointment', 'https://alnoor.example/appointments/', 'Online, phone and walk-in appointment options for outpatient clinics.' ],
			[ 'info', 'Health Library', 'https://alnoor.example/health-library/', 'Patient guides explaining common conditions, tests and procedures in plain language.' ],
			[ 'contact', 'Emergency Care', 'https://alnoor.example/emergency/', 'Location and access information for the 24-hour emergency department.' ],
			[ 'legal', 'Patient Rights and Responsibilities', 'https://alnoor.example/patient-rights/', 'Patient rights and responsibilities, the complaints procedure and how to give feedback.' ],
			[ 'optional', 'News', 'https://alnoor.example/news/', 'Hospital announcements and community health events.' ],
			[ 'optional', 'العربية', 'https://alnoor.example/ar/', 'Arabic version of the website.' ],
		],
	},
};
