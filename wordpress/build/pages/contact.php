<?php
/**
 * Contact (/contact/) — rebuilt from contact.html.
 * The form mockup is intentionally NOT rebuilt: "Contact Form Slot" is an empty
 * container under "Or send a note" for the site owner's working form.
 */
$id = vv_new( 'Contact', 'contact' );

$steps = array(
	array( '01', 'I read it.', 'Every note arrives in the same inbox. No assistants, no triage. I read what you wrote, in full.' ),
	array( '02', 'I reply.', 'A short, personal response. Sometimes a question back, sometimes a link to something already written, sometimes a thank-you.' ),
	array( '03', 'We take it from there.', 'A continued exchange, a call, an introduction — or just two people glad to have crossed paths.' ),
);
$faq = array(
	array( 'Are you a consultant for hire?', 'This site is primarily a publishing platform for my writing. I do take on a small number of advisory and speaking engagements each year — say hello and we can talk.' ),
	array( 'Can I quote or republish your essays?', 'Yes, with attribution and a link back. Drop a note before publishing so I can share any updated context.' ),
	array( 'Do you do podcast or panel appearances?', 'Often. The topics I most enjoy: AI in marketing, search, measurement, and the operating systems behind growing teams.' ),
	array( 'Will you respond to a cold outreach?', 'Almost always, if it is a real note from a real person about a real idea. Generic pitches do not get a reply.' ),
	array( 'How do you handle data shared in a conversation?', 'In confidence. Nothing shared with me is fed to a model that retains it, or shared further without permission.' ),
);
$items = array();
foreach ( $faq as $i => $q ) {
	$n = $i + 1;
	$items[] = vv_acc_item( "Question $n", array( 'acc-item' ), array( 'acc-head' ), sprintf( '%02d', $n ), array( 'acc-num' ), $q[0], array( 'acc-title' ),
		array( 'acc-icon' ), array( 'acc-body' ), array( vv_p( "Question $n Answer", $q[1], array( 'acc-answer' ) ) ) );
}
$link = function ( $l, $text, $href, $extra = array(), $blank = false ) {
	return vv_n( 'e-paragraph', $l, array_merge( array( 'contact-link' ), $extra ), array( 'paragraph' => $text, 'tag' => 'p', 'link' => array( 'destination' => $href, 'isTargetBlank' => $blank, 'tag' => 'a' ) ) );
};

$nodes = array(
	vv_hero( 'Contact',
		array( vv_status_block( 'Contact', 'Status' ), vv_meta_block( 'Contact', 'Reply', 'Within one working day · GST +4' ), vv_meta_block( 'Contact', 'Office hours', 'Sunday — Thursday · 9:00 — 18:00' ) ),
		'Say<br>hello', '.', true,
		'For a conversation, a question, or a thought worth sharing. If something on this site struck a chord — or you want to swap notes — send me a note.'
	),
	vv_f( 'Reach', array( 'section', 'bg-canvas' ), array( vv_f( 'Reach Inner', array( 'wrap' ), array( vv_f( 'Reach Split', array( 'split' ), array(
		vv_f( 'Direct', array( 'col-5w' ), array(
			vv_p( 'Direct Heading', 'Direct', array( 't-mono' ) ),
			vv_f( 'Direct Links', array( 'stack', 'mt-32' ), array(
				$link( 'Direct Email', 'vineetvijay88@gmail.com', 'mailto:vineetvijay88@gmail.com' ),
				$link( 'Direct Phone', '+971 58 682 3646', 'tel:+971586823646', array( 'mt-16' ) ),
				$link( 'Direct LinkedIn', 'linkedin.com/in/vineetvijay', 'https://linkedin.com/in/vineetvijay', array( 'mt-16' ), true ),
			) ),
			vv_f( 'Based', array( 'stack', 'mt-64' ), array( vv_p( 'Based Heading', 'Based', array( 't-mono' ) ), vv_p( 'Based Text', 'Abu Dhabi &amp; Dubai<br>United Arab Emirates', array( 't-medium', 'mt-16' ) ) ) ),
			vv_f( 'Markets', array( 'stack', 'mt-48' ), array( vv_p( 'Markets Heading', 'Active markets', array( 't-mono' ) ), vv_p( 'Markets Text', 'UAE · KSA · India · Wider GCC', array( 't-meta', 'mt-16' ) ) ) ),
		), array(), vv_ix() ),
		vv_f( 'Note', array( 'col-6w' ), array(
			vv_p( 'Note Heading', 'Or send a note', array( 't-mono' ) ),
			vv_f( 'Contact Form Slot', array( 'form-slot', 'mt-32' ) ),
		), array(), vv_ix( 'scrollIn', 'slide', 120 ) ),
	) ) ) ) ), array( 'tag' => 'section' ) ),
	vv_f( 'Expect', array( 'section', 'bg-parchment' ), array( vv_f( 'Expect Inner', array( 'wrap' ), array(
		vv_sec_head( 'Expect', '01', 'What to expect', 'A quiet inbox, taken seriously' ),
		vv_title_block( 'Expect', 'From note', 'to reply.' ),
		vv_cards( 'Expect', $steps, array( 'grid-3-stack', 'mt-96' ), false, 'Step ' ),
	) ) ), array( 'tag' => 'section' ) ),
	vv_f( 'FAQ', array( 'section', 'bg-canvas' ), array( vv_f( 'FAQ Inner', array( 'wrap' ), array(
		vv_sec_head( 'FAQ', '02', 'Common questions', 'Frequently asked' ),
		vv_f( 'FAQ Holder', array( 'stack', 'mt-64' ), array(
			vv_n( 'e-accordion', 'FAQ Accordion', array( 'acc' ), array( 'default_state' => 'first_expanded', 'max_expanded' => 'one', 'show_icon' => true, 'faq_schema' => true ), $items ),
		), array(), vv_ix() ),
	) ) ), array( 'tag' => 'section' ) ),
);

return array( 'id' => $id, 'result' => vv_build( $id, $nodes, 'document', 'replace_children' ) );
