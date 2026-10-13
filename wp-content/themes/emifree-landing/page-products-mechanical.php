<?php
/**
 * Page template: /en/products/mechanical/
 *
 * Long-form landing for the ECO AIR Cleaner (mechanical) line. Own
 * URL + canonical + BreadcrumbList + hreflang pair to the DE
 * sibling. Renders the gallery, dimensions, specs, and brochure
 * sections for the mechanical product family.
 *
 * Renders template-parts/page-products-mechanical.php.
 *
 * The intermediate "Products" breadcrumb points to /en/#products
 * (the home-page anchor) until /en/products/ exists as its own
 * page; the user can swap the URL in two places when it lands.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/products/mechanical/' );
$emifree_url_de = home_url( '/de/produkte/mechanische-filtration/' );

emifree_seo_page_with_breadcrumb(
	'Mechanical Oil Mist Filtration — ECO AIR Cleaner · Emifree',
	'Industrial oil mist extraction for CNC machining. ECO AIR Cleaner self-cleaning mechanical filtration, with optional HEPA. Specs, dimensions, and brochure downloads.',
	$emifree_url_en,
	'emifree-products-mechanical-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'ECO AIR Cleaner — Mechanical Oil Mist Extraction',
		'description' => 'Self-cleaning mechanical filtration system using centrifugal force to separate oil mist and coolant fumes at the source for heavy-duty CNC machining environments.',
		'category'    => 'Industrial Air Filtration',
		'url'         => $emifree_url_en,
		'inLanguage'  => 'en-US',
		'brand'       => array(
			'@type' => 'Brand',
			'name'  => 'Emifree',
		),
		'manufacturer' => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Home',      'url' => home_url( '/en/' ) ),
		array( 'name' => 'Products',  'url' => home_url( '/en/#products' ) ),
		array( 'name' => 'Mechanical','url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-mechanical.php';

get_footer();
