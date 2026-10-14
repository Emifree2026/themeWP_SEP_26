<?php
/**
 * Page template: /en/products/dust/
 *
 * Long-form landing for the dust-filtration line. As of 2026-10-14
 * only the hero section is live (gallery + intro + CTA). The page
 * will grow the same way the mechanical and electrostatic pages did:
 * dimensions → performance → specs → brochure → cross-link strip.
 *
 * Own URL + canonical + BreadcrumbList + hreflang pair to the DE
 * sibling. Renders template-parts/page-products-dust.php.
 *
 * The intermediate "Products" breadcrumb points to /en/#products
 * (the home-page anchor) until /en/products/ exists as its own
 * page; the user can swap the URL in two places when it lands.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/products/dust/' );
$emifree_url_de = home_url( '/de/produkte/entstaubung/' );

emifree_seo_page_with_breadcrumb(
	'Dust Filtration — Stop Dust at the Source · Emifree',
	'Emifree dust filtration for wood, metal, mineral, and food-grade powders. Auto-clean jet-pulse cartridges, frequency-converter airflow control, optional ATEX-rated explosion protection.',
	$emifree_url_en,
	'emifree-products-dust-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'Emifree Dust Filtration System',
		'description' => 'Industrial dust collection with auto-clean jet-pulse cartridges, frequency-converter (FC) airflow control, and ATEX-rated options for wood, metal, mineral, and food-grade applications.',
		'category'    => 'Industrial Dust Collection',
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
		array( 'name' => 'Home',     'url' => home_url( '/en/' ) ),
		array( 'name' => 'Products', 'url' => home_url( '/en/#products' ) ),
		array( 'name' => 'Dust',     'url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-dust.php';

get_footer();
