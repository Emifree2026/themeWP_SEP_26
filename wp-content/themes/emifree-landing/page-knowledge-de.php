<?php
/**
 * Page template stub: /de/wissen/
 *
 * Mirror of page-knowledge.php for the German locale. The landing page
 * keeps a single hub — the Ressourcen & Wissen section on the
 * homepage (`#knowledge`) — so any direct visit to /de/wissen/ 301s
 * to that section.
 *
 * The /de/wissen/<sub>/ URLs (insights, about, downloads, tools,
 * ductulator, etc.) are handled by their own page-knowledge-*-de.php
 * templates and remain live.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_redirect( home_url( '/de/#knowledge' ), 301 );
exit;
