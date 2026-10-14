<?php
/**
 * Page body, EN: /knowledge/hepa-filters-cnc-industrial-workshops/
 *
 * The HEPA "page" is a long-form editorial article (not a product
 * spec sheet) that reuses the dust page's hero layout (3-photo
 * gallery + title + CTA + feature list) for visual consistency
 * with the other per-product landing pages. Below the hero the
 * page renders 5 H2 sections — Best uses, Limitations, Selection
 * checklist, Safety note, Practical setup — followed by a final
 * CTA. The body content is sourced from HEPA_SECTIONMD.md
 * (supplied by the user 2026-10-14) and is rendered inline below
 * rather than abstracted into a data array, since the editorial
 * copy is short and bespoke to this page.
 *
 * Hero layout (mirrors the dust template):
 *   - Page-top: back-to-home link + breadcrumb (Home / Knowledge /
 *     HEPA Filters) + 2-col hero band
 *   - Left col: 3-photo product gallery with thumbnail strip
 *   - Right col: eyebrow tag, H1, "Request a quote" CTA, 4-item
 *     feature intro
 *
 * No sub-menu, no back-to-top, no IntersectionObserver, no FAQ
 * section — all of those are out of scope for the initial cut. The
 * gallery uses the same thumb-swap JS as the dust page.
 *
 * The whole bg-slate-50 band carries id="hero" so the future
 * back-to-top button can use it as its scroll-spy anchor.
 *
 * Renders Breadcrumb back to /en/knowledge/ via an intermediate
 * /en/knowledge/ anchor for the "Knowledge" crumb.
 *
 * SEO:
 *   - title: HEPA Filters in CNC & Industrial Workshops: Safety Guide
 *   - h1:    HEPA Filters in CNC & Industrial Workshops: Uses, Limits & Safety
 *   - meta:  Learn how HEPA filters help control fine dust in CNC
 *            and industrial workshops, plus key limitations,
 *            selection tips, and combustible dust safety.
 *   - slug:  hepa-filters-cnc-industrial-workshops (per the
 *            HEPA_SECTIONMD.md SEO recommendations)
 *
 * Renders template-parts/page-hepa-filters.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

$emifree_uri         = get_template_directory_uri() . '/assets/products/hepa/';
$emifree_gallery     = emifree_get_hepa_gallery();
$emifree_hero_intro  = emifree_get_hepa_hero_intro( 'en' );
$emifree_cta         = emifree_get_hepa_cta( 'en' );
$emifree_contact_url = home_url( '/en/?quote=hepa#contact' );
?>

<div class="min-h-screen bg-white">

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
					<li><a href="<?php echo esc_url( home_url( '/en/knowledge/' ) ); ?>" class="hover:text-blue-700">Knowledge</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/en/knowledge/hepa-filters-cnc-industrial-workshops/' ) ); ?>" class="hover:text-blue-700">HEPA Filters</a></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<?php /* Left: gallery */ ?>
				<div>
					<div data-emifree-gallery class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
						<div class="aspect-[4/3] flex items-center justify-center p-6">
							<img
								data-emifree-gallery-main
								src="<?php echo esc_url( $emifree_uri . $emifree_gallery[0]['filename'] ); ?>"
								alt="<?php echo esc_attr( $emifree_gallery[0]['alt'] ); ?>"
								class="max-w-full max-h-full object-contain transition-opacity duration-300"
								decoding="async"
							>
						</div>

						<div role="tablist" aria-label="Product photos" class="grid grid-cols-3 gap-2 p-2 bg-slate-50 border-t border-slate-200">
							<?php foreach ( $emifree_gallery as $emifree_idx => $emifree_photo ) : ?>
								<button
									type="button"
									role="tab"
									data-emifree-thumb
									data-thumb-src="<?php echo esc_url( $emifree_uri . $emifree_photo['filename'] ); ?>"
									data-thumb-alt="<?php echo esc_attr( $emifree_photo['alt'] ); ?>"
									aria-label="<?php echo esc_attr( $emifree_photo['alt'] ); ?>"
									aria-current="<?php echo 0 === $emifree_idx ? 'true' : 'false'; ?>"
									class="aspect-[4/3] rounded-lg overflow-hidden bg-white border-2 border-transparent hover:border-blue-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-all duration-200 <?php echo 0 === $emifree_idx ? 'is-active' : ''; ?>"
								>
									<img
										src="<?php echo esc_url( $emifree_uri . $emifree_photo['filename'] ); ?>"
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
				<div class="relative min-h-[280px] md:min-h-[320px]">
					<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">HEPA Filtration</p>
					<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">HEPA Filters in CNC &amp; Industrial Workshops: Uses, Limits &amp; Safety</h1>
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
					<ul class="space-y-3 text-base md:text-lg text-slate-600 leading-relaxed">
						<?php foreach ( $emifree_hero_intro as $emifree_feature ) : ?>
							<li>
								<strong class="text-zinc-900"><?php echo esc_html( $emifree_feature['label'] ); ?>:</strong>
								<?php echo esc_html( $emifree_feature['body'] ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

			</div>
		</div>
	</div>

	<?php /* ----- Body: 5 H2 sections + final CTA -----

	   The body content is sourced from HEPA_SECTIONMD.md
	   (supplied 2026-10-14) and is rendered inline. Each H2
	   section is a <section> with a stable id so the table of
	   contents (added in a future iteration if needed) can deep-link
	   into it. The id slugs match the recommended URL slug
	   convention: #hepa-best-uses, #hepa-limitations, etc.

	   The "Safety note" section is intentionally given a stronger
	   visual treatment (red-tinted left border + icon) because
	   combustible-dust safety is the single most important
	   constraint from the article and a future reader who only
	   skims the page should still see it. The other sections
	   use the default slate palette.

	   Internal cross-links inside the body use the URL slugs of
	   sibling Knowledge pages where they exist, so search engines
	   can crawl the article → product / article → about chain.
	   */ ?>

	<div class="bg-white">
		<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

			<section id="hepa-best-uses" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Best uses</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li><strong class="text-zinc-900">CNC machining:</strong> Reduces suspended metal, plastic, wood, and composite dust. A HEPA filter is capable of filtering out even the smallest particles (0.12&ndash;0.25&nbsp;micrometers) from the air with 99.95% efficiency, which makes it well suited to the fine aerosols these processes produce.</li>
					<li><strong class="text-zinc-900">Woodworking routers:</strong> Helps with fine residual dust; extract MDF, plywood, etc. at the tool.</li>
					<li><strong class="text-zinc-900">Plastics/composites:</strong> Cleans ambient fine irritant dust; source capture is essential.</li>
					<li><strong class="text-zinc-900">Grinding/polishing/finishing:</strong> Controls fine particles that spread beyond the work area.</li>
				</ul>
			</section>

			<section id="hepa-limitations" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Limitations</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li>HEPA captures particles, not gases or vapors.</li>
					<li>Oil mist, coolant vapors, welding fumes, solvents, and chemical vapors need <a href="<?php echo esc_url( home_url( '/en/products/mechanical/' ) ); ?>" class="text-blue-700 hover:text-blue-800 underline">mist collectors</a>, fume extraction, carbon filtration, or local exhaust.</li>
					<li>Oily/sticky dust can clog HEPA quickly. Use pre-filters and sometimes mist/coalescing filters.</li>
				</ul>
			</section>

			<section id="hepa-selection-checklist" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Selection checklist</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li>Match airflow/clean air delivery to room size and dust load.</li>
					<li>Use a pre-filter before HEPA; add carbon or mist filtration if needed.</li>
					<li>For combustible dust (wood, aluminum, some plastics), use explosion-safe certified equipment.</li>
					<li>Place for good circulation, but keep intake away from heavy dust sources.</li>
					<li>Monitor pressure drop; replace pre-filters often and HEPA per manufacturer.</li>
					<li>Confirm suitability for material, fire/explosion risk, and local safety rules.</li>
				</ul>
			</section>

			<section id="hepa-safety-note" class="mb-12 scroll-mt-20 border-l-4 border-red-500 bg-red-50 p-6 rounded-r-lg">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4 flex items-center gap-3">
					<svg class="w-8 h-8 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
						<line x1="12" y1="9" x2="12" y2="13"></line>
						<line x1="12" y1="17" x2="12.01" y2="17"></line>
					</svg>
					Safety note
				</h2>
				<p class="text-lg text-slate-800 leading-relaxed">
					Combustible dust can accumulate inside HEPA units or ducting and create fire/explosion risks. Do not assume a standard HEPA unit is safe. Use certified equipment, grounding, good housekeeping, and explosion protection.
				</p>
			</section>

			<section id="hepa-practical-setup" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Practical setup</h2>
				<ol class="space-y-3 text-lg text-slate-700 leading-relaxed list-decimal pl-6">
					<li>Capture most dust at the CNC machine with extraction or an enclosure.</li>
					<li>Use a HEPA fan-filter unit for fine airborne particles.</li>
					<li>Maintain general ventilation for fresh air and heat/gas control.</li>
					<li>Use a pre-filter and monitor filter condition.</li>
					<li>Keep filters, floors, ledges, and ducting clean.</li>
				</ol>
			</section>

			<?php /* Bottom CTA, mirrors the markdown's recommendation
			   ("Contact us to select the right HEPA filtration setup
			   for your workshop"). Same destination as the hero CTA,
			   so the user lands on the same contact form (with
			   ?quote=hepa prefilling the subject). */ ?>
			<div class="mt-16 text-center bg-slate-50 border border-slate-200 rounded-2xl p-8 md:p-12">
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Need help selecting the right HEPA filtration setup?</h2>
				<p class="text-lg text-slate-600 mb-6 max-w-2xl mx-auto">
					Talk to our team about airflow, pre-filtration, and explosion safety for your specific workshop.
				</p>
				<a
					href="<?php echo esc_url( $emifree_contact_url ); ?>"
					class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-4 rounded-full shadow-md hover:shadow-lg transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
				>
					<?php echo esc_html( $emifree_cta ); ?>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M5 12h14"></path>
						<path d="m12 5 7 7-7 7"></path>
					</svg>
				</a>
			</div>

		</div>
	</div>

</div>

<?php /* Gallery thumb-swap JS, identical to the dust page. */ ?>
<script type="module">
	const emifreeGallery = document.querySelector('[data-emifree-gallery]');
	if (emifreeGallery) {
		const emifreeMain = emifreeGallery.querySelector('[data-emifree-gallery-main]');
		const emifreeThumbs = emifreeGallery.querySelectorAll('[data-emifree-thumb]');
		emifreeThumbs.forEach((emifreeThumb) => {
			emifreeThumb.addEventListener('click', () => {
				const emifreeSrc = emifreeThumb.getAttribute('data-thumb-src');
				const emifreeAlt = emifreeThumb.getAttribute('data-thumb-alt');
				if (emifreeSrc) {
					emifreeMain.style.opacity = '0';
					setTimeout(() => {
						emifreeMain.setAttribute('src', emifreeSrc);
						if (emifreeAlt) {
							emifreeMain.setAttribute('alt', emifreeAlt);
						}
						emifreeMain.style.opacity = '1';
					}, 150);
				}
				emifreeThumbs.forEach((t) => {
					t.classList.remove('is-active');
					t.setAttribute('aria-current', 'false');
				});
				emifreeThumb.classList.add('is-active');
				emifreeThumb.setAttribute('aria-current', 'true');
			});
		});
	}
</script>
