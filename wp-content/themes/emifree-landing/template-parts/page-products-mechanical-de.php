<?php
/**
 * Product page body, DE: /de/produkte/mechanische-filtration/
 *
 * Deutsche Variante von template-parts/page-products-mechanical.php.
 * Gleiche Struktur, gleiche Reihenfolge der Sektionen, nur die
 * Strings und der 4. Maßplan (DE-Version) sind ausgetauscht.
 *
 *  - Hero-Text: "Industrielle Ölnebelabscheidung" + deutsche Beschreibung.
 *  - Hero rechte Spalte: Titel → "Angebot anfordern" CTA →
 *    Einleitungs-Absatz. Der CTA sitzt direkt vor dem Einleitungs-
 *    Absatz (keine separate Angebots-Sektion, keine Anwendungs-Chips).
 *  - Das Hero-Band hat id="hero": das 1. Navigations-Element
 *    "Nach oben" dient sowohl als Scroll-Spy-Anker (es wird blau,
 *    solange der Hero im Sichtbereich ist) als auch als
 *    "Zurück-nach-oben"-Sprungziel (Klick scrollt an den Anfang).
 *  - Sektionsnavigation: vertikale rechte Schiene auf lg+, schwebender
 *    "Nach oben"-Button auf <lg (kein Sticky-Top auf Mobile);
 *    Reihenfolge Nach oben / Abmessungen / Leistungskurve /
 *    Spezifikation / Broschüre.
 *  - 4. Maßzeichnung: dimension-4-de.webp (statt EN-Version).
 *  - PDF-Download: ECO AIR Cleaner Katalog, DE, v4.2.
 *  - Galerie: automatische Rotation alle 5s, pausiert bei Hover /
 *    Tastatur-Fokus / wenn außerhalb des Sichtbereichs; respektiert
 *    prefers-reduced-motion.
 *  - Cross-Links: Elektrostatisch / Entstaubung.
 *
 * Wie die EN-Version: Galerie und Sub-Menü-JS sind inline am Ende
 * der Datei (type="module"), kein externes Enqueue.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

// See template-parts/page-products-mechanical.php for the rationale
// behind splitting the URI into a mechanical/ subfolder (logo,
// dimensions, specs reference) and a parent folder (3 product
// photos shared with the home-page section template).
$emifree_uri               = get_template_directory_uri() . '/assets/products/mechanical/';
$emifree_photos_uri        = get_template_directory_uri() . '/assets/products/';
$emifree_gallery           = emifree_get_mechanical_gallery();
$emifree_specs_rows        = emifree_get_mechanical_specs_rows( 'de' );
$emifree_dimension_images  = emifree_get_mechanical_dimension_images( false );
$emifree_performance_curves = emifree_get_mechanical_performance_curves( 'de' );
$emifree_brochure_url      = get_template_directory_uri() . '/assets/catalog/emifree_eco_air_cleaner_katalog_DE_v4.2.pdf';
$emifree_applications      = emifree_get_mechanical_applications( 'de' );
$emifree_cta               = emifree_get_mechanical_cta( 'de' );
$emifree_contact_url       = home_url( '/de/?quote=mechanical#contact' );
?>

<div class="min-h-screen bg-white">

	<?php /* Seitenkopf: Zurück-Link + Brotkrumen + 2-spaltiger Hero.
		 *
		 * Das gesamte bg-slate-50-Band trägt id="hero", damit das
		 * 1. Navigations-Element "Angebot" (rechte Schiene / Sticky-Top)
		 * zwei Aufgaben erfüllen kann:
		 *   1. Als Scroll-Spy-Anker: der IntersectionObserver am Ende
		 *      der Datei beobachtet #hero und hebt das "Angebot"-Pill
		 *      hervor, solange irgendein Teil des Hero-Bands im
		 *      Sichtbereich ist (vom Seitenanfang bis kurz vor dem
		 *      Abmessungen-Absatz).
		 *   2. Als "Zurück nach oben"-Sprungziel: ein Klick auf
		 *      "Angebot" scrollt zu #hero, also an den Anfang der
		 *      Seite (das Hero-Band ist das erste Element im DOM).
		 *
		 * Der Anker liegt absichtlich auf dem äußeren Band und nicht
		 * nur auf dem CTA-Button, damit der Scroll-Spy den gesamten
		 * Hero-Bereich abdeckt — nicht nur den Moment, in dem der
		 * Button genau in der 5%-Schnittzone des Observers liegt. */ ?>
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
					<li aria-current="page" class="text-slate-700">Mechanische Filtration</li>
				</ol>
			</nav>

			<?php /* Das 2-Spalten-Grid beherbergt den Magnify-Hover-
			 * Effekt: `.emifree-magnify-source` ist die `:hover`-
			 * Quelle für das Zoom-Panel in der rechten Spalte
			 * (nur auf `lg+` — siehe tailwind.src.css
			 * `.emifree-zoom-panel`). */ ?>
			<div class="emifree-magnify-source grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<?php /* Links: Logo + Galerie */ ?>
				<div>
					<img
						src="<?php echo esc_url( $emifree_uri . 'eco_air_final.png' ); ?>"
						alt="ECO AIR Cleaner Wortmarke"
						class="w-48 md:w-56 h-auto mb-6"
						decoding="async"
					>

					<div data-emifree-gallery class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
						<?php /* Hauptbild-Bereich, vom Inline-JS unten getauscht.
						 *
						 * Auf `lg+`-Viewports blendet das Hovern über
						 * dieses Bild ein separates Zoom-Panel in der
						 * rechten Spalte (den Titel-/Intro-Slot) ein —
						 * siehe `.emifree-zoom-panel` in
						 * tailwind.src.css. Das Hauptbild selbst bewegt
						 * sich nie; das Panel zeigt die vergrößerte
						 * Ansicht, mit `object-position` gesteuert
						 * von der Cursor-Position über diesem Bild
						 * (über die `--emifree-mx` / `--emifree-my`
						 * CSS-Vars am 2-Spalten-Grid-Container). Das
						 * Standard-E-Commerce-Muster nach Amazon-
						 * Vorbild. */ ?>
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

				<?php /* Rechts: Titel + Anwendungen + Angebots-CTA + Einleitung.
				 *
				 * Die Anwendungs-Chips sitzen direkt unter dem Titel —
				 * sie sind die kategorische Kurzfassung dessen, wofür
				 * die Linie gedacht ist (CNC-Bearbeitung, Schleifen,
				 * Drehen, Fräsen, Senkerodieren), und liefern dem
				 * Besucher sofort den Anwendungs-Kontext, bevor er
				 * den längeren Einleitungs-Absatz liest.
				 *
				 * Der Angebots-Button (id="angebot") folgt direkt darunter
				 * und ist der primäre Call-to-Action der Seite. Das
				 * 4. Navigations-Element "Angebot" (rechte Schiene /
				 * Sticky-Top) scrollt zu dieser Stelle im Hero; der
				 * Button selbst führt mit einem weiteren Klick zum
				 * Kontaktformular (/de/#contact).
				 *
				 * Die Einleitung kommt zuletzt, damit der Lesefluss
				 * "Was ist es? → Wofür? → Wie bestellen? → Details"
				 * statt "Details → Was ist es?" lautet. */ ?>
				<div class="relative emifree-zoom-slot min-h-[280px] md:min-h-[320px]">
					<?php /* Rechts: Titel + Anwendungen + CTA + Intro per
					 * Default, Magnify-Panel auf `lg+`-Hover der
					 * Galerie. Der `.emifree-zoom-text`-Wrapper
					 * blendet aus, während das Panel sichtbar ist,
					 * und wieder ein, wenn der Cursor die Galerie
					 * verlässt. Das Panel ist `pointer-events: none`,
					 * damit der Cursor zur Galerie durchgereicht wird
					 * (kein "festhängender" Hover-Zustand). */ ?>
					<div class="emifree-zoom-text">
						<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">Mechanische Filtration</p>
						<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">Industrielle Ölnebelabscheidung</h1>
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
							Unsere mechanische Filtrationsanlage nutzt Zentrifugalkraft, um Ölnebel und Kühlschmierstoffdämpfe direkt an der Quelle abzuscheiden, für anspruchsvolle CNC-Zerspanungsumgebungen.
						</p>
					</div>
					<div class="emifree-zoom-panel" aria-hidden="true">
						<?php /* Das Magnify-Panel rendert dasselbe Bild als
						 * CSS-Hintergrund in 2,5x-Skalierung, nicht als
						 * zweites <img> mit object-fit. Mit `background-
						 * size: 250%` + `background-position`, gesteuert
						 * vom Cursor-Prozent über dem Hauptbild, bildet
						 * der sichtbare Ausschnitt in diesem Panel das
						 * Pixel unter dem Cursor 1:1 ab. (Ein <img> mit
						 * object-fit: contain erzeugt Letterbox-Ränder
						 * im Element, sodass die Cursor-Prozentangabe nur
						 * einen Teilbereich des tatsächlichen Bildes
						 * beschreiben würde — ein background-image hat
						 * keine Letterbox, daher bleibt die Zuordnung
						 * unabhängig vom Bildseitenverhältnis genau.)
						 *
						 * `role="img"` + `aria-label` spiegeln das alt
						 * des Hauptbildes, sodass ein Screenreader, der
						 * den Panel-Inhalt vorliest, dieselbe Beschreibung
						 * hört wie beim statischen Foto. Das inline
						 * `background-image`-Saat wird vom Galerie-JS
						 * ersetzt, wenn der Nutzer einen anderen Thumb
						 * anklickt. */ ?>
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
	</div>
	<?php /* Desktop (lg+) rechte Schiene — vertikale Floating-Pill-
	 * Leiste am rechten Viewport-Rand, "extended FAB" Behandlung.
	 * Die Elemente sind von oben nach unten gestapelt, sodass die
	 * Schiene natürlich zu lesen ist, ohne dass das Auge
	 * links-rechts wandern muss.
	 *
	 * Warum nur auf Desktop: eine rechte Schiene ist ~130px breit;
	 * auf einem 375px-Mobilbildschirm würde sie die rechten 35%
	 * des Viewports belegen und Maße-/Spezifikations-Inhalte
	 * überlappen. Auf Mobile ist die Schiene ausgeblendet
	 * (`hidden lg:flex`) — der schwebende "Nach oben"-Button
	 * unten deckt den "Springe nach oben"-Use-Case für schmale
	 * Viewports ab.
	 *
	 * `padding-bottom: env(safe-area-inset-bottom)` hält die
	 * Schiene auf iPhones mit Home-Indikator über der System-UI.
	 * Tailwind v3 stellt keine Safe-Area-Utilities bereit, daher
	 * ist der Inline-Stil die wartbarste Lösung.
	 *
	 * Jeder Link nutzt die Klasse `.emifree-product-submenu__link`,
	 * sodass der IntersectionObserver am Ende der Datei den
	 * aktiven Abschnitt beim Scrollen in Echtzeit hervorhebt. */ ?>
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
			<a href="#brochure" data-section="brochure" class="emifree-product-submenu__link inline-flex items-center justify-center px-4 py-3 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors whitespace-nowrap">
				Broschüre
			</a>
		</nav>
	</div>

	<?php /* Schwebender "Nach oben"-Button — die Navigation für
	 * schmale Viewports. Die rechte Schiene oben deckt Desktop
	 * (lg+) ab; die Sticky-Top-Leiste auf Mobile ist absichtlich
	 * weggelassen, weil sie ~64px vertikalen Platz an jeder
	 * Scroll-Position belegen würde. Der Button wird auf dem
	 * Hero selbst ausgeblendet (per JS unten), damit er nicht
	 * direkt beim Seitenaufruf über dem Seitenanfang sitzt.
	 *
	 * `padding-bottom: env(safe-area-inset-bottom)` hält den
	 * Button über dem iPhone Home-Indikator. Tailwind v3 stellt
	 * keine Safe-Area-Utilities bereit, daher ist der Inline-Stil
	 * die wartbarste Lösung. */ ?>
	<a href="#hero" data-emifree-back-to-top
		class="fixed right-4 bottom-4 lg:right-6 lg:bottom-6 z-40 inline-flex items-center gap-1.5 px-4 py-3 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-xl ring-1 ring-blue-700/20 hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition-colors transition-opacity duration-200 opacity-0 pointer-events-none"
		style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px));"
		aria-label="Nach oben">
		<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
			<path d="M12 19V5"></path>
			<path d="m5 12 7-7 7 7"></path>
		</svg>
		Nach oben
	</a>

	<?php /* Abmessungen: 2x2-Raster der mechanischen Zeichnungen. */ ?>
	<section id="dimensions" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Abmessungen</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Technische Zeichnungen des ECO AIR Cleaners in der Standard- und HEPA-Ausführung. Alle Maße in Millimetern.
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

	<?php /* Leistungskurve: 2×1-Raster der Druckverlust-/
	 * Volumenstrom-Kennlinien für die 1200-m³/h- und
	 * 1500-m³/h-Variante des ECO AIR Cleaners.
	 *
	 * Die Bilder werden als <figure>-Karten in derselben Form
	 * wie die Maßzeichnungen oben gerendert (bg-slate-50-Karte,
	 * zentriertes Bild, max-h-420px, damit keine Kurve die
	 * Zeile dominiert, falls eine höher ist als die andere).
	 * Jede Karte trägt eine kleine Beschriftung unter dem
	 * Bild ("1200 m³/h" / "1500 m³/h"), damit der Besucher
	 * die Kurve der Variante in der Spezifikations-Tabelle
	 * unten zuordnen kann, ohne die Achsenbeschriftung lesen
	 * zu müssen.
	 *
	 * Die Sektion verwendet `bg-slate-50`, um mit der weißen
	 * Abmessungen-Sektion darüber zu alternieren — derselbe
	 * visuelle Rhythmus, den die Seite bereits nutzt (weiß /
	 * slate-50 zwischen den bestehenden Sektionen). Das
	 * `scroll-mt-20` verhindert, dass das Sticky-Top-Untermenü
	 * die Überschrift nach einem Anker-Sprung verdeckt.
	 *
	 * Premium + HEPA wird hier absichtlich NICHT gezeigt —
	 * der Frequenzumrichter dieser Variante erlaubt es dem
	 * Kunden, einen beliebigen Arbeitspunkt zwischen den
	 * beiden festen Kurven zu wählen, daher wäre eine
	 * Einzelkurve irreführend. Die Spezifikations-Tabelle
	 * unten zeigt in der Premium-+-HEPA-Spalte der
	 * Luftleistungs-Zeile bereits "—" aus demselben Grund. */ ?>
	<section id="performance" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Leistungskurve</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Druckverlust- / Volumenstrom-Kennlinien der beiden ECO AIR Cleaner-Varianten. Die rote Markierung auf jeder Kurve zeigt den Nennarbeitspunkt des Geräts.
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

	<?php /* Spezifikation: 3-spaltige Tabelle.
	 *
	 * Mobil (<sm): Tabelle ist breiter als der Viewport — `min-w-[640px]`
	 * auf dem <table>-Element, `overflow-x-auto` am Wrapper für den
	 * horizontalen Scroll. Der "Wischen für mehr Spalten"-Hinweis über
	 * der Tabelle (auch <sm) signalisiert dem Nutzer, dass die Tabelle
	 * scrollbar ist; ein CSS-Gradient-Mask am rechten Rand des Wrappers
	 * deutet visuell an, dass es mehr Inhalt gibt, bevor der Nutzer
	 * scrollt.
	 *
	 * sm+ (>=640px): 640px min-w passt ohne Scroll in den Viewport, der
	 * Hinweis wird mit `sm:hidden` ausgeblendet.
	 *
	 * Cell-Padding fällt auf `px-4` (von `px-6`) auf Mobil, um ~16px
	 * horizontalen Platz auf einem 375px-Viewport zurückzugewinnen. */ ?>
	<section id="specs" class="scroll-mt-20 py-16 md:py-20 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Spezifikation</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Technischer Vergleich des ECO AIR Cleaners in zwei Ausführungen: Advanced und Premium + HEPA. Optionale Varianten und Zubehör sind entsprechend gekennzeichnet.
			</p>
			<p class="sm:hidden text-sm text-slate-500 mb-3 flex items-center gap-1.5" aria-hidden="true">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
				Wischen für mehr Spalten
			</p>
			<div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200 emifree-specs-scroll">
				<table class="w-full text-left min-w-[640px]">
					<thead class="bg-blue-600 text-white">
						<tr>
							<th scope="col" class="px-4 sm:px-6 py-4 font-semibold">Spezifikation</th>
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

	<?php /* Broschüre: einzelne ECO-AIR-Katalog-Download-Karte. */ ?>
	<section id="brochure" class="scroll-mt-20 py-16 md:py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4">Broschüre</h2>
			<p class="text-lg text-slate-600 mb-8 max-w-3xl">
				Laden Sie den ECO AIR CLEANER Katalog für weitere Informationen herunter.
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
						<h3 class="text-xl font-semibold text-zinc-900 mb-1 leading-snug">ECO AIR Cleaner Katalog</h3>
						<div class="flex items-center gap-3 text-sm text-slate-500 mb-3">
							<span>v4.2</span>
							<span aria-hidden="true">·</span>
							<span>2,1 MB</span>
							<span aria-hidden="true">·</span>
							<span class="bg-slate-100 px-2 py-0.5 rounded text-xs font-semibold">DE</span>
						</div>
						<span class="inline-flex items-center gap-2 text-blue-700 group-hover:text-blue-800 font-semibold text-sm">
							PDF herunterladen
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

	<?php /* Cross-Link-Streifen: 2 Geschwister-Produktkarten + Zurück-Link. */ ?>
	<div class="mt-8 py-16 border-t border-slate-200 bg-slate-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl font-bold text-zinc-900 mb-6">Weitere Produktlinien</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
				<a href="<?php echo esc_url( home_url( '/de/produkte/elektrostatische-filtration/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Elektrostatische Filtration</p>
					<p class="text-sm text-slate-600">Abscheidung sub-mikroner Partikel für Rauch, Feinnebel und industrielle Geruchsbelastung.</p>
				</a>
				<a href="<?php echo esc_url( home_url( '/de/produkte/entstaubung/' ) ); ?>" class="block p-5 rounded-xl border border-slate-200 bg-white hover:border-blue-200 hover:bg-blue-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
					<p class="font-semibold text-zinc-900 mb-1">Staubfiltration</p>
					<p class="text-sm text-slate-600">Patronen- und Schlauchfilterlösungen für Holzbearbeitung, Metallschleiferei und Schüttgut.</p>
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

<script type="module">
	// Galerie: Klick auf Thumbnail tauscht das Hauptbild und aria-current.
	// Automatischer Wechsel alle 5 s; pausiert bei Hover, Fokus,
	// reduced-motion oder wenn die Galerie aus dem Viewport scrollt.
	// Manuelle Klicks setzen den Timer zurück.
	const emifreeGalleryRotator = 3000;
	const emifreePrefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	document.querySelectorAll('[data-emifree-gallery]').forEach((gallery) => {
		const main = gallery.querySelector('[data-emifree-gallery-main]');
		const zoom = document.querySelector('[data-emifree-zoom-image]');
		const thumbs = gallery.querySelectorAll('[data-emifree-thumb]');
		// Der 2-Spalten-Grid-Wrapper, der sowohl die Galerie als
		// auch das Seitenpanel-Magnify beherbergt. CSS-Variablen
		// für den Magnify werden hier geschrieben, damit das
		// Panel (Geschwister, nicht Kind) sie lesen kann. Fallback
		// auf den Galerie-Elternteil, falls die
		// .emifree-magnify-source-Klasse fehlt (defensiv gegen
		// zukünftige Markup-Änderungen).
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
				// Seitenpanel-Zoom synchron mit dem statischen Bild
				// halten. Das Panel ist ein <div> mit einem CSS-
				// background-image (background-size: 250%,
				// background-position gesteuert vom Cursor-% über
				// der Galerie via CSS-Vars am 2-Spalten-Grid-
				// Wrapper); ohne diesen Tausch würde der Hover-Zoom
				// das vorherige Foto zeigen.
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

		// Manueller Klick — Sprung zum Thumbnail und Timer-Neustart.
		thumbs.forEach((thumb, idx) => {
			thumb.addEventListener('click', () => {
				showIndex(idx);
				stop();
				start();
			});
		});

		// Pausiert bei Hover / Fokus, läuft weiter bei Verlassen / Blur.
		gallery.addEventListener('mouseenter', () => { isHovered = true;  stop(); });
		gallery.addEventListener('mouseleave', () => { isHovered = false; if (!hasFocus && isVisible) { start(); } });
		gallery.addEventListener('focusin',    () => { hasFocus   = true;  stop(); });
		gallery.addEventListener('focusout',   () => { hasFocus   = false; if (!isHovered && isVisible) { start(); } });

		// Pausiert, sobald die Galerie großteils außerhalb des Viewports ist.
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

		// Magnify: Cursor-Position über dem Hauptbild verfolgen
		// und die relative Position (0–100 %) als CSS-Variablen
		// am 2-Spalten-Grid-Wrapper schreiben. Das
		// `.emifree-zoom-panel` lebt in der rechten Spalte, nicht
		// in der Galerie, daher müssen die Variablen auf einem
		// gemeinsamen Vorfahren leben — dem Grid-Wrapper. Die
		// `background-position` des Panels liest diese Variablen,
		// sodass der sichtbare vergrößerte Ausschnitt dem Cursor
		// 1:1 folgt.
		//
		// WICHTIG: das Cursor-% wird aus der getBoundingClientRect()
		// des tatsächlichen <img>-Elements berechnet, NICHT aus
		// der des gepaddeten `aspect-[4/3]`-Wrappers. Der Wrapper
		// hat `p-6`-Padding um das Bild; vom Wrapper aus zu messen
		// würde (a) Hover-über-Padding als gültige Cursor-Position
		// behandeln (ist es nicht — dort ist kein Bild), und (b)
		// die Zuordnung pro Achse um ~6 % verschieben (der Anteil
		// des Paddings an Wrapper-Breite/Höhe). Die Bindung an
		// das <img> sorgt auch dafür, dass Hover-Events nur
		// feuern, wenn der Cursor über echten Bildpixeln ist.
		//
		// Die Sichtbarkeit des Seitenpanels wird über die
		// `emifree-magnify-source--active`-Klasse am Grid-Wrapper
		// gesteuert, die `mouseenter` setzt und `mouseleave`
		// entfernt. Die CSS nutzt diese Klasse (nicht `:hover`
		// am Grid, das auch feuern würde, wenn der Cursor in der
		// rechten Spalte ist, wo das Panel selbst lebt).
		// Touch-Geräte (kein mouseenter) überspringen dies
		// komplett — das Panel bleibt via @media (hover: hover)
		// + (min-width: 1024px) in der CSS bei opacity 0,
		// sodass der Magnify-Effekt für Touch-User und auf
		// md-und-kleiner-Viewports nie erscheint.
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
			// Bei Verlassen: aktive Klasse entfernen, damit
			// das Panel ausblendet, und CSS-Vars neu zentrieren,
			// damit beim erneuten Hover nicht kurz eine Ecke
			// des Panels angezeigt wird. An das <img> gebunden
			// (nicht den gepaddeten Wrapper), sodass das
			// Verlassen des Wrappers über das Padding keinen
			// Reset auslöst, solange der Cursor noch über echten
			// Bildpixeln ist.
			main.addEventListener('mouseleave', () => {
				magnifySource.classList.remove('emifree-magnify-source--active');
				magnifySource.style.setProperty('--emifree-mx', '50%');
				magnifySource.style.setProperty('--emifree-my', '50%');
			});
		}

		// Auto-Rotation beim Laden starten.
		start();
	});

	// Untermenü: Aktive Sektion hervorheben, sobald sie in den Sichtbereich scrollt.
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

	// Schwebender "Nach oben"-Button: einblenden, sobald der
	// Hero-Bereich aus dem Sichtfeld gescrollt wurde, und wieder
	// ausblenden, wenn er zurück im Blick ist. Ein
	// IntersectionObserver auf dem Hero-Element (statt eines
	// Scroll-Listeners) hält die Show/Hide-Logik aus dem
	// Main-Thread jedes Scroll-Ticks heraus.
	//
	// `rootMargin: '0px 0px -90% 0px'` schrumpft den
	// Beobachtungsbereich auf die oberen 10% des Viewports —
	// der Button erscheint, sobald der Hero aus diesem Streifen
	// herausgescrollt wurde, passend zum "below the fold"
	// mentalen Modell, nach dem Nutzer einen Zurück-Button
	// suchen.
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
