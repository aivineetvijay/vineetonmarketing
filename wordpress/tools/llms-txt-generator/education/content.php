<?php
/** Page copy for the Education llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'Education',
	'h1'   => 'Free llms.txt generator for education websites.',
	'lead' => 'For universities, schools, training institutes and learning platforms. Map your programmes, admissions and accreditation so AI assistants describe what you teach accurately.',
	'why'  => array(
		'h2'    => 'Why education websites need an llms.txt file.',
		'intro' => 'Students and parents now ask AI assistants which university offers a course, how to apply, or whether a school is accredited. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Education sites are hard for machines to read.', 'Course search filters, application portals, event pages and PDF prospectuses bury the pages that explain the institution. llms.txt points straight to them: programmes, admissions and accreditation.' ),
			array( 'Accurate answers about programmes.', 'A curated list of faculty and programme pages helps AI tools describe what you teach, at what level and how, instead of guessing from rankings sites or old prospectuses.' ),
			array( 'Trust signals in one place.', 'Choosing a school or degree is a big decision. Linking accreditation, licensing and policy pages helps assistants confirm the institution is recognised.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a programme launches or an intake opens.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What an education site should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain the institution. For education, that means stable pages: programmes, admissions, student support and accreditation. Not single events or application portals.',
		'types' => array(
			array( 'Universities & colleges', 'Faculty and programme pages, admissions, fees and scholarships overviews, research centres and accreditation.' ),
			array( 'Schools & nurseries', 'Curriculum and phases, admissions, fees overview, inspection reports, transport, uniform and policies for families.' ),
			array( 'Training institutes', 'Course catalogue, certifications offered, delivery modes, enrolment steps and accreditation.' ),
			array( 'Learning platforms', 'Course and subject hubs, how learning works, plans overview, certificates and the learner help centre.' ),
		),
		'include' => array( 'Faculty, programme and course pages', 'Admissions, fees and scholarships pages', 'Accreditation and licensing pages', 'Student support and campus pages', 'Policies and contact pages' ),
		'leave'   => array( 'Fees, deadlines and intake dates', 'Rankings or outcomes without a source', 'Portal, LMS and application form pages', 'Filtered course search URLs', 'Single events and open-day dates' ),
		'bp_h3'   => 'Best practices for education websites.',
		'bp'      => array(
			array( 'Link programme hubs first.', 'Faculty and catalogue pages give the full picture. With more than 40 programmes, add the hubs plus up to 20 flagship programmes.' ),
			array( 'Describe each page in one plain line.', 'State the level, field and mode: "Four-year BSc in Computer Science, full-time on the Dubai campus." Skip slogans like "launch your dream career".' ),
			array( 'Use the names students search for.', 'Match programme names to common usage, e.g. "BSc Computer Science (Software Engineering)", so assistants connect the page to the question.' ),
			array( 'Put accreditation on the record.', 'Link a page that names licensing bodies and accreditations exactly as issued, such as CAA, KHDA or ADEK.' ),
			array( 'Point to fees, don’t quote them.', 'Fees, deadlines and intake dates change every year. Link the page that holds them.' ),
			array( 'Keep linked pages crawlable.', 'Key facts belong in the page text, not only in PDF prospectuses or portals that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'EducationalOrganization, Course and FAQ schema back up what the file says.' ),
			array( 'Update every intake.', 'Revise the file when programmes launch or close, and review it at the start of each term.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for an education website?', 'A plain Markdown file at the site root that lists the pages best describing the institution: programmes, admissions, student support and accreditation. AI assistants can read it to understand the site without crawling every page.' ),
		array( 'Should every course be listed?', 'With 40 or fewer programmes you can list them individually. With more, link the faculty and catalogue hubs plus up to 20 flagship programmes.' ),
		array( 'Should fees and deadlines go in the file?', 'No. They change every year, and AI tools may repeat old figures. Link the fees and admissions pages instead.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it keeps the description of the institution consistent wherever it is read.' ),
		array( 'How often should it be updated?', 'At the start of each term, and whenever a programme launches or closes.' ),
	),
);
