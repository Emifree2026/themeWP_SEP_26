<?php
/**
 * Silktide Consent Manager v2 loader + language-aware config.
 *
 * Replaces the Cookiebot plugin (installed at wp-content/plugins/cookiebot/
 * but unconfigured). Emits the CDN-hosted silktide-consent-manager bundle
 * (CSS + JS) on wp_head priority 1 (before the gtag loader at priority 3,
 * gtag's default-consent call must precede gtag('config', ...)).
 *
 * The init config is EN or DE based on emifree_get_lang().
 *
 * Category layout (v2 official snippet, single source of truth below):
 *   essential   strictly necessary, always on (no UI toggle)
 *   analytics   GA4 + Tawk.to live chat (gtag functionality_storage +
 *               analytics_storage both granted on accept)
 *   marketing   reserved for future marketing tags (gtag: ad_*)
 *
 * Tawk.to is no longer a separate "functional" category in the banner;
 * instead, the external assets/js/tawk-gate.js listens for the
 * Silktide analytics-consent state and injects the official Tawk.to
 * embed bundle only after the user accepts Analytics. This keeps the
 * banner on the standard 3-category layout the snippet ships with,
 * while still gating Tawk.to.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'emifree_get_tawk_property_id' ) ) :
	/**
	 * Return the Tawk.to property ID for the active language, or '' if
	 * unconfigured. Re-reads REQUEST_URI each call so it's safe to call
	 * both at wp_head priority 1 and at wp_enqueue_scripts time.
	 *
	 * @return string Property ID in '<account>/<widget>' format, or ''.
	 */
	function emifree_get_tawk_property_id() {
		$lang = function_exists( 'emifree_get_lang' ) ? emifree_get_lang() : 'en';
		if ( 'de' === $lang ) {
			return defined( 'EMIFREE_TAWK_PROPERTY_ID_DE' ) ? trim( (string) EMIFREE_TAWK_PROPERTY_ID_DE ) : '';
		}
		return defined( 'EMIFREE_TAWK_PROPERTY_ID_EN' ) ? trim( (string) EMIFREE_TAWK_PROPERTY_ID_EN ) : '';
	}
endif;

if ( ! function_exists( 'emifree_enqueue_silktide_consent' ) ) :
	/**
	 * Emit the Silktide loader bundle + init script on the front end.
	 *
	 * Hooked at wp_head priority 1 so the default-consent state is
	 * published to dataLayer BEFORE the gtag loader (priority 3) runs
	 * its `gtag('config', ...)` call. Without that ordering, GA4 would
	 * fire a config-level ping before any consent default has been set,
	 * which is what the previous implementation did and is why the
	 * GA4 set_cookies / ad_storage signal was always "granted".
	 */
	function emifree_enqueue_silktide_consent() {
		if ( is_admin() ) {
			return;
		}

		$lang     = function_exists( 'emifree_get_lang' ) ? emifree_get_lang() : 'en';
		$tawk_id  = emifree_get_tawk_property_id();

		$config      = ( 'de' === $lang )
			? emifree_silktide_config_de( $tawk_id )
			: emifree_silktide_config_en( $tawk_id );
		$config_json = wp_json_encode( $config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

		?>
		<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
		<link rel="stylesheet" id="silktide-consent-manager-css" href="https://cdn.jsdelivr.net/gh/silktide/consent-manager@v2.0.1/silktide-consent-manager.css" integrity="sha384-EdMq+R+YOnsbelo08wPenoTlnxbAyxI11NMIxzugx/qAsbh64KcOkqxYqq6pfvO/" crossorigin="anonymous">
		<style id="silktide-consent-manager-overrides">
		#stcm-wrapper {
		  --boxShadow: -5px 5px 10px 0px #00000012, 0px 0px 50px 0px #0000001a;
		  --fontFamily: Helvetica Neue, Segoe UI, Arial, sans-serif;
		  --primaryColor: #3B62E2;
		  --backgroundColor: #FFFFFF;
		  --textColor: #253B48;
		  --backdropBackgroundColor: #00000033;
		  --backdropBackgroundBlur: 0px;
		  --iconColor: #3B62E2;
		  --iconBackgroundColor: #FFFFFF;
		}
		</style>
		<script src="https://cdn.jsdelivr.net/gh/silktide/consent-manager@v2.0.1/silktide-consent-manager.js" integrity="sha384-5Pt34uiIbCsvfiiZXoLi4HRf/YBXjr9c8e+gYeVo9smUaInNHYVtc8NZ8wUnXJIq" crossorigin="anonymous"></script>
		<script>
		window.silktideConsentManager.init(<?php echo $config_json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON-encoded config object, trusted. ?>);
		</script>
		<?php
	}
	add_action( 'wp_head', 'emifree_enqueue_silktide_consent', 1 );

	/**
	 * Enqueue the external Tawk.to gate loader.
	 *
	 * The actual Tawk.to embed script is injected by assets/js/tawk-gate.js
	 * only after the user accepts the Silktide "analytics" consent
	 * category. wp_localize_script passes the property ID from PHP to
	 * JS in a single round trip (no data-attribute parsing).
	 */
	if ( '' !== emifree_get_tawk_property_id() ) :
		function emifree_enqueue_tawk_gate() {
			$tawk_id = emifree_get_tawk_property_id();
			if ( '' === $tawk_id ) {
				return;
			}

			wp_enqueue_script(
				'emifree-tawk-gate',
				get_template_directory_uri() . '/assets/js/tawk-gate.js',
				array(),
				defined( 'EMIFREE_THEME_VERSION' ) ? EMIFREE_THEME_VERSION : false,
				true // footer
			);
			wp_localize_script(
				'emifree-tawk-gate',
				'emifreeTawk',
				array(
					'propertyId' => $tawk_id,
					'lang'       => function_exists( 'emifree_get_lang' ) ? emifree_get_lang() : 'en',
				)
			);
		}
		add_action( 'wp_enqueue_scripts', 'emifree_enqueue_tawk_gate' );
	endif;
endif;

if ( ! function_exists( 'emifree_silktide_config_en' ) ) :
	function emifree_silktide_config_en( $tawk_id ) {
		// $tawk_id is currently unused here; the Silktide analytics
		// category's "gtag" config publishes the functionality_storage
		// + analytics_storage update on accept, and the external
		// assets/js/tawk-gate.js observes that state to inject Tawk.to.
		// The argument is kept in the function signature so future
		// categories (e.g. a separate functional bucket) can opt back
		// into inline scripts.
		return array(
			'backdrop' => array( 'show' => true ),
			'icon'     => array( 'position' => 'bottomLeft' ),
			'prompt'   => array( 'position' => 'bottomLeft' ),
			'consentTypes' => array(
				array(
					'id'          => 'essential',
					'label'       => 'Essential',
					'required'    => true,
					'description' => '<p>These cookies are necessary for the website to function properly and cannot be switched off. They help with things like logging in and setting your privacy preferences.</p>',
				),
				array(
					'id'          => 'analytics',
					'label'       => 'Analytics',
					'required'    => false,
					'gtag'        => array( 'analytics_storage', 'functionality_storage' ),
					'description' => '<p>These cookies help us improve the site by tracking which pages are most popular and how visitors move around the site. Accepting Analytics also enables our live chat (tawk.to) — both rely on the same consent signal.</p>',
				),
				array(
					'id'          => 'marketing',
					'label'       => 'Marketing',
					'required'    => false,
					'gtag'        => array( 'ad_storage', 'ad_user_data', 'ad_personalization' ),
					'description' => '<p>These cookies are used by us and our advertising partners to show you relevant ads on this site and elsewhere, and to measure how those campaigns perform.</p>',
				),
			),
			'text' => array(
				'prompt' => array(
					'description'                              => '<p>We use cookies on our site to enhance your user experience, provide personalized content, and analyze our traffic.</p>',
					'acceptAllButtonText'                      => 'Accept all',
					'acceptAllButtonAccessibleLabel'           => 'Accept all cookies',
					'rejectNonEssentialButtonText'             => 'Reject non-essential',
					'rejectNonEssentialButtonAccessibleLabel'  => 'Reject all non-essential cookies',
					'preferencesButtonText'                    => 'Preferences',
					'preferencesButtonAccessibleLabel'         => 'Toggle preferences',
				),
				'preferences' => array(
					'title'                       => 'Customize your cookie preferences',
					'description'                 => '<p>We respect your right to privacy. You can choose not to allow some types of cookies. Your cookie preferences will apply across our website.</p>',
					'saveButtonText'              => 'Save and close',
					'saveButtonAccessibleLabel'   => 'Save your cookie preferences',
					'creditLinkText'              => 'Get this banner for free',
					'creditLinkAccessibleLabel'   => 'Get this banner for free',
				),
			),
		);
	}
endif;

if ( ! function_exists( 'emifree_silktide_config_de' ) ) :
	function emifree_silktide_config_de( $tawk_id ) {
		return array(
			'backdrop' => array( 'show' => true ),
			'icon'     => array( 'position' => 'bottomLeft' ),
			'prompt'   => array( 'position' => 'bottomLeft' ),
			'consentTypes' => array(
				array(
					'id'          => 'essential',
					'label'       => 'Essenziell',
					'required'    => true,
					'description' => '<p>Diese Cookies sind für das einwandfreie Funktionieren der Website notwendig und können nicht deaktiviert werden. Sie unterstützen z. B. das Anmelden und das Speichern Ihrer Datenschutzeinstellungen.</p>',
				),
				array(
					'id'          => 'analytics',
					'label'       => 'Analyse',
					'required'    => false,
					'gtag'        => array( 'analytics_storage', 'functionality_storage' ),
					'description' => '<p>Diese Cookies helfen uns, die Website zu verbessern, indem sie erfassen, welche Seiten am beliebtesten sind und wie Besucher sich auf der Website bewegen. Mit der Zustimmung zu Analyse aktivieren Sie auch unseren Live-Chat (tawk.to) — beide nutzen dasselbe Einwilligungssignal.</p>',
				),
				array(
					'id'          => 'marketing',
					'label'       => 'Marketing',
					'required'    => false,
					'gtag'        => array( 'ad_storage', 'ad_user_data', 'ad_personalization' ),
					'description' => '<p>Diese Cookies werden von uns und unseren Werbepartnern verwendet, um Ihnen relevante Anzeigen auf dieser Website und anderswo zu zeigen und um die Leistung dieser Kampagnen zu messen.</p>',
				),
			),
			'text' => array(
				'prompt' => array(
					'description'                              => '<p>Wir verwenden Cookies auf unserer Website, um Ihre Nutzererfahrung zu verbessern, personalisierte Inhalte bereitzustellen und unseren Traffic zu analysieren.</p>',
					'acceptAllButtonText'                      => 'Alle akzeptieren',
					'acceptAllButtonAccessibleLabel'           => 'Alle Cookies akzeptieren',
					'rejectNonEssentialButtonText'             => 'Nicht-essenzielle ablehnen',
					'rejectNonEssentialButtonAccessibleLabel'  => 'Alle nicht-essenziellen Cookies ablehnen',
					'preferencesButtonText'                    => 'Einstellungen',
					'preferencesButtonAccessibleLabel'         => 'Einstellungen umschalten',
				),
				'preferences' => array(
					'title'                       => 'Cookie-Einstellungen anpassen',
					'description'                 => '<p>Wir respektieren Ihr Recht auf Privatsphäre. Sie können einige Cookie-Typen deaktivieren. Ihre Cookie-Einstellungen gelten für unsere gesamte Website.</p>',
					'saveButtonText'              => 'Speichern und schließen',
					'saveButtonAccessibleLabel'   => 'Cookie-Einstellungen speichern',
					'creditLinkText'              => 'Diesen Banner kostenlos erhalten',
					'creditLinkAccessibleLabel'   => 'Diesen Banner kostenlos erhalten',
				),
			),
		);
	}
endif;
