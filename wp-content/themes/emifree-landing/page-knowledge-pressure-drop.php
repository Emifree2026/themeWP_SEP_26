<?php
/**
 * Page template: /air-pressure-loss-calculator/  (legacy alias: /knowledge/pressure-drop/)
 * Renders the Air Pressure Loss Calculator (English).
 *
 * The canonical URL is /air-pressure-loss-calculator/ — the keyword-rich
 * slug that matches the dominant search query. The legacy
 * /knowledge/pressure-drop/ URL 301-redirects here so existing links
 * don't break (handler: emifree_maybe_redirect_legacy_url()).
 *
 * Mirrors page-knowledge-ductulator.php's shim pattern: enqueues the
 * section script, registers per-page SEO + JSON-LD (WebApplication +
 * FAQPage), delegates the body to the template part.
 */

require_once get_template_directory() . '/inc/i18n.php';

// Enqueue the per-section script.
emifree_enqueue_section_script( 'pressure-drop' );

// Per-page SEO meta + JSON-LD. Title and description lead with the
// primary search term "air pressure loss" so the page ranks for the
// "air pressure loss calculator", "air pressure loss", "HVAC duct
// pressure loss", "fan ΔP calculator" cluster. Two schemas are emitted:
// WebApplication (with alternateName array for synonym matching) +
// FAQPage (questions rendered in the body, paired 1:1 with the JSON-LD
// below — keep them in sync if you edit either side).
emifree_seo_page(
	'Air Pressure Loss Calculator — HVAC Duct, Fan & Industrial ΔP (Free)',
	'Air pressure loss calculator for HVAC ducts, fans, and industrial extraction. Compute friction loss + K-factor losses for elbows, T-junctions, and reducers using Darcy-Weisbach + ASHRAE. Free, no signup. Includes oil-mist and dust correction.',
	home_url( '/air-pressure-loss-calculator' ),
	array(
		array(
			'id'   => 'emifree-knowledge-air-pressure-loss-schema',
			'data' => array(
				'@context'            => 'https://schema.org',
				'@type'               => 'WebApplication',
				'name'                => 'Emifree Air Pressure Loss Calculator',
				'alternateName'       => array(
					'Pressure Drop Calculator',
					'Duct Pressure Loss Calculator',
					'Air Pressure Drop Calculator',
					'HVAC Static Pressure Calculator',
					'Fan ΔP Calculator',
					'ΔP Calculator',
				),
				'description'         => 'Compute air pressure loss for HVAC duct runs with fittings. Darcy-Weisbach + ASHRAE K-factor library.',
				'url'                 => home_url( '/air-pressure-loss-calculator' ),
				'applicationCategory' => 'UtilitiesApplication',
				'operatingSystem'     => 'Any (browser-based)',
				'publisher'           => array(
					'@type' => 'Organization',
					'name'  => 'Emifree GmbH',
					'url'   => home_url(),
				),
			),
		),
		array(
			'id'   => 'emifree-knowledge-air-pressure-loss-faq-schema',
			'data' => array(
				'@context'    => 'https://schema.org',
				'@type'       => 'FAQPage',
				'mainEntity'  => array(
					array(
						'@type'          => 'Question',
						'name'           => 'What is air pressure loss?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Air pressure loss (also called air pressure drop or duct pressure loss) is the reduction in static pressure as air flows through a duct, fitting, filter, or other component. It is measured in pascals (Pa) and is the single most important factor when sizing a fan or extractor for an HVAC, oil-mist, or dust-collection system. Pressure loss comes from two sources: friction along straight duct walls and minor (fitting) losses at elbows, branches, transitions, and filters.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'How do I calculate air pressure loss in a duct?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Air pressure loss is the sum of friction loss in straight ducts (Darcy-Weisbach, calculated with the Swamee-Jain friction factor) plus the K-factor losses of every fitting in the run (90° elbow K ≈ 0.18, 45° elbow K ≈ 0.20, T-junction K ≈ 1.20, Y-connector K ≈ 0.60, reducer K ≈ 0.10). For oil-mist extraction multiply the total by 1.15, for dust collection multiply by 1.25, then double the result for fan safety margin.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'What is the difference between air pressure loss and air pressure drop?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'There is no physical difference — both terms describe the same quantity (static-pressure reduction, in Pa). "Pressure drop" is the engineering / ASHRAE term; "pressure loss" is the phrasing used by HVAC installers, ductwork suppliers, and most European industrial catalogues. Search engines and supplier documentation mix the two freely; this calculator handles both, and the methodology treats them as identical.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'What is a normal air pressure loss for an HVAC duct?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'For a typical galvanized HVAC supply duct at 1,500 m³/h, expect roughly 1 Pa per metre of straight duct (200 mm diameter, f ≈ 0.02) plus 5-12 Pa per 90° elbow and 30-70 Pa per T-branch. ASHRAE recommends a target friction rate of 0.8-1.2 Pa/m for low-pressure mains. For industrial oil-mist and dust extraction, total static pressure is usually 800-2,500 Pa once filter and cyclone losses are added.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'What K-factor should I use for a 90° elbow?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'It depends on the elbow geometry. Common ASHRAE / Idelchik values: die-stamped 90° elbow (r/D = 1.5) → K = 0.18; mitered 90° without vanes → K = 1.3; mitered 90° with single vane → K = 0.5; smooth-radius 90° (r/D = 1.0) → K = 0.23. This calculator uses the die-stamped r/D = 1.5 value of 0.18, which is the most common HVAC fitting.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'How do I size a fan for my duct?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Two numbers: airflow (m³/h) and static pressure (Pa). The airflow is set by the application — for oil-mist, 1,500-2,500 m³/h per CNC; for dust, 2,000-5,000 m³/h per cell. The static pressure is the duct pressure loss from this calculator, plus filter and cyclone loss (typically 500-1,500 Pa for an oil-mist filter cartridge). Industry practice adds a 2× safety margin on top — this calculator already applies that.',
						),
					),
				),
			),
		),
	),
	// hreflang alternates — point at the EN canonical (self) and the
	// DE sibling. x-default is emitted by emifree_seo_page() as the
	// EN canonical itself.
	array(
		'en' => home_url( '/air-pressure-loss-calculator' ),
		'de' => home_url( '/de/luftdruckverlust-rechner' ),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-pressure-drop.php';

get_footer();
