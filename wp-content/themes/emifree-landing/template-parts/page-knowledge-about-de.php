<?php
/**
 * Knowledge sub-page, DE: /de/wissen/ueber-uns/
 *
 * Deutsche Variante von page-knowledge-about.php. Eigene Landingpage
 * für das "Über uns"-Thema. Hebt denselben Inhalt (Unsere Geschichte,
 * Kennzahlen, Mission, Werte, vertrauenswürdige Kunden) auf eine
 * eigene URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emifree_about_icons_de = array(
	'book-marked' => '<path d="M10 2h8a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-8a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path><path d="M16 2v4a2 2 0 0 0 2 2h-6a2 2 0 0 1-2-2V2"></path>',
	'leaf'        => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6"></path>',
	'shield'      => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>',
	'settings'    => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle>',
	'target'      => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle>',
);
?>

<div class="min-h-screen bg-white">

	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
			<nav aria-label="Brotkrumen" class="mb-6 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="hover:text-blue-700">Startseite</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/de/wissen/' ) ); ?>" class="hover:text-blue-700">Wissen</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Über uns</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Über Emifree</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Die Emifree GmbH entwickelt selbstreinigende Luftfiltrationssysteme aus Berlin, gegründet 2010. Wir konstruieren Filtrationsprodukte, die industrielle Verfügbarkeit mit Umweltverantwortung verbinden und ersetzen Einweg-Patronenfilter durch regenerierbare Medien, wo immer der Lastzyklus dies zulässt.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<?php /* Unsere Geschichte */ ?>
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 flex items-center gap-3 mb-6">
					<svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<?php echo $emifree_about_icons_de['book-marked']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
					</svg>
					Unsere Geschichte
				</h2>
				<p class="text-lg text-slate-600 mb-6 leading-relaxed">
					Die 2010 in Berlin gegründete Emifree GmbH entstand aus der Vision, Filtrationslösungen zu entwickeln, die industrielle Leistung mit Umweltverantwortung verbinden. Was als kleines Engineering-Team mit Fokus auf CNC-Bearbeitungsanwendungen begann, ist heute ein weltweit führender Anbieter von Luftfiltrationstechnologie mit über 500 Kunden in Automotive, Werkzeugmaschinenbau und Prozessindustrie.
				</p>

				<div class="grid grid-cols-3 gap-6">
					<?php
					$emifree_about_stats_de = array(
						array( 'value' => '2010', 'label' => 'Gegründet' ),
						array( 'value' => '500+', 'label' => 'Kunden weltweit' ),
						array( 'value' => '15+',  'label' => 'Länder' ),
					);
					foreach ( $emifree_about_stats_de as $emifree_stat ) :
						?>
						<div class="text-center">
							<div class="text-3xl font-bold text-blue-700 mb-1"><?php echo esc_html( $emifree_stat['value'] ); ?></div>
							<div class="text-sm text-slate-600"><?php echo esc_html( $emifree_stat['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="bg-gradient-to-br from-blue-100 to-cyan-50 rounded-3xl p-8 flex flex-col items-center justify-center aspect-video">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/berlin.png' ); ?>" alt="Standort Berlin" class="w-20 h-20 object-contain">
				<p class="text-lg font-semibold text-zinc-900 mt-4">Standort Berlin, Deutschland</p>
				<p class="text-sm text-slate-600">Weltweit im Einsatz seit 2010</p>
			</div>
		</div>

		<?php /* Unsere Mission */ ?>
		<div class="mb-16 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Unsere Mission</h2>
			<p class="text-lg text-slate-600 max-w-3xl mx-auto mb-12">
				Wir glauben, dass saubere Luft ein Grundrecht an jedem Arbeitsplatz ist. Unsere Mission ist die Entwicklung innovativer Filtrationstechnologien, die Beschäftigte schützen, die Umweltbelastung reduzieren und Industrien helfen, nachhaltiger zu arbeiten.
			</p>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
				<?php
				$emifree_about_values_de = array(
					array(
						'icon'  => 'leaf',
						'title' => 'Nachhaltigkeit',
						'desc'  => 'Produkte, die den ökologischen Fußabdruck minimieren',
					),
					array(
						'icon'  => 'shield',
						'title' => 'Sicherheit zuerst',
						'desc'  => 'Schutz der Gesundheit durch nachgewiesene Filtrationseffizienz',
					),
					array(
						'icon'  => 'settings',
						'title' => 'Innovation',
						'desc'  => 'Kontinuierliche Verbesserung von Technologie und Prozessen',
					),
					array(
						'icon'  => 'target',
						'title' => 'Zuverlässigkeit',
						'desc'  => 'Konstante Leistung, auf die sich unsere Kunden verlassen können',
					),
				);
				foreach ( $emifree_about_values_de as $emifree_value ) :
					?>
					<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300">
						<div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
							<svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<?php echo $emifree_about_icons_de[ $emifree_value['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
							</svg>
						</div>
						<h3 class="font-semibold text-zinc-900 mb-2"><?php echo esc_html( $emifree_value['title'] ); ?></h3>
						<p class="text-sm text-slate-600"><?php echo esc_html( $emifree_value['desc'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php /* Vertrauen von Branchenführern */ ?>
		<div class="bg-slate-100 rounded-3xl p-8 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-6">Vertrauen von Branchenführern</h2>
			<div class="flex flex-wrap justify-center gap-x-8 gap-y-3 items-center">
				<?php
				$emifree_about_clients_de = array(
					'Mercedes-Benz',
					'BMW',
					'General Motors',
					'NSK Bearings',
					'Knorr-Bremse',
					'Siemens',
					'Bosch',
					'ThyssenKrupp',
				);
				foreach ( $emifree_about_clients_de as $emifree_client_name ) :
					?>
					<span class="text-lg font-semibold text-slate-500 hover:text-slate-800 transition-colors duration-200">
						<?php echo esc_html( $emifree_client_name ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		</div>

		<?php /* Cross-Links zurück in den Wissen-Hub */ ?>
		<div class="mt-16 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">Weitere Inhalte aus dem Wissen-Hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/de/wissen/insights/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Branchen-Insights</p>
					<p class="text-sm text-slate-600">Technische Anleitungen und Praxisanmerkungen.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/de/wissen/tools/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Kostenlose Werkzeuge</p>
					<p class="text-sm text-slate-600">Kanalauslegung + Druckverlustrechner.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/de/wissen/downloads/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Produktbroschüren</p>
					<p class="text-sm text-slate-600">ECO-AIR-Katalog, technische Datenblätter.</p>
				</a>
			</div>
		</div>

	</div>

</div>
