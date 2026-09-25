<?php
/**
 * Snapshot helper: fetches a page's logged-in preview and zips it with the
 * local assets it references, so it can be rendered outside the server.
 */
function vv_bundle( $post_id ) {
	$cookie = wp_generate_auth_cookie( 1, time() + 600, 'logged_in' );
	$url = 'publish' === get_post_status( $post_id ) ? get_permalink( $post_id ) : get_preview_post_link( $post_id );
	$r = wp_remote_get( $url, array( 'timeout' => 45, 'sslverify' => false, 'cookies' => array( new WP_Http_Cookie( array( 'name' => LOGGED_IN_COOKIE, 'value' => $cookie ) ) ) ) );
	$html = wp_remote_retrieve_body( $r );
	$host = preg_quote( wp_parse_url( home_url(), PHP_URL_HOST ), '/' );
	preg_match_all( '/https?:\/\/' . $host . '(\/[^"\'\s\)\?,]+)/', $html, $m );
	$zf = wp_tempnam( 'vv-bundle' );
	$zip = new ZipArchive();
	$zip->open( $zf, ZipArchive::OVERWRITE );
	$zip->addFromString( 'index.html', $html );
	foreach ( array_unique( $m[1] ) as $p ) {
		$local = ABSPATH . ltrim( urldecode( $p ), '/' );
		if ( is_file( $local ) && filesize( $local ) < 3000000 && preg_match( '/\.(css|js|webp|png|jpe?g|svg|woff2?|ttf)$/i', $local ) ) {
			$zip->addFile( $local, 'site' . $p );
		}
	}
	$zip->close();
	$b = base64_encode( file_get_contents( $zf ) );
	unlink( $zf );
	return $b;
}
