<?php
/**
 * Page template: /de/luftdruckverlust-rechner/  (legacy alias: /de/wissen/druckverlust/)
 * Renders the Luftdruckverlust-Rechner (Pressure Drop Calculator, German).
 *
 * The canonical URL is /de/luftdruckverlust-rechner/ — the keyword-rich
 * slug. The legacy /de/wissen/druckverlust/ URL 301-redirects here.
 *
 * Mirrors page-knowledge-pressure-drop.php's shim pattern with German
 * strings + hreflang wiring.
 */

require_once get_template_directory() . '/inc/i18n.php';

emifree_enqueue_section_script( 'pressure-drop' );

emifree_seo_page(
	'Luftdruckverlust-Rechner — HVAC-Kanäle, Ventilatoren & Industrie-ΔP (Kostenlos)',
	'Luftdruckverlust-Rechner für HVAC-Kanäle, Ventilatoren und industrielle Absauganlagen. Berechnen Sie Reibungsverlust + K-Faktor-Verluste für Bögen, T-Stücke und Reduzierstücke nach Darcy-Weisbach + ASHRAE. Kostenlos, ohne Anmeldung. Inkl. Ölnebel- und Staub-Korrektur.',
	home_url( '/de/luftdruckverlust-rechner' ),
	array(
		array(
			'id'   => 'emifree-knowledge-luftdruckverlust-schema',
			'data' => array(
				'@context'            => 'https://schema.org',
				'@type'               => 'WebApplication',
				'name'                => 'Emifree Luftdruckverlust-Rechner',
				'alternateName'       => array(
					'Druckverlust-Rechner',
					'Kanal-Druckverlust-Rechner',
					'Luft-Druckabfall-Rechner',
					'HVAC-Statikdruck-Rechner',
					'Ventilator-ΔP-Rechner',
					'ΔP-Rechner',
				),
				'description'         => 'Berechnung des Luftdruckverlusts für HVAC-Kanäle mit Formstücken. Darcy-Weisbach + ASHRAE K-Faktor-Bibliothek.',
				'url'                 => home_url( '/de/luftdruckverlust-rechner' ),
				'applicationCategory' => 'UtilitiesApplication',
				'operatingSystem'     => 'Beliebig (browserbasiert)',
				'inLanguage'          => 'de-DE',
				'publisher'           => array(
					'@type' => 'Organization',
					'name'  => 'Emifree GmbH',
					'url'   => home_url(),
				),
			),
		),
		array(
			'id'   => 'emifree-knowledge-luftdruckverlust-faq-schema',
			'data' => array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => array(
					array(
						'@type'          => 'Question',
						'name'           => 'Was ist Luftdruckverlust?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Luftdruckverlust (auch Druckabfall oder Kanal-Druckverlust) bezeichnet die Abnahme des statischen Drucks, wenn Luft durch ein Kanalstück, ein Formstück, einen Filter oder eine andere Komponente strömt. Gemessen wird er in Pascal (Pa) — er ist die wichtigste Größe bei der Auslegung eines Ventilators oder einer Absauganlage für HVAC, Ölnebel- oder Staubabsaugung.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'Wie berechne ich den Luftdruckverlust in einem Kanal?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Der Luftdruckverlust ist die Summe aus Reibungsverlust in geraden Rohren (Darcy-Weisbach, berechnet mit dem Swamee-Jain-Reibungsfaktor) und den K-Faktor-Verlusten jedes Formstücks im Strang (90°-Bogen K ≈ 0,18, 45°-Bogen K ≈ 0,20, T-Stück K ≈ 1,20, Y-Stück K ≈ 0,60, Reduzierstück K ≈ 0,10). Für Ölnebel-Absaugung multiplizieren Sie die Summe mit 1,15, für Staubabsaugung mit 1,25.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'Was ist der Unterschied zwischen Luftdruckverlust und Luftdruckabfall?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Es gibt keinen physikalischen Unterschied — beide Begriffe beschreiben dieselbe Größe (Abnahme des statischen Drucks in Pa). „Druckverlust" ist die deutsche Standardbezeichnung nach DIN / VDI; „Druckabfall" ist die wörtliche Übersetzung von „pressure drop" aus dem englischsprachigen ASHRAE-Standard.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'Was ist ein normaler Luftdruckverlust für einen HVAC-Kanal?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Für einen typischen verzinkten HVAC-Versorgungskanal bei 1.500 m³/h ist mit etwa 1 Pa pro Meter geradem Kanal zu rechnen (200 mm Durchmesser, f ≈ 0,02) plus 5-12 Pa pro 90°-Bogen und 30-70 Pa pro T-Abzweig. ASHRAE empfiehlt eine Reibungsrate von 0,8-1,2 Pa/m für Niederdruck-Hauptkanäle.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'Welchen K-Faktor soll ich für einen 90°-Bogen verwenden?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Das hängt von der Bogen-Geometrie ab. Übliche ASHRAE / Idelchik-Werte: tiefgezogener 90°-Bogen (r/D = 1,5) → K = 0,18; gegrateter 90°-Bogen ohne Leitschaufeln → K = 1,3; gegrateter 90°-Bogen mit Einzelleitschaufel → K = 0,5; Glattradius 90° (r/D = 1,0) → K = 0,23.',
						),
					),
					array(
						'@type'          => 'Question',
						'name'           => 'Wie dimensioniere ich einen Ventilator für meinen Kanal?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => 'Zwei Größen sind nötig: Luftstrom (m³/h) und Statikdruck (Pa). Der Luftstrom wird durch die Anwendung bestimmt — bei Ölnebel 1.500-2.500 m³/h pro CNC, bei Staub 2.000-5.000 m³/h pro Zelle. Der Statikdruck ist der Kanal-Druckverlust aus diesem Rechner, plus Filter- und Zyklonverlust (typisch 500-1.500 Pa).',
						),
					),
				),
			),
		),
	),
	// hreflang alternates — point at the DE canonical (self) and the
	// EN sibling. x-default is emitted by emifree_seo_page() as the
	// DE canonical itself.
	array(
		'en' => home_url( '/air-pressure-loss-calculator' ),
		'de' => home_url( '/de/luftdruckverlust-rechner' ),
	)
);

get_header();

require_once get_template_directory() . '/template-parts/page-knowledge-druckverlust-de.php';

get_footer();
