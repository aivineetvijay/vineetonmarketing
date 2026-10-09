<?php
/**
 * llms.txt (https://vineetonmarketing.com/llms.txt): the hand-written file in wordpress/seo/llms.txt, in the same
 * format the site's llms.txt generators produce (H1, summary, key facts, then curated sections of links with one
 * factual line each). Run server-side via Novamira execute-php with $vv_base set to the raw GitHub URL of
 * wordpress/ at a commit, e.g. https://raw.githubusercontent.com/<owner>/<repo>/<sha>/wordpress/.
 *
 * Rank Math's generated llms.txt (a list of every page) is switched off, and the file is written to the site root,
 * where the web server serves it directly as text/plain. Update wordpress/seo/llms.txt and re-run when pages change.
 */
$r = wp_remote_get( $vv_base . 'seo/llms.txt', array( 'timeout' => 30 ) );
$txt = wp_remote_retrieve_body( $r );
if ( 200 !== wp_remote_retrieve_response_code( $r ) || 0 !== strpos( $txt, '# ' ) ) {
	return array( 'error' => 'could not fetch seo/llms.txt' );
}
wp_get_ability( 'rank-math/set-module-status' )->execute( array( 'modules' => array( 'llms-txt' => false ) ) );
file_put_contents( ABSPATH . 'llms.txt', $txt );
flush_rewrite_rules( false );
do_action( 'litespeed_purge_all' );
return array( 'bytes' => strlen( $txt ) );
