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
