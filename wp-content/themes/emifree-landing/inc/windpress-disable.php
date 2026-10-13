<?php
/**
 * Emifree Theme, disable WindPress runtime play observer.
 *
 * The theme ships its own Tailwind build (npm run build writes
 * assets/css/main.css, committed to the repo). The WindPress plugin
 * also runs a Tailwind v4 compiler on every page load, scanning the
 * DOM and injecting compiled CSS into
 * <style id="windpress-cached-inline-css">. Because WindPress uses
 * Tailwind v4 syntax (CSS variables, oklch() colors, a different set
 * of --tw-gradient-* variables) and the theme's static main.css is
 * compiled with Tailwind v3, the runtime CSS lands on top of the
 * static one ~1s after first paint and overrides the visual result
 * with v4-equivalent class definitions. Symptom: the page renders
 * with the freshly built static CSS, then visibly reverts to an
 * older look once the observer finishes its async compile.
 *
 * The play observer checks window.__windpress__disable_playObserver
 * at module load and bails out if the flag is true. Setting the flag
 * here -- in wp_head at priority 1, before the deferred module
 * <script type="module" id="windpress:observer-js"> is evaluated --
 * disables the runtime injection without deactivating the WindPress
 * plugin. The WindPress admin, the Wizard, and the in-dashboard
 * code editor keep working; only the front-end runtime observer is
 * turned off.
 *
 * The <style id="windpress-cached-inline-css"> that WordPress
 * renders server-side is left in place: it carries only the Tailwind
 * v4 theme variables (--font-*, --color-*, --blur-*, etc.) and a
 * handful of @keyframes, with no utility-class rules, so it does not
 * conflict with the static main.css.
 *
 * Removal: delete this file and the require_once line in
 * functions.php. The theme's static build is self-sufficient and
 * does not depend on WindPress for any styling.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_head',
	static function () {
		echo '<script>window.__windpress__disable_playObserver = true;</script>' . "\n";
	},
	1
);
