<?php
/**
 * Footer, full markup mirroring src/components/Footer.jsx post-cleanup.
 *
 * - Newsletter signup (visual + form structure; real AJAX wiring lands
 *   with the Contact section in Piece 9. For now the form's onsubmit
 *   just prevents reload so the page doesn't jump.)
 * - Three link columns (Company / Resources / Legal) read from
 *   inc/footer.php so the data is editable in one place.
 * - Emifree GmbH legal line at the bottom (matches the React Footer).
 * - Social icons (LinkedIn, YouTube, Email) with SVG paths.
 * - No gradient text on the heading (the React cleanup).
 */

require_once get_template_directory() . '/inc/i18n.php';
emifree_require_section_data( 'footer' );
?>

<footer class="bg-zinc-900 text-white">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<!-- Main Footer Content -->
		<div class="py-16">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">

				<!-- Brand section (col-span-2) -->
				<div class="lg:col-span-2">
					<h2 class="text-3xl font-bold text-blue-400 font-mono mb-4">
						Emifree
					</h2>
					<p class="text-zinc-400 mb-6 leading-relaxed">
						Choose the Right Filtration Technology for Your Process.
					</p>

					<!-- Social Links -->
					<div class="flex space-x-4">
						<?php foreach ( emifree_social_links() as $emifree_social ) : ?>
							<a
								href="<?php echo esc_url( $emifree_social['href'] ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-all duration-200"
								aria-label="<?php echo esc_attr( $emifree_social['name'] ); ?>"
							>
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="<?php echo esc_attr( $emifree_social['svg'] ); ?>"></path>
								</svg>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Link Columns (1 each, fills the remaining 3 cols of the 5-col grid) -->
				<?php foreach ( emifree_footer_links() as $emifree_col_label => $emifree_col_links ) : ?>
					<div>
						<h4 class="font-semibold text-white mb-4">
							<?php echo esc_html( $emifree_col_label ); ?>
						</h4>
						<ul class="space-y-3">
							<?php foreach ( $emifree_col_links as $emifree_link ) : ?>
								<li>
									<?php
									// If link provides per-language hrefs (Legal column), emit
									// data attributes and choose the initial href based on the
									// site's current language so the links are language-aware.
									if ( isset( $emifree_link['href_en'] ) ) :
										// Resolve the active language. Request URI is the
										// source of truth (matches a user landing on /de/
										// after the / → /de/ 301 redirect); the cookie is
										// the fallback for routes without a /de/ prefix.
										$site_lang  = 'en';
										$emifree_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
										if ( 0 === strpos( $emifree_uri, '/de' ) ) {
											$site_lang = 'de';
										} elseif ( isset( $_COOKIE['emifree_lang'] ) ) {
											$site_lang = strtolower( sanitize_text_field( wp_unslash( $_COOKIE['emifree_lang'] ) ) );
										} else {
											$site_lang = strtolower( substr( get_bloginfo( 'language' ), 0, 2 ) );
										}
										$initial_href = ( 'de' === $site_lang ) ? $emifree_link['href_de'] : $emifree_link['href_en'];
										?>
										<?php
											// Decide which label to render server-side. Prefer cookie, then site language.
											$link_label = '';
											if ( 'de' === $site_lang && ! empty( $emifree_link['name_de'] ) ) {
												$link_label = $emifree_link['name_de'];
											} elseif ( ! empty( $emifree_link['name_en'] ) ) {
												$link_label = $emifree_link['name_en'];
											} elseif ( ! empty( $emifree_link['name'] ) ) {
												$link_label = $emifree_link['name'];
											}
										?>
										<a
										href="<?php echo esc_url( $initial_href ); ?>"
										class="text-zinc-400 hover:text-white transition-colors duration-200 emifree-legal-link"
										data-href-en="<?php echo esc_attr( $emifree_link['href_en'] ); ?>"
										data-href-de="<?php echo esc_attr( $emifree_link['href_de'] ); ?>"
										<?php if ( ! empty( $emifree_link['onclick'] ) ) : ?>
										onclick="<?php echo esc_attr( $emifree_link['onclick'] ); ?>"
										<?php endif; ?>
										>
											<?php echo esc_html( $link_label ); ?>
										</a>
										<?php else : ?>
										<a
											href="<?php echo esc_url( $emifree_link['href'] ); ?>"
											class="text-zinc-400 hover:text-white transition-colors duration-200"
										>
											<?php echo esc_html( $emifree_link['name'] ); ?>
										</a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Bottom Section -->
		<div class="py-8 border-t border-zinc-800 flex flex-col md:flex-row items-center justify-between gap-4">
			<?php
			/* ISO 9001 trust badge in the footer bottom bar. Image +
			   alt/aria are picked by request URI the same way the
			   language-aware legal links pick their href, so a /de/
			   visit sees the German certificate and an English visit
			   sees the English one. Sits inline with the copyright
			   line on the left, sized 2x the previous placement
			   (80/96/112px) so it reads as a proper trust mark next
			   to the legal text instead of a tiny corner glyph.
			   External link to the virtualbadge.io credential
			   verifier, opens in a new tab. */
			$emifree_badge_is_de = ( 0 === strpos(
				isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '',
				'/de'
			) );
			$emifree_badge_url  = get_template_directory_uri() . '/assets/badges/iso9001_badge_' . ( $emifree_badge_is_de ? 'de' : 'en' ) . '.png';
			$emifree_badge_alt  = $emifree_badge_is_de
				? 'ISO 9001 Qualitätsmanagement zertifiziert'
				: 'ISO 9001 Quality Management certified';
			$emifree_badge_aria = $emifree_badge_is_de
				? 'ISO-9001-Zertifizierung — Anmeldedaten verifizieren (öffnet in neuem Tab)'
				: 'ISO 9001 certification — verify credential (opens in new tab)';
			?>
			<div class="flex items-center gap-3 text-zinc-400 text-sm">
				<span>
					© <?php echo esc_html( gmdate( 'Y' ) ); ?> Emifree GmbH · Pestalozzistraße 13 · 12557 Berlin · Germany
				</span>
				<a
					href="https://www.virtualbadge.io/certificate-validator?credential=ca8b6217-fca6-476f-9852-2c45f7cb70c1"
					target="_blank"
					rel="noopener noreferrer"
					class="inline-block transition-transform duration-200 hover:scale-105 focus-visible:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-zinc-900 rounded-full"
					aria-label="<?php echo esc_attr( $emifree_badge_aria ); ?>"
					title="ISO 9001 — verify credential"
				>
					<img
						src="<?php echo esc_url( $emifree_badge_url ); ?>"
						alt="<?php echo esc_attr( $emifree_badge_alt ); ?>"
						class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-full shadow-[0_4px_16px_rgba(0,0,0,0.35)]"
						loading="lazy"
						decoding="async"
						width="112"
						height="112"
					>
				</a>
			</div>
			<div class="flex items-center space-x-4 text-zinc-500 text-sm">
				<a href="mailto:info@emifree.com" class="text-zinc-300 hover:text-white transition-colors">info@emifree.com</a>
				<span aria-hidden="true">·</span>
				<a href="tel:+493076283520" class="text-zinc-300 hover:text-white transition-colors">+49 307 628 3520</a>
			</div>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>