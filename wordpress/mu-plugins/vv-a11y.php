<?php
/**
 * Plugin Name: VV Accessibility
 * Description: Gives every Elementor page one <main> landmark, so screen readers can jump straight to the content.
 *              Elementor's Header-Footer template prints the page between the theme header and footer with no <main>;
 *              this wraps it using the template's own before/after hooks. The tool pages print their own <main>
 *              (vv-tools.php, vv-utm.php).
 *              A small footer script adds what the page builder and theme can't set: one clear accessible name for
 *              each tool card link (its title and summary, instead of every word on the card), hides the decorative
 *              status dots, marks Astra's mobile menu drawer as a labelled modal dialog linked to its menu button,
 *              and returns keyboard focus to that button when the drawer closes.
 * Version:     1.1.0
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

add_action( 'wp_footer', function () {
	?>
<script id="vv-a11y">
(function () {
	function init() {
		/* Tool cards: the whole card is one link; name it by its title and summary. */
		document.querySelectorAll('a.gen-card').forEach(function (a) {
			var t = a.querySelector('.tcard-name, .aside-title'), u = a.querySelector('.tcard-use, .art-p-sm');
			if (t) { a.setAttribute('aria-label', t.textContent.trim() + (u ? ': ' + u.textContent.trim().split(/(?<=[.?!])\s/)[0] : '')); }
		});
		document.querySelectorAll('.status-dot').forEach(function (d) { d.setAttribute('aria-hidden', 'true'); });

		/* Mobile menu drawer: a labelled modal dialog, linked to its button; focus goes back to the button on close. */
		var drawer = document.querySelector('.ast-mobile-popup-drawer');
		if (!drawer) { return; }
		if (!drawer.id) { drawer.id = 'vv-mobile-menu'; }
		drawer.setAttribute('role', 'dialog');
		drawer.setAttribute('aria-modal', 'true');
		drawer.setAttribute('aria-label', 'Site menu');
		var opener = null;
		document.querySelectorAll('button.main-header-menu-toggle').forEach(function (b) {
			b.setAttribute('aria-controls', drawer.id);
			b.addEventListener('click', function () { opener = b; });
		});
		new MutationObserver(function () {
			if (!drawer.classList.contains('active') && opener) {
				var b = opener; opener = null;
				setTimeout(function () { if (!drawer.contains(document.activeElement) && (document.activeElement === document.body || !document.activeElement)) { b.focus(); } }, 50);
			}
		}).observe(drawer, { attributes: true, attributeFilter: ['class'] });
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); } else { init(); }
})();
</script>
	<?php
}, 99 );
