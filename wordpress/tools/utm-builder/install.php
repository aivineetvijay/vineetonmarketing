<?php
/**
 * Server-side installer for the UTM builder. Run the body of this file as top-level code through Novamira
 * execute-php, with $vv_base set to the raw GitHub URL of wordpress/ at a commit
 * (https://raw.githubusercontent.com/<owner>/<repo>/<sha>/wordpress/). Do not include() it: the host returns
 * nothing from file writes made inside an included file.
 *
 *  1. Copies the builder (src/*.js, page.js, utm.css, pages.json) to wp-content/uploads/vv-tools/utm-builder/.
 *     configs.js is wrapped so its definitions stay out of the global scope (page.js reads window.UTM_CFG_MODULE).
 *  2. Installs the vv-utm mu-plugin, which renders the pages inside the theme.
 *  3. Creates or updates the hub page (/ai-tools/utm-builder/, the basic builder) and one child page per
 *     industry builder, indexable, with Rank Math meta and FAQPage data (vv_faq).
 * Re-running is safe: files are overwritten and pages are matched by slug and parent.
 */
$vv_utm_fetch = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};
$vv_utm_root = wp_get_upload_dir()['basedir'] . '/vv-tools/utm-builder/';
wp_mkdir_p( $vv_utm_root );
$vv_utm_files = array(
	'configs.js' => "/* Builder definitions (src/configs.js), wrapped for the browser. */\n(function (module) {\n" . $vv_utm_fetch( 'tools/utm-builder/src/configs.js' ) . "\n})(window.UTM_CFG_MODULE = { exports: {} });\n",
	'ga4.js'     => $vv_utm_fetch( 'tools/utm-builder/src/ga4.js' ),
	'qrcode.js'  => $vv_utm_fetch( 'tools/utm-builder/src/qrcode.js' ),
	'engine.js'  => $vv_utm_fetch( 'tools/utm-builder/src/engine.js' ),
	'page.js'    => $vv_utm_fetch( 'tools/utm-builder/page.js' ),
	'utm.css'    => $vv_utm_fetch( 'tools/utm-builder/utm.css' ),
	'pages.json' => $vv_utm_fetch( 'tools/utm-builder/pages.json' ),
);
$vv_utm_copied = array();
foreach ( $vv_utm_files as $f => $body ) {
	file_put_contents( $vv_utm_root . $f, $body );
	clearstatcache();
	$vv_utm_copied[ $f ] = is_file( $vv_utm_root . $f ) ? filesize( $vv_utm_root . $f ) : 0;
	if ( $vv_utm_copied[ $f ] < 100 ) { return array( 'error' => 'write failed: ' . $f, 'copied' => $vv_utm_copied ); }
}

$vv_utm_mu = $vv_utm_fetch( 'mu-plugins/vv-utm.php' );
if ( false === strpos( $vv_utm_mu, 'Plugin Name: VV UTM Builder' ) ) { return array( 'error' => 'mu-plugin fetch failed' ); }
file_put_contents( WPMU_PLUGIN_DIR . '/vv-utm.php', $vv_utm_mu );

$vv_utm_tools = get_page_by_path( 'ai-tools' );
if ( ! $vv_utm_tools ) { return array( 'error' => 'AI Tools page not found' ); }
$vv_utm_data  = json_decode( $vv_utm_files['pages.json'], true );
$vv_utm_pages = array();
$vv_utm_hub   = 0;
$vv_utm_order = 0;
foreach ( $vv_utm_data['pages'] as $p ) {
	$vv_utm_order++;
	$parent = $p['slug'] ? $vv_utm_hub : $vv_utm_tools->ID;
	$slug   = $p['slug'] ? $p['slug'] : 'utm-builder';
	$found  = get_posts( array( 'post_type' => 'page', 'name' => $slug, 'post_parent' => $parent, 'post_status' => 'any', 'numberposts' => 1 ) );
	$post   = array( 'post_type' => 'page', 'post_title' => $p['name'], 'post_name' => $slug, 'post_parent' => $parent, 'post_status' => 'publish', 'post_excerpt' => $p['description'], 'menu_order' => $vv_utm_order, 'comment_status' => 'closed', 'ping_status' => 'closed' );
	if ( $found ) { $post['ID'] = $found[0]->ID; }
	$id = $found ? wp_update_post( wp_slash( $post ), true ) : wp_insert_post( wp_slash( $post ), true );
	if ( is_wp_error( $id ) ) { return array( 'error' => $slug . ': ' . $id->get_error_message() ); }
	if ( ! $p['slug'] ) { $vv_utm_hub = $id; }
	$title = strlen( $p['title'] . ' | Vineet Vijay' ) <= 60 ? $p['title'] . ' | Vineet Vijay' : $p['title'];
	$meta  = array(
		'vv_utm' => $p['id'],
		'ast-site-content-layout' => 'full-width-container', 'site-content-style' => 'unboxed', 'site-sidebar-layout' => 'no-sidebar', 'site-post-title' => 'disabled',
		'rank_math_title' => $title, 'rank_math_description' => $p['description'], 'rank_math_facebook_title' => $title, 'rank_math_facebook_description' => $p['description'],
		'rank_math_focus_keyword' => $p['slug'] ? strtolower( $p['name'] ) : 'utm builder,utm link builder',
		'rank_math_breadcrumb_title' => $p['slug'] ? $p['nav'] : 'UTM Builder',
		'rank_math_robots' => array( 'index' ),
		'vv_faq' => $p['faqs'],
	);
	foreach ( $meta as $k => $v ) { update_post_meta( $id, $k, $v ); }
	$vv_utm_pages[ $p['id'] ] = array( 'id' => $id, 'url' => get_permalink( $id ), 'title' => $title );
}

if ( class_exists( '\RankMath\Sitemap\Cache' ) ) { \RankMath\Sitemap\Cache::invalidate_storage(); }
do_action( 'litespeed_purge_all' );
return array( 'copied' => $vv_utm_copied, 'pages' => $vv_utm_pages );
