<?php
/**
 * Page template: /de/wissen/insights/
 *
 * Deutsche Variante von page-knowledge-insights.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar, damit Google die
 * DE-Version der Branchen-Insights eigenständig indexieren kann.
 *
 * Rendert template-parts/page-knowledge-insights-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/insights/' );
$emifree_url_de = home_url( '/de/wissen/insights/' );

emifree_seo_page_with_breadcrumb(
	'Branchen-Insights, Luftfiltrations-Engineering-Blog',
	'Technische Anleitungen, Dimensionierungsreferenzen und Praxisanmerkungen zur industriellen Luftfiltration, Ölnebelabscheidung und HLK-Kanalauslegung. Wöchentlich aktualisiert von Emifree GmbH.',
	$emifree_url_de,
	'emifree-knowledge-insights-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Branchen-Insights',
		'description' => 'Technische Anleitungen, Dimensionierungsreferenzen und Praxisanmerkungen zur industriellen Luftfiltration und HLK-Kanalauslegung.',
		'url'         => $emifree_url_de,
		'inLanguage'  => 'de-DE',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Startseite', 'url' => home_url( '/de/' ) ),
		array( 'name' => 'Wissen',     'url' => home_url( '/de/wissen/' ) ),
		array( 'name' => 'Branchen-Insights', 'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-insights-de.php';

get_footer();
