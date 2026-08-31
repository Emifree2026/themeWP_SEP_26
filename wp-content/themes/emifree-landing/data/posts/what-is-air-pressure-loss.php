<?php
/**
 * Body content for "What Is Air Pressure Loss?".
 *
 * SEO pillar article for the "air pressure loss calculator" /
 * "what is air pressure loss" query cluster. Targets users who
 * are early in the funnel — they have heard the term and want a
 * plain-English definition before they touch a calculator.
 *
 * Internal links: calculator + both sibling posts. The calculator
 * link uses the new canonical /air-pressure-loss-calculator/ slug.
 *
 * @see https://emifree.com/air-pressure-loss-calculator/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'body_html' => <<<HTML
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	<strong>Air pressure loss</strong> &mdash; also called <em>pressure drop</em>, <em>static pressure loss</em>, or <em>&Delta;P</em> &mdash; is the single most important quantity when designing any duct system. Whether you are sizing a ventilation duct for an office, an industrial oil-mist extraction line for a CNC cell, or a dust-collection manifold for a woodworking shop, the air pressure loss of your duct run determines the fan you need.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	In simple terms: air pressure loss is the amount of static pressure that disappears as air moves through your ductwork. The fan at one end has to push hard enough to overcome that loss and still deliver the design airflow at the far end. If the duct pressure loss is too high, the fan cannot keep up &mdash; you get starved tools, weak extraction, and overheated motors.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Where does air pressure loss come from?</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Air pressure loss has two sources, and every real duct run has both:
</p>
<ol class="list-decimal pl-6 space-y-3 text-lg text-zinc-700 leading-relaxed mb-6">
	<li><strong>Friction loss</strong> along straight duct walls. Air drags against the inside of the duct; rougher materials and longer runs create more drag.</li>
	<li><strong>Minor (fitting) losses</strong> at elbows, branches, transitions, filters, valves, and any other component that changes the flow direction or area. These are often larger than the friction loss.</li>
</ol>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">The formula</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	The standard model in HVAC and industrial ventilation is <strong>Darcy&ndash;Weisbach</strong> for friction plus <strong>K-factor</strong> losses for fittings:
</p>
<div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6 font-mono text-base text-zinc-800">
	<p class="mb-2"><strong>Friction (per straight section):</strong></p>
	<p class="mb-4">&Delta;P<sub>f</sub> = f &middot; (L / D) &middot; ½ &middot; &rho; &middot; V&sup2;</p>
	<p class="mb-2"><strong>Minor loss (per fitting):</strong></p>
	<p class="mb-4">&Delta;P<sub>m</sub> = K &middot; ½ &middot; &rho; &middot; V&sup2;</p>
	<p class="mb-2"><strong>Total air pressure loss:</strong></p>
	<p>&Delta;P<sub>total</sub> = ( &Sigma; &Delta;P<sub>f</sub> + &Sigma; &Delta;P<sub>m</sub> ) &times; K<sub>app</sub></p>
</div>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Where <em>&rho;</em> is air density (1.2 kg/m&sup3; at standard conditions), <em>V</em> is air velocity in the duct, <em>f</em> is the Darcy friction factor (calculated from the Swamee&ndash;Jain equation for turbulent flow), and <em>K</em> is the loss coefficient for each fitting. <em>K<sub>app</sub></em> is an application-specific correction: 1.0 for HVAC, 1.15 for oil mist, 1.25 for dust.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">Why it matters</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Fan selection depends on it. Every fan on the market is rated by airflow (m&sup3;/h or CFM) at a given static pressure (Pa or in.wg). If your duct air pressure loss is 800 Pa, you need a fan that delivers your airflow at <em>at least</em> 800 Pa &mdash; and industry practice adds a 2&times; safety margin, so 1,600 Pa is the real minimum.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	Energy costs depend on it. The fan motor power is proportional to airflow &times; pressure. Undersizing the duct (which raises velocity and therefore velocity-squared loss) wastes electricity every hour the system runs.
</p>

<h2 class="text-2xl font-bold text-zinc-900 mt-10 mb-4">How to calculate it</h2>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	The Darcy&ndash;Weisbach + K-factor formula above gives the textbook answer, but applying it manually to a real duct run (with 10+ sections, each with its own diameter, length, and fittings) is tedious. Our free <a href="/air-pressure-loss-calculator/" class="text-blue-700 hover:text-blue-800 underline">air pressure loss calculator</a> does the full calculation in a single click &mdash; enter airflow, pick your duct material and application, add the sections, and read the result.
</p>
<p class="text-lg text-zinc-700 leading-relaxed mb-6">
	For a hands-on walkthrough, see our worked example: <a href="/blog/how-to-calculate-air-pressure-loss/" class="text-blue-700 hover:text-blue-800 underline">How to Calculate Air Pressure Loss in a Duct</a>. And if you have ever wondered whether &ldquo;air pressure loss&rdquo; and &ldquo;pressure drop&rdquo; are the same thing (they are), the terminology article explains why both terms appear in supplier catalogues: <a href="/blog/air-pressure-loss-vs-pressure-drop/" class="text-blue-700 hover:text-blue-800 underline">Air Pressure Loss vs. Pressure Drop</a>.
</p>
HTML
);
