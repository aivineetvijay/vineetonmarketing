<?php
/**
 * Server-side: adds one image to the media library. Resizes to at most 1600px on the longest edge (GD), saves
 * WebP as $vv_name.webp, sets alt text, title and description, generates srcset sizes. Re-running replaces the
 * attachment with the same name. Expects $vv_src (bytes), $vv_name, $vv_alt, $vv_title, $vv_desc.
 */
$src = imagecreatefromstring( $vv_src );
if ( ! $src ) { return array( 'error' => 'unreadable source' ); }
$sw = imagesx( $src ); $sh = imagesy( $src ); $k = min( 1, 1600 / max( $sw, $sh ) );
$w = (int) round( $sw * $k ); $h = (int) round( $sh * $k );
$out = imagecreatetruecolor( $w, $h );
imagecopyresampled( $out, $src, 0, 0, 0, 0, $w, $h, $sw, $sh );
require_once ABSPATH . 'wp-admin/includes/image.php';
$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $vv_name, 'numberposts' => 1, 'post_status' => 'inherit' ) );
if ( $existing ) { wp_delete_attachment( $existing[0]->ID, true ); }
$up = wp_upload_dir();
$path = trailingslashit( $up['path'] ) . wp_unique_filename( $up['path'], $vv_name . '.webp' );
imagewebp( $out, $path, 84 );
$id = wp_insert_attachment( array( 'post_mime_type' => 'image/webp', 'post_title' => $vv_title, 'post_content' => $vv_desc, 'post_status' => 'inherit', 'post_name' => $vv_name ), $path );
wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
update_post_meta( $id, '_wp_attachment_image_alt', $vv_alt );
return array( 'id' => $id, 'source' => array( $sw, $sh ), 'size' => array( $w, $h ), 'kb' => round( filesize( $path ) / 1024 ), 'url' => wp_get_attachment_url( $id ) );
