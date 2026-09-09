<?php
/**
 * Knowledge sub-page, EN: /en/knowledge/downloads/
 *
 * Own landing page for the "Product Brochures" topic. Lifts the
 * same PDF card grid the hub's JS tab shows onto its own URL, plus
 * a substantial intro paragraph that names the documents (so this
 * page has more than a grid of links), explains how a visitor
 * should pick between the ECO AIR catalog and the broader range
 * brochures, and points readers back to the contact section for
 * custom datasheets.
 *
 * Renders Breadcrumb back to /en/knowledge/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/knowledge.php';

$emifree_knowledge_icons = emifree_knowledge_icons();
$emifree_catalog_pdfs     = emifree_catalog_pdfs();
?>

<div class="min-h-screen bg-white">

	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
			<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"></path>
				</svg>
				Back to home
			</a>

			<nav aria-label="Breadcrumb" class="mb-6 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="hover:text-blue-700">Home</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/en/knowledge/' ) ); ?>" class="hover:text-blue-700">Knowledge</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Downloads</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Product Brochures</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Download Emifree product brochures and technical datasheets as PDF. The ECO AIR Cleaner catalog (English and German, v4.2) is the primary reference for our self-cleaning mechanical filtration line; the EARIA electrostatic catalog and the Full Product Range 2026 are listed for completeness and will be published here as they become available.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<?php /* Brochure grid. Mirrors section-knowledge.php's Downloads
		   panel: real <a download> when the PDF exists, disabled card
		   with "coming soon" copy when it doesn't. The
		   emifree_catalog_pdfs() helper in inc/knowledge.php owns the
		   flag. */ ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
			<?php foreach ( $emifree_catalog_pdfs as $emifree_pdf ) : ?>
				<?php emifree_knowledge_pdf_card( $emifree_pdf, $emifree_knowledge_icons ); ?>
			<?php endforeach; ?>
		</div>

		<?php /* "How to use these brochures" intro — addresses the
		   thin-content signal by giving the page its own prose, not
		   just a grid of links. */ ?>
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">How to use these brochures</h2>
				<p class="text-lg text-slate-600 mb-6 leading-relaxed">
					The ECO AIR Cleaner catalog is the technical reference for our mechanical, self-cleaning filtration line: airflow ranges, HEPA options, mounting configurations, and dimensional drawings. Use it during the equipment-selection phase, when you need to compare the ECO AIR against cartridge-filter or electrostatic alternatives on the same page.
				</p>
				<p class="text-lg text-slate-600 leading-relaxed">
					Brochures marked <em>coming soon</em> are translations or expanded versions of the ECO AIR catalog. If you need a specific datasheet (e.g. a CAD drawing for a non-standard mounting), our engineering team can prepare it on request.
				</p>
			</div>

			<div class="rounded-3xl p-8 md:p-12 text-white" style="background: linear-gradient(90deg, #1d4ed8 0%, #06b6d4 100%);">
				<h2 class="text-2xl md:text-3xl font-bold mb-4">Need Custom Documentation?</h2>
				<p class="text-lg text-blue-100 mb-8">
					Can't find what you're looking for? Contact our technical team for custom datasheets, CAD drawings, or specific documentation for your application.
				</p>
				<a
					href="<?php echo esc_url( home_url( '/en/#contact' ) ); ?>"
					class="inline-flex items-center gap-2 bg-white text-blue-700 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
				>
					Contact Technical Support
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<?php echo $emifree_knowledge_icons['arrow-right']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
					</svg>
				</a>
			</div>
		</div>

		<?php /* Cross-link to other Knowledge sub-pages */ ?>
		<div class="mt-8 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">More from the Knowledge hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/en/knowledge/insights/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Industry Insights</p>
					<p class="text-sm text-slate-600">Engineering guides and field notes.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/about/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">About Emifree</p>
					<p class="text-sm text-slate-600">Our story, mission, and partners.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/tools/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Free Engineering Tools</p>
					<p class="text-sm text-slate-600">Duct sizing + pressure loss calculators.</p>
				</a>
			</div>
		</div>

	</div>

</div>
