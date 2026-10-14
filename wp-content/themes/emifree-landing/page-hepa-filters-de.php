<?php
/**
 * Page template: /de/wissen/hepa-filter-cnc-industrielle-werkstaetten/
 *
 * Deutsche Variante von page-hepa-filters.php. Eigene URL,
 * Canonical, BreadcrumbList und hreflang-Paar. Verwendet die
 * Inhalte aus template-parts/page-hepa-filters-de.php.
 *
 * Hinweis zum Slug: ASCII-Konvention wie /de/wissen/ueber-uns/,
 * damit Umlaute in der URL keine Copy/Paste- oder
 * Analytics-Probleme verursachen. Der ausgelieferte Title zeigt
 * weiterhin "HEPA-Filter in CNC- & Industriewerkstätten".
 *
 * ----- ÜBERSETZUNGSHINWEIS -----
 * Die DE-Texte sind auto-übersetzt (Stand 2026-10-14) und
 * müssen vor der öffentlichen Veröffentlichung redaktionell
 * gegengelesen werden. Siehe Hinweis oben in
 * template-parts/page-hepa-filters-de.php.
 *
 * Renders template-parts/page-hepa-filters-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/hepa-filters-cnc-industrial-workshops/' );
$emifree_url_de = home_url( '/de/wissen/hepa-filter-cnc-industrielle-werkstaetten/' );

emifree_seo_page_with_breadcrumb(
	'HEPA-Filter in CNC- & Industriewerkstätten: Sicherheits-Leitfaden',
	'Lernen Sie, wie HEPA-Filter Feinstaub in CNC- und Industriewerkstätten reduzieren — inklusive Grenzen, Auswahl-Tipps und Sicherheitshinweisen zu brennbarem Staub.',
	$emifree_url_de,
	'emifree-knowledge-hepa-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Article',
		'headline'    => 'HEPA-Filter in CNC- & Industriewerkstätten: Einsatz, Grenzen & Sicherheit',
		'description' => 'Lernen Sie, wie HEPA-Filter Feinstaub in CNC- und Industriewerkstätten reduzieren — inklusive Grenzen, Auswahl-Tipps und Sicherheitshinweisen zu brennbarem Staub.',
		'url'         => $emifree_url_de,
		'inLanguage'  => 'de-DE',
		'articleSection' => 'Wissen',
		'about'       => array(
			'@type' => 'Thing',
			'name'  => 'HEPA-Filtration in CNC- und Industriewerkstätten',
		),
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Startseite', 'url' => home_url( '/de/' ) ),
		array( 'name' => 'Wissen',     'url' => home_url( '/de/wissen/' ) ),
		array( 'name' => 'HEPA-Filter', 'url' => $emifree_url_de ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-hepa-filters-de.php';

get_footer();
