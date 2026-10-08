<?php
/**
 * Server-side installer for the llms.txt generators. Expects $vv_base (raw GitHub URL of wordpress/ at a commit).
 *  1. Copies the shared engine (assets/) and each industry's config.js to wp-content/uploads/vv-tools/llms-txt-generator/.
 *  2. Installs the vv-tools mu-plugin, which renders the tool pages inside the theme.
 *  3. Creates or updates one page per tool under the hub (/ai-tools/llms-txt-generator/<slug>/), noindex.
 *  4. Removes the old standalone Real Estate build (index.html, support.js, _ds/) that the pages replace.
 * Re-running is safe: files are overwritten and pages are matched by slug under the hub.
 */
$fetch = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};
$tmp = wp_tempnam( 'vv' ); file_put_contents( $tmp, $fetch( 'tools/llms-txt-generator/tools.php' ) ); $tools = include $tmp; @unlink( $tmp );

$root = wp_get_upload_dir()['basedir'] . '/vv-tools/llms-txt-generator/';
$files = array( 'assets/generator.js', 'assets/generator.css' );
foreach ( array_keys( $tools ) as $slug ) { $files[] = $slug . '/config.js'; }
$copied = array();
foreach ( $files as $rel ) {
	wp_mkdir_p( dirname( $root . $rel ) );
	file_put_contents( $root . $rel, $fetch( 'tools/llms-txt-generator/' . $rel ) );
	$copied[ $rel ] = filesize( $root . $rel );
}

$mu = $fetch( 'mu-plugins/vv-tools.php' );
if ( false === strpos( $mu, 'Plugin Name: VV Tools' ) ) { return array( 'error' => 'mu-plugin fetch failed' ); }
file_put_contents( WPMU_PLUGIN_DIR . '/vv-tools.php', $mu );

/* Old standalone Real Estate build. */
$old = $root . 'real-estate/';
foreach ( array( 'index.html', 'support.js' ) as $f ) { if ( is_file( $old . $f ) ) { unlink( $old . $f ); } }
if ( is_dir( $old . '_ds' ) ) {
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $old . '_ds', FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST );
	foreach ( $it as $item ) { $item->isDir() ? rmdir( $item->getPathname() ) : unlink( $item->getPathname() ); }
	rmdir( $old . '_ds' );
}

$hub = get_page_by_path( 'ai-tools/llms-txt-generator' );
if ( ! $hub ) { return array( 'error' => 'hub page not found' ); }
$pages = array(); $order = 0;
foreach ( $tools as $slug => $t ) {
	$order++;
	$existing = get_posts( array( 'post_type' => 'page', 'name' => $slug, 'post_parent' => $hub->ID, 'post_status' => 'any', 'numberposts' => 1 ) );
	$data = array( 'post_type' => 'page', 'post_title' => $t['title'], 'post_name' => $slug, 'post_parent' => $hub->ID, 'post_status' => 'publish', 'post_excerpt' => $t['lead'], 'menu_order' => $order, 'comment_status' => 'closed', 'ping_status' => 'closed' );
	if ( $existing ) { $data['ID'] = $existing[0]->ID; }
	$id = $existing ? wp_update_post( wp_slash( $data ), true ) : wp_insert_post( wp_slash( $data ), true );
	if ( is_wp_error( $id ) ) { return array( 'error' => $slug . ': ' . $id->get_error_message() ); }
	$meta = array(
		'vv_tool' => $slug, 'vv_tool_h1' => $t['h1'], 'vv_tool_label' => $t['label'],
		'ast-site-content-layout' => 'full-width-container', 'site-content-style' => 'unboxed', 'site-sidebar-layout' => 'no-sidebar', 'site-post-title' => 'disabled',
		'rank_math_title' => $t['seo_t'], 'rank_math_description' => $t['seo_d'], 'rank_math_facebook_title' => $t['seo_t'], 'rank_math_facebook_description' => $t['seo_d'],
		'rank_math_focus_keyword' => 'llms.txt generator for ' . strtolower( $t['label'] ), 'rank_math_breadcrumb_title' => $t['label'],
		'rank_math_robots' => array( 'noindex' ),
	);
	foreach ( $meta as $k => $v ) { update_post_meta( $id, $k, $v ); }
	$pages[ $slug ] = array( 'id' => $id, 'url' => get_permalink( $id ) );
}

if ( class_exists( '\RankMath\Sitemap\Cache' ) ) { \RankMath\Sitemap\Cache::invalidate_storage(); }
do_action( 'litespeed_purge_all' );
return array( 'copied' => $copied, 'pages' => $pages );
