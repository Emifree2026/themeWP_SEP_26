<?php
/**
 * Knowledge hub index (DE), /de/wissen/.
 *
 * Hard-separated German equivalent of page-knowledge-index.php.
 * Same overall structure: Explore (4 sub-page cards) above Tools
 * (2 flagship calculators), all copy translated, URLs point at the
 * /de/wissen/<sub>/ German sub-pages.
 */

// Sub-page overview. Mirrors the homepage Knowledge section's tab set
// (Brancheneinblicke / Über uns / Downloads) plus the standalone
// "Werkzeuge" CTA. Each href is the canonical DE sub-page URL.
$emifree_subpages = array(
	array(
		'slug'        => 'insights',
		'title'       => 'Brancheneinblicke',
		'description' => 'Praxisberichte, Fallstudien und technische Beobachtungen aus industriellen Luftfiltrationsanwendungen.',
		'icon'        => 'book-open',
		'url'         => home_url( '/de/wissen/insights/' ),
	),
	array(
		'slug'        => 'about',
		'title'       => 'Über uns',
		'description' => 'Unsere Geschichte, Mission und das Team hinter den Emifree-Luftfiltrationssystemen.',
		'icon'        => 'users',
		'url'         => home_url( '/de/wissen/about/' ),
	),
	array(
		'slug'        => 'downloads',
		'title'       => 'Produktbroschüren',
		'description' => 'PDF-Kataloge für die Produktlinien ECO AIR und EARIA, sofort herunterladbar und teilbar.',
		'icon'        => 'download',
		'url'         => home_url( '/de/wissen/downloads/' ),
	),
	array(
		'slug'        => 'tools',
		'title'       => 'Kostenlose Ingenieur-Werkzeuge',
		'description' => 'Kanalrechner, Luftdruckverlust-Rechner und Referenzen für die HLK-Auslegung sowie Luftfiltrationsdimensionierung.',
		'icon'        => 'wrench',
		'url'         => home_url( '/de/wissen/tools/' ),
	),
);

// Existing direct-link calculators. Kept below the sub-page overview
// because most visitors landing on the hub want to pick a sub-section,
// not jump straight into a calculator.
$emifree_tools = array(
	array(
		'slug'        => 'ductulator',
		'title'       => 'Kanalrechner',
		'description' => 'Dimensionieren Sie runde oder rechteckige HLK-Kanäle aus Luftstrom, Reibungsverlust oder Geschwindigkeit. Darcy-Weisbach + Swamee-Jain + ASHRAE-Äquivalentdurchmesser. Imperial und metrisch.',
		'icon'        => 'calculator',
		'url'         => home_url( '/de/wissen/ductulator/' ),
	),
	array(
		'slug'        => 'luftdruckverlust-rechner',
		'title'       => 'Luftdruckverlust-Rechner',
		'description' => 'Berechnen Sie den Gesamtdruckverlust (Pa) für einen Kanalstrang. Reibungsverlust für gerade Rohre + K-Faktor-Verluste für Bögen, T-Stücke und Reduzierstücke. Darcy-Weisbach + ASHRAE. Inkl. Ölnebel- und Staub-Korrektur.',
		'icon'        => 'flow',
		'url'         => home_url( '/de/luftdruckverlust-rechner/' ),
	),
);

// Inline SVG icons. Shared with the EN version's icon vocabulary
// (lucide-style 24x24 stroke=2), so DE/EN sub-pages render identical
// glyphs and only the surrounding copy differs.
function emifree_subpage_icon_de( $emifree_slug ) {
	switch ( $emifree_slug ) {
		case 'book-open':
			return '<path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H4a1 1 0 0 1-1-1z"></path><path d="M21 18a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7a1 1 0 0 0 1-1z"></path>';
		case 'users':
			return '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>';
		case 'download':
			return '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>';
		case 'wrench':
			return '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>';
		case 'calculator':
			return '<rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="8" y1="10" x2="10" y2="10"></line><line x1="13" y1="10" x2="16" y2="10"></line><line x1="8" y1="14" x2="10" y2="14"></line><line x1="13" y1="14" x2="16" y2="14"></line><line x1="8" y1="18" x2="16" y2="18"></line>';
		case 'flow':
			return '<path d="M3 7c0-1.66 4-3 9-3s9 1.34 9 3-4 3-9 3-9-1.34-9-3z"></path><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"></path><path d="M3 17c0 1.66 4 3 9 3s9-1.34 9-3"></path>';
		default:
			return '';
	}
}
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

	<?php /* ----- Erkunden: Links zu den vier Unterseiten ----- */ ?>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Erkunden</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<?php foreach ( $emifree_subpages as $emifree_subpage ) : ?>
				<a href="<?php echo esc_url( $emifree_subpage['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<?php echo emifree_subpage_icon_de( $emifree_subpage['icon'] ); ?>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_subpage['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_subpage['description'] ); ?></p>
					<span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-blue-700 group-hover:gap-2 transition-all">
						Öffnen
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
						</svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<?php /* ----- Werkzeuge: Direktlinks zu den Flaggschiff-Rechnern ----- */ ?>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
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
							<?php echo emifree_subpage_icon_de( $emifree_tool['icon'] ); ?>
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
