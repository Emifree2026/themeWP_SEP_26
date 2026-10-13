<?php
/**
 * Analytics helpers, third-party measurement tag emission.
 *
 * Each tag is gated on a wp-config.php constant so the same theme
 * ships to staging + production with different IDs, and any tag can
 * be disabled site-wide by setting its constant to '' (empty) or
 * commenting it out.
 *
 * Constants read (define in wp-config.php):
 *
 *   EMIFREE_GA4_ID                  Google Analytics 4 web stream ID
 *                                  (e.g. 'G-FBMDM7TY8M'). Empty =
 *                                  no GA4.
 *
 *   EMIFREE_GSC_VERIFICATION        Google Search Console <meta
 *                                  name="google-site-verification">
 *                                  content value. Empty = no GSC tag.
 *
 *   EMIFREE_BING_VERIFICATION       Bing Webmaster Tools <meta
 *                                  name="msvalidate.01"> content value.
 *                                  Empty = no Bing tag.
 *
 * Why wp-config constants and not theme-options / admin UI:
 *  - IDs are deployment-environment data, not content. They don't
 *    belong in the database.
 *  - Theme options are easy to forget and hard to grep across
 *    deploys. wp-config is in version control and reviewed.
 *  - Operators rotating an ID (which happens ~1x per year) edit
 *    one file, not two (DB + cache flush).
 *
 * Preconnect hints to googletagmanager.com are emitted unconditionally
 *, they cost ~0ms for browsers that never load gtag, but shave
 * ~100ms off Time-to-Interactive on first paint for the browsers
 * that do. The async gtag.js itself is loaded only when
 * EMIFREE_GA4_ID is set.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emit preconnect hints for known measurement-tag origins.
 *
 * Fired on wp_head at priority 1 (early) so the browser can start
 * the DNS+TLS handshake for these origins while it parses the rest
 * of the document. Saves ~100-300ms on first interaction with the
 * third-party tag.
 */
function emifree_analytics_preconnect() {
	?>
	<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
	<link rel="dns-prefetch" href="https://www.googletagmanager.com">
	<link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
	<link rel="dns-prefetch" href="https://www.google-analytics.com">
	<?php
}
add_action( 'wp_head', 'emifree_analytics_preconnect', 1 );

/**
 * Emit search-engine verification meta tags.
 *
 * Both GSC and Bing Webmaster Tools offer a <meta name="..."> tag
 * verification option. They live in <head> and tell the engine "I
 * control this site, please index it." No JS, no cookies, no
 * privacy impact.
 */
function emifree_analytics_verification_tags() {
	$emifree_gsc  = defined( 'EMIFREE_GSC_VERIFICATION' )  ? trim( (string) EMIFREE_GSC_VERIFICATION )  : '';
	$emifree_bing = defined( 'EMIFREE_BING_VERIFICATION' ) ? trim( (string) EMIFREE_BING_VERIFICATION ) : '';
	if ( '' !== $emifree_gsc ) {
		echo '<meta name="google-site-verification" content="' . esc_attr( $emifree_gsc ) . '">' . "\n";
	}
	if ( '' !== $emifree_bing ) {
		echo '<meta name="msvalidate.01" content="' . esc_attr( $emifree_bing ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'emifree_analytics_verification_tags', 2 );

/**
 * Emit the Google Analytics 4 (gtag.js) loader + config call.
 *
 * Only fires when EMIFREE_GA4_ID is defined and non-empty. Uses the
 * recommended async loader (the official Google snippet), non-blocking.
 *
 * Consent Mode v2: this function publishes a `gtag('consent', 'default',
 * …)` call BEFORE the `gtag('config', …)` call, with every storage
 * signal set to 'denied'. The Silktide Consent Manager loader (emitted
 * at wp_head priority 1 by inc/consent.php) watches for these signals
 * and re-publishes `gtag('consent', 'update', …)` whenever the user
 * grants/revokes a category in the banner or preferences modal. The
 * 'wait_for_update: 500' delay tells gtag not to fire any
 * measurement pings until either (a) the user makes a choice, or (b)
 * 500 ms elapse — whichever comes first. The 500 ms fallback still
 * captures cookieless pings even if Silktide is blocked.
 *
 * Hooked at wp_head priority 3 so it runs AFTER the Silktide loader
 * (priority 1) — order matters: the default-consent call must hit
 * dataLayer before the config call so gtag honours the initial
 * denied-by-default state on its very first measurement ping.
 */
function emifree_analytics_ga4() {
	$emifree_ga4_id = defined( 'EMIFREE_GA4_ID' ) ? trim( (string) EMIFREE_GA4_ID ) : '';
	if ( '' === $emifree_ga4_id ) {
		return;
	}
	?>
	<!-- Google tag (gtag.js), measurement ID <?php echo esc_html( $emifree_ga4_id ); ?> -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $emifree_ga4_id ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('consent', 'default', {
			ad_storage: 'denied',
			ad_user_data: 'denied',
			ad_personalization: 'denied',
			analytics_storage: 'denied',
			functionality_storage: 'denied',
			wait_for_update: 500
		});
		gtag('js', new Date());
		gtag('config', '<?php echo esc_js( $emifree_ga4_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'emifree_analytics_ga4', 3 );