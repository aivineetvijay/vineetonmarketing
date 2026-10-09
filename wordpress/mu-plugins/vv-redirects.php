<?php
/**
 * Plugin Name: VV Redirects
 * Description: Permanent (301) redirects for URLs that moved or were retired.
 *              /blog/ became /writing/ (30 September 2026). On 9 October 2026 the AI in Marketing page (/ai/) was
 *              retired in favour of /writing/, the case studies were moved to draft (their roles are on /experience/),
 *              and category archives were switched off (the Writing page has the category filters).
 * Version:     1.1.0
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
