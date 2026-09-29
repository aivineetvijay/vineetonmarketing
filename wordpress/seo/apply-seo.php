<?php
/**
 * On-page SEO: Rank Math meta titles / descriptions / focus keywords from meta.json,
 * Rank Math breadcrumbs, and the visible breadcrumb bar via Astra's breadcrumb settings.
 * Run server-side (e.g. via execute-php) with $vv_meta = decoded meta.json.
 */

// 1. Per-page meta (Rank Math post meta). meta.json: { "<post id>": { "t": title, "d": description, "f": focus keyword } }.
$done = array();
foreach ( $vv_meta as $id => $m ) {
	$id = (int) $id;
	if ( ! get_post( $id ) ) {
		continue;
	}
	update_post_meta( $id, 'rank_math_title', $m['t'] );
	update_post_meta( $id, 'rank_math_description', $m['d'] );
	update_post_meta( $id, 'rank_math_focus_keyword', $m['f'] );
	if ( 'post' === get_post_type( $id ) ) {
		update_post_meta( $id, 'rank_math_facebook_title', $m['t'] );
		update_post_meta( $id, 'rank_math_facebook_description', $m['d'] );
	}
	$done[] = $id;
}

// 2. Rank Math breadcrumbs: Home / Parent / Page, "/" separator.
$general = get_option( 'rank-math-options-general', array() );
$general = array_merge( $general, array(
	'breadcrumbs'                     => 'on',
	'breadcrumbs_separator'           => '/',
	'breadcrumbs_home'                => 'on',
	'breadcrumbs_home_label'          => 'Home',
	'breadcrumbs_home_link'           => home_url( '/' ),
	'breadcrumbs_ancestor_categories' => 'off',
	'breadcrumbs_blog_page'           => 'off',
	'breadcrumbs_remove_post_title'   => 'off',
) );
update_option( 'rank-math-options-general', $general );

// 3. Visible breadcrumb bar: Astra, below the header, sourced from Rank Math. Hidden on Home and 404.
$resp = function ( $d, $t = null, $m = null ) {
	return array( 'desktop' => $d, 'tablet' => null === $t ? $d : $t, 'mobile' => null === $m ? ( null === $t ? $d : $t ) : $m );
};
$astra = get_option( 'astra-settings', array() );
$astra = array_merge( $astra, array(
	'breadcrumb-position'                => 'astra_header_after',
	'select-breadcrumb-source'           => 'rank-math',
	'breadcrumb-alignment'               => 'left',
	'breadcrumb-disable-home-page'       => '0',
	'breadcrumb-disable-blog-posts-page' => '1',
	'breadcrumb-disable-search'          => '1',
	'breadcrumb-disable-archive'         => '1',
	'breadcrumb-disable-single-page'     => '1',
	'breadcrumb-disable-single-post'     => '1',
	'breadcrumb-disable-singular'        => '1',
	'breadcrumb-disable-404-page'        => '0',
	'breadcrumb-font-family'             => "'Inter', sans-serif",
	'breadcrumb-font-weight'             => '400',
	'breadcrumb-font-size'               => array( 'desktop' => '13', 'tablet' => '13', 'mobile' => '12', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px' ),
	'breadcrumb-font-extras'             => array( 'line-height' => '1.4', 'line-height-unit' => 'em', 'text-transform' => '', 'letter-spacing' => '0.01', 'letter-spacing-unit' => 'em' ),
	'breadcrumb-bg-color'                => $resp( '#ffffff' ),
	'breadcrumb-text-color-responsive'   => $resp( '#6e6e73' ), // links
	'breadcrumb-hover-color-responsive'  => $resp( '#0066cc' ),
	'breadcrumb-active-color-responsive' => $resp( '#1d1d1f' ), // current page
	'breadcrumb-separator-color'         => $resp( '#86868b' ),
	'breadcrumb-spacing'                 => array(
		'desktop'      => array( 'top' => '14', 'right' => '', 'bottom' => '14', 'left' => '' ),
		'tablet'       => array( 'top' => '12', 'right' => '', 'bottom' => '12', 'left' => '' ),
		'mobile'       => array( 'top' => '10', 'right' => '', 'bottom' => '10', 'left' => '' ),
		'desktop-unit' => 'px',
		'tablet-unit'  => 'px',
		'mobile-unit'  => 'px',
	),
) );
update_option( 'astra-settings', $astra );

// 4. Caches.
if ( class_exists( '\Elementor\Plugin' ) ) {
	\Elementor\Plugin::$instance->files_manager->clear_cache();
}
do_action( 'litespeed_purge_all' );

return array( 'meta' => $done );
