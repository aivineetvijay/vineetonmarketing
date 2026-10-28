<?php
/** AI Tools (/ai-tools/): one card per live tool (llms.txt Generator, UTM Builder), each linking to its hub, where the
 *  industry versions are listed. Cards reuse the llms.txt hub's classes. */
$id = vv_new( 'AI Tools', 'ai-tools' );

/* Live tools: the llms.txt generator family (9 October 2026) and the UTM builder family (28 October 2026). */
$hub  = vv_url( '/ai-tools/llms-txt-generator/' );
$industries = array(
	array( 'Real Estate', 'Developers, brokerages, agencies and portals', 'real-estate' ),
	array( 'Healthcare', 'Hospitals, clinics and specialists', 'healthcare' ),
	array( 'E-commerce', 'D2C brands, retailers and marketplaces', 'ecommerce' ),
	array( 'Education', 'Universities, schools, institutes and learning platforms', 'education' ),
	array( 'Finance & Fintech', 'Banks, payments, lending, insurance and investment firms', 'finance' ),
	array( 'Content & Publishers', 'News sites, magazines, blogs and newsletters', 'publishers' ),
);
$pill = function ( $p, $label ) {
	return vv_f( "$p Status", array( 'gen-pill' ), array(
		vv_p( "$p Status Dot", '●', array( 'status-dot' ), 'span' ),
		vv_p( "$p Status Label", $label, array( 'status-label' ), 'span' ),
	) );
};

/* One card per tool, linking to its hub. The industry counts come from the lists above. */
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
/* UTM builders: the basic builder (hub) and one per industry (wordpress/tools/utm-builder). */
$utm_hub = vv_url( '/ai-tools/utm-builder/' );
$utm_industries = array(
	array( 'Healthcare', 'Service line and objective for hospitals and clinics', 'healthcare' ),
	array( 'Ecommerce', 'Campaign type and category for online stores', 'ecommerce' ),
	array( 'Real estate', 'Project and objective for property launches', 'real-estate' ),
	array( 'Travel & tourism', 'Destination and product for hotels and travel', 'travel-tourism' ),
	array( 'B2B', 'Product, campaign type and funnel stage for B2B and SaaS', 'b2b' ),
);
$utm_featured = vv_link( 'UTM Tool', array( 'gen-card' ), $utm_hub, array(
	vv_f( 'UTM Tool Top', array( 'gen-top' ), array(
		$pill( 'UTM Tool', 'Live' ),
		vv_p( 'UTM Tool Count', ( count( $utm_industries ) + 1 ) . ' builders', array( 't-mono' ), 'span' ),
	) ),
	vv_f( 'UTM Tool Body', array( 'gen-body' ), array(
		vv_p( 'UTM Tool Category', 'Measurement', array( 'eyebrow-accent' ), 'span' ),
		vv_h( 'UTM Tool Name', 'UTM Builder', array( 'tcard-name' ), 'h3' ),
		vv_p( 'UTM Tool Use', 'Build clean UTM links and see which GA4 channel each one will report under before you publish. Catches naming mistakes, adds Google Ads, Meta and TikTok macros, and makes a QR code. Industry builders come with a ready-made campaign naming convention.', array( 'tcard-use' ) ),
	) ),
	vv_p( 'UTM Tool Action', 'Open the UTM builder →', array( 'gen-cta' ), 'span' ),
) );
$nodes = array(
	vv_hero( 'Tools',
		array( vv_meta_block( 'Tools', 'Built for', 'Fellow marketers' ), vv_meta_block( 'Tools', 'Tools', '2 live' ), vv_meta_block( 'Tools', 'Price', 'Free to use', true ) ),
		'AI Tools', 'for marketers.', false,
		'Small, focused tools I build for marketers: llms.txt generators that help AI assistants describe your business accurately, and UTM builders that keep campaign tracking clean in GA4. Free, and everything runs in your browser.',
		array(
			vv_btn( 'Tools Generator Button', 'Open the llms.txt generator', $hub, array( 'btn', 'btn-filled' ) ),
			vv_btn( 'Tools UTM Button', 'Open the UTM builder', $utm_hub, array( 'btn' ) ),
		)
	),
	vv_f( 'Directory', array( 'section', 'pt-24', 'bg-canvas' ), array(
		vv_f( 'Directory Inner', array( 'wrap' ), array(
			vv_sec_head( 'Directory', '01', 'Live tools', 'Free · runs in your browser · nothing uploaded' ),
			vv_g( 'Directory Tools', array( 'gen-grid', 'mt-64' ), array( $featured, $utm_featured ) ),
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
