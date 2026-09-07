<?php
/**
 * Page template: /en/knowledge/about/
 *
 * Crawlable EN landing for the Knowledge hub's "About Us" tab.
 * Own URL + canonical + BreadcrumbList + hreflang pair. Shares the
 * same template-part as the DE twin (/de/wissen/ueber-uns/) which
 * keeps the visual structure aligned while the copy is translated
 * inline via a lang switch on partial includes.
 *
 * Renders template-parts/page-knowledge-about.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/about/' );
$emifree_url_de = home_url( '/de/wissen/ueber-uns/' );

emifree_seo_page_with_breadcrumb(
	'About Emifree, Low-maintenance Air Filtration Since 2010',
	'Emifree GmbH engineers self-cleaning air filtration systems from Berlin. Founded 2010, serving 500+ clients in 15+ countries. Our mission, our values, and the partners we serve.',
	$emifree_url_en,
	'emifree-knowledge-about-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'AboutPage',
		'name'        => 'About Emifree GmbH',
		'description' => 'Emifree GmbH engineers self-cleaning air filtration systems from Berlin since 2010.',
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
		array( 'name' => 'About Us',  'url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-about.php';

get_footer();
