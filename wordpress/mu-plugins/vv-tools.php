<?php
/**
 * Plugin Name: VV Tools
 * Description: Renders the llms.txt generator pages as part of the site. Each generator is a WordPress page under
 *              /ai-tools/llms-txt-generator/ with post meta vv_tool = <slug>; this plugin draws it inside the theme
 *              (Astra header, Rank Math breadcrumbs, footer): hero, why, what to include, the stepped
 *              generator, FAQ and more generators. Page copy comes from <slug>/content.json and the generator from
 *              assets/generator.js + <slug>/config.js, all in wp-content/uploads/vv-tools/llms-txt-generator/.
 *              SEO meta (title, description, robots) is Rank Math's, set per page; FAQPage schema comes from vv_faq.
 *              generator.css is printed inline in the head; the two scripts load deferred.
 * Version:     3.3.0
 *
 * Install: copy to wp-content/mu-plugins/vv-tools.php (see wordpress/tools/install-llms-generators.php).
 */

defined( 'ABSPATH' ) || exit;

function vv_tools_dir() { return wp_get_upload_dir()['basedir'] . '/vv-tools/llms-txt-generator/'; }

function vv_tools_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$slug = (string) get_post_meta( get_queried_object_id(), 'vv_tool', true );
	return $slug && preg_match( '/^[a-z0-9-]+$/', $slug ) && is_file( vv_tools_dir() . $slug . '/config.js' ) && is_file( vv_tools_dir() . $slug . '/content.json' ) ? $slug : '';
}

add_action( 'template_redirect', function () {
	$slug = vv_tools_slug();
	if ( ! $slug ) {
		return;
	}
	$dir = vv_tools_dir();
	$url = set_url_scheme( wp_get_upload_dir()['baseurl'] . '/vv-tools/llms-txt-generator/', 'https' );
	$ver = function ( $f ) use ( $dir ) { return (string) filemtime( $dir . $f ); };
	add_action( 'wp_enqueue_scripts', function () use ( $slug, $url, $ver ) {
		/* The stylesheet is small (under 4 KiB), so it is printed in the head instead of fetched: one less render-blocking request. */
		wp_register_style( 'vv-llms', false, array(), $ver( 'assets/generator.css' ) );
		wp_enqueue_style( 'vv-llms' );
		wp_add_inline_style( 'vv-llms', (string) file_get_contents( vv_tools_dir() . 'assets/generator.css' ) );
		$defer = array( 'in_footer' => true, 'strategy' => 'defer' );
		wp_enqueue_script( 'vv-llms-config', $url . $slug . '/config.js', array(), $ver( $slug . '/config.js' ), $defer );
		wp_enqueue_script( 'vv-llms', $url . 'assets/generator.js', array( 'vv-llms-config' ), $ver( 'assets/generator.js' ), $defer );
	} );
	add_filter( 'body_class', function ( $c ) { $c[] = 'vvg-page'; return $c; } );
	$copy = json_decode( (string) file_get_contents( $dir . $slug . '/content.json' ), true );
	get_header();
	vv_tools_render( get_queried_object_id(), $copy );
	get_footer();
	exit;
} );

function vv_tools_render( $id, $c ) {
	$hub    = wp_get_post_parent_id( $id );
	$hubUrl = get_permalink( $hub );
	$self   = get_permalink( $id );
	$label  = (string) get_post_meta( $id, 'vv_tool_label', true );
	$others = get_posts( array( 'post_type' => 'page', 'post_parent' => $hub, 'post_status' => 'publish', 'numberposts' => 20, 'orderby' => 'menu_order', 'order' => 'ASC', 'exclude' => array( $id ), 'meta_key' => 'vv_tool' ) );
	$enc    = rawurlencode( $self );
	$e      = function ( $s ) { echo esc_html( $s ); };
	?>
<div class="vvg">
	<header class="vvg-hero">
		<div class="vvg-wrap">
			<h1><?php $e( $c['h1'] ); ?></h1>
			<p class="vvg-hero-lead"><?php $e( $c['lead'] ); ?></p>
			<div class="vvg-hero-btns">
				<a class="vvg-btn-outline" href="#guide">What to include</a>
				<a class="vvg-btn-blue" href="#generator">Build the file</a>
			</div>
			<p class="vvg-byline">By <a href="<?php echo esc_url( home_url( '/experience/' ) ); ?>">Vineet Vijay</a> · Updated <?php $e( get_the_modified_date( 'j F Y', $id ) ); ?> · Runs in the browser. Nothing is uploaded.</p>
		</div>
	</header>

	<section id="why" class="vvg-section vvg-bg-parch">
		<div class="vvg-wrap vvg-why">
			<div class="vvg-why-copy">
				<h2 class="vvg-h2"><?php $e( $c['why']['h2'] ); ?></h2>
				<p class="vvg-intro"><?php $e( $c['why']['intro'] ); ?></p>
				<a class="vvg-btn-blue" href="#generator">Generate llms.txt file</a>
			</div>
			<div class="vvg-why-list">
				<?php foreach ( $c['why']['items'] as $it ) : ?>
				<div><h3><?php $e( $it[0] ); ?></h3><p><?php $e( $it[1] ); ?></p></div>
				<?php endforeach; ?>
				<p class="vvg-note">llms.txt is an emerging, voluntary standard. Support differs between AI platforms and continues to develop.</p>
			</div>
		</div>
	</section>

	<section id="guide" class="vvg-section vvg-bg-white">
		<div class="vvg-wrap">
			<h2 class="vvg-h2"><?php $e( $c['guide']['h2'] ); ?></h2>
			<p class="vvg-intro"><?php $e( $c['guide']['intro'] ); ?></p>
			<div class="vvg-types">
				<?php foreach ( $c['guide']['types'] as $it ) : ?>
				<div class="vvg-card"><h3><?php $e( $it[0] ); ?></h3><p><?php $e( $it[1] ); ?></p></div>
				<?php endforeach; ?>
			</div>
			<div class="vvg-bp-head">
				<h3><?php $e( $c['guide']['bp_h3'] ); ?></h3>
				<p>The file is only as useful as the pages it points to. These habits keep both accurate.</p>
			</div>
			<div class="vvg-bp">
				<?php foreach ( $c['guide']['bp'] as $it ) : ?>
				<div class="vvg-card"><h4><?php $e( $it[0] ); ?></h4><p><?php $e( $it[1] ); ?></p></div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="generator" class="vvg-section vvg-bg-parch">
		<div class="vvg-wrap-wide">
			<div class="vvg-gen-head">
				<div>
					<h2 class="vvg-h2">Generator.</h2>
					<p>Fill in each step. The preview updates as you type.</p>
				</div>
				<div class="vvg-gen-tools">
					<button type="button" class="vvg-btn-light" data-vvg="example">Load example</button>
					<button type="button" class="vvg-link-btn" data-vvg="clear">Clear form</button>
				</div>
			</div>
			<div id="vvg-app"><noscript>This generator runs in your browser and needs JavaScript.</noscript></div>
		</div>
	</section>

	<section id="faq" class="vvg-section vvg-bg-white">
		<div class="vvg-wrap-narrow">
			<h2 class="vvg-h2">Frequently asked questions.</h2>
			<div class="vvg-faq">
				<?php foreach ( $c['faqs'] as $i => $q ) : ?>
				<details<?php echo 0 === $i ? ' open' : ''; ?>><summary><h3><?php $e( $q[0] ); ?></h3></summary><p><?php $e( $q[1] ); ?></p></details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="vvg-section vvg-bg-parch">
		<div class="vvg-wrap vvg-more">
			<div class="vvg-card">
				<span class="vvg-eyebrow">Other industries</span>
				<h2>More llms.txt generators.</h2>
				<div class="vvg-more-links">
					<?php foreach ( $others as $o ) : ?>
					<a href="<?php echo esc_url( get_permalink( $o ) ); ?>"><?php $e( get_post_meta( $o->ID, 'vv_tool_label', true ) ); ?> ›</a>
					<?php endforeach; ?>
					<a href="<?php echo esc_url( $hubUrl ); ?>">All industries ›</a>
				</div>
				<div class="vvg-more-share">If this tool made it easy for you to build your llms.txt file, share it with your peers and fellow marketers.
					<div class="vvg-more-links">
						<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $enc ); ?>" target="_blank" rel="noopener">LinkedIn ↗</a>
						<a href="https://wa.me/?text=<?php echo esc_attr( rawurlencode( 'A free llms.txt generator for ' . strtolower( $label ) . ' websites: ' ) . $enc ); ?>" target="_blank" rel="noopener">WhatsApp ↗</a>
						<a href="mailto:?subject=<?php echo esc_attr( rawurlencode( 'A free llms.txt generator for ' . strtolower( $label ) ) ); ?>&amp;body=<?php echo esc_attr( rawurlencode( 'Thought this might help: ' ) . $enc ); ?>">Email ↗</a>
					</div>
				</div>
			</div>
			<div class="vvg-card">
				<span class="vvg-eyebrow">About the author</span>
				<h2>Built by Vineet Vijay.</h2>
				<p>Digital marketing strategist based in the UAE, writing about AI in marketing, search, paid media and measurement.</p>
				<div class="vvg-more-links">
					<a href="<?php echo esc_url( home_url( '/writing/' ) ); ?>">Read the writing ›</a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Get in touch ›</a>
				</div>
			</div>
		</div>
	</section>
</div>
	<?php
}
