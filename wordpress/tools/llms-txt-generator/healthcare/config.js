/* llms.txt generator: Healthcare. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'healthcare', label: 'healthcare', where: 'in',
	shareWith: 'someone who manages a hospital or clinic website', reviewWhen: 'or whenever a department, doctor or location changes',
	typeLabel: 'Organisation type',
	types: [
		[ 'hospital', 'Hospital', 'hospital', 'Hospital' ],
		[ 'clinic', 'Clinic', 'clinic', 'Clinic' ],
		[ 'specialist', 'Specialist practice', 'specialist practice', 'Specialist practice' ],
		[ 'diagnostic', 'Diagnostic centre', 'diagnostic centre', 'Diagnostic centre' ],
		[ 'telehealth', 'Telehealth', 'telehealth provider', 'Telehealth provider' ],
		[ 'pharmacy', 'Pharmacy', 'pharmacy', 'Pharmacy' ],
	],
	fields: {
		name: { label: 'Organisation name', ph: 'Al Noor Specialty Hospital' },
		site: { label: 'Website', ph: 'https://alnoor.ae' },
		markets: { label: 'Locations', ph: 'Abu Dhabi, Al Ain', fact: 'Locations' },
		licence: { label: 'Accreditation / licence', ph: 'JCI accredited · DOH licence MF1234', fact: 'Accreditation' },
		summary: { ph: 'What kind of provider it is, where, and its main specialties.' },
	},
	groups: [
		{ key: 'specialties', label: 'Specialties', heading: 'Specialties & services', hint: 'Departments, specialties and services, plus condition and treatment pages.', ph: [ 'Cardiology', 'https://…/specialties/cardiology', 'Diagnostics, interventional cardiology and rehabilitation' ] },
		{ key: 'doctors', label: 'Doctors', heading: 'Doctors & locations', hint: 'The doctor directory, key profiles (30 doctors or fewer) and each hospital or clinic.', ph: [ 'Find a doctor', 'https://…/doctors', 'Directory by specialty, language and location' ] },
		{ key: 'patients', label: 'Patients', heading: 'Patients & visitors', hint: 'Booking, insurance, preparing for a visit and patient guides. No prices.', ph: [ 'Insurance accepted', 'https://…/insurance', 'Insurance providers accepted at each location' ] },
		{ key: 'trust', label: 'Trust', heading: 'Accreditation, policies & contact', hint: 'Accreditation, licensing, patient rights, privacy, emergency and contact pages.', ph: [ 'Accreditation', 'https://…/accreditation', 'JCI accreditation and DOH licence details' ] },
	],
	urlRules: [
		{ re: /\/(book|booking|appointments?)\/.+(slot|time|step|confirm|select)/i, hard: true, msg: 'Booking steps are left out. Link the first booking page instead.' },
		{ re: /\/(patient-portal|portal|myhealth|my-health)(\/|$)/i, hard: true, msg: 'Patient portal pages are left out.' },
		{ re: /\/(offer|offers|promo|promotion|campaign)(\/|-|$)/i, msg: 'Time-limited offers are usually left out.' },
	],
	superlatives: /\b(top|renowned|state[- ]of[- ]the[- ]art|cutting[- ]edge|trusted)\b/i,
	descRules: [
		{ re: /\b(cures?d?|guarantee[sd]?|painless|pain[- ]free|risk[- ]free|success(ful)? rates?|recovery time|miracle|proven)\b/i, msg: 'Describe the care, not outcomes or guarantees.' },
		{ re: /\b(aed|usd|sar)\b|\$|\b\d+\s?%|\bwait(ing)? times?\b|\bpackage price/i, msg: 'Leave prices, waiting times and success figures out.' },
		{ re: /\b(\d+\+?\s?years'? (of )?experience|patients treated|5[- ]star|rated)\b/i, msg: 'Doctor entries: name, title, specialty and location only.' },
	],
	example: {
		f: { type: 'hospital', name: 'Al Noor Specialty Hospital', site: 'https://alnoor.ae', markets: 'Abu Dhabi, Al Ain', licence: 'JCI accredited · DOH licensed', summary: 'Al Noor Specialty Hospital is a multi-specialty hospital in Abu Dhabi with outpatient clinics in Al Ain, providing inpatient, outpatient and emergency care for adults and children.' },
		rows: {
			specialties: [
				{ t: 'Cardiology', u: 'https://alnoor.ae/specialties/cardiology', n: 'Diagnostics, interventional cardiology and cardiac rehabilitation' },
				{ t: 'Orthopaedics', u: 'https://alnoor.ae/specialties/orthopaedics', n: 'Joint replacement, sports injuries and spine care' },
				{ t: 'Knee replacement', u: 'https://alnoor.ae/treatments/knee-replacement', n: 'What the procedure involves and how to prepare' },
			],
			doctors: [
				{ t: 'Find a doctor', u: 'https://alnoor.ae/doctors', n: 'Directory by specialty, language and location' },
				{ t: 'Abu Dhabi hospital', u: 'https://alnoor.ae/locations/abu-dhabi', n: 'Main hospital with emergency department and inpatient wards' },
			],
			patients: [
				{ t: 'Insurance accepted', u: 'https://alnoor.ae/insurance', n: 'Insurance providers and networks accepted at each location' },
				{ t: 'Book an appointment', u: 'https://alnoor.ae/appointments', n: 'Online, phone and walk-in options' },
			],
			trust: [
				{ t: 'Accreditation & licensing', u: 'https://alnoor.ae/accreditation', n: 'JCI accreditation and DOH licence details' },
				{ t: 'Emergency care', u: 'https://alnoor.ae/emergency', n: 'Location and access to the 24-hour emergency department' },
			],
		},
	},
};
