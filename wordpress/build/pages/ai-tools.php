<?php
/** AI Tools (/ai-tools/) — rebuilt from ai-tools.html. The category chips are native v4 tabs. */
$id = vv_new( 'AI Tools', 'ai-tools' );

$tone = array( 'mono' => 117, 'blue' => 115, 'warm' => 116, 'deep' => 118, 'sand' => 122, 'pearl' => 119, 'mint' => 121, 'rose' => 120 );
$status = array( 'live' => 'Live', 'beta' => 'Beta', 'soon' => 'Coming soon' );
$tools = array(
	array( 'SEO Brief Builder', 'SEO', 'live', 'mono', 'Paste a keyword, get a structured content brief — intent, outline, FAQs and schema suggestions.' ),
	array( 'AI Visibility Checker', 'SEO', 'beta', 'blue', 'See whether your brand is being cited in AI answers for your priority category questions.' ),
	array( 'Ad Copy Variator', 'Paid Media', 'live', 'warm', 'Generate on-brand headline and description variants for Google and Meta, within character limits.' ),
	array( 'ROAS Planner', 'Paid Media', 'live', 'deep', 'Work backwards from a revenue target to the budget, CPA and ROAS you actually need.' ),
	array( 'Persona Generator', 'Strategy', 'beta', 'sand', 'Turn survey or CRM exports into clear, usable customer personas and messaging angles.' ),
	array( 'Content Calendar AI', 'Content', 'soon', 'pearl', 'A month of topics mapped to search intent and funnel stage, ready to brief.' ),
	array( 'UTM & Naming Kit', 'Analytics', 'live', 'mint', 'Consistent UTMs and campaign naming so GA4 reporting stays clean across teams.' ),
	array( 'Report Summariser', 'Analytics', 'soon', 'rose', 'Drop in a GA4 or ads export, get a plain-language summary your leadership will read.' ),
);

$card = function ( $p, $t ) use ( $tone, $status ) {
	$dot = array( 'status-dot' ); if ( 'beta' === $t[2] ) { $dot[] = 'status-dot-beta'; } if ( 'soon' === $t[2] ) { $dot[] = 'status-dot-soon'; }
	return vv_f( "$p", array( 'tcard' ), array(
		vv_f( "$p Media", array( 'tcard-media' ), array(
			vv_img( "$p Screenshot", $tone[ $t[3] ], '', array( 'tcard-img' ) ),
			vv_f( "$p Status", array( 'tcard-status' ), array( vv_p( "$p Status Dot", '●', $dot, 'span' ), vv_p( "$p Status Label", $status[ $t[2] ], array( 'status-label' ), 'span' ) ) ),
		) ),
		vv_p( "$p Category", $t[1], array( 'eyebrow-accent' ), 'span' ),
		vv_h( "$p Name", htmlspecialchars( $t[0] ), array( 'tcard-name' ), 'h3' ),
		vv_p( "$p Use", $t[4], array( 'tcard-use' ) ),
		vv_p( "$p Action", 'soon' === $t[2] ? 'In development →' : 'Try the tool →', 'soon' === $t[2] ? array( 'tcard-cta', 'tcard-cta-soon' ) : array( 'tcard-cta' ), 'span' ),
	) );
};

$panels = array();
foreach ( array( 'All', 'SEO', 'Paid Media', 'Content', 'Analytics', 'Strategy' ) as $cat ) {
	$cards = array();
	foreach ( $tools as $t ) {
		if ( 'All' === $cat || $t[1] === $cat ) { $cards[] = $card( "$cat · " . $t[0], $t ); }
	}
	$panels[ $cat ] = $cards;
}
$live = count( array_filter( $tools, function ( $t ) { return 'live' === $t[2]; } ) );

$nodes = array(
	vv_hero( 'Tools',
		array( vv_meta_block( 'Tools', 'Built for', 'Fellow marketers' ), vv_meta_block( 'Tools', 'Tools', count( $tools ) . ' built · ' . $live . ' live' ), vv_meta_block( 'Tools', 'Price', 'Free to use', true ) ),
		'AI Tools', 'for marketers.', false,
		'Small, focused tools I’ve built with AI to take the repetitive work out of marketing — briefs, copy, planning and reporting. Free to use.'
	),
	vv_f( 'Directory', array( 'section', 'pt-24', 'bg-canvas' ), array(
		vv_f( 'Directory Inner', array( 'wrap' ), array(
			vv_tabs( 'Directory', $panels, function ( $i, $children ) { return vv_g( "Directory Grid $i", array( 'tgrid' ), $children ); } ),
		) ),
	), array( 'tag' => 'section' ) ),
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
						vv_btn_dark( 'Ideas Subscribe Button', 'Get new tools', vv_url( '/blog/#subscribe' ) ),
					) ),
				), array(), vv_ix( 'scrollIn', 'slide', 120 ) ),
			) ),
		) ),
	), array( 'tag' => 'section' ) ),
);

return array( 'id' => $id, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
