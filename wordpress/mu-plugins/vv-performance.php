<?php
/**
 * Plugin Name: VV Performance
 * Description: Removes front-end files the site does not use. Every page is built with Elementor, so the WordPress
 *              block stylesheets and the Hostinger Reach subscription-block stylesheet are render-blocking requests
 *              with nothing to style. They still load on any page whose content does contain blocks. Also removes
 *              the emoji detection script and styles (browsers draw emoji natively).
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-performance.php (must-use plugins load automatically).
 * Related settings (not in this file): Astra loads Google Fonts locally with preload; LiteSpeed browser cache is on.
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
