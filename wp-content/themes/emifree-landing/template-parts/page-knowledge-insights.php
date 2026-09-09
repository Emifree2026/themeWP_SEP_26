<?php
/**
 * Knowledge sub-page, EN: /en/knowledge/insights/
 *
 * Lists the full EN blog feed (legacy PHP-array + CPT entries merged,
 * sorted newest first), gives every post its own card, and ends with
 * a "View All Articles" CTA back to /blog/.
 *
 * Why this page isn't just a redirect to /blog/: the Knowledge hub's
 * Industry Insights tab was previously only reachable under
 * /en/knowledge/, which conflated it with the rest of the hub. This
 * page gives the topic its own crawlable URL, an intro paragraph that
 * names what the visitor will find (filter-selection guides, sizing
 * references, terminology posts), and an internal link back to the
 * full /blog/ archive so Google can pass PageRank through it.
 *
 * Renders Breadcrumb back to /en/knowledge/ so visitors landing here
 * from search have an obvious path to the rest of the Knowledge hub.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/knowledge.php';
require_once get_template_directory() . '/inc/blog-cards.php';

$emifree_blog_posts = emifree_blog_posts();
$emifree_all_posts   = emifree_get_all_blog_posts_merged( 'en', $emifree_blog_posts );
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
					<li aria-current="page" class="text-slate-700">Industry Insights</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Industry Insights</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Engineering guides, sizing references, and field notes on industrial air filtration, oil-mist separation, and HVAC duct design. Posts cover filter selection, pressure-loss terminology (pressure loss vs pressure drop), duct sizing methodology, and case studies from CNC machining, automotive, and heavy industry.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<?php if ( empty( $emifree_all_posts ) ) : ?>
			<p class="text-slate-600">No articles published yet. Check back soon, or browse the full <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="text-blue-700 hover:text-blue-800 font-medium">blog archive</a>.</p>
		<?php else : ?>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
				<?php foreach ( $emifree_all_posts as $emifree_post ) : ?>
					<?php emifree_featured_blog_card( $emifree_post ); ?>
				<?php endforeach; ?>
			</div>

			<div class="text-center">
				<a
					href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
					class="inline-flex items-center gap-2 bg-white border-2 border-blue-700 text-blue-700 px-8 py-3 rounded-full font-semibold hover:bg-blue-700 hover:text-white transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
				>
					View All Articles
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
					</svg>
				</a>
			</div>
		<?php endif; ?>

		<?php /* Cross-link back into the rest of the Knowledge hub so
		   visitors landing here from search can reach the About and
		   Downloads sub-pages without having to back out to the hub. */ ?>
		<div class="mt-16 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">More from the Knowledge hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/en/knowledge/about/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">About Emifree</p>
					<p class="text-sm text-slate-600">Our story, mission, and the partners we serve.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/tools/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Free Engineering Tools</p>
					<p class="text-sm text-slate-600">Duct sizing + air pressure loss calculators.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/downloads/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Product Brochures</p>
					<p class="text-sm text-slate-600">ECO AIR Cleaner catalog, technical datasheets.</p>
				</a>
			</div>
		</div>
	</div>

</div>
