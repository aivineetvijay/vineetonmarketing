<?php
/**
 * Server-side: replaces the schema essay's desktop banner (attachment 452) with the supplied 3:1 artwork.
 * Resizes to at most 1600px wide (GD), saves WebP under a new filename so caches pick up the change, keeps
 * the attachment ID (so the Elementor layout needs no rebuild), regenerates the srcset sizes and removes the
 * old files. Expects $vv_src (source image bytes).
 */
$id  = 452;
$src = imagecreatefromstring( $vv_src );
if ( ! $src ) { return array( 'error' => 'unreadable source' ); }
$sw = imagesx( $src ); $sh = imagesy( $src );
$w  = min( 1600, $sw ); $h = (int) round( $sh * $w / $sw );
$out = imagecreatetruecolor( $w, $h );
imagecopyresampled( $out, $src, 0, 0, 0, 0, $w, $h, $sw, $sh );

require_once ABSPATH . 'wp-admin/includes/image.php';
$old_file = get_attached_file( $id );
$old_meta = wp_get_attachment_metadata( $id );
$dir      = dirname( $old_file );
$name     = wp_unique_filename( $dir, 'schema-markup-ai-visibility-banner-desktop.webp' );
$path     = trailingslashit( $dir ) . $name;
imagewebp( $out, $path, 82 );

/* Remove the old file and its generated sizes. */
if ( ! empty( $old_meta['sizes'] ) ) { foreach ( $old_meta['sizes'] as $s ) { @unlink( trailingslashit( $dir ) . $s['file'] ); } }
if ( $old_file && $old_file !== $path ) { @unlink( $old_file ); }

update_attached_file( $id, $path );
wp_update_post( array( 'ID' => $id, 'post_mime_type' => 'image/webp' ) );
wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );

return array( 'id' => $id, 'source' => array( $sw, $sh ), 'size' => array( $w, $h ), 'kb' => round( filesize( $path ) / 1024 ), 'url' => wp_get_attachment_url( $id ), 'alt' => get_post_meta( $id, '_wp_attachment_image_alt', true ) );
