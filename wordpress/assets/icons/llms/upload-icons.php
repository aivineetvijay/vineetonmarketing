<?php
/**
 * Server-side: adds the llms.txt hub's industry icons (24px line icons, Action Blue stroke) to the media library
 * as SVG attachments named llms-icon-<slug>, for Elementor's native SVG element. Re-running replaces them.
 * Returns slug => attachment id.
 *
 * Calling pattern (see wordpress/README.md for the runner): include from the top-level execute-php code with
 * $vv_files['assets/icons/llms/<slug>.svg'] = a temp file holding each icon, written by the caller. Code in an
 * included temp file cannot call file_put_contents(), so this file writes nothing itself. WordPress core
 * (wp_handle_sideload) moves each temp file into uploads. Without those entries it returns
 * array( 'vv_need' => <paths> ) before changing anything.
 */
require_once ABSPATH . 'wp-admin/includes/file.php';
$slugs = array( 'real-estate', 'healthcare', 'ecommerce', 'education', 'finance', 'publishers', 'travel', 'small-business' );
$need  = array();
foreach ( $slugs as $slug ) { if ( empty( $vv_files[ 'assets/icons/llms/' . $slug . '.svg' ] ) ) { $need[] = 'assets/icons/llms/' . $slug . '.svg'; } }
if ( $need ) { return array( 'vv_need' => $need ); }
$out = array();
foreach ( $slugs as $slug ) {
	$name = 'llms-icon-' . $slug;
	$old  = get_posts( array( 'post_type' => 'attachment', 'name' => $name, 'post_status' => 'inherit', 'numberposts' => 1 ) );
	if ( $old ) { wp_delete_attachment( $old[0]->ID, true ); }
	$upload = array( 'name' => $name . '.svg', 'tmp_name' => $vv_files[ 'assets/icons/llms/' . $slug . '.svg' ] );
	$file = wp_handle_sideload( $upload, array( 'test_form' => false, 'test_type' => false ) );
	if ( isset( $file['error'] ) ) { return array( 'error' => $slug . ': ' . $file['error'] ); }
	$path = $file['file'];
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/svg+xml', 'post_title' => 'Icon: ' . ucwords( str_replace( '-', ' ', $slug ) ), 'post_status' => 'inherit', 'post_name' => $name ), $path );
	wp_update_attachment_metadata( $id, array( 'width' => 24, 'height' => 24, 'file' => _wp_relative_upload_path( $path ) ) );
	update_post_meta( $id, '_wp_attachment_image_alt', '' );
	$out[ $slug ] = $id;
}
return $out;
