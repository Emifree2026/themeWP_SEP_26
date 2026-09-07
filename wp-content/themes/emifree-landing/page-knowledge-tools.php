<?php
/**
 * Page template: /en/knowledge/tools/
 *
 * Crawlable EN landing for the Free Engineering Tools entry
 * point. Own URL + canonical (pointing at self, NOT at the
 * individual calculator pages) + BreadcrumbList + hreflang pair.
 *
 * Renders the tool tile layout (ductulator, pressure-loss
 * calculator) plus a "Choosing the right tool" comparison intro
 * and a per-tool guidance paragraph so the umbrella page carries
 * its own substantive content. This is the cannibalization
 * mitigation the user requested: the calculator pages stay the
 * canonical answers for their long-tail queries, and this page
 * ranks for the umbrella "free engineering tools" head term.
 *
 * Renders template-parts/page-knowledge-tools.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/tools/' );
$emifree_url_de = home_url( '/de/wissen/tools/' );

emifree_seo_page_with_breadcrumb(
	'Free Engineering Tools, Duct Sizing and Pressure Loss',
	'Free HVAC and air-filtration engineering calculators: a duct sizing tool (Darcy-Weisbach + Swamee-Jain, imperial + metric) and an air pressure loss calculator with K-factor fittings.',
	$emifree_url_en,
	'emifree-knowledge-tools-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Free Engineering Tools',
		'description' => 'Free duct sizing and air pressure loss calculators for HVAC and industrial air filtration.',
		'url'         => $emifree_url_en,
		'inLanguage'  => 'en-US',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Home',      'url' => home_url( '/en/' ) ),
		array( 'name' => 'Knowledge', 'url' => home_url( '/en/knowledge/' ) ),
		array( 'name' => 'Free Tools', 'url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-tools.php';

get_footer();
