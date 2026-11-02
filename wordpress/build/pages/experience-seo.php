<?php
/**
 * Experience page (ID 253): on-page SEO for "digital marketing specialist in dubai". 2 November 2026.
 * Run via Novamira execute-php. Edits the page's Elementor data in place; the design stays the same.
 *
 *  - H1: a small mono line "Vineet Vijay, digital marketing specialist in Dubai" under the big hero line.
 *    The big "A decade in the work." stays exactly as it looks, but is now a paragraph.
 *  - Hero intro opens with "I'm a digital marketing specialist in Dubai."
 *  - Split headings joined, so the whole line is the heading: "The path here.", "Four principles.",
 *    "Read what I am writing now." The italic half keeps its look as a span inside the heading.
 *  - Education and Tools section labels become H2s.
 *  - New section before the closing band: "How I work with Dubai brands", four areas of work,
 *    and buttons to Contact and the doctors article.
 *  - New global class "heading-reset" (margin 0, normal weight) for headings that sit in small type.
 *
 * A copy of the page data before this ran is in the option vv_backup_experience_20261102.
 */
$pid = 253;
$out = array();

/* 0. Global class for small headings. */
$existing = array();
foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) { $existing[ $c['label'] ] = $c['id']; }
if ( ! isset( $existing['heading-reset'] ) ) {
	wp_get_ability( 'elementor/manage-classes' )->execute( array( 'operations' => array(
		array( 'action' => 'create', 'label' => 'heading-reset', 'css' => 'margin: 0px; font-weight: 400;' ),
	) ) );
	foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) { $existing[ $c['label'] ] = $c['id']; }
}
$cls = function ( ...$labels ) use ( $existing ) {
	$ids = array();
	foreach ( $labels as $l ) {
		if ( ! isset( $existing[ $l ] ) ) { throw new Exception( 'missing class ' . $l ); }
		$ids[] = $existing[ $l ];
	}
	return array( '$$type' => 'classes', 'value' => $ids );
};
$s   = function ( $v ) { return array( '$$type' => 'string', 'value' => $v ); };
$h   = function ( $v ) { return array( '$$type' => 'escaped-html', 'value' => $v ); };
$nid = function () { return substr( md5( uniqid( '', true ) ), 0, 7 ); };
$w   = function ( $type, $title, $settings ) use ( $nid ) {
	return array( 'id' => $nid(), 'elType' => 'widget', 'settings' => $settings, 'elements' => array(), 'widgetType' => $type, 'editor_settings' => array( 'title' => $title ), 'version' => '0.0' );
};
$box = function ( $type, $title, $settings, $kids ) use ( $nid ) {
	return array( 'id' => $nid(), 'elType' => $type, 'settings' => $settings, 'elements' => $kids, 'isInner' => false, 'editor_settings' => array( 'title' => $title ), 'version' => '0.0' );
};
$para = function ( $title, $text, $classes, $tag = 'p' ) use ( $w, $h, $s ) { return $w( 'e-paragraph', $title, array( 'classes' => $classes, 'paragraph' => $h( $text ), 'tag' => $s( $tag ) ) ); };
$head = function ( $title, $text, $classes, $tag ) use ( $w, $h, $s ) { return $w( 'e-heading', $title, array( 'classes' => $classes, 'tag' => $s( $tag ), 'title' => $h( $text ) ) ); };
$btn  = function ( $title, $text, $href, $classes ) use ( $w, $h, $s ) {
	return $w( 'e-button', $title, array( 'classes' => $classes, 'text' => $h( $text ), 'link' => array( '$$type' => 'link', 'value' => array( 'destination' => array( '$$type' => 'url', 'value' => $href ), 'tag' => $s( 'a' ) ) ) ) );
};

$data = json_decode( get_post_meta( $pid, '_elementor_data', true ), true );
if ( ! $data ) { return array( 'error' => 'no elementor data' ); }
if ( false !== strpos( wp_json_encode( $data ), 'How I work with' ) ) { return array( 'error' => 'already applied' ); }

/* Walk helpers: edit an element by id, remove an element by id, insert after/before an element. */
$edit = function ( &$els, $id, $fn ) use ( &$edit ) {
	foreach ( $els as &$e ) {
		if ( $e['id'] === $id ) { $fn( $e ); return true; }
		if ( ! empty( $e['elements'] ) && $edit( $e['elements'], $id, $fn ) ) { return true; }
	}
	return false;
};
$remove = function ( &$els, $id ) use ( &$remove ) {
	foreach ( $els as $i => &$e ) {
		if ( $e['id'] === $id ) { array_splice( $els, $i, 1 ); return true; }
		if ( ! empty( $e['elements'] ) && $remove( $e['elements'], $id ) ) { return true; }
	}
	return false;
};
$insert = function ( &$els, $id, $new, $after = true ) use ( &$insert ) {
	foreach ( $els as $i => &$e ) {
		if ( $e['id'] === $id ) { array_splice( $els, $after ? $i + 1 : $i, 0, array( $new ) ); return true; }
		if ( ! empty( $e['elements'] ) && $insert( $e['elements'], $id, $new, $after ) ) { return true; }
	}
	return false;
};
$must = function ( $ok, $what ) use ( &$out ) { $out[ $what ] = $ok ? 'ok' : 'NOT FOUND'; if ( ! $ok ) { throw new Exception( 'not found: ' . $what ); } };

/* 1. Hero: big line becomes a paragraph; the H1 is a small mono line under it. */
$must( $edit( $data, '4b33ed27', function ( &$e ) use ( $s ) {
	$e['widgetType'] = 'e-paragraph';
	$e['settings']['paragraph'] = $e['settings']['title'];
	unset( $e['settings']['title'] );
	$e['settings']['tag'] = $s( 'p' );
} ), 'hero line to paragraph' );
$must( $insert( $data, '119e2ece', $head( 'Experience H1', 'Vineet Vijay, digital marketing specialist in Dubai', $cls( 't-mono', 'heading-reset', 'mt-24' ), 'h1' ) ), 'H1 inserted' );
$must( $edit( $data, 'fc0972a', function ( &$e ) use ( $h ) {
	$e['settings']['paragraph'] = $h( 'I’m a digital marketing specialist in Dubai. Ten years split between three of the largest media networks in the region — Wavemaker (WPP), Interactive Avenues (IPG), GenY Medium — and an in-house healthcare lead role in the UAE.' );
} ), 'hero intro' );

/* 2. Join split headings: the italic second half moves into the heading as a span. */
foreach ( array(
	array( '60760d57', '14705a0c', 'The', 'path here.', 't-italic muted' ),
	array( '716d52e3', '3643687d', 'Four', 'principles.', 't-italic muted-on-dark' ),
	array( '3bb3b673', '4154aa09', 'Read what', 'I am writing now.', 't-italic muted-on-dark' ),
) as $j ) {
	list( $hid, $pid2, $a, $b, $span ) = $j;
	$must( $edit( $data, $hid, function ( &$e ) use ( $h, $a, $b, $span ) {
		$e['settings']['title'] = $h( $a . '<br><span class="' . $span . '">' . $b . '</span>' );
	} ), "join $a" );
	$must( $remove( $data, $pid2 ), "remove $b" );
}

/* 3. Education and Tools section labels become H2s (same look). */
foreach ( array( '4a782212' => 'Education &amp; certifications', '164a630b' => 'Tools in the daily stack' ) as $id => $text ) {
	$must( $edit( $data, $id, function ( &$e ) use ( $h, $s, $text, $cls ) {
		$e['widgetType'] = 'e-heading';
		unset( $e['settings']['paragraph'] );
		$e['settings']['title'] = $h( $text );
		$e['settings']['tag'] = $s( 'h2' );
		$e['settings']['classes'] = $cls( 'sec-label', 'heading-reset' );
	} ), "label h2 $id" );
}

/* 4. New section before the closing band. */
$areas = array(
	array( 'SEO and AI search visibility', 'Content, technical SEO and structured data that help people and AI answers find you. At Reem Hospital, this grew organic traffic 180% in 18 months.' ),
	array( 'Paid media that pays back', 'Google, Meta and programmatic campaigns set up to optimise for enquiries and sales, not clicks. Remarketing-led e-commerce campaigns at IPG returned a ROAS of 6.' ),
	array( 'Measurement and tracking', 'GA4, Google Tag Manager and CRM tracking, so every campaign is judged on the business result. The dashboard comes first.' ),
	array( 'Healthcare marketing in the UAE', 'Patient acquisition for hospitals and doctors within DHA and DoH advertising rules, from the booking path to the booked consultation.' ),
);
$cards = array();
foreach ( $areas as $i => $a ) {
	$n = sprintf( '%02d', $i + 1 );
	$cards[] = $box( 'e-flexbox', "Work Area $n", array( 'classes' => $cls( 'stack' ) ), array(
		$para( "Work Area $n Index", $n, $cls( 't-mono' ) ),
		$head( "Work Area $n Title", $a[0], $cls( 'card-title', 'mt-16' ), 'h3' ),
		$para( "Work Area $n Body", $a[1], $cls( 't-body', 'mt-16' ) ),
	) );
}
$section = $box( 'e-flexbox', 'Work With Me', array( 'classes' => $cls( 'section', 'bg-parchment' ), 'tag' => $s( 'section' ) ), array(
	$box( 'e-flexbox', 'Work With Me Inner', array( 'classes' => $cls( 'wrap' ) ), array(
		$box( 'e-flexbox', 'Work With Me Head', array( 'classes' => $cls( 'sec-head' ) ), array(
			$box( 'e-flexbox', 'Work With Me Head Left', array( 'classes' => $cls( 'sec-head-l' ) ), array(
				$para( 'Work With Me Index', '05', $cls( 'sec-idx' ), 'span' ),
				$para( 'Work With Me Label', 'Work with me', $cls( 'sec-label' ), 'span' ),
			) ),
			$para( 'Work With Me Note', 'Dubai and the UAE', $cls( 'sec-note' ) ),
		) ),
		$head( 'Work With Me Title', 'How I work with<br><span class="t-italic muted">Dubai brands.</span>', $cls( 't-display' ), 'h2' ),
		$para( 'Work With Me Lead', 'As a digital marketing specialist in Dubai, I work on the parts of marketing that decide whether spend turns into revenue: being found, being trusted, and measuring what actually moved.', $cls( 't-lead', 'mt-32' ) ),
		$box( 'e-grid', 'Work Areas', array( 'classes' => $cls( 'grid-2', 'mt-64' ) ), $cards ),
		$box( 'e-flexbox', 'Work With Me Buttons', array( 'classes' => $cls( 'btn-row', 'mt-48' ) ), array(
			$btn( 'Work With Me Contact', 'Get in touch ↗', home_url( '/contact/' ), $cls( 'btn', 'btn-filled' ) ),
			$btn( 'Work With Me Doctors', 'Digital marketing for doctors ↗', home_url( '/digital-marketing-for-doctors/' ), $cls( 'btn' ) ),
		) ),
	) ),
) );
$must( $insert( $data, '3e2065e4', $section, false ), 'work-with-me section' );

/* 5. Save, refresh caches and the plain-text copy. */
update_post_meta( $pid, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $pid, '_elementor_element_cache' );
delete_post_meta( $pid, '_elementor_css' );
if ( function_exists( 'vv_refresh_text_copy' ) ) { vv_refresh_text_copy( $pid ); }
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return $out;
