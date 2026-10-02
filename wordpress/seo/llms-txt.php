<?php
/**
 * llms.txt (https://vineetonmarketing.com/llms.txt) via Rank Math's llms-txt module.
 * Run server-side. Lists published pages and posts with their summaries, plus an "About" block.
 * Page summaries come from post_excerpt, so each page's excerpt is set to its Rank Math meta description
 * (otherwise Rank Math falls back to the first line of page text, e.g. "Status" or "Industry").
 */
global $wpdb;
wp_get_ability( 'rank-math/set-module-status' )->execute( array( 'modules' => array( 'llms-txt' => true ) ) );

$gen = get_option( 'rank-math-options-general', array() );
$gen['llms_post_types']    = array( 'page', 'post' );
$gen['llms_taxonomies']    = array();
$gen['llms_limit']         = 100;
$gen['llms_extra_content'] = "## About\n\n"
	. "Vineet Vijay is a digital marketing strategist based in Dubai, UAE, with ten years across healthcare, e-commerce, FMCG and luxury. "
	. "He writes practitioner essays on AI in marketing, SEO and AI search visibility, schema markup, paid media and measurement, for marketing leaders in the GCC and India.\n\n"
	. "- Writing: https://vineetonmarketing.com/writing/\n"
	. "- Experience: https://vineetonmarketing.com/experience/\n"
	. "- Case studies: https://vineetonmarketing.com/case-studies/\n"
	. "- Contact: https://vineetonmarketing.com/contact/\n"
	. "- LinkedIn: https://www.linkedin.com/in/vineetvijay\n\n"
	. 'Quoting is welcome with attribution and a link to the original essay.';
update_option( 'rank-math-options-general', $gen );

foreach ( get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'numberposts' => -1 ) ) as $p ) {
	$d = get_post_meta( $p->ID, 'rank_math_description', true );
	if ( $d ) { $wpdb->update( $wpdb->posts, array( 'post_excerpt' => $d ), array( 'ID' => $p->ID ) ); clean_post_cache( $p->ID ); }
}

/* The module registers ^llms\.txt$ once loaded; flush so the URL resolves on the next request. */
flush_rewrite_rules( false );
do_action( 'litespeed_purge_all' );
return 'ok';
