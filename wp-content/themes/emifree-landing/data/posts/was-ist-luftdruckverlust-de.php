<?php
/**
 * Body content for "Was ist Luftdruckverlust?".
 *
 * DE Pillar-Artikel für den Suchbegriff-Cluster
 * „Luftdruckverlust-Rechner" / „Was ist Luftdruckverlust".
 * Spricht Nutzer an, die den Begriff gehört haben und eine
 * klare Definition suchen, bevor sie einen Rechner benutzen.
 *
 * Interne Links: Rechner + beide Schwester-Artikel.
 *
 * @see https://emifree.com/de/luftdruckverlust-rechner/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	<strong>Luftdruckverlust</strong> &mdash; auch <em>Druckabfall</em>, <em>statischer Druckverlust</em> oder <em>&Delta;P</em> genannt &mdash; ist die wichtigste Größe bei der Auslegung jedes Kanalsystems. Ob Sie einen Lüftungskanal für ein Büro, eine industrielle Ölnebel-Absaugleitung für eine CNC-Zelle oder ein Staubabsaug-Sammelrohr für eine Schreinerei dimensionieren: der Luftdruckverlust Ihres Kanalstrangs bestimmt den benötigten Ventilator.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Einfach ausgedrückt: Luftdruckverlust ist die Menge an statischem Druck, die verschwindet, während die Luft durch Ihre Kanäle strömt. Der Ventilator am Anfang muss stark genug drücken, um diesen Verlust zu überwinden und am Ende immer noch den Auslegungs-Luftstrom zu liefern. Ist der Kanal-Druckverlust zu hoch, schafft der Ventilator es nicht &mdash; die Folge sind ausgehungerte Werkzeuge, schwache Absaugung und überhitzte Motoren.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Wo entsteht Luftdruckverlust?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Luftdruckverlust hat zwei Ursachen, und jeder reale Kanalstrang hat beide:
</p>
<ol class="list-decimal pl-6 space-y-3 text-lg text-zinc-700 leading-relaxed mb-6">
	<li><strong>Reibungsverlust</strong> an geraden Kanalwänden. Die Luft schleift an der Kanal-Innenwand; rauere Materialien und längere Strecken erzeugen mehr Widerstand.</li>
	<li><strong>Einzelwiderstände</strong> an Bögen, Abzweigen, Übergängen, Filtern, Ventilen und jeder anderen Komponente, die Strömungsrichtung oder -querschnitt ändert. Diese sind oft sogar größer als der Reibungsverlust.</li>
</ol>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Die Formel</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Das Standardmodell in HVAC und industrieller Lüftung ist <strong>Darcy&ndash;Weisbach</strong> für die Reibung plus <strong>K-Faktor</strong>-Verluste für Formstücke:
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p class="mb-2"><strong>Reibung (pro gerader Abschnitt):</strong></p>
	<p class="mb-4">&Delta;P<sub>f</sub> = f &middot; (L / D) &middot; &half; &middot; &rho; &middot; V&sup2;</p>
	<p class="mb-2"><strong>Einzelwiderstand (pro Formstück):</strong></p>
	<p class="mb-4">&Delta;P<sub>m</sub> = K &middot; &half; &middot; &rho; &middot; V&sup2;</p>
	<p class="mb-2"><strong>Gesamt-Luftdruckverlust:</strong></p>
	<p>&Delta;P<sub>gesamt</sub> = ( &Sigma; &Delta;P<sub>f</sub> + &Sigma; &Delta;P<sub>m</sub> ) &times; K<sub>app</sub></p>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Wobei <em>&rho;</em> die Luftdichte (1,2 kg/m&sup3; unter Normbedingungen), <em>V</em> die Luftgeschwindigkeit im Kanal, <em>f</em> der Darcy-Reibungsfaktor (berechnet nach Swamee&ndash;Jain für turbulente Strömung) und <em>K</em> der Verlustbeiwert des Formstücks ist. <em>K<sub>app</sub></em> ist der anwendungsspezifische Korrekturfaktor: 1,0 für HVAC, 1,15 für Ölnebel, 1,25 für Staub.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Warum das wichtig ist</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Die Ventilatorauswahl hängt davon ab. Jeder Ventilator am Markt ist nach Luftstrom (m&sup3;/h) bei einem bestimmten Statikdruck (Pa) spezifiziert. Wenn Ihr Luftdruckverlust 800 Pa beträgt, brauchen Sie einen Ventilator, der Ihren Luftstrom bei <em>mindestens</em> 800 Pa liefert &mdash; und in der Praxis wird eine 2&times;-Sicherheitsmarge addiert, also 1.600 Pa als echtes Minimum.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Die Energiekosten hängen davon ab. Die Ventilator-Motorleistung ist proportional zu Luftstrom &times; Druck. Eine zu kleine Kanal-Dimensionierung (die die Geschwindigkeit und damit den geschwindigkeitsabhängigen Verlust erhöht) verschwendet Strom &mdash; in jeder Betriebsstunde.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Wie wird er berechnet?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Die Darcy&ndash;Weisbach + K-Faktor-Formel oben liefert die Lehrbuch-Antwort, aber sie manuell auf einen realen Kanalstrang anzuwenden (mit 10+ Abschnitten, jeder mit eigenem Durchmesser, Länge und Formstücken) ist mühselig. Unser kostenloser <a href="/de/luftdruckverlust-rechner/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust-Rechner</a> erledigt die vollständige Berechnung mit einem Klick &mdash; Luftstrom eingeben, Material und Anwendung wählen, Abschnitte hinzufügen, Ergebnis ablesen.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Ein praxisnahes Rechenbeispiel finden Sie in unserem Tutorial: <a href="/de/blog/luftdruckverlust-berechnen/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust im Kanal berechnen</a>. Und falls Sie sich jemals gefragt haben, ob &bdquo;Luftdruckverlust&ldquo; und &bdquo;Druckabfall&ldquo; dasselbe sind (sie sind es), erklärt der Begriffsartikel, warum beide Bezeichnungen in Lieferantenkatalogen auftauchen: <a href="/de/blog/luftdruckverlust-vs-druckabfall/" class="text-blue-700 hover:text-blue-800 underline">Luftdruckverlust vs. Druckabfall</a>.
</p>
HTML
);
