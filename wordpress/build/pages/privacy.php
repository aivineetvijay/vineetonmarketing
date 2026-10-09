<?php
/**
 * Privacy policy (/privacy-policy/). Reuses WordPress's privacy page (ID 3, set as the site's privacy policy page)
 * and the essay text classes. Describes what the site actually does: contact form and email, the Hostinger Reach
 * newsletter, Google Analytics through Google Tag Manager (loaded on first interaction or after 10 seconds),
 * Hostinger hosting logs, and the llms.txt generators, which keep entries in the visitor's browser only.
 */
$id = vv_new( 'Privacy Policy', 'privacy-policy' );
update_option( 'wp_page_for_privacy_policy', $id );

$email = 'vineetvijay88@gmail.com';
$a = function ( $text, $href ) { return '<a href="' . esc_url( $href ) . '"><u>' . $text . '</u></a>'; };

/* Sections: [heading, anchor, blocks]. Blocks: ['p', html] or ['ul', [html, ...]]. */
$sections = array(
	array( 'Who I am', 'who', array(
		array( 'p', 'This website, vineetonmarketing.com, is run by me, Vineet Vijay, an individual based in Dubai, United Arab Emirates. I decide how the personal information described here is used, which makes me responsible for it.' ),
		array( 'p', 'Questions about this policy or your information: ' . $a( $email, 'mailto:' . $email ) . '.' ),
	) ),
	array( 'What I collect and why', 'collect', array(
		array( 'ul', array(
			'<strong>When you contact me.</strong> If you use the contact form, email or call me, I receive your name, email address and whatever you write. I use it only to reply and to continue the conversation. The form sends your message to my email inbox.',
			'<strong>When you subscribe.</strong> If you sign up for new essays or tools, I receive your email address. I use it only to send what you signed up for. Every email has an unsubscribe link.',
			'<strong>When you read the site.</strong> Google Analytics, loaded through Google Tag Manager, records which pages are visited, how visitors arrived, and general device, browser and approximate location details. I use it to understand which writing and tools are useful. It loads on your first scroll, tap or click, or after 10 seconds on a page.',
			'<strong>When your browser requests a page.</strong> My hosting provider keeps standard server logs, including IP address, browser and the page requested, to run the site securely and keep it fast.',
		) ),
		array( 'p', '<strong>The llms.txt generators.</strong> The ' . $a( 'llms.txt generators', vv_url( '/ai-tools/llms-txt-generator/' ) ) . ' run entirely in your browser. What you type is saved in your own browser’s local storage so you can come back to it, and is never sent to me or anyone else. Use <em>Clear form</em> or clear your browser data to remove it.' ),
		array( 'p', 'I do not sell or rent personal information, and I do not knowingly collect information from children under 16.' ),
	) ),
	array( 'Legal basis', 'basis', array(
		array( 'p', 'Where data protection law asks for a legal basis, I rely on your consent for the newsletter and, where required, for analytics, and on my legitimate interest in replying to messages, understanding how the site is used and keeping it secure. This applies under the UAE Personal Data Protection Law and, for visitors in the EU or UK, the GDPR.' ),
	) ),
	array( 'Cookies', 'cookies', array(
		array( 'p', 'Google Analytics sets first-party cookies (named <em>_ga</em> and <em>_ga_</em> followed by an ID) to tell visits apart. They last up to two years unless you clear them. The site itself does not set marketing cookies for visitors. You can block or delete cookies in your browser settings, or install Google’s ' . $a( 'Analytics opt-out add-on', 'https://tools.google.com/dlpage/gaoptout' ) . '.' ),
	) ),
	array( 'Who processes it for me', 'processors', array(
		array( 'ul', array(
			'<strong>Hostinger</strong>: website hosting, content delivery and the newsletter (Hostinger Reach).',
			'<strong>Google</strong>: Google Analytics and Google Tag Manager, and Gmail, which delivers contact-form messages and email replies.',
		) ),
		array( 'p', 'These providers process information on my behalf under their own terms and may store it outside the UAE. I share personal information with no one else, unless the law requires it.' ),
	) ),
	array( 'How long I keep it', 'retention', array(
		array( 'p', 'Messages are kept for as long as the conversation is relevant, and deleted on request. Newsletter addresses are kept until you unsubscribe. Analytics data is kept for the retention period set in Google Analytics. Server logs are kept by Hostinger for a limited period for security.' ),
	) ),
	array( 'Your rights', 'rights', array(
		array( 'p', 'You can ask to see the information I hold about you, correct it, delete it, receive a copy, object to how it is used, or withdraw consent at any time. Email ' . $a( $email, 'mailto:' . $email ) . ' and I will respond within 30 days. If you are unhappy with the answer, you can complain to the UAE Data Office or, in the EU or UK, your local data protection authority.' ),
	) ),
	array( 'Changes to this policy', 'changes', array(
		array( 'p', 'If what the site collects changes, I will update this page and the date at the top.' ),
	) ),
);

$body = array(); $i = 0;
foreach ( $sections as $s ) {
	$i++;
	$body[] = vv_n( 'e-heading', "Privacy $i Heading", array( 'art-h3' ), array( 'tag' => 'h2', 'title' => $s[0] ), array(), null, $s[1] );
	$j = 0;
	foreach ( $s[2] as $b ) {
		$j++;
		if ( 'p' === $b[0] ) {
			$body[] = vv_p( "Privacy $i Paragraph $j", $b[1], array( 'art-p' ) );
			continue;
		}
		$rows = array(); $k = 0;
		foreach ( $b[1] as $item ) {
			$k++;
			$rows[] = vv_f( "Privacy $i List $j Point $k", array( 'bullet' ), array(
				vv_p( "Privacy $i List $j Point $k Mark", '•', array( 'bullet-mark', 'art-mark' ), 'span' ),
				vv_p( "Privacy $i List $j Point $k Text", $item, array( 'art-p' ) ),
			) );
		}
		$body[] = vv_f( "Privacy $i List $j", array( 'bullet-list' ), $rows );
	}
}

$nodes = array(
	vv_hero( 'Privacy',
		array( vv_meta_block( 'Privacy', 'Last updated', '9 October 2026' ), vv_meta_block( 'Privacy', 'Applies to', 'vineetonmarketing.com' ), vv_meta_block( 'Privacy', 'Questions', $email, true ) ),
		'Privacy', 'policy.', true,
		'What this site collects, why, who helps me process it, and how to see or delete it. Short version: very little, never sold, and the tools keep your entries in your own browser.'
	),
	vv_f( 'Policy', array( 'section', 'pt-24', 'bg-canvas' ), array(
		vv_f( 'Policy Inner', array( 'wrap' ), array(
			vv_f( 'Policy Text', array( 'art-body' ), $body, array( 'tag' => 'article' ) ),
		) ),
	), array( 'tag' => 'section' ) ),
);

return array( 'id' => $id, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
