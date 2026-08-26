<?php
/**
 * Luftdruckverlust-Rechner (DE) — /de/luftdruckverlust-rechner/.
 *
 * German equivalent of template-parts/page-knowledge-pressure-drop.php.
 * Hard-separated (not a language branch) per the active theme's
 * i18n convention.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Locale strings passed to the JS.
// Only Quick Calc keys are kept — the visual builder keys
// (toolbox, properties, results, K-factor library) were removed
// along with the canvas UI on 2026-08-25.
$emifree_pd_i18n_de = array(
	'airflow'        => 'Luftstrom',
	'material'       => 'Material',
	'variant'        => 'Anwendung',
	'quickTitle'     => 'Kanalstrang-Rechner',
	'quickSubtitle'  => 'Schnelle Druckverlustberechnung für industrielle Kanalstränge.',
	'addSection'     => 'Abschnitt hinzufügen',
	'remove'         => 'Entfernen',
	'calculate'      => 'Berechnen',
	'fanRec'         => 'Ventilator (2× Sicherheit)',
	'diameter'       => 'Durchmesser',
	'components'     => 'Komponenten',
	'addRow'         => '+ Komponente hinzufügen',
	'methodology'    => 'Methodik',
	'methodBody'     => '<b>1. Luftdaten (Normbedingungen, 20°C / Meereshöhe):</b> ρ = 1,2 kg/m³, μ = 1,81×10⁻⁵ Pa·s. <br><br><b>2. Strömungsgrößen pro Abschnitt:</b> D = Abschnittsdurchmesser (m), A = π·D²/4, V = Q/A, Re = ρ·V·D/μ. <br><br><b>3. Reibungsfaktor (Swamee–Jain, explizit):</b> f = 0,25 / [log₁₀(ε/3,7D + 5,74/Re⁰·⁹)]². ε nach Material: verzinkter Stahl = 0,15 mm, Aluminium = 0,0015 mm, Schwarzstahl = 0,045 mm. <br><br><b>4. Reibungsverlust gerader Rohre (Darcy–Weisbach):</b> ΔP_f = f·(L/D)·½·ρ·V² pro Zeile. <br><br><b>5. Einzelwiderstand Formstücke (K-Faktor, Idelchik / ASHRAE Mittelwerte):</b> ΔP_m = K·½·ρ·V² pro Zeile. K-Werte: 90°-Bogen = 0,18, 45°-Bogen = 0,20, T-Stück = 1,20, Y-Stück = 0,60, Reduzierstück = 0,10. <br><br><b>6. Reduzierstück-Durchmesserübergang:</b> Wird eine Zeile als Reduzierstück markiert, wird der effektive Durchmesser des Abschnitts ab dieser Zeile auf den Reduzierstück-Ausgang aktualisiert. <br><br><b>7. Anwendungskorrektur (K_app):</b> Der Roh-Gesamtverlust wird mit 1,0 (HVAC), 1,15 (Ölnebel, berücksichtigt die Reibung des Flüssigkeitsfilms an der Rohrwand) oder 1,25 (Staub, berücksichtigt Partikelbeschleunigung und Wandaufprall) multipliziert. <br><br><b>8. Endergebnis:</b> ΔP_gesamt = (Σ ΔP_f + Σ ΔP_m) × K_app. Empfohlener Ventilator-Statikdruck = ΔP_gesamt × 2 (branchenübliche 2×-Sicherheitsmarge).',
	'limitations'    => 'Einschränkungen',
	'limitBody'      => 'Nur Einzelstrang-Druckverlust — kein Mehrstrang-Abgleich, keine Lüfterauswahl, keine Temperatur-/Höhenkorrektur. K-Faktoren setzen turbulente Strömung voraus (Re > 4000). Passen Sie die K-Werte pro Komponente in der Bibliothek an, wenn Ihre Installation von den ASHRAE-Standards abweicht.',
);

wp_localize_script( 'emifree-section-pressure-drop', 'EMIFREE_PRESSUREDROP_I18N', $emifree_pd_i18n_de );
?>

<div class="pd-root min-h-screen bg-white">

	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-8">
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
				<span class="text-zinc-700">Luftdruckverlust-Rechner</span>
			</nav>

			<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-zinc-900 leading-tight mb-3">
				Luftdruckverlust-Rechner
			</h1>
			<p class="text-base sm:text-lg text-blue-800 font-medium max-w-3xl mb-2">
				Auch bekannt als: Kanal-Druckverlust-Rechner &middot; Luft-Druckabfall-Rechner &middot; HVAC-Statikdruck-Rechner &middot; Ventilator-&Delta;P-Rechner.
			</p>
			<p class="text-lg text-zinc-600 max-w-3xl">
				Berechnen Sie den <strong>Luftdruckverlust</strong> in HVAC-Kanälen, Ventilatoren und industriellen Absauganlagen. Kostenloses Online-Werkzeug für Ölnebel-Abscheidung, Staubabsaugung und Standard-HVAC &mdash; keine Anmeldung, keine Installation. Basiert auf Darcy&ndash;Weisbach-Reibung + Idelchik / ASHRAE K-Faktoren mit anwendungsspezifischer Korrektur für Ölnebel und Staub.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<div data-pd-tab="quick" class="pd-tab-panel">
			<div class="bg-white border border-slate-200 rounded-2xl p-6">
				<div class="flex items-center justify-between mb-4">
					<h2 class="text-lg font-bold text-zinc-900" data-pd-i18n="quickTitle">Kanalstrang-Rechner</h2>
					<button type="button" data-pd-quick-calc class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" data-pd-i18n="calculate">Berechnen</button>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-4 border-b border-slate-200">
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="airflow">Luftstrom</span>
						<div class="flex">
							<input type="number" name="pd-quick-airflow" min="0" step="any" value="1700" class="flex-1 min-w-0 rounded-l border border-slate-300 px-2 py-1.5 text-sm" inputmode="decimal">
							<span class="inline-flex items-center px-2 rounded-r border border-l-0 border-slate-300 bg-slate-50 text-slate-600 text-xs flex-shrink-0">m³/h</span>
						</div>
					</label>
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="material">Material</span>
						<select name="pd-quick-material" class="rounded border border-slate-300 px-2 py-1.5 text-sm">
							<option value="galvanized" selected>Verzinkter Stahl (k=0,15mm)</option>
							<option value="aluminum">Aluminium (k=0,0015mm)</option>
							<option value="blackSteel">Schwarzstahl (k=0,045mm)</option>
						</select>
					</label>
					<label class="flex flex-col gap-1">
						<span class="text-xs font-medium text-slate-600 uppercase tracking-wider" data-pd-i18n="variant">Anwendung</span>
						<select name="pd-quick-variant" class="rounded border border-slate-300 px-2 py-1.5 text-sm">
							<option value="oil-mist" selected>Ölnebel</option>
							<option value="dust">Staub</option>
							<option value="hvac">HVAC</option>
						</select>
					</label>
				</div>

				<div data-pd-quick-sections class="space-y-3"></div>

				<button type="button" data-pd-quick-add-section class="mt-3 inline-flex items-center gap-2 text-sm text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
					<span data-pd-i18n="addSection">Abschnitt hinzufügen</span>
				</button>

				<div data-pd-quick-result class="hidden mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
					<div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="frictionLoss">Reibung</div>
							<div data-pd-quick-friction class="font-mono text-lg font-bold text-zinc-900">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="minorLoss">Einzelwiderstände</div>
							<div data-pd-quick-minor class="font-mono text-lg font-bold text-zinc-900">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="totalDrop">Gesamt ΔP</div>
							<div data-pd-quick-total class="font-mono text-xl font-bold text-blue-700">0 Pa</div>
						</div>
						<div>
							<div class="text-xs text-slate-600 uppercase tracking-wider" data-pd-i18n="fanRec">Ventilator (2× Sicherheit)</div>
							<div data-pd-quick-fan class="font-mono text-lg font-bold text-zinc-700">0 Pa</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<section class="mt-12 prose max-w-none text-zinc-700">
			<h2 class="text-2xl font-bold text-zinc-900" data-pd-i18n="methodology">Methodik</h2>
			<p data-pd-i18n="methodBody"><b>1. Luftdaten (Normbedingungen, 20°C / Meereshöhe):</b> ρ = 1,2 kg/m³, μ = 1,81×10⁻⁵ Pa·s. <br><br><b>2. Strömungsgrößen pro Abschnitt:</b> D = Abschnittsdurchmesser (m), A = π·D²/4, V = Q/A, Re = ρ·V·D/μ. <br><br><b>3. Reibungsfaktor (Swamee–Jain, explizit):</b> f = 0,25 / [log₁₀(ε/3,7D + 5,74/Re⁰·⁹)]². ε nach Material: verzinkter Stahl = 0,15 mm, Aluminium = 0,0015 mm, Schwarzstahl = 0,045 mm. <br><br><b>4. Reibungsverlust gerader Rohre (Darcy–Weisbach):</b> ΔP_f = f·(L/D)·½·ρ·V² pro Zeile. <br><br><b>5. Einzelwiderstand Formstücke (K-Faktor, Idelchik / ASHRAE Mittelwerte):</b> ΔP_m = K·½·ρ·V² pro Zeile. K-Werte: 90°-Bogen = 0,18, 45°-Bogen = 0,20, T-Stück = 1,20, Y-Stück = 0,60, Reduzierstück = 0,10. <br><br><b>6. Reduzierstück-Durchmesserübergang:</b> Wird eine Zeile als Reduzierstück markiert, wird der effektive Durchmesser des Abschnitts ab dieser Zeile auf den Reduzierstück-Ausgang aktualisiert. <br><br><b>7. Anwendungskorrektur (K_app):</b> Der Roh-Gesamtverlust wird mit 1,0 (HVAC), 1,15 (Ölnebel, berücksichtigt die Reibung des Flüssigkeitsfilms an der Rohrwand) oder 1,25 (Staub, berücksichtigt Partikelbeschleunigung und Wandaufprall) multipliziert. <br><br><b>8. Endergebnis:</b> ΔP_gesamt = (Σ ΔP_f + Σ ΔP_m) × K_app. Empfohlener Ventilator-Statikdruck = ΔP_gesamt × 2 (branchenübliche 2×-Sicherheitsmarge).</p>
			<h3 class="text-xl font-semibold text-zinc-900 mt-6" data-pd-i18n="limitations">Einschränkungen</h3>
			<p data-pd-i18n="limitBody">Nur Einzelstrang-Druckverlust — kein Mehrstrang-Abgleich, keine Lüfterauswahl, keine Temperatur-/Höhenkorrektur. K-Faktoren setzen turbulente Strömung voraus (Re > 4000). Passen Sie die K-Werte pro Komponente in der Bibliothek an, wenn Ihre Installation von den ASHRAE-Standards abweicht.</p>
		</section>

		<?php /* Häufig gestellte Fragen — gepaart mit FAQPage-JSON-LD im Shim. */ ?>
		<section class="mt-12" aria-labelledby="pd-faq-de">
			<h2 id="pd-faq-de" class="text-2xl font-bold text-zinc-900 mb-6">Häufig gestellte Fragen</h2>
			<div class="space-y-4">
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Was ist Luftdruckverlust?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Luftdruckverlust (auch Druckabfall oder Kanal-Druckverlust) bezeichnet die Abnahme des statischen Drucks, wenn Luft durch ein Kanalstück, ein Formstück, einen Filter oder eine andere Komponente strömt. Gemessen wird er in Pascal (Pa) &mdash; er ist die wichtigste Größe bei der Auslegung eines Ventilators oder einer Absauganlage für HVAC, Ölnebel- oder Staubabsaugung. Druckverlust hat zwei Ursachen: <strong>Reibung</strong> an geraden Kanalwänden und <strong>Einzelwiderstände</strong> (Formstücke) an Bögen, Abzweigen, Übergängen und Filtern.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Wie berechne ich den Luftdruckverlust in einem Kanal?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Der Luftdruckverlust ist die Summe aus Reibungsverlust in geraden Rohren (Darcy&ndash;Weisbach, berechnet mit dem Swamee&ndash;Jain-Reibungsfaktor) und den K-Faktor-Verlusten jedes Formstücks im Strang (90&deg;-Bogen K &asymp; 0,18, 45&deg;-Bogen K &asymp; 0,20, T-Stück K &asymp; 1,20, Y-Stück K &asymp; 0,60, Reduzierstück K &asymp; 0,10). Für Ölnebel-Absaugung multiplizieren Sie die Summe mit 1,15, für Staubabsaugung mit 1,25, und verdoppeln Sie das Ergebnis als Sicherheitsmarge für den Ventilator. Dieser Rechner erledigt das alles automatisch &mdash; Luftstrom eingeben, Material und Anwendung wählen, Kanalabschnitte hinzufügen, auf Berechnen klicken.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Was ist der Unterschied zwischen Luftdruckverlust und Luftdruckabfall?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Es gibt keinen physikalischen Unterschied &mdash; beide Begriffe beschreiben dieselbe Größe (Abnahme des statischen Drucks in Pa). &bdquo;Druckverlust&ldquo; ist die deutsche Standardbezeichnung nach DIN / VDI; &bdquo;Druckabfall&ldquo; ist die wörtliche Übersetzung von &bdquo;pressure drop&ldquo; aus dem englischsprachigen ASHRAE-Standard. Suchmaschinen und Herstellerunterlagen verwenden beide Begriffe; dieser Rechner behandelt sie als gleichwertig.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Was ist ein normaler Luftdruckverlust für einen HVAC-Kanal?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Für einen typischen verzinkten HVAC-Versorgungskanal bei 1.500 m&sup3;/h ist mit etwa <strong>1 Pa pro Meter geradem Kanal</strong> zu rechnen (200 mm Durchmesser, f &asymp; 0,02) plus 5-12 Pa pro 90&deg;-Bogen und 30-70 Pa pro T-Abzweig. ASHRAE empfiehlt eine Reibungsrate von 0,8-1,2 Pa/m für Niederdruck-Hauptkanäle. Für industrielle Ölnebel- und Staubabsaugung liegt der Gesamt-Statikdruck üblicherweise bei 800-2.500 Pa, wenn Filter- und Zyklonverluste hinzukommen &mdash; dieser Rechner liefert nur den Kanalwert; Filterverlust separat addieren.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Welchen K-Faktor soll ich für einen 90&deg;-Bogen verwenden?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Das hängt von der Bogen-Geometrie ab. Übliche ASHRAE / Idelchik-Werte: <strong>Tiefgezogener 90&deg;-Bogen (r/D = 1,5)</strong> &rarr; K = 0,18; <strong>Gegrateter 90&deg;-Bogen ohne Leitschaufeln</strong> &rarr; K = 1,3; <strong>Gegrateter 90&deg;-Bogen mit Einzelleitschaufel</strong> &rarr; K = 0,5; <strong>Glattradius 90&deg; (r/D = 1,0)</strong> &rarr; K = 0,23. Dieser Rechner verwendet den tiefgezogenen r/D = 1,5-Wert von 0,18 &mdash; passen Sie den K-Faktor in der Methodik oben an, wenn Ihre Installation eine andere Geometrie verwendet.</p>
					</div>
				</details>
				<details class="group bg-white border border-slate-200 rounded-lg p-5" name="pd-faq-de-group">
					<summary class="flex items-start justify-between cursor-pointer list-none">
						<h3 class="text-lg font-semibold text-zinc-900 pr-4">Wie dimensioniere ich einen Ventilator für meinen Kanal?</h3>
						<svg class="w-5 h-5 text-slate-400 flex-shrink-0 transition-transform group-open:rotate-180 mt-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</summary>
					<div class="mt-3 text-zinc-700 leading-relaxed">
						<p>Zwei Größen sind nötig: Luftstrom (m&sup3;/h) und Statikdruck (Pa). Der Luftstrom wird durch die Anwendung bestimmt &mdash; bei Ölnebel 1.500-2.500 m&sup3;/h pro CNC, bei Staub 2.000-5.000 m&sup3;/h pro Zelle. Der Statikdruck ist der Kanal-Druckverlust aus diesem Rechner, <strong>plus Filter- und Zyklonverlust</strong> (typisch 500-1.500 Pa bei einer Ölnebel-Filterpatrone). Branchenüblich ist eine 2&times;-Sicherheitsmarge &mdash; dieser Rechner wendet das bereits an, sodass die Ausgabe &bdquo;Ventilator (2&times; Sicherheit)&ldquo; Ihre Mindest-Ventilatorleistung darstellt.</p>
					</div>
				</details>
			</div>
		</section>

		<?php /* Wichtige Hinweise — Haftungsausschluss; Anwender müssen mit Fachleuten abgleichen. */ ?>
		<aside class="mt-10 p-6 bg-amber-50 border border-amber-300 rounded-lg" aria-labelledby="pd-important-notes-de">
			<h2 id="pd-important-notes-de" class="text-2xl font-bold text-zinc-900 mb-3">Wichtige Hinweise</h2>
			<p class="text-zinc-800 leading-relaxed mb-3">
				Bitte kontaktieren Sie uns per E-Mail unter
				<a href="mailto:info@emifree.com" class="text-blue-700 hover:text-blue-800 underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">info@emifree.com</a>,
				falls Sie Fehler, Ungenauigkeiten oder anderweitig inakzeptable Angaben feststellen.
			</p>
			<p class="text-zinc-800 leading-relaxed">
				Die Inhalte dieses Werkzeugs dürfen von jeder natürlichen oder juristischen Person <strong>OHNE GEWÄHRLEISTUNG</strong> und <strong>OHNE HAFTUNG</strong> verwendet werden. Wichtige Informationen sollten stets mit alternativen Quellen oder Fachleuten abgeglichen werden. Alle geltenden nationalen und lokalen Vorschriften und Praktiken zu diesem Thema sind strikt einzuhalten.
			</p>
		</aside>
	</div>

</div>