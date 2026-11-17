<?php
/**
 * Plugin Name: VV Headings
 * Description: Two-line display titles as one heading. Section titles such as "What is an / llms.txt file?" used to be an
 *              <h2> holding only the first half, with the italic second half in a separate paragraph, so search engines
 *              read "What is an" as the heading. Pages now put the whole sentence in the heading and wrap the second
 *              line in <em>; this gives that <em> the look the separate paragraph had (light italic, muted colour; the
 *              lighter muted tone on dark sections). The colours are the site's global Elementor variables, the same
 *              ones the "muted" and "muted-on-dark" classes use.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-headings.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', function () {
	echo '<style id="vv-headings">'
		. '.t-display em,.t-huge em{font-style:italic;font-weight:300;color:var(--color-ink-muted-48)}'
		. '.on-dark.t-display em,.on-dark.t-huge em{color:var(--color-body-muted)}'
		. "</style>\n";
}, 20 );
