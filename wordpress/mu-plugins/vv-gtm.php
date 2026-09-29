<?php
/**
 * Plugin Name: VV Google Tag Manager
 * Description: Prints the Google Tag Manager container (GTM-MPZBRGLB) first in <head>, plus the <noscript> fallback right after <body>.
 * Version:     1.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-gtm.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

const VV_GTM_ID = 'GTM-MPZBRGLB';

add_action( 'wp_head', function () {
	?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_js( VV_GTM_ID ); ?>');</script>
<!-- End Google Tag Manager -->
	<?php
}, PHP_INT_MIN );

add_action( 'wp_body_open', function () {
	?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( VV_GTM_ID ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php
}, PHP_INT_MIN );
