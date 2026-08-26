<?php
/**
 * Page template: /knowledge/
 * Renders the Knowledge hub (English).
 *
 * Mirrors page-blog.php's per-page SEO pattern. No JS behaviors.
 */

require_once get_template_directory() . '/inc/i18n.php';

emifree_seo_page_with_schema(
	'Knowledge — Engineering Tools & References',
	'HVAC duct design tools, sizing references, and engineering guides for industrial air filtration and ventilation systems.',
	home_url( '/knowledge' ),
	'emifree-knowledge-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Emifree Knowledge',
		'description' => 'Engineering tools, references, and field guides for HVAC duct design and air filtration.',
		'url'         => home_url( '/knowledge' ),
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-index.php';

get_footer();