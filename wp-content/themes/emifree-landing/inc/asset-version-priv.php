<?php
/**
 * Emifree Theme, asset-version privacy + XML-RPC disable.
 *
 * Two narrow layer-defence measures, both enabled unconditionally
 * (no opt-out flag) because the leak they prevent is passive recon
 * (DevTools-network panel, plain GET to /xmlrpc.php):
 *
 *   1. ?ver= fingerprint scrubber. Filters the `?ver=...` query
 *      string WP appends to every enqueued style/script. The default
 *      value of that ver is the theme or plugin version, so the
 *      rendered HTML currently leaks the active WordPress + every
 *      active plugin version into a fully crawlable attribute.
 *      An attacker who sees something like
 *        ?wp-includes/css/dist/block-library/style.min.css?ver=6.6.1
 *      immediately knows which CVEs to look up.
 *
 *      We rewrite ver to a single privacy-preserving constant:
 *      EMIFREE_PUBLIC_ASSET_VER (defaults to '1'). Cache-busting
 *      still works the way WP intended (a deploy bumps the const,
 *      the URL changes, caches miss). The numeric theme/plugin
 *      version never enters DevTools or the page source.
 *
 *   2. XML-RPC hard disable. The xmlrpc.php endpoint is one of the
 *      highest-volume brute-force and DDoS vectors in the WP
 *      ecosystem. The site doesn't use it (Jetpack-style integrations
 *      aren't installed; the contact form goes through admin-ajax),
 *      so we kill it at the WP level with `xmlrpc_enabled`. The
 *      .htaccess `Require all denied` on xmlrpc.php is the matching
 *      server-level block; this filter handles the layer Apache
 *      might let through (LiteSpeed, misconfigured vhost, etc.).
 *
 * Layer rationale, neither file should split because both are
 * "make passive recon harder" controls with the same threat model
 * and the same rationale block.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EMIFREE_PUBLIC_ASSET_VER' ) ) {
	define( 'EMIFREE_PUBLIC_ASSET_VER', '1' );
}

/**
 * Replace `?ver=<theme-or-plugin-version>` with `?ver=1` on
 * enqueued asset URLs.
 *
 * Runs late (priority 9999) on both filters so plugins/themes
 * which compute their own version can't override us on the way out.
 * The two filters are independent in WP (style_loader_src and
 * script_loader_src), so both need the same treatment.
 *
 * Implementation note, regex choice: the replacement must preserve
 * the separator before the `ver=` token. An earlier variant used a
 * capturing group around the leading `?`/`&` and rewrote both
 * halves in one go, but a typo on that variant consumed the
 * separator without re-emitting it, producing URLs like
 *   `.../main.jsver=1`
 * (no `?`), which 404 against a real asset path. This version
 * uses a fixed-width lookbehind (`(?<=[?&])`) to find `ver=`
 * without consuming the preceding character, then replaces just
 * the `ver=...` portion:
 *
 *   before: `https://x/wp/main.js?ver=1.5.2&foo=bar`
 *   after : `https://x/wp/main.js?ver=1&foo=bar`  (good)
 *   before: `https://x/wp/main.js?other=x&ver=1.5.2`
 *   after : `https://x/wp/main.js?other=x&ver=1`  (good)
 *   before: `https://x/wp/main.js?ver=1.5.2`
 *   after : `https://x/wp/main.js?ver=1`         (good)
 *
 * What we deliberately DON'T do:
 *   - Strip `?ver=` entirely. WP's cache-busting semantics rely
 *     on the URL differing across releases. A constant `?ver=1`
 *     gives us the same deploy-time-bump pattern with one less
 *     surface for "site not updating after deploy" regressions.
 *   - Touch external CDN URLs. The filter receives whatever URL
 *     WP generated; we run remove_query_arg('ver')-style logic
 *     generically. CDNs that ship assets without `?ver=` aren't
 *     affected (the conditional skips them).
 *
 * @param string $src Asset URL emitted by wp_enqueue_*().
 * @return string URL with the ver query arg rewritten.
 */
function emifree_strip_asset_vers( $src ) {
	if ( '' === $src ) {
		return $src;
	}
	if ( false === strpos( $src, 'ver=' ) ) {
		return $src;
	}
	// (?<=[?&]) is a fixed-width 1-char lookbehind -- supported on
	// every PHP version this theme targets. Without consuming the
	// preceding `?` or `&`, the replacement only rewrites the
	// `ver=...` token, never the separator that precedes it.
	return preg_replace( '/(?<=[?&])ver=[^&]*/', 'ver=' . EMIFREE_PUBLIC_ASSET_VER, $src );
}
add_filter( 'style_loader_src', 'emifree_strip_asset_vers', 9999 );
add_filter( 'script_loader_src', 'emifree_strip_asset_vers', 9999 );

/**
 * Hard-disable the XML-RPC endpoint.
 *
 * The historical `xmlrpc_enabled` filter on its own does NOT block
 * XML-RPC in modern WP -- since 5.7.3 it only governs whether
 * auth-required methods (wp.* publishing, etc.) are reachable;
 * anonymous methods like `system.listMethods`, `pingback.ping`,
 * and `demo.addTwoNumbers` keep responding regardless. That makes
 * `add_filter( 'xmlrpc_enabled', '__return_false' )` not enough:
 * a brute-force scanner hitting `system.listMethods` or
 * `demo.addTwoNumbers` would still get the standard XML fault
 * response, signalling "server is here".
 *
 * The XML-RPC server builds its method table on each request from
 * a single filter, `xmlrpc_methods`, applied at the end of
 * WP_XMLRPC_Server::__construct(). Returning an empty array wipes
 * the table: every method call subsequently ends with
 * "requested method does not exist", and an attacker who lists
 * methods gets back only `system.multicall` (the multicall wrapper
 * itself is hardcoded in IXR_Server and survives any filter).
 *
 * The `.htaccess` `Require all denied` on xmlrpc.php is the
 * matching server-level block; this filter handles the layer
 * Apache might let through (LiteSpeed, misconfigured vhost, the
 * WAF rewriting rule order, etc.). The two together give
 * belt-and-braces coverage across Apache/LiteSpeed/cloud-fronted
 * hosts.
 *
 * What the site loses: nothing the site actively uses. The
 * contact form posts to admin-ajax.php, the blog CPT publishes
 * via cron, the SMTP helper sends via wp_mail(); none of these
 * touch xmlrpc.php. If a future feature (Jetpack, the WordPress
 * mobile app, pingbacks from other WP blogs) needs it back, the
 * one filter below is the single opt-out point.
 */
add_filter( 'xmlrpc_methods', '__return_empty_array' );
