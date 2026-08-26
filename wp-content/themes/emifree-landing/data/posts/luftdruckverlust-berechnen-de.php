<?php
/**
 * Body content for "Luftdruckverlust im Kanal berechnen".
 *
 * DE-Rechenbeispiel für den Suchbegriff-Cluster
 * „Luftdruckverlust berechnen" / „Druckverlustberechnung".
 * Mid-Funnel: Nutzer kennt den Begriff und will Zahlen sehen.
 *
 * Interne Links zurück zum Rechner + Pillar-Artikel.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Dieser Artikel rechnet eine echte <strong>Luftdruckverlust-Berechnung</strong> für eine industrielle Ölnebel-Absaugung durch: 1.700 m&sup3;/h durch 8 m verzinktes 200-mm-Rohr, zwei 90&deg;-Bögen, ein T-Stück und ein Reduzierstück auf 160 mm. Wir verwenden die Darcy&ndash;Weisbach + K-Faktor-Methode aus dem <a href="/de/blog/was-ist-luftdruckverlust/" class="text-blue-700 hover:text-blue-800 underline">Was ist Luftdruckverlust?</a>-Pillar-Artikel, wenden die 1,15-Ölnebel-Korrektur an und addieren die 2&times;-Ventilator-Sicherheitsmarge. Unten finden Sie das Ergebnis, oder Sie verwenden direkt unseren kostenlosen <a href="/de/luftdruckverlust-rechner/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust-Rechner</a>.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 1 &mdash; Eingaben</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<ul class="space-y-2 text-base text-zinc-800">
		<li><strong>Luftstrom:</strong> Q = 1.700 m&sup3;/h = 0,472 m&sup3;/s</li>
		<li><strong>Kanalmaterial:</strong> verzinkter Stahl (Rauigkeit &epsilon; = 0,15 mm)</li>
		<li><strong>Anwendung:</strong> Ölnebel (Korrekturfaktor K<sub>app</sub> = 1,15)</li>
		<li><strong>Luftdaten:</strong> &rho; = 1,2 kg/m&sup3;, &mu; = 1,81&times;10&#8315;&#8308; Pa&middot;s (20&nbsp;&deg;C, Meereshöhe)</li>
	</ul>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 2 &mdash; Abschnitt A: 200 mm gerader Kanal</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p>D = 0,200 m &middot; A = &pi;&middot;D&sup2;/4 = 0,0314 m&sup2;</p>
	<p>V = Q/A = 0,472 / 0,0314 = 15,0 m/s</p>
	<p>Re = &rho;&middot;V&middot;D/&mu; = 1,2 &middot; 15,0 &middot; 0,200 / 1,81&times;10&#8315;&#8308; = 199.000</p>
	<p>f (Swamee&ndash;Jain) = 0,0206</p>
	<p>L = 8 m &rArr; &Delta;P<sub>f</sub> = 0,0206 &middot; (8/0,2) &middot; 0,5 &middot; 1,2 &middot; 15,0&sup2; = <strong>111 Pa</strong></p>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 3 &mdash; Formstücke in Abschnitt A</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<table class="w-full text-left text-base text-zinc-800">
		<thead>
			<tr class="border-b border-slate-300">
				<th class="py-2 pr-4 font-semibold">Formstück</th>
				<th class="py-2 pr-4 font-semibold">K-Faktor</th>
				<th class="py-2 font-semibold">&Delta;P<sub>m</sub> = K&middot;&half;&middot;&rho;&middot;V&sup2;</th>
			</tr>
		</thead>
		<tbody>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">90&deg;-Bogen (tiefgezogen, r/D = 1,5)</td><td class="py-2 pr-4 font-mono">0,18</td><td class="py-2 font-mono">24,3 Pa</td></tr>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">90&deg;-Bogen (tiefgezogen, r/D = 1,5)</td><td class="py-2 pr-4 font-mono">0,18</td><td class="py-2 font-mono">24,3 Pa</td></tr>
			<tr><td class="py-2 pr-4">T-Stück (Durchgang)</td><td class="py-2 pr-4 font-mono">1,20</td><td class="py-2 font-mono">162,0 Pa</td></tr>
		</tbody>
	</table>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Zwischensumme Abschnitt A: 111 + 24,3 + 24,3 + 162,0 = <strong>321,6 Pa</strong>.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 4 &mdash; Abschnitt B: 160 mm nach dem Reduzierstück</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Das Reduzierstück hat K = 0,10. Neue Geschwindigkeit V = 0,472 / (&pi;&middot;0,16&sup2;/4) = 23,4 m/s. Wir nehmen 2 m gerades 160-mm-Rohr am Ausgang für den Filteranschluss an.
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p>Re = 1,2 &middot; 23,4 &middot; 0,160 / 1,81&times;10&#8315;&#8308; = 248.000</p>
	<p>f (Swamee&ndash;Jain) = 0,0196</p>
	<p>Reibung: &Delta;P<sub>f</sub> = 0,0196 &middot; (2/0,16) &middot; 0,5 &middot; 1,2 &middot; 23,4&sup2; = <strong>40,2 Pa</strong></p>
	<p>Reduzierstück K-Verlust: &Delta;P<sub>m</sub> = 0,10 &middot; 0,5 &middot; 1,2 &middot; 23,4&sup2; = <strong>32,9 Pa</strong></p>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 5 &mdash; Ölnebel-Korrektur anwenden</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Rohtotal: 321,6 + 40,2 + 32,9 = 394,7 Pa. Mit K<sub>app</sub> = 1,15 für Ölnebel (berücksichtigt die Reibung des Flüssigkeitsfilms an der Rohrwand): <strong>&Delta;P<sub>gesamt</sub> = 453,9 Pa</strong>.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Schritt 6 &mdash; Ventilator-Empfehlung</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Branchenüblich ist eine 2&times;-Sicherheitsmarge: Ventilator-Statikdruck = 2 &middot; 453,9 = <strong>~910 Pa</strong> bei 1.700 m&sup3;/h. Den Filterpatronen-Druckverlust addieren Sie oben drauf (typisch 500&ndash;1.500 Pa bei einer Ölnebel-Filterpatrone) &mdash; das ergibt die Gesamt-Ventilatorleistung. Eine reale Auslegung hier wäre also 1.500 Pa bei 1.700 m&sup3;/h &mdash; eine gängige Größe für eine einzelne CNC-Zelle.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Wolllen Sie eigene Werte eingeben? Der kostenlose <a href="/de/luftdruckverlust-rechner/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust-Rechner</a> erledigt alle sechs Schritte automatisch. Die theoretische Grundlage finden Sie im <a href="/de/blog/was-ist-luftdruckverlust/" class="text-blue-700 hover:text-blue-800 underline">Was ist Luftdruckverlust?</a>-Pillar-Artikel.
</p>
HTML
);
