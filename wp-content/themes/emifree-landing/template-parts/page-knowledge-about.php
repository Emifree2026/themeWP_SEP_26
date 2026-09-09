<?php
/**
 * Knowledge sub-page, EN: /en/knowledge/about/
 *
 * Own landing page for the "About Us" topic. Lifts the same content
 * the hub's JS tab shows (Our Story, stats, mission, values,
 * trusted-by clients) onto its own URL so search engines can index
 * each piece of brand content individually.
 *
 * Renders Breadcrumb back to /en/knowledge/ so visitors landing here
 * from search have an obvious path to the rest of the Knowledge hub.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emifree_about_icons = array(
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
					<li aria-current="page" class="text-slate-700">About Us</li>
				</ol>
			</nav>

			<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-4">About Emifree</h1>
			<p class="text-xl text-zinc-600 max-w-3xl">
				Emifree GmbH engineers self-cleaning air filtration systems from Berlin, founded in 2010. We design filtration products that balance industrial uptime with environmental responsibility, replacing disposable cartridge filters with regenerable media wherever the duty cycle allows.
			</p>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<?php /* Our Story */ ?>
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 flex items-center gap-3 mb-6">
					<svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<?php echo $emifree_about_icons['book-marked']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
					</svg>
					Our Story
				</h2>
				<p class="text-lg text-slate-600 mb-6 leading-relaxed">
					Founded in Berlin in 2010, Emifree GmbH emerged from a vision to create filtration solutions that balance industrial performance with environmental responsibility. What started as a small engineering team focused on CNC machining applications has grown into a global leader in air filtration technology, with 500+ clients across automotive, machine tool, and process industries.
				</p>

				<div class="grid grid-cols-3 gap-6">
					<?php
					$emifree_about_stats = array(
						array( 'value' => '2010', 'label' => 'Founded' ),
						array( 'value' => '500+', 'label' => 'Clients Worldwide' ),
						array( 'value' => '15+',  'label' => 'Countries' ),
					);
					foreach ( $emifree_about_stats as $emifree_stat ) :
						?>
						<div class="text-center">
							<div class="text-3xl font-bold text-blue-700 mb-1"><?php echo esc_html( $emifree_stat['value'] ); ?></div>
							<div class="text-sm text-slate-600"><?php echo esc_html( $emifree_stat['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="bg-gradient-to-br from-blue-100 to-cyan-50 rounded-3xl p-8 flex flex-col items-center justify-center aspect-video">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/berlin.png' ); ?>" alt="Based in Berlin" class="w-20 h-20 object-contain">
				<p class="text-lg font-semibold text-zinc-900 mt-4">Based in Berlin, Germany</p>
				<p class="text-sm text-slate-600">Serving industry worldwide since 2010</p>
			</div>
		</div>

		<?php /* Our Mission */ ?>
		<div class="mb-16 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Our Mission</h2>
			<p class="text-lg text-slate-600 max-w-3xl mx-auto mb-12">
				We believe that clean air is a fundamental right in every workplace. Our mission is to develop innovative filtration technologies that protect workers, reduce environmental impact, and help industries operate more sustainably.
			</p>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
				<?php
				$emifree_about_values = array(
					array(
						'icon'  => 'leaf',
						'title' => 'Sustainability',
						'desc'  => 'Designing products that minimize environmental footprint',
					),
					array(
						'icon'  => 'shield',
						'title' => 'Safety First',
						'desc'  => 'Protecting worker health with proven filtration efficiency',
					),
					array(
						'icon'  => 'settings',
						'title' => 'Innovation',
						'desc'  => 'Continuously improving our technology and processes',
					),
					array(
						'icon'  => 'target',
						'title' => 'Reliability',
						'desc'  => 'Delivering consistent performance our customers can trust',
					),
				);
				foreach ( $emifree_about_values as $emifree_value ) :
					?>
					<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300">
						<div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
							<svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<?php echo $emifree_about_icons[ $emifree_value['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, controlled SVG markup. ?>
							</svg>
						</div>
						<h3 class="font-semibold text-zinc-900 mb-2"><?php echo esc_html( $emifree_value['title'] ); ?></h3>
						<p class="text-sm text-slate-600"><?php echo esc_html( $emifree_value['desc'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php /* Trusted by Industry Leaders */ ?>
		<div class="bg-slate-100 rounded-3xl p-8 text-center">
			<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-6">Trusted by Industry Leaders</h2>
			<div class="flex flex-wrap justify-center gap-x-8 gap-y-3 items-center">
				<?php
				$emifree_about_clients = array(
					'Mercedes-Benz',
					'BMW',
					'General Motors',
					'NSK Bearings',
					'Knorr-Bremse',
					'Siemens',
					'Bosch',
					'ThyssenKrupp',
				);
				foreach ( $emifree_about_clients as $emifree_client_name ) :
					?>
					<span class="text-lg font-semibold text-slate-500 hover:text-slate-800 transition-colors duration-200">
						<?php echo esc_html( $emifree_client_name ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		</div>

		<?php /* Cross-link to other Knowledge sub-pages */ ?>
		<div class="mt-16 pt-12 border-t border-slate-200">
			<h2 class="text-2xl font-bold text-zinc-900 mb-4">More from the Knowledge hub</h2>
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
				<a href="<?php echo esc_url( home_url( '/en/knowledge/insights/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Industry Insights</p>
					<p class="text-sm text-slate-600">Engineering guides and field notes.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/tools/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Free Engineering Tools</p>
					<p class="text-sm text-slate-600">Duct sizing + pressure loss calculators.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/en/knowledge/downloads/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50 transition-colors">
					<p class="font-semibold text-zinc-900 mb-1">Product Brochures</p>
					<p class="text-sm text-slate-600">ECO AIR catalog, technical datasheets.</p>
				</a>
			</div>
		</div>

	</div>

</div>
