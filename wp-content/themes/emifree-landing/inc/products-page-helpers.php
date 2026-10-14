<?php
/**
 * Product-page helpers.
 *
 * Shared data + renderers for the per-product landing pages
 * (/products/{slug}/). Today only the Mechanical product page consumes
 * these; Electrostatic and Dust will reuse the same shapes (gallery +
 * specs rows) when those pages are built in follow-up sessions.
 *
 * Why a helper file:
 *   - Keeps the template-parts free of inline data arrays; the body
 *     template only iterates over rows and renders markup.
 *   - The "is this a 2-col or 3-col spec table" branching lives here,
 *     not in the template. The Mechanical page is 2-col (Advanced vs
 *     Premium + HEPA); future pages with single-version specs can
 *     call a different renderer or skip the columns argument.
 *   - emifree_products() (inc/products.php) stays the single source
 *     of truth for product metadata; this file is a thin facade.
 *
 * Conventions:
 *   - All file paths emitted in markup are template-relative
 *     (assets/products/{slug}/...), resolved with get_template_directory_uri().
 *   - Markup is echo'd as PHP, not concatenated strings, so editors
 *     see familiar WordPress escaping patterns (esc_attr, esc_html).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// emifree_products() is the canonical product-metadata array. The
// home-page section template (section-products.php) loads it via
// emifree_require_section_data('products'); on the product landing
// pages section-products.php is not in the request path, so the
// array isn't in scope. Require it here so this helper file can
// delegate to emifree_products() without the caller having to
// also require inc/products.php.
require_once __DIR__ . '/products.php';

if ( ! function_exists( 'emifree_get_mechanical_gallery' ) ) :
	/**
	 * Return the 3 mechanical product photos as [filename, alt] pairs.
	 *
	 * Uses the `*.original.webp` variants (fotom1.original.webp,
	 * fotom5.original.webp, fotom6.original.webp) rather than the
	 * compressed `*.webp` siblings. The originals are ~2x the byte
	 * size of the compressed ones (47 KB vs 22 KB, 49 KB vs 23 KB,
	 * 60 KB vs 25 KB) and noticeably crisper on the gallery's
	 * large-image role. The compressed `*.webp` files remain on disk
	 * for the home-page product card (where they're rendered at
	 * 800×1000 inside a 4:5 card, so the extra weight would be
	 * wasted) — see template-parts/section-products.php.
	 *
	 * The alt text is short (the page already names the product in
	 * the heading above the gallery; an empty alt would be equally
	 * valid, but a short label reads better in screen-reader
	 * announcement order).
	 *
	 * @return array<int, array{filename:string, alt:string}>
	 */
	function emifree_get_mechanical_gallery() {
		return array(
			array(
				'filename' => 'fotom1.original.webp',
				'alt'      => 'ECO AIR Cleaner, side view',
			),
			array(
				'filename' => 'fotom5.original.webp',
				'alt'      => 'ECO AIR Cleaner, control panel',
			),
			array(
				'filename' => 'fotom6.original.webp',
				'alt'      => 'ECO AIR Cleaner, installed',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_specs_rows' ) ) :
	/**
	 * Return the mechanical specs table as [label, advanced, premium] triples.
	 *
	 * The user-provided source for the EN copy is
	 * C:\Users\vpedr\Downloads\mechanical_product_v1.md; the DE
	 * copy is the German sibling supplied in 2026-10-12. Both
	 * languages describe the same product and have the same row
	 * order; only the labels and unit-localised values differ
	 * (e.g. "1.5 kW" → "1,5 kW", "L×W×H" → "L×B×H").
	 *
	 * Where the source has "–" / "—" (em dash) for one version,
	 * the corresponding cell is "—" in the table.
	 *
	 * Same value in both columns → repeated in both cells, not
	 * collapsed to "same as left". Scannability wins over
	 * column-density for a comparison table.
	 *
	 * @param string $emifree_lang  'en' (default) or 'de'.
	 * @return array<int, array{label:string, advanced:string, premium:string}>
	 */
	function emifree_get_mechanical_specs_rows( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return array(
				array(
					'label'    => 'Bezeichnung',
					'advanced' => 'EAC12-2 / EAC15-2 + CS-X-X',
					'premium'  => 'EAC12-2 / EAC15-2 + CS-C-F',
				),
				array(
					'label'    => 'Abmessungen [L×B×H]',
					'advanced' => '818 × 466 × 566 mm',
					'premium'  => '818 × 470 × 961 mm',
				),
				array(
					'label'    => 'Luftleistung',
					'advanced' => 'bis zu 1200 / 1500 m³/h',
					'premium'  => '—',
				),
				array(
					'label'    => 'Elektrik',
					'advanced' => '3-Ph. 400 V · 50/60 Hz',
					'premium'  => '3-Ph. 400 V · 50/60 Hz',
				),
				array(
					'label'    => 'Leistung',
					'advanced' => '1,5 kW (IE3)',
					'premium'  => '1,5 kW (IE3)',
				),
				array(
					'label'    => 'Stromstärke',
					'advanced' => '2,3 A',
					'premium'  => '2,3 A',
				),
				array(
					'label'    => 'Schutzart',
					'advanced' => 'IP54',
					'premium'  => 'IP54',
				),
				array(
					'label'    => 'Schallpegel',
					'advanced' => '70 dB',
					'premium'  => '70 dB',
				),
				array(
					'label'    => 'Rohranschluss',
					'advanced' => 'DN 200 mm (opt. DN 150 mm)',
					'premium'  => 'DN 200 mm (opt. DN 150 mm)',
				),
				array(
					'label'    => 'Standardfarbe',
					'advanced' => 'RAL 7035 (opt. weitere RAL-Farben)',
					'premium'  => 'RAL 7035 (opt. weitere RAL-Farben)',
				),
				array(
					'label'    => 'Gewicht',
					'advanced' => '95 / 96 kg',
					'premium'  => '110 / 111 kg + 20 kg',
				),
				array(
					'label'    => 'Vorfilter',
					'advanced' => '✓',
					'premium'  => '✓',
				),
				array(
					'label'    => 'Reinigungssystem',
					'advanced' => '✓',
					'premium'  => '✓',
				),
				array(
					'label'    => 'Erweitertes Steuerungssystem',
					'advanced' => '—',
					'premium'  => '✓',
				),
				array(
					'label'    => 'Frequenzumrichter',
					'advanced' => '—',
					'premium'  => '✓',
				),
			);
		}

		return array(
			array(
				'label'    => 'Designation',
				'advanced' => 'EAC12-2 / EAC15-2 + CS-X-X',
				'premium'  => 'EAC12-2 / EAC15-2 + CS-C-F',
			),
			array(
				'label'    => 'Dimensions [L×W×H]',
				'advanced' => '818 × 466 × 566 mm',
				'premium'  => '818 × 470 × 961 mm',
			),
			array(
				'label'    => 'Airflow',
				'advanced' => 'up to 1200 / 1500 m³/h',
				'premium'  => '—',
			),
			array(
				'label'    => 'Electrical',
				'advanced' => '3-Ph. 400 V · 50/60 Hz',
				'premium'  => '3-Ph. 400 V · 50/60 Hz',
			),
			array(
				'label'    => 'Power',
				'advanced' => '1.5 kW (IE3)',
				'premium'  => '1.5 kW (IE3)',
			),
			array(
				'label'    => 'Current',
				'advanced' => '2.3 A',
				'premium'  => '2.3 A',
			),
			array(
				'label'    => 'Protection class',
				'advanced' => 'IP54',
				'premium'  => 'IP54',
			),
			array(
				'label'    => 'Noise level',
				'advanced' => '70 dB',
				'premium'  => '70 dB',
			),
			array(
				'label'    => 'Pipe connection',
				'advanced' => 'DN 200 mm (opt. DN 150 mm)',
				'premium'  => 'DN 200 mm (opt. DN 150 mm)',
			),
			array(
				'label'    => 'Standard color',
				'advanced' => 'RAL 7035 (opt. other RAL colors)',
				'premium'  => 'RAL 7035 (opt. other RAL colors)',
			),
			array(
				'label'    => 'Weight',
				'advanced' => '95 / 96 kg',
				'premium'  => '110 / 111 kg + 20 kg',
			),
			array(
				'label'    => 'Pre-filter',
				'advanced' => '✓',
				'premium'  => '✓',
			),
			array(
				'label'    => 'Cleaning system',
				'advanced' => '✓',
				'premium'  => '✓',
			),
			array(
				'label'    => 'Advanced control system',
				'advanced' => '—',
				'premium'  => '✓',
			),
			array(
				'label'    => 'Frequency converter',
				'advanced' => '—',
				'premium'  => '✓',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_performance_curves' ) ) :
	/**
	 * Return the ECO AIR Cleaner performance-curve images as
	 * [filename, alt, label] triples.
	 *
	 * Two variants are shipped: the 1200 m³/h unit
	 * (EAC12-2 + CS-X-X, "Advanced") and the 1500 m³/h unit
	 * (EAC15-2 + CS-X-X, also "Advanced" but with a higher
	 * motor output — see the Airflow row of
	 * emifree_get_mechanical_specs_rows(), which lists both
	 * 1200 and 1500 m³/h under the Advanced column). The
	 * Premium + HEPA variant ships with no published curve
	 * (its variable-speed drive lets the customer pick any
	 * operating point between the two).
	 *
	 * Two language variants exist (EN / DE) because the
	 * source drawings have language-specific axis labels
	 * ("PERFORMANCE CURVE" + "PRESSURE [Pa]" + "VOLUME FLOW
	 * [m³/h]" for EN, "LEISTUNGSKURVE" + "DRUCK [Pa]" +
	 * "VOLUMENSTROM [m³/h]" for DE). The image pixels are
	 * identical except for the German axis text overlay.
	 *
	 * The `label` slot is the small caption rendered below
	 * each image ("1200 m³/h" / "1500 m³/h") so the user
	 * knows which curve corresponds to which variant without
	 * having to read the axis text.
	 *
	 * Source files (in C:\Users\vpedr\Downloads\):
	 *   - performance1200-removebg-preview.png (EN 1200)
	 *   - performance1500-removebg-preview.png (EN 1500)
	 *   - Leistungskurve1200-removebg-preview.png (DE 1200)
	 *   - Leistungskurve1500-removebg-preview.png (DE 1500)
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array<int, array{filename:string, alt:string, label:string}>
	 */
	function emifree_get_mechanical_performance_curves( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return array(
				array(
					'filename' => 'performance-1200-de.png',
					'alt'      => 'ECO AIR Cleaner Leistungskurve, 1200 m³/h Variante',
					'label'    => '1200 m³/h',
				),
				array(
					'filename' => 'performance-1500-de.png',
					'alt'      => 'ECO AIR Cleaner Leistungskurve, 1500 m³/h Variante',
					'label'    => '1500 m³/h',
				),
			);
		}
		return array(
			array(
				'filename' => 'performance-1200-en.png',
				'alt'      => 'ECO AIR Cleaner performance curve, 1200 m³/h variant',
				'label'    => '1200 m³/h',
			),
			array(
				'filename' => 'performance-1500-en.png',
				'alt'      => 'ECO AIR Cleaner performance curve, 1500 m³/h variant',
				'label'    => '1500 m³/h',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_dimension_images' ) ) :
	/**
	 * Return the 4 mechanical dimension drawings as [filename, alt] pairs.
	 *
	 * The 4th image has two language variants (EN / DE) because the
	 * source drawings are callout-labeled in each language. The EN
	 * template uses 'dimension-4-en.webp'; the DE template passes
	 * 'en' => false to swap to 'dimension-4-de.webp'.
	 *
	 * The 4th image shows the HEPA-style enclosure with the analog
	 * differential-pressure-indicator callout (the gauge is the same
	 * in both languages, only the caption text differs). The file
	 * content is sourced from HEPA_V2_{EN,DE}.webp in the user's
	 * Downloads; the dimension-4-{en,de}.webp filenames are kept for
	 * the existing helper signature (one filename slot per image).
	 *
	 * @param bool $emifree_english If true, use the EN 4th image; otherwise the DE one.
	 * @return array<int, array{filename:string, alt:string}>
	 */
	function emifree_get_mechanical_dimension_images( $emifree_english = true ) {
		return array(
			array(
				'filename' => 'dimension-1.webp',
				'alt'      => 'ECO AIR dimensions, view 1',
			),
			array(
				'filename' => 'dimension-2.webp',
				'alt'      => 'ECO AIR dimensions, view 2',
			),
			array(
				'filename' => 'dimension-3.webp',
				'alt'      => 'ECO AIR dimensions, view 3',
			),
			array(
				'filename' => $emifree_english ? 'dimension-4-en.webp' : 'dimension-4-de.webp',
				'alt'      => $emifree_english
					? 'ECO AIR enclosure with analog differential pressure indicator callout (EN)'
					: 'ECO AIR Gehäuse mit Analoger Differenzdruckanzeige-Callout (DE)',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_applications' ) ) :
	/**
	 * Return the typical applications for the ECO AIR Cleaner line.
	 *
	 * Source of truth for the EN list is `emifree_products()`
	 * (inc/products.php) under `mechanical.applications`. The DE
	 * list is hand-translated here, not pulled from
	 * emifree_products(), because the upstream data array stores
	 * only the EN strings — the DE mirror is a presentation concern
	 * of the product page (and the same approach the specs table
	 * uses via emifree_get_mechanical_specs_rows()).
	 *
	 * The DE vocabulary follows typical machine-shop terminology:
	 *   CNC Machining   → CNC-Bearbeitung
	 *   Grinding        → Schleifen
	 *   Turning         → Drehen
	 *   Milling         → Fräsen
	 *   Spark Eroding   → Senkerodieren (also: Funkenerosion)
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array<int, string>
	 */
	function emifree_get_mechanical_applications( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return array(
				'CNC-Bearbeitung',
				'Schleifen',
				'Drehen',
				'Fräsen',
				'Senkerodieren',
			);
		}
		return emifree_products()['mechanical']['applications'];
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_cta' ) ) :
	/**
	 * Return the call-to-action button label for the mechanical
	 * product page.
	 *
	 * The EN label is sourced from `emifree_products()` so that
	 * the upstream data array stays the single source of truth
	 * (used by the home-page product card and any future
	 * re-use). The DE label is a verb form ("Angebot anfordern")
	 * because the upstream string is a noun phrase ("Request ...
	 * Quote") that doesn't translate cleanly word-for-word.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return string
	 */
	function emifree_get_mechanical_cta( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return 'Angebot anfordern';
		}
		return emifree_products()['mechanical']['cta'];
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_quotation_heading' ) ) :
	/**
	 * Return the section heading for the Quotation / Angebot block.
	 *
	 * The heading is the noun form ("Quotation" / "Angebot") rather
	 * than the imperative verb form (which is the button label).
	 * This matches the convention used by the in-page nav menu
	 * item label and the `<h2>` of the section, and keeps the CTA
	 * button visually distinct (verb, action-oriented).
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return string
	 */
	function emifree_get_mechanical_quotation_heading( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return 'Angebot';
		}
		return 'Quotation';
	}
endif;

if ( ! function_exists( 'emifree_get_mechanical_quotation_intro' ) ) :
	/**
	 * Return the one-line intro shown above the applications chips
	 * in the Quotation / Angebot block.
	 *
	 * Kept short — the chips themselves carry the categorical
	 * information, the intro just sets up the conversion goal.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return string
	 */
	function emifree_get_mechanical_quotation_intro( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return 'Typische Anwendungsbereiche der ECO AIR Cleaner-Reihe:';
		}
		return 'Typical applications for the ECO AIR Cleaner line:';
	}
endif;

// ============================================================================
// Electrostatic (EARIA) product line — mirrors the mechanical helper shape
// above. Same set of return signatures so the electrostatic template-parts
// iterate over the same shapes the mechanical ones do. Slugs:
//   EN: /en/products/electrostatic/     — emifree_products()['electrostatic']
//   DE: /de/produkte/elektrostatische-filtration/
// ============================================================================

if ( ! function_exists( 'emifree_get_electrostatic_gallery' ) ) :
	/**
	 * Return the 3 EARIA product photos as [filename, alt] pairs.
	 *
	 * Same approach as the mechanical helper: the photos live in the
	 * parent assets/products/ folder (shared with the home-page
	 * product card) rather than under electrostatic/, so the home
	 * section template can keep its single uri.
	 *
	 * @return array<int, array{filename:string, alt:string}>
	 */
	function emifree_get_electrostatic_gallery() {
		return array(
			array(
				'filename' => 'fotoe1.webp',
				'alt'      => 'EARIA electrostatic precipitator, front view',
			),
			array(
				'filename' => 'fotoe2.webp',
				'alt'      => 'EARIA electrostatic precipitator, side with hinged door open',
			),
			array(
				'filename' => 'fotoe3.webp',
				'alt'      => 'EARIA electrostatic precipitator, hinge detail',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_specs_rows' ) ) :
	/**
	 * Return the EARIA specs table as [label, basic, premium] triples.
	 *
	 * Source of truth for the copy is the spec data the user
	 * transcribed on 2026-10-14 (table with 14 rows: Designation /
	 * Dimensions / Flow Rate / ... / Control System, columns Basic +
	 * Premium, EN and DE). The structure mirrors the mechanical
	 * helper's [label, advanced, premium] shape — the electrostatic
	 * template iterates the same way, only the column keys differ
	 * (`basic` instead of `advanced`).
	 *
	 * "Version" is treated as the column header for the row-label
	 * column (the user typed it first in the source transcription,
	 * matching the layout of the published EARIA spec sheet);
	 * the table the template renders has a single `Version | Basic
	 * | Premium` thead row + 14 tbody data rows.
	 *
	 * Differences from the mechanical helper:
	 *  - 14 rows, not 15 (electrostatic has no "Airflow" row split
	 *    into Advanced vs "—"; the line ships a single 1000 m³/h
	 *    variant).
	 *  - The Pre-filter / Cleaning System / Control System rows
	 *    inherit the same ✓/✓/—/✓ pattern from the EARIA spec
	 *    image the user supplied in the previous turn (those three
	 *    rows are part of the row-label list but the user-supplied
	 *    text didn't include cell values; the spec image is the
	 *    only source of truth we have, so it's preserved here).
	 *  - "Electrical" / "Elektrik" for the Premium column uses
	 *    "3-phase 400 V 50/60 Hz" (EN) and "3-Ph. 400 V 50/60 Hz"
	 *    (DE) — the user typed them differently per language, so
	 *    the value is preserved as written rather than normalised.
	 *  - The Dimensions row uses `(L x W x H)` for the Basic
	 *    column and `[L x W x H]` for the Premium column (the
	 *    user transcribed the spec sheet with different bracket
	 *    styles per cell); the asymmetry is preserved as a
	 *    transcription choice, not a typo to "fix".
	 *  - "Flow Rate Adjustment" is lowercase ("via potentiometer"
	 *    / "via touch panel") per the user's source text; the
	 *    mechanical helper capitalises ("via Potentiometer") because
	 *    that matches the ECO AIR PDF's styling.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array<int, array{label:string, basic:string, premium:string}>
	 */
	function emifree_get_electrostatic_specs_rows( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return array(
				array(
					'label'   => 'Bezeichnung',
					'basic'   => 'EAR-10-CS-X',
					'premium' => 'EAR-10-CS-X',
				),
				array(
					'label'   => 'Abmessungen',
					'basic'   => '818 x 466 x 566 mm (L x W x H)',
					'premium' => '818 x 466 x 566 mm [L x W x H]',
				),
				array(
					'label'   => 'Volumenstrom',
					'basic'   => 'einstellbar, bis 1000 m³/h',
					'premium' => 'einstellbar, bis 1000 m³/h',
				),
				array(
					'label'   => 'Einstellung Volumenstrom',
					'basic'   => 'über Potentiometer',
					'premium' => 'via Touch-Panel',
				),
				array(
					'label'   => 'Elektrik',
					'basic'   => '1-Ph. 230 V 50/60 Hz',
					'premium' => '3-Ph. 400 V 50/60 Hz',
				),
				array(
					'label'   => 'Leistung',
					'basic'   => '0.4 kW',
					'premium' => '0,5 kW',
				),
				array(
					'label'   => 'Schutzklasse',
					'basic'   => 'IP54',
					'premium' => 'IP54',
				),
				array(
					'label'   => 'Geräusch',
					'basic'   => '68 dB',
					'premium' => '68 dB',
				),
				array(
					'label'   => 'Rohranschluss',
					'basic'   => 'DN 200 mm',
					'premium' => 'DN 200 mm',
				),
				array(
					'label'   => 'Standardfarbe',
					'basic'   => 'RAL 9002 (opt. andere RAL Farben)',
					'premium' => 'RAL 9002 (opt. andere RAL Farben)',
				),
				array(
					'label'   => 'Gewicht',
					'basic'   => '120 kg',
					'premium' => '130 kg',
				),
				array(
					'label'   => 'Vorfilter',
					'basic'   => '✓',
					'premium' => '✓',
				),
				array(
					'label'   => 'Reinigungssystem',
					'basic'   => '✓',
					'premium' => '✓',
				),
				array(
					'label'   => 'Kontrollsystem',
					'basic'   => '—',
					'premium' => '✓',
				),
			);
		}

		return array(
			array(
				'label'   => 'Designation',
				'basic'   => 'EAR-10-CS-X',
				'premium' => 'EAR-10-CS-X',
			),
			array(
				'label'   => 'Dimensions',
				'basic'   => '818 x 466 x 566 mm (L x W x H)',
				'premium' => '818 x 466 x 566 mm [L x W x H]',
			),
			array(
				'label'   => 'Flow Rate',
				'basic'   => 'Adjustable up to 1000 m³/h',
				'premium' => 'Adjustable up to 1000 m³/h',
			),
			array(
				'label'   => 'Flow Rate Adjustment',
				'basic'   => 'via potentiometer',
				'premium' => 'via touch panel',
			),
			array(
				'label'   => 'Electrical',
				'basic'   => '1-Ph. 230 V 50/60 Hz',
				'premium' => '3-phase 400 V 50/60 Hz',
			),
			array(
				'label'   => 'Power',
				'basic'   => '0.4 kW',
				'premium' => '0.5 kW',
			),
			array(
				'label'   => 'Protection Class',
				'basic'   => 'IP54',
				'premium' => 'IP54',
			),
			array(
				'label'   => 'Noise',
				'basic'   => '68 dB',
				'premium' => '68 dB',
			),
			array(
				'label'   => 'Pipe Connection',
				'basic'   => 'DN 200 mm',
				'premium' => 'DN 200 mm',
			),
			array(
				'label'   => 'Standard Color',
				'basic'   => 'RAL 9002 (opt. other RAL colors)',
				'premium' => 'RAL 9002 (other RAL colors available)',
			),
			array(
				'label'   => 'Weight',
				'basic'   => '120 kg',
				'premium' => '130 kg',
			),
			array(
				'label'   => 'Pre-filter',
				'basic'   => '✓',
				'premium' => '✓',
			),
			array(
				'label'   => 'Cleaning System',
				'basic'   => '✓',
				'premium' => '✓',
			),
			array(
				'label'   => 'Control System',
				'basic'   => '—',
				'premium' => '✓',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_dimension_images' ) ) :
	/**
	 * Return the 3 electrostatic dimension drawings as [filename, alt, uri] triples.
	 *
	 * The 3rd drawing has two language variants (EN / DE) because
	 * the source drawing has a callout label in each language
	 * ("Fastener, 6 × M10" / "Befestigung, 6 × M10"). The EN
	 * template uses 'earia-dim-3-en.jpg'; the DE template passes
	 * $emifree_english = false to swap to 'earia-dim-3-de.jpg'.
	 *
	 * Views 1 and 2 are language-neutral (no embedded text). All
	 * three live in assets/products/electrostatic/ alongside the
	 * EARIA logo and the (no-longer-rendered) spec-sheet PNGs.
	 *
	 * The "3 in a 2-col grid" layout leaves the 4th cell empty on
	 * sm+ viewports. The user has not asked for the 3rd tile to
	 * span both columns; if that becomes a request, the template's
	 * foreach wrapper gets a `sm:col-span-2` on the last iteration
	 * (one-line change). Mirrors the mechanical helper's per-
	 * language 4th-slot signature.
	 *
	 * @param bool $emifree_english If true, use the EN 3rd image; otherwise the DE one.
	 * @return array<int, array{filename:string, alt:string, uri:string}>
	 */
	function emifree_get_electrostatic_dimension_images( $emifree_english = true ) {
		$emifree_uri = get_template_directory_uri() . '/assets/products/electrostatic/';
		return array(
			array(
				'filename' => 'earia-dim-1.jpg',
				'alt'      => 'EARIA dimensions, view 1 — side elevation',
				'uri'      => $emifree_uri . 'earia-dim-1.jpg',
			),
			array(
				'filename' => 'earia-dim-2.jpg',
				'alt'      => 'EARIA dimensions, view 2 — front view',
				'uri'      => $emifree_uri . 'earia-dim-2.jpg',
			),
			array(
				'filename' => $emifree_english ? 'earia-dim-3-en.jpg' : 'earia-dim-3-de.jpg',
				'alt'      => $emifree_english
					? 'EARIA dimensions, view 3 — mounting view, 6 × M10 fasteners'
					: 'EARIA Maße, Ansicht 3 — Montageansicht, 6 × M10 Befestigung',
				'uri'      => $emifree_uri . ( $emifree_english ? 'earia-dim-3-en.jpg' : 'earia-dim-3-de.jpg' ),
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_performance_curves' ) ) :
	/**
	 * Return the EARIA performance-comparison image as
	 * [filename, alt, label, uri] quads.
	 *
	 * The performance section on the EARIA product page is no
	 * longer a single-variant pressure-loss curve; it is a
	 * side-by-side comparison graph ("Emifree System" vs.
	 * "Conventional System" / "Emifree-System" vs.
	 * "Konventionelles System") showing how a self-cleaning
	 * cycle keeps filtration efficiency near 100% over time
	 * while a conventional system decays toward 60%.
	 *
	 * The graph ships as a single PNG per language (the legend
	 * text is baked into the image: "Emifree System",
	 * "Self-cleaning system", "Conventional System" in EN, and
	 * the German equivalents in DE). The body template renders
	 * the section with one full-width figure; the loop is kept
	 * for symmetry with the mechanical helper but returns a
	 * single entry.
	 *
	 * The `label` key is preserved in the return shape for
	 * backwards compatibility with the existing template, but
	 * the EARIA body template now intentionally omits the
	 * figcaption — the old "1000 m³/h" label was specific to
	 * the per-variant pressure-loss curve, and the new
	 * comparison graph has no variant number to call out.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array<int, array{filename:string, alt:string, label:string, uri:string}>
	 */
	function emifree_get_electrostatic_performance_curves( $emifree_lang = 'en' ) {
		$emifree_uri = get_template_directory_uri() . '/assets/products/electrostatic/';
		if ( 'de' === $emifree_lang ) {
			return array(
				array(
					'filename' => 'earia-performance-de.png',
					'alt'      => 'Leistungsvergleich: Emifree-System mit Selbstreinigung gegen konventionelles System über die Zeit',
					'label'    => '',
					'uri'      => $emifree_uri . 'earia-performance-de.png',
				),
			);
		}
		return array(
			array(
				'filename' => 'earia-performance-en.png',
				'alt'      => 'Performance comparison: Emifree System with self-cleaning vs. conventional system over time',
				'label'    => '',
				'uri'      => $emifree_uri . 'earia-performance-en.png',
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_spec_image' ) ) :
	/**
	 * Return the URL + alt text for the static spec image (PNG)
	 * for the EARIA line.
	 *
	 * The user supplied a per-language spec table image rather than
	 * a structured data array (earia_EN.png, earia_DE_final2.png).
	 * The body template renders the image at full width on the Specs
	 * section rather than building an HTML table. When a structured
	 * EARIA spec sheet replaces the PNG, this helper should be
	 * replaced by an `emifree_get_electrostatic_specs_table()` that
	 * returns the same [rows] shape used by the mechanical helper.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array{url:string, alt:string}
	 */
	function emifree_get_electrostatic_spec_image( $emifree_lang = 'en' ) {
		$emifree_uri = get_template_directory_uri() . '/assets/products/electrostatic/';
		if ( 'de' === $emifree_lang ) {
			return array(
				'url' => $emifree_uri . 'earia_DE_final2.png',
				'alt' => 'EARIA 1000 m³/h — Spezifikationsübersicht (DE)',
			);
		}
		return array(
			'url' => $emifree_uri . 'earia_EN.png',
			'alt' => 'EARIA 1000 m³/h — specifications overview (EN)',
		);
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_applications' ) ) :
	/**
	 * Return the typical applications for the EARIA line.
	 *
	 * Mirrors the mechanical helper. The EN list is pulled from
	 * `emifree_products()['electrostatic']['applications']`; the DE
	 * list is hand-translated here.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return array<int, string>
	 */
	function emifree_get_electrostatic_applications( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return array(
				'Ölnebel',
				'Rauch',
				'Schweißrauch',
				'Schleifstaub',
				'Laserdämpfe',
			);
		}
		return emifree_products()['electrostatic']['applications'];
	}
endif;

if ( ! function_exists( 'emifree_get_electrostatic_cta' ) ) :
	/**
	 * Return the call-to-action button label for the electrostatic
	 * product page.
	 *
	 * Same pattern as the mechanical helper. EN from
	 * `emifree_products()`, DE is a verb form to match the
	 * mechanical DE button style.
	 *
	 * @param string $emifree_lang 'en' (default) or 'de'.
	 * @return string
	 */
	function emifree_get_electrostatic_cta( $emifree_lang = 'en' ) {
		if ( 'de' === $emifree_lang ) {
			return 'Angebot anfordern';
		}
		return emifree_products()['electrostatic']['cta'];
	}
endif;
