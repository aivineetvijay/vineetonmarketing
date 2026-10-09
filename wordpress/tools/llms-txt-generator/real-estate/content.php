<?php
/** Page copy for the Real Estate llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'Real estate',
	'h1'   => 'Free llms.txt generator for real estate websites.',
	'lead' => 'For developers, brokerages, agencies and portals. Map your projects, areas and compliance pages so AI assistants describe the business accurately.',
	'why'  => array(
		'h2'    => 'Why real estate websites need an llms.txt file.',
		'intro' => 'Buyers, tenants and investors now ask AI assistants which developer to trust, which community suits a family, or how off-plan payment plans work. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Property sites are hard for machines to read.', 'Thousands of listing pages, filtered search URLs and map-based search tools bury the pages that actually explain the business. llms.txt points straight to them: projects, communities, services and licensing.' ),
			array( 'Accurate answers about projects and areas.', 'A curated list of project and community pages helps AI tools describe what is being built, where, and for whom, instead of guessing from third-party portals or old press releases.' ),
			array( 'Trust signals in one place.', 'Real estate is a regulated, high-value purchase. Linking licence, escrow and policy pages makes it easier for assistants to confirm the business is legitimate before recommending it.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a project launches or hands over.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What a property site should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain the business. For real estate, that means stable pages: projects, areas, services and licensing. Not listings.',
		'types' => array(
			array( 'Developers', 'Project pages, master communities, payment plan explainers, handover and escrow information.' ),
			array( 'Brokerages', 'Areas covered, buying and renting services, the team page and the regulator licence.' ),
			array( 'Agencies', 'Property management, valuation and leasing services, landlord guides and fee policies.' ),
			array( 'Portals', 'Search hubs by city and type, area guides, market reports and listing policies.' ),
		),
		'include' => array( 'Project and community pages', 'Area and buying guides', 'Services and how fees work', 'Licence, regulator and escrow pages', 'Contact and office locations' ),
		'leave'   => array( 'Individual listings and unit pages', 'Prices, yields and availability', 'Agent mobile numbers', 'Filtered search URLs', 'Expired launch or campaign pages' ),
		'bp_h3'   => 'Best practices for real estate websites.',
		'bp'      => array(
			array( 'Link stable pages, not listings.', 'Project, community and area pages last for years. Listings expire in weeks and leave AI tools quoting units that are already sold.' ),
			array( 'Describe each page in one plain line.', 'State what it is, where it is and the status: "Waterfront apartments in Dubai Marina, handover Q4 2027." Skip slogans like "luxury redefined".' ),
			array( 'Use the names buyers search for.', 'Match community and area names to common usage, e.g. "Jumeirah Village Circle (JVC)", so assistants connect the page to the question.' ),
			array( 'Put licensing on the record.', 'Include the regulator, licence or ORN number, and escrow details on a dedicated page, and link it in the file.' ),
			array( 'Keep linked pages crawlable.', 'Key facts should be in the page text, not only in PDFs, brochures, images or map widgets that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'RealEstateAgent or Organization schema, plus address and FAQ markup, back up what the file says.' ),
			array( 'Cover each language separately.', 'For English and Arabic sites, list both versions of key pages, or keep a separate section for each language.' ),
			array( 'Update on milestones.', 'Revise the file when a project launches, sells out or hands over, and review it every quarter.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for a real estate website?', 'A plain Markdown file at the site root that lists the pages best describing the business: projects, areas, services and licensing. AI assistants can read it to understand the site without crawling every listing.' ),
		array( 'Should a portal list every property?', 'No. Listings change daily. Link the city, community and property-type hubs instead, and let those pages lead to live inventory.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it makes the business description consistent wherever it is read.' ),
		array( 'Where is the file uploaded on WordPress?', 'In the root folder, next to wp-config.php, using the host’s file manager or SFTP. Some SEO plugins can also serve it. It should open at yoursite.com/llms.txt.' ),
		array( 'How often should it be updated?', 'Every quarter, and whenever a project launches, sells out or hands over.' ),
	),
);
