<?php
/**
 * Site structure changes of 9 October 2026. Run once via Novamira execute-php after build/vv-builder.php is loaded
 * (vv_build, vv_p, vv_publish). Redirects for the retired URLs live in mu-plugins/vv-redirects.php.
 *
 *  - AI in Marketing (/ai/) and the case studies (/case-studies/ and its four pages) move to draft.
 *  - Category archives are switched off: noindex and out of the sitemap (vv-redirects sends them to /writing/).
 *  - Header menu: AI in Marketing out, AI Tools in (after Writing).
 *  - Home "Read the POV" and Experience "AI in Marketing" buttons now point to /ai-tools/ as "Free AI tools".
 *  - Footer: "Privacy policy" link before "Built with restraint in Dubai." (also in build/theme/header-footer.php).
 *  - Contact: a short privacy note under the form.
 */
$out = array();

/* 1. Retired pages to draft. */
$retire = array( 'ai', 'case-studies', 'case-studies/reem-hospital', 'case-studies/apollo-hospitals', 'case-studies/myntra', 'case-studies/titan' );
foreach ( $retire as $path ) {
	$p = get_page_by_path( $path );
	if ( $p && 'draft' !== $p->post_status ) {
		wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'draft' ) );
	}
	$out['draft'][ $path ] = $p ? get_post_status( $p->ID ) : 'missing';
}

/* 2. Category archives off in Rank Math. */
$titles = get_option( 'rank-math-options-titles', array() );
$titles['tax_category_custom_robots'] = 'on';
$titles['tax_category_robots']        = array( 'noindex', 'follow' );
update_option( 'rank-math-options-titles', $titles );
$sitemap = get_option( 'rank-math-options-sitemap', array() );
$sitemap['tax_category_sitemap'] = 'off';
update_option( 'rank-math-options-sitemap', $sitemap );
$out['category'] = 'noindex, not in sitemap';

/* 3. Header menu. */
$menu  = (int) ( get_nav_menu_locations()['primary'] ?? 0 );
$tools = get_page_by_path( 'ai-tools' );
foreach ( wp_get_nav_menu_items( $menu ) as $item ) {
	if ( 'page' === $item->object && in_array( (int) $item->object_id, array( (int) get_page_by_path( 'ai' )->ID ), true ) ) {
		wp_delete_post( $item->ID, true );
	}
}
$have = wp_list_pluck( wp_get_nav_menu_items( $menu ), 'object_id' );
if ( $tools && ! in_array( (string) $tools->ID, array_map( 'strval', $have ), true ) ) {
	wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => 'AI Tools', 'menu-item-object' => 'page', 'menu-item-object-id' => $tools->ID, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish', 'menu-item-position' => 10 ) );
}
$order = array( 'experience' => 1, 'writing' => 2, 'ai-tools' => 3 );
foreach ( wp_get_nav_menu_items( $menu ) as $item ) {
	$slug = get_post_field( 'post_name', $item->object_id );
	if ( isset( $order[ $slug ] ) ) {
		wp_update_post( array( 'ID' => $item->ID, 'menu_order' => $order[ $slug ] ) );
	}
}
$out['menu'] = array_map( function ( $i ) { return $i->title; }, wp_get_nav_menu_items( $menu ) );

/* 4. Buttons that pointed at /ai/: now "Free AI tools" to /ai-tools/. */
$buttons = array( 'home' => 'About POV Button', 'experience' => 'Experience CTA Pov Button' );
foreach ( $buttons as $page => $title ) {
	$pid  = get_page_by_path( $page )->ID;
	$data = json_decode( (string) get_post_meta( $pid, '_elementor_data', true ), true );
	$n    = 0;
	$walk = function ( &$els ) use ( &$walk, &$n, $title ) {
		foreach ( $els as &$el ) {
			if ( ( $el['editor_settings']['title'] ?? '' ) === $title ) {
				$el['settings']['text']['value'] = 'Free AI tools ↗';
				$el['settings']['link'] = json_decode( str_replace( '\/ai\/', '\/ai-tools\/', wp_json_encode( $el['settings']['link'] ) ), true );
				$n++;
			}
			if ( ! empty( $el['elements'] ) ) { $walk( $el['elements'] ); }
		}
	};
	$walk( $data );
	if ( $n ) {
		update_post_meta( $pid, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		delete_post_meta( $pid, '_elementor_element_cache' );
	}
	$out['buttons'][ $page ] = $n;
}

/* 5. Footer privacy link (Astra footer HTML element 1). */
$astra = get_option( 'astra-settings', array() );
$astra['footer-html-1'] = '<a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '">Privacy policy</a> · Built with restraint in Dubai.';
$astra['footer-html-1link-color']   = array( 'desktop' => 'rgba(255,255,255,0.8)', 'tablet' => 'rgba(255,255,255,0.8)', 'mobile' => 'rgba(255,255,255,0.8)' );
$astra['footer-html-1link-h-color'] = array( 'desktop' => '#2997ff', 'tablet' => '#2997ff', 'mobile' => '#2997ff' );
update_option( 'astra-settings', $astra );

/* 6. Contact: privacy note under the form, inside the "Note" column. */
$contact = get_page_by_path( 'contact' )->ID;
$raw     = (string) get_post_meta( $contact, '_elementor_data', true );
if ( false === strpos( $raw, 'Contact Privacy Note' ) ) {
	$note = null;
	$find = function ( $els ) use ( &$find, &$note ) { foreach ( $els as $el ) { if ( 'Note' === ( $el['editor_settings']['title'] ?? '' ) ) { $note = $el['id']; return; } $find( $el['elements'] ?? array() ); } };
	$find( json_decode( $raw, true ) );
	if ( $note ) {
		$out['contact_note'] = vv_build( $contact, array(
			vv_p( 'Contact Privacy Note', 'I use your details only to reply. See the <a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '"><u>privacy policy</u></a>.', array( 't-meta', 'mt-16' ) ),
		), $note, 'append' );
		vv_publish( $contact );
	}
}

if ( class_exists( '\RankMath\Sitemap\Cache' ) ) { \RankMath\Sitemap\Cache::invalidate_storage(); }
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );
return $out;
