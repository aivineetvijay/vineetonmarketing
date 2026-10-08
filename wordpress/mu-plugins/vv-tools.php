<?php
/**
 * Plugin Name: VV Tools
 * Description: Renders the llms.txt generators as part of the site. Each generator is a WordPress page under
 *              /ai-tools/llms-txt-generator/ with post meta vv_tool = <slug>; this plugin draws the page inside the
 *              theme (Astra header, Rank Math breadcrumbs, footer) with the tool's hero, the generator app and a
 *              share card. The app is wp-content/uploads/vv-tools/llms-txt-generator/assets/generator.js with the
 *              industry's <slug>/config.js. SEO meta (title, description, robots) is Rank Math's, set per page.
 * Version:     2.0.0
 *
 * Install: copy to wp-content/mu-plugins/vv-tools.php (see wordpress/tools/install-llms-generators.php).
 */

defined( 'ABSPATH' ) || exit;

function vv_tools_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$slug = (string) get_post_meta( get_queried_object_id(), 'vv_tool', true );
	return $slug && preg_match( '/^[a-z0-9-]+$/', $slug ) && is_file( wp_get_upload_dir()['basedir'] . '/vv-tools/llms-txt-generator/' . $slug . '/config.js' ) ? $slug : '';
}

add_action( 'template_redirect', function () {
	$slug = vv_tools_slug();
	if ( ! $slug ) {
		return;
	}
	$up  = wp_get_upload_dir();
	$dir = $up['basedir'] . '/vv-tools/llms-txt-generator/';
	$url = set_url_scheme( $up['baseurl'] . '/vv-tools/llms-txt-generator/', 'https' );
	$ver = function ( $f ) use ( $dir ) { return (string) filemtime( $dir . $f ); };
	add_action( 'wp_enqueue_scripts', function () use ( $slug, $url, $ver ) {
		wp_enqueue_style( 'vv-llms', $url . 'assets/generator.css', array(), $ver( 'assets/generator.css' ) );
		wp_enqueue_script( 'vv-llms-config', $url . $slug . '/config.js', array(), $ver( $slug . '/config.js' ), true );
		wp_enqueue_script( 'vv-llms', $url . 'assets/generator.js', array( 'vv-llms-config' ), $ver( 'assets/generator.js' ), true );
	} );
	add_filter( 'body_class', function ( $c ) { $c[] = 'vvg-page'; return $c; } );
	get_header();
	vv_tools_render( get_queried_object_id(), $slug );
	get_footer();
	exit;
} );

function vv_tools_render( $id, $slug ) {
	$h1    = explode( '|', (string) get_post_meta( $id, 'vv_tool_h1', true ) . '|' );
	$label = (string) get_post_meta( $id, 'vv_tool_label', true );
	$hub   = get_permalink( wp_get_post_parent_id( $id ) );
	$link  = rawurlencode( get_permalink( $id ) );
	$what  = rawurlencode( 'A free llms.txt generator for ' . strtolower( $label ) . ' websites: ' );
	?>
<div class="vvg">
	<section class="vvg-hero">
		<div class="vvg-wrap">
			<p class="vvg-eyebrow"><a href="<?php echo esc_url( $hub ); ?>">llms.txt Generator</a> · <?php echo esc_html( $label ); ?></p>
			<h1 class="vvg-h1"><?php echo esc_html( trim( $h1[0] ) ); ?> <em><?php echo esc_html( trim( $h1[1] ) ); ?></em></h1>
			<div class="vvg-hero-foot">
				<p class="vvg-lead"><?php echo esc_html( get_post_field( 'post_excerpt', $id ) ); ?></p>
				<div class="vvg-btns">
					<button type="button" class="vvg-btn-filled" data-vvg="example">Load example</button>
					<button type="button" class="vvg-btn" data-vvg="clear">Clear form</button>
				</div>
			</div>
		</div>
	</section>
	<section class="vvg-tool" id="vvg-tool">
		<div class="vvg-wrap"><div id="vvg-app"><noscript>This generator runs in your browser and needs JavaScript.</noscript></div></div>
	</section>
	<section class="vvg-share">
		<div class="vvg-wrap vvg-share-inner">
			<div>
				<h2>Did this make your llms.txt <em>easier?</em></h2>
				<p>If this tool made it easy for you to build your llms.txt file, share it with your peers and fellow marketers.</p>
				<a class="vvg-share-more" href="<?php echo esc_url( $hub ); ?>">All llms.txt generators</a>
			</div>
			<div class="vvg-btns">
				<a class="vvg-btn-filled" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $link ); ?>" target="_blank" rel="noopener">Share on LinkedIn ↗</a>
				<a class="vvg-btn" href="https://wa.me/?text=<?php echo esc_attr( $what . $link ); ?>" target="_blank" rel="noopener">WhatsApp ↗</a>
				<a class="vvg-btn" href="mailto:?subject=<?php echo esc_attr( rawurlencode( 'A free llms.txt generator for ' . strtolower( $label ) ) ); ?>&amp;body=<?php echo esc_attr( rawurlencode( 'Thought this might help: ' ) . $link ); ?>">Email ↗</a>
			</div>
		</div>
	</section>
</div>
	<?php
}
