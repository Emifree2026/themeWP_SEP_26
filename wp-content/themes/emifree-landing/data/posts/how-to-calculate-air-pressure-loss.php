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
	Air pressure loss, also called pressure drop, is the reduction in static pressure that happens when air moves through ductwork, fittings, filters, and other restrictions. It affects airflow, fan sizing, and system performance, which is why many engineers use an <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> to estimate it quickly.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">What Is Air Pressure Loss?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Air pressure loss represents the energy lost by moving air as it overcomes resistance inside a system. As air flows through a duct network, friction against the duct walls and turbulence created by changes in direction or velocity consume static pressure.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Common causes of air pressure loss include:
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<ul class="space-y-2 text-base text-zinc-800">
		<li><strong>Surface Friction:</strong> Smooth vs. rough duct materials (e.g., galvanized steel vs. flexible ducting).</li>
		<li><strong>Duct Geometry:</strong> Narrower diameters increase air velocity and friction exponentially.</li>
		<li><strong>Fittings &amp; Changes in Direction:</strong> Elbows, T-junctions, reducers, and branches create local turbulence losses (<em>K</em>-factors).</li>
		<li><strong>System Components:</strong> Filters, dampers, and hoods introduce major pressure drops.</li>
	</ul>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">How to Calculate Air Pressure Loss</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	To calculate pressure drop accurately across a system, engineers use the <strong>Darcy&ndash;Weisbach equation</strong> combined with equivalent friction parameters (<em>K</em>-factors) for fittings:
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p class="mb-2"><strong>Friction (per straight section):</strong></p>
	<p class="mb-4">&Delta;P<sub>f</sub> = f &middot; (L / D) &middot; (&half; &rho; V&sup2;)</p>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">Where:</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<ul class="space-y-2 text-base text-zinc-800">
		<li><em>f</em> = friction factor (calculated via Swamee&ndash;Jain equation)</li>
		<li><em>L</em> = length of duct (m)</li>
		<li><em>D</em> = duct diameter (m)</li>
		<li><em>&rho;</em> = air density (kg/m&sup3;)</li>
		<li><em>V</em> = air velocity (m/s)</li>
	</ul>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">For fittings, minor loss is calculated using:</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p class="mb-2"><strong>Minor loss (per fitting):</strong></p>
	<p>&Delta;P<sub>m</sub> = K &middot; (&half; &rho; V&sup2;)</p>
</div>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Worked Example: Using the Free Air Pressure Loss Calculator</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Rather than manually computing complex fluid mechanics formulas, you can calculate the exact pressure drop for your duct run using our free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">Air Pressure Loss Calculator</a>. Follow these simple steps to calculate your system requirements:
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
	<ol class="space-y-3 list-decimal pl-6 text-base text-zinc-800">
		<li><strong>Enter the Airflow:</strong> Input your target airflow volume in m&sup3;/h (e.g., 1,700&nbsp;m&sup3;/h).</li>
		<li><strong>Select Duct Material:</strong> Choose from Galvanized Steel, Aluminum, or Black Steel to set the surface roughness factor.</li>
		<li><strong>Select Application:</strong> Pick Oil Mist, Dust, or HVAC. The calculator automatically applies the relevant application correction factor (<em>K</em><sub>app</sub>) to account for wall drag from heavy particles or aerosols.</li>
		<li><strong>Build Duct Sections &amp; Components:</strong>
			<ul class="list-disc pl-6 mt-2 space-y-1">
				<li>Add sections using different diameter ranges.</li>
				<li>Add common piping components, including straight duct runs (custom lengths), 90&deg; or 45&deg; elbows, T-junctions, Y-connectors, or reducers.</li>
				<li><em>Note on Reducers:</em> If you insert a reducer within a section, all subsequent components added to that section will automatically default to the exit diameter of the last reducer added.</li>
			</ul>
		</li>
		<li><strong>Calculate Results:</strong> Click <strong>Calculate</strong> to generate your total friction loss and total pressure drop in Pascals (Pa).</li>
	</ol>
</div>

<h3 class="text-xl font-bold text-zinc-900 mt-8 mb-4">Result &amp; Fan Selection Recommendation</h3>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Based on your inputs, the calculator displays the calculated static pressure drop (e.g., 453.9&nbsp;Pa for an oil-mist run) and automatically recommends a suitable fan. Factoring in safety margins and standard filter resistance (500&ndash;1,500&nbsp;Pa), the tool guides you to an ideal fan sizing rating&mdash;such as <strong>1,500&nbsp;Pa static pressure at 1,700&nbsp;m&sup3;/h</strong> for a single CNC cell extraction setup.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Frequently Asked Questions</h2>
<div class="space-y-6 mb-6">
	<div>
		<p class="text-lg font-semibold text-zinc-900 mb-2">What is the difference between static pressure loss and total pressure loss?</p>
		<p class="text-lg text-zinc-700 leading-relaxed">Static pressure loss measures the drop in force exerted against duct walls (overcoming resistance), while total pressure loss accounts for both static pressure loss and changes in dynamic (velocity) pressure within the system.</p>
	</div>
	<div>
		<p class="text-lg font-semibold text-zinc-900 mb-2">Which duct fittings cause the highest pressure loss?</p>
		<p class="text-lg text-zinc-700 leading-relaxed">T-junctions, sharp 90&deg; mitered elbows, and rapid step-down reducers create the highest dynamic turbulence and carry the largest <em>K</em>-factors.</p>
	</div>
	<div>
		<p class="text-lg font-semibold text-zinc-900 mb-2">When do I need to apply an application correction factor (<em>K</em><sub>app</sub>)?</p>
		<p class="text-lg text-zinc-700 leading-relaxed">Application factors should be applied whenever airstreams carry particulates, heavy dust, or liquid phase aerosols (such as oil mist, steam, or sticky fumes) that increase wall friction beyond clean air standards.</p>
	</div>
</div>

<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Want to plug in your own numbers? Use our free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> to run your own calculations instantly, or read our <a href="/blog/what-is-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">pillar guide on pressure loss theory</a>.
</p>
HTML
);
