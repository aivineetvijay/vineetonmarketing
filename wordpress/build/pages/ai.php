<?php
/** AI in Marketing (/ai/) — rebuilt from ai.html. */
$id = vv_new( 'AI in Marketing', 'ai' );

$pillars = array(
	array( '01', 'Research.', 'From customer interview transcripts to category audits, the research pile is now a queryable asset, not a deck nobody opens.' ),
	array( '02', 'Search.', 'When the answer comes before the click, content needs to be quotable. Schema, source authority, and editorial discipline matter more than ever.' ),
	array( '03', 'Creative.', 'Generative tools are not a designer replacement. They are a velocity multiplier for the brands with the clearest visual language.' ),
	array( '04', 'Decisioning.', 'The platforms are already AI. The advantage now lives upstream: clean signal, clear incrementality, and a structure that lets the model learn.' ),
	array( '05', 'Measurement.', 'MMM and causal inference are no longer enterprise-only. The smallest D2C team can now know what actually drove the lift.' ),
	array( '06', 'Workflow.', 'Briefs, QA, asset routing, reporting — the meta-work around campaigns is the next thing to compress.' ),
);
$truths = array(
	array( '01', 'The platforms are AI now.', 'Bidding, audience expansion, creative selection — already a black box. The job is shifting from operating the platforms to feeding them the right signal.' ),
	array( '02', 'Search is splitting in two.', 'Classic SERP for navigational queries. Generated answers for everything else. Both need a content strategy. Most brands have neither.' ),
	array( '03', 'Content velocity is a strategic lever.', 'For the first time, the bottleneck on category coverage is editorial discipline, not headcount. Used carelessly, it becomes noise.' ),
	array( '04', 'Attribution is finally honest.', 'Modern incrementality + MMM frameworks can be stood up in weeks, not quarters. Hiding behind last-click is now a choice.' ),
	array( '05', 'Brand still wins long term.', 'Distinctiveness, memory structures, sonic and visual codes — none of this is automatable. Performance compounds on brand, or it doesn’t compound at all.' ),
);
$steps = array(
	array( '01', 'Map what you have.', 'Audit current stack, signal quality, data hygiene, and the people. Identify the three workflows worth re-architecting first.' ),
	array( '02', 'Design the operating system.', 'Tool selection, workflow maps, role redesigns, KPI structure. A working architecture, not a recommendation slide.' ),
	array( '03', 'Ship one workflow.', 'A single end-to-end pilot the team can run on Monday. Measurable, governance-clean, reversible.' ),
);

$items = array();
foreach ( $truths as $i => $t ) {
	$n = $i + 1;
	$items[] = vv_acc_item( "Truth $n", array( 'acc-item', 'on-dark-lines' ), array( 'acc-head', 'truth-head' ),
		$t[0] . ' — Truth', array( 'acc-num', 'truth-num' ), $t[1], array( 'acc-title', 'truth-title' ),
		array( 'acc-icon', 'on-dark' ), array( 'acc-body', 'truth-body' ),
		array( vv_p( "Truth $n Text", $t[2], array( 'truth-answer' ) ) ) );
}

$nodes = array(
	vv_hero( 'AI',
		array( vv_meta_block( 'AI', 'Section', 'A point of view' ), vv_meta_block( 'AI', 'Length', '~ 12 minutes' ), vv_meta_block( 'AI', 'Updated', 'May 2026' ) ),
		'AI in<br>Marketing', '.', true,
		'Every layer of the marketing stack — research, creative, distribution, measurement — is being rewritten. The opportunity is not to add an AI tool. It is to redesign the workflow.',
		array(
			vv_btn( 'AI Pillars Button', 'Read the pillars', vv_url( '/ai/#pillars' ), array( 'btn' ) ),
			vv_btn( 'AI Writing Button', 'Explore the writing', vv_url( '/blog/' ), array( 'btn', 'btn-filled' ) ),
		)
	),
	vv_f( 'Feature', array( 'section-sm', 'bg-canvas' ), array(
		vv_f( 'Feature Inner', array( 'wrap' ), array(
			vv_n( 'e-image', 'Feature Image', array( 'tile-img' ), array( 'image' => array( 'src' => array( 'id' => 116, 'alt' => '' ), 'size' => 'full' ) ), array(), vv_ix( 'scrollIn', 'fade' ) ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'Pillars', array( 'section', 'bg-canvas' ), array(
		vv_f( 'Pillars Inner', array( 'wrap' ), array(
			vv_sec_head( 'Pillars', '01', 'Six pillars', 'Where AI changes marketing — and where it doesn’t' ),
			vv_title_block( 'Pillars', 'Where AI', 'changes marketing.' ),
			vv_cards( 'Pillars', $pillars, array( 'topics-grid', 'mt-96' ) ),
		) ),
	), array( 'tag' => 'section' ), null, 'pillars' ),
	vv_f( 'Quote', array( 'section', 'bg-parchment' ), array(
		vv_f( 'Quote Inner', array( 'wrap-text' ), array(
			vv_f( 'Quote Block', array( 'pull-quote' ), array(
				vv_p( 'Quote Text', '“The platforms are already AI. The advantage now lives upstream — in the signal, the structure, and the discipline of the team feeding them.”', array( 'pull-quote-text' ) ),
				vv_p( 'Quote Cite', '— from <em>Schema is the new resume</em>, May 2026', array( 'pull-cite' ) ),
			), array(), vv_ix() ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'Truths', array( 'section', 'bg-ink' ), array(
		vv_f( 'Truths Inner', array( 'wrap' ), array(
			vv_sec_head( 'Truths', '02', 'Five truths', 'The patterns that keep showing up', true ),
			vv_title_block( 'Truths', 'The honest', 'read.', true ),
			vv_f( 'Truths Holder', array( 'stack', 'mt-96' ), array(
				vv_n( 'e-accordion', 'Truths Accordion', array( 'acc', 'on-dark-lines' ), array( 'default_state' => 'first_expanded', 'max_expanded' => 'one', 'show_icon' => true ), $items ),
			), array(), vv_ix() ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'Proof', array( 'section', 'bg-canvas' ), array(
		vv_f( 'Proof Inner', array( 'wrap' ), array(
			vv_sec_head( 'Proof', '03', 'In practice', 'Measured, not theoretical' ),
			vv_stats( 'Proof', array(
				array( '38', '%', 'Average production cost reduction on always-on creative.' ),
				array( '4.2', '×', 'Faster brief-to-asset turnaround on tested workflows.' ),
				array( '180', '%', 'Organic traffic growth using AI-assisted content systems.' ),
				array( '0', '', 'Client data trained into a third-party model without consent.' ),
			) ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_f( 'Framework', array( 'section', 'bg-parchment' ), array(
		vv_f( 'Framework Inner', array( 'wrap' ), array(
			vv_sec_head( 'Framework', '04', 'How the framework runs', 'Three weeks · three artefacts' ),
			vv_title_block( 'Framework', 'Three weeks.', 'Three artefacts.' ),
			vv_cards( 'Framework', $steps, array( 'grid-3-stack', 'mt-96' ), false, 'Week ' ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_cta_dark( 'AI', 'More', 'on this thread.', array(
		vv_btn_dark( 'AI CTA Experience Button', 'Experience', vv_url( '/experience/' ) ),
		vv_btn_dark( 'AI CTA Writing Button', 'Read the writing', vv_url( '/blog/' ), true ),
	) ),
);

return array( 'id' => $id, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
