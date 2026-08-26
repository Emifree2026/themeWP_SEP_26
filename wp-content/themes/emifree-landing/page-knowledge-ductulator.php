<?php
/**
 * Page template: /knowledge/ductulator/
 * Renders the Ductulator tool (English).
 *
 * Mirrors the blog-post shim pattern: enqueues the section script,
 * registers per-page SEO, then delegates the body to the template
 * part. The dispatcher in functions.php routes this template when
 * the URL is /knowledge/{slug}/ and the language is English.
 *
 * No slug 404 here — at the moment the only known slug is
 * `ductulator`, and any other slug will simply render an empty
 * page (the template part will fall back to "No tool found").
 * Future tools add their own slugs here.
 */

require_once get_template_directory() . '/inc/i18n.php';

$emifree_requested_slug = get_query_var( 'emifree_knowledge_slug' );

// Only one tool ships today. Add cases as new tools are added.
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
	echo '<h1>Tool not found</h1><p><a href="' . esc_url( home_url( '/knowledge/' ) ) . '">Back to Knowledge</a></p>';
	exit;
}

// Enqueue the per-section script (matches existing pattern used by
// every template-part — the helper silently no-ops if the file is
// missing, so this is safe before the script lands).
emifree_enqueue_section_script( 'ductulator' );

// Per-page SEO meta + JSON-LD. Description focuses on the tool's
// engineering methodology (Darcy-Weisbach / Swamee-Jain / ASHRAE) so
// the page has a useful snippet in search results.
emifree_seo_page_with_schema(
	'Duct Sizing Calculator — Round & Rectangular HVAC Ducts',
	'Size round or rectangular HVAC ducts from airflow, friction rate, or velocity. Uses Darcy-Weisbach, Swamee-Jain, and ASHRAE equivalent-diameter methods. Imperial and metric.',
	home_url( '/knowledge/ductulator' ),
	'emifree-knowledge-ductulator-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebApplication',
		'name'        => 'Emifree Duct Sizing Calculator',
		'description' => 'Size round or rectangular HVAC ducts from airflow, friction rate, or velocity.',
		'url'         => home_url( '/knowledge/ductulator' ),
		'applicationCategory' => 'UtilitiesApplication',
		'operatingSystem'     => 'Any (browser-based)',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-ductulator.php';

get_footer();