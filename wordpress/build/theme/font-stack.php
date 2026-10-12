<?php
/**
 * Sans-serif fallbacks for the site fonts, and a font-mono variable for code. Run via Novamira execute-php (no inputs).
 *
 * The Elementor global font variables font-text and font-display were just "Inter". Fonts load with
 * font-display: optional (no layout shift), so if Inter is not ready at first paint the browser uses the next font
 * in the list, and with no list that was its default serif (Times). The stack keeps Inter first, then the closest
 * system sans-serif fonts.
 */
$stack = 'Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif';
$kit   = (int) get_option( 'elementor_active_kit' );
$raw   = get_post_meta( $kit, '_elementor_global_variables', true );
$vars  = json_decode( is_string( $raw ) ? $raw : wp_json_encode( $raw ), true );
$hit   = array();
foreach ( $vars['data'] as $id => $v ) {
	if ( 'global-font-variable' === ( $v['type'] ?? '' ) && in_array( $v['label'] ?? '', array( 'font-text', 'font-display' ), true ) ) {
		$vars['data'][ $id ]['value']['value'] = $stack;
		$vars['data'][ $id ]['updated_at']     = current_time( 'mysql' );
		$hit[] = $v['label'];
	}
}
if ( ! $hit ) {
	return array( 'error' => 'font variables not found' );
}
/* font-mono: one system monospace stack for code (art-code; the generator pages use the same stack). A variable,
   because Elementor quotes a plain comma-separated font-family value as one family name. */
$mono   = 'ui-monospace, SF Mono, Menlo, Consolas, Liberation Mono, monospace';
$has    = false;
$orders = array( 0 );
foreach ( $vars['data'] as $id => $v ) {
	$orders[] = (int) ( $v['order'] ?? 0 );
	if ( 'font-mono' === ( $v['label'] ?? '' ) ) {
		$vars['data'][ $id ]['value']['value'] = $mono;
		$has = true;
	}
}
if ( ! $has ) {
	$vars['data'][ 'e-gv-' . substr( md5( 'font-mono' ), 0, 7 ) ] = array(
		'type' => 'global-font-variable', 'label' => 'font-mono', 'value' => array( '$$type' => 'string', 'value' => $mono ),
		'order' => max( $orders ) + 1, 'created_at' => current_time( 'mysql' ), 'updated_at' => current_time( 'mysql' ),
	);
}
$hit[] = 'font-mono';
update_post_meta( $kit, '_elementor_global_variables', wp_slash( wp_json_encode( $vars ) ) );
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return array( 'updated' => $hit, 'value' => $stack );
