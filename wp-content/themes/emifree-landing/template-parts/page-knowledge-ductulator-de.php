<?php
/**
 * Knowledge Ductulator (DE) — /de/wissen/ductulator/.
 *
 * German equivalent of template-parts/page-knowledge-ductulator.php.
 * Hard-separated (not a language branch) per the active theme's
 * i18n convention — see page-blog-de.php for the parallel.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emifree_duct_i18n_de = array(
	'title'           => 'Kanalrechner',
	'subtitle'        => 'Dimensionieren Sie runde oder rechteckige Lüftungskanäle aus Luftstrom, Zielreibungsverlust oder Zielgeschwindigkeit. Normluft (21 °C, Meereshöhe).',
	'mode'            => 'Dimensionierungsmodus',
	'modeFriction'    => 'Reibungsverlust',
	'modeVelocity'    => 'Geschwindigkeit',
	'modeKnown'       => 'Bekannte Größe',
	'airflow'         => 'Luftstrom',
	'cfm'             => 'CFM',
	'm3h'             => 'm³/h',
	'friction'        => 'Zielreibungsverlust',
	'inwg'            => 'in. w.c. / 100 ft',
	'paM'             => 'Pa / m',
	'velocity'        => 'Zielgeschwindigkeit',
	'fpm'             => 'fpm',
	'mS'              => 'm/s',
	'shape'           => 'Kanalform',
	'round'           => 'Rund',
	'rect'            => 'Rechteckig',
	'units'           => 'Einheiten',
	'imperial'        => 'Imperial',
	'metric'          => 'Metrisch',
	'material'        => 'Material',
	'matGalvanized'   => 'Verzinkter Stahl',
	'matAluminum'     => 'Aluminium',
	'matPvc'          => 'PVC',
	'matFiberglass'   => 'Glasfaser-Kanalplatte',
	'matFlex'         => 'Flex-Kanal (gestreckt)',
	'matConcrete'     => 'Beton',
	'matCustom'       => 'Benutzerdefiniert',
	'customRough'     => 'Rauheit (mm)',
	'diameter'        => 'Durchmesser',
	'width'           => 'Breite',
	'height'          => 'Höhe',
	'widthIn'         => 'in',
	'heightIn'        => 'in',
	'snap'            => 'Auf Standardgröße aufrunden',
	'results'         => 'Ergebnisse',
	'labelDiameter'   => 'Durchmesser',
	'labelVelocity'   => 'Geschwindigkeit',
	'labelFriction'   => 'Reibungsverlust',
	'labelReynolds'   => 'Reynolds-Zahl',
	'labelFf'         => 'Reibungsfaktor',
	'labelEqDiameter' => 'Äquivalenter Ø',
	'resultEmpty'     => 'Luftstrom eingeben, um zu beginnen.',
	'schematicEmpty'  => 'Noch kein Kanal',
	'schematicLabel'  => 'Schema',
	'disclaimer'      => 'Nur Einzelabschnittsdimensionierung. Für Mehrabschnittssysteme, Formstückverluste, Temperatur-/Höhenkorrektur oder Kanalkalender wenden Sie sich an einen HLK-Ingenieur. Methodik und Einschränkungen siehe unten.',
	'backLink'        => 'Zurück zu Wissen',
);

wp_localize_script( 'emifree-section-ductulator', 'EMIFREE_DUCTULATOR_I18N', $emifree_duct_i18n_de );
?>

<div class="duct-root min-h-screen bg-white">

	<?php /* ----- Header band ----- */ ?>
	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
			<a href="<?php echo esc_url( home_url( '/de/wissen/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"></path>
				</svg>
				Zurück zu den Werkzeugen
			</a>

			<nav aria-label="breadcrumb" class="mb-6 text-sm text-zinc-500">
				<a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="hover:text-blue-700">Startseite</a>
				<span class="mx-2" aria-hidden="true">/</span>
				<a href="<?php echo esc_url( home_url( '/de/wissen/' ) ); ?>" class="hover:text-blue-700">Wissen</a>
				<span class="mx-2" aria-hidden="true">/</span>
				<span class="text-zinc-700">Kanalrechner</span>
			</nav>

			<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-zinc-900 leading-tight mb-4">
				Kanalrechner
			</h1>
			<p class="text-lg text-zinc-600 max-w-3xl">
				Dimensionieren Sie runde oder rechteckige Lüftungskanäle aus Luftstrom, Zielreibungsverlust oder Zielgeschwindigkeit. Normluft (21 °C, Meereshöhe).
			</p>
		</div>
	</div>

	<?php /* ----- Tool body ----- */ ?>
	<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

			<form class="lg:col-span-2 space-y-6 bg-slate-50 border border-slate-200 rounded-2xl p-6" onsubmit="return false;">

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Einheiten</span>
							<select name="duct-units" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
								<option value="metric" selected>Metrisch (m³/h, Pa/m, m/s)</option>
								<option value="imperial">Imperial (CFM, in.wg, fpm)</option>
							</select>
						</label>
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Kanalform</span>
							<select name="duct-shape" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
								<option value="round" selected>Rund</option>
								<option value="rect">Rechteckig</option>
							</select>
						</label>
					</div>

					<fieldset class="space-y-2">
						<legend class="text-sm font-medium text-zinc-700 mb-1">Dimensionierungsmodus</legend>
						<div class="flex flex-wrap gap-3">
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="friction" checked class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">Aus Reibungsverlust</span>
							</label>
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="velocity" class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">Aus Zielgeschwindigkeit</span>
							</label>
							<label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white cursor-pointer hover:border-blue-400">
								<input type="radio" name="duct-mode" value="known" class="text-blue-600 focus:ring-blue-500">
								<span class="text-sm">Bekannte Größe</span>
							</label>
						</div>
					</fieldset>

					<label class="block">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Luftstrom</span>
						<div class="flex">
							<input type="number" name="duct-q" min="0" step="any" value="1700"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">CFM</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">m³/h</span>
						</div>
					</label>

					<label class="block" data-duct-show="friction">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Zielreibungsverlust</span>
						<div class="flex">
							<input type="number" name="duct-friction" min="0" step="any" value="0.85"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in. w.c. / 100 ft</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">Pa / m</span>
						</div>
					</label>

					<label class="block" data-duct-show="velocity" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Zielgeschwindigkeit</span>
						<div class="flex">
							<input type="number" name="duct-velocity" min="0" step="any" value="7.5"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">fpm</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">m/s</span>
						</div>
					</label>

					<label class="block" data-duct-show="known" data-duct-duct="round" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Durchmesser</span>
						<div class="flex">
							<input type="number" name="duct-d-round" min="0" step="any" value="300"
								class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in</span>
							<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">mm</span>
						</div>
					</label>

					<div class="grid grid-cols-2 gap-4" data-duct-show="known" data-duct-duct="rect" style="display:none;">
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Breite</span>
							<div class="flex">
								<input type="number" name="duct-w" min="0" step="any" value="600"
									class="flex-1 rounded-l-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="imperial" style="display:none;">in</span>
								<span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm" data-duct-units="metric">mm</span>
							</div>
						</label>
						<label class="block">
							<span class="block text-sm font-medium text-zinc-700 mb-1">Höhe</span>
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
							<option value="galvanized" selected>Verzinkter Stahl (ε = 0,09 mm)</option>
							<option value="aluminum">Aluminium (ε = 0,04 mm)</option>
							<option value="pvc">PVC (ε = 0,03 mm)</option>
							<option value="fiberglass">Glasfaser-Kanalplatte (ε = 0,9 mm)</option>
							<option value="flex">Flex-Kanal, gestreckt (ε = 1,0 mm)</option>
							<option value="concrete">Beton (ε = 1,5 mm)</option>
							<option value="custom">Benutzerdefinierte Rauheit…</option>
						</select>
					</label>

					<label class="block" style="display:none;">
						<span class="block text-sm font-medium text-zinc-700 mb-1">Benutzerdefinierte Rauheit (mm)</span>
						<input type="number" name="duct-custom-rough" min="0" step="any" value="0.09"
							class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" inputmode="decimal">
					</label>

					<label class="inline-flex items-center gap-2">
						<input type="checkbox" name="duct-snap" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
						<span class="text-sm text-zinc-700">Auf nächste Standardgröße aufrunden</span>
					</label>

					<div class="pt-2 border-t border-slate-200">
						<button type="button" data-duct-reset class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-blue-700 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<polyline points="1 4 1 10 7 10"></polyline>
								<path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
							</svg>
							Auf Standardwerte zurücksetzen
						</button>
					</div>

				</form>

				<aside class="space-y-6">
					<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
						<h2 class="text-lg font-bold text-zinc-900 mb-4">Ergebnisse</h2>
						<div data-duct-result class="space-y-1 text-sm">
							<p class="text-slate-500">Luftstrom eingeben, um zu beginnen.</p>
						</div>
					</div>

					<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
						<h2 class="text-lg font-bold text-zinc-900 mb-4">Schema</h2>
						<svg data-duct-schematic viewBox="0 0 200 140" class="w-full h-36 text-blue-700"
							xmlns="http://www.w3.org/2000/svg" aria-label="Kanalschema">
							<text x="100" y="60" text-anchor="middle" fill="#94a3b8" font-size="12">Noch kein Kanal</text>
						</svg>
					</div>

					<div class="text-xs text-slate-500 leading-relaxed">
						Nur Einzelabschnittsdimensionierung. Für Mehrabschnittssysteme, Formstückverluste, Temperatur-/Höhenkorrektur oder Kanalkalender wenden Sie sich an einen HLK-Ingenieur. Methodik und Einschränkungen siehe unten.
					</div>
				</aside>

		</div>

		<section class="mt-16 prose max-w-none text-zinc-700">
			<h2 class="text-2xl font-bold text-zinc-900">Methodik</h2>
			<p>
				Der Kanalrechner implementiert ein Einzelabschnitts-Dimensionierungsmodell mit drei Modi: Kanalgröße aus Luftstrom + Zielreibungsverlust; Kanalgröße aus Luftstrom + Zielgeschwindigkeit; oder Bewertung einer vorhandenen Kanalgröße hinsichtlich Geschwindigkeit, Reibungsverlust und Reynolds-Zahl. Runde und rechteckige Kanäle werden unterstützt.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Druckverlust</h3>
			<p>
				Der Druckverlust pro Längeneinheit folgt der Darcy-Weisbach-Gleichung, <code>ΔP/L = f · (V²/2D) · ρ</code>, wobei <em>f</em> der Darcy-Reibungsfaktor, <em>V</em> die Luftgeschwindigkeit, <em>D</em> der Kanaldurchmesser (oder äquivalenter Durchmesser bei rechteckigen Kanälen) und <em>ρ</em> die Luftdichte ist.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Reibungsfaktor</h3>
			<p>
				Die explizite Swamee-Jain-Approximation der Colebrook-White-Gleichung wird verwendet, um eine innere iterative Lösung zu vermeiden: <code>f = 0,25 / [log₁₀(ε/(3,7D) + 5,74/Re^0,9)]²</code>. Dies ist die Standardformel für vollständig turbulente Strömung und deckt nahezu alle HLK-Kanalgeschwindigkeiten ab.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Äquivalenter Runddurchmesser</h3>
			<p>
				Rechteckige Kanäle verwenden den ASHRAE-äquivalenten Runddurchmesser mit gleichem Reibungsverlust und gleicher Luftstromkapazität: <code>De = 1,30 · (ab)^0,625 / (a + b)^0,25</code>.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Normluft</h3>
			<p>
				Normluft angenommen: 21 °C bei Meereshöhe, ρ = 1,204 kg/m³, ν = 1,51×10⁻⁵ m²/s. Keine Temperatur-, Höhen- oder Feuchtigkeitskorrektur.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Referenzwert</h3>
			<p>
				Die Standardeinstellung ist <strong>1700 m³/h</strong> bei <strong>0,85 Pa/m</strong> und verzinktem Stahl, Rundkanal. Der Löser liefert einen Durchmesser von ungefähr <strong>345 mm</strong> bei einer Geschwindigkeit nahe <strong>5,05 m/s</strong>. Mit aktivierter Standardgrößenaufrundung wird auf <strong>350 mm</strong> aufgerundet (~4,9 m/s). Dies entspricht den metrischen Standard-Kanaldimensionierungstabellen für diese Eingaben.
			</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-8">Einschränkungen</h3>
			<ul>
				<li>Nur einzelne gerade Abschnitte — keine Bibliothek für Formstück-/Bogenverluste, keine summierten Druckverluste über einen Strang.</li>
				<li>Standardgrößenliste ist eine sinnvolle Annäherung, keine Herstellerspezifikation.</li>
				<li>Geschwindigkeitsrichtwerte (2,5–12,5 m/s) sind generisch; nicht an Kanalposition oder Gebäudetyp gebunden.</li>
				<li>Keine SMACNA-Warnung bei Seitenverhältnissen über ~4:1.</li>
			</ul>
		</section>

		<?php /* Wichtige Hinweise — Haftungsausschluss; Anwender müssen mit Fachleuten abgleichen. */ ?>
		<aside class="mt-10 p-6 bg-amber-50 border border-amber-300 rounded-lg" aria-labelledby="duct-important-instructions-de">
			<h2 id="duct-important-instructions-de" class="text-2xl font-bold text-zinc-900 mb-3">Wichtige Hinweise</h2>
			<p class="text-zinc-800 leading-relaxed mb-3">
				Bitte kontaktieren Sie uns per E-Mail unter
				<a href="mailto:info@emifree.com" class="text-blue-700 hover:text-blue-800 underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">info@emifree.com</a>,
				falls Sie Fehler, Ungenauigkeiten oder anderweitig inakzeptable Angaben feststellen.
			</p>
			<p class="text-zinc-800 leading-relaxed">
				Die Inhalte dieses Werkzeugs dürfen von jeder natürlichen oder juristischen Person <strong>OHNE GEWÄHRLEISTUNG</strong> und <strong>OHNE HAFTUNG</strong> verwendet werden. Wichtige Informationen sollten stets mit alternativen Quellen oder Fachleuten verifiziert werden. Alle geltenden nationalen und lokalen Vorschriften und Praktiken zu diesem Thema sind strikt einzuhalten.
			</p>
		</aside>
	</div>

</div>