<?php
/**
 * Body content for "Luftdruckverlust vs. Druckabfall".
 *
 * DE-Begriffsartikel: klärt, dass „Luftdruckverlust" und
 * „Druckabfall" dieselbe physikalische Größe bezeichnen.
 * Zielgruppe: Nutzer, die nach beiden Begriffen suchen und
 * unsicher sind, ob sie unterschiedliche Dinge meinen.
 *
 * Interne Links zum Rechner + beiden Schwester-Artikeln.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Kurze Antwort: <strong>Luftdruckverlust</strong> und <strong>Druckabfall</strong> bezeichnen dieselbe physikalische Größe &mdash; die Abnahme des statischen Drucks, ausgedrückt in Pascal (Pa) oder Millimeter Wassersäule (mmWS). Wenn Sie einen deutschen VDI-3802-Katalog mit einem ASHRAE-Fundamentals-Handbuch vergleichen und am Ende verwirrt sind, liegt das Problem fast immer an der Begrifflichkeit, nicht an der Physik.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Woher kommen die beiden Begriffe?</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<table class="w-full text-left text-base text-zinc-800">
		<thead>
			<tr class="border-b border-slate-300">
				<th class="py-2 pr-4 font-semibold">Begriff</th>
				<th class="py-2 pr-4 font-semibold">Tradition</th>
				<th class="py-2 font-semibold">Wo Sie ihn finden</th>
			</tr>
		</thead>
		<tbody>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">Druckabfall</td><td class="py-2 pr-4">DIN / VDI (wörtliche Übersetzung von &bdquo;pressure drop&ldquo;)</td><td class="py-2">VDI 3802, deutsche Normen, europäische Lieferantenkataloge</td></tr>
			<tr><td class="py-2 pr-4">Luftdruckverlust</td><td class="py-2 pr-4">Technische Umgangssprache (Installateur / Anlagenbau)</td><td class="py-2">HVAC-Installateurunterlagen, Kanal-Lieferanten-Spezifikationen</td></tr>
		</tbody>
	</table>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Beide Begriffe bezeichnen dasselbe: <em>&Delta;P</em> &mdash; die Druckdifferenz zwischen zwei Punkten in einem Kanalstrang. Das Symbol, die Einheiten und die zugrunde liegende Gleichung (Darcy&ndash;Weisbach + K-Faktor) sind identisch.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Und &bdquo;statischer Druckverlust&ldquo;?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	<em>Statischer Druckverlust</em> ist dieselbe Größe, mit einem klärenden Zusatzwort. In einem strömenden Kanal ist der Gesamtdruck die Summe aus statischem Druck (das Vermögen, Luft zu verdrängen) und Geschwindigkeitsdruck (½&middot;&rho;&middot;V&sup2;, die kinetische Energie der bewegten Luft). Druckverlust ist der Verlust an <em>statischem</em> Druck, weil die Geschwindigkeit in einem gleichförmigen Kanalstrang ungefähr konstant bleibt &mdash; daher ist die präzisere Bezeichnung &bdquo;statischer Druckverlust&ldquo;, aber &bdquo;Druckabfall&ldquo; und &bdquo;Druckverlust&ldquo; werden in praktisch jedem Katalog synonym verwendet.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Ist dem Rechner der Begriff egal?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Ja. Der kostenlose <a href="/de/luftdruckverlust-rechner/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust-Rechner</a> verwendet dasselbe Darcy&ndash;Weisbach + K-Faktor-Modell, egal ob Sie das Ergebnis Druckverlust, Druckabfall oder statischen Druckverlust nennen. Was zählt: Luftstrom (m&sup3;/h), Kanaldurchmesser (mm), gerade Länge (m), Formstücktypen, Material (verzinkt, Aluminium, Schwarzstahl) und Anwendung (HVAC, Ölnebel, Staub). Diese Werte eingeben &mdash; das Ergebnis ist Ihr statischer Druckverlust in Pa.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Häufige Synonyme</h2>
<ul class="list-disc pl-6 space-y-2 text-lg text-zinc-700 leading-relaxed mb-6">
	<li><strong>Druckabfall</strong> (DIN / VDI)</li>
	<li><strong>Druckverlust</strong> (Installateur / Anlagenbau)</li>
	<li><strong>Statischer Druckverlust</strong> (präzise Form)</li>
	<li><strong>&Delta;P</strong> (Ingenieur-Kurzform)</li>
	<li><strong>Gesamtdruckverlust</strong> (voller Kanalstrang, einschließlich Formstücke)</li>
	<li><strong>Reibungsverlust</strong> (nur Reibungsanteil, ohne Formstücke)</li>
</ul>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Die vollständige Berechnung mit Formel-Ableitung finden Sie im <a href="/de/blog/was-ist-luftdruckverlust/" class="text-blue-700 hover:text-blue-800 underline">Was ist Luftdruckverlust?</a>-Pillar-Artikel, und eine Schritt-für-Schritt-Durchrechnung im <a href="/de/blog/luftdruckverlust-berechnen/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust im Kanal berechnen</a>-Tutorial.
</p>
HTML
);
