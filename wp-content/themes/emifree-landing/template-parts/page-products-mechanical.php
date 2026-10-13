<?php
/**
 * Product page body, EN: /products/mechanical/
 *
 * Long-form landing for the ECO AIR Cleaner (mechanical) line. The
 * page-top stacks a "back to home" + breadcrumb + 2-col hero (logo +
 * gallery on the left, title + "Request a quote" CTA + intro on
 * the right), then the four content sections. In-page navigation
 * is provided by a vertical floating right-rail sub-menu on
 * desktop (lg+) and a single "Back to top" button on smaller
 * viewports; the active pill is set by an IntersectionObserver
 * at the bottom of this file.
 *
 * The hero band carries id="hero" so the 1st nav pill "To the top"
 * doubles as a "return to top" target: clicking it scrolls to the
 * top of the page, and the observer highlights it whenever the
 * hero is in view.
 *
 * Section order (top → bottom):
 *   1. Hero (id="hero"): logo, gallery (auto-rotating carousel),
 *      title, CTA, intro
 *   2. Dimensions: 2×2 grid of mechanical drawings
 *   3. Performance: 2×1 grid of pressure-loss / airflow curves
 *      (1200 m³/h + 1500 m³/h variants)
 *   4. Specs: 3-col table (Spec | Advanced | Premium + HEPA)
 *   5. Brochure: single ECO AIR Cleaner Catalog download card
 *   6. Cross-link strip: Electrostatic + Dust siblings + back-to-home
 *
 * The DE mirror (template-parts/page-products-mechanical-de.php) is
 * a byte-for-byte structural twin with German strings and a swapped
 * 4th dimension image.
 *
 * Self-contained: gallery + sub-menu JS are inline at the bottom of
 * this file as `<script type="module">`. The theme does not enqueue
 * a separate JS file for product pages; the prior products.js was
 * removed when the home-page section moved from a tabbed view to a
 * card grid (see the emifree-landing memory note on that work).
 *
 * Renders Breadcrumb back to /en/ (with an intermediate /en/#products
 * anchor for the "Products" crumb, since the parent page doesn't
 * exist as its own URL yet).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

// URIs for the two asset folders the page uses:
//   mechanical/  — the ECO AIR logo, dimension drawings, specs
//                  reference image (per-product assets, only used
//                  on the mechanical landing page).
//   ../          — the 3 product photos (fotom1, fotom5, fotom6)
//                  that double as the home-page product card
//                  image AND the gallery source. Lives in the
//                  parent assets/products/ folder so the home-
//                  page section template can keep using a single
//                  uri (template-parts/section-products.php).
$emifree_uri               = get_template_directory_uri() . '/assets/products/mechanical/';
$emifree_photos_uri        = get_template_directory_uri() . '/assets/products/';
$emifree_gallery           = emifree_get_mechanical_gallery();
$emifree_specs_rows        = emifree_get_mechanical_specs_rows();
$emifree_dimension_images  = emifree_get_mechanical_dimension_images( true );
$emifree_performance_curves = emifree_get_mechanical_performance_curves();
$emifree_brochure_url      = get_template_directory_uri() . '/assets/catalog/emifree_eco_air_cleaner_katalog_ENG_v4.2.pdf';
$emifree_contact_url       = home_url( '/en/?quote=mechanical#contact' );
?>

<div class="min-h-screen bg-white">

	<?php /* Page-top: back-to-home + breadcrumb + 2-col hero + Quotation block.
		 *
		 * The whole bg-slate-50 band carries id="hero" so the 1st nav
		 * pill "Quotation" (right-rail / sticky-top) serves two roles:
		 *   1. Scroll-spy anchor: the IntersectionObserver at the bottom
		 *      of this file watches #hero and highlights the "Quotation"
		 *      pill whenever any part of the hero band is in view (from
		 *      page top until just before the Dimensions section).
		 *   2. "Return to top" target: clicking "Quotation" scrolls to
		 *      #hero, which is the first element in the DOM, so the
		 *      user lands at the top of the page.
		 *
		 * The anchor sits on the outer band (not just on the Quotation
		 * h2) so the scroll-spy covers the whole hero region, not
		 * only the moment the heading crosses the 5% observer strip. */ ?>
	<div id="hero" class="bg-slate-50 border-b border-slate-200 scroll-mt-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
			<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M19 12H5"></path>
					<path d="m12 19-7-7 7-7"></path>
				</svg>
				Back to home
			</a>

			<nav aria-label="Breadcrumb" class="mb-8 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="hover:text-blue-700">Home</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/en/#products' ) ); ?>" class="hover:text-blue-700">Products</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Mechanical</li>
				</ol>
			</nav>

			<?php /* The 2-col grid hosts the magnify hover effect:
			 * `.emifree-magnify-source` is the `:hover` source for
			 * the right-column zoom panel (only on `lg+` — see
			 * tailwind.src.css `.emifree-zoom-panel`). */ ?>
			<div class="emifree-magnify-source grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<?php /* Left: logo + gallery */ ?>
				<div>
					<img
						src="<?php echo esc_url( $emifree_uri . 'eco_air_final.png' ); ?>"
						alt="ECO AIR Cleaner wordmark"
						class="w-48 md:w-56 h-auto mb-6"
						decoding="async"
					>

					<div data-emifree-gallery class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
						<?php /* Main image area, swapped by the inline JS below.
						 *
						 * On `lg+` viewports, hovering this image fades
						 * in a separate zoom panel in the right column
						 * (the title/intro slot) — see
						 * `.emifree-zoom-panel` in tailwind.src.css.
						 * The main image itself never moves; the panel
						 * is what shows the magnified view, with
						 * `object-position` driven by the cursor's
						 * position over this image (via the
						 * `--emifree-mx` / `--emifree-my` CSS vars on
						 * the parent 2-col grid). The standard
						 * e-commerce "Amazon"-style pattern. */ ?>
						<div class="aspect-[4/3] flex items-center justify-center p-6">
							<img
								data-emifree-gallery-main
								src="<?php echo esc_url( $emifree_photos_uri . $emifree_gallery[0]['filename'] ); ?>"
								alt="<?php echo esc_attr( $emifree_gallery[0]['alt'] ); ?>"
								class="max-w-full max-h-full object-contain transition-opacity duration-300"
								decoding="async"
							>
						</div>

						<?php /* Thumbnail strip: 2 real <button> elements, keyboard-friendly. */ ?>
						<div role="tablist" aria-label="Product photos" class="grid grid-cols-3 gap-2 p-2 bg-slate-50 border-t border-slate-200">
							<?php foreach ( $emifree_gallery as $emifree_idx => $emifree_photo ) : ?>
								<button
									type="button"
									role="tab"
									data-emifree-thumb
									data-thumb-src="<?php echo esc_url( $emifree_photos_uri . $emifree_photo['filename'] ); ?>"
									aria-label="<?php echo esc_attr( $emifree_photo['alt'] ); ?>"
									aria-current="<?php echo 0 === $emifree_idx ? 'true' : 'false'; ?>"
									class="aspect-[4/3] rounded-lg overflow-hidden bg-white border-2 border-transparent hover:border-blue-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-all duration-200 <?php echo 0 === $emifree_idx ? 'is-active' : ''; ?>"
								>
									<img
										src="<?php echo esc_url( $emifree_photos_uri . $emifree_photo['filename'] ); ?>"
										alt=""
										class="w-full h-full object-contain p-2"
										loading="lazy" decoding="async"
									>
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<?php /* Right: title + CTA + intro */ ?>
				<div class="relative emifree-zoom-slot min-h-[280px] md:min-h-[320px]">
					<?php /* Right column: title + CTA + intro by default, magnify
					 * panel on `lg+` hover of the gallery. The
					 * `.emifree-zoom-text` wrapper fades out while the
					 * panel is shown, then fades back in when the
					 * cursor leaves. The panel is `pointer-events:
					 * none` so the cursor passes through to the gallery
					 * below (no "stuck" hover). */ ?>
					<div class="emifree-zoom-text">
						<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">Mechanical Filtration</p>
						<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">Industrial Oil Mist Extraction</h1>
						<a
							href="<?php echo esc_url( $emifree_contact_url ); ?>"
							class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:shadow-lg transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 mb-6"
						>
							Request a quote
							<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M5 12h14"></path>
								<path d="m12 5 7 7-7 7"></path>
							</svg>
						</a>
						<p class="text-lg md:text-xl text-slate-600 leading-relaxed">
							Our mechanical filtration system use centrifugal force to separate oil mist and coolant fumes directly at the source for heavy-duty CNC machining environments.
						</p>
					</div>
					<div class="emifree-zoom-panel" aria-hidden="true">
						<?php /* The magnify panel renders the SAME image as a
						 * CSS background at 2.5x scale, not a second <img>
						 * with object-fit. With `background-size: 250%` +
						 * `background-position` driven by the cursor's
						 * percentage over the main image, the visible
						 * crop in this panel maps 1:1 to the pixel under
						 * the cursor. (An <img> with object-fit: contain
						 * letterboxes inside the element, so the cursor
						 * percentage would only describe a sub-region of
						 * the actual image — a background-image has no
						 * letterboxing, so the mapping stays accurate
						 * regardless of the image's aspect ratio.)
						 *
						 * `role="img"` + `aria-label` mirror the main
						 * image's alt so a screen reader announcing the
						 * panel content hears the same description as
						 * the static photo. The inline `background-image`
						 * seed is replaced by the gallery JS when the
						 * user clicks a different thumb. */ ?>
						<div
							data-emifree-zoom-image
							role="img"
							aria-label="<?php echo esc_attr( $emifree_gallery[0]['alt'] ); ?>"
							class="emifree-zoom-panel__bg"
							style="background-image: url('<?php echo esc_url( $emifree_photos_uri . $emifree_gallery[0]['filename'] ); ?>');"
						></div>
						<?php /* Small label at the bottom-right of the
						 * panel — tells the user this is a magnified
						 * view of the photo on the left. Helpful
						 * accessibility cue since the panel swaps in
						 * abruptly on hover. */ ?>
						<span class="emifree-zoom-panel__label">Magnified view</span>
					</div>
				</div>

			</div>
		</div>

	<?php /* Desktop (lg+) right-rail sub-menu — vertical floating
	 * pill bar pinned to the right edge of the viewport, "extended
	 * FAB" treatment. Items stacked top-to-bottom so the rail reads
	 * naturally without the eye having to traverse left-right.
	 *
	 * Why only on desktop: a right rail is ~130px wide; on a
	 * 375px mobile screen it would occupy the rightmost 35% of
	 * the viewport and overlap the dimensions / specs content.
	 * The right rail is hidden on mobile (`hidden lg:flex`) — the
	 * floating "Back to top" button below covers the small-viewport
	 * jump-to-top use case.
	 *
	 * The `padding-bottom: env(safe-area-inset-bottom)` inline
	 * style adds clearance for phones with a home-indicator notch
	 * (iPhone X+) even though the rail is desktop-only — keeps
	 * the style consistent with the back-to-top button below.
	 *
	 * Each link uses the `.emifree-product-submenu__link` class,
	 * so the IntersectionObserver at the bottom of the file
	 * highlights the active section in real time as the user
	 * scrolls. */ ?>
	<div class="hidden lg:flex fixed right-4 xl:right-6 top-1/2 -translate-y-1/2 z-40" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
		<nav aria-label="Page sections" class="flex flex-col items-center gap-1 p-2 bg-white/85 backdrop-blur-xl border border-slate-200/80 shadow-2xl rounded-full">
			<a href="#hero" data-section="hero" class="emifree-product-submenu__link inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M12 19V5"></path>
					<path d="m5 12 7-7 7 7"></path>
				</svg>
				To the top
			</a>
			<a href="#dimensions" data-section="dimensions" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Dimensions
			</a>
			<a href="#performance" data-section="performance" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Performance
			</a>
			<a href="#specs" data-section="specs" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Specs
			</a>
			<a href="#brochure" data-section="brochure" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Brochure
			</a>
		</nav>
	</div>

	<?php /* Floating "Back to top" button — the small-viewport nav.
	 * The right-rail sub-menu above covers desktop (lg+); the
	 * sticky-top bar is intentionally omitted on mobile because
	 * it would take ~64px of vertical space at the top of every
	 * scroll position. The button itself is hidden on the hero
	 * (via the JS show/hide below) so it doesn't sit on top of
	 * the page top until the user has actually scrolled past it.
	 *
	 * `padding-bottom: env(safe-area-inset-bottom)` keeps the
	 * button above the iPhone home indicator. Tailwind v3 doesn't
	 * ship safe-area utilities, so the inline style is the
	 * most maintainable fit. */ ?>
	<a href="#hero" data-emifree-back-to-top
		class="fixed right-4 bottom-4 lg:right-6 lg:bottom-6 z-40 inline-flex items-center gap-1.5 px-4 py-3 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-xl ring-1 ring-blue-700/20 hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors transition-opacity duration-200 opacity-0 pointer-events-none"
		style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px));"
		aria-label="Back to top">
		<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
			<path d="M12 19V5"></path>
			<path d="m5 12 7-7 7 7"></path>
		</svg>
		Up
	</a>

	<?php /* Dimensions section: 2x2 grid of mechanical drawings. */ ?>
	<section id="dimensions" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Dimensions</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Mechanical drawings of the ECO AIR Cleaner in its standard and HEPA-equipped configurations. All measurements are in millimeters.
			</p>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				<?php foreach ( $emifree_dimension_images as $emifree_dim ) : ?>
					<figure class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex items-center justify-center min-h-[280px]">
						<img
							src="<?php echo esc_url( $emifree_uri . $emifree_dim['filename'] ); ?>"
							alt="<?php echo esc_attr( $emifree_dim['alt'] ); ?>"
							loading="lazy" decoding="async"
							class="max-w-full max-h-[420px] object-contain"
						>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php /* Performance section: 2×1 grid of pressure-loss /
	 * airflow curves for the 1200 m³/h and 1500 m³/h
	 * ECO AIR Cleaner variants.
	 *
	 * The two images are rendered as <figure> cards in the same
	 * shape as the dimension drawings above (bg-slate-50 card,
	 * centered image, max-h-420px so neither curve dominates the
	 * row when one is taller than the other). Each card carries
	 * a small label below the image ("1200 m³/h" / "1500 m³/h")
	 * so the visitor can match the curve to the variant in the
	 * specs table below without having to read the axis text.
	 *
	 * The section uses `bg-slate-50` to alternate with the white
	 * Dimensions section above, matching the visual rhythm the
	 * page already uses (white / slate-50 between the existing
	 * sections). The `scroll-mt-20` keeps the sticky-top submenu
	 * from covering the heading after an anchor jump.
	 *
	 * Premium + HEPA is intentionally NOT shown here — the
	 * variable-speed drive on that variant lets the customer
	 * pick any operating point between the two fixed curves,
	 * so a single curve would be misleading. The specs table
	 * below already shows "—" for the Premium + HEPA Airflow
	 * row to reflect the same fact. */ ?>
	<section id="performance" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Performance</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Pressure-loss / airflow curves for the two ECO AIR Cleaner variants. The red marker on each curve shows the unit's nominal operating point.
			</p>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				<?php foreach ( $emifree_performance_curves as $emifree_curve ) : ?>
					<figure class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col items-center justify-center min-h-[280px] shadow-sm">
						<img
							src="<?php echo esc_url( $emifree_uri . $emifree_curve['filename'] ); ?>"
							alt="<?php echo esc_attr( $emifree_curve['alt'] ); ?>"
							loading="lazy" decoding="async"
							class="max-w-full max-h-[420px] object-contain"
						>
						<figcaption class="mt-4 text-sm font-semibold text-zinc-700">
							<?php echo esc_html( $emifree_curve['label'] ); ?>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php /* Specs section: 3-col table.
	 *
	 * Mobile (<sm): the table is wider than the viewport, so we set
	 * a `min-w-[640px]` floor on the <table> element and let the
	 * wrapper's `overflow-x-auto` produce a horizontal scrollbar.
	 * The "Swipe to see more" hint above the table (also <sm) tells
	 * the user the table is scrollable; the inline arrow icon fades
	 * the right edge via a CSS gradient mask so even before the user
	 * tries to scroll they can see there's more content.
	 *
	 * sm+ (>=640px): the 640px min-w no longer exceeds the viewport,
	 * so the table fits naturally and the hint is hidden (`sm:hidden`).
	 *
	 * Cell padding drops to `px-4` on mobile (from `px-6`) to claw
	 * back ~16px of horizontal space on a 375px viewport.
	 */ ?>
	<section id="specs" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Specs</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Technical comparison of the ECO AIR Cleaner in its two configurations: Advanced and Premium + HEPA. Optional variants and accessories are listed where applicable.
			</p>
			<p class="sm:hidden text-sm text-slate-500 mb-3 flex items-center gap-1.5" aria-hidden="true">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
				Swipe to see all columns
			</p>
			<div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200 emifree-specs-scroll">
				<table class="w-full text-left min-w-[640px]">
					<thead class="bg-blue-600 text-white">
						<tr>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Specification</th>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Advanced</th>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Premium + HEPA</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-200 text-slate-700">
						<?php foreach ( $emifree_specs_rows as $emifree_row ) : ?>
							<tr>
								<th scope="row" class="px-4 sm:px-6 py-3 font-medium text-zinc-900 align-top">
									<?php echo esc_html( $emifree_row['label'] ); ?>
								</th>
								<td class="px-4 sm:px-6 py-3 align-top"><?php echo esc_html( $emifree_row['advanced'] ); ?></td>
								<td class="px-4 sm:px-6 py-3 align-top"><?php echo esc_html( $emifree_row['premium'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<?php /* Brochure section: single ECO AIR Catalog download card. */ ?>
	<section id="brochure" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Brochure</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Download the ECO AIR CLEANER  catalogue for more information.
			</p>

			<a
				href="<?php echo esc_url( $emifree_brochure_url ); ?>"
				download
				class="group block max-w-xl bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
			>
				<div class="flex items-start gap-5">
					<div class="w-14 h-14 bg-blue-100 group-hover:bg-blue-700 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-300">
						<svg class="w-7 h-7 text-blue-700 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
							<polyline points="14 2 14 8 20 8"></polyline>
							<line x1="12" y1="18" x2="12" y2="12"></line>
							<polyline points="9 15 12 12 15 15"></polyline>
						</svg>
					</div>
					<div class="flex-1 min-w-0">
						<h3 class="text-xl font-semibold text-zinc-900 mb-1 leading-snug">ECO AIR Cleaner Catalog</h3>
						<div class="flex items-center gap-3 text-sm text-slate-500 mb-3">
							<span>v4.2</span>
							<span aria-hidden="true">·</span>
							<span>2.1 MB</span>
							<span aria-hidden="true">·</span>
							<span class="bg-slate-100 px-2 py-0.5 rounded text-xs font-semibold">EN</span>
						</div>
						<span class="inline-flex items-center gap-2 text-blue-700 group-hover:text-blue-800 font-semibold text-sm">
							Download PDF
							<svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
								<polyline points="7 10 12 15 17 10"></polyline>
								<line x1="12" y1="15" x2="12" y2="3"></line>
							</svg>
						</span>
					</div>
				</div>
			</a>
		</div>
	</section>

	<?php /* Cross-link strip: 2 sibling product cards + back-to-home. */ ?>
	<div class="mt-8 py-16 border-t border-slate-200 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl font-bold text-zinc-900 mb-6">Other product lines</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
				<a href="<?php echo esc_url( home_url( '/products/electrostatic/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Electrostatic Filtration</p>
					<p class="text-sm text-slate-600">Sub-micron particle capture for smoke, fine mist, and industrial odor control.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/products/dust/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Dust Filtration</p>
					<p class="text-sm text-slate-600">Cartridge and baghouse solutions for woodworking, metal grinding, and bulk material handling.</p>
				</a>
			</div>
			<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M19 12H5"></path>
					<path d="m12 19-7-7 7-7"></path>
				</svg>
				Back to home
			</a>
		</div>
	</div>

</div>

<?php /* Inline JS: gallery thumb swap + sub-menu active-pill on scroll.
   Deferred via type="module" so it doesn't block paint. Both blocks
   are guarded by feature checks (querySelector + IntersectionObserver)
   so older browsers fall back to a static page. */ ?>
<script type="module">
	// Gallery: click a thumb to swap the main image and toggle aria-current.
	// Auto-advances every 5 s; pauses on hover, focus, reduced-motion, or
	// when the gallery scrolls out of view. Manual clicks reset the timer.
	const emifreeGalleryRotator = 3000;
	const emifreePrefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	document.querySelectorAll('[data-emifree-gallery]').forEach((gallery) => {
		const main = gallery.querySelector('[data-emifree-gallery-main]');
		const zoom = document.querySelector('[data-emifree-zoom-image]');
		const thumbs = gallery.querySelectorAll('[data-emifree-thumb]');
		// The 2-col grid wrapper that hosts both the gallery and
		// the side-panel magnify. CSS vars for the magnify are
		// written here so the panel (sibling, not child) can
		// read them. Falls back to the gallery's parent if the
		// .emifree-magnify-source class isn't present (defensive
		// against future markup changes).
		const magnifySource = gallery.closest('.emifree-magnify-source') || gallery.parentElement;
		if (!main || thumbs.length < 2) {
			return;
		}

		let currentIndex = 0;
		let timerId = null;
		let isHovered = false;
		let hasFocus = false;
		let isVisible = true;

		const showIndex = (idx) => {
			const next = thumbs[idx];
			if (!next) {
				return;
			}
			const newSrc = next.getAttribute('data-thumb-src');
			if (!newSrc) {
				return;
			}
			currentIndex = idx;
			main.style.opacity = '0';
			window.setTimeout(() => {
				main.src = newSrc;
				main.alt = next.getAttribute('aria-label') || '';
				main.style.opacity = '1';
				// Keep the side-panel zoom in sync with the static
				// image. The panel is a <div> with a CSS background-
				// image (background-size: 250%, background-position
				// driven by the cursor's % over the gallery via
				// CSS vars on the 2-col grid wrapper); without
				// this swap the hover-zoom would show the previous
				// photo.
				if (zoom) {
					zoom.style.backgroundImage = "url('" + newSrc + "')";
				}
			}, 150);
			thumbs.forEach((t) => {
				t.setAttribute('aria-current', 'false');
				t.classList.remove('is-active');
			});
			next.setAttribute('aria-current', 'true');
			next.classList.add('is-active');
		};

		const advance = () => {
			showIndex((currentIndex + 1) % thumbs.length);
		};

		const start = () => {
			if (timerId !== null || emifreePrefersReduced) {
				return;
			}
			timerId = window.setInterval(advance, emifreeGalleryRotator);
		};

		const stop = () => {
			if (timerId === null) {
				return;
			}
			window.clearInterval(timerId);
			timerId = null;
		};

		// Manual click — jump to that thumb and restart the timer.
		thumbs.forEach((thumb, idx) => {
			thumb.addEventListener('click', () => {
				showIndex(idx);
				stop();
				start();
			});
		});

		// Pause on pointer hover / focus, resume on leave / blur.
		gallery.addEventListener('mouseenter', () => { isHovered = true;  stop(); });
		gallery.addEventListener('mouseleave', () => { isHovered = false; if (!hasFocus && isVisible) { start(); } });
		gallery.addEventListener('focusin',    () => { hasFocus   = true;  stop(); });
		gallery.addEventListener('focusout',   () => { hasFocus   = false; if (!isHovered && isVisible) { start(); } });

		// Pause when the gallery is mostly off-screen (saves cycles on long pages).
		if ('IntersectionObserver' in window) {
			const visObserver = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					isVisible = entry.isIntersecting;
					if (isVisible) {
						if (!isHovered && !hasFocus) { start(); }
					} else {
						stop();
					}
				});
			}, { threshold: 0.25 });
			visObserver.observe(gallery);
		}

		// Magnify: track the cursor over the main image and write
		// the relative position (0–100%) as CSS variables on the
		// 2-col grid wrapper. The `.emifree-zoom-panel` lives in
		// the right column, not the gallery, so the variables
		// need to live on a common ancestor — the grid wrapper.
		// The panel's `background-position` reads those vars, so
		// the visible magnified crop tracks the cursor 1:1.
		//
		// IMPORTANT: the cursor % is computed from the actual
		// <img> element's getBoundingClientRect(), NOT from the
		// padded `aspect-[4/3]` wrapper. The wrapper has `p-6`
		// padding around the image; measuring from the wrapper
		// would (a) treat hover-over-padding as a valid cursor
		// position (it's not — the image isn't there), and (b)
		// shift the mapping by ~6% on each axis (the padding's
		// share of the wrapper's width/height). Binding the
		// handler to the <img> also means hover events only fire
		// when the cursor is over real image pixels.
		//
		// Visibility of the side panel is gated by a
		// `emifree-magnify-source--active` class on the grid
		// wrapper that `mouseenter` adds and `mouseleave`
		// removes. The CSS uses that class (not `:hover` on the
		// grid, which would also fire while the cursor is in the
		// right column where the panel itself lives). Touch
		// devices (no mouse events) skip this entirely — the
		// panel stays at opacity 0 via the @media (hover: hover)
		// + (min-width: 1024px) gate in the CSS.
		if (zoom && magnifySource) {
			main.addEventListener('mouseenter', () => {
				magnifySource.classList.add('emifree-magnify-source--active');
			});
			main.addEventListener('mousemove', (e) => {
				const rect = main.getBoundingClientRect();
				let xPct = ((e.clientX - rect.left) / rect.width)  * 100;
				let yPct = ((e.clientY - rect.top)  / rect.height) * 100;
				if (xPct < 0) { xPct = 0; } else if (xPct > 100) { xPct = 100; }
				if (yPct < 0) { yPct = 0; } else if (yPct > 100) { yPct = 100; }
				magnifySource.style.setProperty('--emifree-mx', xPct + '%');
				magnifySource.style.setProperty('--emifree-my', yPct + '%');
			});
			// Reset on leave: drop the active class so the
			// panel fades out, and recenter the CSS vars so the
			// next hover doesn't briefly show a corner of the
			// panel. Bound to the <img> (not the padded wrapper)
			// so leaving the wrapper via the padding doesn't
			// trigger a reset while the cursor is still over a
			// real image pixel.
			main.addEventListener('mouseleave', () => {
				magnifySource.classList.remove('emifree-magnify-source--active');
				magnifySource.style.setProperty('--emifree-mx', '50%');
				magnifySource.style.setProperty('--emifree-my', '50%');
			});
		}

		// Kick off auto-rotation on initial load.
		start();
	});

	// Sub-menu: highlight the section currently in view.
	if ('IntersectionObserver' in window) {
		const submenuLinks = document.querySelectorAll('.emifree-product-submenu__link');
		const sectionMap = new Map();
		submenuLinks.forEach((a) => {
			const id = a.getAttribute('data-section');
			if (id) {
				sectionMap.set(id, a);
			}
		});
		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const link = sectionMap.get(entry.target.id);
					if (link) {
						submenuLinks.forEach((a) => {
							a.classList.remove('is-active');
							a.setAttribute('aria-current', 'false');
						});
						link.classList.add('is-active');
						link.setAttribute('aria-current', 'true');
					}
				}
			});
		}, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });
		sectionMap.forEach((_link, id) => {
			const section = document.getElementById(id);
			if (section) {
				observer.observe(section);
			}
		});
	}

	// Floating "Back to top" button: show it once the user has
	// scrolled past the hero, hide it when the hero is back in
	// view. Using an IntersectionObserver on the hero element
	// (rather than a scroll listener) keeps the show/hide work
	// off the main thread on every scroll tick.
	//
	// `rootMargin: '0px 0px -90% 0px'` shrinks the observation
	// root to the top 10% of the viewport — the button reveals
	// as soon as the hero has scrolled out of that strip,
	// matching the "past the fold" mental model the user has
	// when looking for a back-to-top control.
	if ('IntersectionObserver' in window) {
		const backToTop = document.querySelector('[data-emifree-back-to-top]');
		const hero = document.getElementById('hero');
		if (backToTop && hero) {
			const heroObserver = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						backToTop.classList.add('opacity-0', 'pointer-events-none');
						backToTop.classList.remove('opacity-100');
					} else {
						backToTop.classList.add('opacity-100');
						backToTop.classList.remove('opacity-0', 'pointer-events-none');
					}
				});
			}, { rootMargin: '0px 0px -90% 0px', threshold: 0 });
			heroObserver.observe(hero);
		}
	}
</script>
