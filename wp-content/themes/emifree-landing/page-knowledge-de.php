<?php
/**
 * Page template: /de/wissen/
 * Renders the Knowledge hub (German).
 *
 * Mirrors page-blog-de.php's per-page SEO pattern with German
 * strings + 'inLanguage' => 'de-DE' on the JSON-LD.
 */

require_once get_template_directory() . '/inc/i18n.php';

emifree_seo_page_with_schema(
	'Wissen — Technische Werkzeuge & Referenzen',
	'HLK-Kanalauslegungswerkzeuge, Dimensionierungsreferenzen und technische Anleitungen für industrielle Luftfiltration und Lüftung.',
	home_url( '/de/wissen' ),
	'emifree-knowledge-schema-de',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'CollectionPage',
		'name'        => 'Emifree Wissen',
		'description' => 'Technische Werkzeuge, Referenzen und Praxisanleitungen für HLK-Kanalauslegung und Luftfiltration.',
		'url'         => home_url( '/de/wissen' ),
		'inLanguage'  => 'de-DE',
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-index-de.php';

get_footer();