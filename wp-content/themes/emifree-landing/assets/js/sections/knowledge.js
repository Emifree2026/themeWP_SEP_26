/**
 * Emifree Knowledge, per-section behaviors.
 *
 * History note. Before the September 2026 Knowledge subsection URL
 * refactor, this file owned the in-page tab-swap on the homepage
 * Knowledge section: clicking a tab swapped the visible panel via
 * `classList.toggle('hidden', ...)` and updated aria-selected.
 *
 * As of that refactor, each Knowledge tab is a real `<a href>`
 * pointing at its own crawlable sub-page
 * (/en/knowledge/{insights,about,downloads,tools}/, DE twins under
 * /de/wissen/). Clicks therefore navigate to the sub-page, the
 * in-page swap behavior would just block the navigation. The
 * homepage section template is also the only place section-knowledge*.php
 * is rendered; the Knowledge hub (/en/knowledge/, /de/wissen/) has
 * its own page template (page-knowledge-index.php) that does not
 * render the tabs, so the old swap UX was effectively dead code.
 *
 * The file is kept as a placeholder for future Knowledge behaviors
 * (e.g. fragment-anchor scrolling, deep-link awareness). Currently
 * no-op. The `emifree_enqueue_section_script('knowledge')` call in
 * template-parts/section-knowledge*.php still loads it, which is
 * fine, the empty IIFE costs ~30 bytes and preserves the queue API
 * for whatever comes next.
 */
(function () {
    'use strict';
})();
