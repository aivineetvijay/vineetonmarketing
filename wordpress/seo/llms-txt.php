<?php
/**
 * llms.txt (https://vineetonmarketing.com/llms.txt): the hand-written file in wordpress/seo/llms.txt, in the same
 * format the site's llms.txt generators produce (H1, summary, key facts, then curated sections of links with one
 * factual line each). Run server-side via Novamira execute-php with $vv_base set to the raw GitHub URL of
 * wordpress/ at a commit, e.g. https://raw.githubusercontent.com/<owner>/<repo>/<sha>/wordpress/.
 *
 * Rank Math's generated llms.txt (a list of every page) is switched off, and the file goes in the site root,
 * where the web server serves it directly as text/plain. Update wordpress/seo/llms.txt and re-run when pages change.
 *
 * Calling pattern (see wordpress/README.md for the runner): this file does not write llms.txt itself, because code
 * in an included temp file cannot call file_put_contents(). It returns
 *   array( 'bytes' => <length>, 'vv_write' => array( ABSPATH . 'llms.txt' => <contents> ) )
 * and the top-level execute-php code writes each vv_write entry. Without the runner:
 *   $res = include $tmp;   // $tmp = this file, fetched and written by the top-level code
 *   foreach ( $res['vv_write'] as $path => $data ) { $res['written'][ $path ] = file_put_contents( $path, $data ); }
 * The run succeeded only if written[ABSPATH . 'llms.txt'] equals bytes.
 */
$r = wp_remote_get( $vv_base . 'seo/llms.txt', array( 'timeout' => 30 ) );
$txt = wp_remote_retrieve_body( $r );
if ( 200 !== wp_remote_retrieve_response_code( $r ) || 0 !== strpos( $txt, '# ' ) ) {
	return array( 'error' => 'could not fetch seo/llms.txt' );
}
wp_get_ability( 'rank-math/set-module-status' )->execute( array( 'modules' => array( 'llms-txt' => false ) ) );
flush_rewrite_rules( false );
do_action( 'litespeed_purge_all' );
return array( 'bytes' => strlen( $txt ), 'vv_write' => array( ABSPATH . 'llms.txt' => $txt ) );
