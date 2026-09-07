<?php
/**
 * Knowledge sub-page, DE: /de/wissen/downloads/
 *
 * Deutsche Variante von page-knowledge-downloads.php. Listet die
 * PDF-Broschüren mit substantieller Einleitung, wie sie die
 * Broschüren einsetzen sollen, und einem CTA-Kontakt-Banner für
 * Sonderdokumentation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/knowledge.php';

$emifree_knowledge_icons_de = emifree_knowledge_icons();
$emifree_catalog_pdfs_de     = emifree_catalog_pdfs();
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
					<li aria-current="page" class="text-slate-700">Downloads</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Produktbroschüren</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Laden Sie Emifree-Produktbroschüren und technische Datenblätter als PDF herunter. Der ECO-AIR-Reiniger-Katalog (Deutsch und Englisch, v4.2) ist die Hauptreferenz für unsere selbstreinigende mechanische Filtrationslinie. Der EARIA-Elektrostatik-Katalog und der Gesamtkatalog 2026 sind in Vorbereitung und werden hier veröffentlicht, sobald sie verfügbar sind.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
			<?php foreach ( $emifree_catalog_pdfs_de as $emifree_pdf ) : ?>
				<?php emifree_knowledge_pdf_card( $emifree_pdf, $emifree_knowledge_icons_de ); ?>
			<?php endforeach; ?>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">So nutzen Sie diese Broschüren</h2>
				<p class="text-lg text-slate-600 mb-6 leading-relaxed">
					Der ECO-AIR-Reiniger-Katalog ist die technische Referenz für unsere mechanische, selbstreinigende Filtrationslinie: Luftstrombereiche, HEPA-Optionen, Montagevarianten und Maßzeichnungen. Verwenden Sie ihn in der Anlagenauswahl-Phase, wenn Sie die ECO-AIR-Lösung mit Kartuschenfilter- oder Elektrostatik-Alternativen auf derselben Seite vergleichen möchten.
				</p>
				<p class="text-lg text-slate-600 leading-relaxed">
					Als <em>demnächst verfügbar</em> markierte Broschüren sind Übersetzungen oder erweiterte Versionen des ECO-AIR-Katalogs. Wenn Sie ein bestimmtes Datenblatt benötigen (z. B. eine CAD-Zeichnung für eine Sondermontage), kann unser Engineering-Team dieses auf Anfrage erstellen.
				</p>
			</div>

			<div class="rounded-3xl p-8 md:p-12 text-white" style="background: linear-gradient(90deg, #1d4ed8 0%, #06b6d4 100%);">
				<h2 class="text-2xl md:text-3xl font-bold mb-4">Benötigen Sie Sonderdokumentation?</h2>
				<p class="text-lg text-blue-100 mb-8">
					Sie finden nicht, was Sie suchen? Kontaktieren Sie unser technisches Team für kundenspezifische Datenblätter, CAD-Zeichnungen oder anwendungsspezifische Dokumentation.
				</p>
				<a
					href="<?php echo esc_url( home_url( '/de/#contact' ) ); ?>"
					class="inline-flex items-center gap-2 bg-white text-blue-700 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
				>
					Technischen Support kontaktieren
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<?php echo $emifree_knowledge_icons_de['arrow-right']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
					</svg>
				</a>
			</div>
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
				<a href="<?php echo esc_url( home_url( '/de/wissen/tools/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Kostenlose Werkzeuge</p>
					<p class="text-sm text-slate-600">Kanalauslegung + Druckverlustrechner.</p>
				</a>
			</div>
		</div>

	</div>

</div>
