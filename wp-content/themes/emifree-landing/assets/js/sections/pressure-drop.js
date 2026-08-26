/**
 * Emifree Pressure Drop Calculator — Quick Calc (TLV-style section form).
 *
 *  - Single-section list: each row is a duct section with diameter
 *    + a list of component rows (straight tubes 0.5/1/2 m, 90°/45°
 *    elbows, T/Y, reducer). The user clicks Calculate to sum friction
 *    loss (Darcy-Weisbach + Swamee-Jain) + minor loss (K-factor).
 *  - Application correction K_app scales the total: 1.0 HVAC,
 *    1.15 oil mist (liquid-film drag), 1.25 dust (particle accel.).
 *  - Imperial unit branch converts D in/ft → m. Airflow stays m³/h.
 *  - Recommended fan pressure = total × 2 (industry safety margin).
 *
 * Labels come from window.EMIFREE_PRESSUREDROP_I18N.
 *
 * (The legacy visual builder — drag-and-drop SVG canvas, ASHRAE JSON
 * engine, port-snap, properties panel — was removed per product
 * decision. Only the Quick Calc tab is shipped.)
 */

(function () {
    'use strict';

    const emifreeRoot = document.querySelector('.pd-root');
    if (!emifreeRoot) {
        return;
    }

    // --- i18n ----------------------------------------------------------------
    const emifreeI18n = window.EMIFREE_PRESSUREDROP_I18N || {};
    function emifreeT(key, fallback) { return emifreeI18n[key] || fallback || key; }
    emifreeRoot.querySelectorAll('[data-pd-i18n]').forEach(function (el) {
        const key = el.getAttribute('data-pd-i18n');
        const txt = emifreeT(key);
        if (typeof txt === 'string') {
            // Use innerHTML so the i18n strings can contain simple
            // HTML markup (e.g. <b>, <br>) for the methodology,
            // calculations, etc. All i18n values are hardcoded in the
            // PHP template — no user-supplied data flows through here.
            el.innerHTML = txt;
        }
    });

    // --- Constants -----------------------------------------------------------
    // Material roughness values — industry standard (Idelchik 1986
    // Table 1.2 / ASHRAE Handbook Fundamentals / Crane TP-410). mm.
    const emifreeRoughnessMm = {
        galvanized: 0.15,
        aluminum:   0.0015,
        blackSteel: 0.045,
    };

    // Component options for the row dropdown. The first 3 are
    // straight-tube presets (each has a known length in m). The rest
    // are fittings with K-factors baked in.
    //   straight-0.5 → 0.5 m of straight tube
    //   straight-1   → 1 m
    //   straight-2   → 2 m
    //   e90          → 90° elbow, K = 0.18
    //   e45          → 45° elbow, K = 0.20
    //   tee          → T-junction, K = 1.20
    //   y            → Y-connector, K = 0.60
    //   reducer      → Reducer (K = 0.10)
    const emifreeComponentOptions = [
        { value: 'straight-0.5', label: 'Straight tube 0.5 m', length: 0.5, k: 0 },
        { value: 'straight-1',   label: 'Straight tube 1 m',   length: 1,   k: 0 },
        { value: 'straight-2',   label: 'Straight tube 2 m',   length: 2,   k: 0 },
        { value: 'e90',          label: '90° elbow (K=0.18)',  length: 0,   k: 0.18 },
        { value: 'e45',          label: '45° elbow (K=0.20)',  length: 0,   k: 0.20 },
        { value: 'tee',          label: 'T-junction (K=1.20)', length: 0,   k: 1.20 },
        { value: 'y',            label: 'Y-connector (K=0.60)', length: 0,  k: 0.60 },
        { value: 'reducer',      label: 'Reducer (K=0.10)',    length: 0,   k: 0.10 },
    ];
    const emifreeComponentByValue = Object.fromEntries(
        emifreeComponentOptions.map(function (o) { return [o.value, o]; })
    );

    // --- Quick Calc: section + row templates -------------------------------
    let emifreeQuickSectionCounter = 0;

    function emifreeQuickSectionTemplate(idx) {
        // One section: diameter input + a list of component rows. The
        // section uses a single diameter for all its fittings. A
        // reducer row carries a second (outlet) diameter so the
        // downstream rows step down.
        return (
            '<div class="pd-quick-section border border-slate-200 rounded-lg p-3 bg-slate-50" data-section-idx="' + idx + '">' +
            '<div class="flex items-center justify-between mb-2">' +
                '<span class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Section ' + idx + '</span>' +
                '<button type="button" data-pd-quick-remove-section class="text-slate-400 hover:text-red-600 text-xs font-medium" data-pd-i18n="remove">Remove</button>' +
            '</div>' +
            // Diameter — single value for the whole section.
            '<div class="mb-3">' +
                '<label class="flex flex-col gap-1">' +
                    '<span class="text-[10px] text-slate-600 uppercase tracking-wider" data-pd-i18n="diameter">Diameter</span>' +
                    '<select name="pd-quick-d-' + idx + '" class="w-full rounded border border-slate-300 px-2 py-1 text-sm">' +
                        '<optgroup label="mm" data-pd-quick-units="metric">' +
                            '<option value="300">300 mm</option>' +
                            '<option value="250">250 mm</option>' +
                            '<option value="200" selected>200 mm</option>' +
                            '<option value="150">150 mm</option>' +
                            '<option value="125">125 mm</option>' +
                            '<option value="100">100 mm</option>' +
                            '<option value="80">80 mm</option>' +
                        '</optgroup>' +
                    '</select>' +
                '</label>' +
            '</div>' +
            // Components list — the duct run is built from a list of
            // named components (straight tube 0.5/1/2 m, 90°/45°
            // elbows, T/Y, reducer). The user adds rows; the math
            // handles each row per its K-factor or length.
            '<div class="mb-1 text-[10px] text-slate-600 uppercase tracking-wider" data-pd-i18n="components">Components</div>' +
            '<div data-pd-quick-rows-' + idx + ' class="space-y-1 mb-2"></div>' +
            '<button type="button" data-pd-quick-add-row="' + idx + '" class="text-xs text-blue-700 hover:text-blue-800 font-medium">' +
                '<span data-pd-i18n="addRow">+ Add component</span>' +
            '</button>' +
            '</div>'
        );
    }

    function emifreeQuickRowTemplate(sectionIdx, rowIdx) {
        // Component options for the row dropdown. The "reducer" option
        // triggers a second "outlet diameter" dropdown that must be
        // smaller than the section's diameter (so the user can model
        // a step-down in pipe size).
        const opts = emifreeComponentOptions.map(function (o) {
            return '<option value="' + o.value + '">' + o.label + '</option>';
        }).join('');
        // Outlets for a reducer are diameters SMALLER than the section
        // diameter. The outlet list is updated dynamically when the
        // user changes the section diameter.
        return (
            '<div class="flex items-center gap-1" data-pd-quick-row="' + sectionIdx + '-' + rowIdx + '">' +
                '<select name="pd-quick-comp-' + sectionIdx + '-' + rowIdx + '" class="flex-1 rounded border border-slate-300 px-2 py-1 text-sm">' +
                    opts +
                '</select>' +
                // Outlet-diameter selector — shown only for the reducer
                // type. The class is toggled visible via a row change
                // handler.
                '<select name="pd-quick-outlet-' + sectionIdx + '-' + rowIdx + '" data-pd-quick-outlet class="w-24 rounded border border-slate-300 px-1 py-1 text-sm hidden" title="Outlet diameter (mm)">' +
                    '<option value="80">80</option>' +
                    '<option value="100">100</option>' +
                    '<option value="125">125</option>' +
                    '<option value="150">150</option>' +
                    '<option value="200">200</option>' +
                    '<option value="250">250</option>' +
                    '<option value="300" selected>300</option>' +
                '</select>' +
                '<input type="number" name="pd-quick-qty-' + sectionIdx + '-' + rowIdx + '" min="1" step="1" value="1" class="w-14 rounded border border-slate-300 px-1 py-1 text-sm text-center" inputmode="numeric" title="Quantity">' +
                '<button type="button" data-pd-quick-remove-row="' + sectionIdx + '-' + rowIdx + '" class="text-slate-400 hover:text-red-600 px-1" title="Remove">&times;</button>' +
            '</div>'
        );
    }

    function emifreeQuickAddRow(sectionIdx) {
        const container = emifreeRoot.querySelector('[data-pd-quick-rows-' + sectionIdx + ']');
        if (!container) return;
        const rowIdx = container.children.length;
        const wrap = document.createElement('div');
        wrap.innerHTML = emifreeQuickRowTemplate(sectionIdx, rowIdx);
        const newRow = wrap.firstElementChild;
        container.appendChild(newRow);
        // Re-filter the new row's outlet dropdown so it only shows
        // diameters smaller than the section's main. Otherwise the
        // user sees the full 7-value list (80, 100, 125, 150, 200,
        // 250, 300) on every reducer row regardless of section size.
        const section = container.closest('.pd-quick-section');
        if (section) {
            const dSel = section.querySelector('select[name^="pd-quick-d-"]');
            const outlet = newRow.querySelector('select[name^="pd-quick-outlet-"]');
            if (dSel && outlet) {
                const D_mm = parseFloat(dSel.value);
                const prev = parseFloat(outlet.value);
                const allOutlets = [80, 100, 125, 150, 200, 250, 300];
                const valid = allOutlets.filter(function (d) { return d < D_mm; });
                outlet.innerHTML = valid.map(function (d) {
                    return '<option value="' + d + '">' + d + ' mm</option>';
                }).join('');
                const pick = (valid.indexOf(prev) >= 0) ? prev : valid[valid.length - 1];
                if (pick) outlet.value = String(pick);
            }
        }
    }

    function emifreeQuickAddSection() {
        emifreeQuickSectionCounter += 1;
        const container = emifreeRoot.querySelector('[data-pd-quick-sections]');
        if (!container) return;
        const idx = emifreeQuickSectionCounter;
        const wrap = document.createElement('div');
        wrap.innerHTML = emifreeQuickSectionTemplate(idx);
        container.appendChild(wrap.firstElementChild);
        // If the previous section ended with a reducer, pre-select
        // this section's diameter to the reducer's outlet. The user
        // can still pick a different value.
        const prevOutlet_mm = emifreeGetLastReducerOutlet_mm();
        if (prevOutlet_mm) {
            const dSel = wrap.querySelector('select[name="pd-quick-d-' + idx + '"]');
            if (dSel) {
                dSel.value = String(prevOutlet_mm);
            }
        }
        // Seed with one default row so the user has something to start
        // from.
        emifreeQuickAddRow(idx);
    }

    // Find the most recent reducer's outlet diameter (in mm) across
    // all sections, in order. Returns null if no reducer has been
    // added yet, or if the previous sections don't have a reducer.
    // Used to pre-select the diameter of newly-added sections so
    // they continue a pipe size reduction.
    function emifreeGetLastReducerOutlet_mm() {
        const inputs = emifreeQuickReadQuickInputs();
        for (let i = inputs.sections.length - 1; i >= 0; i--) {
            const sec = inputs.sections[i];
            for (let j = sec.rows.length - 1; j >= 0; j--) {
                const row = sec.rows[j];
                if (row.type === 'reducer' && row.outlet_mm) {
                    return row.outlet_mm;
                }
            }
        }
        return null;
    }

    function emifreeAttachQuickCalc() {
        // Add section button
        const addBtn = emifreeRoot.querySelector('[data-pd-quick-add-section]');
        if (addBtn) addBtn.addEventListener('click', emifreeQuickAddSection);

        // Calculate button
        const calcBtn = emifreeRoot.querySelector('[data-pd-quick-calc]');
        if (calcBtn) calcBtn.addEventListener('click', emifreeQuickCalculate);

        const sectionsContainer = emifreeRoot.querySelector('[data-pd-quick-sections]');
        if (!sectionsContainer) return;

        // Remove section (delegated)
        sectionsContainer.addEventListener('click', function (e) {
            const rm = e.target.closest('[data-pd-quick-remove-section]');
            if (rm) {
                const section = rm.closest('.pd-quick-section');
                if (section) section.remove();
            }
        });

        // Add component row (delegated — buttons carry section idx).
        sectionsContainer.addEventListener('click', function (e) {
            const addBtn = e.target.closest('[data-pd-quick-add-row]');
            if (addBtn) {
                emifreeQuickAddRow(addBtn.getAttribute('data-pd-quick-add-row'));
            }
        });

        // Row change: when a row's component is set to "reducer", show
        // the outlet-diameter dropdown. For anything else, hide it.
        // Also: at most one reducer per section. If this section
        // already has a reducer, disable the "Reducer" option in all
        // other rows' dropdowns so the user can't accidentally add a
        // second.
        sectionsContainer.addEventListener('change', function (e) {
            const sel = e.target.closest('select[name^="pd-quick-comp-"]');
            if (sel) {
                const row = sel.closest('[data-pd-quick-row]');
                const outlet = row.querySelector('select[name^="pd-quick-outlet-"]');
                if (outlet) {
                    // Tailwind's `hidden` class is
                    // display: none !important, so we have to
                    // toggle the class itself, not the inline
                    // style.
                    outlet.classList.toggle('hidden', sel.value !== 'reducer');
                }
                // Disable the "Reducer" option in every other
                // row's dropdown if this section already has one.
                const section = sel.closest('.pd-quick-section');
                if (section) {
                    const reducerRows = section.querySelectorAll('select[name^="pd-quick-comp-"]');
                    let reducerCount = 0;
                    reducerRows.forEach(function (s) {
                        if (s.value === 'reducer') reducerCount++;
                    });
                    reducerRows.forEach(function (s) {
                        const opt = Array.from(s.options).find(function (o) { return o.value === 'reducer'; });
                        if (opt) {
                            if (s.value !== 'reducer' && reducerCount >= 1) {
                                opt.disabled = true;
                            } else {
                                opt.disabled = false;
                            }
                        }
                    });
                }
            }
            // Diameter change in a section: regenerate the
            // reducer outlet dropdowns so they only show
            // diameters strictly smaller than the section's main
            // diameter. Preserve the previously-selected value if
            // it is still valid; otherwise pick the largest valid
            // option (the size just below the section's main).
            const dSel = e.target.closest('select[name^="pd-quick-d-"]');
            if (dSel) {
                const D_mm = parseFloat(dSel.value);
                const allOutlets = [80, 100, 125, 150, 200, 250, 300];
                emifreeRoot.querySelectorAll('select[name^="pd-quick-outlet-"]').forEach(function (outSel) {
                    const prev = parseFloat(outSel.value);
                    const valid = allOutlets.filter(function (d) { return d < D_mm; });
                    outSel.innerHTML = valid.map(function (d) {
                        return '<option value="' + d + '">' + d + ' mm</option>';
                    }).join('');
                    const pick = (valid.indexOf(prev) >= 0) ? prev : valid[valid.length - 1];
                    if (pick) outSel.value = String(pick);
                });
            }
        });

        // Remove component row (delegated).
        sectionsContainer.addEventListener('click', function (e) {
            const rm = e.target.closest('[data-pd-quick-remove-row]');
            if (rm) {
                const row = rm.closest('[data-pd-quick-row]');
                if (row) row.remove();
            }
        });
    }

    function emifreeQuickReadQuickInputs() {
        const af = parseFloat(emifreeRoot.querySelector('[name="pd-quick-airflow"]').value) || 0;
        const mat = emifreeRoot.querySelector('[name="pd-quick-material"]').value;
        const variant = emifreeRoot.querySelector('[name="pd-quick-variant"]').value;
        const sections = [];
        emifreeRoot.querySelectorAll('[data-pd-quick-sections] .pd-quick-section').forEach(function (sec) {
            const idx = sec.getAttribute('data-section-idx');
            const D_mm = parseFloat(sec.querySelector('[name="pd-quick-d-' + idx + '"]').value) || 0;
            // Each section has a list of component rows. Each row has
            // a type (length or K) and a quantity. We collect the rows
            // as a list so the calculate function can step through them
            // in order and apply diameter changes after reducers.
            const rows = [];
            sec.querySelectorAll('[data-pd-quick-row]').forEach(function (row) {
                const type = row.querySelector('select').value;
                const qty = parseInt(row.querySelector('input[type="number"]').value) || 0;
                const def = emifreeComponentByValue[type];
                if (def && qty > 0) {
                    const outletSelect = row.querySelector('select[name^="pd-quick-outlet-"]');
                    const outlet_mm = (type === 'reducer' && outletSelect) ? parseFloat(outletSelect.value) : null;
                    rows.push({
                        type: type,
                        qty: qty,
                        length: def.length,
                        k: def.k,
                        outlet_mm: outlet_mm
                    });
                }
            });
            sections.push({
                D: D_mm,
                rows: rows
            });
        });
        return { airflow: af, material: mat, variant: variant, sections: sections };
    }

    function emifreeQuickCalculate() {
        // For each section, we walk the row list in order. Each row
        // contributes friction (if it's a tube) or K·P_v (if it's a
        // fitting) at the row's upstream diameter. After a reducer,
        // the rest of the section continues at the reducer's outlet
        // diameter — this is what fixes the multi-reducer accuracy.
        // Airflow is ALWAYS m³/h (no imperial toggle for Q). Diameter
        // and length per section are converted from in/ft → m if the
        // user picks the imperial unit system.
        const inputs = emifreeQuickReadQuickInputs();
        const unitsEl = emifreeRoot.querySelector('[name="pd-quick-units"]');
        const units = unitsEl ? unitsEl.value : 'metric';
        const Qsi = inputs.airflow / 3600;     // m³/h → m³/s
        const rho = 1.2;
        const mu = 1.81e-5;
        // Resolve material roughness
        const matKey = inputs.material;
        const epsM = (matKey === 'custom') ? 0.00015 : (emifreeRoughnessMm[matKey] || 0.15) / 1000;

        let totalFriction = 0;
        let totalMinor = 0;
        for (const s of inputs.sections) {
            if (s.D <= 0) continue;
            // Convert section D to meters. Airflow already in m³/h.
            let D = (units === 'imperial') ? s.D * 0.0254 : s.D / 1000;
            // Walk the rows in order. After a reducer, the remaining
            // rows use the reducer's outlet diameter.
            for (const row of s.rows) {
                if (row.type === 'reducer') {
                    // Friction and K for the reducer — computed at the
                    // upstream diameter, using the section's current D.
                    const A = Math.PI * D * D / 4;
                    const V = Qsi / A;
                    const Re = (rho * V * D) / mu;
                    const term = (epsM / (3.7 * D)) + (5.74 / Math.pow(Re, 0.9));
                    const f = term > 0 ? 0.25 / Math.pow(Math.log10(term), 2) : 0.02;
                    const Pv = 0.5 * rho * V * V;
                    // Reducer K·P_v is computed once. (No length
                    // contribution — the reducer is a fitting, not a
                    // length of duct.)
                    const minor = row.k * row.qty * Pv;
                    totalMinor += minor;
                    // Now switch the current diameter to the outlet
                    // diameter. Imperial outlet is in inches.
                    if (row.outlet_mm) {
                        D = (units === 'imperial') ? row.outlet_mm * 0.0254 : row.outlet_mm / 1000;
                    }
                } else if (row.length > 0) {
                    // Straight tube: friction loss for the row's length.
                    const L = (units === 'imperial') ? row.length * 0.3048 : row.length;
                    const A = Math.PI * D * D / 4;
                    const V = Qsi / A;
                    const Re = (rho * V * D) / mu;
                    const term = (epsM / (3.7 * D)) + (5.74 / Math.pow(Re, 0.9));
                    const f = term > 0 ? 0.25 / Math.pow(Math.log10(term), 2) : 0.02;
                    const friction = f * (L / D) * 0.5 * rho * V * V * row.qty;
                    totalFriction += friction;
                } else {
                    // Pure fitting (90° elbow, 45° elbow, T, Y):
                    // K·P_v at the current D.
                    const A = Math.PI * D * D / 4;
                    const V = Qsi / A;
                    const Pv = 0.5 * rho * V * V;
                    const minor = row.k * row.qty * Pv;
                    totalMinor += minor;
                }
            }
        }
        const Kapp = ({'oil-mist': 1.15, 'dust': 1.25, 'hvac': 1.0})[inputs.variant] || 1.0;
        const totalRaw = totalFriction + totalMinor;
        const totalAdjusted = totalRaw * Kapp;
        const fanRec = totalAdjusted * 2; // 2× safety margin
        // Render
        const r = emifreeRoot.querySelector('[data-pd-quick-result]');
        if (r) r.classList.remove('hidden');
        const set = function (sel, val) {
            const el = emifreeRoot.querySelector(sel);
            if (el) el.textContent = val.toFixed(1) + ' Pa';
        };
        set('[data-pd-quick-friction]', totalFriction);
        set('[data-pd-quick-minor]', totalMinor);
        set('[data-pd-quick-total]', totalAdjusted);
        const fanEl = emifreeRoot.querySelector('[data-pd-quick-fan]');
        if (fanEl) fanEl.textContent = fanRec.toFixed(1) + ' Pa';
    }

    function emifreeInit() {
        emifreeAttachQuickCalc();
        // Seed one section so the user has a row to edit on first load.
        emifreeQuickAddSection();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', emifreeInit);
    } else {
        emifreeInit();
    }
})();
