<?php
/**
 * Link-in-bio page (/links/) for Instagram. Run server-side with eval() in Novamira execute-php, with $vv_base set to
 * the raw GitHub URL of wordpress/ at a commit (see run-blog.php for why eval, not include):
 *   $vv_base = 'https://raw.githubusercontent.com/<owner>/<repo>/<sha>/wordpress/';
 *   return eval( preg_replace( '/^<\?php/', '', wp_remote_retrieve_body( wp_remote_get( $vv_base . 'build/pages/links.php' ) ) ) );
 *
 * Installs mu-plugins/vv-links.php, stores content/links.json in the vv_links option, and creates (or reuses) the page.
 * The page is drawn by vv-links.php, kept out of search (noindex, follow) and linked from nowhere on the site.
 * To add an Instagram post link: edit content/links.json, push, and run this again.
 */
$get = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};

$mu = $get( 'mu-plugins/vv-links.php' );
if ( false === strpos( $mu, 'Plugin Name: VV Links' ) ) { return array( 'error' => 'mu-plugin fetch failed' ); }
file_put_contents( WPMU_PLUGIN_DIR . '/vv-links.php', $mu );

$json = $get( 'content/links.json' );
$data = json_decode( $json, true );
if ( ! is_array( $data ) || empty( $data['fixed'] ) ) { return array( 'error' => 'links.json is not valid JSON' ); }
update_option( 'vv_links', wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ), false );

$page = get_page_by_path( 'links', OBJECT, 'page' );
$id   = $page ? $page->ID : wp_insert_post( array(
	'post_type' => 'page', 'post_title' => 'Links', 'post_name' => 'links', 'post_status' => 'publish',
	'post_content' => '', 'comment_status' => 'closed', 'ping_status' => 'closed',
), true );
if ( is_wp_error( $id ) ) { return array( 'error' => $id->get_error_message() ); }
update_post_meta( $id, 'vv_links', '1' );
update_post_meta( $id, 'rank_math_robots', array( 'noindex', 'follow' ) );
update_post_meta( $id, 'rank_math_title', 'Links | Vineet Vijay' );
update_post_meta( $id, 'rank_math_description', 'Links from Vineet Vijay\'s Instagram posts: essays on AI, SEO and paid media, and free marketing tools.' );

do_action( 'litespeed_purge_all' );
return array( 'id' => $id, 'url' => get_permalink( $id ), 'posts' => count( $data['posts'] ?? array() ) );
