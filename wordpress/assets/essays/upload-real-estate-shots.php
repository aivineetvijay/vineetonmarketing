<?php
/**
 * Server-side: converts the two Emaar screenshots for "Seven schemas every property site needs." to WebP
 * (GD, longest edge <= 1600px, well under 400 KB) and adds them to the media library with SEO filenames,
 * alt text (leading with the focus keyword) and captions. Expects $vv_get( $path ) to fetch repo files.
 */
$shots = array(
	array( 'emaar-the-oasis-community-page-breadcrumb.jpg', 'schema-markup-for-real-estate-emaar-oasis-breadcrumb',
		'Schema markup for real estate example: The Oasis by Emaar community page showing a visible breadcrumb (Home, All Communities, The Oasis by Emaar) that is not marked up for machines',
		'The Oasis by Emaar community page. The breadcrumb is visible to buyers but not marked up for machines. Screenshot taken 30 September 2026.' ),
	array( 'emaar-the-oasis-prices-from-zero.jpg', 'schema-markup-for-real-estate-emaar-oasis-prices-from-zero',
		'Schema markup for real estate example: The Oasis by Emaar page with a sticky bar reading Prices from 0',
		'The sticky bar on The Oasis page read "Prices from 0" at the time of checking. Screenshot taken 30 September 2026.' ),
);
require_once ABSPATH . 'wp-admin/includes/image.php';
$out = array();
foreach ( $shots as $s ) {
	list( $file, $name, $alt, $caption ) = $s;
	$im = imagecreatefromstring( $vv_get( 'assets/essays/' . $file ) );
	$w = imagesx( $im ); $h = imagesy( $im );
	if ( max( $w, $h ) > 1600 ) { $k = 1600 / max( $w, $h ); $im = imagescale( $im, (int) round( $w * $k ), (int) round( $h * $k ) ); }
	$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $name, 'numberposts' => 1, 'post_status' => 'inherit' ) );
	if ( $existing ) { wp_delete_attachment( $existing[0]->ID, true ); }
	$up = wp_upload_dir();
	$path = trailingslashit( $up['path'] ) . wp_unique_filename( $up['path'], $name . '.webp' );
	imagewebp( $im, $path, 85 );
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/webp', 'post_title' => $alt, 'post_excerpt' => $caption, 'post_status' => 'inherit', 'post_name' => $name ), $path );
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	$out[ $file ] = array( 'id' => $id, 'kb' => round( filesize( $path ) / 1024 ), 'size' => array( imagesx( $im ), imagesy( $im ) ) );
}
return $out;
