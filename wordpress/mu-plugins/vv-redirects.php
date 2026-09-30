<?php
/**
 * Plugin Name: VV Redirects
 * Description: Permanent (301) redirects for URLs that moved. /blog/ became /writing/ on 30 September 2026.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-redirects.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'template_redirect', function () {
	$map  = array( 'blog' => '/writing/' );
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( isset( $map[ $path ] ) ) {
		$query = (string) wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY );
		wp_safe_redirect( home_url( $map[ $path ] ) . ( $query ? '?' . $query : '' ), 301, 'VV Redirects' );
		exit;
	}
}, 1 );
