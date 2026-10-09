<?php
/**
 * Plugin Name: VV Performance
 * Description: Removes front-end files the site does not use. Every page is built with Elementor, so the WordPress
 *              block stylesheets and the Hostinger Reach subscription-block stylesheet are render-blocking requests
 *              with nothing to style. They still load on any page whose content does contain blocks. Also removes
 *              the emoji detection script and styles (browsers draw emoji natively).
 *              On Elementor pages Inter comes from Elementor's local copy (one variable font file for every weight), so
 *              Astra's second copy of Inter is skipped there and Elementor's file is preloaded instead.
 *              Theme, Elementor and font stylesheets are printed inline in <head>; essay banners load eagerly and the
 *              one for the current screen size is preloaded at high priority.
 * Version:     1.2.0
 *
 * Install: copy to wp-content/mu-plugins/vv-performance.php (must-use plugins load automatically).
 * Related settings (not in this file): Astra loads Google Fonts locally with preload (Astra > Performance);
 *              Elementor loads Google Fonts locally (elementor_local_google_fonts) and prints page CSS inline
 *              (elementor_css_print_method = internal); the kit's unused default global fonts are set to Inter, so
 *              Roboto and Roboto Slab no longer load; LiteSpeed browser cache is on (1 year).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	if ( is_singular() && has_blocks( get_queried_object() ) ) {
		return;
	}
	foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'hostinger-reach-subscription-block' ) as $h ) {
		wp_dequeue_style( $h );
	}
}, 100 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

/* Elementor's local Inter stylesheet and its Latin upright file (all weights). Empty if Elementor has not built it. */
function vv_perf_elementor_inter() {
	$css = wp_get_upload_dir()['basedir'] . '/elementor/google-fonts/css/inter.css';
	if ( ! is_file( $css ) ) {
		return '';
	}
	$key  = 'vv_perf_inter_' . filemtime( $css );
	$font = get_transient( $key );
	if ( false === $font ) {
		$font = preg_match( '#/\* latin \*/\s*@font-face \{[^}]*font-style: normal;[^}]*url\(([^)]+)\)#', (string) file_get_contents( $css ), $m ) ? trim( $m[1], '\'"' ) : '';
		set_transient( $key, $font, MONTH_IN_SECONDS );
	}
	return $font;
}

function vv_perf_is_elementor_page() {
	return is_singular() && class_exists( '\Elementor\Plugin' )
		&& \Elementor\Plugin::$instance->documents->get( get_queried_object_id() )
		&& \Elementor\Plugin::$instance->documents->get( get_queried_object_id() )->is_built_with_elementor();
}

add_filter( 'astra_render_fonts', function ( $fonts ) {
	return vv_perf_is_elementor_page() && vv_perf_elementor_inter() ? array() : $fonts;
} );

add_action( 'wp_head', function () {
	$font = vv_perf_is_elementor_page() ? vv_perf_elementor_inter() : '';
	if ( $font ) {
		echo '<link rel="preload" href="' . esc_url( $font ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
}, 1 );

/* ---------- Essay banner: the LCP image ----------
 * Each essay has a desktop banner (3:1, hidden at 767px and below) and a mobile banner (16:10, shown at 767px and
 * below), or one placeholder tile. WordPress lazy-loads every image after the first, which delays the mobile banner.
 * Banners load eagerly; the one the screen will show is preloaded at high priority with a media query. */

function vv_perf_banner_classes() {
	static $ids = null;
	if ( null === $ids ) {
		$ids = array();
		if ( class_exists( '\Elementor\Modules\GlobalClasses\Global_Classes_Repository' ) ) {
			foreach ( \Elementor\Modules\GlobalClasses\Global_Classes_Repository::make()->all()->get_items()->all() as $c ) {
				if ( in_array( $c['label'], array( 'art-banner', 'art-banner-desktop', 'art-banner-mobile' ), true ) ) {
					$ids[ $c['id'] ] = $c['label'];
				}
			}
		}
	}
	return $ids;
}

/* Banner attachment IDs on a post, by class label: art-banner-desktop / art-banner-mobile / art-banner. */
function vv_perf_banners( $post_id ) {
	$key = 'vv_perf_banners_' . $post_id . '_' . get_post_modified_time( 'U', true, $post_id );
	$found = get_transient( $key );
	if ( false !== $found ) {
		return $found;
	}
	$found = array();
	$classes = vv_perf_banner_classes();
	$walk = function ( $els ) use ( &$walk, &$found, $classes ) {
		foreach ( (array) $els as $el ) {
			if ( 'e-image' === ( $el['widgetType'] ?? '' ) ) {
				foreach ( (array) ( $el['settings']['classes']['value'] ?? array() ) as $cid ) {
					$img = $el['settings']['image']['value']['src']['value']['id']['value'] ?? 0;
					if ( isset( $classes[ $cid ] ) && $img && ! isset( $found[ $classes[ $cid ] ] ) ) {
						$found[ $classes[ $cid ] ] = (int) $img;
					}
				}
			}
			$walk( $el['elements'] ?? array() );
		}
	};
	$walk( json_decode( (string) get_post_meta( $post_id, '_elementor_data', true ), true ) );
	set_transient( $key, $found, MONTH_IN_SECONDS );
	return $found;
}

/* Elementor decides loading/fetchpriority per <img> on wp_content_img_tag (priority 10) and lazy-loads everything
 * after its first few images. Marking the banners eager first makes it leave them alone (it still adds
 * fetchpriority="high" to a single placeholder tile itself). */
add_filter( 'wp_content_img_tag', function ( $img ) {
	if ( ! preg_match( '/class="[^"]*\bart-banner\b/', $img ) || preg_match( '/ loading=/', $img ) ) {
		return $img;
	}
	return str_replace( '<img', '<img loading="eager"', $img );
}, 5 );

add_action( 'wp_head', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	$media = array( 'art-banner-desktop' => '(min-width: 768px)', 'art-banner-mobile' => '(max-width: 767px)', 'art-banner' => '' );
	foreach ( vv_perf_banners( get_queried_object_id() ) as $label => $id ) {
		$src = wp_get_attachment_image_url( $id, 'full' );
		if ( ! $src ) {
			continue;
		}
		$set = wp_get_attachment_image_srcset( $id, 'full' );
		echo '<link rel="preload" as="image" href="' . esc_url( $src ) . '"'
			. ( $set ? ' imagesrcset="' . esc_attr( $set ) . '" imagesizes="100vw"' : '' )
			. ( $media[ $label ] ? ' media="' . esc_attr( $media[ $label ] ) . '"' : '' )
			. ' fetchpriority="high">' . "\n";
	}
}, 2 );

/* ---------- Render-blocking stylesheets printed inline ----------
 * The theme, Elementor and font stylesheets are small once compressed (about 23 KiB together), so they are printed
 * in <head> instead of fetched one by one; the browser can paint without waiting on eight requests. The CSS is
 * unchanged, read from the same files, with the same media query. Not in the Elementor editor or Customizer. */

add_filter( 'style_loader_tag', function ( $tag, $handle, $href, $media ) {
	if ( is_admin() || is_customize_preview() || isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return $tag;
	}
	if ( ! preg_match( '/^(astra-theme-css|astra-google-fonts|elementor-frontend|elementor-post-\d+|elementor-gf-local-[a-z]+|base-(desktop|tablet|mobile)|global-\d+-frontend-(desktop|tablet|mobile))$/', $handle ) ) {
		return $tag;
	}
	$path = wp_parse_url( $href, PHP_URL_PATH );
	$host = wp_parse_url( $href, PHP_URL_HOST );
	if ( ! $path || ( $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host ) ) {
		return $tag;
	}
	$file = ABSPATH . ltrim( $path, '/' );
	if ( ! is_file( $file ) || filesize( $file ) > 80 * KB_IN_BYTES ) {
		return $tag;
	}
	$css = (string) file_get_contents( $file );
	/* Relative url() references resolve against the stylesheet's folder, so make them absolute. */
	$base = trailingslashit( dirname( strtok( $href, '?' ) ) );
	$css  = preg_replace_callback( '#url\(\s*([\'"]?)(?!data:|https?:|/|\#)([^\'")]+)\1\s*\)#i', function ( $m ) use ( $base ) {
		return 'url(' . $m[1] . $base . $m[2] . $m[1] . ')';
	}, $css );
	$css = str_replace( '</style', '<\/style', $css );
	return '<style id="' . esc_attr( $handle ) . '-css"' . ( $media && 'all' !== $media ? ' media="' . esc_attr( $media ) . '"' : '' ) . '>' . $css . "</style>\n";
}, 10, 4 );
