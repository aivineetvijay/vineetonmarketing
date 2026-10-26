<?php
/**
 * Server-side runner for the Blog index + essays: creates/updates the essay-block global classes, rebuilds
 * /writing/ and every essay, publishes them, and keeps the other essays' "last modified" dates unchanged
 * (their text did not change).
 *
 * Calling pattern (see wordpress/README.md for the runner): include this file from the top-level execute-php
 * code with
 *   $vv_base   raw GitHub URL of wordpress/ at a commit, e.g. https://raw.githubusercontent.com/<owner>/<repo>/<sha>/wordpress/
 *              (essay bodies, content/essays/<slug>.json, are fetched from here),
 *   $vv_essays the essays changed in this run (array() for a no-change rebuild),
 *   $vv_json   every essay whose body lives in a JSON file (every body_src in build/pages/blog.php),
 *   $vv_files  repo path => temp file the caller already wrote, for build/vv-builder.php,
 *              build/classes/essay-blocks.php and build/pages/blog.php.
 * This file writes no files. Code in an included temp file cannot call file_put_contents() / file_get_contents().
 * If $vv_files lacks a path it returns array( 'vv_need' => <paths> ) before changing anything. The caller writes
 * those paths and includes this file again.
 */
$need = array_values( array_diff( array( 'build/vv-builder.php', 'build/classes/essay-blocks.php', 'build/pages/blog.php' ), array_keys( $vv_files ?? array() ) ) );
if ( $need ) { return array( 'vv_need' => $need ); }
$get = function ( $path ) use ( $vv_base ) {
	$r = wp_remote_get( $vv_base . $path, array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { throw new Exception( 'fetch failed: ' . $path ); }
	return wp_remote_retrieve_body( $r );
};
/* Includes a caller-written file in its own scope, so its variables cannot overwrite this runner's. */
$load = function ( $path, $vars = array() ) use ( $vv_files ) {
	extract( $vars );
	return include $vv_files[ $path ];
};
if ( ! function_exists( 'vv_build' ) ) { $load( 'build/vv-builder.php' ); }

/* 1. Global classes for the long-form blocks (create, or patch if the label already exists). */
include $vv_files['build/classes/essay-blocks.php'];
if ( empty( $vv_essay_classes ) ) { return array( 'error' => 'build/classes/essay-blocks.php did not define $vv_essay_classes' ); }
$existing = array();
foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) { $existing[ $c['label'] ] = $c['id']; }
$ops = array();
foreach ( $vv_essay_classes as $label => $css ) {
	$ops[] = isset( $existing[ $label ] ) ? array( 'action' => 'update', 'id' => $existing[ $label ], 'css' => $css, 'mode' => 'replace' ) : array( 'action' => 'create', 'label' => $label, 'css' => $css );
}
$classes = wp_get_ability( 'elementor/manage-classes' )->execute( array( 'operations' => $ops ) );

/* 2. Essay bodies from JSON. */
$vv_essay_bodies = array();
/* $vv_essays = the essays changed in this run; $vv_json = every essay whose body lives in a JSON file. */
foreach ( array_unique( array_merge( $vv_json ?? array(), $vv_essays ) ) as $slug ) { $vv_essay_bodies[ $slug ] = json_decode( $get( 'content/essays/' . $slug . '.json' ), true ); }

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

/* FAQPage schema (vv-schema.php) from each JSON essay's visible FAQ: question h3s + answer paragraphs after the "faq" h2. */
foreach ( $vv_essays as $slug ) {
	$faq = array(); $in = false; $q = null;
	foreach ( $vv_essay_bodies[ $slug ] as $blk ) {
		if ( 'h2' === $blk[0] ) { $in = ( 'faq' === $blk[2] ); continue; }
		if ( ! $in ) { continue; }
		if ( 'h3s' === $blk[0] ) { $q = wp_strip_all_tags( $blk[1] ); }
		elseif ( 'p' === $blk[0] && $q ) { $faq[] = array( $q, wp_strip_all_tags( html_entity_decode( $blk[1], ENT_QUOTES, 'UTF-8' ) ) ); $q = null; }
	}
	if ( $faq && isset( $built[ $slug ] ) ) { update_post_meta( $built[ $slug ]['id'], 'vv_faq', $faq ); }
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );

/* Guard: every rebuilt document must still be on Elementor Full Width. */
$templates = array();
foreach ( $built as $slug => $b ) { $templates[ $slug ] = get_post_meta( $b['id'], '_wp_page_template', true ); }

return array( 'classes' => $classes, 'built' => $built, 'templates' => $templates );
