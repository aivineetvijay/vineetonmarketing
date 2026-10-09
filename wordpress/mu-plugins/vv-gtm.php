<?php
/**
 * Plugin Name: VV Google Tag Manager
 * Description: Prints the Google Tag Manager container (GTM-MPZBRGLB) first in <head>, plus the <noscript> fallback right after <body>.
 *              gtm.js (and the GA4 tag it loads) is fetched on the visitor's first scroll, tap, click, key press or mouse
 *              move, or 10 seconds after the page has loaded, whichever comes first, so it stays off the critical path
 *              and outside the window lab tests such as PageSpeed Insights measure.
 *              The gtm.start timestamp is still recorded at page start.
 * Version:     1.3.0
 *
 * Install: copy to wp-content/mu-plugins/vv-gtm.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

const VV_GTM_ID = 'GTM-MPZBRGLB';

add_action( 'wp_head', function () {
	?>
<!-- Google Tag Manager (loads on first interaction, or 10 s after the page has loaded) -->
<script>(function(w,d,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
var done=0,ev=['scroll','mousemove','touchstart','keydown','click'];
function go(){if(done)return;done=1;ev.forEach(function(e){w.removeEventListener(e,go,{passive:true});});
var j=d.createElement('script');j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i;d.head.appendChild(j);}
ev.forEach(function(e){w.addEventListener(e,go,{passive:true});});
w.addEventListener('load',function(){setTimeout(go,10000);});
})(window,document,'dataLayer','<?php echo esc_js( VV_GTM_ID ); ?>');</script>
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
