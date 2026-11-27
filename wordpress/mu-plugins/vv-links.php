<?php
/**
 * Plugin Name: VV Links
 * Description: The link-in-bio page for Instagram (/links/). The WordPress page with post meta vv_links = 1 is drawn as a
 *              standalone, mobile-first page: no theme header, menu or footer, and none of the theme's or Elementor's
 *              stylesheets or scripts (wp_head still runs, so Rank Math's meta and Google Tag Manager load). Shows the
 *              headshot, name and bio line, the fixed buttons, the free tools (two cards side by side on a tinted
 *              background), then the latest Instagram post links (newest first).
 *              Content comes from the vv_links option, which is wordpress/content/links.json from the repo
 *              (wordpress/build/pages/links.php writes it). Every link carries utm_source=instagram, utm_medium=social,
 *              utm_campaign=link_in_bio and utm_content=<link>, and every click pushes a link_in_bio_click event to the
 *              dataLayer. Kept out of search: noindex, follow (Rank Math robots meta plus an X-Robots-Tag header), and
 *              nothing on the site links to it.
 * Version:     1.1.1
 *
 * Install: copy to wp-content/mu-plugins/vv-links.php (must-use plugins load automatically).
 */

defined( 'ABSPATH' ) || exit;

function vv_links_is_page() {
	return is_page() && '1' === (string) get_post_meta( get_queried_object_id(), 'vv_links', true );
}

/* Belt and braces: whatever Rank Math's settings say, this page is noindex, follow. */
add_filter( 'rank_math/frontend/robots', function ( $robots ) {
	if ( vv_links_is_page() ) {
		$robots['index']  = 'noindex';
		$robots['follow'] = 'follow';
	}
	return $robots;
} );

/** Link with the Instagram UTM tags; utm_content names the button or post. */
function vv_links_tag( $url, $content ) {
	$url = 0 === strpos( $url, '/' ) ? home_url( $url ) : $url;
	return add_query_arg( array(
		'utm_source'   => 'instagram',
		'utm_medium'   => 'social',
		'utm_campaign' => 'link_in_bio',
		'utm_content'  => substr( sanitize_title( $content ), 0, 60 ),
	), $url );
}

/** Thumbnail for a post link: its own image if given, else the featured image of the essay it points to. */
function vv_links_thumb( $item ) {
	if ( ! empty( $item['image'] ) ) {
		return is_numeric( $item['image'] ) ? (string) wp_get_attachment_image_url( (int) $item['image'], 'thumbnail' ) : (string) $item['image'];
	}
	$url = 0 === strpos( $item['url'], '/' ) ? home_url( $item['url'] ) : $item['url'];
	$id  = url_to_postid( $url );
	return $id && has_post_thumbnail( $id ) ? (string) get_the_post_thumbnail_url( $id, 'thumbnail' ) : '';
}

add_action( 'template_redirect', function () {
	if ( ! vv_links_is_page() ) {
		return;
	}
	$data = json_decode( (string) get_option( 'vv_links', '' ), true );
	if ( ! is_array( $data ) ) {
		return; // Fall back to the ordinary page rather than an empty one.
	}
	header( 'X-Robots-Tag: noindex, follow', true );

	/* Standalone page: drop every stylesheet and script the theme and plugins enqueue (GTM is printed inline by vv-gtm). */
	add_action( 'wp_enqueue_scripts', function () {
		global $wp_styles, $wp_scripts;
		foreach ( (array) $wp_styles->queue as $h ) { wp_dequeue_style( $h ); }
		foreach ( (array) $wp_scripts->queue as $h ) { wp_dequeue_script( $h ); }
	}, PHP_INT_MAX );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	$e     = function ( $s ) { echo esc_html( $s ); };
	$photo = wp_get_attachment_image_url( 8, 'medium' );
	$max   = (int) ( $data['max'] ?? 12 );
	$posts = array_slice( (array) ( $data['posts'] ?? array() ), 0, $max );
	$latest = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1 ) );
	?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<style id="vv-links-css">
:root{--ink:#1d1d1f;--muted:#6e6e73;--line:#e0e0e0;--bg:#f5f5f7;--card:#fff;--blue:#0066cc}
*{box-sizing:border-box}
html,body{margin:0;padding:0;background:var(--bg)}
body{font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;color:var(--ink);-webkit-font-smoothing:antialiased;line-height:1.4}
.vvl{max-width:520px;margin:0 auto;padding:40px 16px 32px}
.vvl-head{text-align:center;margin-bottom:28px}
.vvl-photo{width:96px;height:96px;border-radius:50%;object-fit:cover;display:block;margin:0 auto 14px;background:#ddd}
.vvl-name{font-size:24px;font-weight:600;letter-spacing:-.02em;margin:0}
.vvl-bio{font-size:15px;color:var(--muted);margin:8px auto 0;max-width:360px}
.vvl-fixed{display:grid;grid-template-columns:minmax(0,1fr);gap:10px;margin-bottom:32px}
.vvl-btn{display:block;text-decoration:none;color:var(--ink);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:15px 18px;text-align:center;font-size:16px;font-weight:600;transition:border-color .15s,transform .15s}
.vvl-btn small{display:block;font-weight:400;font-size:13px;color:var(--muted);margin-top:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.vvl-btn.is-primary{background:var(--ink);color:#fff;border-color:var(--ink)}
.vvl-btn.is-primary small{color:#cccccc}
.vvl-tools{margin-bottom:32px}
.vvl-label.is-title{text-transform:none;letter-spacing:-.01em;font-size:17px;font-weight:600;color:var(--ink)}
.vvl-tool-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
.vvl-tool{display:flex;flex-direction:column;gap:6px;text-decoration:none;color:var(--ink);background:#eaf2fc;border:1px solid #cfe0f5;border-radius:14px;padding:16px 14px;transition:border-color .15s,transform .15s}
.vvl-tool-name{font-size:16px;font-weight:600;line-height:1.25}
.vvl-tool-text{font-size:13px;color:#44474d;line-height:1.35}
.vvl-tool:hover{border-color:#0066cc}
.vvl-tool:focus-visible{outline:2px solid var(--blue);outline-offset:2px}
.vvl-label{font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin:0 0 12px}
.vvl-posts{display:grid;grid-template-columns:minmax(0,1fr);gap:10px;list-style:none;margin:0;padding:0}
.vvl-posts li{min-width:0}
.vvl-post{display:flex;gap:14px;align-items:center;text-decoration:none;color:var(--ink);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:10px;transition:border-color .15s,transform .15s}
.vvl-thumb{width:64px;height:64px;border-radius:10px;object-fit:cover;flex:0 0 64px;background:var(--bg)}
.vvl-thumb.is-empty{display:flex;align-items:center;justify-content:center;font-weight:600;color:var(--muted)}
.vvl-post-title{font-size:15px;font-weight:600;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.vvl-post-date{font-size:12px;color:var(--muted);margin-top:4px}
.vvl-btn:hover,.vvl-post:hover{border-color:var(--ink)}
.vvl-btn:focus-visible,.vvl-post:focus-visible{outline:2px solid var(--blue);outline-offset:2px}
.vvl-foot{text-align:center;font-size:12px;color:var(--muted);margin-top:36px}
.vvl-foot a{color:var(--muted)}
#ast-scroll-top,.ast-scroll-top-icon{display:none!important}
@media (prefers-reduced-motion:no-preference){.vvl-btn:active,.vvl-post:active,.vvl-tool:active{transform:scale(.98)}}
</style>
</head>
<body <?php body_class( 'vv-links' ); ?>>
<?php wp_body_open(); ?>
<main class="vvl">
	<header class="vvl-head">
		<?php if ( $photo ) : ?><img class="vvl-photo" src="<?php echo esc_url( $photo ); ?>" alt="Vineet Vijay" width="96" height="96"><?php endif; ?>
		<h1 class="vvl-name">Vineet Vijay</h1>
		<p class="vvl-bio"><?php $e( $data['bio'] ?? '' ); ?></p>
	</header>
	<nav class="vvl-fixed" aria-label="Main links">
		<?php
		$pos = 0;
		foreach ( (array) ( $data['fixed'] ?? array() ) as $i => $b ) {
			$pos++;
			$url = $b['url'] ?? '';
			$sub = '';
			if ( ! empty( $b['latest'] ) ) {
				if ( ! $latest ) { continue; }
				$url = wp_make_link_relative( get_permalink( $latest[0] ) );
				$sub = wp_strip_all_tags( get_the_title( $latest[0] ) );
			}
			if ( ! $url ) { continue; }
			printf(
				'<a class="vvl-btn%s" href="%s" data-vvl="fixed" data-vvl-pos="%d">%s%s</a>',
				0 === $i ? ' is-primary' : '',
				esc_url( vv_links_tag( $url, $b['label'] ) ),
				$pos,
				esc_html( $b['label'] ),
				$sub ? '<small>' . esc_html( $sub ) . '</small>' : ''
			);
		}
		?>
	</nav>
	<?php $tools = (array) ( $data['tools'] ?? array() ); if ( $tools ) : ?>
	<section class="vvl-tools" aria-labelledby="vvl-tools-label">
		<h2 class="vvl-label is-title" id="vvl-tools-label"><?php $e( $data['tools_title'] ?? 'Free Tools for Marketers' ); ?></h2>
		<div class="vvl-tool-grid">
			<?php
			$pos = 0;
			foreach ( $tools as $t ) {
				if ( empty( $t['url'] ) || empty( $t['label'] ) ) { continue; }
				$pos++;
				printf(
					'<a class="vvl-tool" href="%s" data-vvl="tool" data-vvl-pos="%d"><span class="vvl-tool-name">%s</span>%s</a>',
					esc_url( vv_links_tag( $t['url'], $t['label'] ) ),
					$pos,
					esc_html( $t['label'] ),
					! empty( $t['text'] ) ? '<span class="vvl-tool-text">' . esc_html( $t['text'] ) . '</span>' : ''
				);
			}
			?>
		</div>
	</section>
	<?php endif; ?>
	<?php if ( $posts ) : ?>
	<section aria-labelledby="vvl-posts-label">
		<h2 class="vvl-label" id="vvl-posts-label">From my Instagram posts</h2>
		<ul class="vvl-posts">
			<?php
			$pos = 0;
			foreach ( $posts as $p ) {
				if ( empty( $p['url'] ) || empty( $p['title'] ) ) { continue; }
				$pos++;
				$thumb = vv_links_thumb( $p );
				$date  = ! empty( $p['date'] ) ? date_i18n( 'j M Y', strtotime( $p['date'] ) ) : '';
				echo '<li><a class="vvl-post" href="' . esc_url( vv_links_tag( $p['url'], $p['title'] ) ) . '" data-vvl="post" data-vvl-pos="' . (int) $pos . '">';
				echo $thumb
					? '<img class="vvl-thumb" src="' . esc_url( $thumb ) . '" alt="" width="64" height="64" loading="' . ( $pos > 4 ? 'lazy' : 'eager' ) . '">'
					: '<span class="vvl-thumb is-empty" aria-hidden="true">' . esc_html( mb_substr( $p['title'], 0, 1 ) ) . '</span>';
				echo '<span><span class="vvl-post-title">' . esc_html( $p['title'] ) . '</span>';
				if ( $date ) { echo '<span class="vvl-post-date">' . esc_html( $date ) . '</span>'; }
				echo '</span></a></li>';
			}
			?>
		</ul>
	</section>
	<?php endif; ?>
	<p class="vvl-foot">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Vineet Vijay · <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy policy</a></p>
</main>
<script>
document.addEventListener('click',function(ev){var a=ev.target.closest&&ev.target.closest('a[data-vvl]');if(!a)return;
var t=a.querySelector('.vvl-post-title,.vvl-tool-name');window.dataLayer=window.dataLayer||[];
window.dataLayer.push({event:'link_in_bio_click',link_section:a.getAttribute('data-vvl'),link_position:+a.getAttribute('data-vvl-pos'),link_text:(t?t.textContent:a.firstChild.textContent).trim(),link_url:a.href.split('?')[0]});});
</script>
<?php wp_footer(); ?>
</body>
</html>
<?php
	exit;
} );
