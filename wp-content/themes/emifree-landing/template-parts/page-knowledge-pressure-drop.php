<?php
/**
 * Air Pressure Loss Calculator — /air-pressure-loss-calculator/.
 *
 * Visual run builder: drag tube segments + fittings (90°/45° elbows,
 * T-junction, Y-connector, reducer) from the toolbox onto an SVG
 * canvas. Components snap to nearest port (≤ 20px). Live
 * recalculation of total pressure drop (Pa) on every change.
 *
 * Math (per row):
 *   major_loss = f × (L / D) × ρ × v² / 2  per tube segment
 *   minor_loss = K × ρ × v² / 2             per fitting
 *   total_ΔP   = Σ major + Σ minor  ×  K_app
 *   where v = Q / A_section for the current diameter at that row.
 *
 * Defaults (ASHRAE/SMACNA — see methodBody i18n string for the
 * full derivation):
 *   ρ = 1.2 kg/m³  (standard air)
 *   μ = 1.81 × 10⁻⁵ Pa·s
 *   f  = Swamee-Jain explicit, ε from material
 *   K_elbow90 = 0.18   (R/D = 1.5 die-stamped)
 *   K_elbow45 = 0.20
 *   K_tee     = 1.20   (branch)
 *   K_y       = 0.60
 *   K_reducer = 0.10   (gradual, θ ≤ 15°)
 *   K_app     = 1.0 (HVAC), 1.15 (oil mist), 1.25 (dust)
 *
 * Labels are localized via wp_localize_script on the
 * 'emifree-section-pressure-drop' handle. The JS consumes them via
 * window.EMIFREE_PRESSUREDROP_I18N.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Locale strings passed to the JS ----------------------------------------
// All visible labels + units live here so the JS file has no embedded
// copy and the German variant can swap them entirely.
// Locale strings passed to the JS.
// Only Quick Calc keys are kept — the visual builder keys
// (toolbox, properties, results, K-factor library) were removed
// along with the canvas UI on 2026-08-25.
$emifree_pd_i18n = array(
	'airflow'        => 'Airflow',
	'material'       => 'Material',
	'variant'        => 'Application',
	'quickTitle'     => 'Duct Run Calculator',
	'quickSubtitle'  => 'Quick pressure loss calculation for industrial duct runs.',
	'addSection'     => 'Add section',
	'remove'         => 'Remove',
	'calculate'      => 'Calculate',
	'fanRec'         => 'Fan (2× safety)',
	'diameter'       => 'Diameter',
	'components'     => 'Components',
	'addRow'         => '+ Add component',
	'methodology'    => 'Methodology',
	'methodBody'     => '<b>1. Air properties (standard conditions, 20°C / sea level):</b> ρ = 1.2 kg/m³, μ = 1.81×10⁻⁵ Pa·s. <br><br><b>2. Section flow properties (per section):</b> D = section diameter (m), A = π·D²/4, V = Q/A, Re = ρ·V·D/μ. <br><br><b>3. Friction factor (Swamee–Jain, explicit):</b> f = 0.25 / [log₁₀(ε/3.7D + 5.74/Re⁰·⁹)]². ε from material: galvanized = 0.15 mm, aluminum = 0.0015 mm, black steel = 0.045 mm. <br><br><b>4. Straight-tube friction (Darcy–Weisbach):</b> ΔP_f = f·(L/D)·½·ρ·V² per row. <br><br><b>5. Fitting loss (K-factor, Idelchik / ASHRAE averages):</b> ΔP_m = K·½·ρ·V² per row. K values: 90° elbow = 0.18, 45° elbow = 0.20, T-junction = 1.20, Y-connector = 0.60, reducer = 0.10. <br><br><b>6. Reducer step-down:</b> When a row is a reducer, the section\'s effective diameter is updated to the reducer\'s outlet for all subsequent rows. <br><br><b>7. Application correction (K_app):</b> Total raw loss is multiplied by 1.0 (HVAC), 1.15 (oil mist, accounts for liquid film drag), or 1.25 (dust, accounts for particle acceleration and wall impact). <br><br><b>8. Final result:</b> ΔP_total = (Σ ΔP_f + Σ ΔP_m) × K_app. Recommended fan static pressure = ΔP_total × 2 (industry 2× safety margin).',
	'limitations'    => 'Limitations',
	'limitBody'      => 'Single-run pressure drop only — no multi-branch balancing, no fan matching, no temperature/altitude correction. K-factors assume turbulent flow (Re > 4000). Adjust per-component K-values in the library if your installation deviates from ASHRAE defaults.',
);

wp_localize_script( 'emifree-section-pressure-drop', 'EMIFREE_PRESSUREDROP_I18N', $emifree_pd_i18n );
?>

<div class="pd-root min-h-screen bg-white">

	<?php /* ----- Header band ----- */ ?>
	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-8">
			<a href="<?php echo esc_url( home_url( '/en/knowledge/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"></path>
				</svg>
				Back to Engineering Tools
			</a>

			<nav aria-label="breadcrumb" class="mb-6 text-sm text-zinc-500">
				<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="hover:text-blue-700">Home</a>
				<span class="mx-2" aria-hidden="true">/</span>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/' ) ); ?>" class="hover:text-blue-700">Tools</a>
				<span class="mx-2" aria-hidden="true">/</span>
				<span class="text-zinc-700">Air Pressure Loss Calculator</span>
			</nav>

			<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-zinc-900 leading-tight mb-3">
				Air Pressure Loss Calculator
			</h1>
			<p class="text-base sm:text-lg text-blue-800 font-medium max-w-3xl mb-2">
				Also called: duct pressure loss calculator &middot; air pressure drop calculator &middot; HVAC static pressure calculator &middot; fan &Delta;P calculator.
			</p>
			<p class="text-lg text-zinc-600 max-w-3xl">
				Calculate <strong>air pressure loss</strong> in HVAC ducts, fans, and industrial extraction systems. Free online tool for oil-mist collection, dust extraction, and standard HVAC &mdash; no signup, no installation. Built on Darcy&ndash;Weisbach friction + Idelchik / ASHRAE K-factors with application-specific correction for oil mist and dust.
			</p>
		</div>
	</div>

	<?php /* ----- Quick Calc (the only tab; visual builder was removed 2026-08-25) ----- */ ?>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<div data-pd-tab="quick" class="pd-tab-panel">
			<div class="bg-white border border-slate-200 rounded-2xl p-6">
				<div class="flex items-center justify-between mb-4">
					<div class="flex items-center gap-3">
						<h2 class="text-lg font-bold text-zinc-900" data-pd-i18n="quickTitle">Duct Run Calculator</h2>
</div>
					<button type="button" data-pd-quick-calc class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" data-pd-i18n="calculate">Calculate</button>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-4 border-b border-slate-200">
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="airflow">Airflow</span>
						<div class="flex">
							<input type="number" name="pd-quick-airflow" min="0" step="any" value="1700"
								class="flex-1 min-w-0 rounded-l border border-slate-300 px-2 py-1.5 text-sm" inputmode="decimal">
							<span class="inline-flex items-center px-2 rounded-r border border-l-0 border-slate-300 bg-slate-50 text-slate-600 text-xs flex-shrink-0">m³/h</span>
						</div>
					</label>
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="material">Material</span>
						<select name="pd-quick-material" class="rounded border border-slate-300 px-2 py-1.5 text-sm">
							<option value="galvanized" selected>Galvanized steel (k=0.15mm)</option>
							<option value="aluminum">Aluminum (k=0.0015mm)</option>
							<option value="blackSteel">Black steel (k=0.045mm)</option>
						</select>
					</label>
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="variant">Application</span>
						<select name="pd-quick-variant" class="rounded border border-slate-300 px-2 py-1.5 text-sm">
							<option value="oil-mist" selected>Oil mist</option>
							<option value="dust">Dust</option>
							<option value="hvac">HVAC</option>
						</select>
					</label>
				</div>

				<div data-pd-quick-sections class="space-y-3">
					<?php /* Section rows are cloned by JS */ ?>
				</div>

				<button type="button" data-pd-quick-add-section class="mt-3 inline-flex items-center gap-2 text-sm text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
					<span data-pd-i18n="addSection">Add section</span>
				</button>

				<div data-pd-quick-result class="hidden mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
					<div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="frictionLoss">Friction</div>
							<div data-pd-quick-friction class="font-mono text-lg font-bold text-zinc-900">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="minorLoss">Minor loss</div>
							<div data-pd-quick-minor class="font-mono text-lg font-bold text-zinc-900">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="totalDrop">Total ΔP</div>
							<div data-pd-quick-total class="font-mono text-xl font-bold text-blue-700">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="fanRec">Fan (2× safety)</div>
							<div data-pd-quick-fan class="font-mono text-lg font-bold text-zinc-700">0 Pa</div>
						</div>
					</div>
				</div>
			</div>
		</div><?php /* end data-pd-tab="quick" */ ?>

		<?php /* Methodology */ ?>
		<section class="mt-12 prose max-w-none text-zinc-700">
			<h2 class="text-2xl font-bold text-zinc-900" data-pd-i18n="methodology">Methodology</h2>
			<p data-pd-i18n="methodBody"><b>1. Air properties (standard conditions, 20°C / sea level):</b> ρ = 1.2 kg/m³, μ = 1.81×10⁻⁵ Pa·s. <br><br><b>2. Section flow properties (per section):</b> D = section diameter (m), A = π·D²/4, V = Q/A, Re = ρ·V·D/μ. <br><br><b>3. Friction factor (Swamee–Jain, explicit):</b> f = 0.25 / [log₁₀(ε/3.7D + 5.74/Re⁰·⁹)]². ε from material: galvanized = 0.15 mm, aluminum = 0.0015 mm, black steel = 0.045 mm. <br><br><b>4. Straight-tube friction (Darcy–Weisbach):</b> ΔP_f = f·(L/D)·½·ρ·V² per row. <br><br><b>5. Fitting loss (K-factor, Idelchik / ASHRAE averages):</b> ΔP_m = K·½·ρ·V² per row. K values: 90° elbow = 0.18, 45° elbow = 0.20, T-junction = 1.20, Y-connector = 0.60, reducer = 0.10. <br><br><b>6. Reducer step-down:</b> When a row is a reducer, the section's effective diameter is updated to the reducer's outlet for all subsequent rows. <br><br><b>7. Application correction (K_app):</b> Total raw loss is multiplied by 1.0 (HVAC), 1.15 (oil mist, accounts for liquid film drag), or 1.25 (dust, accounts for particle acceleration and wall impact). <br><br><b>8. Final result:</b> ΔP_total = (Σ ΔP_f + Σ ΔP_m) × K_app. Recommended fan static pressure = ΔP_total × 2 (industry 2× safety margin).</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-6" data-pd-i18n="limitations">Limitations</h3>
			<p data-pd-i18n="limitBody">Single-run pressure drop only — no multi-branch balancing, no fan matching, no temperature/altitude correction. K-factors assume turbulent flow (Re > 4000). Adjust per-component K-values in the library if your installation deviates from ASHRAE defaults.</p>
		</section>

		<?php /* Frequently Asked Questions — paired with FAQPage JSON-LD in the shim. */ ?>
		<section class="mt-12" aria-labelledby="pd-faq-en">
			<h2 id="pd-faq-en" class="text-2xl font-bold text-zinc-900 mb-6">Frequently Asked Questions</h2>
			<div class="space-y-4">
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">What is air pressure loss?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Air pressure loss (also called air pressure drop or duct pressure loss) is the reduction in static pressure as air flows through a duct, fitting, filter, or other component. It is measured in pascals (Pa) and is the single most important factor when sizing a fan or extractor for an HVAC, oil-mist, or dust-collection system. Pressure loss comes from two sources: <strong>friction</strong> along straight duct walls and <strong>minor (fitting) losses</strong> at elbows, branches, transitions, and filters.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">How do I calculate air pressure loss in a duct?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Air pressure loss is the sum of friction loss in straight ducts (Darcy&ndash;Weisbach, calculated with the Swamee&ndash;Jain friction factor) plus the K-factor losses of every fitting in the run (90&deg; elbow K &asymp; 0.18, 45&deg; elbow K &asymp; 0.20, T-junction K &asymp; 1.20, Y-connector K &asymp; 0.60, reducer K &asymp; 0.10). For oil-mist extraction multiply the total by 1.15, for dust collection multiply by 1.25, then double the result for fan safety margin. This calculator does all of the above automatically &mdash; enter airflow, pick your material and application, add the duct sections, click Calculate.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">What is the difference between air pressure loss and air pressure drop?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>There is no physical difference &mdash; both terms describe the same quantity (static-pressure reduction, in Pa). &ldquo;Pressure drop&rdquo; is the engineering / ASHRAE term; &ldquo;pressure loss&rdquo; is the phrasing used by HVAC installers, ductwork suppliers, and most European industrial catalogues. Search engines and supplier documentation mix the two freely; this calculator handles both, and the methodology treats them as identical.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">What is a normal air pressure loss for an HVAC duct?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>For a typical galvanized HVAC supply duct at 1,500 m&sup3;/h, expect roughly <strong>1 Pa per metre of straight duct</strong> (200 mm diameter, f &asymp; 0.02) plus 5-12 Pa per 90&deg; elbow and 30-70 Pa per T-branch. ASHRAE recommends a target friction rate of 0.8-1.2 Pa/m for low-pressure mains. For industrial oil-mist and dust extraction, total static pressure is usually 800-2,500 Pa once filter and cyclone losses are added &mdash; the calculator gives you the duct-only figure; add filter loss separately.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">What K-factor should I use for a 90&deg; elbow?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>It depends on the elbow geometry. Common ASHRAE / Idelchik values: <strong>die-stamped 90&deg; elbow (r/D = 1.5)</strong> &rarr; K = 0.18; <strong>mitered 90&deg; without vanes</strong> &rarr; K = 1.3; <strong>mitered 90&deg; with single vane</strong> &rarr; K = 0.5; <strong>smooth-radius 90&deg; (r/D = 1.0)</strong> &rarr; K = 0.23. This calculator uses the die-stamped r/D = 1.5 value of 0.18, which is the most common HVAC fitting; adjust the K in the methodology section above if your installation uses a different geometry.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-en-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">How do I size a fan for my duct?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Two numbers: airflow (m&sup3;/h) and static pressure (Pa). The airflow is set by the application &mdash; for oil-mist, 1,500-2,500 m&sup3;/h per CNC; for dust, 2,000-5,000 m&sup3;/h per cell. The static pressure is the duct pressure loss from this calculator, <strong>plus filter and cyclone loss</strong> (typically 500-1,500 Pa for an oil-mist filter cartridge). Industry practice adds a 2&times; safety margin on top &mdash; this calculator already applies that, so the &ldquo;Fan (2&times; safety)&rdquo; output is your minimum fan rating.</p>
					</div>
				</details>
			</div>
		</section>

		<?php /* Important Notes — disclaimer; users must verify with specialists. */ ?>
		<aside class="mt-10 p-6 bg-amber-50 border border-amber-300 rounded-lg" aria-labelledby="pd-important-notes-en">
			<h2 id="pd-important-notes-en" class="text-2xl font-bold text-zinc-900 mb-3">Important Notes</h2>
			<p class="text-zinc-800 leading-relaxed mb-3">
				Please contact us by email
				<a href="mailto:info@emifree.com" class="text-blue-700 hover:text-blue-800 underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">info@emifree.com</a>
				if you find any faults, inaccuracies, or otherwise unacceptable information.
			</p>
			<p class="text-zinc-800 leading-relaxed">
				The content of this tool can be used by any individual or organization with <strong>NO WARRANTY</strong> or <strong>LIABILITY</strong>. Important information should always be double checked with alternative sources or specialists. All applicable national and local regulations and practices concerning this aspects must be strictly followed and adhered to.
			</p>
		</aside>
	</div>

</div>