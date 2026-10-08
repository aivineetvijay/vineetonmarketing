<?php
/**
 * Plugin Name: VV Tools
 * Description: Serves standalone tools (static HTML apps) under /ai-tools/<tool>/<variant>/ from
 *              wp-content/uploads/vv-tools/. The files live outside the web root's /ai-tools/ path, so the
 *              WordPress "AI Tools" page (slug ai-tools) keeps working when it is published. Every response is
 *              noindex, nofollow: the tools are shared by link only and stay out of search and the sitemap.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-tools.php; tool files go in wp-content/uploads/vv-tools/
 * (see wordpress/tools/install-tools.php).
 */

defined( 'ABSPATH' ) || exit;

/** URL prefix => folder inside wp-content/uploads/vv-tools/. */
const VV_TOOLS = array(
	'ai-tools/llms-txt-generator/real-estate' => 'llms-txt-generator/real-estate',
);

add_action( 'parse_request', function () {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	foreach ( VV_TOOLS as $prefix => $dir ) {
		if ( $path !== $prefix && 0 !== strpos( $path, $prefix . '/' ) ) {
			continue;
		}
		if ( $path === $prefix && '/' !== substr( wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), -1 ) ) {
			wp_safe_redirect( home_url( '/' . $prefix . '/' ), 301, 'VV Tools' );
			exit;
		}
		$base = realpath( wp_get_upload_dir()['basedir'] . '/vv-tools/' . $dir );
		$rel  = rawurldecode( substr( $path, strlen( $prefix ) ) );
		$file = $base ? realpath( $base . ( '' === trim( $rel, '/' ) ? '/index.html' : $rel ) ) : false;
		/* Only files inside the tool's own folder. */
		if ( ! $file || ! is_file( $file ) || 0 !== strpos( $file, $base . DIRECTORY_SEPARATOR ) ) {
			return;
		}
		$types = array( 'html' => 'text/html; charset=utf-8', 'js' => 'application/javascript; charset=utf-8', 'css' => 'text/css; charset=utf-8', 'json' => 'application/json', 'png' => 'image/png', 'webp' => 'image/webp', 'svg' => 'image/svg+xml' );
		$ext   = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
		if ( ! isset( $types[ $ext ] ) ) {
			return;
		}
		do_action( 'litespeed_control_set_nocache', 'vv-tools' );
		status_header( 200 );
		header( 'Content-Type: ' . $types[ $ext ] );
		header( 'X-Robots-Tag: noindex, nofollow' );
		header( 'Cache-Control: no-cache' );
		header( 'Content-Length: ' . filesize( $file ) );
		readfile( $file );
		exit;
	}
}, 0 );

/** Keep the tool URLs out of Rank Math's llms.txt and sitemap (they are not WordPress posts, so this is belt and braces). */
add_filter( 'wp_robots', function ( $robots ) {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	foreach ( array_keys( VV_TOOLS ) as $prefix ) {
		if ( 0 === strpos( $path, $prefix ) ) {
			$robots['noindex'] = true; $robots['nofollow'] = true;
		}
	}
	return $robots;
} );
