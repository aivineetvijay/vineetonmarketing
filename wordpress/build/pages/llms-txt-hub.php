<?php
/**
 * llms.txt Generator hub (/ai-tools/llms-txt-generator/): one page for the family of industry-specific
 * llms.txt generators. Copy from "llms.txt Generator Hub Page Content" (8 October 2026). Built with the
 * site's existing section patterns and global classes; the generators themselves are standalone tools
 * served by the vv-tools mu-plugin under this path.
 */
$id = vv_new( 'llms.txt Generator', 'llms-txt-generator', 262 );

$tool = function ( $slug ) { return vv_url( '/ai-tools/llms-txt-generator/' . $slug . '/' ); };
$link = function ( $text, $href ) { return '<a href="' . esc_url( $href ) . '"><u>' . $text . '</u></a>'; };

/* Generators: industry, who it is for, tool slug (null = coming soon). */
$generators = array(
	array( 'Real Estate', 'Developers, brokerages, agencies and portals', 'real-estate' ),
	array( 'Healthcare', 'Hospitals, clinics and specialists', 'healthcare' ),
	array( 'E-commerce', 'D2C brands, retailers and marketplaces', 'ecommerce' ),
	array( 'Education', 'Universities, schools, institutes and learning platforms', 'education' ),
	array( 'Finance & Fintech', 'Banks, payments, lending, insurance and investment firms', 'finance' ),
	array( 'Content & Publishers', 'News sites, magazines, blogs and newsletters', 'publishers' ),
	array( 'Travel', 'Hotels, tour operators and travel agencies', null ),
	array( 'Small Business', 'Local services and SMBs', null ),
);
$live = count( array_filter( $generators, function ( $g ) { return $g[2]; } ) );

/* Generator cards: industry icon (SVG attachment llms-icon-<slug>, see assets/icons/llms/), status, audience. */
$icon = function ( $slug ) {
	$p = get_posts( array( 'post_type' => 'attachment', 'name' => 'llms-icon-' . $slug, 'post_status' => 'inherit', 'numberposts' => 1 ) );
	return $p ? $p[0]->ID : 0;
};
$cards = array(); $i = 0;
foreach ( $generators as $g ) {
	$i++;
	$live_card = (bool) $g[2];
	$key = $g[2] ?: sanitize_title( $g[0] );
	$kids = array(
		vv_f( "Generators Card $i Top", array( 'gen-top' ), array(
			vv_f( "Generators Card $i Icon Tile", array( 'gen-icon-tile' ), array( vv_n( 'e-svg', "Generators Card $i Icon", array( 'gen-icon' ), array( 'svg' => array( 'id' => $icon( $key ) ) ) ) ) ),
			vv_f( "Generators Card $i Status", array( 'gen-pill' ), array(
				vv_p( "Generators Card $i Status Dot", '●', $live_card ? array( 'status-dot' ) : array( 'status-dot-soon' ), 'span' ),
				vv_p( "Generators Card $i Status Label", $live_card ? 'Live' : 'Coming soon', array( 'status-label' ), 'span' ),
			) ),
		) ),
		vv_f( "Generators Card $i Body", array( 'gen-body' ), array(
			vv_h( "Generators Card $i Title", $g[0], array( 'tcard-name' ), 'h3' ),
			vv_p( "Generators Card $i For", $g[1], array( 'tcard-use' ) ),
		) ),
		vv_p( "Generators Card $i Action", $live_card ? 'Open generator →' : 'In development', array( $live_card ? 'gen-cta' : 'gen-cta-soon' ), 'span' ),
	);
	$cards[] = $live_card ? vv_link( "Generators Card $i", array( 'gen-card' ), $tool( $g[2] ), $kids ) : vv_f( "Generators Card $i", array( 'gen-card-soon' ), $kids );
}

$sample = array(
	'# Palmera Bay Developments',
	'',
	'> Residential developer in Dubai building waterfront apartments and townhouses for end-users and investors.',
	'',
	'## Projects',
	'- [Creekside Residences](https://…/creekside/): Off-plan 1–3 bedroom apartments in Dubai Creek Harbour.',
	'',
	'## Buyer guides',
	'- [Buying off-plan](https://…/off-plan/): Escrow, payment plans and handover, explained.',
	'',
	'## Contact',
	'- [Contact us](https://…/contact/): Sales centre, phone and enquiry form.',
);

$reasons = array(
	array( '01', 'Shape the summary.', 'AI answers describe your brand in a sentence or two. llms.txt gives you a say in which facts make it into that sentence.' ),
	array( '02', 'Point to the right pages.', 'Models choose sources quickly. A curated list steers them toward your service, product and guide pages instead of a three-year-old press release.' ),
	array( '03', 'Fewer wrong answers.', 'Clear, factual descriptions of what you offer and where you operate leave fewer gaps for a model to fill with guesses.' ),
	array( '04', 'Part of AEO and GEO.', 'It sits beside schema, crawlable content and source authority as one more signal in an AI-visibility programme. Not instead of them.' ),
	array( '05', 'Low effort, low risk.', 'One text file. No code changes, no effect on classic rankings. Minutes to deploy, seconds to update.' ),
	array( '06', 'A forcing function.', 'Writing one makes you decide which pages actually represent the business. Most sites have never done that exercise.' ),
);
$steps = array(
	array( '01', 'Choose your industry.', 'Open the generator for your industry from the cards above. Each one is set up with the sections that industry’s customers look for.' ),
	array( '02', 'Fill in your business details.', 'Enter your business name, website URL, business type, markets and languages. Add a short description, founding year and licences if you have them.' ),
	array( '03', 'Add your key pages.', 'For each important page, paste its title and URL, write one factual sentence about what it contains, and pick its section. Click Add page for the next one.' ),
	array( '04', 'Fix anything flagged.', 'Read the notes under each page. Filter URLs, logins and duplicates are left out for you; rewrite any line flagged for superlatives, prices or claims.' ),
	array( '05', 'Copy or download the file.', 'Check the preview on the right. When it looks right, click Copy or Download to save your llms.txt.' ),
);
/* After the file is built: publish, check, maintain. */
$publish = array(
	array( '06', 'Upload it to your site root.', 'Save the file as llms.txt so it opens at yourdomain.com/llms.txt. On WordPress, upload it through your host’s file manager, or paste it into your SEO plugin’s llms.txt setting instead of letting the plugin generate one.' ),
	array( '07', 'Check that it loads.', 'Open yourdomain.com/llms.txt in a browser. You should see plain text with a 200 status, not a redirect, a login screen or an HTML page. Make sure robots.txt isn’t blocking it.' ),
	array( '08', 'Keep it current.', 'Your entries stay saved in your browser. Come back and regenerate the file when you launch a service, project or location, and review it at least once a quarter.' ),
);
/* Also written to the vv_faq post meta by the runner, for the FAQPage schema (vv-schema.php). */
$faq = array(
	array( 'Is llms.txt the same as robots.txt?', 'No. robots.txt tells crawlers what they are allowed to access. llms.txt does not allow or block anything. It summarises the business and points models to the pages worth reading.' ),
	array( 'Will it improve my Google rankings?', 'Not in classic search. Its value is in how AI assistants understand and describe your business, and even there support varies by platform. Think of it as AI-visibility hygiene, not an SEO lever.' ),
	array( 'What is the difference between llms.txt and llms-full.txt?', 'llms.txt is a curated index: a summary plus links with one-line descriptions. llms-full.txt is an optional companion that holds the full text of those pages in a single file. These generators produce llms.txt.' ),
	array( 'Can I edit the file before publishing?', 'Yes. It is plain Markdown. Keep the structure intact: one H1 with the business name, a short summary in a blockquote, then H2 sections containing lists of links with a description after each.' ),
	array( 'How often should I regenerate it?', 'Whenever the site changes in a way a customer would notice, such as a new service, project, location or product line. Otherwise, review it once a quarter.' ),
	array( 'Why not use one generic generator for every site?', 'A generic tool lists pages. An industry generator knows which pages matter, what goes stale and what must never be invented. A real estate file should skip expiring listings, and a healthcare file must keep medical claims factual.' ),
);
$items = array(); $j = 0;
foreach ( $faq as $qa ) {
	$j++;
	$items[] = vv_acc_item( "Questions Item $j", array( 'acc-item' ), array( 'art-acc-head' ), sprintf( '%02d', $j ), array( 'acc-num' ), $qa[0], array( 'art-acc-title' ), array( 'acc-icon' ), array( 'acc-body' ), array( vv_p( "Questions Item $j Answer", $qa[1], array( 'art-p-sm' ) ) ) );
}

$nodes = array(
	vv_hero( 'Hub',
		array( vv_meta_block( 'Hub', 'Built for', 'Marketers and site owners' ), vv_meta_block( 'Hub', 'Generators', count( $generators ) . ' industries · ' . $live . ' live' ), vv_meta_block( 'Hub', 'Price', 'Free to use', true ) ),
		'llms.txt Generator', null, true,
		'A family of industry-specific generators that turn your website into a clean, curated llms.txt file: the short map AI assistants can read to understand who you are and which pages to trust.',
		array(
			vv_btn( 'Hub Industry Button', 'Choose your industry', '#generators', array( 'btn', 'btn-filled' ) ),
			vv_btn( 'Hub How Button', 'How it works', '#how-it-works', array( 'btn' ) ),
		)
	),
	vv_f( 'Generators', array( 'section', 'bg-parchment' ), array(
		vv_f( 'Generators Inner', array( 'wrap' ), array(
			vv_sec_head( 'Generators', '01', 'Generators', 'One format · industry-specific rules' ),
			vv_title_block( 'Generators', 'Pick your', 'industry.' ),
			vv_g( 'Generators Cards', array( 'gen-grid', 'mt-64' ), $cards ),
		) ),
	), array( 'tag' => 'section' ), null, 'generators' ),
	vv_f( 'Basics', array( 'section', 'bg-canvas' ), array(
		vv_f( 'Basics Inner', array( 'wrap' ), array(
			vv_sec_head( 'Basics', '02', 'The basics', 'One file · plain Markdown · site root' ),
			vv_title_block( 'Basics', 'What is an', 'llms.txt file?' ),
			vv_f( 'Basics Split', array( 'split', 'mt-64' ), array(
				vv_f( 'Basics Copy', array( 'col-6w', 'stack' ), array(
					vv_p( 'Basics Text 1', 'llms.txt is a plain Markdown file that lives at the root of a website, at <strong>yoursite.com/llms.txt</strong>. It gives large language models a short, curated summary of the business and a list of the pages that matter most, each with a one-line description.', array( 't-body' ) ),
					vv_p( 'Basics Text 2', 'Think of it as the opposite of a sitemap. A sitemap lists everything, for crawlers. llms.txt lists the right things, for a model working with a limited context window, written so the facts can be repeated accurately.', array( 't-body', 'mt-16' ) ),
					vv_p( 'Basics Text 3', 'The format was proposed by Jeremy Howard of Answer.AI in 2024 and is documented at ' . $link( 'llmstxt.org', 'https://llmstxt.org/' ) . '. It is a community convention rather than an official standard, which is exactly why a well-built file is still a differentiator.', array( 't-body', 'mt-16' ) ),
				), array(), vv_ix() ),
				vv_f( 'Basics Sample', array( 'col-5w', 'stack' ), array(
					vv_p( 'Basics Sample Label', 'Sample · real estate developer', array( 't-mono' ) ),
					vv_p( 'Basics Sample Code', implode( '<br>', array_map( function ( $l ) { return htmlspecialchars( $l, ENT_NOQUOTES ); }, $sample ) ), array( 'art-code', 'mt-16' ) ),
				), array(), vv_ix( 'scrollIn', 'slide', 120 ) ),
			) ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'Reasons', array( 'section', 'bg-ink' ), array(
		vv_f( 'Reasons Inner', array( 'wrap' ), array(
			vv_sec_head( 'Reasons', '03', 'For marketers', 'Six reasons it earns a place on the AI-visibility checklist', true ),
			vv_title_block( 'Reasons', 'Why it matters', 'for marketers.', true ),
			vv_cards( 'Reasons', $reasons, array( 'topics-grid', 'mt-96' ), true ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'How', array( 'section', 'bg-parchment' ), array(
		vv_f( 'How Inner', array( 'wrap' ), array(
			vv_sec_head( 'How', '04', 'How it works', 'From your details to a live llms.txt' ),
			vv_title_block( 'How', 'Build it.', 'Then publish it.' ),
			vv_p( 'How Build Label', 'Build your file', array( 't-mono', 'mt-96' ) ),
			vv_cards( 'How Build', $steps, array( 'topics-grid', 'mt-32' ), false, 'Step ' ),
			vv_p( 'How Publish Label', 'Once it’s built', array( 't-mono', 'mt-96' ) ),
			vv_cards( 'How Publish', $publish, array( 'grid-3-stack', 'mt-32' ), false, 'Step ' ),
			vv_f( 'How Callout', array( 'art-callout', 'mt-64' ), array(
				vv_p( 'How Callout Label', 'What it won’t do', array( 't-mono' ) ),
				vv_p( 'How Callout Text', 'llms.txt is not a ranking factor, and no AI platform guarantees it will read the file. Support varies by platform and Google has not said it uses it. Treat it as low-cost hygiene that sits beside the work that actually moves AI visibility: structured data, crawlable content and genuine source authority.', array( 'art-p-sm' ) ),
			), array(), vv_ix() ),
		) ),
	), array( 'tag' => 'section' ), null, 'how-it-works' ),
	vv_f( 'Questions', array( 'section', 'bg-canvas' ), array(
		vv_f( 'Questions Inner', array( 'wrap' ), array(
			vv_sec_head( 'Questions', '05', 'Questions', 'The ones that come up most' ),
			vv_title_block( 'Questions', 'Common', 'questions.' ),
			vv_f( 'Questions Holder', array( 'stack', 'mt-64' ), array(
				vv_n( 'e-accordion', 'Questions Accordion', array( 'acc' ), array( 'default_state' => 'first_expanded', 'max_expanded' => 'one', 'show_icon' => true, 'faq_schema' => false ), $items ),
			), array(), vv_ix() ),
		) ),
	), array( 'tag' => 'section' ), null, 'faq' ),
	vv_cta_dark( 'Hub', 'Start with', 'your industry.', array(
		vv_btn_dark( 'Hub CTA Real Estate Button', 'Real estate generator', $tool( 'real-estate' ), true ),
		vv_btn_dark( 'Hub CTA Suggest Button', 'Suggest an industry', vv_url( '/contact/' ) ),
	) ),
);

return array( 'id' => $id, 'faq' => $faq, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
