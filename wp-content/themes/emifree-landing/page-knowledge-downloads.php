<?php
/**
 * Page template: /en/knowledge/downloads/
 *
 * Crawlable EN landing for the Knowledge hub's "Downloads" tab.
 * Own URL + canonical + BreadcrumbList + hreflang pair. Renders
 * the product-brochure grid with a 1-2 sentence intro that names
 * the documents and explains how to use them, addressing the
 * thin-content signal-dilution risk the hub's JS-driven tab had.
 *
 * Renders template-parts/page-knowledge-downloads.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/downloads/' );
$emifree_url_de = home_url( '/de/wissen/downloads/' );

emifree_seo_page_with_breadcrumb(
	'Product Brochures, Emifree PDF Library',
	'Download Emifree product brochures, technical datasheets, and full-range catalogs in PDF format. ECO AIR Cleaner catalog (EN + DE) available now, with more catalogs coming soon.',
	$emifree_url_en,
	'emifree-knowledge-downloads-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Product Brochures and PDFs',
		'description' => 'Downloadable Emifree product brochures, technical datasheets, and full-range catalogs.',
		'url'         => $emifree_url_en,
		'inLanguage'  => 'en-US',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Home',     'url' => home_url( '/en/' ) ),
		array( 'name' => 'Knowledge', 'url' => home_url( '/en/knowledge/' ) ),
		array( 'name' => 'Downloads', 'url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-downloads.php';

get_footer();
