/* llms.txt generator: Education. types: [key, chip, summary phrase, "Type:" line]. */
window.VVLLMS = {
	slug: 'education', label: 'education', where: 'in',
	shareWith: 'someone who manages a school or university website', reviewWhen: 'and at the start of each term or intake',
	typeLabel: 'Institution type',
	types: [
		[ 'university', 'University / college', 'university', 'University' ],
		[ 'school', 'School / nursery', 'school', 'School' ],
		[ 'training', 'Training institute', 'training institute', 'Training institute' ],
		[ 'platform', 'Learning platform', 'online learning platform', 'Online learning platform' ],
	],
	fields: {
		name: { label: 'Institution name', ph: 'Gulf Bridge University' },
		site: { label: 'Website', ph: 'https://gbu.ac.ae' },
		markets: { label: 'Campuses / delivery', ph: 'Dubai, online', fact: 'Campuses' },
		licence: { label: 'Accreditation / licensing', ph: 'Licensed by the CAA, UAE Ministry of Education', fact: 'Accreditation' },
		summary: { ph: 'What the institution is, what it teaches, and where.' },
	},
	groups: [
		{ key: 'programmes', label: { school: 'Curriculum', training: 'Courses', platform: 'Courses', _: 'Programmes' },
			heading: { school: 'Curriculum', training: 'Courses', platform: 'Courses', _: 'Programmes' },
			hint: 'Faculty or department hubs, the full catalogue and flagship programmes. More than 40? Add hubs plus up to 20 flagships.', ph: [ 'BSc Computer Science', 'https://…/programmes/computer-science', 'Four-year degree, full-time on the Dubai campus' ] },
		{ key: 'admissions', label: 'Admissions', heading: 'Admissions & fees', hint: 'How to apply, entry requirements, fees overview and scholarships. No figures or deadlines.', ph: [ 'How to apply', 'https://…/admissions/apply', 'Application steps and required documents' ] },
		{ key: 'life', label: 'Student life', heading: 'Student life & support', hint: 'Campus, facilities, housing, wellbeing, careers and parent information.', ph: [ 'Student services', 'https://…/student-services', 'Counselling, careers advice and housing support' ] },
		{ key: 'trust', label: 'Trust', heading: 'Accreditation, policies & contact', hint: 'Accreditation, inspection reports, policies and the admissions office.', ph: [ 'Accreditation', 'https://…/accreditation', 'CAA licensing and programme accreditation' ] },
	],
	urlRules: [
		{ re: /\/(lms|moodle|blackboard|canvas|intranet|portal|student-portal|myportal|sis)(\/|$)/i, hard: true, msg: 'Portal, LMS and intranet pages are left out.' },
		{ re: /\/(apply|application)\/.+(step|form|submit)/i, hard: true, msg: 'Application form steps are left out. Link How to apply instead.' },
		{ re: /\/(events?|open-days?)\/.+\d{4}/i, msg: 'Single dated events date quickly. Usually left out.' },
	],
	superlatives: /\b(top[- ]ranked|prestigious|dream|elite|renowned)\b/i,
	descRules: [
		{ re: /\b(aed|usd|sar)\b|\$|\b\d+\s?%|\bdeadline\b|\bacceptance rate\b|\bsalar(y|ies)\b/i, msg: 'Leave fees, deadlines and rates out. Point to the page.' },
		{ re: /\bguarantee[sd]?\b|\b(job|visa|placement)s? (guaranteed|assured)\b/i, msg: 'No outcome promises: jobs, visas, placements or pass rates.' },
	],
	example: {
		f: { type: 'university', name: 'Gulf Bridge University', site: 'https://gbu.ac.ae', markets: 'Dubai', licence: 'Licensed by the Commission for Academic Accreditation (CAA)', summary: 'Gulf Bridge University is a private university in Dubai offering undergraduate and postgraduate degrees in business, engineering and computing, taught in English.' },
		rows: {
			programmes: [
				{ t: 'Undergraduate programmes', u: 'https://gbu.ac.ae/undergraduate', n: 'Bachelor’s degrees in business, engineering and computing' },
				{ t: 'Postgraduate programmes', u: 'https://gbu.ac.ae/postgraduate', n: 'Master’s and MBA programmes, full-time and part-time' },
				{ t: 'BSc Computer Science', u: 'https://gbu.ac.ae/undergraduate/computer-science', n: 'Four-year degree with AI and cybersecurity specialisations' },
			],
			admissions: [
				{ t: 'How to apply', u: 'https://gbu.ac.ae/admissions/apply', n: 'Application steps, documents and admissions contacts' },
				{ t: 'Tuition fees', u: 'https://gbu.ac.ae/admissions/fees', n: 'Fees by programme, payment plans and refund policy' },
			],
			life: [
				{ t: 'Student services', u: 'https://gbu.ac.ae/student-life/services', n: 'Counselling, disability support, careers and housing' },
			],
			trust: [
				{ t: 'Accreditation', u: 'https://gbu.ac.ae/about/accreditation', n: 'CAA licensing and programme accreditation status' },
				{ t: 'Admissions office', u: 'https://gbu.ac.ae/contact/admissions', n: 'Phone, email and campus visit booking' },
			],
		},
	},
};
