<?php
/** Page copy for the E-commerce llms.txt generator (rendered by the vv-tools mu-plugin). */
return array(
	'nav'  => 'E-commerce',
	'h1'   => 'Free llms.txt generator for e-commerce websites.',
	'lead' => 'For D2C brands, retailers and marketplaces. Map your categories, guides and store policies so AI shopping assistants describe what you sell accurately.',
	'why'  => array(
		'h2'    => 'Why e-commerce websites need an llms.txt file.',
		'intro' => 'Shoppers now ask AI assistants where to buy a product, which brand ships to their country, or what a store’s return policy is. The answer is built from whatever the assistant can find and understand on the site.',
		'items' => array(
			array( 'Online stores are hard for machines to read.', 'Thousands of product variants, filtered category URLs and checkout pages bury the pages that explain the store. llms.txt points straight to them: categories, guides and policies.' ),
			array( 'Accurate answers about what you sell.', 'A curated list of category and collection pages helps AI tools describe your range and who it is for, instead of guessing from marketplaces or old reviews.' ),
			array( 'The policies shoppers ask about.', 'Shipping, returns and payment questions decide a purchase. Linking those pages helps assistants point shoppers to your own terms, not someone else’s summary.' ),
			array( 'Low effort, low risk.', 'It is one plain-text file at the site root. It does not change rankings, robots rules or the sitemap, and takes minutes to update when a category or policy changes.' ),
		),
	),
	'guide' => array(
		'h2'    => 'What an online store should include.',
		'intro' => 'llms.txt is a plain Markdown file at the site root. It gives AI assistants a short, curated map of the pages that explain the store. For e-commerce, that means stable pages: categories, collections, buying guides and policies. Not individual products or sale pages.',
		'types' => array(
			array( 'D2C brands', 'Category and collection pages, the brand story, size and care guides, shipping and returns.' ),
			array( 'Multi-brand retailers', 'Category hubs, brand pages, buying guides, the store locator and delivery information.' ),
			array( 'Marketplaces', 'Category hubs, seller information, buyer protection, shipping and returns policies.' ),
			array( 'Subscription brands', 'How the subscription works, plans overview, the range, pausing and cancelling, and delivery.' ),
		),
		'include' => array( 'Category and collection pages', 'Brand, sourcing and certification pages', 'Size, fit and buying guides', 'Shipping, returns and payment pages', 'Help centre and contact pages' ),
		'leave'   => array( 'Individual products and variants', 'Prices, discounts and stock levels', 'Cart, checkout and account pages', 'Filtered and sorted category URLs', 'Sale and promo-code pages' ),
		'bp_h3'   => 'Best practices for e-commerce websites.',
		'bp'      => array(
			array( 'Link categories, not products.', 'Category and collection pages stay live for years. Product pages sell out, change price and leave AI tools recommending items you no longer stock.' ),
			array( 'Describe each page in one plain line.', 'State what it holds and for whom: "Road and trail running shoes for men and women." Skip slogans like "must-have styles".' ),
			array( 'Use the names shoppers search for.', 'Match category names to everyday terms, e.g. "Trainers (sneakers)", so assistants connect the page to the question.' ),
			array( 'Point to policies, don’t quote them.', 'Link the returns and shipping pages instead of writing "30-day returns" in the file. The page is the source of truth.' ),
			array( 'Only claim what is certified.', 'Words like organic, sustainable or B Corp belong in the file only when they are formal certifications.' ),
			array( 'Keep linked pages crawlable.', 'Key facts belong in the page text, not only in images, carousels or apps that AI tools cannot read.' ),
			array( 'Match the rest of the site.', 'Every URL in llms.txt should be indexable, in the sitemap and use its canonical address. No redirects or noindexed pages.' ),
			array( 'Add structured data to key pages.', 'Organization, Product and BreadcrumbList schema, plus return-policy and shipping markup, back up what the file says.' ),
			array( 'Update with the range.', 'Revise the file when a category or collection is added or retired, and review it every quarter.' ),
		),
	),
	'faqs' => array(
		array( 'What is llms.txt for an e-commerce website?', 'A plain Markdown file at the site root that lists the pages best describing the store: categories, collections, guides and policies. AI assistants can read it to understand the store without crawling every product.' ),
		array( 'Should I list every product?', 'No. Products and variants change too often. Link category and collection pages, plus up to 10 flagship products that are permanently stocked.' ),
		array( 'Should prices or delivery times go in the file?', 'No. Prices, discounts and delivery times change often, and AI tools may repeat them as current. Link the pages that hold them instead.' ),
		array( 'Does llms.txt replace robots.txt or the sitemap?', 'No. robots.txt controls crawling and the sitemap lists every URL. llms.txt is a short, curated summary that sits alongside both.' ),
		array( 'Does it help with ChatGPT shopping, Perplexity or Google AI Overviews?', 'Support varies by platform and is still developing. It costs little to add, and it keeps the description of your store consistent wherever it is read.' ),
		array( 'How often should it be updated?', 'Every quarter, and whenever a category, collection or policy changes.' ),
	),
);
