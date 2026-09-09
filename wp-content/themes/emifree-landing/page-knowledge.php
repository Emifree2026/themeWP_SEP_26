<?php
/**
 * Page template stub: /knowledge/
 *
 * Earlier this rendered the standalone Knowledge hub index, but the
 * landing page now keeps a single hub — the Resources & Knowledge
 * section on the homepage (`#knowledge`). Any bookmark, share, or
 * legacy link to /en/knowledge/ therefore 301s to the homepage anchor
 * so visitors land on the same Resources & Knowledge section they
 * would have reached by clicking the Knowledge nav item from any
 * other page.
 *
 * The /en/knowledge/<sub>/ URLs (insights, about, downloads, tools,
 * ductulator, etc.) are handled by their own page-knowledge-*.php
 * templates and remain live — this only redirects the bare /en/knowledge/
 * landing URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_redirect( home_url( '/en/#knowledge' ), 301 );
exit;
