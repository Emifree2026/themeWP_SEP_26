<?php
/**
 * Page template: /en/knowledge/insights/
 *
 * Crawlable EN landing for the Knowledge hub's "Industry Insights"
 * tab. Own URL + canonical + BreadcrumbList + hreflang pair so
 * Google can index this content independently from the hub and
 * from the equivalent DE page.
 *
 * Renders template-parts/page-knowledge-insights.php (which renders
 * the merged EN blog feed + featured cards + intro + CTA back to
 * /blog/).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/insights/' );
$emifree_url_de = home_url( '/de/wissen/insights/' );

emifree_seo_page_with_breadcrumb(
	'Industry Insights, Air Filtration Engineering Blog',
	'Engineering guides, sizing references, and field notes on industrial air filtration, oil-mist separation, and HVAC duct design. Updated weekly by Emifree GmbH.',
	$emifree_url_en,
	'emifree-knowledge-insights-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Industry Insights',
		'description' => 'Engineering guides, sizing references, and field notes on industrial air filtration and HVAC duct design.',
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
		array( 'name' => 'Industry Insights', 'url' => $emifree_url_en ),
	),
	array(
		'en'         => $emifree_url_en,
		'de'         => $emifree_url_de,
		'x-default'  => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-insights.php';

get_footer();
