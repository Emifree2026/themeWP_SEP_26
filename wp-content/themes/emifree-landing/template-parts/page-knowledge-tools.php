<?php
/**
 * Knowledge sub-page, EN: /en/knowledge/tools/
 *
 * Umbrella landing page for the Free Engineering Tools entry
 * point. The two individual tools (Duct Sizing Calculator,
 * Air Pressure Loss Calculator) keep their own dedicated pages
 * and remain the canonical answers for their long-tail queries.
 *
 * This page exists for the umbrella "free engineering tools"
 * head term and is the link target that the Knowledge hub's
 * "Open Our Free Engineering Tools" CTA points to.
 *
 * Cannibalization mitigation (per the SEO feedback):
 *  - The canonical points at /en/knowledge/tools/ itself.
 *  - Each tool card here links to the tool's dedicated page,
 *    NOT to a duplicate copy of the calculator. The calculator
 *    pages stay the authoritative sources.
 *  - The "Choosing the right tool" intro paragraph gives this
 *    page its own substantive content so Google sees it as a
 *    hub, not as a duplicate of the tool pages.
 *
 * Renders Breadcrumb back to /en/knowledge/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emifree_tools_icons = array(
	'calculator' => '<rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="8" y1="10" x2="10" y2="10"></line><line x1="13" y1="10" x2="16" y2="10"></line><line x1="8" y1="14" x2="10" y2="14"></line><line x1="13" y1="14" x2="16" y2="14"></line><line x1="8" y1="18" x2="16" y2="18"></line>',
	'flow'       => '<path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path>',
);

$emifree_tools_list = array(
	array(
		'slug'        => 'ductulator',
		'title'       => 'Duct Sizing Calculator',
		'description' => 'Size round or rectangular HVAC ducts from airflow, friction rate, or velocity. Darcy-Weisbach + Swamee-Jain + ASHRAE equivalent diameter. Imperial and metric.',
		'icon'        => 'calculator',
		'url'         => home_url( '/en/knowledge/ductulator/' ),
		'when_to_use' => 'Use this when you need to pick a duct cross-section for a given airflow and a target friction rate per 100 ft (or per meter). Outputs both round and rectangular equivalents so you can compare against existing shaft sizes.',
	),
	array(
		'slug'        => 'air-pressure-loss-calculator',
		'title'       => 'Air Pressure Loss Calculator',
		'description' => 'Compute total air pressure loss (Pa) for a duct run. Friction loss for straight tubes + K-factor losses for elbows, T-junctions, reducers. Darcy-Weisbach + ASHRAE. Includes oil-mist and dust correction.',
		'icon'        => 'flow',
		'url'         => home_url( '/air-pressure-loss-calculator/' ),
		'when_to_use' => 'Use this when you already have a duct geometry and need to know the static pressure the fan has to overcome, including losses across elbows, T-junctions, and reducers. Supports oil-mist and dust-laden airstreams.',
	),
);
?>

<div class="min-h-screen bg-white">

	<div class="bg-slate-50 border-b border-slate-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
			<nav aria-label="Breadcrumb" class="mb-6 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="hover:text-blue-700">Home</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/en/knowledge/' ) ); ?>" class="hover:text-blue-700">Knowledge</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Free Tools</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">Free Engineering Tools</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Two free, browser-based calculators for HVAC and air-filtration engineering. Both implement the Darcy-Weisbach friction equation with the Swamee-Jain explicit formula for the friction factor, the same methods used in ASHRAE Fundamentals and VDI 3802. No login, no install, and the formulas are visible on every page for auditability.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<?php /* "Choosing the right tool" intro — the cannibalization
		   mitigation. This page is NOT a duplicate of the tool pages,
		   it's an index. The paragraphs below explain when each
		   calculator is the right starting point so Google ranks
		   /en/knowledge/ductulator/ for the duct-sizing long tail and
		   /air-pressure-loss-calculator/ for the pressure-loss long
		   tail while THIS page ranks for the umbrella term. */ ?>
		<section class="mb-12">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Choosing the right tool</h2>
			<p class="text-lg text-slate-600 mb-4 leading-relaxed">
				Most HVAC and air-filtration calculations come down to two questions: <strong>what size should the duct be?</strong> and <strong>what is the resulting pressure loss?</strong> These are related, but they answer different design-stage questions, and Emifree provides a dedicated calculator for each.
			</p>
			<p class="text-lg text-slate-600 leading-relaxed">
				The <strong>Duct Sizing Calculator</strong> is for the <em>equipment-selection</em> phase: you have a target airflow (m3/h or CFM) and a friction-rate budget (Pa/m or in.wg per 100 ft), and you need to know what cross-section to specify. The <strong>Air Pressure Loss Calculator</strong> is for the <em>system-design</em> phase: you already have a duct geometry, and you need to know the total static pressure the fan has to overcome, including K-factor losses across elbows, T-junctions, and reducers, plus oil-mist and dust-correction multipliers when the airstream is loaded.
			</p>
		</section>

		<div class="flex items-center gap-2 mb-8 text-zinc-700">
			<svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6l3 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8l3-5z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6"></path>
			</svg>
			<h2 class="text-2xl font-bold">Available Tools</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
			<?php foreach ( $emifree_tools_list as $emifree_tool ) : ?>
				<a href="<?php echo esc_url( $emifree_tool['url'] ); ?>" class="group block bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl p-6 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<?php echo $emifree_tools_icons[ $emifree_tool['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
						</svg>
					</div>
					<p class="text-lg font-bold text-zinc-900 group-hover:text-blue-800 leading-snug">
						<?php echo esc_html( $emifree_tool['title'] ); ?>
					</p>
					<p class="text-sm text-zinc-600 mt-2"><?php echo esc_html( $emifree_tool['description'] ); ?></p>
					<p class="text-sm text-slate-700 mt-3 leading-relaxed">
						<strong>When to use it:</strong> <?php echo esc_html( $emifree_tool['when_to_use'] ); ?>
					</p>
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
				<a href="<?php echo esc_url( home_url( '/en/knowledge/downloads/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Product Brochures</p>
					<p class="text-sm text-slate-600">ECO AIR catalog, technical datasheets.</p>
				</a>
			</div>
		</div>

	</div>

</div>
