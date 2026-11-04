<?php
/**
 * Home (post 101): internal links.
 *  1. "Start here" section after the brand strip: five priority pages (three essays, two tools) as cards that
 *     reuse the AI Tools card classes (gen-grid, gen-card ...). Built once; skipped if it already exists.
 *  2. Section numbers after it move up one (Topics 02, Writing 03, About 04, Numbers 05).
 *  3. "All writing" button reads "Browse all essays by topic".
 *  4. About: "Reem Hospital" in the Previously list links to the doctors essay (the Reem Hospital case). The
 *     paragraph gets the p-links global class (underlined links inside it) so the link is visible.
 * The Writing rows (one per recent essay, each linking to its post) are home-writing.php.
 * Needs vv-builder.php loaded. Run at top level through Novamira execute-php, then vv_publish( 101 ).
 */
$vv_home = 101;
$vv_start = array(
	array( 'Essay · 12 min', 'AI in Marketing', 'Schema markup is your website’s resume.', 'A five-line framework for schema markup that helps search engines and AI tools identify you correctly.', '/schema-markup-ai-visibility/', 'Read the essay →' ),
	array( 'Essay · 9 min', 'AI in Marketing', 'How to rank in AI Overviews: what I learned getting cited.', 'AI Overviews quote passages, not pages. What a DA 17 hospital site taught me about getting cited, and the LIFT test.', '/rank-in-ai-overviews/', 'Read the essay →' ),
	array( 'Essay · 10 min', 'Measurement', 'What is an AI visibility score?', 'Why three tools gave one hospital three different scores, and the PACE check for what’s actually worth measuring.', '/ai-visibility-score/', 'Read the essay →' ),
	array( 'Free tool', 'AI visibility', 'llms.txt Generator', 'Build the short file AI assistants read to understand your website, with a generator for each of six industries.', '/ai-tools/llms-txt-generator/', 'Open the generator →' ),
	array( 'Free tool', 'Measurement', 'UTM Builder', 'Build clean UTM links and see which GA4 channel each one reports under before you publish.', '/ai-tools/utm-builder/', 'Open the UTM builder →' ),
);

$vv_find = function ( $els, $title ) use ( &$vv_find ) {
	foreach ( $els as $e ) {
		if ( ( $e['editor_settings']['title'] ?? '' ) === $title ) { return $e; }
		if ( ! empty( $e['elements'] ) && ( $f = $vv_find( $e['elements'], $title ) ) ) { return $f; }
	}
	return null;
};
$vv_out = array();

/* Global class: underline links inside a paragraph (Elementor strips inline styles from paragraph HTML). */
$vv_classes = array();
foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) { $vv_classes[ $c['label'] ] = $c['id']; }
if ( empty( $vv_classes['p-links'] ) ) {
	$r = wp_get_ability( 'elementor/manage-classes' )->execute( array( 'operations' => array( array( 'action' => 'create', 'label' => 'p-links', 'css' => '& a { text-decoration: underline; text-underline-offset: 3px; } & a:hover { color: var(--color-primary); }' ) ) ) );
	$vv_classes['p-links'] = $r['results'][0]['id'] ?? '';
}

/* 1. Build the section (appended to the document, then moved after "Brands"). */
$data = json_decode( get_post_meta( $vv_home, '_elementor_data', true ), true );
if ( ! $vv_find( $data, 'Start Here' ) ) {
	$cards = array();
	foreach ( $vv_start as $i => $c ) {
		$n = 'Start Card ' . ( $i + 1 );
		$cards[] = vv_link( $n, array( 'gen-card' ), vv_url( $c[4] ), array(
			vv_f( "$n Top", array( 'gen-top' ), array( vv_p( "$n Kind", $c[0], array( 't-mono' ), 'span' ) ) ),
			vv_f( "$n Body", array( 'gen-body' ), array(
				vv_p( "$n Category", $c[1], array( 'eyebrow-accent' ), 'span' ),
				vv_h( "$n Title", $c[2], array( 'tcard-name' ), 'h3' ),
				vv_p( "$n Text", $c[3], array( 'tcard-use' ) ),
			) ),
			vv_p( "$n Action", $c[5], array( 'gen-cta' ), 'span' ),
		) );
	}
	$vv_out['build'] = vv_build( $vv_home, array(
		vv_f( 'Start Here', array( 'section', 'bg-canvas' ), array(
			vv_f( 'Start Here Inner', array( 'wrap' ), array(
				vv_sec_head( 'Start Here', '01', 'Start here', 'Five places to begin' ),
				vv_title_block( 'Start Here', 'New here?', 'Start with these.' ),
				vv_g( 'Start Here Cards', array( 'gen-grid', 'mt-64' ), $cards ),
			) ),
		), array( 'tag' => 'section' ) ),
	), 'document', 'append' );
	vv_publish( $vv_home );
}

/* 2-4. Move the section, renumber, button text, About link. Works on the published data. */
$data = json_decode( get_post_meta( $vv_home, '_elementor_data', true ), true );
$start = null; $rest = array();
foreach ( $data as $e ) {
	if ( 'Start Here' === ( $e['editor_settings']['title'] ?? '' ) ) { $start = $e; } else { $rest[] = $e; }
}
if ( $start ) {
	$data = array();
	foreach ( $rest as $e ) {
		$data[] = $e;
		if ( 'Brands' === ( $e['editor_settings']['title'] ?? '' ) ) { $data[] = $start; $start = null; }
	}
	if ( $start ) { array_splice( $data, 1, 0, array( $start ) ); }
}
$set_text = array(
	'Topics Index'  => array( 'paragraph', '02' ),
	'Writing Index' => array( 'paragraph', '03' ),
	'About Eyebrow' => array( 'paragraph', '04 · About' ),
	'Numbers Index' => array( 'paragraph', '05' ),
);
$doctors = esc_url( home_url( '/digital-marketing-for-doctors/' ) );
$plinks = $vv_classes['p-links'];
$walk = function ( &$els ) use ( &$walk, $set_text, $doctors, $plinks, &$vv_out ) {
	foreach ( $els as &$e ) {
		$t = $e['editor_settings']['title'] ?? '';
		if ( isset( $set_text[ $t ] ) ) { $e['settings'][ $set_text[ $t ][0] ]['value'] = $set_text[ $t ][1]; $vv_out['set'][] = $t; }
		if ( 'All Writing Button' === $t ) { $e['settings']['text']['value'] = 'Browse all essays by topic ↗'; $vv_out['set'][] = $t; }
		if ( 'About Previously Value' === $t ) {
			$v = $e['settings']['paragraph']['value'];
			if ( false === strpos( $v, 'digital-marketing-for-doctors' ) ) {
				$e['settings']['paragraph']['value'] = preg_replace( '/Reem Hospital/', '<a href="' . $doctors . '">Reem Hospital</a>', $v, 1 );
				$vv_out['set'][] = $t;
			}
			if ( $plinks && ! in_array( $plinks, $e['settings']['classes']['value'], true ) ) { $e['settings']['classes']['value'][] = $plinks; }
		}
		if ( ! empty( $e['elements'] ) ) { $walk( $e['elements'] ); }
	}
};
$walk( $data );
update_post_meta( $vv_home, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $vv_home, '_elementor_element_cache' );
vv_refresh_text_copy( $vv_home );
return $vv_out;
