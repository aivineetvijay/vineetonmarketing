<?php
/**
 * Home (post 101) "Writing" list: the most recent published essays, newest first, each row linking to its
 * essay. Rows "Post 1".."Post N" were built with the Home page; this updates their text and link in place,
 * adds rows (copies of the last one, with fresh element IDs) when there are more essays than rows, and removes
 * rows beyond the list. Expects $vv_rows = array( array( date, title, category, url ), ... ).
 */
$data = json_decode( get_post_meta( 101, '_elementor_data', true ), true );
$max  = count( $vv_rows ); $changed = 0; $removed = 0; $added = 0;

/* Add rows by copying the last "Post N" row inside "Post List". */
$fresh = function ( $e, $n ) use ( &$fresh ) {
	$e['id'] = substr( md5( uniqid( '', true ) ), 0, 7 );
	$e['editor_settings']['title'] = preg_replace( '/^Post \d+/', "Post $n", $e['editor_settings']['title'] ?? '' );
	foreach ( $e['elements'] ?? array() as $k => $c ) { $e['elements'][ $k ] = $fresh( $c, $n ); }
	return $e;
};
$grow = function ( &$els ) use ( &$grow, $max, $fresh, &$added ) {
	foreach ( $els as &$e ) {
		if ( 'Post List' === ( $e['editor_settings']['title'] ?? '' ) ) {
			$rows = count( $e['elements'] );
			while ( $rows < $max ) { $e['elements'][] = $fresh( $e['elements'][ $rows - 1 ], ++$rows ); $added++; }
			return;
		}
		if ( ! empty( $e['elements'] ) ) { $grow( $e['elements'] ); }
	}
};
$grow( $data );

$set = array();
foreach ( $vv_rows as $i => $r ) {
	$n = $i + 1;
	$set[ "Post $n Date" ]     = array( 'paragraph', $r[0] );
	$set[ "Post $n Title" ]    = array( 'title', $r[1] );
	$set[ "Post $n Category" ] = array( 'paragraph', $r[2] );
	$link[ "Post $n" ]         = $r[3];
}
$walk = function ( &$els ) use ( &$walk, $set, $link, $max, &$changed, &$removed ) {
	foreach ( $els as $k => &$e ) {
		$t = $e['editor_settings']['title'] ?? '';
		if ( preg_match( '/^Post (\d+)$/', $t, $m ) && (int) $m[1] > $max ) { unset( $els[ $k ] ); $removed++; continue; }
		if ( isset( $set[ $t ] ) ) { $e['settings'][ $set[ $t ][0] ]['value'] = $set[ $t ][1]; $changed++; }
		if ( isset( $link[ $t ] ) ) { $e['settings']['link']['value']['destination']['value'] = $link[ $t ]; $changed++; }
		if ( ! empty( $e['elements'] ) ) { $walk( $e['elements'] ); }
	}
	$els = array_values( $els );
};
$walk( $data );
update_post_meta( 101, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( 101, '_elementor_element_cache' );
if ( function_exists( 'vv_refresh_text_copy' ) ) { vv_refresh_text_copy( 101 ); }
return array( 'changed' => $changed, 'added' => $added, 'removed' => $removed );
