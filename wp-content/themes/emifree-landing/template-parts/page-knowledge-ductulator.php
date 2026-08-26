<?php
/**
 * Knowledge Ductulator — /knowledge/ductulator/.
 *
 * Embeds the Ductulator tool: a vanilla-JS port of ductulator.jsx
 * that sizes round or rectangular HVAC ducts using Darcy-Weisbach
 * + Swamee-Jain + ASHRAE equivalent diameter. Math runs in the
 * browser; this template provides the mount point, scoped CSS, and
 * localized labels passed to the JS via wp_localize_script.
 *
 * Labels are kept here (not in a .mo file) because the JS consumes
 * them via window.EMIFREE_DUCTULATOR_I18N — the same inline pattern
 * the products section uses (functions.php emifree_enqueue_section_script).
 *
 * Loaded only when the Ductulator page is rendered. The shim
 * (page-knowledge-ductulator.php) calls
 * emifree_enqueue_section_script( 'ductulator' ) and
 * emifree_seo_page_with_schema() before get_header().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Labels passed to the JS. Mirrors the ductulator.jsx React artifact's
// strings so the German and English versions are predictable.
$emifree_duct_i18n = array(
	'title'           => 'Duct Sizing Calculator',
	'subtitle'        => 'Size round or rectangular HVAC ducts from airflow, target friction rate, or target velocity. Standard air (70°F, sea level).',
	'mode'            => 'Sizing mode',
	'modeFriction'    => 'Friction rate',
	'modeVelocity'    => 'Velocity',
	'modeKnown'       => 'Known size',
	'airflow'         => 'Airflow',
	'cfm'             => 'CFM',
	'm3h'             => 'm³/h',
	'friction'        => 'Target friction rate',
	'inwg'            => 'in. w.c. / 100 ft',
	'paM'             => 'Pa / m',
	'velocity'        => 'Target velocity',
	'fpm'             => 'fpm',
	'mS'              => 'm/s',
	'shape'           => 'Duct shape',
	'round'           => 'Round',
	'rect'            => 'Rectangular',
	'units'           => 'Units',
	'imperial'        => 'Imperial',
	'metric'          => 'Metric',
	'material'        => 'Material',
	'matGalvanized'   => 'Galvanized steel',
	'matAluminum'     => 'Aluminum',
	'matPvc'          => 'PVC',
	'matFiberglass'   => 'Fibrous glass duct board',
	'matFlex'         => 'Flex duct (extended)',
	'matConcrete'     => 'Concrete',
	'matCustom'       => 'Custom',
	'customRough'     => 'Roughness (mm)',
	'diameter'        => 'Diameter',
	'width'           => 'Width',
	'height'          => 'Height',
	'widthIn'         => 'in',
	'heightIn'        => 'in',
	'snap'            => 'Round up to standard size',
	'results'         => 'Results',
	'labelDiameter'   => 'Diameter',
	'labelVelocity'   => 'Velocity',
	'labelFriction'   => 'Friction rate',
	'labelReynolds'   => 'Reynolds number',
	'labelFf'         => 'Friction factor',
	'labelEqDiameter' => 'Equivalent Ø',
	'resultEmpty'     => 'Enter airflow to begin.',
	'schematicEmpty'  => 'No duct yet',
	'schematicLabel'  => 'Schematic',
	'disclaimer'      => 'Single-segment sizing only. For multi-section systems, fitting losses, temperature/altitude correction, or duct schedules, consult an HVAC engineer. See the readme below for methodology and limitations.',
	'backLink'        => 'Back to Knowledge',
);

wp_localize_script( 'emifree-section-ductulator', 'EMIFREE_DUCTULATOR_I18N', $emifree_duct_i18n );
?>

<div class="duct-root min-h-screen bg-white">

	<?php /* ----- Header band ----- */ ?>
	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
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
				<span class="text-zinc-700">Duct Sizing Calculator</span>
			</nav>

			<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-zinc-900 leading-tight mb-4">
				Duct Sizing Calculator
			</h1>
			<p class="text-lg text-zinc-600 max-w-3xl">
				Size round or rectangular HVAC ducts from airflow, target friction rate, or target velocity. Standard air (70°F, sea level).
			</p>
		</div>
	</div>

	<?php /* ----- Tool body ----- */ ?>
	<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

			<form class="lg:col-span-2 space-y-6 bg-slate-50 border border-slate-200 rounded-2xl p-6" onsubmit="return false;">

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Units</span>
							<select name="duct-units" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
								<option value="metric" selected>Metric (m³/h, Pa/m, m/s)</option>
								<option value="imperial">Imperial (CFM, in.wg, fpm)</option>
							</select>
						</label>
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Duct shape</span>
							<select name="duct-shape" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
								<option value="round" selected>Round</option>
								<option value="rect">Rectangular</option>
							</select>
						</label>
					</div>

					<fieldset class="space-y-2">
						<legend class="text-sm font-medium text-zinc-700 mb-1">Sizing mode</legend>
						<div class="flex flex-wrap gap-3">
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="friction" checked class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">From friction rate</span>
							</label>
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="velocity" class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">From target velocity</span>
							</label>
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="known" class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">Known size</span>
							</label>
						</div>
					</fieldset>

					<label class="block">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Airflow</span>
						<div class="flex">
							<input type="number" name="duct-q" min="0" step="any" value="1700"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">CFM</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">m³/h</span>
						</div>
					</label>

					<label class="block" data-duct-show="friction">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Target friction rate</span>
						<div class="flex">
							<input type="number" name="duct-friction" min="0" step="any" value="0.85"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in. w.c. / 100 ft</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">Pa / m</span>
						</div>
					</label>

					<label class="block" data-duct-show="velocity" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Target velocity</span>
						<div class="flex">
							<input type="number" name="duct-velocity" min="0" step="any" value="7.5"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">fpm</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">m/s</span>
						</div>
					</label>

					<label class="block" data-duct-show="known" data-duct-duct="round" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Diameter</span>
						<div class="flex">
							<input type="number" name="duct-d-round" min="0" step="any" value="300"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">mm</span>
						</div>
					</label>

					<div class="grid grid-cols-2 gap-4" data-duct-show="known" data-duct-duct="rect" style="display:none;">
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Width</span>
							<div class="flex">
								<input type="number" name="duct-w" min="0" step="any" value="600"
									class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in</span>
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">mm</span>
							</div>
						</label>
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Height</span>
							<div class="flex">
								<input type="number" name="duct-h" min="0" step="any" value="300"
									class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in</span>
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">mm</span>
							</div>
						</label>
					</div>

					<label class="block">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Material</span>
						<select name="duct-material" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
							<option value="galvanized" selected>Galvanized steel (ε = 0.09 mm)</option>
							<option value="aluminum">Aluminum (ε = 0.04 mm)</option>
							<option value="pvc">PVC (ε = 0.03 mm)</option>
							<option value="fiberglass">Fibrous glass duct board (ε = 0.9 mm)</option>
							<option value="flex">Flex duct, extended (ε = 1.0 mm)</option>
							<option value="concrete">Concrete (ε = 1.5 mm)</option>
							<option value="custom">Custom roughness…</option>
						</select>
					</label>

					<label class="block" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Custom roughness (mm)</span>
						<input type="number" name="duct-custom-rough" min="0" step="any" value="0.09"
							class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
					</label>

					<label class="inline-flex items-center gap-2">
						<input type="checkbox" name="duct-snap" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
						<span class="text-sm text-zinc-700">Round up to nearest standard size</span>
					</label>

					<div class="pt-2 border-t border-slate-200">
						<button type="button" data-duct-reset class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-blue-700 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<polyline points="1 4 1 10 7 10"></polyline>
								<path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
							</svg>
							Reset to defaults
						</button>
					</div>

				</form>

				<?php /* ----- Results column ----- */ ?>
				<aside class="space-y-6">
					<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
						<h2 class="text-lg font-bold text-zinc-900 mb-4">Results</h2>
						<div data-duct-result class="space-y-1 text-sm">
							<p class="text-slate-500">Enter airflow to begin.</p>
						</div>
					</div>

					<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
						<h2 class="text-lg font-bold text-zinc-900 mb-4">Schematic</h2>
						<svg data-duct-schematic viewBox="0 0 200 140" class="w-full h-36 text-blue-700"
							xmlns="http://www.w3.org/2000/svg" aria-label="Duct schematic">
							<text x="100" y="60" text-anchor="middle" fill="#94a3b8" font-size="12">No duct yet</text>
						</svg>
					</div>

					<div class="text-xs text-slate-500 leading-relaxed">
						Single-segment sizing only. For multi-section systems, fitting losses, temperature/altitude correction, or duct schedules, consult an HVAC engineer. See the readme below for methodology and limitations.
					</div>
				</aside>

		</div>

		<?php /* ----- Methodology ----- */ ?>
		<section class="mt-16 prose max-w-none text-zinc-700">
			<h2 class="text-2xl font-bold text-zinc-900">Methodology</h2>
			<p>
				The Ductulator implements a single-segment sizing model with three modes: solve for duct size given airflow + target friction rate; solve for duct size given airflow + target velocity; or evaluate an existing duct size for resulting velocity, friction rate, and Reynolds number. Round and rectangular ducts are supported.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Friction loss</h3>
			<p>
				Pressure drop per unit length follows the Darcy-Weisbach equation, <code>ΔP/L = f · (V²/2D) · ρ</code>, where <em>f</em> is the Darcy friction factor, <em>V</em> is the air velocity, <em>D</em> is the duct diameter (or equivalent diameter for rectangular), and <em>ρ</em> is air density.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Friction factor</h3>
			<p>
				The Swamee-Jain explicit approximation of the Colebrook-White equation is used to avoid an inner iterative solve: <code>f = 0.25 / [log₁₀(ε/(3.7D) + 5.74/Re^0.9)]²</code>. This is the standard closed-form friction factor for fully turbulent flow, covering essentially all HVAC duct velocities.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Equivalent round diameter</h3>
			<p>
				Rectangular ducts use the ASHRAE equal-friction-and-capacity equivalent round: <code>De = 1.30 · (ab)^0.625 / (a + b)^0.25</code>. This finds the round duct with the same friction rate and the same airflow capacity, not just the same velocity.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Standard air</h3>
			<p>
				Standard air assumed: 21°C / 70°F at sea level, ρ = 1.204 kg/m³, ν = 1.51×10⁻⁵ m²/s. No temperature, altitude, or humidity correction.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Reference spot-check</h3>
			<p>
				The default load is <strong>1700 m³/h</strong> at <strong>0.85 Pa/m</strong> on galvanized steel, round duct. The solver returns a diameter of approximately <strong>345 mm</strong> at a velocity near <strong>5.05 m/s</strong>. With "Round up to standard size" enabled, that snaps to <strong>350 mm</strong> at ~4.9 m/s. This matches standard metric duct sizing charts for those inputs.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Limitations</h3>
			<ul>
				<li>Single straight section only — no fitting/elbow loss library, no summed pressure drop across a run.</li>
				<li>Standard-size list is a reasonable approximation, not a manufacturer spec.</li>
				<li>Velocity guidance (500–2500 fpm) is generic; not tied to duct location or building type.</li>
				<li>No SMACAC aspect-ratio warning above ~4:1.</li>
			</ul>
		</section>

		<?php /* Important Instructions — disclaimer; users must verify with specialists. */ ?>
		<aside class="mt-10 p-6 bg-amber-50 border border-amber-300 rounded-lg" aria-labelledby="duct-important-instructions-en">
			<h2 id="duct-important-instructions-en" class="text-2xl font-bold text-zinc-900 mb-3">Important Instructions</h2>
			<p class="text-zinc-800 leading-relaxed mb-3">
				Please contact us by email at
				<a href="mailto:info@emifree.com" class="text-blue-700 hover:text-blue-800 underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">info@emifree.com</a>
				if you find any errors, inaccuracies or otherwise unacceptable information.
			</p>
			<p class="text-zinc-800 leading-relaxed">
				The content of this tool may be used by any natural or legal person <strong>WITHOUT WARRANTY</strong> and <strong>WITHOUT LIABILITY</strong>. Important information should always be verified with alternative sources or experts. All applicable national and local regulations and practices on this subject must be strictly observed.
			</p>
		</aside>
	</div>

</div>