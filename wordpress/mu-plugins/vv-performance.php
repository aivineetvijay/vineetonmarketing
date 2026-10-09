<?php
/**
 * Plugin Name: VV Performance
 * Description: Removes front-end files the site does not use. Every page is built with Elementor, so the WordPress
 *              block stylesheets and the Hostinger Reach subscription-block stylesheet are render-blocking requests
 *              with nothing to style. They still load on any page whose content does contain blocks. Also removes
 *              the emoji detection script and styles (browsers draw emoji natively).
 *              On Elementor pages Inter comes from Elementor's local copy (one variable font file for every weight), so
 *              Astra's second copy of Inter is skipped there and Elementor's file is preloaded instead.
 * Version:     1.1.0
 *
 * Install: copy to wp-content/mu-plugins/vv-performance.php (must-use plugins load automatically).
 * Related settings (not in this file): Astra loads Google Fonts locally with preload (Astra > Performance);
 *              Elementor loads Google Fonts locally (elementor_local_google_fonts); LiteSpeed browser cache is on (1 year).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	if ( is_singular() && has_blocks( get_queried_object() ) ) {
		return;
	}
	foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'hostinger-reach-subscription-block' ) as $h ) {
		wp_dequeue_style( $h );
	}
}, 100 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

/* Elementor's local Inter stylesheet and its Latin upright file (all weights). Empty if Elementor has not built it. */
function vv_perf_elementor_inter() {
	$css = wp_get_upload_dir()['basedir'] . '/elementor/google-fonts/css/inter.css';
	if ( ! is_file( $css ) ) {
		return '';
	}
	$key  = 'vv_perf_inter_' . filemtime( $css );
	$font = get_transient( $key );
	if ( false === $font ) {
		$font = preg_match( '#/\* latin \*/\s*@font-face \{[^}]*font-style: normal;[^}]*url\(([^)]+)\)#', (string) file_get_contents( $css ), $m ) ? trim( $m[1], '\'"' ) : '';
		set_transient( $key, $font, MONTH_IN_SECONDS );
	}
	return $font;
}

function vv_perf_is_elementor_page() {
	return is_singular() && class_exists( '\Elementor\Plugin' )
		&& \Elementor\Plugin::$instance->documents->get( get_queried_object_id() )
		&& \Elementor\Plugin::$instance->documents->get( get_queried_object_id() )->is_built_with_elementor();
}

add_filter( 'astra_render_fonts', function ( $fonts ) {
	return vv_perf_is_elementor_page() && vv_perf_elementor_inter() ? array() : $fonts;
} );

add_action( 'wp_head', function () {
	$font = vv_perf_is_elementor_page() ? vv_perf_elementor_inter() : '';
	if ( $font ) {
		echo '<link rel="preload" href="' . esc_url( $font ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
}, 1 );
