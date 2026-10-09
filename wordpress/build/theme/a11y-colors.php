<?php
/**
 * Accessible muted grey. Run once via Novamira execute-php (no inputs).
 *
 * The Elementor global colour variable color-ink-muted-48 (meta labels, captions, list markers, table labels) was
 * #7a7a7a: 4.29:1 on white and 3.94:1 on the parchment sections (#f5f5f7), under the WCAG AA minimum of 4.5:1 for
 * small text. #6e6e73 is 5.07:1 on white, 4.65:1 on parchment and 4.85:1 on pearl (#fafafc). The variable is only
 * used on light backgrounds.
 */
$kit  = (int) get_option( 'elementor_active_kit' );
$raw  = get_post_meta( $kit, '_elementor_global_variables', true );
$vars = json_decode( is_string( $raw ) ? $raw : wp_json_encode( $raw ), true );
$hit  = 0;
foreach ( $vars['data'] as $id => $v ) {
	if ( 'color-ink-muted-48' === ( $v['label'] ?? '' ) ) {
		$vars['data'][ $id ]['value']['value'] = '#6e6e73';
		$vars['data'][ $id ]['updated_at']     = current_time( 'mysql' );
		$hit++;
	}
}
if ( ! $hit ) {
	return array( 'error' => 'color-ink-muted-48 not found' );
}
update_post_meta( $kit, '_elementor_global_variables', wp_slash( wp_json_encode( $vars ) ) );
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return array( 'updated' => $hit );
