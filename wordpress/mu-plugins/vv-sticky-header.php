<?php
/**
 * Plugin Name: VV Sticky Header
 * Description: Keeps the site header (logo, menu, Get in touch) visible while scrolling on desktop. Astra (free) and
 *              Elementor (free) have no sticky-header setting, so this is the one agreed CSS rule: desktop only
 *              (Astra's desktop breakpoint, 922px and up), the 80px header row only (the breadcrumb bar scrolls away).
 *              overflow-x: clip replaces Astra's overflow-x: hidden on body, which would otherwise stop sticky working.
 *              scroll-padding-top keeps in-page anchors (contents links, #faq) clear of the header.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-sticky-header.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', function () {
	echo "<style id=\"vv-sticky-header\">@media (min-width:922px){html body{overflow-x:clip;overflow-y:visible}#masthead{position:sticky;top:0;z-index:999;background:#fff;box-shadow:0 1px 0 rgba(0,0,0,.06)}.admin-bar #masthead{top:32px}html{scroll-padding-top:96px}}</style>\n";
}, 99 );
