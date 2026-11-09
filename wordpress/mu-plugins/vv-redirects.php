<?php
/**
 * Plugin Name: VV Redirects
 * Description: Permanent (301) redirects for URLs that moved or were retired.
 *              /blog/ became /writing/ (30 September 2026). On 9 October 2026 the AI in Marketing page (/ai/) was
 *              retired in favour of /writing/, the case studies were moved to draft (their roles are on /experience/),
 *              and category archives were switched off (the Writing page has the category filters).
 *              9 November 2026: the early essays that were taken down, and the sample page.
 * Version:     1.2.0
 *
 * Install: copy to wp-content/mu-plugins/vv-redirects.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

function vv_redirect_target( $path ) {
	$map = array(
		'blog'         => '/writing/',
		'ai'           => '/writing/',
		'case-studies' => '/experience/',
	);
	if ( isset( $map[ $path ] ) ) {
		return $map[ $path ];
	}
	if ( 0 === strpos( $path, 'case-studies/' ) ) {
		return '/experience/';
	}
	if ( 'category' === $path || 0 === strpos( $path, 'category/' ) ) {
		return '/writing/';
	}
	/* Early essays taken down on 25-30 September 2026 (Search Console listed them as 404s), and WordPress's
	   default sample page. Skipped if a published post or page is ever put back at the same address. */
	$retired = array(
		'ai-search-readiness'             => '/rank-in-ai-overviews/',
		'technical-debt-nobody-audits'    => '/writing/',
		'three-creative-workflows'        => '/writing/',
		'holdouts-not-optional'           => '/writing/',
		'quarterly-cadence'               => '/writing/',
		'stop-optimising-the-wrong-thing' => '/writing/',
		'mmm-you-can-run-on-monday'       => '/writing/',
		'sample-page'                     => '/',
	);
	if ( isset( $retired[ $path ] ) ) {
		$live = get_page_by_path( $path, OBJECT, array( 'post', 'page' ) );
		if ( ! $live || 'publish' !== $live->post_status ) {
			return $retired[ $path ];
		}
	}
	return null;
}

add_action( 'template_redirect', function () {
	if ( is_user_logged_in() && ( is_preview() || isset( $_GET['preview'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return; // Drafts stay previewable in the editor.
	}
	$path   = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	$target = vv_redirect_target( $path );
	if ( $target ) {
		$query = (string) wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY );
		wp_safe_redirect( home_url( $target ) . ( $query ? '?' . $query : '' ), 301, 'VV Redirects' );
		exit;
	}
}, 1 );
