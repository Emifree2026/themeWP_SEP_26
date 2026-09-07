<?php
/**
 * Page template: /de/wissen/downloads/
 *
 * Deutsche Variante von page-knowledge-downloads.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar. Listet die gleichen
 * PDF-Broschüren wie die EN-Version; für DE wird der deutsche
 * ECO-AIR-Katalog verlinkt.
 *
 * Rendert template-parts/page-knowledge-downloads-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/downloads/' );
$emifree_url_de = home_url( '/de/wissen/downloads/' );

emifree_seo_page_with_breadcrumb(
	'Produktbroschüren, Emifree PDF-Bibliothek',
	'Emifree-Produktbroschüren, technische Datenblätter und Gesamtkataloge als PDF herunterladen. ECO-AIR-Reiniger-Katalog (DE + EN) jetzt verfügbar, weitere Kataloge folgen.',
	$emifree_url_de,
	'emifree-knowledge-downloads-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Produktbroschüren und PDFs',
		'description' => 'Herunterladbare Emifree-Produktbroschüren, technische Datenblätter und Gesamtkataloge.',
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
		array( 'name' => 'Downloads',  'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-downloads-de.php';

get_footer();
