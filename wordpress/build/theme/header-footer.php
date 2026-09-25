<?php
/**
 * Astra header + footer set up to match the Claude Design nav and footer
 * (js/Shared.jsx: Nav, Footer). Uses only Astra's own builder settings, the
 * site logo, the "Header" menu and core blocks in the footer widget areas.
 * Expects $sha (git commit to fetch assets from) to be set by the runner.
 */
$raw = 'https://raw.githubusercontent.com/aivineetvijay/vineetonmarketing/' . $sha . '/wordpress/assets/';

/* ---------- Logo: pulsing dot + "Vineet Vijay" (SVG, see build_logo.py) ---------- */
$logo_id = (int) get_theme_mod( 'custom_logo' );
if ( ! $logo_id || 'image/svg+xml' !== get_post_mime_type( $logo_id ) ) {
	$svg = wp_remote_retrieve_body( wp_remote_get( $raw . 'logo-vineet-vijay.svg', array( 'timeout' => 30 ) ) );
	if ( 0 !== strpos( $svg, '<svg' ) ) { return 'logo fetch failed'; }
	$up = wp_upload_dir();
	$path = $up['path'] . '/' . wp_unique_filename( $up['path'], 'logo-vineet-vijay.svg' );
	file_put_contents( $path, $svg );
	$logo_id = wp_insert_attachment( array( 'post_mime_type' => 'image/svg+xml', 'post_title' => 'Logo: Vineet Vijay', 'post_status' => 'inherit' ), $path );
	update_post_meta( $logo_id, '_wp_attachment_image_alt', 'Vineet Vijay' );
	wp_update_attachment_metadata( $logo_id, array( 'width' => 119, 'height' => 28, 'file' => _wp_relative_upload_path( $path ) ) );
	set_theme_mod( 'custom_logo', $logo_id );
}

/* ---------- Astra builder settings ---------- */
$resp = function ( $d, $t = null, $m = null ) { return array( 'desktop' => $d, 'tablet' => null === $t ? $d : $t, 'mobile' => null === $m ? ( null === $t ? $d : $t ) : $m ); };
$box = function ( $t, $r, $b, $l ) { return array( 'top' => $t, 'right' => $r, 'bottom' => $b, 'left' => $l ); };
$spacing = function ( $d, $t, $m, $unit = 'px' ) { return array( 'desktop' => $d, 'tablet' => $t, 'mobile' => $m, 'desktop-unit' => $unit, 'tablet-unit' => $unit, 'mobile-unit' => $unit ); };
$size = function ( $d, $t = '', $m = '' ) { return array( 'desktop' => $d, 'tablet' => $t, 'mobile' => $m, 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px' ); };
$bg = function ( $c ) {
	$one = array( 'background-color' => $c, 'background-image' => '', 'background-repeat' => 'repeat', 'background-position' => 'center center', 'background-size' => 'auto', 'background-attachment' => 'scroll', 'overlay-type' => '', 'overlay-color' => '', 'overlay-opacity' => '', 'overlay-gradient' => '' );
	return array( 'desktop' => $one, 'tablet' => $one, 'mobile' => $one );
};
$ink = '#1d1d1f'; $blue = '#0066cc'; $blue_dark = '#2997ff';
$hair_dark = 'rgba(255,255,255,0.16)';

$s = (array) get_option( 'astra-settings', array() );
$set = array(
	/* Typography: the design's Inter (SF Pro fallback) for theme-rendered text. */
	'body-font-family' => "'Inter', sans-serif", 'body-font-variant' => '400', 'body-font-weight' => '400',
	'headings-font-family' => "'Inter', sans-serif", 'headings-font-weight' => '600',

	/* Header layout: logo left; menu + "Get in touch" pill right. */
	'header-desktop-items' => array(
		'popup' => array( 'popup_content' => array( 'mobile-menu' ) ),
		'above' => array( 'above_left' => array(), 'above_left_center' => array(), 'above_center' => array(), 'above_right_center' => array(), 'above_right' => array() ),
		'primary' => array( 'primary_left' => array( 'logo' ), 'primary_left_center' => array(), 'primary_center' => array(), 'primary_right_center' => array(), 'primary_right' => array( 'menu-1', 'button-1' ) ),
		'below' => array( 'below_left' => array(), 'below_left_center' => array(), 'below_center' => array(), 'below_right_center' => array(), 'below_right' => array() ),
	),
	'header-mobile-items' => array(
		'popup' => array( 'popup_content' => array( 'mobile-menu' ) ),
		'above' => array( 'above_left' => array(), 'above_center' => array(), 'above_right' => array() ),
		'primary' => array( 'primary_left' => array( 'logo' ), 'primary_center' => array(), 'primary_right' => array( 'mobile-trigger' ) ),
		'below' => array( 'below_left' => array(), 'below_center' => array(), 'below_right' => array() ),
	),
	'hb-header-main-layout-width' => 'full',
	'hb-header-height' => array( 'desktop' => 80, 'tablet' => 64, 'mobile' => 64 ),
	'hb-header-main-sep' => 0,
	'hb-header-bg-obj-responsive' => $bg( '#ffffff' ),
	'section-primary-header-builder-padding' => $spacing( $box( '0', '40', '0', '40' ), $box( '0', '20', '0', '20' ), $box( '0', '20', '0', '20' ) ),
	'hb-header-spacing' => $spacing( $box( '', '', '', '' ), $box( '', '', '', '' ), $box( '', '', '', '' ) ),

	/* Brand: logo only (the name is part of the logo). */
	'display-site-title-responsive' => array( 'desktop' => 0, 'tablet' => 0, 'mobile' => 0 ),
	'display-site-tagline-responsive' => array( 'desktop' => 0, 'tablet' => 0, 'mobile' => 0 ),
	'ast-header-responsive-logo-width' => array( 'desktop' => 119, 'tablet' => 119, 'mobile' => 112 ),

	/* Primary menu: 14px, #333 → ink on hover, underline on hover/active. */
	'header-menu1-font-size' => $size( 14 ),
	'header-menu1-font-weight' => '400',
	'header-menu1-font-extras' => array( 'line-height' => '1.2', 'line-height-unit' => '', 'letter-spacing' => '-0.14', 'letter-spacing-unit' => 'px', 'text-transform' => '', 'text-decoration' => '' ),
	'header-menu1-color-responsive' => $resp( '#333333' ),
	'header-menu1-h-color-responsive' => $resp( $ink ),
	'header-menu1-a-color-responsive' => $resp( $ink ),
	'header-menu1-h-bg-color-responsive' => $resp( '' ),
	'header-menu1-a-bg-color-responsive' => $resp( '' ),
	'header-menu1-menu-hover-animation' => 'underline',
	'header-menu1-menu-spacing' => $spacing( $box( '8', '14', '8', '14' ), $box( '', '', '', '' ), $box( '', '', '', '' ) ),

	/* "Get in touch" pill: ink → Action Blue on hover. */
	'header-button1-text' => 'Get in touch ↗',
	'header-button1-link-option' => array( 'url' => home_url( '/contact/' ), 'new_tab' => false, 'link_rel' => '' ),
	'header-button1-font-size' => $size( 14 ),
	'header-button1-font-weight' => '400',
	'header-button1-text-color' => $resp( '#ffffff' ),
	'header-button1-back-color' => $resp( $ink ),
	'header-button1-text-h-color' => $resp( '#ffffff' ),
	'header-button1-back-h-color' => $resp( $blue ),
	'header-button1-border-size' => $box( 0, 0, 0, 0 ),
	'header-button1-border-radius-fields' => $spacing( $box( 999, 999, 999, 999 ), $box( 999, 999, 999, 999 ), $box( 999, 999, 999, 999 ) ),
	'header-button1-padding' => $spacing( $box( '10', '18', '10', '18' ), $box( '10', '18', '10', '18' ), $box( '10', '18', '10', '18' ) ),
	'section-hb-button-1-padding' => $spacing( $box( '0', '0', '0', '8' ), $box( '', '', '', '' ), $box( '', '', '', '' ) ),

	/* Mobile: minimal trigger, full-screen black menu with large white links. */
	'mobile-header-type' => 'full-width',
	'mobile-header-toggle-btn-style' => 'minimal',
	'mobile-header-toggle-btn-color' => $ink,
	'mobile-header-toggle-icon-size' => 22,
	'off-canvas-background' => $bg( '#000000' )['desktop'],
	'off-canvas-close-color' => '#ffffff',
	'header-mobile-menu-bg-obj-responsive' => $bg( '' ),
	'header-mobile-menu-color-responsive' => $resp( '#ffffff' ),
	'header-mobile-menu-h-color-responsive' => $resp( $blue_dark ),
	'header-mobile-menu-a-color-responsive' => $resp( $blue_dark ),
	'header-mobile-menu-h-bg-color-responsive' => $resp( '' ),
	'header-mobile-menu-a-bg-color-responsive' => $resp( '' ),
	'header-mobile-menu-font-size' => $size( 40, 40, 36 ),
	'header-mobile-menu-font-weight' => '600',
	'header-mobile-menu-submenu-item-border' => true,
	'header-mobile-menu-submenu-item-b-size' => '1',
	'header-mobile-menu-submenu-item-b-color' => 'rgba(255,255,255,0.12)',
	'header-mobile-menu-menu-spacing' => $spacing( $box( '', '', '', '' ), $box( '12', '0', '12', '0' ), $box( '12', '0', '12', '0' ) ),

	/* Footer layout: big email (above), details row (primary), legal (below). */
	'footer-desktop-items' => array(
		'above' => array( 'above_1' => array( 'widget-1' ), 'above_2' => array(), 'above_3' => array(), 'above_4' => array(), 'above_5' => array() ),
		'primary' => array( 'primary_1' => array( 'widget-2' ), 'primary_2' => array(), 'primary_3' => array(), 'primary_4' => array(), 'primary_5' => array() ),
		'below' => array( 'below_1' => array( 'copyright' ), 'below_2' => array( 'html-1' ), 'below_3' => array(), 'below_4' => array(), 'below_5' => array() ),
	),
	'hba-footer-column' => '1', 'hba-footer-layout' => array( 'desktop' => 'full', 'tablet' => 'full', 'mobile' => 'full' ),
	'hb-footer-column' => '1', 'hb-footer-layout' => array( 'desktop' => 'full', 'tablet' => 'full', 'mobile' => 'full' ),
	'hbb-footer-column' => '2', 'hbb-footer-layout' => array( 'desktop' => '2-equal', 'tablet' => '2-equal', 'mobile' => 'full' ),
	'hba-footer-layout-width' => 'full', 'hb-footer-layout-width' => 'full', 'hbb-footer-layout-width' => 'full',
	'hba-footer-bg-obj-responsive' => $bg( '#000000' ),
	'hb-footer-bg-obj-responsive' => $bg( '#000000' ),
	'hbb-footer-bg-obj-responsive' => $bg( '#000000' ),
	'hba-footer-height' => 0, 'hbb-footer-height' => 0, 'hb-primary-footer-height' => '',
	'hb-footer-main-sep' => 1, 'hb-footer-main-sep-color' => $hair_dark,
	'hbb-footer-separator' => 0,
	'section-above-footer-builder-padding' => $spacing( $box( '120', '40', '96', '40' ), $box( '96', '20', '64', '20' ), $box( '64', '20', '48', '20' ) ),
	'section-primary-footer-builder-padding' => $spacing( $box( '28', '40', '0', '40' ), $box( '28', '20', '0', '20' ), $box( '24', '20', '0', '20' ) ),
	'section-below-footer-builder-padding' => $spacing( $box( '48', '40', '60', '40' ), $box( '40', '20', '40', '20' ), $box( '28', '20', '32', '20' ) ),

	'footer-widget-1-color' => $resp( '#ffffff' ),
	'footer-widget-1-link-color' => $resp( '#ffffff' ),
	'footer-widget-1-link-h-color' => $resp( $blue_dark ),
	'footer-widget-2-color' => $resp( 'rgba(255,255,255,0.65)' ),
	'footer-widget-2-link-color' => $resp( '#ffffff' ),
	'footer-widget-2-link-h-color' => $resp( $blue_dark ),
	'footer-widget-2-content-font-size' => $size( 13 ),
	'footer-widget-2-content-font-extras' => array( 'line-height' => '1.6', 'line-height-unit' => '', 'letter-spacing' => '-0.13', 'letter-spacing-unit' => 'px', 'text-transform' => '', 'text-decoration' => '' ),

	'footer-copyright-editor' => '© [current_year] Vineet Vijay. All rights reserved.',
	'footer-copyright-color' => 'rgba(255,255,255,0.4)',
	'font-size-section-footer-copyright' => $size( 12 ),
	'footer-copyright-alignment' => array( 'desktop' => 'left', 'tablet' => 'left', 'mobile' => 'left' ),
	'footer-html-1' => 'Built with restraint in Dubai.',
	'footer-html-1color' => $resp( 'rgba(255,255,255,0.4)' ),
	'font-size-section-fb-html-1' => $size( 12 ),
	'footer-html-1-alignment' => array( 'desktop' => 'right', 'tablet' => 'right', 'mobile' => 'left' ),
);
update_option( 'astra-settings', array_merge( $s, $set ) );

/* ---------- Footer widget areas: core blocks ---------- */
$label = function ( $t ) {
	return '<!-- wp:paragraph {"style":{"typography":{"fontSize":"11px","letterSpacing":"0.12em","textTransform":"uppercase"},"color":{"text":"rgba(255,255,255,0.5)"},"spacing":{"margin":{"bottom":"8px"}}}} -->'
		. '<p class="has-text-color" style="color:rgba(255,255,255,0.5);margin-bottom:8px;font-size:11px;letter-spacing:0.12em;text-transform:uppercase">' . $t . '</p><!-- /wp:paragraph -->';
};
$text = function ( $html ) {
	return '<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} --><p style="margin-top:0;margin-bottom:0">' . $html . '</p><!-- /wp:paragraph -->';
};
$column = function ( $inner ) { return '<!-- wp:column --><div class="wp-block-column">' . $inner . '</div><!-- /wp:column -->'; };

$mega = '<!-- wp:paragraph {"style":{"typography":{"fontSize":"12px","letterSpacing":"0.12em","textTransform":"uppercase"},"color":{"text":"rgba(255,255,255,0.55)"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->'
	. '<p class="has-text-color" style="color:rgba(255,255,255,0.55);margin-top:0;margin-bottom:0;font-size:12px;letter-spacing:0.12em;text-transform:uppercase">Get in touch · Dubai, GST</p><!-- /wp:paragraph -->'
	. '<!-- wp:heading {"style":{"typography":{"fontSize":"clamp(28px, 4.4vw, 72px)","fontStyle":"normal","fontWeight":"600","letterSpacing":"-0.03em","lineHeight":"1.05"},"spacing":{"margin":{"top":"24px","bottom":"0"}}}} -->'
	. '<h2 class="wp-block-heading" style="margin-top:24px;margin-bottom:0;font-size:clamp(28px, 4.4vw, 72px);font-style:normal;font-weight:600;letter-spacing:-0.03em;line-height:1.05"><a href="mailto:vineetvijay88@gmail.com">vineetvijay88@gmail.com</a></h2><!-- /wp:heading -->';

$details = '<!-- wp:columns --><div class="wp-block-columns">'
	. $column( $label( 'Based' ) . $text( 'Abu Dhabi · Dubai<br>United Arab Emirates' ) )
	. $column( $label( 'Phone' ) . $text( '<a href="tel:+971586823646">+971 58 682 3646</a>' ) )
	. $column( $label( 'Elsewhere' ) . $text( '<a href="https://linkedin.com/in/vineetvijay" target="_blank" rel="noreferrer noopener">LinkedIn</a><br><a href="' . esc_url( home_url( '/blog/#subscribe' ) ) . '">Subscribe</a>' ) )
	. $column( $label( 'Status' ) . $text( '<mark style="background-color:rgba(0,0,0,0);color:#1f8a5b" class="has-inline-color">●</mark> Open to new conversations' ) )
	. '</div><!-- /wp:columns -->';

$blocks = get_option( 'widget_block', array() );
if ( ! is_array( $blocks ) ) { $blocks = array(); }
$next = max( array_merge( array( 1 ), array_filter( array_keys( $blocks ), 'is_int' ) ) ) + 1;
$blocks[ $next ] = array( 'content' => $mega );
$blocks[ $next + 1 ] = array( 'content' => $details );
$blocks['_multiwidget'] = 1;
update_option( 'widget_block', $blocks );
$sw = get_option( 'sidebars_widgets', array() );
$sw['footer-widget-1'] = array( 'block-' . $next );
$sw['footer-widget-2'] = array( 'block-' . ( $next + 1 ) );
update_option( 'sidebars_widgets', $sw );

if ( class_exists( 'Astra_Cache_Base' ) ) { do_action( 'astra_theme_update_after' ); }
delete_option( 'astra-dynamic-css' );
\Elementor\Plugin::$instance->files_manager->clear_cache();
do_action( 'litespeed_purge_all' );

return array( 'logo' => $logo_id, 'settings' => count( $set ), 'widgets' => array( $sw['footer-widget-1'], $sw['footer-widget-2'] ) );
