<?php
/**
 * Page body, DE: /wissen/hepa-filter-cnc-industrielle-werkstaetten/
 *
 * Deutsche Variante von page-hepa-filters.php (EN). Selbe Struktur
 * (Hero mit Galerie + Titel + CTA + 4 Intro-Punkten, dann 5
 * H2-Abschnitte, dann Abschluss-CTA), übersetzte Strings.
 *
 * ----- ÜBERSETZUNGSHINWEIS (für die Inhaltsprüfung) -----
 * Die DE-Texte wurden mit automatisierter Übersetzung erstellt
 * (DeepL / Google Translate, Stand 2026-10-14) und müssen VOR
 * der öffentlichen Veröffentlichung von einer/m muttersprachlichen
 * DE-Redakteur:in gegengelesen werden. Insbesondere zu prüfen:
 *
 *   - Fachbegriffe (HEPA, Vorfilter, Luftstrom, Druckverlust) —
 *     branchenübliche DE-Begriffe verwenden
 *   - Sicherheitshinweis (Combustible dust) — die deutsche
 *     Rechtschreibung und Tonalität muss der EN-Vorlage
 *     entsprechen, der Inhalt darf nicht abgeschwächt werden
 *   - CTA-Beschriftung ("Angebot anfordern") — soll mit der
 *     Tonaliät der EN-CTA ("Request a quote") übereinstimmen
 *
 * Bis zur Freigabe durch die Redaktion ist der Zugang zur
 * DE-Seite im Theme aktiv, aber das DE-Mirroring im
 * Language-Switcher ist noch nicht auf diese URL gemappt.
 *
 * Renders template-parts/page-hepa-filters-de.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/products-page-helpers.php';

$emifree_uri         = get_template_directory_uri() . '/assets/products/hepa/';
$emifree_gallery     = emifree_get_hepa_gallery();
$emifree_hero_intro  = emifree_get_hepa_hero_intro( 'de' );
$emifree_cta         = emifree_get_hepa_cta( 'de' );
$emifree_contact_url = home_url( '/de/?quote=hepa#contact' );
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
					<li><a href="<?php echo esc_url( home_url( '/de/wissen/' ) ); ?>" class="hover:text-blue-700">Wissen</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo esc_url( home_url( '/de/wissen/hepa-filter-cnc-industrielle-werkstaetten/' ) ); ?>" class="hover:text-blue-700">HEPA-Filter</a></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">

				<?php /* Linke Spalte: Galerie */ ?>
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

				<?php /* Rechte Spalte: Titel + CTA + Intro */ ?>
				<div class="relative min-h-[280px] md:min-h-[320px]">
					<p class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-3">HEPA-Filtration</p>
					<h1 class="text-4xl md:text-5xl font-bold text-zinc-900 mb-5 leading-tight">HEPA-Filter in CNC- &amp; Industriewerkstätten: Einsatz, Grenzen &amp; Sicherheit</h1>
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

	<?php /* ----- Body: 5 H2-Abschnitte + Abschluss-CTA -----

	   Die 5 Abschnitte spiegeln die EN-Reihenfolge exakt. Die
	   technischen Aussagen wurden 1:1 aus der markdown-Quelle
	   (HEPA_SECTIONMD.md, Stand 2026-10-14) übernommen und nur
	   sprachlich lokalisiert. Fachbegriffe (HEPA, Vorfilter,
	   Luftstrom, Druckverlust) wurden aus der bestehenden
	   DE-Site-Terminologie übernommen, der Sicherheitshinweis
	   bleibt sprachlich nah an der EN-Vorlage, weil es um
	   Rechtsverbindlichkeit geht.

	   Die Sektion-IDs (#hepa-best-uses, #hepa-limitations, …)
	   sind sprachneutral und stimmen mit der EN-Seite überein,
	   damit ein eventuelles Inhaltsverzeichnis (zukünftige
	   Erweiterung) auf beiden Sprachversionen dieselben Anker
	   verwenden kann. */ ?>

	<div class="bg-white">
		<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

			<section id="hepa-best-uses" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Einsatzbereiche</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li><strong class="text-zinc-900">CNC-Bearbeitung:</strong> Reduziert schwebende Metall-, Kunststoff-, Holz- und Verbundwerkstoff-Stäube. Ein HEPA-Filter ist in der Lage, selbst kleinste Partikel (0,12&ndash;0,25&nbsp;Mikrometer) mit einem Wirkungsgrad von 99,95&nbsp;% aus der Luft zu filtern &ndash; ideal für die feinen Aerosole, die bei diesen Prozessen entstehen.</li>
					<li><strong class="text-zinc-900">Holzbearbeitungs-Fräsen:</strong> Nimmt feine Reststäube auf; MDF, Sperrholz usw. möglichst direkt an der Maschine absaugen.</li>
					<li><strong class="text-zinc-900">Kunststoffe/Verbundwerkstoffe:</strong> Reinigt feine, reizende Stäube in der Umgebungsluft; die Quellenabsaugung bleibt unverzichtbar.</li>
					<li><strong class="text-zinc-900">Schleifen/Polieren/Oberflächenbearbeitung:</strong> Hält Feinstaub zurück, der sich über den Arbeitsbereich hinaus ausbreitet.</li>
				</ul>
			</section>

			<section id="hepa-limitations" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Grenzen</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li>HEPA filtert Partikel, keine Gase oder Dämpfe.</li>
					<li>Ölnebel, Kühlschmierstoffdämpfe, Schweißrauche, Lösemittel- und Chemikaliendämpfe erfordern <a href="<?php echo esc_url( home_url( '/de/produkte/mechanische-filtration/' ) ); ?>" class="text-blue-700 hover:text-blue-800 underline">Nebelabscheider</a>, Schweißrauchabsaugung, Aktivkohlefilter oder lokale Entlüftung.</li>
					<li>Ölige/klebrige Stäube verstopfen HEPA schnell. Vorfilter einsetzen und ggf. Koaleszenz-/Nebelvorfilter ergänzen.</li>
				</ul>
			</section>

			<section id="hepa-selection-checklist" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Auswahl-Checkliste</h2>
				<ul class="space-y-3 text-lg text-slate-700 leading-relaxed list-disc pl-6">
					<li>Luftstrom/Reinluftleistung auf Raumgröße und Staublast abstimmen.</li>
					<li>Vorfilter vor den HEPA schalten; bei Bedarf Aktivkohle- oder Nebelvorfilter ergänzen.</li>
					<li>Bei brennbarem Staub (Holz, Aluminium, einige Kunststoffe) nur explosionsgeschützte, zertifizierte Geräte einsetzen.</li>
					<li>Aufstellung für gute Luftzirkulation, Ansaugöffnung aber fern von Hauptstaubquellen platzieren.</li>
					<li>Druckverlust überwachen; Vorfilter regelmäßig und HEPA nach Herstellerangabe wechseln.</li>
					<li>Eignung für Material, Brand-/Explosionsrisiko und lokale Sicherheitsvorschriften prüfen.</li>
				</ul>
			</section>

			<section id="hepa-safety-note" class="mb-12 scroll-mt-20 border-l-4 border-red-500 bg-red-50 p-6 rounded-r-lg">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-4 flex items-center gap-3">
					<svg class="w-8 h-8 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
						<line x1="12" y1="9" x2="12" y2="13"></line>
						<line x1="12" y1="17" x2="12.01" y2="17"></line>
					</svg>
					Sicherheitshinweis
				</h2>
				<p class="text-lg text-slate-800 leading-relaxed">
					Brennbarer Staub kann sich im Inneren von HEPA-Geräten oder in Rohrleitungen ansammeln und eine Brand- bzw. Explosionsgefahr darstellen. Ein Standard-HEPA-Gerät ist dafür nicht ohne Weiteres geeignet. Nur zertifizierte Geräte mit Erdung, ordentlicher Sauberkeit und Explosionsschutz einsetzen.
				</p>
			</section>

			<section id="hepa-practical-setup" class="mb-12 scroll-mt-20">
				<h2 class="text-3xl md:text-4xl font-bold text-zinc-900 mb-6">Praxis-Setup</h2>
				<ol class="space-y-3 text-lg text-slate-700 leading-relaxed list-decimal pl-6">
					<li>Den Großteil des Staubs direkt an der CNC-Maschine mit Absaugung oder Einhausung erfassen.</li>
					<li>Eine HEPA-Ventilator-Filter-Einheit für feine Schwebstoffe in der Umgebungsluft einsetzen.</li>
					<li>Allgemeine Raumbelüftung für Frischluft sowie Wärme- und Gasabfuhr vorsehen.</li>
					<li>Vorfilter verwenden und den Filterzustand regelmäßig kontrollieren.</li>
					<li>Filter, Böden, Ablageflächen und Rohrleitungen sauber halten.</li>
				</ol>
			</section>

			<?php /* Abschluss-CTA, spiegelt die Empfehlung aus der
			   markdown-Quelle ("Contact us to select the right HEPA
			   filtration setup for your workshop"). Ziel ist dasselbe
			   Kontaktformular wie im Hero-CTA (mit ?quote=hepa), damit
			   das Subject-Feld im Mailclient passend vorbefüllt wird. */ ?>
			<div class="mt-16 text-center bg-slate-50 border border-slate-200 rounded-2xl p-8 md:p-12">
				<h2 class="text-2xl md:text-3xl font-bold text-zinc-900 mb-4">Brauchen Sie Hilfe bei der Auswahl des passenden HEPA-Filtrations-Setups?</h2>
				<p class="text-lg text-slate-600 mb-6 max-w-2xl mx-auto">
					Sprechen Sie unser Team zu Luftstrom, Vorfilter und Explosionsschutz für Ihre konkrete Werkstatt an.
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

<?php /* Galerie-Thumb-Swap-JS, identisch mit der EN-Seite. */ ?>
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
