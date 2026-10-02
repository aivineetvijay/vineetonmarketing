<?php
/**
 * Plugin Name: VV Schema
 * Description: Enriches the Rank Math JSON-LD graph with Vineet Vijay's author (Person) profile, merges the post author into the site Person, and sets ProfilePage / CollectionPage types.
 * Version:     1.3.0
 *
 * Install: copy to wp-content/mu-plugins/vv-schema.php (must-use plugins load automatically).
 * Requires Rank Math SEO with the Schema (rich-snippet) module active.
 */

defined( 'ABSPATH' ) || exit;

/** Astra adds its own microdata (itemtype=...). Rank Math's JSON-LD replaces it. */
add_filter( 'astra_schema_enabled', '__return_false' );

/** Page IDs that describe the person (ProfilePage) and the essay index (CollectionPage). */
const VV_SCHEMA_PROFILE_PAGES    = array( 101, 253 ); // Home, Experience.
const VV_SCHEMA_COLLECTION_PAGES = array( 296 );      // Blog.
const VV_SCHEMA_HEADSHOT_ID      = 8;
const VV_SCHEMA_BLOG_PAGE        = 296;

/** Breadcrumbs (visible trail and BreadcrumbList): essays sit under the Blog page, not a category archive. */
add_filter( 'rank_math/frontend/breadcrumb/items', function ( $crumbs ) {
	if ( is_singular( 'post' ) && count( $crumbs ) >= 2 ) {
		return array( reset( $crumbs ), array( get_the_title( VV_SCHEMA_BLOG_PAGE ), get_permalink( VV_SCHEMA_BLOG_PAGE ) ), end( $crumbs ) );
	}
	return $crumbs;
} );

function vv_schema_person_id() {
	return home_url( '/#person' );
}

function vv_schema_person() {
	$bio   = 'Digital marketing strategist with ten years across healthcare, e-commerce, FMCG and luxury. Writes about AI in marketing, search, paid media and measurement.';
	$place = array(
		'@type'           => 'PostalAddress',
		'addressLocality' => 'Dubai',
		'addressCountry'  => 'AE',
	);
	$person = array(
		'@type'       => 'Person',
		'@id'         => vv_schema_person_id(),
		'name'        => 'Vineet Vijay',
		'url'         => home_url( '/' ),
		'jobTitle'    => 'Digital Marketing Strategist',
		'description' => $bio,
		'address'     => $place,
		'homeLocation' => array(
			'@type'   => 'Place',
			'name'    => 'Dubai, United Arab Emirates',
			'address' => $place,
		),
		'alumniOf'    => array(
			array( '@type' => 'CollegeOrUniversity', 'name' => 'Indian Institute of Management Calcutta', 'alternateName' => 'IIM Calcutta' ),
			array( '@type' => 'CollegeOrUniversity', 'name' => 'ICFAI Business School, Hyderabad', 'alternateName' => 'ICFAI Hyderabad' ),
			array( '@type' => 'CollegeOrUniversity', 'name' => 'Dayananda Sagar College of Engineering, Bangalore', 'alternateName' => 'DSCE Bangalore' ),
		),
		'knowsAbout'  => array( 'Digital marketing', 'AI in marketing', 'Search engine optimisation', 'Paid media', 'Marketing measurement' ),
		'sameAs'      => array( 'https://www.linkedin.com/in/vineetvijay' ),
	);
	$img = wp_get_attachment_image_src( VV_SCHEMA_HEADSHOT_ID, 'full' );
	if ( $img ) {
		$person['image'] = array(
			'@type'      => 'ImageObject',
			'@id'        => home_url( '/#personimage' ),
			'url'        => $img[0],
			'contentUrl' => $img[0],
			'width'      => $img[1],
			'height'     => $img[2],
			'caption'    => 'Vineet Vijay',
		);
	}
	return $person;
}

function vv_schema_is_person( $node ) {
	$type = isset( $node['@type'] ) ? (array) $node['@type'] : array();
	return in_array( 'Person', $type, true );
}

/** Point every reference to an author archive Person at the single site Person. */
function vv_schema_repoint( $value ) {
	if ( ! is_array( $value ) ) {
		return $value;
	}
	if ( isset( $value['@id'] ) && is_string( $value['@id'] ) && 0 === strpos( $value['@id'], home_url( '/author/' ) ) ) {
		return array( '@id' => vv_schema_person_id(), 'name' => 'Vineet Vijay' );
	}
	foreach ( $value as $k => $v ) {
		$value[ $k ] = vv_schema_repoint( $v );
	}
	return $value;
}

add_filter( 'rank_math/json_ld', function ( $data, $jsonld ) {
	if ( ! is_array( $data ) || empty( $data ) ) {
		return $data;
	}

	// One Person for the whole site: drop Rank Math's Person/Organization and author nodes.
	foreach ( $data as $k => $node ) {
		if ( is_array( $node ) && vv_schema_is_person( $node ) ) {
			unset( $data[ $k ] );
		}
	}
	$data = vv_schema_repoint( $data );
	$data = array( 'publisher' => vv_schema_person() ) + $data;

	$website = null;
	$webpage = null;
	foreach ( $data as $k => $node ) {
		$type = isset( $node['@type'] ) ? (array) $node['@type'] : array();
		if ( in_array( 'WebSite', $type, true ) ) {
			$website = $k;
		}
		if ( array_intersect( array( 'WebPage', 'ProfilePage', 'CollectionPage', 'AboutPage' ), $type ) ) {
			$webpage = $k;
		}
	}

	if ( null === $website ) {
		$data['WebSite'] = array(
			'@type'         => 'WebSite',
			'@id'           => home_url( '/#website' ),
			'url'           => home_url(),
			'name'          => 'Vineet Vijay',
			'alternateName' => 'vineetonmarketing.com',
			'publisher'     => array( '@id' => vv_schema_person_id() ),
			'inLanguage'    => get_bloginfo( 'language' ),
		);
	}

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		$url     = get_permalink( $post_id );
		if ( null === $webpage ) {
			$webpage          = 'WebPage';
			$data['WebPage']  = array(
				'@type'         => 'WebPage',
				'@id'           => $url . '#webpage',
				'url'           => $url,
				'name'          => wp_strip_all_tags( get_the_title( $post_id ) ) . ' - Vineet Vijay',
				'datePublished' => get_post_time( 'c', true, $post_id ),
				'dateModified'  => get_post_modified_time( 'c', true, $post_id ),
				'isPartOf'      => array( '@id' => home_url( '/#website' ) ),
				'inLanguage'    => get_bloginfo( 'language' ),
			);
			if ( isset( $data['BreadcrumbList']['@id'] ) ) {
				$data['WebPage']['breadcrumb'] = array( '@id' => $data['BreadcrumbList']['@id'] );
			}
		}
		if ( in_array( $post_id, VV_SCHEMA_PROFILE_PAGES, true ) ) {
			$data[ $webpage ]['@type']      = 'ProfilePage';
			$data[ $webpage ]['mainEntity'] = array( '@id' => vv_schema_person_id() );
			$data[ $webpage ]['about']      = array( '@id' => vv_schema_person_id() );
		} elseif ( in_array( $post_id, VV_SCHEMA_COLLECTION_PAGES, true ) ) {
			$data[ $webpage ]['@type'] = 'CollectionPage';
			$data[ $webpage ]['about'] = array( '@id' => vv_schema_person_id() );
		}
	}

	// Essays: author = the site Person; headline without the " - Vineet Vijay" title suffix.
	foreach ( $data as $k => $node ) {
		$type = isset( $node['@type'] ) ? (array) $node['@type'] : array();
		if ( array_intersect( array( 'BlogPosting', 'Article', 'NewsArticle' ), $type ) ) {
			$title                    = wp_strip_all_tags( html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ) );
			$data[ $k ]['headline']   = $title;
			$data[ $k ]['name']       = $title;
			/* Author and publisher as typed Person objects (not bare @id references) so every schema
			   validator shows them in full; the @id still links them to the site Person node. */
			$author                   = array(
				'@type'    => 'Person',
				'@id'      => vv_schema_person_id(),
				'name'     => 'Vineet Vijay',
				'url'      => home_url( '/' ),
				'jobTitle' => 'Digital Marketing Strategist',
				'sameAs'   => array( 'https://www.linkedin.com/in/vineetvijay' ),
			);
			$data[ $k ]['author']     = $author;
			$data[ $k ]['publisher']  = array( '@type' => 'Person', '@id' => vv_schema_person_id(), 'name' => 'Vineet Vijay', 'url' => home_url( '/' ) );
		}
	}

	// FAQPage from an essay's visible FAQ section (post meta vv_faq: [[question, answer], ...]).
	if ( is_singular() ) {
		$faq = get_post_meta( get_queried_object_id(), 'vv_faq', true );
		if ( is_array( $faq ) && $faq ) {
			$url             = get_permalink( get_queried_object_id() );
			$data['FAQPage'] = array(
				'@type'      => 'FAQPage',
				'@id'        => $url . '#faq',
				'isPartOf'   => array( '@id' => $url . '#webpage' ),
				'inLanguage' => get_bloginfo( 'language' ),
				'mainEntity' => array_map( function ( $qa ) {
					return array(
						'@type'          => 'Question',
						'name'           => $qa[0],
						'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $qa[1] ),
					);
				}, $faq ),
			);
		}
	}

	return $data;
}, 99, 2 );
