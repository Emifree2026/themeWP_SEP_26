<?php
/**
 * Page template: /de/produkte/mechanische-filtration/
 *
 * Deutsche Variante von page-products-mechanical.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar. Rendert Galerie,
 * Abmessungen, Spezifikation und Broschüre für die mechanische
 * ECO-AIR-Reiniger-Linie.
 *
 * Renders template-parts/page-products-mechanical-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_de = home_url( '/de/produkte/mechanische-filtration/' );
$emifree_url_en = home_url( '/en/products/mechanical/' );

emifree_seo_page_with_breadcrumb(
	'Mechanische Ölnebelfiltration — ECO AIR Cleaner · Emifree',
	'Industrielle Ölnebelabscheidung für die CNC-Zerspanung. Selbstreinigende mechanische Filtration mit optionalem HEPA. Spezifikationen, Abmessungen und Broschüren-Downloads.',
	$emifree_url_de,
	'emifree-products-mechanical-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'ECO AIR Cleaner — Mechanische Ölnebelabscheidung',
		'description' => 'Selbstreinigende mechanische Filtrationsanlage, die Ölnebel und Kühlschmierstoffdämpfe direkt an der Quelle abscheidet, für anspruchsvolle CNC-Zerspanungsumgebungen.',
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
		array( 'name' => 'Startseite',               'url' => home_url( '/de/' ) ),
		array( 'name' => 'Produkte',                 'url' => home_url( '/de/#produkte' ) ),
		array( 'name' => 'Mechanische Filtration',   'url' => $emifree_url_de ),
	),
	array(
		'de'        => $emifree_url_de,
		'en'        => $emifree_url_en,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-mechanical-de.php';

get_footer();
