<?php
/**
 * Server-side runner for the Blog index + essays. Fetches the build files from GitHub at
 * $vv_base (e.g. https://raw.githubusercontent.com/<owner>/<repo>/<ref>/wordpress/), then:
 * creates/updates the essay-block global classes, rebuilds /blog/ and every essay, publishes
 * them, and keeps the other essays' "last modified" dates unchanged (their text did not change).
 */
$get = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};
$load = function ( $path, $vars = array() ) use ( $get ) {
	$tmp = wp_tempnam( 'vv' );
	file_put_contents( $tmp, $get( $path ) );
	extract( $vars );
	$res = include $tmp;
	unlink( $tmp );
	return $res;
};
if ( ! function_exists( 'vv_build' ) ) { $load( 'build/vv-builder.php' ); }

/* 1. Global classes for the long-form blocks (create, or patch if the label already exists). */
$tmp = wp_tempnam( 'vv' ); file_put_contents( $tmp, $get( 'build/classes/essay-blocks.php' ) ); include $tmp; unlink( $tmp );
$existing = array();
foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) { $existing[ $c['label'] ] = $c['id']; }
$ops = array();
foreach ( $vv_essay_classes as $label => $css ) {
	$ops[] = isset( $existing[ $label ] ) ? array( 'action' => 'update', 'id' => $existing[ $label ], 'css' => $css, 'mode' => 'replace' ) : array( 'action' => 'create', 'label' => $label, 'css' => $css );
}
$classes = wp_get_ability( 'elementor/manage-classes' )->execute( array( 'operations' => $ops ) );

/* 2. Essay bodies from JSON. */
$vv_essay_bodies = array();
foreach ( $vv_essays as $slug ) { $vv_essay_bodies[ $slug ] = json_decode( $get( 'content/essays/' . $slug . '.json' ), true ); }

/* 3. Rebuild. Remember the other essays' modified dates first. */
$keep = array();
foreach ( get_posts( array( 'post_type' => 'post', 'numberposts' => -1 ) ) as $p ) {
	if ( ! in_array( $p->post_name, $vv_essays, true ) ) { $keep[ $p->ID ] = array( $p->post_modified, $p->post_modified_gmt ); }
}
$built = $load( 'build/pages/blog.php', array( 'vv_essay_bodies' => $vv_essay_bodies ) );
if ( isset( $built['error'] ) ) { return $built; }
foreach ( $built as $slug => $b ) { vv_publish( $b['id'] ); }

global $wpdb;
foreach ( $keep as $id => $m ) {
	if ( in_array( get_post_field( 'post_name', $id ), $vv_essays, true ) ) { continue; } // renamed during this run
	$wpdb->update( $wpdb->posts, array( 'post_modified' => $m[0], 'post_modified_gmt' => $m[1] ), array( 'ID' => $id ) );
	clean_post_cache( $id );
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );

/* Guard: every rebuilt document must still be on Elementor Full Width. */
$templates = array();
foreach ( $built as $slug => $b ) { $templates[ $slug ] = get_post_meta( $b['id'], '_wp_page_template', true ); }

return array( 'classes' => $classes, 'built' => $built, 'templates' => $templates );
