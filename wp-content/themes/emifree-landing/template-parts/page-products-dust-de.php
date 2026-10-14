<?php
/**
 * Product page body, DE: /produkte/entstaubung/
 *
 * Deutsche Variante von template-parts/page-products-dust.php.
 * Gleiche Struktur, gleiche Reihenfolge der Sektionen, nur die
 * Strings sind ausgetauscht. Die Helfer
 * emifree_get_dust_gallery() / emifree_get_dust_hero_intro() /
 * emifree_get_dust_cta() sind sprachunabhängig bzw. akzeptieren
 * einen Sprachparameter.
 *
 * Hero-Struktur (spiegelt die elektrostatische Vorlage):
 *   - Seitenanfang: Zurück-zur-Startseite-Link + Brotkrumen + 2-spaltiger Held
 *   - Linke Spalte: 3-Foto-Produktgalerie mit Miniaturstreifen
 *   - Rechte Spalte: Eyebrow-Tag, H1, "Angebot anfordern" CTA, 4-Punkt-Intro
 *
 * Wie die EN-Variante: keine Unterseiten-Navigation, kein "Nach
 * oben"-Button, keine Sektions-Beobachter, keine Magnify-Panels.
 * Wird ergänzt, sobald weitere Sektionen dazukommen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

$emifree_uri         = get_template_directory_uri() . '/assets/products/dust/';
$emifree_gallery     = emifree_get_dust_gallery();
$emifree_hero_intro  = emifree_get_dust_hero_intro( 'de' );
$emifree_cta         = emifree_get_dust_cta( 'de' );
$emifree_contact_url = home_url( '/de/?quote=entstaubung#contact' );
?>

<div class="min-h-screen bg-white">

	<div id="hero" class="bg-slate-50 border-b border-slate-200 scroll-mt-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
			<a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M19 12H5"></path>
					<path d="m12 19-7-7 7-7"></path>
				</svg>
				Zurück zur Startseite
			</a>

			<nav aria-label="Brotkrumen" class="mb-8 text-sm text-slate-500">
				<ol class="flex flex-wrap items-center gap-1">
					<li><a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="hover:text-blue-700">Startseite</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/de/#products' ) ); ?>" class="hover:text-blue-700">Produkte</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/produkte/entstaubung/' ) ); ?>" class="hover:text-blue-700">Staub</a></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<?php /* Links: Galerie */ ?>
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

						<div role="tablist" aria-label="Produktfotos" class="grid grid-cols-3 gap-2 p-2 bg-slate-50 border-t border-slate-200">
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

				<?php /* Rechts: Titel + CTA + Intro */ ?>
				<div class="relative min-h-[280px] md:min-h-[320px]">
					<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">Staubfiltration</p>
					<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">Staub direkt an der Quelle stoppen</h1>
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

</div>

<?php /* Minimale Galerie-JS: Klick auf Miniatur tauscht das
	 * Hauptbild und schaltet den aktiven Ring um. Kein Magnify,
	 * kein Auto-Rotate, kein Beobachter — die Seite wächst in
	 * das volle Muster (entsprechend mechanisch / elektrostatisch),
	 * sobald weitere Sektionen dazukommen. */ ?>
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
