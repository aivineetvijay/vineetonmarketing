<?php
/**
 * Experience page (ID 253): current role. 2 November 2026. Run via Novamira execute-php.
 *
 *  - New timeline row at the top: Senior Digital Marketing Manager, House of Comms · Dubai, 2026 — Now (no bullets yet).
 *  - Reem Hospital: 2024 — 2026, first two bullets in the past tense.
 *  - Hero "Current" line: House of Comms · Dubai. Timeline note: Five roles, one practice.
 *  - Hero intro names the current role.
 */
$pid = 253;
$out = array();
$data = json_decode( get_post_meta( $pid, '_elementor_data', true ), true );
if ( ! $data ) { return array( 'error' => 'no elementor data' ); }
if ( false !== strpos( wp_json_encode( $data ), 'Senior Digital Marketing Manager' ) ) { return array( 'error' => 'already applied' ); }

$edit = function ( &$els, $id, $fn ) use ( &$edit ) {
	foreach ( $els as &$e ) {
		if ( $e['id'] === $id ) { $fn( $e ); return true; }
		if ( ! empty( $e['elements'] ) && $edit( $e['elements'], $id, $fn ) ) { return true; }
	}
	return false;
};
$insert = function ( &$els, $id, $new ) use ( &$insert ) {
	foreach ( $els as $i => &$e ) {
		if ( $e['id'] === $id ) { array_splice( $els, $i, 0, array( $new ) ); return true; }
		if ( ! empty( $e['elements'] ) && $insert( $e['elements'], $id, $new ) ) { return true; }
	}
	return false;
};
$text = function ( $id, $key, $old, $new ) use ( &$data, $edit, &$out ) {
	$ok = $edit( $data, $id, function ( &$e ) use ( $key, $old, $new, &$out, $id ) {
		if ( $e['settings'][ $key ]['value'] !== $old ) { throw new Exception( "unexpected text in $id: " . $e['settings'][ $key ]['value'] ); }
		$e['settings'][ $key ]['value'] = $new;
	} );
	if ( ! $ok ) { throw new Exception( "not found: $id" ); }
	$out[ $id ] = 'ok';
};

$text( '451a689f', 'paragraph', 'Reem Hospital · Abu Dhabi', 'House of Comms · Dubai' );
$text( '7a3a10b4', 'paragraph', 'Four roles, one practice', 'Five roles, one practice' );
$text( '1b8d15ae', 'paragraph', '2024 — Now', '2024 — 2026' );
$text( '27068c75', 'paragraph', 'Leading end-to-end digital strategy for a UAE-based healthcare provider; a team of five across SEO, paid, content and analytics.', 'Led end-to-end digital strategy for a UAE-based healthcare provider; a team of five across SEO, paid, content and analytics.' );
$edit( $data, '3efe480', function ( &$e ) { $e['settings']['paragraph']['value'] = str_replace( 'Built the growth framework that now delivers 35%', 'Built the growth framework that delivered 35%', $e['settings']['paragraph']['value'] ); } );
$text( 'fc0972a', 'paragraph',
	'I’m a digital marketing specialist in Dubai. Ten years split between three of the largest media networks in the region — Wavemaker (WPP), Interactive Avenues (IPG), GenY Medium — and an in-house healthcare lead role in the UAE.',
	'I’m a digital marketing specialist in Dubai, now Senior Digital Marketing Manager at House of Comms. The ten years before took in three of the largest media networks in the region — Wavemaker (WPP), Interactive Avenues (IPG), GenY Medium — and an in-house healthcare lead role at Reem Hospital in Abu Dhabi.' );

/* New timeline row, built like the existing rows (classes copied from the Reem Hospital row). */
$row = null;
$edit( $data, '270a26f9', function ( &$e ) use ( &$row ) { $row = $e; } );
if ( ! $row ) { throw new Exception( 'Reem row not found' ); }
$nid = function () { return substr( md5( uniqid( '', true ) ), 0, 7 ); };
$new = array(
	'id' => $nid(), 'elType' => $row['elType'], 'settings' => $row['settings'], 'isInner' => false,
	'editor_settings' => array( 'title' => 'Role House of Comms' ), 'version' => '0.0',
	'elements' => array(),
);
$date = $row['elements'][0]; $date['id'] = $nid(); $date['settings']['paragraph']['value'] = '2026 — Now'; $date['editor_settings'] = array( 'title' => 'Role House of Comms Date' );
$stack = $row['elements'][1]; $stack['id'] = $nid(); $stack['editor_settings'] = array( 'title' => 'Role House of Comms Head' );
$stack['elements'][0]['id'] = $nid(); $stack['elements'][0]['settings']['title']['value'] = 'Senior Digital Marketing Manager'; $stack['elements'][0]['editor_settings'] = array( 'title' => 'Role House of Comms Title' );
$stack['elements'][1]['id'] = $nid(); $stack['elements'][1]['settings']['paragraph']['value'] = 'House of Comms · Dubai'; $stack['elements'][1]['editor_settings'] = array( 'title' => 'Role House of Comms Company' );
unset( $date['interactions'], $stack['interactions'], $stack['elements'][0]['interactions'], $stack['elements'][1]['interactions'] );
$new['elements'] = array( $date, $stack );
if ( ! $insert( $data, '270a26f9', $new ) ) { throw new Exception( 'insert failed' ); }
$out['row'] = $new['id'];

update_post_meta( $pid, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $pid, '_elementor_element_cache' );
delete_post_meta( $pid, '_elementor_css' );
if ( function_exists( 'vv_refresh_text_copy' ) ) { vv_refresh_text_copy( $pid ); }
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return $out;
