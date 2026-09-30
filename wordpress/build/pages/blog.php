<?php
/**
 * Blog (/blog/) and its eight essays — rebuilt from blog.html.
 * Essays are real WordPress posts (with categories, dates, excerpts and a
 * featured image) built with Elementor; the index filter uses native v4 tabs.
 */
$tone = array( 'deep' => 118, 'blue' => 115, 'warm' => 116, 'mono' => 117, 'mint' => 121, 'sand' => 122, 'rose' => 120, 'pearl' => 119 );
$posts = array(
	array( 'slug' => 'schema-markup-for-real-estate', 'y' => 'Sep ’26', 'date' => 'September 30, 2026', 'iso' => '2026-09-30 10:00:00', 'cat' => 'AI in Marketing', 'tags' => array( 'AI in Marketing', 'SEO' ),
		't' => 'Seven schemas every property site needs.',
		'dek' => 'Buyers increasingly meet your project in an AI answer first. Here are the seven schemas that make sure those facts come from your own website, and the brief to get them built.',
		'min' => 10, 'tone' => 'warm', 'fmt' => 'Guide', 'body_src' => 'schema-markup-for-real-estate',
		/* Banners (made by wordpress/assets/essays/upload-image.php): 540 = 1600x534 desktop, 541 = 1586x992 mobile + featured. */
		'banner' => array( 540, 541 ), 'thumb' => 541,
		'banner_alt' => 'Schema markup for real estate illustrated: a modern villa listing mapped to Schema.org Residence JSON-LD (address, geo, numberOfRooms, amenityFeature) and shown as a rich property result in search',
		/* Screenshots (made by wordpress/assets/essays/upload-real-estate-shots.php): marker file => attachment id, caption. */
		'figures' => array(
			'emaar-the-oasis-community-page-breadcrumb.jpg' => array( 477, 'The Oasis by Emaar community page. The breadcrumb is visible to buyers but not marked up for machines. Screenshot taken 30 September 2026.' ),
		) ),
	array( 'slug' => 'schema-markup-ai-visibility', 'old_slug' => 'schema-is-the-new-resume', 'y' => 'Sep ’26', 'date' => 'September 30, 2026', 'iso' => '2026-09-30 07:00:00', 'cat' => 'AI in Marketing', 'tags' => array( 'AI in Marketing', 'SEO' ),
		't' => 'Schema is your website’s resume.',
		'dek' => 'Schema will not get you cited by ChatGPT or Google’s AI on its own. What it does is make sure the machines screening you read the right name, credentials and references.',
		'min' => 12, 'tone' => 'deep', 'fmt' => 'Framework',
		/* Banner art direction (attachment IDs made by wordpress/assets/essays/make-schema-banner.php):
		   452 = 1500x500 desktop, 453 = 1024x640 mobile, also the featured image (blog card + social). */
		'banner' => array( 452, 453 ), 'thumb' => 453,
		'banner_alt' => 'Schema markup illustrated: a resume mapped line by line to Schema.org Person JSON-LD (sameAs, alumniOf, worksFor, jobTitle, knowsAbout) and linked into a knowledge graph of entities',
		/* Long-form body lives in wordpress/content/essays/<slug>.json (made by html_to_blocks.py from the essay HTML). */
		'body_src' => 'schema-markup-ai-visibility' ),
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

/* Essays whose body comes from a JSON block file: the runner passes them in $vv_essay_bodies. */
foreach ( $posts as $k => $p ) {
	if ( isset( $p['body_src'] ) ) {
		if ( empty( $vv_essay_bodies[ $p['body_src'] ] ) ) { return array( 'error' => 'Missing essay body: ' . $p['body_src'] ); }
		$posts[ $k ]['body'] = $vv_essay_bodies[ $p['body_src'] ];
	}
}

/* Create (or reuse) the posts first so every card can link to them. */
foreach ( $posts as $k => $p ) {
	/* A renamed essay keeps its post (and WordPress redirects the old slug). */
	if ( ! empty( $p['old_slug'] ) && ! get_page_by_path( $p['slug'], OBJECT, 'post' ) ) {
		$old = get_page_by_path( $p['old_slug'], OBJECT, 'post' );
		if ( $old ) { wp_update_post( array( 'ID' => $old->ID, 'post_name' => $p['slug'] ) ); }
	}
	$pid = vv_new( wp_strip_all_tags( $p['t'] ), $p['slug'], 0, 'post', array(
		'post_date' => $p['iso'], 'post_date_gmt' => get_gmt_from_date( $p['iso'] ), 'edit_date' => true,
		'post_excerpt' => $p['dek'], 'post_category' => array( $cat_ids[ $p['cat'] ] ),
	) );
	/* Keep title, excerpt and date in step with this file (only touched when they differ). */
	$cur = get_post( $pid );
	$want = array( 'post_title' => wp_strip_all_tags( $p['t'] ), 'post_excerpt' => $p['dek'], 'post_date' => $p['iso'] );
	if ( $cur->post_title !== $want['post_title'] || $cur->post_excerpt !== $want['post_excerpt'] || $cur->post_date !== $want['post_date'] ) {
		wp_update_post( array_merge( array( 'ID' => $pid, 'post_date_gmt' => get_gmt_from_date( $p['iso'] ), 'edit_date' => true ), $want ) );
	}
	/* Category and tags follow this file on every run (vv_new only sets them when the post is created). */
	if ( wp_get_post_categories( $pid ) !== array( $cat_ids[ $p['cat'] ] ) ) { wp_set_post_categories( $pid, array( $cat_ids[ $p['cat'] ] ) ); }
	if ( isset( $p['tags'] ) ) { wp_set_post_tags( $pid, $p['tags'], false ); }
	set_post_thumbnail( $pid, $p['thumb'] ?? $tone[ $p['tone'] ] );
	$posts[ $k ]['id'] = $pid;
	$posts[ $k ]['url'] = vv_url( '/' . $p['slug'] . '/' );
}

$e = function ( $s ) { return htmlspecialchars( $s, ENT_NOQUOTES ); };
$feed_card = function ( $l, $p ) use ( $tone, $e ) {
	return vv_link( $l, array( 'feed-card' ), $p['url'], array(
		vv_img( "$l Banner", $p['thumb'] ?? $tone[ $p['tone'] ], '', array( 'feed-img' ) ),
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
/* Bulleted (•) or numbered (1.) list built from flex rows, so theme list styles never apply. */
$list = function ( $l, $type, $items, $text_c, $mark_c ) {
	$rows = array(); $j = 0;
	foreach ( $items as $item ) {
		$j++;
		$rows[] = vv_f( "$l Point $j", array( 'bullet' ), array( vv_p( "$l Point $j Mark", 'ol' === $type ? $j . '.' : '•', $mark_c, 'span' ), vv_p( "$l Point $j Text", $item, $text_c ) ) );
	}
	return vv_f( "$l List", array( 'bullet-list' ), $rows );
};
foreach ( $posts as $k => $p ) {
	$body = array(); $i = 0;
	/* Inline links: Elementor resets <a> inside text (all: unset) and strips classes/styles, so wrap
	   the link text in <u> to keep links visibly underlined. */
	array_walk_recursive( $p['body'], function ( &$v ) {
		if ( is_string( $v ) ) { $v = preg_replace( '#<a ([^>]*)>(?!<u>)(.*?)</a>#s', '<a $1><u>$2</u></a>', $v ); }
	} );
	/* FAQ sections (question h3s + answer paragraphs after the "faq" h2) render as the site's accordion. */
	$blocks = array(); $in_faq = false;
	foreach ( $p['body'] as $b ) {
		if ( 'h2' === $b[0] ) { $in_faq = ( 'faq' === $b[2] ); }
		elseif ( $in_faq && 'h3s' === $b[0] ) { if ( 'faq' !== end( $blocks )[0] ) { $blocks[] = array( 'faq', array() ); } $blocks[ count( $blocks ) - 1 ][1][] = array( $b[1], array() ); continue; }
		elseif ( $in_faq && 'p' === $b[0] && 'faq' === end( $blocks )[0] ) { $f = &$blocks[ count( $blocks ) - 1 ][1]; $f[ count( $f ) - 1 ][1][] = $b[1]; unset( $f ); continue; }
		else { $in_faq = $in_faq && 'faq' !== end( $blocks )[0]; }
		$blocks[] = $b;
	}
	foreach ( $blocks as $b ) {
		$i++;
		switch ( $b[0] ) {
			case 'p':  $body[] = vv_p( "Body $i Paragraph", $b[1], array( 'art-p' ) ); break;
			case 'h3': $body[] = vv_h( "Body $i Heading", $e( $b[1] ), array( 'art-h3' ), 'h3' ); break;
			case 'ul': $body[] = $list( "Body $i", 'ul', $b[1], array( 'art-p' ), array( 'bullet-mark', 'art-mark' ) ); break;
			case 'quote':
				$quote = array( vv_p( "Body $i Quote Text", $e( $b[1] ), array( 'art-quote-text' ) ) );
				if ( '' !== $b[2] ) { $quote[] = vv_p( "Body $i Quote Cite", $e( $b[2] ), array( 'art-cite' ) ); }
				$body[] = vv_f( "Body $i Quote", array( 'art-quote' ), $quote );
				break;
			/* Long-form blocks (see wordpress/content/essays/html_to_blocks.py). */
			case 'h2': $body[] = vv_n( 'e-heading', "Body $i Section Heading", array( 'art-h3' ), array( 'tag' => 'h2', 'title' => $b[1] ), array(), null, $b[2] ); break;
			case 'h3s': $body[] = vv_h( "Body $i Subheading", $b[1], array( 'art-sub' ), 'h3' ); break;
			case 'cite': $body[] = vv_p( "Body $i Caption", $b[1], array( 'art-cite' ) ); break;
			case 'ol': $body[] = $list( "Body $i", 'ol', $b[1], array( 'art-p' ), array( 'bullet-mark', 'art-mark' ) ); break;
			case 'box':
				$body[] = vv_f( "Body $i Summary", array( 'art-box' ), array( vv_p( "Body $i Summary Label", $b[1], array( 't-mono' ) ), $list( "Body $i Summary", $b[2], $b[3], array( 'art-p-sm' ), array( 'sm-mark' ) ) ) );
				break;
			case 'toc':
				$rows = array(); $j = 0;
				foreach ( $b[2] as $t ) {
					$j++;
					$rows[] = vv_f( "Body $i Contents $j", array( 'bullet' ), array( vv_p( "Body $i Contents $j Number", $j . '.', array( 'toc-mark' ), 'span' ), vv_p( "Body $i Contents $j Link", $t[0], array( 'art-toc-link' ), 'p', '#' . $t[1] ) ) );
				}
				$body[] = vv_f( "Body $i Contents", array( 'art-toc' ), array_merge( array( vv_p( "Body $i Contents Label", $b[1], array( 't-mono' ) ) ), $rows ), array( 'tag' => 'nav' ) );
				break;
			case 'code':
				$lines = array_map( function ( $line ) { return preg_replace_callback( '/^ +/', function ( $m ) { return str_repeat( '&nbsp;', strlen( $m[0] ) ); }, htmlspecialchars( $line, ENT_NOQUOTES ) ); }, $b[1] );
				$body[] = vv_p( "Body $i Code Sample", implode( '<br>', $lines ), array( 'art-code' ) );
				break;
			case 'table':
				$wide = count( $b[1] ) > 2; $rows = array(); $cols = array();
				foreach ( $b[1] as $c => $th ) { $cols[] = vv_p( "Body $i Table Head $c", $th, array( 'art-th' ) ); }
				$rows[] = vv_f( "Body $i Table Head", array( $wide ? 'art-thr-4' : 'art-thr' ), $cols );
				foreach ( $b[2] as $r => $tr ) {
					$cols = array();
					foreach ( $tr as $c => $td ) {
						/* Wide tables stack into labelled cards on mobile, so each cell carries its column label. */
						$cols[] = $wide
							? vv_f( "Body $i Row $r Cell $c", array( 'art-cell' ), array( vv_p( "Body $i Row $r Cell $c Label", $b[1][ $c ], array( 'art-td-label' ) ), vv_p( "Body $i Row $r Cell $c Text", $td, array( 'art-td' ) ) ) )
							: vv_p( "Body $i Row $r Cell $c", $td, array( 'art-td' ) );
					}
					$rows[] = vv_f( "Body $i Row $r", array( $wide ? 'art-tr-4' : 'art-tr' ), $cols );
				}
				$body[] = vv_f( "Body $i Table", array( 'art-table' ), $rows );
				break;
			case 'callout':
				$body[] = vv_f( "Body $i Framework", array( 'art-callout' ), array( vv_p( "Body $i Framework Label", $b[1], array( 't-mono' ) ), vv_p( "Body $i Framework Title", $b[2], array( 'art-callout-title' ) ), $list( "Body $i Framework", $b[3], $b[4], array( 'art-p-sm' ), array( 'sm-mark' ) ) ) );
				break;
			case 'note':
				$body[] = vv_f( "Body $i Actions", array( 'art-note' ), array( vv_p( "Body $i Actions Title", $b[1], array( 'art-callout-title' ) ), $list( "Body $i Actions", $b[2], $b[3], array( 'art-p-sm' ), array( 'sm-mark' ) ) ) );
				break;
			case 'cta':
				$body[] = vv_f( "Body $i Closing", array( 'art-cta' ), array_merge( array( vv_p( "Body $i Closing Question", $b[1], array( 'art-callout-title' ) ) ), '' !== $b[2] ? array( vv_p( "Body $i Closing Text", $b[2], array( 'art-p-sm' ) ) ) : array(), array( vv_p( "Body $i Closing Link", $b[3], array( 'art-cta-link' ), 'p', $b[4] ) ) ) );
				break;
			case 'faq':
				$items = array(); $j = 0;
				foreach ( $b[1] as $qa ) {
					$j++; $answers = array(); $k = 0;
					foreach ( $qa[1] as $para ) { $k++; $answers[] = vv_p( "Body $i Question $j Answer $k", $para, array( 'art-p-sm' ) ); }
					$items[] = vv_acc_item( "Body $i Question $j", array( 'acc-item' ), array( 'art-acc-head' ), sprintf( '%02d', $j ), array( 'acc-num' ), $qa[0], array( 'art-acc-title' ), array( 'acc-icon' ), array( 'acc-body' ), $answers );
				}
				/* FAQPage schema comes from the vv_faq post meta (vv-schema.php), so the widget's own FAQ schema stays off. */
				$body[] = vv_n( 'e-accordion', "Body $i FAQ Accordion", array( 'acc' ), array( 'default_state' => 'first_expanded', 'max_expanded' => 'one', 'show_icon' => true, 'faq_schema' => false ), $items );
				break;
			case 'figure':
				$fig = $p['figures'][ $b[1] ];
				$body[] = vv_f( "Body $i Screenshot", array( 'art-figure' ), array(
					vv_img( "Body $i Screenshot Image", $fig[0], '', ( wp_get_attachment_image_src( $fig[0], 'full' )[1] ?? 0 ) < 1100 ? array( 'art-shot', 'art-shot-sm' ) : array( 'art-shot' ) ),
					vv_p( "Body $i Screenshot Caption", $e( $fig[1] ), array( 'art-cite' ) ),
				) );
				break;
			case 'diagram':
				$cols = array(); $c = 0;
				foreach ( $b[3] as $col ) {
					$c++; $kids = array( vv_p( "Body $i Diagram Column $c Label", $col[0], array( 'dg-label' ) ) ); $k = 0;
					foreach ( $col[2] as $box ) {
						$k++;
						$indent = $col[1] ? array() : ( $k > 1 ? array( 'dg-indent-' . min( 3, $k - 1 ) ) : array() );
						if ( ! $col[1] && $k > 1 ) { $kids[] = vv_p( "Body $i Diagram Column $c Arrow $k", '↓', array_merge( array( 'dg-arrow' ), $indent ) ); }
						$kids[] = vv_f( "Body $i Diagram Column $c Box $k", array_merge( array( $col[1] ? 'dg-box-dashed' : 'dg-box' ), $indent ), array(
							vv_p( "Body $i Diagram Column $c Box $k Title", $box[0], array( 'dg-box-title' ) ),
							vv_p( "Body $i Diagram Column $c Box $k Text", $box[1], array( 'dg-box-sub' ) ),
						) );
					}
					$cols[] = vv_f( "Body $i Diagram Column $c", array( 'dg-col' ), $kids );
				}
				$body[] = vv_f( "Body $i Diagram", array( 'art-callout' ), array(
					vv_p( "Body $i Diagram Label", $b[1], array( 't-mono' ) ), vv_p( "Body $i Diagram Title", $b[2], array( 'art-callout-title' ) ),
					vv_f( "Body $i Diagram Columns", array( 'dg-cols' ), $cols ), vv_p( "Body $i Diagram Caption", $b[4], array( 'art-cite' ) ),
				) );
				break;
			case 'compare':
				$cols = array(); $c = 0; $marks = array( 'good' => '✓', 'bad' => '✗', 'warn' => '~' );
				foreach ( $b[3] as $col ) {
					$c++; $kids = array( vv_p( "Body $i Compare Column $c Label", $col[0], array( 'dg-label' ) ) ); $k = 0;
					foreach ( $col[1] as $row ) {
						$k++;
						$kids[] = vv_f( "Body $i Compare Column $c Row $k", array( 'cmp-row' ), array( vv_p( "Body $i Compare Column $c Row $k Mark", $marks[ $row[0] ], array( 'cmp-' . $row[0] ), 'span' ), vv_p( "Body $i Compare Column $c Row $k Text", $row[1], array( 'art-td' ) ) ) );
					}
					$cols[] = vv_f( "Body $i Compare Column $c", array( 'dg-col' ), $kids );
				}
				$body[] = vv_f( "Body $i Compare", array( 'art-callout' ), array(
					vv_p( "Body $i Compare Label", $b[1], array( 't-mono' ) ), vv_p( "Body $i Compare Title", $b[2], array( 'art-callout-title' ) ),
					vv_f( "Body $i Compare Columns", array( 'dg-cols' ), $cols ), vv_p( "Body $i Compare Caption", $b[4], array( 'art-cite' ) ),
				) );
				break;
			case 'brief':
				$kids = array( vv_p( "Body $i Brief Label", $b[1], array( 't-mono' ) ), vv_p( "Body $i Brief Title", $b[2], array( 'art-callout-title' ) ) ); $k = 0;
				foreach ( $b[3] as $part ) {
					$k++;
					$kids[] = 'p' === $part[0] ? vv_p( "Body $i Brief Part $k", $part[1], array( 'art-p-sm' ) ) : $list( "Body $i Brief Part $k", $part[0], $part[1], array( 'art-p-sm' ), array( 'sm-mark' ) );
				}
				$body[] = vv_f( "Body $i Brief", array( 'art-callout' ), $kids );
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
	foreach ( array( $e( $p['cat'] ), $p['fmt'] ?? 'Field note', $p['min'] . ' min' ) as $t ) {
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
					...( isset( $p['banner'] )
						? array( vv_img( 'Article Banner', $p['banner'][0], $p['banner_alt'] ?? '', array( 'art-banner-desktop' ) ), vv_img( 'Article Banner Mobile', $p['banner'][1], $p['banner_alt'] ?? '', array( 'art-banner-mobile' ) ) )
						: array( vv_img( 'Article Banner', $tone[ $p['tone'] ], '', array( 'tile-img', 'art-banner' ) ) ) ),
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
					/* Image slot for a future ad/promo image (4:5 on desktop, 6:5 up to 300px on tablet/mobile). */
					vv_img( 'Sidebar Image Slot', 357, '', array( 'ad-slot' ) ),
				), array( 'tag' => 'aside' ) ),
			) ),
		) ) ), array( 'tag' => 'section' ) ),
		vv_subscribe( 'Article' ),
	);
	$out[ $p['slug'] ] = array( 'id' => $p['id'], 'result' => vv_build( $p['id'], $nodes, 'document', 'replace_children' ) );
}
return $out;
