<?php
/**
 * Plugin Name: VV UTM Builder
 * Description: Renders the UTM builder pages as part of the site. The hub (/ai-tools/utm-builder/) and one page per
 *              industry (/ai-tools/utm-builder/<slug>/) are WordPress pages with post meta vv_utm = <builder id>; this
 *              plugin draws them inside the theme (Astra header, footer): the site's standard hero (meta strip, large
 *              headline, lead and buttons), the builder tabs, the builder itself and the guide below it. Page copy comes from pages.json; the builder from configs.js, ga4.js, qrcode.js,
 *              page.js and engine.js, all in wp-content/uploads/vv-tools/utm-builder/. utm.css is printed inline in
 *              the head; the scripts load deferred. SEO meta is Rank Math's, set per page; FAQPage schema comes from
 *              vv_faq (vv-schema.php); this plugin adds the WebApplication schema.
 * Version:     1.1.0
 *
 * Install: see wordpress/tools/utm-builder/install.php.
 */

defined( 'ABSPATH' ) || exit;

function vv_utm_dir() { return wp_get_upload_dir()['basedir'] . '/vv-tools/utm-builder/'; }

/** The pages.json entry for the current page, or null. */
function vv_utm_page() {
	static $page = false;
	if ( false !== $page ) {
		return $page;
	}
	$page = null;
	if ( ! is_page() ) {
		return $page;
	}
	$id = (string) get_post_meta( get_queried_object_id(), 'vv_utm', true );
	if ( ! $id || ! preg_match( '/^[a-z0-9-]+$/', $id ) || ! is_file( vv_utm_dir() . 'pages.json' ) || ! is_file( vv_utm_dir() . 'engine.js' ) ) {
		return $page;
	}
	$data = json_decode( (string) file_get_contents( vv_utm_dir() . 'pages.json' ), true );
	foreach ( (array) ( $data['pages'] ?? array() ) as $p ) {
		if ( $p['id'] === $id ) {
			$page = $p;
			$page['all'] = $data['pages'];
			$page['base'] = $data['base'];
		}
	}
	return $page;
}

add_action( 'template_redirect', function () {
	$p = vv_utm_page();
	if ( ! $p ) {
		return;
	}
	$dir = vv_utm_dir();
	$url = set_url_scheme( wp_get_upload_dir()['baseurl'] . '/vv-tools/utm-builder/', 'https' );
	$ver = function ( $f ) use ( $dir ) { return (string) filemtime( $dir . $f ); };
	add_action( 'wp_enqueue_scripts', function () use ( $p, $url, $ver ) {
		wp_register_style( 'vv-utm', false, array(), $ver( 'utm.css' ) );
		wp_enqueue_style( 'vv-utm' );
		wp_add_inline_style( 'vv-utm', (string) file_get_contents( vv_utm_dir() . 'utm.css' ) );
		$defer = array( 'in_footer' => true, 'strategy' => 'defer' );
		wp_enqueue_script( 'vv-utm-configs', $url . 'configs.js', array(), $ver( 'configs.js' ), $defer );
		wp_enqueue_script( 'vv-utm-ga4', $url . 'ga4.js', array(), $ver( 'ga4.js' ), $defer );
		wp_enqueue_script( 'vv-utm-qr', $url . 'qrcode.js', array(), $ver( 'qrcode.js' ), $defer );
		wp_enqueue_script( 'vv-utm-page', $url . 'page.js', array( 'vv-utm-configs', 'vv-utm-ga4', 'vv-utm-qr' ), $ver( 'page.js' ), $defer );
		wp_add_inline_script( 'vv-utm-page', 'window.UTM_PAGE=' . wp_json_encode( array( 'id' => $p['id'] ) ) . ';', 'before' );
		wp_enqueue_script( 'vv-utm', $url . 'engine.js', array( 'vv-utm-page' ), $ver( 'engine.js' ), $defer );
	} );
	add_filter( 'body_class', function ( $c ) use ( $p ) {
		$c[] = 'vvu-page';
		if ( 'industry' === $p['kind'] ) {
			$c[] = 'is-industry';
		}
		return $c;
	} );
	get_header();
	vv_utm_render( get_queried_object_id(), $p );
	get_footer();
	exit;
} );

/* WebApplication schema: what the tool is, that it is free, and who made it. */
add_action( 'wp_head', function () {
	$p = vv_utm_page();
	if ( ! $p ) {
		return;
	}
	$ld = array(
		'@context'            => 'https://schema.org',
		'@type'               => 'WebApplication',
		'name'                => $p['name'],
		'url'                 => get_permalink( get_queried_object_id() ),
		'description'         => $p['description'],
		'applicationCategory' => 'BusinessApplication',
		'operatingSystem'     => 'Any (runs in the browser)',
		'isAccessibleForFree' => true,
		'offers'              => array( '@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD' ),
		'author'              => array( '@id' => home_url( '/#person' ) ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 20 );

function vv_utm_render( $id, $p ) {
	$e = function ( $s ) { echo esc_html( $s ); };
	?>
<main id="main-content" class="vvu">
	<section class="vvu-hero">
		<div class="vvu-wrap">
			<div class="vvu-meta">
				<div><p class="vvu-mono">Built for</p><p class="vvu-meta-v"><?php $e( $p['hero']['audience'] ); ?></p></div>
				<div><p class="vvu-mono">Includes</p><p class="vvu-meta-v">GA4 channel check · QR code</p></div>
				<div class="vvu-hide-m"><p class="vvu-mono">Price</p><p class="vvu-meta-v">Free to use</p></div>
			</div>
			<h1 class="vvu-huge"><?php $e( $p['hero']['main'] ); ?><?php if ( $p['hero']['aside'] ) : ?> <span class="vvu-aside"><?php $e( $p['hero']['aside'] ); ?></span><?php endif; ?></h1>
			<div class="vvu-foot">
				<p class="vvu-lead"><?php $e( $p['intro'] ); ?></p>
				<div class="vvu-btns">
					<a class="vvu-btn vvu-btn-filled" href="#builder">Build your link ↗</a>
					<a class="vvu-btn" href="#how">How it works ↗</a>
				</div>
			</div>
		</div>
	</section>
	<section class="tile-top" id="builder">
		<nav class="tabs" aria-label="UTM builders">
			<div class="tabs__links">
				<?php foreach ( $p['all'] as $o ) : ?>
				<a href="<?php echo esc_url( home_url( $p['base'] . ( $o['slug'] ? $o['slug'] . '/' : '' ) ) ); ?>"<?php echo $o['id'] === $p['id'] ? ' aria-current="page"' : ''; ?>><?php $e( $o['nav'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</nav>
		<div id="utm-app"><noscript><p>This builder needs JavaScript. Turn it on to build your links.</p></noscript></div>
	</section>
	<section class="tile-content">
		<article class="content">
			<p class="vvu-byline">By <a href="<?php echo esc_url( home_url( '/experience/' ) ); ?>">Vineet Vijay</a> · Updated <?php $e( get_the_modified_date( 'j F Y', $id ) ); ?> · Runs in your browser. Nothing is uploaded.</p>
			<?php echo str_replace( '{{YYYYMM}}', esc_html( wp_date( 'Ym' ) ), $p['content'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from the repo's pages.json ?>
		</article>
	</section>
</main>
	<?php
}
