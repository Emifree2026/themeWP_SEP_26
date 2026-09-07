<?php
/**
 * Page template: /de/wissen/tools/
 *
 * Deutsche Variante von page-knowledge-tools.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar.
 *
 * Rendert die Werkzeug-Kacheln (Kanalauslegung + Druckverlustrechner)
 * mit eigenständiger Einleitung "Das passende Werkzeug wählen", die
 * die Cannibalization-Risiken adressiert: die Tool-Detailseiten
 * bleiben die kanonischen Antworten für ihre Long-Tail-Queries, und
 * diese Seite rankt für das Sammel-Head-Term "kostenlose
 * Engineering-Werkzeuge".
 *
 * Rendert template-parts/page-knowledge-tools-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/tools/' );
$emifree_url_de = home_url( '/de/wissen/tools/' );

emifree_seo_page_with_breadcrumb(
	'Kostenlose Engineering-Werkzeuge, Kanalauslegung und Druckverlust',
	'Kostenlose HLK- und Luftfiltrations-Rechner: ein Kanalauslegungswerkzeug (Darcy-Weisbach + Swamee-Jain, metrisch + imperial) und ein Druckverlustrechner mit K-Faktor-Formstücken.',
	$emifree_url_de,
	'emifree-knowledge-tools-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Kostenlose Engineering-Werkzeuge',
		'description' => 'Kostenlose Kanalauslegungs- und Druckverlustrechner für HLK und industrielle Luftfiltration.',
		'url'         => $emifree_url_de,
		'inLanguage'  => 'de-DE',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Startseite',  'url' => home_url( '/de/' ) ),
		array( 'name' => 'Wissen',      'url' => home_url( '/de/wissen/' ) ),
		array( 'name' => 'Werkzeuge',   'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-tools-de.php';

get_footer();
