<?php
/** Case Studies (/case-studies/) plus one child page per case — rebuilt from case-studies.html. */
$tone = array( 'mint' => 121, 'blue' => 115, 'warm' => 116, 'deep' => 118 );
$cases = array(
	array(
		'slug' => 'reem-hospital', 'name' => 'Reem Hospital', 'industry' => 'Healthcare', 'location' => 'Abu Dhabi, UAE', 'period' => '2024 — Present',
		'role' => 'Digital Marketing Strategist', 'services' => 'SEO · Paid Media · AI Workflows',
		'tagline' => 'A patient acquisition engine for Abu Dhabi.',
		'summary' => 'Built the digital front door for a new flagship UAE hospital — from a one-page website to an editorial and acquisition system that now delivers a third of all patient enquiries.',
		'tone' => 'mint',
		'metrics' => array( array( '180', '%', 'Organic traffic growth, 18 months.' ), array( '200', '%', 'Growth in organic enquiries.' ), array( '35', '%', 'Of new enquiries now digital-attributed.' ), array( '5', '', 'Team built and led across SEO, paid, content, analytics.' ) ),
		'body' => array(
			array( 'The brief', 'A new flagship hospital opening in a UAE market dominated by long-established networks. The team had a beautiful product and a budget — but no clear picture of which channels actually moved a patient from intent to appointment.' ),
			array( 'The work', 'A growth framework rebuilt from the ground up: technical SEO, schema, an editorial system and a measurement plane that finally tied first-touch to first-appointment. Paid restructured around incrementality. Email and SMS programmes built off real patient personas. The digital health hub launched as the editorial engine. An AI-driven health podcast launched on top of it.' ),
			array( 'The outcome', 'Within 18 months, organic search became the largest single source of new-patient enquiries. The dashboard the team uses today is the same one we built in week three.' ),
		),
	),
	array(
		'slug' => 'apollo-hospitals', 'name' => 'Apollo Hospitals', 'industry' => 'Healthcare', 'location' => 'India', 'period' => '2019 — 2021',
		'role' => 'Associate Group Head, Interactive Avenues (IPG)', 'services' => 'Performance Media · GTM · Analytics',
		'tagline' => 'A Go-To-Market for Apollo 24x7’s Traq launch.',
		'summary' => 'Engineered the launch strategy for Traq, the wearables product from Apollo 24x7, and the analytics cadence that has informed enterprise media planning ever since.',
		'tone' => 'blue',
		'metrics' => array( array( 'GTM', '', 'Launch strategy delivered for Traq, Apollo 24x7.' ), array( '#1', '', 'Analytics proposal cadence adopted agency-wide.' ), array( '4', '', 'Verticals integrated under one media plan.' ), array( '0', '', 'Patient PII shared with third-party models.' ) ),
		'body' => array(
			array( 'The brief', 'An enterprise healthcare brand entering the wearables and consumer-health category, with a media stack built for hospital lead-gen. The Go-To-Market needed a different shape.' ),
			array( 'The work', 'A consumer-first GTM for Traq, layered on top of the existing enterprise media plan. New growth channels identified and tested. An analytics proposal and action-plan rhythm that informed the broader brand’s decisioning.' ),
			array( 'The outcome', 'Traq launched into market with a measurement plane that let the team see what was working from day one. The analytics cadence built for Apollo became a template for the wider agency practice.' ),
		),
	),
	array(
		'slug' => 'myntra', 'name' => 'Myntra', 'industry' => 'E-commerce', 'location' => 'India', 'period' => '2021 — 2024',
		'role' => 'Associate Business Director, Wavemaker (WPP)', 'services' => 'Programmatic · Media Strategy · Measurement',
		'tagline' => 'A multimillion-dollar digital media strategy, re-architected.',
		'summary' => 'Directed digital media planning for one of India’s largest fashion e-commerce brands, against annual budgets that reach the hundreds of millions of rupees.',
		'tone' => 'warm',
		'metrics' => array( array( '250', 'Mn₹', 'Annual budget directed across the WPP portfolio.' ), array( '6', '+', 'Brands led concurrently at Wavemaker.' ), array( 'TV+', '', 'Integrated TV and digital plans for total reach.' ), array( '−', '', 'Wasted spend on duplicate audiences eliminated.' ) ),
		'body' => array(
			array( 'The brief', 'A market-leading fashion platform with a programmatic spend large enough to matter, but a measurement plane still trusting last-click. The exec team wanted to know what was actually working.' ),
			array( 'The work', 'A staged incrementality program — geo-holdouts on top-spend campaigns, audience hygiene, dynamic creative, and a creative testing system. The deliverable was a new decision-rights document for the demand-side team and a tighter media plan across TV and digital.' ),
			array( 'The outcome', 'Wasted spend down, incremental revenue up. The category leads now ship paid media decisions in a fraction of the prior cycle time.' ),
		),
	),
	array(
		'slug' => 'titan', 'name' => 'Titan Watches', 'industry' => 'Luxury & Lifestyle', 'location' => 'India', 'period' => '2019 — 2021',
		'role' => 'Associate Group Head, Interactive Avenues (IPG)', 'services' => 'Performance Media · E-commerce · Strategy',
		'tagline' => 'A ROAS of 6 on a heritage luxury brand.',
		'summary' => 'Re-engineered the e-commerce performance system for Titan — a remarketing-led framework that converted at six times spend, without compromising the brand.',
		'tone' => 'deep',
		'metrics' => array( array( '6', '×', 'Return on ad spend across e-commerce campaigns.' ), array( '+', '', 'Novel growth channels integrated into the mix.' ), array( '0', '', 'Compromises on the heritage brand voice.' ), array( '24', 'mo', 'Of compounding performance gains.' ) ),
		'body' => array(
			array( 'The brief', 'A heritage brand with a beautiful product, a luxury voice, and a flat e-commerce curve. The previous performance model leaked spend on top-funnel audiences that never converted.' ),
			array( 'The work', 'A remarketing-led growth framework that efficiently converted return audiences. Novel growth channels — new programmatic supply, influencer-led performance — tested and integrated where the math worked.' ),
			array( 'The outcome', 'A ROAS of 6, sustained over the engagement. The brand stayed itself; the performance got better.' ),
		),
	),
);

$index_id = vv_new( 'Case Studies', 'case-studies' );
$url = function ( $c ) { return vv_url( '/case-studies/' . $c['slug'] . '/' ); };
$work_rows = function ( $p, $list ) use ( $url ) {
	$rows = array(); $n = count( $list ); $i = 0;
	foreach ( $list as $c ) {
		$i++;
		$year = str_replace( array( ' — ', 'Present' ), array( '–', '→' ), $c['period'] );
		$rows[] = vv_link( "$p Work $i", array( 'work-row' ), $url( $c ), array(
			vv_p( "$p Work $i Index", sprintf( '%02d / %02d', $i, $n ), array( 'work-idx' ), 'span' ),
			vv_h( "$p Work $i Title", htmlspecialchars( $c['name'] ), array( 'work-title' ), 'h3' ),
			vv_p( "$p Work $i Tag", htmlspecialchars( $c['industry'] ) . ' · ' . rtrim( $c['tagline'], '.' ), array( 'work-tag' ), 'span' ),
			vv_p( "$p Work $i Year", $year, array( 'work-yr' ), 'span' ),
			vv_p( "$p Work $i Arrow", '↗', array( 'work-arr' ), 'span' ),
		) );
	}
	return vv_f( "$p Work List", array( 'work-list' ), $rows, array(), vv_ix() );
};
$back_btn = function ( $l, $dark ) {
	return vv_n( 'e-button', $l, $dark ? array( 'btn', 'btn-on-dark' ) : array( 'btn' ), array( 'text' => '← All projects', 'link' => array( 'destination' => vv_url( '/case-studies/' ), 'tag' => 'a' ) ) );
};

$out = array();
$out['index'] = array( 'id' => $index_id, 'result' => vv_build( $index_id, array(
	vv_hero( 'Work',
		array( vv_meta_block( 'Work', 'Section', 'Selected work' ), vv_meta_block( 'Work', 'Count', '04 projects' ), vv_meta_block( 'Work', 'Window', '2019 — Present' ) ),
		'Selected<br>work.', null, false,
		'Four engagements from a decade across healthcare, e-commerce, FMCG, and luxury. Numbers are taken from public material and engagement debriefs; client confidentialities are respected.'
	),
	vv_f( 'Projects', array( 'section', 'bg-canvas' ), array( vv_f( 'Projects Inner', array( 'wrap' ), array( $work_rows( 'Projects', $cases ) ) ) ), array( 'tag' => 'section' ) ),
	vv_cta_dark( 'Work', 'More', 'where this came from.', array(
		vv_btn_dark( 'Work CTA Pov Button', 'Read the POV', vv_url( '/ai/' ) ),
		vv_btn_dark( 'Work CTA Writing Button', 'Read the writing', vv_url( '/blog/' ), true ),
	) ),
), 'document', 'replace_children' ) );

foreach ( $cases as $k => $c ) {
	$pid = vv_new( $c['name'], $c['slug'], $index_id );
	$name = htmlspecialchars( $c['name'] );
	$metrics = array(); $i = 0;
	foreach ( $c['metrics'] as $m ) {
		$i++;
		$val = array( vv_p( "Result $i Value", $m[0], array( 'metric-n' ), 'span' ) );
		if ( '' !== $m[1] ) { $val[] = vv_p( "Result $i Unit", $m[1], array( 'metric-sup' ), 'span' ); }
		$metrics[] = vv_f( "Result $i", array( 'metric' ), array( vv_f( "Result $i Figure", array( 'stat-value' ), $val ), vv_p( "Result $i Label", $m[2], array( 't-body', 't-body-14', 'mt-8' ) ) ) );
	}
	$body = array(); $i = 0;
	foreach ( $c['body'] as $b ) {
		$i++;
		$body[] = vv_f( "Story $i", array( 'stack' ), array( vv_p( "Story $i Heading", $b[0], array( 't-mono' ) ), vv_p( "Story $i Text", $b[1], array( 't-medium', 'mt-24' ) ) ), array(), vv_ix() );
	}
	$next = array( $cases[ ( $k + 1 ) % 4 ], $cases[ ( $k + 2 ) % 4 ] );
	$nodes = array(
		vv_f( 'Case Hero', array( 'case-hero', 'bg-canvas' ), array( vv_f( 'Case Hero Inner', array( 'wrap' ), array(
			vv_g( 'Case Meta', array( 'hero-meta', 'mb-80' ), array( vv_meta_block( 'Case', 'Industry', htmlspecialchars( $c['industry'] ) ), vv_meta_block( 'Case', 'Location', $c['location'] ), vv_meta_block( 'Case', 'Window', $c['period'] ) ) ),
			vv_f( 'Case Headline', array( 'hero-title' ), array( vv_f( 'Case Title Line', array( 'hero-line', 'gap-0' ), array( vv_h( 'Case Title', $name, array( 't-huge' ), 'h1' ), vv_p( 'Case Title Aside', '.', array( 't-huge', 't-italic', 'muted' ), 'span' ) ), array(), vv_ix( 'load', 'slide' ) ) ) ),
			vv_n( 'e-paragraph', 'Case Tagline', array( 't-lead', 'measure-720', 'mt-48' ), array( 'paragraph' => $c['tagline'], 'tag' => 'p' ), array(), vv_ix( 'load', 'fade', 300 ) ),
			vv_f( 'Case Buttons', array( 'btn-row', 'mt-32' ), array( $back_btn( 'Case Back Button', false ), vv_btn( 'Case Essays Button', 'Read more essays', vv_url( '/blog/' ), array( 'btn', 'btn-filled' ) ) ), array(), vv_ix( 'load', 'fade', 400 ) ),
		) ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Cover', array( 'section-sm', 'pt-0', 'bg-canvas' ), array( vv_f( 'Cover Inner', array( 'wrap' ), array( vv_n( 'e-image', 'Cover Image', array( 'tile-img', 'tile-img-lg' ), array( 'image' => array( 'src' => array( 'id' => $tone[ $c['tone'] ], 'alt' => '' ), 'size' => 'full' ) ), array(), vv_ix( 'scrollIn', 'fade' ) ) ) ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Facts', array( 'section-sm', 'pt-0', 'pb-0', 'bg-canvas' ), array( vv_f( 'Facts Inner', array( 'wrap' ), array( vv_g( 'Facts Strip', array( 'case-meta' ), array(
			vv_f( 'Fact Role', array( 'meta-cell' ), array( vv_p( 'Fact Role Label', 'Role', array( 'meta-k' ) ), vv_p( 'Fact Role Value', $c['role'], array( 'meta-v' ) ) ) ),
			vv_f( 'Fact Disciplines', array( 'meta-cell' ), array( vv_p( 'Fact Disciplines Label', 'Disciplines', array( 'meta-k' ) ), vv_p( 'Fact Disciplines Value', $c['services'], array( 'meta-v', 'meta-v-light' ) ) ) ),
			vv_f( 'Fact Engagement', array( 'meta-cell' ), array( vv_p( 'Fact Engagement Label', 'Engagement', array( 'meta-k' ) ), vv_p( 'Fact Engagement Value', $c['period'], array( 'meta-v' ) ) ) ),
			vv_f( 'Fact Industry', array( 'meta-cell' ), array( vv_p( 'Fact Industry Label', 'Industry', array( 'meta-k' ) ), vv_p( 'Fact Industry Value', htmlspecialchars( $c['industry'] ), array( 'meta-v' ) ) ) ),
		) ) ) ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Summary', array( 'section', 'bg-parchment' ), array( vv_f( 'Summary Inner', array( 'wrap' ), array( vv_f( 'Summary Split', array( 'split' ), array(
			vv_f( 'Summary Copy', array( 'col-6w' ), array( vv_p( 'Summary Heading', 'Summary', array( 't-mono' ) ), vv_p( 'Summary Text', $c['summary'], array( 't-medium', 'mt-24' ) ) ), array(), vv_ix() ),
			vv_f( 'Results', array( 'col-5w' ), array( vv_p( 'Results Heading', 'Results', array( 't-mono' ) ), vv_f( 'Results List', array( 'stack', 'mt-24' ), $metrics ) ), array(), vv_ix( 'scrollIn', 'slide', 120 ) ),
		) ) ) ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Story', array( 'section', 'bg-canvas' ), array( vv_f( 'Story Body', array( 'cs-body' ), $body ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Detail', array( 'section-sm', 'bg-canvas' ), array( vv_f( 'Detail Inner', array( 'wrap' ), array( vv_n( 'e-image', 'Detail Image', array( 'tile-img' ), array( 'image' => array( 'src' => array( 'id' => $tone[ $c['tone'] ], 'alt' => '' ), 'size' => 'full' ) ), array(), vv_ix( 'scrollIn', 'fade' ) ) ) ) ), array( 'tag' => 'section' ) ),
		vv_f( 'Debrief', array( 'section', 'bg-parchment' ), array( vv_f( 'Debrief Quote', array( 'pull-quote' ), array(
			vv_p( 'Debrief Text', '“The dashboard we built in week three is the one the team still runs the business on.”', array( 'pull-quote-text' ) ),
			vv_p( 'Debrief Cite', '— Engagement debrief, ' . $name, array( 'pull-cite' ) ),
		), array(), vv_ix() ) ), array( 'tag' => 'section' ) ),
		vv_f( 'More Work', array( 'section', 'bg-canvas' ), array( vv_f( 'More Work Inner', array( 'wrap' ), array( vv_sec_head( 'More Work', '→', 'Keep reading', 'More work' ), $work_rows( 'More', $next ) ) ) ), array( 'tag' => 'section' ) ),
		vv_cta_dark( 'Case', 'Keep', 'reading.', array( $back_btn( 'Case CTA Back Button', true ), vv_btn_dark( 'Case CTA Writing Button', 'Read the writing', vv_url( '/blog/' ), true ) ) ),
	);
	$out[ $c['slug'] ] = array( 'id' => $pid, 'result' => vv_build( $pid, $nodes, 'document', 'replace_children' ) );
}
return $out;
