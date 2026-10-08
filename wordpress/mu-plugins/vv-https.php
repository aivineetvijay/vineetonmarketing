<?php
/**
 * Plugin Name: VV HTTPS
 * Description: HTTPS hardening. Sends Strict-Transport-Security (HSTS, one year) on every HTTPS response so browsers
 *              never request the site over plain HTTP. http:// and www. requests already 301 to https://vineetonmarketing.com
 *              at the host. includeSubDomains is left off so subdomains without a certificate (mail etc.) are unaffected.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-https.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

$vv_hsts = function () {
	if ( is_ssl() && ! headers_sent() ) {
		header( 'Strict-Transport-Security: max-age=31536000' );
	}
};
add_action( 'send_headers', $vv_hsts );
add_action( 'login_init', $vv_hsts );
add_action( 'admin_init', $vv_hsts );
