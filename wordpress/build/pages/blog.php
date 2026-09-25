<?php
/**
 * Blog (/blog/) and its eight essays — rebuilt from blog.html.
 * Essays are real WordPress posts (with categories, dates, excerpts and a
 * featured image) built with Elementor; the index filter uses native v4 tabs.
 */
$tone = array( 'deep' => 118, 'blue' => 115, 'warm' => 116, 'mono' => 117, 'mint' => 121, 'sand' => 122, 'rose' => 120, 'pearl' => 119 );
$posts = array(
	array( 'slug' => 'schema-is-the-new-resume', 'y' => 'May ’26', 'date' => 'May 14, 2026', 'iso' => '2026-05-14 09:00:00', 'cat' => 'AI in Marketing',
		't' => 'Schema is the new resume — how to brief your brand to an AI.',
		'dek' => 'When the answer comes before the click, the question is no longer how to rank. It is how to be cited. A working framework, written from twelve recent audits.',
		'min' => 9, 'tone' => 'deep', 'body' => array(
			array( 'p', 'For two decades, SEO has been a contest about clicks. Show up on the page, win the visit. The model is so familiar that most marketing teams still build their content programmes around it. The problem is that the contest is quietly being replaced.' ),
			array( 'p', 'When a patient asks an LLM about a knee replacement in the GCC, the model answers without ever sending the patient to a website. The brand that gets named in the answer wins. The brand whose schema, source authority and editorial discipline taught the model who they are wins. Everyone else, no matter how many backlinks they have, becomes invisible.' ),
			array( 'p', 'I have spent the last eighteen months auditing this shift across twelve brands in healthcare, finance, and luxury. The patterns are unmistakable, and they are uncomfortable for most CMOs.' ),
			array( 'h3', 'The three layers AI looks at' ),
			array( 'p', 'Every audit I run now starts from the same three-layer model: <strong>structured data</strong>, <strong>source authority</strong>, and <strong>editorial fingerprint</strong>. The first is mostly engineering. The second is mostly PR. The third is mostly editorial. None of them are optional anymore.' ),
			array( 'quote', 'The job is no longer to get the user to your site. The job is to get the model to your sentence.', 'From an internal audit, March 2026' ),
			array( 'p', 'Most teams over-invest in the first layer because it feels concrete. They schema-mark everything that moves. But schema without editorial fingerprint is a beautiful resume for someone with no story. The model knows the structure; it has no reason to cite you.' ),
			array( 'img', 'mono', 'Figure 01 — The three-layer model of AI-era discoverability.' ),
			array( 'h3', 'Editorial fingerprint, defined' ),
			array( 'p', 'Editorial fingerprint is the set of distinctive linguistic patterns, source citations, and consistent points-of-view that make a brand identifiable to a language model independent of its formatting. It is the thing that makes a 200-word answer about lipid management <em>sound</em> like the Cleveland Clinic and not like a content farm.' ),
			array( 'p', 'Three tests I now run on every editorial system:' ),
			array( 'ul', array( 'Could a stranger identify the brand from an unbranded paragraph?', 'Are sources cited inline, with link rot accounted for, in every long-form piece?', 'Does the brand have a documented point of view on the top twenty category questions — or does it hedge?' ) ),
			array( 'h3', 'What to do on Monday' ),
			array( 'p', 'Three weeks of work — fixed scope, modest budget, and the bones of an AI-era content programme are in place. Audit the schema. Codify the editorial system. Pick ten priority topics, write the brand’s point of view on each, publish them with clean structured data and inline citations, and watch what the models do for sixty days.' ),
			array( 'p', 'The patient already asked. The answer was already written. The only remaining question is whether your brand was in it.' ),
		) ),
	array( 'slug' => 'mmm-you-can-run-on-monday', 'y' => 'May ’26', 'date' => 'May 6, 2026', 'iso' => '2026-05-06 09:00:00', 'cat' => 'Measurement',
		't' => 'The MMM you can actually run on Monday.',
		'dek' => 'A practical recipe for a marketing mix model that does not require a data team.',
		'min' => 7, 'tone' => 'blue', 'body' => array(
			array( 'p', 'Marketing mix models used to be an enterprise project. Eighteen-month engagement, six-figure budget, three consultants in a room. The output was usually a slide nobody trusted.' ),
			array( 'p', 'That world is over. With modern tooling, a small in-house team can stand up a working MMM in three to four weeks. Here is the exact sequence I have used twice in the last year.' ),
			array( 'h3', 'Week one — clean the inputs' ),
			array( 'p', 'Every model is downstream of its data. Most MMMs fail not at the modelling step but at the data step. Spend the first week getting paid media, organic, email, and offline spend into a single weekly cadence with a consistent currency and a stable definition of revenue.' ),
			array( 'quote', 'A good MMM is mostly bookkeeping with a regression on top.', '— Engagement notes, 2025' ),
			array( 'h3', 'Week two — the model' ),
			array( 'p', 'I use Robyn or Meridian, depending on the team’s appetite for Python versus a hosted UI. Both will give you a working model with reasonable adstocks and saturation curves out of the box. The point of week two is not to optimise the model; it is to <strong>see</strong> the model.' ),
			array( 'h3', 'Week three — calibrate' ),
			array( 'p', 'Every model has prior beliefs about what is roughly true. Use a small geo-holdout test to calibrate the most contested channel — usually display or programmatic — and feed the result back as a prior. This is the step that separates an MMM from a horoscope.' ),
			array( 'p', 'Week four is presentation: a one-page executive view, a two-page channel view, a reproducible notebook. Then keep running it monthly. The model will get smarter the longer you live with it.' ),
		) ),
	array( 'slug' => 'ai-search-readiness', 'y' => 'Apr ’26', 'date' => 'April 22, 2026', 'iso' => '2026-04-22 09:00:00', 'cat' => 'SEO',
		't' => 'AI search readiness, in plain language.',
		'dek' => 'What "AI overviews" mean for content strategy — and the three changes most brands are still avoiding.',
		'min' => 8, 'tone' => 'warm', 'body' => array(
			array( 'p', 'Every CMO I speak to has heard about AI search. Most can’t tell me what their team is actually doing about it. In the gap between understanding and action lives the next two years of organic performance.' ),
			array( 'p', 'Here is the plainest version I can give of what is happening, what to do, and what to ignore.' ),
			array( 'h3', 'What is actually changing' ),
			array( 'p', 'Classic SERPs are not going away. They will continue to serve navigational queries (brand searches, specific product pages) for a long time. What is being eaten is the <em>informational</em> long tail — the questions people ask the engine and then click a result to read. That is now answered in-place.' ),
			array( 'h3', 'The three changes' ),
			array( 'ul', array( '<strong>Schema as a first-class citizen.</strong> Not an afterthought added by the SEO team. Engineered, audited, kept current.', '<strong>Author and source authority.</strong> Real bylines, real credentials, real citation discipline. The thin-content era is over for serious categories.', '<strong>Editorial point of view.</strong> Models reward brands that take a position. They penalise hedging the way readers always have.' ) ),
			array( 'p', 'None of these are technically difficult. All of them require an editorial culture most marketing teams have never built.' ),
		) ),
	array( 'slug' => 'stop-optimising-the-wrong-thing', 'y' => 'Apr ’26', 'date' => 'April 9, 2026', 'iso' => '2026-04-09 09:00:00', 'cat' => 'Paid Media',
		't' => 'Stop optimising the wrong thing.',
		'dek' => 'A short essay on the difference between click-through rate and incremental revenue, and why most teams still chase the first.',
		'min' => 5, 'tone' => 'mono', 'body' => array(
			array( 'p', 'There is a quiet little secret in paid media: click-through rate is mostly a proxy for whether your creative is misleading.' ),
			array( 'p', 'High CTR can mean the ad is great. It can also mean the ad is making a promise the landing page cannot keep. The way to tell which is which is to measure <strong>incremental</strong> revenue against a holdout — and most teams do not.' ),
			array( 'h3', 'Why this persists' ),
			array( 'p', 'CTR is daily. Incrementality is quarterly. Daily metrics get optimised because daily metrics are what humans see. The only fix is to put incrementality on the same dashboard, even if the number lags. It changes what the team chases.' ),
		) ),
	array( 'slug' => 'quarterly-cadence', 'y' => 'Mar ’26', 'date' => 'March 28, 2026', 'iso' => '2026-03-28 09:00:00', 'cat' => 'Strategy',
		't' => 'The quarterly cadence that fixed our forecast.',
		'dek' => 'An operating system for marketing leaders who keep getting blindsided by the board pack.',
		'min' => 6, 'tone' => 'mint', 'body' => array(
			array( 'p', 'Most marketing forecasts miss not because the model is wrong, but because the cadence is wrong. The team replans monthly, the board reads quarterly, and the gap between them is where the surprises live.' ),
			array( 'p', 'A six-week rolling plan with a quarterly anchor has solved this for me twice. Here is the structure.' ),
		) ),
	array( 'slug' => 'holdouts-not-optional', 'y' => 'Mar ’26', 'date' => 'March 14, 2026', 'iso' => '2026-03-14 09:00:00', 'cat' => 'Measurement',
		't' => 'Holdouts are not optional.',
		'dek' => 'A defence of the geo-holdout test, written for the marketing leader being told it is too expensive to run.',
		'min' => 7, 'tone' => 'sand', 'body' => array(
			array( 'p', 'Every quarter, a CMO somewhere is told that holdout testing is too expensive. The argument is always the same: switching off a channel for a few weeks in a few markets costs revenue. The argument is correct.' ),
			array( 'p', 'It is also irrelevant. Without holdouts, every penny you spend is justified by attribution models that nobody fully believes.' ),
		) ),
	array( 'slug' => 'three-creative-workflows', 'y' => 'Feb ’26', 'date' => 'February 26, 2026', 'iso' => '2026-02-26 09:00:00', 'cat' => 'AI in Marketing',
		't' => 'Three creative workflows that actually shipped.',
		'dek' => 'A look inside how three brands integrated generative tools without losing the brand voice.',
		'min' => 10, 'tone' => 'rose', 'body' => array(
			array( 'p', 'Generative tools are everywhere in marketing slide decks and almost nowhere in marketing production. The brands that have actually shipped have one thing in common: a clear visual language before the tools arrived.' ),
		) ),
	array( 'slug' => 'technical-debt-nobody-audits', 'y' => 'Feb ’26', 'date' => 'February 11, 2026', 'iso' => '2026-02-11 09:00:00', 'cat' => 'SEO',
		't' => 'The technical debt nobody is auditing.',
		'dek' => 'Rendering, indexation, and the parts of SEO that quietly compound against you.',
		'min' => 8, 'tone' => 'pearl', 'body' => array(
			array( 'p', 'Brands love a content audit. They will spend a quarter on it. Almost nobody runs a rendering audit, which is where most of the actual SEO debt lives.' ),
		) ),
);
$categories = array( 'AI in Marketing', 'SEO', 'Paid Media', 'Strategy', 'Measurement' );
$cat_ids = array();
foreach ( $categories as $c ) {
	$term = term_exists( $c, 'category' );
	if ( ! $term ) { $term = wp_insert_term( $c, 'category' ); }
	$cat_ids[ $c ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}

/* Create (or reuse) the posts first so every card can link to them. */
foreach ( $posts as $k => $p ) {
	$pid = vv_new( wp_strip_all_tags( $p['t'] ), $p['slug'], 0, 'post', array(
		'post_date' => $p['iso'], 'post_date_gmt' => get_gmt_from_date( $p['iso'] ), 'edit_date' => true,
		'post_excerpt' => $p['dek'], 'post_category' => array( $cat_ids[ $p['cat'] ] ),
	) );
	set_post_thumbnail( $pid, $tone[ $p['tone'] ] );
	$posts[ $k ]['id'] = $pid;
	$posts[ $k ]['url'] = vv_url( '/' . $p['slug'] . '/' );
}

$e = function ( $s ) { return htmlspecialchars( $s, ENT_NOQUOTES ); };
$feed_card = function ( $l, $p ) use ( $tone, $e ) {
	return vv_link( $l, array( 'feed-card' ), $p['url'], array(
		vv_img( "$l Banner", $tone[ $p['tone'] ], '', array( 'feed-img' ) ),
		vv_f( "$l Body", array( 'feed-body' ), array(
			vv_f( "$l Meta", array( 'feed-meta' ), array(
				vv_p( "$l Category", $e( $p['cat'] ), array( 'feed-meta-text', 'text-accent' ), 'span' ),
				vv_p( "$l Dot 1", '•', array( 'feed-meta-text' ), 'span' ),
				vv_p( "$l Month", $p['y'], array( 'feed-meta-text' ), 'span' ),
				vv_p( "$l Dot 2", '•', array( 'feed-meta-text' ), 'span' ),
				vv_p( "$l Minutes", $p['min'] . ' min', array( 'feed-meta-text' ), 'span' ),
			) ),
			vv_h( "$l Title", $e( $p['t'] ), array( 'feed-title' ), 'h3' ),
			vv_p( "$l Dek", $e( $p['dek'] ), array( 'feed-dek' ) ),
		) ),
	) );
};

/* ---------- Blog index ---------- */
$blog_id = vv_new( 'Blog', 'blog' );
$panels = array();
foreach ( array_merge( array( 'All' ), $categories ) as $cat ) {
	$cards = array();
	foreach ( $posts as $p ) {
		if ( 'All' === $cat || $p['cat'] === $cat ) { $cards[] = $feed_card( "$cat · " . $p['slug'], $p ); }
	}
	$panels[ $e( $cat ) ] = array( 'name' => 'All' === $cat ? 'All essays' : $e( $cat ), 'cards' => $cards );
}
$out = array();
$out['blog'] = array( 'id' => $blog_id, 'result' => vv_build( $blog_id, array(
	vv_hero( 'Blog',
		array( vv_meta_block( 'Blog', 'Field notes', 'Working theory, written down' ), vv_meta_block( 'Blog', 'Cadence', '~ one essay a fortnight' ), vv_meta_block( 'Blog', 'Topics', 'AI, SEO, paid, measurement, strategy' ) ),
		'Working<br>theory,', 'written down.', false,
		'Short essays on AI in marketing, search, paid media, and the operating systems behind growing teams.'
	),
	vv_f( 'Essays', array( 'section-sm', 'pt-24', 'bg-canvas' ), array(
		vv_f( 'Essays Inner', array( 'wrap' ), array(
			vv_tabs( 'Essays', array_map( function ( $x ) { return $x; }, $panels ), function ( $i, $panel ) {
				$n = count( $panel['cards'] );
				return vv_f( "Essays Feed Panel $i", array( 'stack' ), array(
					vv_f( "Essays Feed Head $i", array( 'sec-head', 'feed-head' ), array(
						vv_f( "Essays Feed Head $i Left", array( 'sec-head-l' ), array(
							vv_p( "Essays Feed Head $i Index", $panel['name'], array( 'sec-idx' ), 'span' ),
							vv_p( "Essays Feed Head $i Label", $n . ' published', array( 'sec-label' ), 'span' ),
						) ),
						vv_p( "Essays Feed Head $i Note", 'Most recent first', array( 'sec-note' ) ),
					) ),
					vv_f( "Essays Feed $i", array( 'feed' ), $panel['cards'] ),
				) );
			} ),
		) ),
	), array( 'tag' => 'section' ) ),
	vv_subscribe( 'Blog' ),
), 'document', 'replace_children' ) );

/* ---------- Essays ---------- */
$n = count( $posts );
foreach ( $posts as $k => $p ) {
	$body = array(); $i = 0;
	foreach ( $p['body'] as $b ) {
		$i++;
		switch ( $b[0] ) {
			case 'p':  $body[] = vv_p( "Body $i Paragraph", $b[1], array( 'art-p' ) ); break;
			case 'h3': $body[] = vv_h( "Body $i Heading", $e( $b[1] ), array( 'art-h3' ), 'h3' ); break;
			case 'ul':
				$li = array(); $j = 0;
				foreach ( $b[1] as $item ) {
					$j++;
					$li[] = vv_f( "Body $i Point $j", array( 'bullet' ), array( vv_p( "Body $i Point $j Mark", '•', array( 'bullet-mark', 'art-mark' ), 'span' ), vv_p( "Body $i Point $j Text", $item, array( 'art-p' ) ) ) );
				}
				$body[] = vv_f( "Body $i List", array( 'bullet-list' ), $li );
				break;
			case 'quote':
				$body[] = vv_f( "Body $i Quote", array( 'art-quote' ), array( vv_p( "Body $i Quote Text", $e( $b[1] ), array( 'art-quote-text' ) ), vv_p( "Body $i Quote Cite", $e( $b[2] ), array( 'art-cite' ) ) ) );
				break;
			case 'img':
				$body[] = vv_f( "Body $i Figure", array( 'art-figure' ), array(
					vv_img( "Body $i Figure Image", $tone[ $b[1] ], '', array( 'tile-img', 'art-figure-img' ) ),
					vv_f( "Body $i Caption Row", array( 'caption-row' ), array( vv_p( "Body $i Caption", $e( $b[2] ), array( 'art-cite' ) ) ) ),
				) );
				break;
		}
	}
	$tags = array(); $j = 0;
	foreach ( array( $e( $p['cat'] ), 'Field note', $p['min'] . ' min' ) as $t ) {
		$j++;
		$tags[] = vv_f( "Tag $j", array( 'itag' ), array( vv_p( "Tag $j Dot", '●', array( 'itag-dot' ), 'span' ), vv_p( "Tag $j Label", $t, array( 'itag-label' ), 'span' ) ) );
	}
	/* Sidebar suggestions: the four most recent other essays. */
	$others = array_slice( array_values( array_filter( $posts, function ( $o ) use ( $p ) { return $o['slug'] !== $p['slug']; } ) ), 0, 4 );
	$suggest = array(); $j = 0;
	foreach ( $others as $o ) {
		$j++;
		$suggest[] = vv_link( "Suggestion $j", array( 'aside-item' ), $o['url'], array(
			vv_p( "Suggestion $j Category", $e( $o['cat'] ), array( 'feed-meta-text', 'text-accent' ), 'span' ),
			vv_h( "Suggestion $j Title", $e( $o['t'] ), array( 'aside-title' ), 'h3' ),
			vv_p( "Suggestion $j Meta", $o['y'] . ' · ' . $o['min'] . ' min', array( 'feed-meta-text' ), 'span' ),
		) );
	}
	$meta_cell = function ( $l, $label, $value_nodes ) { return vv_f( $l, array( 'meta-cell' ), array_merge( array( vv_p( "$l Label", $label, array( 'meta-k' ) ) ), $value_nodes ) ); };
	$nodes = array(
		vv_f( 'Article Hero', array( 'art-hero', 'art-end', 'bg-canvas' ), array( vv_f( 'Article Hero Inner', array( 'wrap' ), array(
			vv_p( 'Back To Writing', '← All writing', array( 'back-link' ), 'p', vv_url( '/blog/' ) ),
			vv_f( 'Article Eyebrow', array( 'art-eyebrow' ), array(
				vv_p( 'Eyebrow Category', $e( $p['cat'] ), array( 'feed-meta-text', 'text-accent' ), 'span' ),
				vv_p( 'Eyebrow Separator 1', '—', array( 'eyebrow-sep' ), 'span' ),
				vv_p( 'Eyebrow Date', $p['date'], array( 'feed-meta-text' ), 'span' ),
				vv_p( 'Eyebrow Separator 2', '—', array( 'eyebrow-sep' ), 'span' ),
				vv_p( 'Eyebrow Reading Time', $p['min'] . ' min read', array( 'feed-meta-text' ), 'span' ),
			), array(), vv_ix( 'load', 'fade' ) ),
			vv_n( 'e-heading', 'Article Title', array( 'art-title' ), array( 'tag' => 'h1', 'title' => $e( $p['t'] ) ), array(), vv_ix( 'load', 'slide', 100 ) ),
			vv_g( 'Article Meta', array( 'art-meta' ), array(
				$meta_cell( 'Meta Author', 'Author', array( vv_f( 'Meta Author Value', array( 'author-inline' ), array( vv_img( 'Meta Author Photo', 8, 'Vineet Vijay', array( 'avatar-sm' ) ), vv_p( 'Meta Author Name', 'Vineet Vijay', array( 'art-meta-v' ), 'span' ) ) ) ) ),
				$meta_cell( 'Meta Published', 'Published', array( vv_p( 'Meta Published Value', $p['date'], array( 'art-meta-v' ) ) ) ),
				$meta_cell( 'Meta Reading', 'Reading time', array( vv_p( 'Meta Reading Value', $p['min'] . ' min', array( 'art-meta-v' ) ) ) ),
				$meta_cell( 'Meta Topic', 'Topic', array( vv_p( 'Meta Topic Value', $e( $p['cat'] ), array( 'art-meta-v' ) ) ) ),
			) ),
			/* Two-part layout from the banner down: article (~82%) + sidebar (~15%); stacks on tablet/mobile. */
			vv_f( 'Article Layout', array( 'art-layout' ), array(
				vv_f( 'Article Main', array( 'art-main' ), array(
					vv_img( 'Article Banner', $tone[ $p['tone'] ], '', array( 'tile-img', 'art-banner' ) ),
					vv_f( 'Article Text', array( 'art-body', 'art-body-flush' ), $body, array( 'tag' => 'article' ) ),
					vv_f( 'Article Footer', array( 'art-footer', 'art-footer-flush' ), array(
						vv_f( 'Article Tags', array( 'art-tags' ), $tags ),
						vv_g( 'Author Card', array( 'author-card' ), array(
							vv_img( 'Author Card Photo', 8, 'Vineet Vijay', array( 'avatar-lg' ) ),
							vv_f( 'Author Card Text', array( 'stack' ), array(
								vv_p( 'Author Card Name', 'Vineet Vijay', array( 'author-name' ) ),
								vv_p( 'Author Card Role', 'Digital Marketing Strategist · UAE', array( 'author-role' ) ),
								vv_p( 'Author Card Bio', 'Ten years across healthcare, e-commerce, FMCG, luxury and fintech. Currently at House of Comms. Previously at Reem Hospital, Wavemaker (WPP), and Interactive Avenues (IPG).', array( 'author-bio' ) ),
							) ),
						) ),
					) ),
				) ),
				vv_f( 'Article Sidebar', array( 'art-aside' ), array(
					vv_f( 'Sidebar Essays', array( 'stack' ), array(
						vv_p( 'Sidebar Essays Heading', 'More essays', array( 't-mono' ) ),
						vv_f( 'Sidebar Essays List', array( 'aside-list' ), $suggest ),
					) ),
					/* Ad space: an empty, named slot for the ad code (160×600 on desktop, 300×250 on tablet/mobile). */
					vv_f( 'Sidebar Ad', array( 'stack' ), array(
						vv_p( 'Sidebar Ad Label', 'Advertisement', array( 'meta-k' ) ),
						vv_f( 'Ad Slot', array( 'ad-slot' ) ),
					) ),
				), array( 'tag' => 'aside' ) ),
			) ),
		) ) ), array( 'tag' => 'section' ) ),
		vv_subscribe( 'Article' ),
	);
	$out[ $p['slug'] ] = array( 'id' => $p['id'], 'result' => vv_build( $p['id'], $nodes, 'document', 'replace_children' ) );
}
return $out;
