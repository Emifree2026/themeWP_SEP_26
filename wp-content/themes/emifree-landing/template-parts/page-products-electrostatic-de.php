<?php
/**
 * Product page body, DE: /de/produkte/elektrostatische-filtration/
 *
 * Deutsche Variante von template-parts/page-products-electrostatic.php.
 * Gleiche Struktur, gleiche Reihenfolge der Sektionen, nur die
 * Strings und die 4. Maßzeichnung (Platzhalter DE) sind
 * ausgetauscht. Die Spezifikations-Sektion nutzt jetzt eine
 * 3-Spalten-Tabelle (Version | Basis | Premium), die das Muster
 * der mechanischen Seite 1:1 spiegelt; die statische
 * earia_DE_final2.png wird nicht mehr gerendert (bleibt aber auf
 * der Festplatte für Referenz).
 *
 *  - Hero-Text: "Submikron-Partikelabscheidung" + deutsche Beschreibung.
 *  - Hero rechte Spalte: Titel → "Angebot anfordern" CTA →
 *    Einleitungs-Absatz. Der CTA sitzt direkt vor dem Einleitungs-
 *    Absatz (kein Anwendungs-Chips im Hero).
 *  - Das Hero-Band hat id="hero": das 1. Navigations-Element
 *    "Nach oben" dient sowohl als Scroll-Spy-Anker (es wird blau,
 *    solange der Hero im Sichtbereich ist) als auch als
 *    "Zurück-nach-oben"-Sprungziel (Klick scrollt an den Anfang).
 *  - Sektionsnavigation: vertikale rechte Schiene auf lg+, schwebender
 *    "Nach oben"-Button auf <lg (kein Sticky-Top auf Mobile);
 *    Reihenfolge Nach oben / Abmessungen / Leistungskurve /
 *    Spezifikation. Eine eigene "Angebot"-Sektion gibt es
 *    nicht mehr — der "Angebot anfordern"-CTA im Hero ist
 *    seit 2026-10 der einzige Konversionspfad.
 *  - 4. Maßzeichnung: DE-Platzhalter (in Kürze.webp) statt EN-Version.
 *  - Galerie: automatische Rotation alle 5s, pausiert bei Hover /
 *    Tastatur-Fokus / wenn außerhalb des Sichtbereichs; respektiert
 *    prefers-reduced-motion.
 *  - Cross-Links: Mechanische Filtration / Entstaubung.
 *
 * Wie die EN-Version: Galerie und Sub-Menü-JS sind inline am Ende
 * der Datei (type="module"), kein externes Enqueue.
 *
 * Kein Broschüren-Abschnitt: es liegt noch keine herunterladbare
 * EARIA-PDF vor. Sobald eine verfügbar ist, einen Broschüren-
 * Abschnitt zwischen Spezifikation und Cross-Link-Streifen
 * ergänzen (siehe mechanische Vorlage).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

// Siehe template-parts/page-products-electrostatic.php für die
// Begründung der URI-Aufteilung (electrostatic/ für Logo,
// übergeordneter Ordner für die 3 Produktfotos, die auch die
// Home-Page-Produktkarte verwendet). Die pro-Sprache-
// Spezifikations-PNGs (earia_EN.png / earia_DE_final2.png) bleiben
// auf der Festplatte für Referenz / spätere Wiederverwendung, werden
// aber nicht mehr gerendert — die Spezifikations-Sektion nutzt jetzt
// eine strukturierte HTML-Tabelle (siehe unten), identisch zum
// mechanischen Pendant.
$emifree_uri               = get_template_directory_uri() . '/assets/products/electrostatic/';
$emifree_photos_uri        = get_template_directory_uri() . '/assets/products/';
$emifree_gallery           = emifree_get_electrostatic_gallery();
$emifree_specs_rows        = emifree_get_electrostatic_specs_rows( 'de' );
$emifree_dimension_images  = emifree_get_electrostatic_dimension_images( false );
$emifree_performance_curves = emifree_get_electrostatic_performance_curves( 'de' );
$emifree_cta               = emifree_get_electrostatic_cta( 'de' );
$emifree_contact_url       = home_url( '/de/?quote=elektrostatische-filtration#contact' );
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
					<li><a href="<?php echo esc_url( home_url( '/de/#produkte' ) ); ?>" class="hover:text-blue-700">Produkte</a></li>
					<li aria-hidden="true">/</li>
					<li aria-current="page" class="text-slate-700">Elektrostatische Filtration</li>
				</ol>
			</nav>

			<div class="emifree-magnify-source grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<div>
					<img
						src="<?php echo esc_url( $emifree_uri . 'earia_final.png' ); ?>"
						alt="EARIA Wortmarke"
						class="w-48 md:w-56 h-auto mb-6"
						decoding="async"
					>

					<div data-emifree-gallery class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
						<div class="aspect-[4/3] flex items-center justify-center p-6">
							<img
								data-emifree-gallery-main
								src="<?php echo esc_url( $emifree_photos_uri . $emifree_gallery[0]['filename'] ); ?>"
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

				<div class="relative emifree-zoom-slot min-h-[280px] md:min-h-[320px]">
					<div class="emifree-zoom-text">
						<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">Elektrostatische Filtration</p>
						<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">Submikron-Partikelabscheidung</h1>
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
							Der EARIA 1000 m³/h Elektroabscheider scheidet submikrone Partikel — Rauch, Feinstnebel und industrielle Gerüche — direkt an der Quelle ab, mit einstellbarem Volumenstrom und optionalem Touch-Panel-Kontrollsystem.
						</p>
					</div>
					<div class="emifree-zoom-panel" aria-hidden="true">
						<div
							data-emifree-zoom-image
							role="img"
							aria-label="<?php echo esc_attr( $emifree_gallery[0]['alt'] ); ?>"
							class="emifree-zoom-panel__bg"
							style="background-image: url('<?php echo esc_url( $emifree_photos_uri . $emifree_gallery[0]['filename'] ); ?>');"
						></div>
						<span class="emifree-zoom-panel__label">Vergrößerte Ansicht</span>
					</div>
				</div>

			</div>
		</div>

	<div class="hidden lg:flex fixed right-4 xl:right-6 top-1/2 -translate-y-1/2 z-40" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
		<nav aria-label="Seitenabschnitte" class="flex flex-col items-center gap-1 p-2 bg-white/85 backdrop-blur-xl border border-slate-200/80 shadow-2xl rounded-full">
			<a href="#hero" data-section="hero" class="emifree-product-submenu__link inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M12 19V5"></path>
					<path d="m5 12 7-7 7 7"></path>
				</svg>
				Nach oben
			</a>
			<a href="#dimensions" data-section="dimensions" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Abmessungen
			</a>
			<a href="#performance" data-section="performance" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Leistungskurve
			</a>
			<a href="#specs" data-section="specs" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Spezifikation
			</a>
			<?php /* Die rechte Navigationsleiste verlinkt nicht mehr auf
			 * eine eigene Angebotssektion (der Hero-CTA ist jetzt
			 * der einzige Konversionspfad). */ ?>
		</nav>
	</div>

	<a href="#hero" data-emifree-back-to-top
		class="fixed right-4 bottom-4 lg:hidden z-40 inline-flex items-center gap-1.5 px-4 py-3 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-xl ring-1 ring-blue-700/20 hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors transition-opacity duration-200 opacity-0 pointer-events-none"
		style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px));"
		aria-label="Nach oben">
		<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
			<path d="M12 19V5"></path>
			<path d="m5 12 7-7 7 7"></path>
		</svg>
		Hoch
	</a>

	<section id="dimensions" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Abmessungen</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Maßzeichnungen des EARIA 1000 m³/h Elektroabscheiders in Standard- und Touch-Panel-Ausführung. Alle Maße in Millimetern.
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

	<?php /* Leistungsvergleichs-Sektion: EARIA Selbstreinigung vs.
		 * konventionelles System. Stacked-Layout: Überschrift →
		 * Bildunterschrift → Diagramm. Eine einzelne
		 * Querformat-PNG (pro Sprache), kein 2-Spalten-Grid und
		 * keine "1000 m³/h"-Beschriftung mehr (die alte
		 * Beschriftung war auf die druckverlustspezifische
		 * Variante gemünzt; das neue Vergleichsdiagramm hat
		 * keine Variantennummer).
		 *
		 * Spiegelung der EN-Vorlage 1:1 — `max-h-[520px]` lässt
		 * dem Querformat-Diagramm auf großen Viewports etwas
		 * mehr Höhe als die alte 420-px-Karte, ohne es
		 * dominieren zu lassen. */ ?>
	<section id="performance" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Kein Leistungsverlust mehr</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Vergleichen Sie die Standardfiltration mit dem Emifree-System. Unsere Selbstreinigungstechnologie erhält einen konstanten Zyklus hocheffizienter Filtration, während konventionelle Systeme einen dauerhaften Effizienzverlust erleiden.
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

	<?php /* Spezifikations-Sektion: 3-Spalten-Tabelle (Version | Basis | Premium).
		 * Spiegelt die Mechanik-Seite 1:1: `min-w-[640px]` auf der
		 * <table> + `overflow-x-auto` am Wrapper erzeugen horizontalen
		 * Scroll auf Telefonen; der "Wischen, um alle Spalten zu
		 * sehen"-Hinweis (sm:hidden) weist mobile Nutzer darauf hin.
		 * Cell-Padding fällt auf `px-4` auf Mobile (von `px-6`), um
		 * ~16px horizontalen Platz auf einem 375px-Viewport
		 * zurückzugewinnen.
		 *
		 * Die Spaltenüberschrift "Version" (statt "Spezifikation"
		 * wie in der mechanischen Tabelle) entspricht dem Layout des
		 * vom Benutzer transkribierten EARIA-Spezifikationsblatts;
		 * siehe emifree_get_electrostatic_specs_rows() für die
		 * Zeilendaten und die Begründung pro Zelle (asymmetrische
		 * Klammern, gemischte Dezimaltrennzeichen, etc. — alles
		 * wörtlich aus der Quelle übernommen). */ ?>
	<section id="specs" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Spezifikation</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Technischer Vergleich der EARIA 1000 m³/h in zwei Ausführungen: Basis und Premium.
			</p>
			<p class="sm:hidden text-sm text-slate-500 mb-3 flex items-center gap-1.5" aria-hidden="true">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
				Wischen, um alle Spalten zu sehen
			</p>
			<div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200 emifree-specs-scroll">
				<table class="w-full text-left min-w-[640px]">
					<thead class="bg-blue-600 text-white">
						<tr>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Version</th>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Basis</th>
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

	<?php /* Cross-Link-Streifen: Geschwister-Produktkarten +
		 * Zurück-zur-Startseite. Die ehemalige Angebotssektion
		 * wurde 2026-10 entfernt — der "Angebot anfordern"-CTA
		 * im Hero ist jetzt der einzige Konversionspfad. */ ?>

	<div class="mt-8 py-16 border-t border-slate-200 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl font-bold text-zinc-900 mb-6">Weitere Produktlinien</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
				<a href="<?php echo esc_url( home_url( '/produkte/mechanische-filtration/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Mechanische Filtration</p>
					<p class="text-sm text-slate-600">Selbstreinigende Zentrifugalfiltration für Ölnebel und Kühlschmierstoffdämpfe an CNC-Bearbeitungsmaschinen.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/produkte/entstaubung/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Entstaubung</p>
					<p class="text-sm text-slate-600">Patronen- und Schlauchfilterlösungen für Holzbearbeitung, Metallschliff und Schüttguthandling.</p>
				</a>
			</div>
			<a href="<?php echo esc_url( home_url( '/de/' ) ); ?>" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M19 12H5"></path>
					<path d="m12 19-7-7 7-7"></path>
				</svg>
				Zurück zur Startseite
			</a>
		</div>
	</div>

</div>

<?php /* Inline JS: gallery thumb swap + sub-menu active-pill on scroll.
   Identisch zur EN-Seite — siehe template-parts/page-products-electrostatic.php
   für die ausführliche Begründung der Auto-Advance-Zeit, der
   Magnify-Panel-Koordinatenabbildung und der IntersectionObserver-
   Wurzelränder. */ ?>
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

	// "Nach-oben"-Button: einblenden, sobald der Anwender über
	// den Hero hinaus gescrollt hat. Zwei Pfade, damit das
	// Einblenden zuverlässig funktioniert, auch wenn der
	// IntersectionObserver-Pfad aus irgendeinem Grund nicht
	// feuert (Browser-Erweiterung, Plugin-Einfluss, der Hero
	// überspringt den oberen 10%-Streifen auf einer sehr kurzen
	// Seite, etc.):
	//
	//   1. IntersectionObserver auf #hero mit `rootMargin: '0px
	//      0px -90% 0px'` — der ursprüngliche schnelle Pfad,
	//      der nur feuert, wenn der Hero die obere 10%-Grenze
	//      kreuzt.
	//   2. Per rAF gedrosselter Scroll-Listener als Fallback —
	//      garantiert, dass der Button bei scrollY > 240
	//      erscheint (≈ "unter der Falte" auf jedem Viewport),
	//      unabhängig vom IO-Verhalten. Die rAF-Drossel hält
	//      die Kosten pro Scroll-Tick unter 1ms.
	//
	// Beide Pfade zielen auf dasselbe Element und schreiben
	// dieselben zwei Klassen-Zustände, sind also idempotent:
	// wer zuerst feuert, setzt den Zustand; der zweite ist ein
	// No-Op. Die mechanische Seite behält den ursprünglichen
	// reines-IO-Block (er funktioniert dort); diese Hybrid-
	// Variante ist der Fix für die elektrostatische Seite, wo
	// der IO in der Praxis stillschweigend nicht feuerte.
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
		// Anfangszustand aus der aktuellen Scroll-Position
		// (deckt Anchor-Links ab, die beim Laden scrollen).
		if (window.scrollY > 240) {
			emifreeShowBackToTop();
		}

		// Pfad 1: IntersectionObserver (unverändertes Verhalten).
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

		// Pfad 2: Scroll-Listener-Fallback. Per rAF gedrosselt.
		// Die 240px-Schwelle liegt auf jedem Viewport deutlich
		// unter dem Seitenanfang (der elektrostatische Hero ist
		// auf Mobile mindestens ~400px hoch) und deutlich vor
		// der ersten Sektionsüberschrift — passend zum
		// "unter-der-Falte"-Mental-Model.
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
