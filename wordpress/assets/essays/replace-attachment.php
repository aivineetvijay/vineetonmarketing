<?php
/**
 * Server-side: replaces the image file behind an existing attachment ($vv_id) with new artwork ($vv_src bytes).
 * Resizes to at most 1600px on the longest edge (GD), saves WebP as $vv_name.webp (a new filename, so caches
 * pick up the change), keeps the ID, alt text and caption, regenerates srcset sizes and removes the old files.
 */
$src = imagecreatefromstring( $vv_src );
if ( ! $src ) { return array( 'error' => 'unreadable source' ); }
$sw = imagesx( $src ); $sh = imagesy( $src ); $k = min( 1, 1600 / max( $sw, $sh ) );
$w = (int) round( $sw * $k ); $h = (int) round( $sh * $k );
$out = imagecreatetruecolor( $w, $h );
imagecopyresampled( $out, $src, 0, 0, 0, 0, $w, $h, $sw, $sh );

require_once ABSPATH . 'wp-admin/includes/image.php';
$old_file = get_attached_file( $vv_id );
$old_meta = wp_get_attachment_metadata( $vv_id );
$dir  = dirname( $old_file );
$path = trailingslashit( $dir ) . wp_unique_filename( $dir, $vv_name . '.webp' );
imagewebp( $out, $path, 85 );
if ( ! empty( $old_meta['sizes'] ) ) { foreach ( $old_meta['sizes'] as $s ) { @unlink( trailingslashit( $dir ) . $s['file'] ); } }
if ( $old_file && $old_file !== $path ) { @unlink( $old_file ); }
update_attached_file( $vv_id, $path );
wp_update_post( array( 'ID' => $vv_id, 'post_mime_type' => 'image/webp' ) );
wp_update_attachment_metadata( $vv_id, wp_generate_attachment_metadata( $vv_id, $path ) );
return array( 'id' => $vv_id, 'source' => array( $sw, $sh ), 'size' => array( $w, $h ), 'kb' => round( filesize( $path ) / 1024 ), 'url' => wp_get_attachment_url( $vv_id ), 'alt' => get_post_meta( $vv_id, '_wp_attachment_image_alt', true ) );
