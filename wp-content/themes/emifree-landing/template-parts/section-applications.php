<?php
/**
 * Applications section, 6 industrial segments with icons + descriptions + SEO questions.
 *
 * Mirrors src/components/Applications.jsx from the React app.
 * Icon SVGs come from emifree_application_icons() in inc/applications.php
 *, no external icon library required for WordPress.
 *
 * Collapsed-by-default card pattern (added 2026-10-14):
 *   Each card shows only the icon + title in its resting state. The
 *   description and italic SEO question are wrapped in a container
 *   that is visually collapsed (opacity-0, max-h-0, overflow-hidden)
 *   and revealed on:
 *     - group-hover      → desktop mouse
 *     - group-focus-within → keyboard Tab (the article has tabindex=0)
 *                         and touch tap (tap = focus, stays expanded
 *                         while the card has focus, collapses when the
 *                         user taps elsewhere)
 *   The text stays in the DOM (no display:none) so screen readers,
 *   search engines, and "find in page" all see it. The sr-only
 *   pattern would also work, but leaving the text in the visual
 *   layout (just collapsed) keeps the SEO question readable by
 *   AT and lets us animate it in/out cleanly.
 *
 *   The max-h-0 → max-h-96 transition gives the card a smooth
 *   "expand" feel without a hard pop. The wrapping padding also
 *   shrinks (p-8 → p-6) so the card visually opens from a compact
 *   chip to a full panel.
 */

require_once get_template_directory() . '/inc/i18n.php';
emifree_require_section_data( 'applications' );
?>

<section id="applications" class="py-12 md:py-24 bg-white">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<div class="text-center mb-20">
			<h2 class="text-4xl md:text-5xl font-bold mb-6" style="background: linear-gradient(90deg, #1d4ed8 0%, #06b6d4 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">
				Industrial Air Filtration for Every Application
			</h2>
			<p class="text-xl text-zinc-600 max-w-3xl mx-auto">
				From small tool shops to large manufacturing facilities, Emifree
				systems capture oil mist, welding fumes, and dust at the source.
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php foreach ( emifree_applications() as $emifree_app ) : ?>
				<article
					tabindex="0"
					aria-label="<?php echo esc_attr( $emifree_app['title'] ); ?>"
					class="group relative bg-white rounded-2xl p-6 group-hover:p-8 group-focus-within:p-8 shadow-lg hover:shadow-2xl focus-within:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-slate-200 focus-within:border-slate-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
				>
					<div class="relative">
						<div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110 group-focus-within:scale-110" style="background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%); box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);">
							<svg class="w-8 h-8" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true" style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));">
								<?php
								$emifree_icons = emifree_application_icons();
								echo $emifree_icons[ $emifree_app['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, SVG markup, controlled input.
								?>
							</svg>
						</div>

						<h3 class="text-xl font-bold text-zinc-900 mb-4 transition-colors duration-300 group-hover:text-blue-700 group-focus-within:text-blue-700">
							<?php echo esc_html( $emifree_app['title'] ); ?>
						</h3>

						<?php /* Collapsed-by-default body wrapper. opacity-0 +
						   max-h-0 + overflow-hidden collapses the section to
						   zero visual height; group-hover and group-focus-within
						   flip both to fully open. max-h-96 (24rem ≈ 384px)
						   is comfortably more than the longest description
						   in the data, so the transition reaches its full
						   open state. duration-300 matches the surrounding
						   card transitions. */ ?>
						<div class="emifree-app-card__body max-h-0 opacity-0 overflow-hidden transition-all duration-300 ease-out group-hover:max-h-96 group-hover:opacity-100 group-focus-within:max-h-96 group-focus-within:opacity-100">
							<p class="text-zinc-600 leading-relaxed mb-4 pt-2">
								<?php echo esc_html( $emifree_app['description'] ); ?>
							</p>

							<!-- SEO question, surfaced as a subtle italic line.
							     text-zinc-600 keeps WCAG AA contrast (5.74:1 on the
							     white card) while still reading as muted copy. The
							     text remains in the DOM (not display:none) so screen
							     readers, search engines, and "find in page" all see
							     it. -->
							<p class="text-sm text-zinc-600 italic">
								&ldquo;<?php echo esc_html( $emifree_app['question'] ); ?>&rdquo;
							</p>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="text-center mt-16">
			<a
				href="#technology"
				class="text-white px-8 py-4 rounded-full font-semibold text-lg hover:shadow-xl transition-all duration-300 inline-block"
				style="background: linear-gradient(90deg, #1d4ed8 0%, #06b6d4 100%); box-shadow: 0 10px 25px rgba(6, 182, 212, 0.25);"
			>
				Find Your Solution
			</a>
		</div>

	</div>
</section>