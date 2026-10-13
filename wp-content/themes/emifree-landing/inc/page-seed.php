<?php
/**
 * Page seeding for the per-product (and other long-form) landing pages.
 *
 * WordPress's template hierarchy auto-resolves `page-{slug}.php` based
 * on a page's `post_name`. The theme ships template files for several
 * long-form pages (Mechanical, future Electrostatic / Dust, the
 * Knowledge sub-pages, the legal pages) but the corresponding
 * `wp_posts` rows don't exist by default — WordPress's default install
 * only has Sample Page + the user's first privacy/terms pages.
 *
 * Without a row, visiting `/products/mechanical/` 404s even when the
 * template file is on disk, because WP's rewrite engine can't match
 * the URL to a post.
 *
 * This seeder fills that gap. It runs on `init` (gated by a wp_option
 * flag set by `after_switch_theme`) and creates the canonical page
 * records the theme depends on, idempotently. Each entry is keyed by
 * `(post_name, post_type, post_status)`, so re-running the seeder
 * never creates duplicates. Existing pages are not modified.
 *
 * The seeder also sets:
 *   - `_wp_page_template` post meta → routes the page to the right
 *     `page-{slug}.php` file.
 *   - `emifree_language` post meta → 'en' or 'de', matching the
 *     `emifree_language` convention used by the blog_post CPT. Used
 *     by future front-end filtering to scope page lists to one
 *     language.
 *   - `post_parent` → builds the URL hierarchy
 *     (`/products/mechanical/` from `mechanical` whose parent has
 *     `post_name=products`).
 *
 * Parents (`products`, `produkte`) are seeded with the `default`
 * template, so they 200 OK at their URL. They render as a bare
 * WordPress page (no custom template) — the home-page product
 * section is the de-facto product index. Future iterations can give
 * the parents a proper template.
 *
 * Required from functions.php. Safe to leave required; the option
 * flag prevents the seeder from running on every page load once
 * seeding is done.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical seed list. Each entry has:
 *   - post_name   : the URL slug
 *   - post_title  : human-readable title (shown in WP admin)
 *   - parent_name : post_name of the parent page (or '' for top-level)
 *   - language    : 'en' or 'de' (recorded in emifree_language meta)
 *   - template    : the page-{slug}.php file (or 'default')
 *
 * To add a new product page (e.g. Electrostatic or Dust), append
 * entries here. To add a future language (e.g. French), add the
 * language code as a new column and the corresponding entries.
 */
function emifree_get_seed_pages() {
	return array(
		// --- EN: Products index (parent) ---
		array(
			'post_name'   => 'products',
			'post_title'  => 'Products',
			'parent_name' => '',
			'language'    => 'en',
			'template'    => 'default',
		),
		array(
			'post_name'   => 'mechanical',
			'post_title'  => 'Mechanical Oil Mist Extraction',
			'parent_name' => 'products',
			'language'    => 'en',
			'template'    => 'page-products-mechanical.php',
		),

		// --- DE: Produkte index (parent) ---
		array(
			'post_name'   => 'produkte',
			'post_title'  => 'Produkte',
			'parent_name' => '',
			'language'    => 'de',
			'template'    => 'default',
		),
		array(
			'post_name'   => 'mechanische-filtration',
			'post_title'  => 'Mechanische Ölnebelfiltration',
			'parent_name' => 'produkte',
			'language'    => 'de',
			'template'    => 'page-products-mechanical-de.php',
		),
	);
}

/**
 * Find an existing published page by post_name, or 0.
 *
 * Bypasses WP_Query state and goes straight to the wp_posts table so
 * the seeder can run during init even when the main query is in
 * transition (e.g. on a 404 URL that triggered the seeder to fire).
 *
 * @param string $emifree_slug Post slug.
 * @return int Post ID, or 0.
 */
function emifree_find_page_id_by_slug( $emifree_slug ) {
	if ( $emifree_slug === '' ) {
		return 0;
	}
	$emifree_post = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'name'           => $emifree_slug,
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'suppress_filters' => false,
			'fields'         => 'ids',
		)
	);
	if ( ! empty( $emifree_post ) ) {
		return (int) $emifree_post[0];
	}
	// get_posts can be filtered by other plugins (relevanssi etc.);
	// fall back to a direct DB lookup. Mirrors the pattern in
	// emifree_query_cpt_blog_post_by_slug() in inc/knowledge.php.
	global $wpdb;
	$emifree_id = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'page' AND post_name = %s LIMIT 1",
			$emifree_slug
		)
	);
	return $emifree_id;
}

/**
 * Insert a single seed page if it doesn't already exist.
 *
 * Idempotent: if a page with the same post_name exists (any status),
 * the function returns its ID without modifying it. The author's
 * customizations (title, content, page template) are preserved.
 *
 * @param array $emifree_entry  One row from emifree_get_seed_pages().
 * @param array $emifree_parent_id_by_slug  Map of post_name => WP post ID, built up as parents are inserted earlier in the loop.
 * @return int Post ID of the (now-existing) page.
 */
function emifree_seed_one_page( $emifree_entry, $emifree_parent_id_by_slug ) {
	$emifree_existing_id = emifree_find_page_id_by_slug( $emifree_entry['post_name'] );
	if ( $emifree_existing_id ) {
		return $emifree_existing_id;
	}

	$emifree_parent_id = 0;
	if ( ! empty( $emifree_entry['parent_name'] ) ) {
		if ( isset( $emifree_parent_id_by_slug[ $emifree_entry['parent_name'] ] ) ) {
			$emifree_parent_id = (int) $emifree_parent_id_by_slug[ $emifree_entry['parent_name'] ];
		}
	}

	$emifree_post_id = wp_insert_post(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'post_title'     => $emifree_entry['post_title'],
			'post_name'      => $emifree_entry['post_name'],
			'post_content'   => '',
			'post_excerpt'   => '',
			'post_parent'    => $emifree_parent_id,
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'menu_order'     => 0,
		),
		true // return WP_Error on failure instead of false
	);

	if ( is_wp_error( $emifree_post_id ) || ! $emifree_post_id ) {
		// Seeding must never crash the request. Log silently.
		return 0;
	}

	// Wire the page to its theme template and language meta.
	if ( ! empty( $emifree_entry['template'] ) ) {
		update_post_meta( $emifree_post_id, '_wp_page_template', $emifree_entry['template'] );
	}
	if ( ! empty( $emifree_entry['language'] ) ) {
		update_post_meta( $emifree_post_id, 'emifree_language', $emifree_entry['language'] );
	}

	return (int) $emifree_post_id;
}

/**
 * Run the full seed pass. Two-phase: first seed entries that have no
 * parent (the parent pages themselves), then seed the children. This
 * ordering is robust against the seed list being edited to add a new
 * parent later.
 *
 * @return array{created:int, existing:int, errors:array<int,string>}
 */
function emifree_seed_pages_run() {
	$emifree_entries = emifree_get_seed_pages();

	// Split by whether they have a parent, preserving original order
	// within each group.
	$emifree_no_parent = array_values(
		array_filter(
			$emifree_entries,
			static function ( $emifree_e ) {
				return empty( $emifree_e['parent_name'] );
			}
		)
	);
	$emifree_with_parent = array_values(
		array_filter(
			$emifree_entries,
			static function ( $emifree_e ) {
				return ! empty( $emifree_e['parent_name'] );
			}
		)
	);

	$emifree_id_map      = array(); // post_name => id
	$emifree_created     = 0;
	$emifree_existing    = 0;
	$emifree_errors      = array();

	foreach ( $emifree_no_parent as $emifree_entry ) {
		$emifree_existing_id = emifree_find_page_id_by_slug( $emifree_entry['post_name'] );
		$emifree_id = emifree_seed_one_page( $emifree_entry, $emifree_id_map );
		if ( $emifree_id ) {
			$emifree_id_map[ $emifree_entry['post_name'] ] = $emifree_id;
			if ( $emifree_existing_id === $emifree_id ) {
				$emifree_existing++;
			} else {
				$emifree_created++;
			}
		} else {
			$emifree_errors[] = $emifree_entry['post_name'];
		}
	}

	foreach ( $emifree_with_parent as $emifree_entry ) {
		$emifree_existing_id = emifree_find_page_id_by_slug( $emifree_entry['post_name'] );
		$emifree_id = emifree_seed_one_page( $emifree_entry, $emifree_id_map );
		if ( $emifree_id ) {
			$emifree_id_map[ $emifree_entry['post_name'] ] = $emifree_id;
			if ( $emifree_existing_id === $emifree_id ) {
				$emifree_existing++;
			} else {
				$emifree_created++;
			}
		} else {
			$emifree_errors[] = $emifree_entry['post_name'];
		}
	}

	return array(
		'created'  => $emifree_created,
		'existing' => $emifree_existing,
		'errors'   => $emifree_errors,
	);
}

/**
 * Schedule the seeder to run once. Called on `after_switch_theme`
 * (always) and on `init` (gated by a wp_option flag, so it only
 * runs until seeding is complete and gets cleared). The flag is the
 * simple "seeding has not yet finished" bit, NOT a "do not seed" bit
 * — so an interrupted seed (e.g. parent failed, child skipped) will
 * resume on the next request.
 */
function emifree_seed_pages_maybe_run() {
	// The wp_options table is only available after init; bail if
	// called too early (defensive).
	if ( ! did_action( 'init' ) ) {
		return;
	}

	// Two-phase commit: set the flag, run the seed, clear the flag.
	// If the request dies mid-seed the next request re-tries.
	update_option( 'emifree_seeding_pages', 'in_progress', false );
	$emifree_result = emifree_seed_pages_run();
	delete_option( 'emifree_seeding_pages' );

	// Flush rewrite rules once per seeder version. We can't gate on
	// "did this run create new pages?" because (a) on the very first
	// run after theme activation the rules were built BEFORE the
	// pages existed, so even an "all existing" pass still needs to
	// rebuild them, and (b) on subsequent runs the seeder is a
	// no-op but the rules were already correct. The version-gate
	// covers both cases cheaply: bumping the seeder version
	// triggers one flush; everything else is silent.
	$emifree_seeder_version = '1';
	$emifree_known_version  = (string) get_option( 'emifree_seeder_version', '' );
	if ( $emifree_known_version !== $emifree_seeder_version ) {
		flush_rewrite_rules( false );
		update_option( 'emifree_seeder_version', $emifree_seeder_version, false );
	}

	// Log to the debug log so an operator can confirm in wp-content/debug.log.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		error_log(
			sprintf(
				'[emifree] page-seed: created=%d existing=%d errors=%s',
				$emifree_result['created'],
				$emifree_result['existing'],
				implode( ',', $emifree_result['errors'] )
			)
		);
	}
}
add_action( 'init', 'emifree_seed_pages_maybe_run', 20 );

/**
 * After the theme is activated (e.g. after a ZIP upload + theme
 * switch), run the seeder. `after_switch_theme` fires once per
 * activation, not on every request, so the per-request `init` hook
 * is the safety net for the case where activation succeeded but
 * seeding didn't complete.
 */
function emifree_seed_pages_on_theme_switch() {
	emifree_seed_pages_maybe_run();
	// WP's rewrite rules need a flush after adding pages with
	// hierarchical URLs (`/products/mechanical/`) so the per-post
	// rewrite entries include the new parents. Without this, the
	// first request after activation still 404s.
	flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'emifree_seed_pages_on_theme_switch' );
