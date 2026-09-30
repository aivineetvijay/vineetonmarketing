<?php
/**
 * Server-side: builds the schema essay's banner images from the 1024x768 source (GD), saves them as WebP
 * and adds them to the media library with SEO filenames, alt text, title and description.
 *  - desktop banner 1500x500 (3:1): source rows 140-640 (resume + JSON), widened with each edge's own
 *    smoothed background tone and a soft blend on the right edge, so object-fit: cover never cuts the resume.
 *  - mobile banner / featured image 1024x640 (16:10): source rows 64-704. Also used for the blog card
 *    (16:10) and social sharing.
 * Expects $vv_src (source image bytes). Returns the attachment IDs.
 */
$src = imagecreatefromstring( $vv_src );
if ( ! $src || 1024 !== imagesx( $src ) || 768 !== imagesy( $src ) ) { return array( 'error' => 'unexpected source image' ); }

$rgb = function ( $im, $x, $y ) { $v = imagecolorat( $im, $x, $y ); return array( ( $v >> 16 ) & 255, ( $v >> 8 ) & 255, $v & 255 ); };
/* Average colour of a box, clamped to the image. */
$avg = function ( $im, $x0, $x1, $y0, $y1 ) use ( $rgb ) {
	$y0 = max( 0, $y0 ); $y1 = min( imagesy( $im ) - 1, $y1 ); $s = array( 0, 0, 0 ); $n = 0;
	for ( $y = $y0; $y <= $y1; $y += 2 ) { for ( $x = $x0; $x <= $x1; $x += 2 ) { $c = $rgb( $im, $x, $y ); $s[0] += $c[0]; $s[1] += $c[1]; $s[2] += $c[2]; $n++; } }
	return array( $s[0] / $n, $s[1] / $n, $s[2] / $n );
};

/* Desktop 1500x500. */
$top = 140; $h = 500; $w = 1500; $pad = 238; $feather = 120;
$out = imagecreatetruecolor( $w, $h );
imagecopy( $out, $src, $pad, 0, 0, $top, 1024, $h );
for ( $y = 0; $y < $h; $y++ ) {
	$l = $avg( $src, 0, 8, $top + $y - 10, $top + $y + 10 );
	$r = $avg( $src, 1000, 1023, $top + $y - 40, $top + $y + 40 );
	$lc = imagecolorallocate( $out, (int) $l[0], (int) $l[1], (int) $l[2] );
	$rc = imagecolorallocate( $out, (int) $r[0], (int) $r[1], (int) $r[2] );
	imageline( $out, 0, $y, $pad - 1, $y, $lc );
	imageline( $out, $pad + 1024, $y, $w - 1, $y, $rc );
	for ( $i = 0; $i < $feather; $i++ ) { /* blend the image's right edge into the right tone (smoothstep) */
		$t = ( $i + 1 ) / $feather; $t = $t * $t * ( 3 - 2 * $t );
		$x = $pad + 1024 - $feather + $i; $c = $rgb( $out, $x, $y );
		imagesetpixel( $out, $x, $y, imagecolorallocate( $out, (int) ( $c[0] + ( $r[0] - $c[0] ) * $t ), (int) ( $c[1] + ( $r[1] - $c[1] ) * $t ), (int) ( $c[2] + ( $r[2] - $c[2] ) * $t ) ) );
	}
}
$desktop = $out;

/* Mobile + featured 1024x640. */
$mobile = imagecreatetruecolor( 1024, 640 );
imagecopy( $mobile, $src, 0, 0, 0, 64, 1024, 640 );

$alt   = 'A resume mapped line by line to Schema.org Person markup in JSON-LD (sameAs, alumniOf, worksFor, jobTitle, knowsAbout) and linked into a knowledge graph of entities';
$title = 'Schema markup is your website’s resume';
$desc  = 'Illustration for the essay "Schema is your website’s resume": resume sections become JSON-LD properties, which connect to entities in a knowledge graph.';
$save = function ( $im, $name, $alt_text ) use ( $title, $desc ) {
	$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $name, 'numberposts' => 1, 'post_status' => 'inherit' ) );
	if ( $existing ) { wp_delete_attachment( $existing[0]->ID, true ); }
	$up = wp_upload_dir();
	$file = wp_unique_filename( $up['path'], $name . '.webp' );
	$path = trailingslashit( $up['path'] ) . $file;
	imagewebp( $im, $path, 82 );
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/webp', 'post_title' => $title, 'post_content' => $desc, 'post_excerpt' => '', 'post_status' => 'inherit', 'post_name' => $name ), $path );
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt_text );
	return array( 'id' => $id, 'url' => wp_get_attachment_url( $id ), 'kb' => round( filesize( $path ) / 1024 ), 'size' => array( imagesx( $im ), imagesy( $im ) ) );
};
return array(
	'desktop' => $save( $desktop, 'schema-markup-ai-visibility-banner', $alt ),
	'mobile'  => $save( $mobile, 'schema-markup-ai-visibility-banner-mobile', $alt ),
);
