<?php
/**
 * Body content for "Air Pressure Loss vs. Pressure Drop".
 *
 * Terminology / disambiguation article for users searching either
 * term. Targets the query cluster "air pressure loss", "air
 * pressure drop", "static pressure loss" — clarifies that all
 * three terms describe the same quantity.
 *
 * Internal links to calculator + both sibling posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Short answer: <strong>air pressure loss</strong> and <strong>air pressure drop</strong> describe the same physical quantity &mdash; a reduction in static pressure, expressed in pascals (Pa) or inches of water column (in.wg). If you cross-reference a German VDI 3802 catalogue against an ASHRAE Fundamentals handbook and end up confused, the issue is almost always terminology, not physics.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Where do the two terms come from?</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<table class="w-full text-left text-base text-zinc-800">
		<thead>
			<tr class="border-b border-slate-300">
				<th class="py-2 pr-4 font-semibold">Term</th>
				<th class="py-2 pr-4 font-semibold">Tradition</th>
				<th class="py-2 font-semibold">Where you see it</th>
			</tr>
		</thead>
		<tbody>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">Pressure drop</td><td class="py-2 pr-4">English / ASHRAE</td><td class="py-2">ASHRAE Fundamentals, US supplier catalogues, OEM fan curves</td></tr>
			<tr><td class="py-2 pr-4">Pressure loss</td><td class="py-2 pr-4">English (installer / European industrial)</td><td class="py-2">HVAC installer docs, ductwork supplier specs, European industrial catalogues</td></tr>
		</tbody>
	</table>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Both terms refer to the same thing: <em>&Delta;P</em> &mdash; the pressure difference between two points in a duct run. The symbol, the units, and the underlying equation (Darcy&ndash;Weisbach + K-factor) are identical.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">What about &ldquo;static pressure loss&rdquo;?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	<em>Static pressure loss</em> is the same quantity again, with one clarifying word. In a flowing duct, total pressure is the sum of static pressure (the potential to push air) and velocity pressure (½&middot;&rho;&middot;V&sup2;, the kinetic energy of the moving air). Pressure drop is the loss of <em>static</em> pressure, because the velocity stays roughly constant through a uniform duct run &mdash; so the more precise term is &ldquo;static pressure loss,&rdquo; but &ldquo;pressure drop&rdquo; and &ldquo;pressure loss&rdquo; are used interchangeably in almost every catalogue you will read.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Does the calculator care which term I use?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	No. The free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> uses the same Darcy&ndash;Weisbach + K-factor model whether you call the result pressure loss, pressure drop, or static pressure loss. What it does care about: airflow (m&sup3;/h), duct diameter (mm), straight length (m), fitting types, material (galvanized, aluminum, black steel), and application (HVAC, oil mist, dust). Enter those and the result is your static pressure loss in Pa.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Common synonyms you will see</h2>
<ul class="list-disc pl-6 space-y-2 text-lg text-zinc-700 leading-relaxed mb-6">
	<li><strong>Pressure drop</strong> (ASHRAE, US English)</li>
	<li><strong>Pressure loss</strong> (installer / European English)</li>
	<li><strong>Static pressure loss</strong> (precise form)</li>
	<li><strong>&Delta;P</strong> (engineering shorthand)</li>
	<li><strong>Total pressure loss</strong> (full duct run, fittings included)</li>
	<li><strong>Friction loss</strong> (the friction-only component, excluding fittings)</li>
</ul>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Want to see the full calculation? Read the <a href="/blog/what-is-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">What Is Air Pressure Loss?</a> pillar article for the formula breakdown, or the <a href="/blog/how-to-calculate-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">How to Calculate Air Pressure Loss</a> worked example for a step-by-step numerical walkthrough.
</p>
HTML
);
