<?php
/**
 * Home (post 101) "Writing" list: shows the published essays only, newest first. Rows "Post 1".."Post 4"
 * were built with the Home page; this updates their text in place and removes rows beyond the published
 * essays. Expects $vv_rows = array( array( date, title, category ), ... ).
 */
$data = json_decode( get_post_meta( 101, '_elementor_data', true ), true );
$set  = array();
foreach ( $vv_rows as $i => $r ) {
	$n = $i + 1;
	$set[ "Post $n Date" ]     = array( 'paragraph', $r[0] );
	$set[ "Post $n Title" ]    = array( 'title', $r[1] );
	$set[ "Post $n Category" ] = array( 'paragraph', $r[2] );
}
$max = count( $vv_rows ); $changed = 0; $removed = 0;
$walk = function ( &$els ) use ( &$walk, $set, $max, &$changed, &$removed ) {
	foreach ( $els as $k => &$e ) {
		$t = $e['editor_settings']['title'] ?? '';
		if ( preg_match( '/^Post (\d+)$/', $t, $m ) && (int) $m[1] > $max ) { unset( $els[ $k ] ); $removed++; continue; }
		if ( isset( $set[ $t ] ) ) { $e['settings'][ $set[ $t ][0] ]['value'] = $set[ $t ][1]; $changed++; }
		if ( ! empty( $e['elements'] ) ) { $walk( $e['elements'] ); }
	}
	$els = array_values( $els );
};
$walk( $data );
update_post_meta( 101, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( 101, '_elementor_element_cache' );
if ( function_exists( 'vv_refresh_text_copy' ) ) { vv_refresh_text_copy( 101 ); }
return array( 'changed' => $changed, 'removed' => $removed );
