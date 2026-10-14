<?php
/**
 * Page template: /de/produkte/entstaubung/
 *
 * Deutsche Variante von page-products-dust.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar. Rendert
 * template-parts/page-products-dust-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/products/dust/' );
$emifree_url_de = home_url( '/de/produkte/entstaubung/' );

emifree_seo_page_with_breadcrumb(
	'Staubfiltration — Staub direkt an der Quelle stoppen · Emifree',
	'Emifree Staubfiltration für Holz, Metall, Mineralien und lebensmittelechte Pulver. Selbstreinigende Jet-Pulse-Patronen, Frequenzumrichter-Luftstromregelung, optionaler ATEX-Explosionsschutz.',
	$emifree_url_de,
	'emifree-products-dust-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => 'Emifree Staubfiltrationssystem',
		'description' => 'Industrielle Staubabscheidung mit selbstreinigenden Jet-Pulse-Patronen, Frequenzumrichter (FC)-Luftstromregelung und optionalem ATEX-Schutz für Holz-, Metall-, Mineral- und Lebensmittelanwendungen.',
		'category'    => 'Industrielle Staubabscheidung',
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
		array( 'name' => 'Startseite', 'url' => home_url( '/de/' ) ),
		array( 'name' => 'Produkte',   'url' => home_url( '/de/#products' ) ),
		array( 'name' => 'Staub',      'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-products-dust-de.php';

get_footer();
