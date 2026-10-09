<?php
/**
 * Plugin Name: VV Accessibility
 * Description: Gives every Elementor page one <main> landmark, so screen readers can jump straight to the content.
 *              Elementor's Header-Footer template prints the page between the theme header and footer with no <main>;
 *              this wraps it using the template's own before/after hooks. The llms.txt generator pages print their
 *              own <main> (vv-tools.php).
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-a11y.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'elementor/page_templates/header-footer/before_content', function () {
	echo '<main id="main-content">';
} );

add_action( 'elementor/page_templates/header-footer/after_content', function () {
	echo '</main>';
} );
