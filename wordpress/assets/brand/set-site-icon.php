<?php
/**
 * Server-side: sets the site icon (favicon, Apple touch icon, Android/PWA icon) from
 * wordpress/assets/brand/site-icon.png, a 512x512 "VV." monogram in the site colours
 * (#1d1d1f tile, white Inter Bold, Action Blue #0071e3 dot). WordPress generates the
 * 32, 180, 192 and 270px sizes and prints the <link rel="icon"> tags itself.
 * Re-running replaces the previous icon.
 *
 * Calling pattern (see wordpress/README.md for the runner): include from the top-level execute-php code with
 * $vv_files['assets/brand/site-icon.png'] = a temp file holding the PNG, written by the caller. Code in an
 * included temp file cannot call file_put_contents(), so this file writes nothing itself. WordPress core
 * (wp_handle_sideload) moves the temp file into uploads. Without that entry it returns
 * array( 'vv_need' => array( 'assets/brand/site-icon.png' ) ) before changing anything.
 */
if ( empty( $vv_files['assets/brand/site-icon.png'] ) ) { return array( 'vv_need' => array( 'assets/brand/site-icon.png' ) ); }
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-site-icon.php';
$name = 'vineet-vijay-site-icon';
$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $name, 'numberposts' => 1, 'post_status' => 'inherit' ) );
if ( $existing ) { wp_delete_attachment( $existing[0]->ID, true ); }
$file = wp_handle_sideload( array( 'name' => $name . '.png', 'tmp_name' => $vv_files['assets/brand/site-icon.png'] ), array( 'test_form' => false ) );
if ( isset( $file['error'] ) ) { return array( 'error' => $file['error'] ); }
$path = $file['file'];
$id = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => 'Vineet Vijay site icon', 'post_status' => 'inherit', 'post_name' => $name ), $path );
update_post_meta( $id, '_wp_attachment_context', 'site-icon' );
update_post_meta( $id, '_wp_attachment_image_alt', 'Vineet Vijay' );
$icon = new WP_Site_Icon();
add_filter( 'intermediate_image_sizes_advanced', array( $icon, 'additional_sizes' ) );
wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
remove_filter( 'intermediate_image_sizes_advanced', array( $icon, 'additional_sizes' ) );
update_option( 'site_icon', $id );
return array( 'id' => $id, 'kb' => round( filesize( $path ) / 1024 ), 'sizes' => array_keys( wp_get_attachment_metadata( $id )['sizes'] ?? array() ), 'url32' => get_site_icon_url( 32 ) );
