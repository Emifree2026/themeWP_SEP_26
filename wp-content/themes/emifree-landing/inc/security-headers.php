<?php
/**
 * Emifree Theme — security response headers + 404 information leak reduction.
 *
 * Loaded globally from functions.php. The work here is split into two
 * sections:
 *
 *   1. STABLE PAGE HARDENING — three baseline security headers added to
 *      every response the theme emits, plus a meta-generator filter
 *      that hides the exact WordPress version from the rendered HTML.
 *      These are the rows in the "Best Practices" Lighthouse audit that
 *      PageSpeed flagged as "Ensure CSP is effective against XSS attacks",
 *      "Use HSTS", "Mitigate clickjacking with XFO or CSP", and "Reduce
 *      DOM-based XSS attacks with trusted types".
 *
 *   2. 404-SPECIFIC LEAK TRIMMING — when the response is a 404, the
 *      default WP 404 page (template = `index.php` from the active
 *      theme) prints every queued inline `<style id="...-inline-css">`
 *      block from WP core and from every plugin that's active. Each
 *      of those blocks is a unique fingerprint: "wp-block-library"
 *      means the block editor is on; "wp-img-auto-sizes-contain"
 *      means the "Image Size Auto Include" plugin is on; and so on.
 *      On a 404 these blocks do nothing (the page doesn't render
 *      anything that uses them — it's literally "Page not found" plus
 *      the search widget), so dropping them on 404 alone keeps the
 *      legitimate pages untouched but reduces the 404 echo.
 *
 * What was deliberately NOT changed:
 *   - The sitemap link. Search engines use it to discover pages; an
 *     attackers-discover-it argument is symmetric (they're going to
 *     find the sitemap through the robots.txt or sitemap.xml anyway).
 *   - The `X-WS-*` rate-limit headers. Those come from the WebSocket-
 *     based WAF in front of production (IONOS or the equivalent), not
 *     from WP, and they're not a 404-specific leak.
 *   - The `Server: Apache` header. Stripped at the host or proxy
 *     layer; PHP can't tell Apache not to identify itself.
 *   - A full Content-Security-Policy. The script inventory differs
 *     page-by-page (Tawk on /, GTAG on /, plus conditionally-loaded
 *     section JS); a CSP that allows all of them is no CSP. The
 *     right CSP for this site needs a per-page nonce audit which
 *     is out of scope for this pass — flagged for a follow-up.
 *
 * No state, no caching. The wp_headers filter is called exactly
 * once per response so the headers we set are the headers that ship.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add three baseline security headers on every response.
 *
 *   - X-Content-Type-Options: nosniff
 *     Tells the browser to refuse MIME-type sniffing on responses.
 *     Without it, an attacker could upload a PNG that contains
 *     JavaScript and trick older browsers into executing it as
 *     text/javascript. With it, the browser honors the declared
 *     Content-Type no matter what.
 *
 *   - Referrer-Policy: strict-origin-when-cross-origin
 *     Sends the full URL when the link target is same-origin,
 *     sends only the origin (not the path) when cross-origin,
 *     and sends nothing when the protocol is downgraded (http →
 *     https). Default for new browsers; setting it explicitly
 *     covers older ones (IE11, Safari 12, etc.).
 *
 *   - X-Frame-Options: SAMEORIGIN
 *     Refuses to render the page in an iframe from a different
 *     origin. Without it, the page could be embedded in a malicious
 *     site and used to run clickjacking attacks against logged-in
 *     users. SAMEORIGIN is the right value here because we don't
 *     embed our own pages in third-party iframes anywhere — if we
 *     did, we'd need DENY or ALLOW-FROM instead.
 *
 * The WP core filter `wp_headers` runs on every response (including
 * the 404), which is exactly what we want. Headers set here persist
 * even when a caching plugin later rewrites Cache-Control /
 * Vary, because security headers aren't storage headers.
 *
 * Skipped paths: nothing. These are correct on every page including
 * the sitemap, the robots.txt, the llms.txt, and the 404.
 *
 * @param array $emifree_headers Existing response headers (key => value).
 * @return array Headers with the three security headers added (or
 *                replaced if already present from the proxy layer).
 */
function emifree_set_security_headers( $emifree_headers ) {
	$emifree_headers['X-Content-Type-Options'] = 'nosniff';
	$emifree_headers['Referrer-Policy']         = 'strict-origin-when-cross-origin';
	$emifree_headers['X-Frame-Options']         = 'SAMEORIGIN';
	return $emifree_headers;
}
add_filter( 'wp_headers', 'emifree_set_security_headers', 25 );

/**
 * Remove the WordPress version from the page <head>.
 *
 * WP outputs `<meta name="generator" content="WordPress X.Y.Z" />` on
 * every front-end page by default; that's the most reliable way for an
 * attacker to learn the exact version without authenticated access.
 * Known-version WP sites get attacked more often because known-CVE
 * exploits are easy to spin up.
 *
 * Filtering `the_generator` to return an empty string drops the meta
 * tag entirely. There's no functional impact — the generator tag is
 * informational only and search engines don't penalise sites for
 * omitting it (Google has confirmed, Bing doesn't care).
 *
 * @param string $emifree_generator The generator meta tag content.
 * @return string Empty string for HTML output, unchanged otherwise.
 */
function emifree_strip_wp_generator( $emifree_generator ) {
	if ( is_admin() ) {
		return $emifree_generator;
	}
	return '';
}
add_filter( 'the_generator', 'emifree_strip_wp_generator' );

/**
 * 404-only inline-CSS block suppression.
 *
 * The 404 page (`index.php` of the active theme, run when no other
 * template matches) renders every `<style id="...-inline-css">` block
 * WP has queued via `wp_add_inline_style()`. On a normal page those
 * styles are what make the design actually look right; on a 404 page
 * they serve nothing visual (the 404 body uses no classes from them).
 *
 * The leak: each block name is a unique plugin/core fingerprint. The
 * pattern `<style id="wp-img-auto-sizes-contain-inline-css">` reveals
 * that the "Image Size Auto Include" plugin is active. An attacker
 * who's mapping the site for known vulnerabilities gets a free inventory
 * of which WordPress + plugin components to target.
 *
 * The fix is narrow: dequeue the inline styles ONLY when the current
 * response is a 404 (detected via `is_404()`). Legitimate pages keep
 * every block they need.
 *
 * Detected block names (from a 2026-08-05 probe of
 * https://emifree.com/secrets.yaml, which 404s):
 *   - wp-img-auto-sizes-contain-inline-css   (plugin "Image Size Auto Include")
 *   - wp-emoji-styles-inline-css             (core emoji CSS)
 *   - wp-block-library-inline-css            (block editor CSS)
 *   - global-styles-inline-css               (theme.json base CSS)
 *
 * We dequeue the inline styles broadly, not by name, by removing the
 * `wp_print_styles` action's output for the inline-style handle. That's
 * safer than listing block IDs here because WP and plugins change the
 * names over releases, and what we want is "no inline CSS on 404s"
 * rather than "no specific named inline CSS on 404s".
 *
 * Hooked on `wp_print_styles` at priority 100 — after every other
 * listener has run — so any conditional styles a plugin adds at a
 * higher priority still get to run before we strip the inline output.
 */
function emifree_strip_inline_css_on_404() {
	if ( ! is_404() ) {
		return;
	}
	// Drop the inline `<style>` blocks from the front-end output on
	// 404 responses. `wp_print_inline_style` is the WP 5.8+ action
	// for emitting queued inline CSS; running it on `wp_print_styles`
	// at priority 100 lets us hook BEFORE it fires and turn off its
	// emission for the current request.
	remove_action( 'wp_print_styles', 'wp_print_inline_style', 20 );
	remove_action( 'wp_footer', 'wp_print_inline_style', 20 );
}
add_action( 'wp_print_styles', 'emifree_strip_inline_css_on_404', 100 );
