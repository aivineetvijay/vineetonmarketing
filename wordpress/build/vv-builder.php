<?php
/**
 * Build helper used while rebuilding the Claude Design pages in Elementor v4.
 *
 * It only assembles the XML + config payload for Elementor's own
 * `elementor/build-composition` ability and runs it; every element it creates
 * is a native v4 atomic element styled by global classes. Nothing here is
 * loaded by the site at runtime.
 */

function vv_n( $t, $l, $c = array(), $cfg = array(), $k = array(), $ix = null, $cssid = null ) {
	return array( 't' => $t, 'l' => $l, 'c' => $c, 'cfg' => $cfg, 'k' => $k, 'ix' => $ix, 'cssid' => $cssid );
}
function vv_f( $l, $c, $k = array(), $cfg = array(), $ix = null, $cssid = null ) { return vv_n( 'e-flexbox', $l, $c, $cfg, $k, $ix, $cssid ); }
function vv_g( $l, $c, $k = array(), $ix = null ) { return vv_n( 'e-grid', $l, $c, array(), $k, $ix ); }
function vv_p( $l, $text, $c, $tag = 'p', $href = null ) {
	$cfg = array( 'paragraph' => $text, 'tag' => $tag );
	if ( $href ) { $cfg['link'] = array( 'destination' => $href, 'tag' => 'a' ); }
	return vv_n( 'e-paragraph', $l, $c, $cfg );
}
function vv_h( $l, $text, $c, $tag = 'h2' ) { return vv_n( 'e-heading', $l, $c, array( 'tag' => $tag, 'title' => $text ) ); }
function vv_img( $l, $id, $alt, $c ) { return vv_n( 'e-image', $l, $c, array( 'image' => array( 'src' => array( 'id' => $id, 'alt' => $alt ), 'size' => 'full' ) ) ); }
function vv_btn( $l, $text, $href, $c ) { return vv_n( 'e-button', $l, $c, array( 'text' => $text . ' ↗', 'link' => array( 'destination' => $href, 'tag' => 'a' ) ) ); }
function vv_link( $l, $c, $href, $k ) { return vv_f( $l, $c, $k, array( 'tag' => 'a', 'link' => array( 'destination' => $href, 'tag' => 'a' ) ) ); }

function vv_ix( $trigger = 'scrollIn', $effect = 'slide', $delay = 0, $dur = 900 ) {
	return array( array( 'trigger' => $trigger, 'animation' => array(
		'effect' => $effect, 'type' => 'in', 'direction' => 'slide' === $effect ? 'bottom' : '',
		'timing_config' => array( 'duration' => array( 'unit' => 'ms', 'size' => $dur ), 'delay' => array( 'unit' => 'ms', 'size' => $delay ) ),
	) ) );
}
function vv_url( $path ) { return home_url( $path ); }

/* ---------- Shared section patterns ---------- */

function vv_meta_block( $p, $k, $v, $hide = false ) {
	$c = $hide ? array( 'meta-block', 'hide-on-mobile' ) : array( 'meta-block' );
	return vv_f( "$p Meta $k", $c, array( vv_p( "$p Meta $k Label", $k, array( 't-mono' ) ), vv_p( "$p Meta $k Value", $v, array( 'meta-value' ) ) ) );
}
function vv_status_block( $p, $k ) {
	return vv_f( "$p Meta $k", array( 'meta-block' ), array(
		vv_p( "$p Meta $k Label", $k, array( 't-mono' ) ),
		vv_f( "$p Status Pill", array( 'status' ), array(
			vv_p( "$p Status Light", '●', array( 'status-led' ), 'span' ),
			vv_p( "$p Status Text", 'Open to new conversations', array( 'status-text' ), 'span' ),
		) ),
	) );
}
/** $title: h1 html; $aside: muted italic tail (null for none); $tight: no gap before aside. */
function vv_hero( $p, $meta_blocks, $title, $aside, $tight, $lead, $buttons = array(), $classes = array( 'hero', 'bg-canvas' ), $inner_extra = array() ) {
	$line = array( vv_h( "$p Title", $title, array( 't-huge' ), 'h1' ) );
	if ( $aside ) { $line[] = vv_p( "$p Title Aside", $aside, array( 't-huge', 't-italic', 'muted' ), 'span' ); }
	$footer = array( vv_n( 'e-paragraph', "$p Intro", array( 't-lead', 'measure-620' ), array( 'paragraph' => $lead, 'tag' => 'p' ), array(), vv_ix( 'load', 'fade', 420 ) ) );
	if ( $buttons ) { $footer[] = vv_f( "$p Buttons", array( 'btn-row' ), $buttons, array(), vv_ix( 'load', 'fade', 520 ) ); }
	$inner = array_merge( array(
		vv_g( "$p Meta", array( 'hero-meta' ), $meta_blocks ),
		vv_f( "$p Headline", array( 'hero-title' ), array( vv_f( "$p Title Line", $tight ? array( 'hero-line', 'gap-0' ) : array( 'hero-line' ), $line, array(), vv_ix( 'load', 'slide', 0 ) ) ) ),
	), $inner_extra );
	if ( $lead ) { $inner[] = vv_f( "$p Footer", array( 'hero-footer' ), $footer ); }
	return vv_f( "$p Hero", $classes, array( vv_f( "$p Hero Inner", array( 'wrap' ), $inner ) ), array( 'tag' => 'section' ) );
}
function vv_sec_head( $p, $idx, $label, $note, $dark = false ) {
	return vv_f( "$p Head", array( 'sec-head' ), array(
		vv_f( "$p Head Left", array( 'sec-head-l' ), array(
			vv_p( "$p Index", $idx, $dark ? array( 'sec-idx', 'on-dark-meta' ) : array( 'sec-idx' ), 'span' ),
			vv_p( "$p Label", $label, $dark ? array( 'sec-label', 'on-dark' ) : array( 'sec-label' ), 'span' ),
		) ),
		vv_p( "$p Note", $note, $dark ? array( 'sec-note', 'on-dark-meta' ) : array( 'sec-note' ) ),
	), array(), vv_ix() );
}
function vv_title_block( $p, $main, $aside, $dark = false, $size = 't-display', $tag = 'h2', $extra = array() ) {
	$main_c = array( $size ); if ( $dark ) { $main_c[] = 'on-dark'; }
	$aside_c = array( $size, 't-italic', $dark ? 'muted-on-dark' : 'muted' );
	return vv_f( "$p Title Block", array_merge( array( 'stack' ), $extra ), array( vv_h( "$p Title", $main, $main_c, $tag ), vv_p( "$p Title Aside", $aside, $aside_c ) ), array(), vv_ix( 'scrollIn', 'slide', 80 ) );
}
/** Numbered cards (topic / pillar / step pattern). */
function vv_cards( $p, $items, $grid_classes, $dark = false, $num_prefix = '' ) {
	$cards = array(); $i = 0;
	foreach ( $items as $it ) {
		$i++;
		$cards[] = vv_f( "$p Card $i", array( 'stack' ), array(
			vv_p( "$p Card $i Number", $num_prefix . $it[0], $dark ? array( 't-mono', 'muted-on-dark' ) : array( 't-mono' ) ),
			vv_h( "$p Card $i Title", $it[1], $dark ? array( 'card-title', 'on-dark', 'mt-16' ) : array( 'card-title', 'mt-16' ), 'h3' ),
			vv_p( "$p Card $i Text", $it[2], $dark ? array( 't-body', 'muted-on-dark', 'mt-16' ) : array( 't-body', 'mt-16' ) ),
		), array(), vv_ix( 'scrollIn', 'slide', ( $i - 1 ) * 80 ) );
	}
	return vv_g( "$p Cards", $grid_classes, $cards );
}
function vv_stats( $p, $stats, $dark = false ) {
	$cells = array(); $i = 0; $n = count( $stats );
	foreach ( $stats as $s ) {
		$i++;
		$c = array( 'stat' ); if ( 1 === $i ) { $c[] = 'stat-pos-1'; } if ( 3 === $i ) { $c[] = 'stat-pos-3'; } if ( 4 === $i ) { $c[] = 'stat-pos-4'; } if ( $dark ) { $c[] = 'on-dark-lines'; }
		$val = array( vv_p( "$p Stat $i Number", $s[0], $dark ? array( 'stat-n', 'on-dark' ) : array( 'stat-n' ), 'span' ) );
		if ( '' !== $s[1] ) { $val[] = vv_p( "$p Stat $i Unit", $s[1], $dark ? array( 'stat-sup', 'muted-on-dark' ) : array( 'stat-sup' ), 'span' ); }
		$cells[] = vv_f( "$p Stat $i", $c, array( vv_f( "$p Stat $i Value", array( 'stat-value' ), $val ), vv_p( "$p Stat $i Label", $s[2], $dark ? array( 'stat-l', 'muted-on-dark' ) : array( 'stat-l' ) ) ) );
	}
	return vv_n( 'e-grid', "$p Stats", $dark ? array( 'stat-row', 'on-dark-lines' ) : array( 'stat-row' ), array(), $cells, vv_ix( 'scrollIn', 'slide', 80 ) );
}
function vv_cta_dark( $p, $main, $aside, $buttons ) {
	return vv_f( "$p CTA", array( 'section', 'bg-ink' ), array( vv_f( "$p CTA Inner", array( 'wrap' ), array(
		vv_title_block( "$p CTA", $main, $aside, true, 't-huge' ),
		vv_f( "$p CTA Buttons", array( 'btn-row', 'mt-48' ), $buttons, array(), vv_ix( 'scrollIn', 'fade' ) ),
	) ) ), array( 'tag' => 'section' ) );
}
function vv_btn_dark( $l, $text, $href, $filled = false ) { return vv_btn( $l, $text, $href, $filled ? array( 'btn', 'btn-on-dark', 'btn-filled' ) : array( 'btn', 'btn-on-dark' ) ); }
function vv_post_row( $p, $y, $title, $cat, $href, $dark = false ) {
	$row_c = $dark ? array( 'post-row', 'on-dark-lines', 'row-hover-on-dark' ) : array( 'post-row' );
	return vv_link( "$p Row", $row_c, $href, array(
		vv_p( "$p Date", $y, $dark ? array( 'post-yr', 'on-dark-meta' ) : array( 'post-yr' ), 'span' ),
		vv_h( "$p Title", $title, $dark ? array( 'post-ttl', 'on-dark' ) : array( 'post-ttl' ), 'h3' ),
		vv_p( "$p Category", $cat, $dark ? array( 'post-cat', 'muted-on-dark' ) : array( 'post-cat' ), 'span' ),
		vv_p( "$p Arrow", '↗', $dark ? array( 'post-arr', 'on-dark' ) : array( 'post-arr' ), 'span' ),
	) );
}
/** Subscribe band: the form area is left as an empty, named slot for a real form. */
function vv_subscribe( $p ) {
	return vv_f( "$p Subscribe", array( 'section', 'bg-ink' ), array( vv_f( "$p Subscribe Inner", array( 'wrap' ), array(
		vv_f( "$p Subscribe Split", array( 'split' ), array(
			vv_f( "$p Subscribe Copy", array( 'col-6w' ), array(
				vv_p( "$p Subscribe Eyebrow", 'Subscribe', array( 't-mono', 'muted-on-dark' ) ),
				vv_title_block( "$p Subscribe", 'New essays,', 'in your inbox.', true, 't-display', 'h2', array( 'mt-24' ) ),
				vv_p( "$p Subscribe Text", 'Once every fortnight. The essay only — no newsletter, no promotion.', array( 't-body', 'muted-on-dark', 'measure-440', 'mt-32' ) ),
			), array(), vv_ix() ),
			vv_f( "$p Subscribe Form Slot", array( 'col-5w', 'form-slot' ) ),
		) ),
	) ) ), array( 'tag' => 'section' ), null, 'subscribe' );
}

/* ---------- Compile + run ---------- */

function vv_compile( $node, &$acc ) {
	$id = $node['l'];
	$n = 2; while ( isset( $acc['seen'][ $id ] ) ) { $id = $node['l'] . ' ' . $n++; }
	$acc['seen'][ $id ] = true;
	if ( $node['cfg'] ) { $acc['cfg'][ $id ] = $node['cfg']; }
	if ( $node['c'] ) { $acc['cls'][ $id ] = $node['c']; }
	if ( $node['ix'] ) { $acc['ix'][ $id ] = $node['ix']; }
	if ( $node['cssid'] ) { $acc['cssid'][ $id ] = $node['cssid']; }
	$inner = '';
	foreach ( $node['k'] as $child ) { $inner .= vv_compile( $child, $acc ); }
	$attr = htmlspecialchars( $id, ENT_QUOTES );
	return '<' . $node['t'] . ' configuration-id="' . $attr . '">' . $inner . '</' . $node['t'] . '>';
}
function vv_build( $post_id, $nodes, $parent = 'document', $mode = 'append' ) {
	$acc = array( 'seen' => array(), 'cfg' => array(), 'cls' => array(), 'ix' => array(), 'cssid' => array() );
	$xml = '';
	foreach ( $nodes as $node ) { $xml .= vv_compile( $node, $acc ); }
	$res = wp_get_ability( 'elementor/build-composition' )->execute( array(
		'post_id' => $post_id, 'xml_structure' => $xml, 'element_config' => (object) $acc['cfg'],
		'classes' => (object) $acc['cls'], 'interactions' => (object) $acc['ix'], 'parent_id' => $parent, 'mode' => $mode,
	) );
	if ( is_wp_error( $res ) ) { return array( 'error' => $res->get_error_message() ); }
	if ( $acc['cssid'] && ! empty( $res['resolved_xml'] ) ) { vv_apply_cssids( $post_id, $res['resolved_xml'], $acc['cssid'] ); }
	return array( 'roots' => $res['root_element_ids'] ?? null, 'warnings' => $res['warnings'] ?? array(), 'count' => count( $acc['seen'] ) );
}
/** Sets Elementor's native element ID setting (_cssid) for anchor targets. */
function vv_apply_cssids( $post_id, $resolved_xml, $map ) {
	$ids = array();
	foreach ( $map as $cfg_id => $css ) {
		if ( preg_match( '/configuration-id="' . preg_quote( htmlspecialchars( $cfg_id, ENT_QUOTES ), '/' ) . '" id="([^"]+)"/', $resolved_xml, $m ) ) { $ids[ $m[1] ] = $css; }
	}
	$data = json_decode( get_post_meta( $post_id, '_elementor_data', true ), true );
	$walk = function ( &$els ) use ( &$walk, $ids ) {
		foreach ( $els as &$e ) {
			if ( isset( $ids[ $e['id'] ] ) ) { $e['settings']['_cssid'] = array( '$$type' => 'string', 'value' => $ids[ $e['id'] ] ); }
			if ( ! empty( $e['elements'] ) ) { $walk( $e['elements'] ); }
		}
	};
	$walk( $data );
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
}
/** Creates an Elementor page/post and applies the template + Astra layout settings. */
function vv_new( $title, $slug, $parent = 0, $type = 'page', $extra = array() ) {
	$existing = get_posts( array( 'post_type' => $type, 'name' => $slug, 'post_parent' => $parent, 'post_status' => 'any', 'numberposts' => 1 ) );
	if ( $existing ) { return $existing[0]->ID; }
	$res = wp_get_ability( 'elementor/create-page' )->execute( array( 'title' => $title, 'post_type' => $type ) );
	$id = (int) $res['id'];
	wp_update_post( array_merge( array( 'ID' => $id, 'post_name' => $slug, 'post_parent' => $parent ), $extra ) );
	update_post_meta( $id, '_wp_page_template', 'elementor_header_footer' );
	update_post_meta( $id, 'ast-site-content-layout', 'full-width-container' );
	update_post_meta( $id, 'site-content-style', 'unboxed' );
	update_post_meta( $id, 'site-sidebar-layout', 'no-sidebar' );
	update_post_meta( $id, 'site-post-title', 'disabled' );
	return $id;
}
