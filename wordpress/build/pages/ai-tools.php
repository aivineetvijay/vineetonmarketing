<?php
/** AI Tools (/ai-tools/): the live tools. For now the llms.txt generator family only; cards reuse the hub's classes. */
$id = vv_new( 'AI Tools', 'ai-tools' );

/* Live tools. For now only the llms.txt generator family (the earlier placeholder list was retired on 9 October 2026). */
$hub  = vv_url( '/ai-tools/llms-txt-generator/' );
$tool = function ( $slug ) { return vv_url( '/ai-tools/llms-txt-generator/' . $slug . '/' ); };
$industries = array(
	array( 'Real Estate', 'Developers, brokerages, agencies and portals', 'real-estate' ),
	array( 'Healthcare', 'Hospitals, clinics and specialists', 'healthcare' ),
	array( 'E-commerce', 'D2C brands, retailers and marketplaces', 'ecommerce' ),
	array( 'Education', 'Universities, schools, institutes and learning platforms', 'education' ),
	array( 'Finance & Fintech', 'Banks, payments, lending, insurance and investment firms', 'finance' ),
	array( 'Content & Publishers', 'News sites, magazines, blogs and newsletters', 'publishers' ),
);
$icon = function ( $slug ) {
	$p = get_posts( array( 'post_type' => 'attachment', 'name' => 'llms-icon-' . $slug, 'post_status' => 'inherit', 'numberposts' => 1 ) );
	return $p ? $p[0]->ID : 0;
};
$pill = function ( $p, $label ) {
	return vv_f( "$p Status", array( 'gen-pill' ), array(
		vv_p( "$p Status Dot", '●', array( 'status-dot' ), 'span' ),
		vv_p( "$p Status Label", $label, array( 'status-label' ), 'span' ),
	) );
};

/* Featured tool card (links to the hub), then one card per industry generator (same cards as the hub). */
$featured = vv_link( 'Featured Tool', array( 'gen-card' ), $hub, array(
	vv_f( 'Featured Tool Top', array( 'gen-top' ), array(
		$pill( 'Featured Tool', 'Live' ),
		vv_p( 'Featured Tool Count', count( $industries ) . ' industries', array( 't-mono' ), 'span' ),
	) ),
	vv_f( 'Featured Tool Body', array( 'gen-body' ), array(
		vv_p( 'Featured Tool Category', 'AI visibility', array( 'eyebrow-accent' ), 'span' ),
		vv_h( 'Featured Tool Name', 'llms.txt Generator', array( 'tcard-name' ), 'h3' ),
		vv_p( 'Featured Tool Use', 'Turn your website into a clean, curated llms.txt file: the short map AI assistants read to understand who you are and which pages to trust. Built separately for each industry, with the pages and rules that industry needs.', array( 'tcard-use' ) ),
	) ),
	vv_p( 'Featured Tool Action', 'Open the llms.txt generator →', array( 'gen-cta' ), 'span' ),
) );
$cards = array(); $i = 0;
foreach ( $industries as $g ) {
	$i++;
	$cards[] = vv_link( "Industry $i", array( 'gen-card' ), $tool( $g[2] ), array(
		vv_f( "Industry $i Top", array( 'gen-top' ), array(
			vv_f( "Industry $i Icon Tile", array( 'gen-icon-tile' ), array( vv_n( 'e-svg', "Industry $i Icon", array( 'gen-icon' ), array( 'svg' => array( 'id' => $icon( $g[2] ) ) ) ) ) ),
			$pill( "Industry $i", 'Live' ),
		) ),
		vv_f( "Industry $i Body", array( 'gen-body' ), array(
			vv_h( "Industry $i Title", 'llms.txt for ' . $g[0], array( 'tcard-name' ), 'h3' ),
			vv_p( "Industry $i For", $g[1], array( 'tcard-use' ) ),
		) ),
		vv_p( "Industry $i Action", 'Open generator →', array( 'gen-cta' ), 'span' ),
	) );
}

$nodes = array(
	vv_hero( 'Tools',
		array( vv_meta_block( 'Tools', 'Built for', 'Fellow marketers' ), vv_meta_block( 'Tools', 'Tools', '1 live · ' . count( $industries ) . ' industries' ), vv_meta_block( 'Tools', 'Price', 'Free to use', true ) ),
		'AI Tools', 'for marketers.', false,
		'Small, focused tools I build for marketers. The first is a family of llms.txt generators that help AI assistants describe your business accurately. Free, and everything runs in your browser.',
		array(
			vv_btn( 'Tools Generator Button', 'Open the llms.txt generator', $hub, array( 'btn', 'btn-filled' ) ),
			vv_btn( 'Tools Industry Button', 'Pick your industry', '#tools', array( 'btn' ) ),
		)
	),
	vv_f( 'Directory', array( 'section', 'pt-24', 'bg-canvas' ), array(
		vv_f( 'Directory Inner', array( 'wrap' ), array(
			vv_sec_head( 'Directory', '01', 'Live tools', 'Free · runs in your browser · nothing uploaded' ),
			vv_f( 'Directory Featured', array( 'stack', 'mt-64' ), array( $featured ) ),
			vv_p( 'Directory Industries Label', 'Or go straight to your industry', array( 't-mono', 'mt-64' ) ),
			vv_g( 'Directory Industries', array( 'gen-grid', 'mt-32' ), $cards ),
		) ),
	), array( 'tag' => 'section' ), null, 'tools' ),
	vv_f( 'Ideas', array( 'section', 'bg-ink' ), array(
		vv_f( 'Ideas Inner', array( 'wrap' ), array(
			vv_f( 'Ideas Split', array( 'split' ), array(
				vv_f( 'Ideas Copy', array( 'col-6w' ), array(
					vv_p( 'Ideas Eyebrow', 'Have an idea?', array( 't-mono', 'muted-on-dark' ) ),
					vv_title_block( 'Ideas', 'Tell me what', 'to build next.', true, 't-display', 'h2', array( 'mt-24' ) ),
				), array(), vv_ix() ),
				vv_f( 'Ideas Action', array( 'col-5w' ), array(
					vv_p( 'Ideas Text', 'If there’s a task you repeat every week, there’s probably a tool in it. Send it over — the most requested ideas get built first.', array( 't-body', 'muted-on-dark', 'measure-440' ) ),
					vv_f( 'Ideas Buttons', array( 'btn-row', 'mt-32' ), array(
						vv_btn_dark( 'Ideas Suggest Button', 'Suggest a tool', vv_url( '/contact/' ), true ),
						vv_btn_dark( 'Ideas Subscribe Button', 'Get new tools', vv_url( '/writing/#subscribe' ) ),
					) ),
				), array(), vv_ix( 'scrollIn', 'slide', 120 ) ),
			) ),
		) ),
	), array( 'tag' => 'section' ) ),
);

return array( 'id' => $id, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
