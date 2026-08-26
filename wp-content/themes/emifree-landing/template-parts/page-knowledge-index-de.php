<?php
/**
 * Knowledge hub index (DE) — /de/wissen/.
 *
 * Hard-separated German equivalent of page-knowledge-index.php.
 * Same tool list, German labels.
 */

$emifree_tools = array(
	array(
		'slug'        => 'ductulator',
		'title'       => 'Kanalrechner',
		'description' => 'Dimensionieren Sie runde oder rechteckige HLK-Kanäle aus Luftstrom, Reibungsverlust oder Geschwindigkeit. Darcy-Weisbach + Swamee-Jain + ASHRAE-Äquivalentdurchmesser. Imperial und metrisch.',
		'url'         => home_url( '/de/wissen/ductulator/' ),
	),
	array(
		'slug'        => 'luftdruckverlust-rechner',
		'title'       => 'Luftdruckverlust-Rechner',
		'description' => 'Berechnen Sie den Gesamtdruckverlust (Pa) für einen Kanalstrang. Reibungsverlust für gerade Rohre + K-Faktor-Verluste für Bögen, T-Stücke und Reduzierstücke. Darcy-Weisbach + ASHRAE. Inkl. Ölnebel- und Staub-Korrektur.',
		'url'         => home_url( '/de/luftdruckverlust-rechner/' ),
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

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Wissen</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Technische Werkzeuge, Referenzen und Praxisanleitungen für HLK-Kanalauslegung, Luftfiltrationsdimensionierung und industrielle Lüftung.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Werkzeuge</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $emifree_tools as $emifree_tool ) : ?>
				<a href="<?php echo esc_url( $emifree_tool['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<rect x="4" y="2" width="16" height="20" rx="2"></rect>
							<line x1="8" y1="6" x2="16" y2="6"></line>
							<line x1="8" y1="10" x2="10" y2="10"></line>
							<line x1="13" y1="10" x2="16" y2="10"></line>
							<line x1="8" y1="14" x2="10" y2="14"></line>
							<line x1="13" y1="14" x2="16" y2="14"></line>
							<line x1="8" y1="18" x2="16" y2="18"></line>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_tool['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_tool['description'] ); ?></p>
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

		<p class="mt-12 text-sm text-slate-500">
			Weitere Werkzeuge und Referenzen folgen in Kürze. Für technische Unterstützung siehe den <a href="<?php echo esc_url( home_url( '/de/#contact' ) ); ?>" class="text-blue-700 hover:text-blue-800 font-medium">Kontaktbereich</a>.
		</p>
	</div>

</div>