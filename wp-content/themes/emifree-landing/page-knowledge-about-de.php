<?php
/**
 * Page template: /de/wissen/ueber-uns/
 *
 * Deutsche Variante von page-knowledge-about.php (About Us). Eigene
 * URL, Canonical, BreadcrumbList und hreflang-Paar.
 *
 * Hinweis zum Slug: "ueber-uns" statt "uber-uns" (ASCII-Sicherheit),
 * die Umlaut-Transliteration würde sonst Rewrite-Probleme verursachen.
 * Der ausgelieferte Title zeigt weiterhin "Über uns".
 *
 * Rendert template-parts/page-knowledge-about-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/about/' );
$emifree_url_de = home_url( '/de/wissen/ueber-uns/' );

emifree_seo_page_with_breadcrumb(
	'Über uns, Wartungsarme Luftfiltration seit 2010',
	'Emifree GmbH entwickelt selbstreinigende Luftfiltrationssysteme aus Berlin. Gegründet 2010, 500+ Kunden in 15+ Ländern. Unsere Mission, unsere Werte und die Partner, denen wir vertrauen.',
	$emifree_url_de,
	'emifree-knowledge-about-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'AboutPage',
		'name'        => 'Über Emifree GmbH',
		'description' => 'Emifree GmbH entwickelt selbstreinigende Luftfiltrationssysteme aus Berlin seit 2010.',
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
		array( 'name' => 'Über uns',   'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-about-de.php';

get_footer();
