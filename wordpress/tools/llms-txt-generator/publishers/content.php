<?php
/** Page copy for the Content & Publishers llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'Publishers',
	'h1'   => 'Free llms.txt generator for publishers and content sites.',
	'lead' => 'For news sites, magazines, blogs and newsletters. Map your sections, standards and evergreen work so AI assistants describe the publication accurately.',
	'why'  => array(
		'h2'    => 'Why publishers need an llms.txt file.',
		'intro' => 'Readers now ask AI assistants which outlet covers a topic, who writes for it, or whether it corrects its mistakes. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Publishing sites are hard for machines to read.', 'Thousands of dated articles, tag pages and archives bury the pages that explain the publication. llms.txt points straight to them: sections, standards and evergreen work.' ),
			array( 'Accurate answers about your coverage.', 'A curated list of section and topic hubs helps AI tools describe what you cover and for whom, instead of judging you by a single old headline.' ),
			array( 'Standards on the record.', 'Linking editorial, corrections and AI-use policies helps assistants see how the publication works before quoting it.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a section or series launches.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What a publication should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain the publication. For publishers, that means stable pages: sections, editorial standards, evergreen guides and named series. Not the latest headlines.',
		'types' => array(
			array( 'News outlets', 'Section hubs, editorial standards, the corrections policy, the masthead and how to send a tip.' ),
			array( 'Magazines', 'Sections, flagship series and annual lists, the editorial team, subscriptions and the print edition.' ),
			array( 'Trade publications', 'Topic hubs, reference guides and reports, events, subscriptions and licensing.' ),
			array( 'Blogs & newsletters', 'Topic hubs, evergreen guides, the author page, the newsletter sign-up and archive.' ),
		),
		'include' => array( 'Section and topic hubs', 'Editorial, corrections and AI-use policies', 'Evergreen guides and named series', 'Masthead and author directory', 'Subscribe, newsletter and contact pages' ),
		'leave'   => array( 'Dated news and live blogs', 'Tag pages and date archives', 'Sponsored and advertorial posts', 'Readership or traffic numbers', 'Summaries of what articles claim' ),
		'bp_h3'   => 'Best practices for publishers.',
		'bp'      => array(
			array( 'Map the publication, not the news.', 'Section hubs and policies stay valid for years. Dated articles go stale and an assistant may repeat them as current.' ),
			array( 'Describe coverage, not claims.', 'Say what a page covers, e.g. "Coverage of GCC startups and venture funding", never what an article says.' ),
			array( 'Limit the evergreen list.', 'Keep at most 30 evergreen guides and flagship series, chosen because they stay accurate for a year or more.' ),
			array( 'Always link corrections and AI-use policies.', 'They are the clearest signal of how the newsroom works.' ),
			array( 'Keep author entries factual.', 'Name, role and beat only, for up to 15 key editors and columnists, plus the authors directory.' ),
			array( 'Keep linked pages crawlable.', 'Key pages should not sit behind the paywall or only in apps that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'NewsMediaOrganization and Person schema, plus publishing-principles markup, back up what the file says.' ),
			array( 'Update when the structure changes.', 'Revise the file when a section or series launches or closes, and review it every quarter.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for a publisher?', 'A plain Markdown file at the site root that lists the pages best describing the publication: sections, standards, evergreen work and how to subscribe. AI assistants can read it to understand the outlet without crawling every article.' ),
		array( 'Should recent articles be listed?', 'No. News dates quickly. List section hubs, standards and up to 30 evergreen guides or flagship series instead.' ),
		array( 'Should the file list every author?', 'Link the authors directory, plus up to 15 key editors and regular columnists with their role and beat.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it keeps the description of the publication consistent wherever it is read.' ),
		array( 'How often should it be updated?', 'Every quarter, and whenever a section, series or policy changes.' ),
	),
);
