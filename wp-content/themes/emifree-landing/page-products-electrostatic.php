<?php
/**
 * Page template: /en/products/electrostatic/
 *
 * Long-form landing for the EARIA 1000 m³/h electrostatic line.
 * Own URL + canonical + BreadcrumbList + hreflang pair to the DE
 * sibling. Renders the gallery, dimensions, performance, specs,
 * and quotation sections.
 *
 * Renders template-parts/page-products-electrostatic.php.
 *
 * The intermediate "Products" breadcrumb points to /en/#products
 * (the home-page anchor) until /en/products/ exists as its own
 * page; the user can swap the URL in two places when it lands.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/products/electrostatic/' );
$emifree_url_de = home_url( '/de/produkte/elektrostatische-filtration/' );

emifree_seo_page_with_breadcrumb(
	'Electrostatic Air Filtration — EARIA 1000 m³/h · Emifree',
	'EARIA 1000 m³/h electrostatic precipitator for sub-micron particle capture: smoke, fine mist, and industrial odor control. Adjustable airflow up to 1000 m³/h, optional control system.',
	$emifree_url_en,
	'emifree-products-electrostatic-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'EARIA 1000 m³/h — Electrostatic Air Filtration',
		'description' => 'Electrostatic precipitator capturing sub-micron particles (smoke, fine mist, industrial odor) directly at the source. Available in Basis and Premium variants.',
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
		array( 'name' => 'Home',         'url' => home_url( '/en/' ) ),
		array( 'name' => 'Products',     'url' => home_url( '/en/#products' ) ),
		array( 'name' => 'Electrostatic','url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-electrostatic.php';

get_footer();
