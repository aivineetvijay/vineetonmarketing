<?php
/** Page copy for the Healthcare llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'Healthcare',
	'h1'   => 'Free llms.txt generator for healthcare websites.',
	'lead' => 'For hospitals, clinics, specialist practices and diagnostic centres. Map your specialties, doctors, locations and patient information so AI assistants describe your care accurately.',
	'why'  => array(
		'h2'    => 'Why healthcare websites need an llms.txt file.',
		'intro' => 'Patients now ask AI assistants which clinic treats a condition, which hospital accepts their insurance, or where to find a specialist nearby. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Hospital sites are hard for machines to read.', 'Doctor search filters, booking flows, patient portals and PDF brochures bury the pages that explain your care. llms.txt points straight to them: specialties, doctors, locations and patient guidance.' ),
			array( 'Accurate answers about care and access.', 'A curated list of specialty, location and insurance pages helps AI tools say what you treat, where and for whom, instead of relying on directories or outdated listings.' ),
			array( 'Trust signals in one place.', 'Healthcare is regulated and high-stakes. Linking accreditation, licensing and patient-rights pages makes it easier for assistants to confirm the provider is legitimate.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a department or clinic opens.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What a healthcare site should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain your care. For healthcare, that means stable pages: specialties, doctors, locations and patient information. Not booking flows or offers.',
		'types' => array(
			array( 'Hospitals', 'Departments and centres of excellence, the doctor directory, emergency care, insurance and visitor information.' ),
			array( 'Clinics', 'Services, the doctors who practise there, locations and opening hours, insurance accepted and how to book.' ),
			array( 'Specialist practices', 'Conditions treated, procedures, the specialists’ profiles, referral information and patient guides.' ),
			array( 'Diagnostic centres', 'Tests and scans offered, preparation guides, how results are shared, locations and accreditation.' ),
		),
		'include' => array( 'Specialty and department pages', 'Condition and treatment pages', 'Doctor directory and key profiles', 'Locations, insurance and booking pages', 'Accreditation, licensing and patient-rights pages' ),
		'leave'   => array( 'Outcome claims and success rates', 'Prices, packages and waiting times', 'Booking steps and patient portal pages', 'Filtered doctor search URLs', 'Time-limited offers and campaign pages' ),
		'bp_h3'   => 'Best practices for healthcare websites.',
		'bp'      => array(
			array( 'Describe care, not outcomes.', 'Say what a page covers: the specialty, the procedure, who it is for. Never imply cures, success rates or guaranteed results.' ),
			array( 'Keep doctor entries factual.', 'Name, title, specialty and location only. Leave out ratings, years of experience and "expert in" claims unless they are formal credentials.' ),
			array( 'Use the names patients search for.', 'Pair clinical and everyday terms, e.g. "Orthopaedics (bone and joint care)", so assistants connect the page to the question.' ),
			array( 'Put accreditation on the record.', 'Link a page that states licences and accreditations exactly as issued, such as DOH, DHA or JCI.' ),
			array( 'Get clinical sign-off.', 'Anything an assistant may repeat to a patient should be reviewed by a qualified clinician before it goes in the file.' ),
			array( 'Keep linked pages crawlable.', 'Key facts belong in the page text, not only in PDFs, images or booking widgets that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'MedicalOrganization, MedicalClinic and Physician schema, plus FAQ markup, back up what the file says.' ),
			array( 'Update when services change.', 'Revise the file when a department, doctor or location is added or closed, and review it every quarter.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for a healthcare website?', 'A plain Markdown file at the site root that lists the pages best describing your care: specialties, doctors, locations and patient information. AI assistants can read it to understand the provider without crawling every page.' ),
		array( 'Should every doctor profile be listed?', 'With 30 or fewer doctors, you can list their profiles with name, specialty and location. With more, link the doctor directory and department pages instead.' ),
		array( 'Can the file mention treatment results or prices?', 'No. Outcome claims, success rates, prices and waiting times change or can mislead. Point to the page that covers the topic and keep the description factual.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it keeps the description of your care consistent wherever it is read.' ),
		array( 'How often should it be updated?', 'Every quarter, and whenever a department, doctor or location is added or closed.' ),
	),
);
