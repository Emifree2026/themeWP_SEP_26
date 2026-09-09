<?php
/**
 * Knowledge hub index, /knowledge/.
 *
 * Renders a navigation overview so visitors arriving via the "Knowledge"
 * nav link land somewhere they can pick where to go next:
 *
 *   1. Explore section: 4 cards linking to the dedicated sub-pages
 *      (Industry Insights, About Us, Downloads, Free Engineering Tools).
 *      These are the same destinations the homepage Knowledge-section
 *      tabs + "Open Our Free Engineering Tools" CTA point at, so the
 *      hub mirrors that information architecture one click deeper.
 *
 *   2. Tools section: the two flagship calculators (Duct Sizing +
 *      Air Pressure Loss) as direct links, since most visitors coming
 *      from a "knowledge hub" entry-point are calculator-shopping.
 *
 * Mirrors template-parts/page-blog-index.php's card grid pattern.
 */

require_once get_template_directory() . '/inc/knowledge.php';

// Sub-page overview. Mirrors the homepage Knowledge section's tab set
// (Industry Insights / About Us / Downloads) plus the standalone
// "Free Engineering Tools" CTA. Each href is the canonical sub-page
// URL the corresponding page-knowledge-*.php template handles.
$emifree_subpages = array(
	array(
		'slug'        => 'insights',
		'title'       => 'Industry Insights',
		'description' => 'Field reports, case studies, and engineering observations from industrial air-filtration deployments.',
		'icon'        => 'book-open',
		'url'         => home_url( '/en/knowledge/insights/' ),
	),
	array(
		'slug'        => 'about',
		'title'       => 'About Us',
		'description' => 'Our story, mission, and the team behind Emifree air-filtration systems.',
		'icon'        => 'users',
		'url'         => home_url( '/en/knowledge/about/' ),
	),
	array(
		'slug'        => 'downloads',
		'title'       => 'Product Brochures',
		'description' => 'PDF catalogs for ECO AIR and EARIA product lines, ready to download and share with your team.',
		'icon'        => 'download',
		'url'         => home_url( '/en/knowledge/downloads/' ),
	),
	array(
		'slug'        => 'tools',
		'title'       => 'Free Engineering Tools',
		'description' => 'Duct-sizing calculator, air-pressure-loss calculator, and references for HVAC design and air-filtration sizing.',
		'icon'        => 'wrench',
		'url'         => home_url( '/en/knowledge/tools/' ),
	),
);

// Existing direct-link calculators. Kept below the sub-page overview
// because most visitors landing on the hub want to pick a sub-section,
// not jump straight into a calculator.
$emifree_tools = array(
	array(
		'slug'        => 'ductulator',
		'title'       => 'Duct Sizing Calculator',
		'description' => 'Size round or rectangular HVAC ducts from airflow, friction rate, or velocity. Darcy-Weisbach + Swamee-Jain + ASHRAE equivalent diameter. Imperial and metric.',
		'icon'        => 'calculator',
		'url'         => home_url( '/en/knowledge/ductulator/' ),
	),
	array(
		'slug'        => 'air-pressure-loss-calculator',
		'title'       => 'Air Pressure Loss Calculator',
		'description' => 'Compute total air pressure loss (Pa) for a duct run. Friction loss for straight tubes + K-factor losses for elbows, T-junctions, reducers. Darcy-Weisbach + ASHRAE. Includes oil-mist and dust correction.',
		'icon'        => 'flow',
		'url'         => home_url( '/air-pressure-loss-calculator/' ),
	),
);

// Inline SVG icons. Kept inline to avoid an extra request for what is
// 4 glyphs total. Mirrors the icon style used in the homepage Knowledge
// section (lucide-style 24x24 stroke=2).
function emifree_subpage_icon( $emifree_slug ) {
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
			<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"></path>
				</svg>
				Back to home
			</a>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Knowledge</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Engineering tools, references, and field guides for HVAC duct design, air-filtration sizing, and industrial ventilation.
			</p>
		</div>
	</div>

	<?php /* ----- Explore: links to the four dedicated sub-pages ----- */ ?>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Explore</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<?php foreach ( $emifree_subpages as $emifree_subpage ) : ?>
				<a href="<?php echo esc_url( $emifree_subpage['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<?php echo emifree_subpage_icon( $emifree_subpage['icon'] ); ?>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_subpage['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_subpage['description'] ); ?></p>
					<span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-blue-700 group-hover:gap-2 transition-all">
						Open
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
						</svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<?php /* ----- Tools: direct links to the flagship calculators ----- */ ?>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Tools</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $emifree_tools as $emifree_tool ) : ?>
				<a href="<?php echo esc_url( $emifree_tool['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<?php echo emifree_subpage_icon( $emifree_tool['icon'] ); ?>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_tool['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_tool['description'] ); ?></p>
					<span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-blue-700 group-hover:gap-2 transition-all">
						Open tool
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 5 7 7-7 7"></path>
						</svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<p class="mt-12 text-sm text-slate-500">
			More tools and references coming soon. For engineering support, see the <a href="<?php echo esc_url( home_url( '/en/#contact' ) ); ?>" class="text-blue-700 hover:text-blue-800 font-medium">contact section</a>.
		</p>
	</div>

</div>
