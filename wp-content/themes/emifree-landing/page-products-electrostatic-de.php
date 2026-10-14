<?php
/**
 * Page template: /de/produkte/elektrostatische-filtration/
 *
 * Deutsche Variante von page-products-electrostatic.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar. Rendert Galerie,
 * Abmessungen, Leistungskurve, Spezifikation und Angebot für die
 * elektrostatische EARIA 1000 m³/h Linie.
 *
 * Renders template-parts/page-products-electrostatic-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_de = home_url( '/de/produkte/elektrostatische-filtration/' );
$emifree_url_en = home_url( '/en/products/electrostatic/' );

emifree_seo_page_with_breadcrumb(
	'Elektrostatische Luftfiltration — EARIA 1000 m³/h · Emifree',
	'EARIA 1000 m³/h Elektroabscheider für die Abscheidung sub-mikroner Partikel: Rauch, Feinstnebel und industrielle Gerüche. Einstellbarer Volumenstrom bis 1000 m³/h, optional mit Kontrollsystem.',
	$emifree_url_de,
	'emifree-products-electrostatic-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'EARIA 1000 m³/h — Elektrostatische Luftfiltration',
		'description' => 'Elektroabscheider zur direkten Abscheidung sub-mikroner Partikel (Rauch, Feinstnebel, Gerüche) an der Quelle. Erhältlich in Basis- und Premium-Ausführung.',
		'category'    => 'Industrielle Luftfiltration',
		'url'         => $emifree_url_de,
		'inLanguage'  => 'de-DE',
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
		array( 'name' => 'Startseite',             'url' => home_url( '/de/' ) ),
		array( 'name' => 'Produkte',               'url' => home_url( '/de/#produkte' ) ),
		array( 'name' => 'Elektrostatische Filtration', 'url' => $emifree_url_de ),
	),
	array(
		'de'        => $emifree_url_de,
		'en'        => $emifree_url_en,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-electrostatic-de.php';

get_footer();
