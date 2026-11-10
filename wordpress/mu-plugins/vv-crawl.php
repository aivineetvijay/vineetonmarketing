<?php
/**
 * Plugin Name: VV Crawl Hygiene
 * Description: Keeps crawlers off URLs that should never be indexed (Search Console, 9 November 2026).
 *              - XML-RPC off: no RSD or pingback links in the page head, no X-Pingback header, no pingbacks.
 *                Google was finding xmlrpc.php from those links and reporting it as "Blocked due to other 4xx" (405).
 *              - Comments are closed site-wide, so the comments feed links leave the head and per-post comment
 *                feeds (/post-slug/feed/) 301 to the post. These showed up as "Crawled - currently not indexed".
 *              - Every remaining feed (the main /feed/ stays for RSS readers) sends X-Robots-Tag: noindex, follow.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-crawl.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

/* XML-RPC and pingbacks. */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );
add_action( 'init', function () {
	remove_action( 'wp_head', 'rsd_link' );
} );
/* Themes print <link rel="pingback"> from bloginfo( 'pingback_url' ); drop that link when it is printed. */
add_action( 'wp_head', function () { ob_start(); }, 0 );
add_action( 'wp_head', function () {
	$head = ob_get_clean();
	echo preg_replace( '#<link rel="pingback"[^>]*>\s*#', '', (string) $head ); // phpcs:ignore WordPress.Security.EscapeOutput
}, PHP_INT_MAX );

/* Comment feeds: no links to them, and per-post comment feeds go to the post. */
add_filter( 'feed_links_show_comments_feed', '__return_false' );
add_action( 'init', function () {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
} );
add_action( 'template_redirect', function () {
	if ( is_feed() && is_singular() ) {
		wp_safe_redirect( get_permalink( get_queried_object_id() ), 301, 'VV Crawl' );
		exit;
	}
	if ( is_feed() && ( is_search() || is_comment_feed() ) ) {
		wp_safe_redirect( home_url( '/feed/' ), 301, 'VV Crawl' );
		exit;
	}
}, 1 );

/* Feeds are for readers, not search results. */
add_action( 'template_redirect', function () {
	if ( is_feed() ) {
		header( 'X-Robots-Tag: noindex, follow', true );
	}
}, 2 );
