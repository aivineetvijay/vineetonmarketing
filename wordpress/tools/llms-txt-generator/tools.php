<?php
/**
 * The llms.txt generators: one WordPress page per industry under the hub (/ai-tools/llms-txt-generator/<slug>/).
 * Each page renders inside the theme (header, breadcrumbs, footer) via the vv-tools mu-plugin; the tool itself is
 * assets/generator.js + <slug>/config.js. Used by install-llms-generators.php. Pages are noindex: shared by link.
 *
 * h1: "main|italic tail".
 */
return array(
	'real-estate' => array(
		'label' => 'Real Estate', 'title' => 'llms.txt Generator for Real Estate', 'h1' => 'llms.txt for|real estate.',
		'lead'  => 'For developers, brokerages, agencies and portals. Fill in the business details and key pages. The file builds as you type, ready to download and upload to your site root.',
		'seo_t' => 'llms.txt Generator for Real Estate Websites | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for property developers, brokerages, agencies and portals. Add your details and key pages; the file builds in your browser.',
	),
	'healthcare' => array(
		'label' => 'Healthcare', 'title' => 'llms.txt Generator for Healthcare', 'h1' => 'llms.txt for|healthcare.',
		'lead'  => 'For hospitals, clinics, specialist practices and diagnostic centres. Accuracy over reach: no outcome claims, no prices, no invented credentials.',
		'seo_t' => 'llms.txt Generator for Healthcare Websites | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for hospitals, clinics and healthcare providers. Add your specialties, locations and key pages; the file builds in your browser.',
	),
	'ecommerce' => array(
		'label' => 'E-commerce', 'title' => 'llms.txt Generator for E-commerce', 'h1' => 'llms.txt for|e-commerce.',
		'lead'  => 'For D2C brands, retailers and marketplaces. Categories over SKUs: map the catalogue and the policies shoppers ask about, without prices that go stale.',
		'seo_t' => 'llms.txt Generator for E-commerce Stores | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for online stores, D2C brands and marketplaces. Add your categories, guides and policies; the file builds in your browser.',
	),
	'education' => array(
		'label' => 'Education', 'title' => 'llms.txt Generator for Education', 'h1' => 'llms.txt for|education.',
		'lead'  => 'For universities, schools, training institutes and learning platforms. Programmes, admissions and accreditation, with fees and deadlines left on the page.',
		'seo_t' => 'llms.txt Generator for Education Websites | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for universities, schools and learning platforms. Add your programmes, admissions and key pages; the file builds in your browser.',
	),
	'finance' => array(
		'label' => 'Finance & Fintech', 'title' => 'llms.txt Generator for Finance & Fintech', 'h1' => 'llms.txt for|finance & fintech.',
		'lead'  => 'For banks, payments, lending, insurance and investment firms. Products and licensing stated exactly, with no rates, returns or advice.',
		'seo_t' => 'llms.txt Generator for Finance & Fintech | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for banks, payments and fintech companies. Add your products, licences and key pages; the file builds in your browser.',
	),
	'publishers' => array(
		'label' => 'Content & Publishers', 'title' => 'llms.txt Generator for Publishers', 'h1' => 'llms.txt for|publishers.',
		'lead'  => 'For news sites, magazines, blogs and newsletters. Map the publication and its standards, surface the evergreen work, and leave the dated headlines out.',
		'seo_t' => 'llms.txt Generator for Publishers & Content Sites | Vineet Vijay',
		'seo_d' => 'Free llms.txt generator for news sites, magazines and blogs. Add your sections, standards and evergreen guides; the file builds in your browser.',
	),
);
