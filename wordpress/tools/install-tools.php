<?php
/**
 * Server-side: copies the standalone tools from the repo (wordpress/tools/) into wp-content/uploads/vv-tools/
 * and installs the vv-tools mu-plugin that serves them. Expects $vv_base (raw GitHub URL of wordpress/ at a
 * commit) and $vv_files (paths relative to wordpress/tools/). Re-running replaces the files.
 */
$root = wp_get_upload_dir()['basedir'] . '/vv-tools/';
$done = array();
foreach ( $vv_files as $rel ) {
	if ( false !== strpos( $rel, '..' ) ) { return array( 'error' => 'bad path ' . $rel ); }
	$r = wp_remote_get( $vv_base . 'tools/' . str_replace( ' ', '%20', $rel ), array( 'timeout' => 30 ) );
	if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { return array( 'error' => 'fetch failed: ' . $rel ); }
	wp_mkdir_p( dirname( $root . $rel ) );
	file_put_contents( $root . $rel, wp_remote_retrieve_body( $r ) );
	$done[ $rel ] = filesize( $root . $rel );
}
$mu = wp_remote_retrieve_body( wp_remote_get( $vv_base . 'mu-plugins/vv-tools.php', array( 'timeout' => 30 ) ) );
if ( false === strpos( $mu, 'Plugin Name: VV Tools' ) ) { return array( 'error' => 'mu-plugin fetch failed' ); }
file_put_contents( WPMU_PLUGIN_DIR . '/vv-tools.php', $mu );
return $done;
