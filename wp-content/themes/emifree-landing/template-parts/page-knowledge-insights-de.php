<?php
/**
 * Knowledge sub-page, DE: /de/wissen/insights/
 *
 * Deutsche Variante von page-knowledge-insights.php. Listet den
 * vollständigen DE-Blog-Feed (Legacy-PHP-Array + CPT-Einträge,
 * jüngste zuerst) und endet mit einem "Alle Artikel ansehen"-CTA
 * zurück zu /de/blog/.
 *
 * Substantielle Einleitung, damit die Seite nicht nur eine
 * Artikelliste ist, sondern Besuchern aus der Suche erklärt, welche
 * Themen sie hier erwarten.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/knowledge.php';
require_once get_template_directory() . '/inc/blog-cards.php';

$emifree_de_blog_posts = emifree_blog_posts_de();
$emifree_de_all_posts   = emifree_get_all_blog_posts_merged( 'de', $emifree_de_blog_posts );
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
					<li aria-current="page" class="text-slate-700">Branchen-Insights</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Branchen-Insights</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Technische Anleitungen, Dimensionierungsreferenzen und Praxisanmerkungen zur industriellen Luftfiltration, Ölnebelabscheidung und HLK-Kanalauslegung. Die Beiträge behandeln Filterauswahl, Druckverlust-Terminologie (Druckverlust versus Druckabfall), Methodik der Kanalauslegung sowie Fallstudien aus CNC-Bearbeitung, Automotive und Schwerindustrie.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<?php if ( empty( $emifree_de_all_posts ) ) : ?>
			<p class="text-slate-600">Noch keine Artikel veröffentlicht. Schauen Sie bald wieder vorbei oder durchsuchen Sie das vollständige <a href="<?php echo esc_url( home_url( '/de/blog/' ) ); ?>" class="text-blue-700 hover:text-blue-800 font-medium">Blog-Archiv</a>.</p>
		<?php else : ?>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
				<?php foreach ( $emifree_de_all_posts as $emifree_post ) : ?>
					<?php emifree_featured_blog_card( $emifree_post ); ?>
				<?php endforeach; ?>
			</div>

			<div class="text-center">
				<a
					href="<?php echo esc_url( home_url( '/de/blog/' ) ); ?>"
					class="inline-flex items-center gap-2 bg-white border-2 border-blue-700 text-blue-700 px-8 py-3 rounded-full font-semibold hover:bg-blue-700 hover:text-white transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
				>
					Alle Artikel ansehen
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
					</svg>
				</a>
			</div>
		<?php endif; ?>

		<?php /* Cross-Links zurück in den Knowledge-Hub */ ?>
		<div class="mt-16 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">Weitere Inhalte aus dem Wissen-Hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/de/wissen/ueber-uns/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Über uns</p>
					<p class="text-sm text-slate-600">Unsere Geschichte, Mission und Partner.</p>
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
