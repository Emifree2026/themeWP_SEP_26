<?php
/**
 * Product page body, EN: /products/electrostatic/
 *
 * Long-form landing for the EARIA 1000 m³/h (electrostatic) line.
 * The page-top stacks a "back to home" + breadcrumb + 2-col hero
 * (logo + gallery on the left, title + "Request a quote" CTA +
 * intro on the right), then the four content sections. In-page
 * navigation is provided by a vertical floating right-rail
 * sub-menu on desktop (lg+) and a single "Back to top" button on
 * smaller viewports; the active pill is set by an
 * IntersectionObserver at the bottom of this file.
 *
 * The hero band carries id="hero" so the 1st nav pill "To the top"
 * doubles as a "return to top" target: clicking it scrolls to the
 * top of the page, and the observer highlights it whenever the
 * hero is in view.
 *
 * Section order (top → bottom):
 *   1. Hero (id="hero"): logo, gallery (auto-rotating carousel),
 *      title, CTA, intro — the "Request a quote" button here is
 *      the only conversion path on the page; the old standalone
 *      Quotation section at the bottom was removed in 2026-10.
 *   2. Dimensions: 2×2 grid of EARIA mechanical drawings
 *      (placeholders until the user supplies dimension images)
 *   3. Performance: single 1000 m³/h pressure-loss / airflow curve
 *      card (placeholder until supplied)
 *   4. Specs: 3-col table (Version | Basic | Premium) mirroring
 *      the mechanical landing's table pattern; the static
 *      earia_EN.png image is no longer rendered (it remains on
 *      disk for reference / future reuse)
 *   5. Cross-link strip: Mechanical + Dust siblings + back-to-home
 *
 * The DE mirror (template-parts/page-products-electrostatic-de.php)
 * is a structural twin with German strings, a swapped spec image
 * (earia_DE_final2.png), and DE placeholder filenames.
 *
 * No brochure section: the user has not yet supplied a
 * downloadable EARIA PDF — when one ships, add a Brochure section
 * between Specs and the cross-link strip following the mechanical
 * pattern.
 *
 * Self-contained: gallery + sub-menu JS are inline at the bottom
 * of this file as `<script type="module">`. The theme does not
 * enqueue a separate JS file for product pages.
 *
 * Renders Breadcrumb back to /en/ (with an intermediate /en/#products
 * anchor for the "Products" crumb, since the parent page doesn't
 * exist as its own URL yet).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

// URIs for the asset folders the page uses:
//   electrostatic/  — the EARIA logo (earia_final.png). The per-
//                    language spec table PNGs (earia_EN.png /
//                    earia_DE_final2.png) are still on disk for
//                    reference / future reuse but the page no
//                    longer renders them — the specs section now
//                    uses a structured HTML table (see below).
//   ../            — the 3 product photos (fotoe1/2/3.webp)
//                    that double as the home-page product card
//                    image AND the gallery source. Lives in the
//                    parent assets/products/ folder so the home-
//                    page section template can keep using a single
//                    uri (template-parts/section-products.php).
$emifree_uri               = get_template_directory_uri() . '/assets/products/electrostatic/';
$emifree_photos_uri        = get_template_directory_uri() . '/assets/products/';
$emifree_gallery           = emifree_get_electrostatic_gallery();
$emifree_specs_rows        = emifree_get_electrostatic_specs_rows( 'en' );
$emifree_dimension_images  = emifree_get_electrostatic_dimension_images( true );
$emifree_performance_curves = emifree_get_electrostatic_performance_curves( 'en' );
$emifree_cta               = emifree_get_electrostatic_cta( 'en' );
$emifree_contact_url       = home_url( '/en/?quote=electrostatic#contact' );
?>

<div class="min-h-screen bg-white">

	<?php /* Page-top: back-to-home + breadcrumb + 2-col hero.
		 *
		 * The whole bg-slate-50 band carries id="hero" so the 1st nav
		 * pill "To the top" serves two roles:
		 *   1. Scroll-spy anchor: the IntersectionObserver at the bottom
		 *      of this file watches #hero and highlights the "To the top"
		 *      pill whenever any part of the hero band is in view.
		 *   2. "Return to top" target: clicking it scrolls to #hero,
		 *      which is the first element in the DOM.
		 *
		 * The anchor sits on the outer band (not just on a heading)
		 * so the scroll-spy covers the whole hero region, not only
		 * the moment the heading crosses the 5% observer strip. */ ?>
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
					<li aria-current="page" class="text-slate-700">Electrostatic</li>
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
						src="<?php echo esc_url( $emifree_uri . 'earia_final.png' ); ?>"
						alt="EARIA wordmark"
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

						<?php /* Thumbnail strip: 3 real <button> elements, keyboard-friendly. */ ?>
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
						<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">Electrostatic Filtration</p>
						<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">Sub-Micron Particle Capture</h1>
						<a
							href="<?php echo esc_url( $emifree_contact_url ); ?>"
							class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:shadow-lg transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 mb-6"
						>
							<?php echo esc_html( $emifree_cta ); ?>
							<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M5 12h14"></path>
								<path d="m12 5 7 7-7 7"></path>
							</svg>
						</a>
						<p class="text-lg md:text-xl text-slate-600 leading-relaxed">
							The EARIA 1000 m³/h electrostatic precipitator captures sub-micron particles — smoke, fine mist, and industrial odor — directly at the source, with adjustable airflow and an optional touch-panel control system.
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
			<?php /* Right-rail sub-menu no longer links to a Quotation
			 * section (the hero CTA is the only conversion path now). */ ?>
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
		class="fixed right-4 bottom-4 lg:hidden z-40 inline-flex items-center gap-1.5 px-4 py-3 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-xl ring-1 ring-blue-700/20 hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors transition-opacity duration-200 opacity-0 pointer-events-none"
		style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px));"
		aria-label="Back to top">
		<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
			<path d="M12 19V5"></path>
			<path d="m5 12 7-7 7 7"></path>
		</svg>
		Up
	</a>

	<?php /* Dimensions section: 2x2 grid of dimension drawings.
		 * Placeholders until the user supplies dimension images. */ ?>
	<section id="dimensions" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Dimensions</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Mechanical drawings of the EARIA 1000 m³/h electrostatic precipitator in its standard and touch-panel configurations. All measurements are in millimeters.
			</p>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				<?php foreach ( $emifree_dimension_images as $emifree_dim ) : ?>
					<figure class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex items-center justify-center min-h-[280px]">
						<img
							src="<?php echo esc_url( $emifree_dim['uri'] ); ?>"
							alt="<?php echo esc_attr( $emifree_dim['alt'] ); ?>"
							loading="lazy" decoding="async"
							class="max-w-full max-h-[420px] object-contain"
						>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php /* Performance section: EARIA self-cleaning vs.
		 * conventional-system comparison graph. The graph is a
		 * single landscape PNG (per language), so we render it
		 * full-width inside a single figure — no 2-col grid, no
		 * "1000 m³/h" figcaption (the old label was specific to
		 * the per-variant pressure-loss curve; the new comparison
		 * graph has no variant number to call out).
		 *
		 * Stacked layout per the user: heading → caption → graph.
		 * `bg-slate-50` alternates with the white Dimensions
		 * section above; `scroll-mt-20` keeps the sticky-top
		 * submenu from covering the heading after an anchor jump.
		 *
		 * `max-h-[520px]` (vs. 420px on the old per-variant card)
		 * gives the landscape graph a bit more room on tall
		 * viewports without making it dominate the page; the
		 * `object-contain` keeps the legend text readable on any
		 * width. */ ?>
	<section id="performance" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Stop Losing Performance</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				See the difference between standard filtration and the Emifree System. Our self-cleaning technology maintains a consistent cycle of high-efficiency filtration, while conventional systems suffer a permanent drop in efficiency.
			</p>
			<?php foreach ( $emifree_performance_curves as $emifree_curve ) : ?>
				<figure class="bg-white border border-slate-200 rounded-2xl p-6 flex items-center justify-center shadow-sm">
					<img
						src="<?php echo esc_url( $emifree_curve['uri'] ); ?>"
						alt="<?php echo esc_attr( $emifree_curve['alt'] ); ?>"
						loading="lazy" decoding="async"
						class="w-full max-h-[520px] object-contain"
					>
				</figure>
			<?php endforeach; ?>
		</div>
	</section>

	<?php /* Specs section: 3-col table (Version | Basic | Premium).
		 *
		 * Mirrors the mechanical page's specs table exactly:
		 * `min-w-[640px]` on the <table> + `overflow-x-auto` on the
		 * wrapper produces a horizontal scroll on phones; the
		 * "Swipe to see all columns" hint (sm:hidden) tells mobile
		 * users the table is scrollable. Cell padding drops to
		 * `px-4` on mobile (from `px-6`) to claw back ~16px of
		 * horizontal space on a 375px viewport.
		 *
		 * The "Version" column header (rather than "Specification"
		 * like the mechanical table) matches the layout of the
		 * published EARIA spec sheet the user transcribed; see
		 * emifree_get_electrostatic_specs_rows() for the row data
		 * and the per-cell reasoning (some cells have asymmetric
		 * bracket styles, mixed decimal separators, etc., all
		 * preserved verbatim from the source). */
	?>
	<section id="specs" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Specs</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Technical comparison of the EARIA 1000 m³/h in its two configurations: Basic and Premium.
			</p>
			<p class="sm:hidden text-sm text-slate-500 mb-3 flex items-center gap-1.5" aria-hidden="true">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
				Swipe to see all columns
			</p>
			<div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200 emifree-specs-scroll">
				<table class="w-full text-left min-w-[640px]">
					<thead class="bg-blue-600 text-white">
						<tr>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Version</th>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Basic</th>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Premium</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-200 text-slate-700">
						<?php foreach ( $emifree_specs_rows as $emifree_row ) : ?>
							<tr>
								<th scope="row" class="px-4 sm:px-6 py-3 font-medium text-zinc-900 align-top">
									<?php echo esc_html( $emifree_row['label'] ); ?>
								</th>
								<td class="px-4 sm:px-6 py-3 align-top"><?php echo esc_html( $emifree_row['basic'] ); ?></td>
								<td class="px-4 sm:px-6 py-3 align-top"><?php echo esc_html( $emifree_row['premium'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<?php /* Cross-link strip: 2 sibling product cards + back-to-home.
		 *
		 * The Quotation section that used to live here was removed
		 * in the user's "eliminate the last quotation section"
		 * request — the hero CTA is the only "Request a quote" /
		 * "Angebot anfordern" path now. The right-rail sub-menu
		 * above no longer has a Quotation pill. */ ?>
	<div class="mt-8 py-16 border-t border-slate-200 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl font-bold text-zinc-900 mb-6">Other product lines</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
				<a href="<?php echo esc_url( home_url( '/products/mechanical/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Mechanical Filtration</p>
					<p class="text-sm text-slate-600">Self-cleaning centrifugal filtration for oil mist and coolant fumes at CNC machining sources.</p>
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
   so older browsers fall back to a static page. The script is identical
   to the mechanical page — see template-parts/page-products-mechanical.php
   for the full rationale on auto-advance timing, magnify-panel
   coordinate mapping, and IntersectionObserver root margins. */ ?>
<script type="module">
	const emifreeGalleryRotator = 3000;
	const emifreePrefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	document.querySelectorAll('[data-emifree-gallery]').forEach((gallery) => {
		const main = gallery.querySelector('[data-emifree-gallery-main]');
		const zoom = document.querySelector('[data-emifree-zoom-image]');
		const thumbs = gallery.querySelectorAll('[data-emifree-thumb]');
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

		thumbs.forEach((thumb, idx) => {
			thumb.addEventListener('click', () => {
				showIndex(idx);
				stop();
				start();
			});
		});

		gallery.addEventListener('mouseenter', () => { isHovered = true;  stop(); });
		gallery.addEventListener('mouseleave', () => { isHovered = false; if (!hasFocus && isVisible) { start(); } });
		gallery.addEventListener('focusin',    () => { hasFocus   = true;  stop(); });
		gallery.addEventListener('focusout',   () => { hasFocus   = false; if (!isHovered && isVisible) { start(); } });

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
			main.addEventListener('mouseleave', () => {
				magnifySource.classList.remove('emifree-magnify-source--active');
				magnifySource.style.setProperty('--emifree-mx', '50%');
				magnifySource.style.setProperty('--emifree-my', '50%');
			});
		}

		start();
	});

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

	// Back-to-top button: reveal once the user has scrolled past
	// the hero. Two paths so the reveal is reliable even if the
	// IntersectionObserver path doesn't fire for any reason (a
	// browser extension or plugin interfering with the hero, the
	// hero skipping the top 10% strip on a very short page, etc.):
	//
	//   1. IntersectionObserver on #hero with `rootMargin: '0px
	//      0px -90% 0px'` — the original fast path that only
	//      fires when the hero crosses the top 10% boundary.
	//   2. Throttled scroll listener fallback — guarantees the
	//      button appears when scrollY > 240 (≈ "past the fold"
	//      on every viewport) regardless of IO behavior. The rAF
	//      throttle keeps it off the main thread on every scroll
	//      tick.
	//
	// Both paths target the same element and write the same two
	// class states, so they're idempotent: whichever fires first
	// sets the state, whichever fires second is a no-op. The
	// mechanical page keeps the original IO-only block (it
	// works there); this hybrid is the fix for the electrostatic
	// page where the IO was silently not firing in the wild.
	const emifreeBackToTop = document.querySelector('[data-emifree-back-to-top]');
	if (emifreeBackToTop) {
		const emifreeShowBackToTop = () => {
			emifreeBackToTop.classList.add('opacity-100');
			emifreeBackToTop.classList.remove('opacity-0', 'pointer-events-none');
		};
		const emifreeHideBackToTop = () => {
			emifreeBackToTop.classList.add('opacity-0', 'pointer-events-none');
			emifreeBackToTop.classList.remove('opacity-100');
		};
		// Initial state from current scroll position (handles
		// anchor links that scroll the page on load).
		if (window.scrollY > 240) {
			emifreeShowBackToTop();
		}

		// Path 1: IntersectionObserver (unchanged behavior).
		if ('IntersectionObserver' in window) {
			const emifreeHero = document.getElementById('hero');
			if (emifreeHero) {
				const emifreeHeroObserver = new IntersectionObserver((entries) => {
					entries.forEach((entry) => {
						if (entry.isIntersecting) {
							emifreeHideBackToTop();
						} else {
							emifreeShowBackToTop();
						}
					});
				}, { rootMargin: '0px 0px -90% 0px', threshold: 0 });
				emifreeHeroObserver.observe(emifreeHero);
			}
		}

		// Path 2: scroll listener fallback. rAF-throttled so it
		// costs < 1ms per scroll tick. The 240px threshold is
		// well past the page top on every viewport (the
		// electrostatic hero is at least ~400px tall on mobile)
		// and well before the first section heading, matching
		// the "past the fold" mental model.
		let emifreeScrollTicking = false;
		window.addEventListener('scroll', () => {
			if (emifreeScrollTicking) { return; }
			emifreeScrollTicking = true;
			window.requestAnimationFrame(() => {
				if (window.scrollY > 240) {
					emifreeShowBackToTop();
				} else {
					emifreeHideBackToTop();
				}
				emifreeScrollTicking = false;
			});
		}, { passive: true });
	}
</script>
