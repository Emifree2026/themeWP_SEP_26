<?php
/**
 * Body content for "How to Calculate Air Pressure Loss in a Duct".
 *
 * Worked example targeting the "how to calculate air pressure loss"
 * / "duct pressure drop calculation" query cluster. Mid-funnel —
 * user already knows the term and wants to see the numbers.
 *
 * Internal links back to the calculator + the pillar article.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	This article walks through a real <strong>air pressure loss calculation</strong> for an industrial oil-mist extraction run: 1,700 m&sup3;/h through 8 m of 200 mm galvanized duct, two 90&deg; elbows, one T-junction, and a step-down reducer to 160 mm. We use the Darcy&ndash;Weisbach + K-factor method described in the <a href="/blog/what-is-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">What Is Air Pressure Loss?</a> pillar article, then apply the 1.15 oil-mist correction and a 2&times; fan safety margin. Skip to the bottom for the result, or use our free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> to run your own numbers instantly.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 1 &mdash; Inputs</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<ul class="space-y-2 text-base text-zinc-800">
		<li><strong>Airflow:</strong> Q = 1,700 m&sup3;/h = 0.472 m&sup3;/s</li>
		<li><strong>Duct material:</strong> galvanized steel (roughness &epsilon; = 0.15 mm)</li>
		<li><strong>Application:</strong> oil mist (correction factor K<sub>app</sub> = 1.15)</li>
		<li><strong>Air properties:</strong> &rho; = 1.2 kg/m&sup3;, &mu; = 1.81&times;10&#8315;&#8308; Pa&middot;s (20&nbsp;&deg;C, sea level)</li>
	</ul>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 2 &mdash; Section A: 200 mm straight duct</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p>D = 0.200 m &middot; A = &pi;&middot;D&sup2;/4 = 0.0314 m&sup2;</p>
	<p>V = Q/A = 0.472 / 0.0314 = 15.0 m/s</p>
	<p>Re = &rho;&middot;V&middot;D/&mu; = 1.2 &middot; 15.0 &middot; 0.200 / 1.81&times;10&#8315;&#8308; = 199,000</p>
	<p>f (Swamee&ndash;Jain) = 0.0206</p>
	<p>L = 8 m &rArr; &Delta;P<sub>f</sub> = 0.0206 &middot; (8/0.2) &middot; 0.5 &middot; 1.2 &middot; 15.0&sup2; = <strong>111 Pa</strong></p>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 3 &mdash; Fittings on Section A</h2>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<table class="w-full text-left text-base text-zinc-800">
		<thead>
			<tr class="border-b border-slate-300">
				<th class="py-2 pr-4 font-semibold">Fitting</th>
				<th class="py-2 pr-4 font-semibold">K-factor</th>
				<th class="py-2 font-semibold">&Delta;P<sub>m</sub> = K&middot;&half;&middot;&rho;&middot;V&sup2;</th>
			</tr>
		</thead>
		<tbody>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">90&deg; elbow (die-stamped, r/D = 1.5)</td><td class="py-2 pr-4 font-mono">0.18</td><td class="py-2 font-mono">24.3 Pa</td></tr>
			<tr class="border-b border-slate-200"><td class="py-2 pr-4">90&deg; elbow (die-stamped, r/D = 1.5)</td><td class="py-2 pr-4 font-mono">0.18</td><td class="py-2 font-mono">24.3 Pa</td></tr>
			<tr><td class="py-2 pr-4">T-junction (through)</td><td class="py-2 pr-4 font-mono">1.20</td><td class="py-2 font-mono">162.0 Pa</td></tr>
		</tbody>
	</table>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Section A subtotal: 111 + 24.3 + 24.3 + 162.0 = <strong>321.6 Pa</strong>.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 4 &mdash; Section B: 160 mm after the reducer</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	The reducer carries K = 0.10. New V = 0.472 / (&pi;&middot;0.16&sup2;/4) = 23.4 m/s. We assume 2 m of straight 160 mm duct on the outlet side for a filter connection.
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p>Re = 1.2 &middot; 23.4 &middot; 0.160 / 1.81&times;10&#8315;&#8308; = 248,000</p>
	<p>f (Swamee&ndash;Jain) = 0.0196</p>
	<p>Friction: &Delta;P<sub>f</sub> = 0.0196 &middot; (2/0.16) &middot; 0.5 &middot; 1.2 &middot; 23.4&sup2; = <strong>40.2 Pa</strong></p>
	<p>Reducer K-loss: &Delta;P<sub>m</sub> = 0.10 &middot; 0.5 &middot; 1.2 &middot; 23.4&sup2; = <strong>32.9 Pa</strong></p>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 5 &mdash; Apply oil-mist correction</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Raw total: 321.6 + 40.2 + 32.9 = 394.7 Pa. Multiply by K<sub>app</sub> = 1.15 for oil mist (accounts for liquid-film drag on the duct wall): <strong>&Delta;P<sub>total</sub> = 453.9 Pa</strong>.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Step 6 &mdash; Fan recommendation</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Industry practice adds a 2&times; safety margin: fan static pressure rating = 2 &middot; 453.9 = <strong>~910 Pa</strong> at 1,700 m&sup3;/h. Add your filter cartridge pressure loss on top (typically 500&ndash;1,500 Pa for an oil-mist filter) to get the total fan rating. So a real selection here would be 1,500 Pa at 1,700 m&sup3;/h &mdash; a common size for a single CNC cell.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Want to plug in your own numbers? The free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> does all six steps automatically. For the underlying theory, see the <a href="/blog/what-is-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">What Is Air Pressure Loss?</a> pillar article.
</p>
HTML
);
