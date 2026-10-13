<?php
/**
 * Products section, German — image-backed category card grid.
 *
 * Three full-bleed image cards (Mechanische / Elektrostatische /
 * Staubfiltration) on a responsive grid. Each card is a real <a href>
 * so search engines and keyboard users can reach the category page.
 * The "Mehr anzeigen" CTA + darker gradient overlay are revealed on
 * hover and on keyboard focus; a visible focus ring makes the card
 * discoverable for keyboard users.
 *
 * No JavaScript dependency — replaces the prior tabbed view
 * (assets/js/sections/products.js) which is no longer enqueued.
 *
 * Self-contained: cards are inlined here (no call to
 * emifree_require_section_data( 'products' )), matching the original
 * German template's standalone approach.
 */

// One entry per category. Image filename is hardcoded (not pulled from
// the data array's images list) because the user picked a specific
// photo per card; this decouples the choice from data-array order.
$emifree_card_uri = get_template_directory_uri() . '/assets/products/';
$emifree_cards    = array(
	'mechanical'    => array(
		'title'      => 'Mechanische Filtration',
		'url'        => home_url( '/de/produkte/mechanische-filtration/' ),
		'image'      => 'fotom1.webp',
		'aria_label' => 'Mechanische Filtration — Kategorie anzeigen',
	),
	'electrostatic' => array(
		'title'      => 'Elektrostatische Filtration',
		'url'        => home_url( '/de/produkte/elektrostatische-filtration/' ),
		'image'      => 'fotoe2.webp',
		'aria_label' => 'Elektrostatische Filtration — Kategorie anzeigen',
	),
	'dust'          => array(
		'title'      => 'Staubfiltration',
		'url'        => home_url( '/de/produkte/entstaubung/' ),
		'image'      => 'dust_filter-emi.png',
		'aria_label' => 'Staubfiltration — Kategorie anzeigen',
	),
);
?>

<section id="products" class="py-12 md:py-24 bg-slate-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<div class="text-center mb-12">
			<h2 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-6">
				Industrielles Luftfiltrations-Produktsortiment
			</h2>
			<p class="text-xl text-zinc-600 max-w-3xl mx-auto">
				Professionelle Filtrationssysteme für CNC-Werkstätten, Metallbearbeitungsbetriebe und industrielle Fertigungsumgebungen.
			</p>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $emifree_cards as $emifree_key => $emifree_card ) : ?>
				<a
					href="<?php echo esc_url( $emifree_card['url'] ); ?>"
					class="product-card__link group relative block aspect-[4/5] overflow-hidden rounded-2xl shadow-md bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 transition-all duration-300 hover:-translate-y-2 focus-visible:-translate-y-2 hover:shadow-2xl focus-visible:shadow-2xl"
					aria-label="<?php echo esc_attr( $emifree_card['aria_label'] ); ?>"
				>
					<div class="flex flex-col h-full">
						<div class="relative flex-1 overflow-hidden">
							<img
								src="<?php echo esc_url( $emifree_card_uri . $emifree_card['image'] ); ?>"
								alt=""
								class="absolute inset-0 w-full h-full object-contain p-6 transition-transform duration-500 ease-out group-hover:scale-105 group-focus-visible:scale-105"
								loading="lazy" decoding="async"
								width="800" height="1000"
							>
						</div>
						<div class="bg-gradient-to-b from-blue-600 to-blue-800 text-white p-6 transition-all duration-300 group-hover:from-blue-700 group-hover:to-blue-900 group-focus-visible:from-blue-700 group-focus-visible:to-blue-900">
							<h3 class="text-2xl font-bold mb-2 drop-shadow-md">
								<?php echo esc_html( $emifree_card['title'] ); ?>
							</h3>
							<span
								class="product-card__cta inline-flex items-center gap-2 text-sm font-semibold md:opacity-0 md:-translate-y-2 transition-all duration-300 md:group-hover:opacity-100 md:group-hover:translate-y-0 md:group-focus-visible:opacity-100 md:group-focus-visible:translate-y-0"
								aria-hidden="true"
							>
								Mehr anzeigen
								<svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 group-focus-visible:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M5 12h14"></path>
									<path d="m12 5 7 7-7 7"></path>
								</svg>
							</span>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

	</div>
</section>
