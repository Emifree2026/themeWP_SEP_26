<?php
/**
 * Knowledge sub-page, DE: /de/wissen/tools/
 *
 * Deutsche Variante von page-knowledge-tools.php. Sammelseite für
 * die kostenlosen Engineering-Werkzeuge. Die einzelnen
 * Werkzeug-Detailseiten bleiben die kanonischen Antworten für ihre
 * Long-Tail-Queries (Cannibalization-Mitigation).
 *
 * Die substantielle "Das passende Werkzeug wählen"-Einleitung macht
 * diese Seite zu einem echten Hub und nicht zu einem Duplikat der
 * Tool-Seiten.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emifree_tools_icons_de = array(
	'calculator' => '<rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="8" y1="10" x2="10" y2="10"></line><line x1="13" y1="10" x2="16" y2="10"></line><line x1="8" y1="14" x2="10" y2="14"></line><line x1="13" y1="14" x2="16" y2="14"></line><line x1="8" y1="18" x2="16" y2="18"></line>',
	'flow'       => '<path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path>',
);

$emifree_tools_list_de = array(
	// DE calculator routes are the existing registered URLs under /de/:
	// the duct sizer lives at /de/wissen/ductulator/ (canonical slug is
	// English by architectural decision, see functions.php rewrite
	// comments) and the air-pressure-loss calculator at
	// /de/luftdruckverlust-rechner/ (NOT a bare /de/druckverlust-rechner/,
	// that path 404s). Using wrong slugs here sent users to the homepage
	// or a 404; using these routes gives them the live calculator.
	array(
		'slug'        => 'ductulator',
		'title'       => 'Kanalauslegungs-Rechner',
		'description' => 'Runde oder rechteckige HLK-Kanäle aus Luftstrom, Reibungsrate oder Geschwindigkeit dimensionieren. Darcy-Weisbach + Swamee-Jain + ASHRAE-Äquivalentdurchmesser. Metrisch und imperial.',
		'icon'        => 'calculator',
		'url'         => home_url( '/de/wissen/ductulator/' ),
		'when_to_use' => 'Verwenden Sie dieses Werkzeug, wenn Sie einen Kanalquerschnitt für einen gegebenen Luftstrom und eine Ziel-Reibungsrate pro Meter (bzw. pro 100 ft) wählen müssen. Die Ausgabe enthält runde und rechteckige Äquivalente zum Vergleich mit bestehenden Schachtgrößen.',
	),
	array(
		'slug'        => 'luftdruckverlust-rechner',
		'title'       => 'Druckverlust-Rechner',
		'description' => 'Gesamtdruckverlust (Pa) einer Kanalstrecke berechnen. Reibungsverluste für gerade Rohre + K-Faktor-Verluste für Bögen, T-Stücke, Reduzierungen. Darcy-Weisbach + ASHRAE. Mit Ölnebel- und Staubkorrektur.',
		'icon'        => 'flow',
		'url'         => home_url( '/de/luftdruckverlust-rechner/' ),
		'when_to_use' => 'Verwenden Sie dieses Werkzeug, wenn Sie bereits eine Kanalgeometrie haben und wissen müssen, welchen statischen Druck das Gebläse überwinden muss, einschließlich der Verluste an Bögen, T-Stücken und Reduzierungen sowie Ölnebel- und Staubkorrekturen bei beladenen Luftströmen.',
	),
);
?>

<div class="min-h-screen bg-white">

	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
			<a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"></path>
				</svg>
				Zurück zur Startseite
			</a>

			<nav aria-label="Brotkrumen" class="mb-6 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="hover:text-blue-700">Startseite</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/de/wissen/' ) ); ?>" class="hover:text-blue-700">Wissen</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Werkzeuge</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Kostenlose Engineering-Werkzeuge</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Zwei kostenlose, browserbasierte Rechner für HLK- und Luftfiltrations-Engineering. Beide implementieren die Darcy-Weisbach-Reibungsgleichung mit der expliziten Swamee-Jain-Formel für den Reibungsfaktor, die gleichen Methoden wie in ASHRAE Fundamentals und VDI 3802. Kein Login, keine Installation, die Formeln sind auf jeder Seite zur Prüfbarkeit sichtbar.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<section class="mb-12">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Das passende Werkzeug wählen</h2>
			<p class="text-lg text-slate-600 mb-4 leading-relaxed">
				Die meisten HLK- und Luftfiltrations-Berechnungen laufen auf zwei Fragen hinaus: <strong>Welche Querschnittsfläche sollte der Kanal haben?</strong> und <strong>Welcher Druckverlust ergibt sich daraus?</strong> Diese Fragen hängen zusammen, beantworten aber unterschiedliche Designphasen, und Emifree stellt für jede einen eigenen Rechner bereit.
			</p>
			<p class="text-lg text-slate-600 leading-relaxed">
				Der <strong>Kanalauslegungs-Rechner</strong> ist für die <em>Anlagenauswahl-Phase</em>: Sie haben einen Ziel-Luftstrom (m3/h oder CFM) und ein Reibungsraten-Budget (Pa/m oder in.wg pro 100 ft) und müssen wissen, welchen Querschnitt Sie spezifizieren. Der <strong>Druckverlust-Rechner</strong> ist für die <em>Systemauslegungs-Phase</em>: Sie haben bereits eine Kanalgeometrie und müssen den gesamten statischen Druck kennen, den das Gebläse überwinden muss, einschließlich K-Faktor-Verlusten an Bögen, T-Stücken und Reduzierungen, plus Ölnebel- und Staub-Korrekturfaktoren bei beladenen Luftströmen.
			</p>
		</section>

		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Verfügbare Werkzeuge</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
			<?php foreach ( $emifree_tools_list_de as $emifree_tool ) : ?>
				<a href="<?php echo esc_url( $emifree_tool['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<?php echo $emifree_tools_icons_de[ $emifree_tool['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_tool['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_tool['description'] ); ?></p>
					<p class="text-sm text-slate-700 mt-3 leading-relaxed">
						<strong>Einsatzempfehlung:</strong> <?php echo esc_html( $emifree_tool['when_to_use'] ); ?>
					</p>
					<span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-blue-700 group-hover:gap-2 transition-all">
						Werkzeug öffnen
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
						</svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="mt-8 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">Weitere Inhalte aus dem Wissen-Hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/de/wissen/insights/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Branchen-Insights</p>
					<p class="text-sm text-slate-600">Technische Anleitungen und Praxisanmerkungen.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/de/wissen/ueber-uns/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Über uns</p>
					<p class="text-sm text-slate-600">Unsere Geschichte, Mission und Partner.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/de/wissen/downloads/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Produktbroschüren</p>
					<p class="text-sm text-slate-600">ECO-AIR-Katalog, technische Datenblätter.</p>
				</a>
			</div>
		</div>

	</div>

</div>
