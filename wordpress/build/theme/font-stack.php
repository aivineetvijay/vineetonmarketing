<?php
/**
 * Sans-serif fallbacks for the site fonts. Run once via Novamira execute-php (no inputs).
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
update_post_meta( $kit, '_elementor_global_variables', wp_slash( wp_json_encode( $vars ) ) );
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return array( 'updated' => $hit, 'value' => $stack );
