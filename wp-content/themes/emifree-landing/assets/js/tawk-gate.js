/**
 * Tawk.to loader, gated by Silktide consent.
 *
 * The widget bundle is appended to the page ONLY when the user grants
 * the "analytics" consent category. This is the official Tawk.to
 * install snippet (verbatim, modulo the property ID being read from a
 * data attribute on <html> rather than hardcoded into the source).
 *
 * The bundle's `unload` event-listener deprecation is a known Tawk.to
 * upstream issue tracked on their side; we can't patch the third-party
 * bundle, so we accept the deprecation warning. The widget itself is
 * fully functional.
 *
 * Detection paths (whichever fires first wins):
 *   1. Poll window.silktideConsentManager.getConsentChoice('analytics')
 *      every 750 ms, capped at 60 s.
 *   2. Click on the banner's "Accept all" / "Save and close" buttons
 *      (capture-phase listener + setTimeout(0) so Silktide's own
 *      bubble-phase handler runs first and writes the new consent
 *      state before we read it).
 *
 * No crossorigin attribute on the dynamic <script>: per the comment in
 * the previous (pre-Silktide) loader, setting crossorigin='*' on the
 * embed script caused intermittent CORS-blocked loads on Tawk.to's CDN
 * and dropped the Lighthouse Best Practices score.
 */
(function () {
	'use strict';

	// Property ID is published by wp_localize_script as the
	// window.emifreeTawk global in inc/consent.php.
	var cfg = window.emifreeTawk;
	if (!cfg || !cfg.propertyId) {
		return;
	}
	var tawkId = cfg.propertyId;
	var tawkLang = cfg.lang || 'en';

	var armed = false;

	function loadTawk() {
		if (armed) {
			return;
		}
		armed = true;

		// Official Tawk.to install snippet, verbatim:
		// <https://dashboard.tawk.to/#/widget/widget-config> -> "Direct
		// Chat Link" -> "Embed code". crossorigin attribute intentionally
		// omitted (see comment at the top of this file).
		window.Tawk_API = window.Tawk_API || {};
		window.Tawk_LoadStart = new Date();
		(function () {
			var s1 = document.createElement('script'),
				s0 = document.getElementsByTagName('script')[0];
			s1.async = true;
			s1.src = 'https://embed.tawk.to/' + tawkId;
			s1.charset = 'UTF-8';
			s0.parentNode.insertBefore(s1, s0);
		})();

		// Tawk.to belongs to the gtag "functionality_storage" bucket;
		// flip the signal now that the user has consented (Silktide
		// already flipped analytics_storage via the analytics category's
		// gtag config, but we re-assert both here so any racing reads
		// from the gtag loader see a consistent granted state).
		if (typeof window.gtag === 'function') {
			window.gtag('consent', 'update', {
				functionality_storage: 'granted',
				analytics_storage: 'granted'
			});
		}
		// Expose the active Tawk.to language on <html> so any
		// downstream widget / debugger can read it.
		document.documentElement.setAttribute('data-emifree-tawk-lang', tawkLang);
	}

	function isAnalyticsGranted() {
		var mgr = window.silktideConsentManager;
		if (!mgr || typeof mgr.getConsentChoice !== 'function') {
			return false;
		}
		try {
			return mgr.getConsentChoice('analytics') === 'granted';
		} catch (e) {
			return false;
		}
	}

	// Path 1: poll. Catches the "user revisits the site and the banner
	// is suppressed because consent is already in localStorage" case.
	var pollStart = Date.now();
	var pollTimer = setInterval(function () {
		if (armed) {
			clearInterval(pollTimer);
			return;
		}
		if (Date.now() - pollStart > 60000) {
			clearInterval(pollTimer);
			return;
		}
		if (isAnalyticsGranted()) {
			loadTawk();
			clearInterval(pollTimer);
		}
	}, 750);

	// Path 2: click probe on banner buttons. Capture phase + setTimeout(0)
	// ensures we run AFTER Silktide's own bubble-phase listener writes
	// the new consent state to its store.
	document.addEventListener(
		'click',
		function (ev) {
			var t = ev.target;
			if (!t) {
				return;
			}
			var txt = (t.textContent || '').toLowerCase();
			var isAcceptAll = /accept\s*all|alle\s*akzeptieren/.test(txt);
			var isSaveAndClose = /save\s*(and|&)?\s*close|speichern/.test(txt);
			if (!isAcceptAll && !isSaveAndClose) {
				return;
			}
			setTimeout(function () {
				if (isAnalyticsGranted()) {
					loadTawk();
				}
			}, 0);
		},
		true
	);
})();
