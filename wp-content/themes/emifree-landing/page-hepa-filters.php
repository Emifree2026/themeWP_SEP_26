<?php
/**
 * Page template: /en/knowledge/hepa-filters-cnc-industrial-workshops/
 *
 * Own landing page for the HEPA Filters in CNC & Industrial
 * Workshops editorial article. Source content is
 * HEPA_SECTIONMD.md (supplied 2026-10-14). The page reuses the
 * dust product page's hero layout (3-photo gallery + title + CTA
 * + 4-item feature intro) for visual consistency with the rest
 * of the Knowledge hub, then adds 5 H2 sections of editorial
 * copy + a final CTA.
 *
 * URL choice: routed as a Knowledge sub-section (same shape as
 * the existing /knowledge/insights/, /knowledge/about/,
 * /knowledge/downloads/, /knowledge/tools/ landing pages) rather
 * than as a sibling of /products/{slug}/. Rationale: the article
 * is editorial / informational (best uses, limitations,
 * selection, safety), not a product spec sheet. The Knowledge
 * subtree is the existing SEO cluster for this kind of content,
 * so a sub-section there inherits the existing internal-link
 * weight and matches user expectations set by the
 * /knowledge/about/ page (which the EN sub-nav links to from
 * the home page).
 *
 * Cross-link from the principal hero chip: the main
 * /en/ hero's "HEPA filter" chip now points to this URL. The DE
 * chip points to /de/wissen/hepa-filter-cnc-industrielle-werkstaetten/
 * via a parallel rewrite rule.
 *
 * Renders template-parts/page-hepa-filters.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/i18n.php';

$emifree_url_en = home_url( '/en/knowledge/hepa-filters-cnc-industrial-workshops/' );
$emifree_url_de = home_url( '/de/wissen/hepa-filter-cnc-industrielle-werkstaetten/' );

emifree_seo_page_with_breadcrumb(
	'HEPA Filters in CNC & Industrial Workshops: Safety Guide',
	'Learn how HEPA filters help control fine dust in CNC and industrial workshops, plus key limitations, selection tips, and combustible dust safety.',
	$emifree_url_en,
	'emifree-knowledge-hepa-schema',
	array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Article',
		'headline'    => 'HEPA Filters in CNC & Industrial Workshops: Uses, Limits & Safety',
		'description' => 'Learn how HEPA filters help control fine dust in CNC and industrial workshops, plus key limitations, selection tips, and combustible dust safety.',
		'url'         => $emifree_url_en,
		'inLanguage'  => 'en-US',
		'articleSection' => 'Knowledge',
		'about'       => array(
			'@type' => 'Thing',
			'name'  => 'HEPA filtration in CNC and industrial workshops',
		),
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => 'Emifree GmbH',
			'url'   => home_url(),
		),
	),
	array(
		array( 'name' => 'Home',      'url' => home_url( '/en/' ) ),
		array( 'name' => 'Knowledge', 'url' => home_url( '/en/knowledge/' ) ),
		array( 'name' => 'HEPA Filters', 'url' => $emifree_url_en ),
	),
	array(
		'en'        => $emifree_url_en,
		'de'        => $emifree_url_de,
		'x-default' => $emifree_url_en,
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-hepa-filters.php';

get_footer();
