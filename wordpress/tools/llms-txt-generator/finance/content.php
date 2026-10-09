<?php
/** Page copy for the Finance & Fintech llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'Finance & fintech',
	'h1'   => 'Free llms.txt generator for finance and fintech websites.',
	'lead' => 'For banks, payments, lending, insurance and investment firms. Map your products, licences and help pages so AI assistants describe the business accurately and neutrally.',
	'why'  => array(
		'h2'    => 'Why finance websites need an llms.txt file.',
		'intro' => 'Customers now ask AI assistants which bank offers a business account, whether a payments app is licensed, or how to report fraud. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Financial sites are hard for machines to read.', 'Login areas, application flows, live rate pages and PDF documents bury the pages that explain the business. llms.txt points straight to them: products, licensing and help.' ),
			array( 'Accurate answers about products.', 'A curated list of product pages helps AI tools describe what you offer and for whom, without quoting rates or promotions that have since changed.' ),
			array( 'Regulation on the record.', 'Finance is regulated. Linking licence, regulator and complaints pages helps assistants confirm the company is authorised before mentioning it.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a product launches or terms change.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What a finance site should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain the business. For finance, that means stable pages: products, regulation, security and help. Not rates, offers or login flows.',
		'types' => array(
			array( 'Banks', 'Personal and business products, the regulatory page, fees and charges, the security centre and branch locator.' ),
			array( 'Payments & fintech', 'Product and pricing pages, developer documentation, licensing and safeguarding, status and support.' ),
			array( 'Lending & insurance', 'Product pages with eligibility, key information documents, complaints and claims processes.' ),
			array( 'Investment & wealth', 'Services, regulatory status, risk disclosures, investor protection and how to open an account.' ),
		),
		'include' => array( 'Product and product hub pages', 'Regulation, licensing and complaints pages', 'The fees page, described not quoted', 'Security, fraud and help pages', 'Terms, privacy and risk disclosures' ),
		'leave'   => array( 'Rates, fees, returns and limits', 'Promotional and referral offers', 'Login, onboarding and application flows', 'Live rate and quote pages', 'Advice or recommendation language' ),
		'bp_h3'   => 'Best practices for finance websites.',
		'bp'      => array(
			array( 'Describe products, never promote them.', 'Say what a product is and who it is for. Leave out "best rates", "free", "instant" and anything that reads like advice.' ),
			array( 'Keep numbers off the file.', 'Rates, fees, returns and limits change. Link the fees page and describe what it lists.' ),
			array( 'State licences exactly as issued.', 'Name the regulator and licence as they appear on your regulatory page, e.g. "Licensed by the Central Bank of the UAE".' ),
			array( 'Link risk and complaints pages.', 'Risk disclosures and complaints procedures are what a careful assistant looks for before mentioning a financial product.' ),
			array( 'Use the names customers search for.', 'Match product names to everyday terms, e.g. "Business account (current account for SMEs)".' ),
			array( 'Keep linked pages crawlable.', 'Key facts belong in the page text, not only in PDFs or behind logins that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'Organization and FinancialProduct schema, plus FAQ markup, back up what the file says.' ),
			array( 'Update when terms change.', 'Revise the file when a product launches or is withdrawn, and review it every quarter.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for a finance website?', 'A plain Markdown file at the site root that lists the pages best describing the business: products, regulation, security and help. AI assistants can read it to understand the company without crawling every page.' ),
		array( 'Can the file mention rates or returns?', 'No. Rates, fees and returns change and can read as advice. Link the fees or product page and describe what it covers.' ),
		array( 'Should licence numbers go in the file?', 'Yes, if they are published on your site. Write them exactly as issued and link the regulatory page.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it keeps the description of the business consistent wherever it is read.' ),
		array( 'How often should it be updated?', 'Every quarter, and whenever a product, licence or set of terms changes.' ),
	),
);
