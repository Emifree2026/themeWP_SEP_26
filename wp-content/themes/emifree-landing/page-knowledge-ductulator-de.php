<?php
/**
 * Page template: /de/wissen/ductulator/
 * Renders the Ductulator tool (German).
 *
 * Mirrors page-knowledge-ductulator.php with German strings +
 * hreflang wiring. The dispatcher routes this template when the URL
 * is /de/wissen/{slug}/ and the language is German.
 */

require_once get_template_directory() . '/inc/i18n.php';

$emifree_requested_slug = get_query_var( 'emifree_knowledge_slug' );

$emifree_known_tools = array( 'ductulator' );

if ( ! in_array( $emifree_requested_slug, $emifree_known_tools, true ) ) {
	$emifree_404 = locate_template( '404.php' );
	if ( $emifree_404 ) {
		status_header( 404 );
		include $emifree_404;
		exit;
	}
	status_header( 404 );
	nocache_headers();
	echo '<h1>Werkzeug nicht gefunden</h1><p><a href="' . esc_url( home_url( '/de/wissen/' ) ) . '">Zurück zu Wissen</a></p>';
	exit;
}

emifree_enqueue_section_script( 'ductulator' );

emifree_seo_page_with_schema(
	'Kanalrechner — Runde & rechteckige HLK-Kanäle',
	'Dimensionieren Sie runde oder rechteckige HLK-Kanäle aus Luftstrom, Reibungsverlust oder Geschwindigkeit. Verwendet Darcy-Weisbach, Swamee-Jain und ASHRAE-Äquivalentdurchmesser. Imperial und metrisch.',
	home_url( '/de/wissen/ductulator' ),
	'emifree-knowledge-ductulator-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebApplication',
		'name'        => 'Emifree Kanalrechner',
		'description' => 'Dimensionierung runder und rechteckiger HLK-Kanäle aus Luftstrom, Reibungsverlust oder Geschwindigkeit.',
		'url'         => home_url( '/de/wissen/ductulator' ),
		'applicationCategory' => 'UtilitiesApplication',
		'operatingSystem'     => 'Beliebig (browserbasiert)',
		'inLanguage'          => 'de-DE',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-ductulator-de.php';

get_footer();