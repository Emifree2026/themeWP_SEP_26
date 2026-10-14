<?php
/**
 * Virtual routes for the per-product long-form landing pages.
 *
 * The home-page product cards link to prefixed URLs:
 *   /en/products/mechanical/   (EN)
 *   /de/produkte/mechanische-filtration/   (DE)
 *
 * The corresponding `wp_posts` rows seeded by `inc/page-seed.php` resolve
 * to the bare URLs `/products/mechanical/` and
 * `/produkte/mechanische-filtration/`, not the prefixed ones. Without
 * additional rewrite rules, `redirect_canonical()` and the legacy
 * redirect map 301 the prefixed URL to the bare one — which the DE
 * homepage then displays to a German user, losing the language
 * context. The fix is to register virtual routes for the prefixed
 * URLs, mirroring the pattern used for the Knowledge sub-pages
 * (`/en/knowledge/about/`, `/de/wissen/ueber-uns/`, etc.).
 *
 * Each entry below maps a URL pattern to a query var pair
 * (`emifree_product` + `emifree_product_slug` + `emifree_product_lang`).
 * The dispatcher at the bottom of the file maps the query vars to
 * the right shim template, falling through to WP's 404 if the slug
 * is unknown.
 *
 * Rewrite rules are emitted at `top` priority, before the broad
 * `(?:.?.+?)(?:/([0-9]+))?/?$` WP permalink catch-all, so the
 * virtual route always wins over the parent/child page resolution.
 *
 * Required from functions.php after `inc/page-seed.php`.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical list of virtual product routes. Each entry has:
 *   - pattern      : the URL pattern (without the leading slash)
 *   - slug         : the WP post_name (used by the dispatcher to
 *                    find the right template pair)
 *   - language     : 'en' or 'de'
 *   - templates    : [en_template, de_template] - the shim file
 *                    that gets included by the dispatcher
 *
 * Adding Electrostatic or Dust is a 2-line change: append a new
 * entry here for each (EN+DE) URL, no need to touch the rewrite
 * rule or dispatcher code below.
 */
function emifree_get_product_virtual_routes() {
	return array(
		// Mechanical — ECO AIR Cleaner line.
		array(
			'pattern'   => '^en/products/mechanical/?$',
			'slug'      => 'mechanical',
			'language'  => 'en',
			'templates' => array( 'page-products-mechanical.php', 'page-products-mechanical-de.php' ),
		),
		array(
			'pattern'   => '^de/produkte/mechanische-filtration/?$',
			'slug'      => 'mechanische-filtration',
			'language'  => 'de',
			'templates' => array( 'page-products-mechanical.php', 'page-products-mechanical-de.php' ),
		),
		// Electrostatic — EARIA 1000 m³/h line.
		array(
			'pattern'   => '^en/products/electrostatic/?$',
			'slug'      => 'electrostatic',
			'language'  => 'en',
			'templates' => array( 'page-products-electrostatic.php', 'page-products-electrostatic-de.php' ),
		),
		array(
			'pattern'   => '^de/produkte/elektrostatische-filtration/?$',
			'slug'      => 'elektrostatische-filtration',
			'language'  => 'de',
			'templates' => array( 'page-products-electrostatic.php', 'page-products-electrostatic-de.php' ),
		),
	);
}

/**
 * Register the per-product virtual routes.
 *
 * Called on `init`. The actual `add_rewrite_rule()` calls only fire
 * when WP rebuilds its rules (which happens automatically after
 * `flush_rewrite_rules()` is called). The seeder in
 * `inc/page-seed.php` triggers a flush whenever the seeder version
 * changes; bumping `EMIFREE_PRODUCT_ROUTES_VERSION` below forces a
 * flush on the next request so new entries land in `rewrite_rules`
 * without manual intervention.
 */
function emifree_register_product_virtual_routes() {
	$emifree_version = (string) get_option( 'emifree_product_routes_version', '' );
	if ( $emifree_version !== EMIFREE_PRODUCT_ROUTES_VERSION ) {
		// Version changed: emit a flush on the same request so the
		// new patterns land in `rewrite_rules` immediately, and stamp
		// the new version so we don't flush again. The init hook fires
		// before any URL is served, so a flush here is safe.
		update_option( 'emifree_product_routes_version', EMIFREE_PRODUCT_ROUTES_VERSION, false );
		// Defer the flush to a point where WP's rewrite class is fully
		// initialized. flush_rewrite_rules() called directly from init
		// works, but deferring via the same hook at a later priority
		// is safer (avoids races with other plugins also calling it
		// during init).
		add_action( 'init', 'emifree_flush_rewrite_rules_for_product_routes', 99 );
	}

	foreach ( emifree_get_product_virtual_routes() as $emifree_entry ) {
		add_rewrite_rule(
			$emifree_entry['pattern'],
			'index.php?emifree_product=post'
				. '&emifree_product_slug=' . rawurlencode( $emifree_entry['slug'] )
				. '&emifree_product_lang=' . rawurlencode( $emifree_entry['language'] ),
			'top'
		);
	}
}
add_action( 'init', 'emifree_register_product_virtual_routes' );

function emifree_flush_rewrite_rules_for_product_routes() {
	flush_rewrite_rules( false );
}

function emifree_register_product_query_vars( $emifree_vars ) {
	$emifree_vars[] = 'emifree_product';
	$emifree_vars[] = 'emifree_product_slug';
	$emifree_vars[] = 'emifree_product_lang';
	return $emifree_vars;
}
add_filter( 'query_vars', 'emifree_register_product_query_vars' );

/**
 * Dispatch the matched product route to the right shim template.
 *
 * Mirrors `emifree_route_knowledge_template()` for the knowledge
 * subsection routes. The rewrite rules above already gate by slug,
 * so an unknown slug only reaches this dispatcher via direct query
 * var manipulation; the whitelist here provides a second layer of
 * 404 defense with friendlier "Page not found" semantics.
 */
function emifree_route_product_template() {
	$emifree_mode = get_query_var( 'emifree_product' );
	if ( ! $emifree_mode ) {
		return;
	}
	if ( 'post' !== $emifree_mode ) {
		return;
	}

	$emifree_slug = (string) get_query_var( 'emifree_product_slug' );
	$emifree_is_de = ( 'de' === get_query_var( 'emifree_product_lang' ) );

	$emifree_template_name = null;
	foreach ( emifree_get_product_virtual_routes() as $emifree_entry ) {
		if ( $emifree_entry['slug'] === $emifree_slug && $emifree_entry['language'] === ( $emifree_is_de ? 'de' : 'en' ) ) {
			$emifree_template_name = $emifree_is_de ? $emifree_entry['templates'][1] : $emifree_entry['templates'][0];
			break;
		}
	}
	if ( null === $emifree_template_name ) {
		// Slug didn't match a registered route. Fall through to WP's
		// 404 so unknown URLs return the standard not-found response
		// instead of a blank page.
		return;
	}

	add_filter(
		'template_include',
		static function ( $emifree_template ) use ( $emifree_template_name ) {
			$emifree_target = locate_template( $emifree_template_name );
			return $emifree_target ? $emifree_target : $emifree_template;
		}
	);
}
add_action( 'template_redirect', 'emifree_route_product_template' );
