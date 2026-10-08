<?php
/**
 * Server-side: adds the llms.txt hub's industry icons (24px line icons, Action Blue stroke) to the media library
 * as SVG attachments named llms-icon-<slug>, for Elementor's native SVG element. Re-running replaces them.
 * Expects $vv_base (raw GitHub URL of wordpress/ at a commit). Returns slug => attachment id.
 */
$out = array();
foreach ( array( 'real-estate', 'healthcare', 'ecommerce', 'education', 'finance', 'publishers', 'travel', 'small-business' ) as $slug ) {
	$svg = wp_remote_retrieve_body( wp_remote_get( $vv_base . 'assets/icons/llms/' . $slug . '.svg', array( 'timeout' => 30 ) ) );
	if ( 0 !== strpos( $svg, '<svg' ) ) { return array( 'error' => 'fetch failed: ' . $slug ); }
	$name = 'llms-icon-' . $slug;
	$old  = get_posts( array( 'post_type' => 'attachment', 'name' => $name, 'post_status' => 'inherit', 'numberposts' => 1 ) );
	if ( $old ) { wp_delete_attachment( $old[0]->ID, true ); }
	$up   = wp_upload_dir();
	$path = trailingslashit( $up['path'] ) . wp_unique_filename( $up['path'], $name . '.svg' );
	file_put_contents( $path, $svg );
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/svg+xml', 'post_title' => 'Icon: ' . ucwords( str_replace( '-', ' ', $slug ) ), 'post_status' => 'inherit', 'post_name' => $name ), $path );
	wp_update_attachment_metadata( $id, array( 'width' => 24, 'height' => 24, 'file' => _wp_relative_upload_path( $path ) ) );
	update_post_meta( $id, '_wp_attachment_image_alt', '' );
	$out[ $slug ] = $id;
}
return $out;
