/**
 * Emifree Ductulator — vanilla JS port of ductulator.jsx
 *
 *  - Three sizing modes: friction-rate, velocity, known-size.
 *  - Round or rectangular duct. Six material roughness presets + custom.
 *  - Imperial (CFM, in.wg/100ft, fpm, inches) or metric (m³/h, Pa/m, m/s, mm).
 *  - Math: Darcy-Weisbach + Swamee-Jain friction factor +
 *    ASHRAE equal-friction-and-capacity equivalent round diameter
 *    (De = 1.30 * (ab)^0.625 / (a+b)^0.25). Bisection on D for
 *    friction-mode sizing (60 iterations, well past double-precision
 *    convergence). Standard air (ρ = 1.204 kg/m³, ν = 1.51e-5 m²/s).
 *  - SVG schematic regenerates on every solve.
 *  - Scoped via the `.duct-root` class on the root element so the
 *    styles below can't leak into the host page.
 *  - Labels come from window.EMIFREE_DUCTULATOR_I18N, set by the
 *    page template via wp_localize_script().
 */

(function () {
    'use strict';

    const emifreeRoot = document.querySelector('.duct-root');
    if (!emifreeRoot) {
        return;
    }

    // --- i18n ----------------------------------------------------------------
    const emifreeI18n = (window.EMIFREE_DUCTULATOR_I18N) || {};

    // --- math ----------------------------------------------------------------
    const emifreeRho = 1.204;           // kg/m³  (standard air, 21°C, sea level)
    const emifreeNu  = 1.51e-5;         // m²/s   (kinematic viscosity)
    const emifreeG   = 9.81;            // m/s²

    // Darcy-Weisbach: ΔP/L (Pa/m) = f * (V² / 2D) * ρ
    function emifreeDarcyWeisbach(Vf, Df, ff, rhoIn) {
        return ff * (Vf * Vf / (2 * Df)) * rhoIn;
    }

    // Swamee-Jain explicit approx of Colebrook-White.
    // Inputs in SI; ε in m; D in m; Re dimensionless.
    function emifreeSwameeJain(eps, D, Re) {
        if (Re <= 0 || D <= 0) return 0.02;
        const emifreeTerm = (eps / (3.7 * D)) + (5.74 / Math.pow(Re, 0.9));
        return 0.25 / Math.pow(Math.log10(emifreeTerm), 2);
    }

    // ASHRAE equal-friction-and-capacity equivalent round for rectangular.
    // a, b in same units (m); returns De in same units.
    function emifreeAshraeDe(a, b) {
        return 1.30 * Math.pow(a * b, 0.625) / Math.pow(a + b, 0.25);
    }

    // Bisection: find D (m) that satisfies target_friction (Pa/m) given Q (m³/s).
    function emifreeBisectD(Q, targetFriction, eps, emifreeUnits) {
        let lo = emifreeUnits === 'imperial' ? 0.0254 : 0.025;       // 1" / 25mm
        let hi = emifreeUnits === 'imperial' ? 1.2192 : 1.250;        // 48" / 1250mm
        for (let i = 0; i < 60; i++) {
            const emifreeMid = (lo + hi) / 2;
            const emifreeArea = Math.PI * emifreeMid * emifreeMid / 4;
            const emifreeV = Q / emifreeArea;
            const emifreeRe = (emifreeV * emifreeMid) / emifreeNu;
            const emifreeFf = emifreeSwameeJain(eps, emifreeMid, emifreeRe);
            const emifreeFp = emifreeDarcyWeisbach(emifreeV, emifreeMid, emifreeFf, emifreeRho);
            if (emifreeFp < targetFriction) {
                hi = emifreeMid;
            } else {
                lo = emifreeMid;
            }
            if (Math.abs(hi - lo) < 1e-7) return emifreeMid;
        }
        return (lo + hi) / 2;
    }

    // --- standard size snapping ----------------------------------------------
    const emifreeStdSizesImp = [];
    for (let i = 4; i <= 12; i++) emifreeStdSizesImp.push(i);
    for (let i = 14; i <= 48; i += 2) emifreeStdSizesImp.push(i);
    const emifreeStdSizesMetric = [100, 125, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 700, 800, 900, 1000, 1100, 1200, 1250];
    function emifreeSnap(D_in, units) {
        if (units === 'imperial') {
            let pick = emifreeStdSizesImp[0];
            for (const s of emifreeStdSizesImp) if (s >= D_in) { pick = s; break; }
            if (D_in > emifreeStdSizesImp[emifreeStdSizesImp.length - 1]) pick = emifreeStdSizesImp[emifreeStdSizesImp.length - 1];
            return pick;
        }
        const mm = D_in * 25.4;
        let pick = emifreeStdSizesMetric[0];
        for (const s of emifreeStdSizesMetric) if (s >= mm) { pick = s; break; }
        if (mm > emifreeStdSizesMetric[emifreeStdSizesMetric.length - 1]) pick = emifreeStdSizesMetric[emifreeStdSizesMetric.length - 1];
        return pick / 25.4;
    }

    // --- material roughness (mm) ---------------------------------------------
    const emifreeRoughness = {
        galvanized: 0.09,
        aluminum:   0.04,
        pvc:        0.03,
        fiberglass: 0.9,
        flex:       1.0,
        concrete:   1.5,
    };

    // --- state ---------------------------------------------------------------
    const emifreeState = {
        mode: 'friction',      // 'friction' | 'velocity' | 'known'
        duct: 'round',         // 'round' | 'rect'
        units: 'metric',       // 'imperial' | 'metric' — metric default per user request (DE audience)
        material: 'galvanized',
        customRough: 0.09,
        snap: true,
    };

    // --- result rendering ----------------------------------------------------
    function emifreeRenderResult(result) {
        const emifreeOut = emifreeRoot.querySelector('[data-duct-result]');
        if (!emifreeOut) return;
        if (!result) {
            emifreeOut.innerHTML = '<p class="text-slate-500">' + (emifreeI18n.resultEmpty || '') + '</p>';
            return;
        }
        const emifreeRows = [];
        for (const k of Object.keys(result.lines)) {
            emifreeRows.push(
                '<div class="flex justify-between py-1 border-b border-slate-100">' +
                '<span class="text-slate-600">' + k + '</span>' +
                '<span class="font-mono font-medium text-slate-900">' + result.lines[k] + '</span>' +
                '</div>'
            );
        }
        emifreeOut.innerHTML = emifreeRows.join('');
        emifreeRenderSchematic(result);
    }

    function emifreeRenderSchematic(result) {
        const emifreeSvg = emifreeRoot.querySelector('[data-duct-schematic]');
        if (!emifreeSvg) return;
        if (!result || !result.shape) {
            emifreeSvg.innerHTML = '<text x="100" y="60" text-anchor="middle" fill="#94a3b8" font-size="12">' + (emifreeI18n.schematicEmpty || '') + '</text>';
            return;
        }
        const emifreeIsImp = emifreeState.units === 'imperial';
        let emifreeHtml = '';
        if (result.shape === 'round') {
            const emifreeR = Math.min(80, Math.max(8, result.d_inches * 4));
            emifreeHtml += '<circle cx="100" cy="60" r="' + emifreeR + '" fill="#dbeafe" stroke="#1d4ed8" stroke-width="2"/>';
            const emifreeDiamLabel = emifreeIsImp
                ? 'Ø ' + result.d_inches.toFixed(2) + ' in'
                : 'Ø ' + (result.d_inches * 25.4).toFixed(0) + ' mm';
            emifreeHtml += '<text x="100" y="125" text-anchor="middle" fill="#1e293b" font-size="11">' + emifreeDiamLabel + '</text>';
        } else {
            const emifreeW = Math.min(160, Math.max(16, result.W_inches * 4));
            const emifreeH = Math.min(120, Math.max(8, result.H_inches * 4));
            emifreeHtml += '<rect x="' + (100 - emifreeW / 2) + '" y="' + (60 - emifreeH / 2) + '" width="' + emifreeW + '" height="' + emifreeH + '" fill="#dbeafe" stroke="#1d4ed8" stroke-width="2"/>';
            const emifreeDimLabel = emifreeIsImp
                ? result.W_inches.toFixed(1) + ' × ' + result.H_inches.toFixed(1) + ' in'
                : (result.W_inches * 25.4).toFixed(0) + ' × ' + (result.H_inches * 25.4).toFixed(0) + ' mm';
            emifreeHtml += '<text x="100" y="125" text-anchor="middle" fill="#1e293b" font-size="11">' + emifreeDimLabel + '</text>';
        }
        emifreeSvg.innerHTML = emifreeHtml;
    }

    // --- core solver ---------------------------------------------------------
    function emifreeSolve() {
        // All inputs are interpreted in the active display units (the
        // form's unit-suffix <span>s flip with emifreeState.units) and
        // converted to SI here. The math below always runs in SI.
        const emifreeUnits = emifreeState.units;
        const emifreeIsImp = emifreeUnits === 'imperial';

        const emifreeQInput = parseFloat(emifreeRoot.querySelector('[name="duct-q"]').value) || 0;
        if (emifreeQInput <= 0) {
            emifreeRenderResult(null);
            return;
        }
        // Airflow: m³/h (metric) or CFM (imperial) → m³/s.
        const emifreeQ_m3s = emifreeIsImp
            ? emifreeQInput * 0.000471947
            : emifreeQInput / 3600;

        const emifreeEpsMm = emifreeState.material === 'custom'
            ? parseFloat(emifreeRoot.querySelector('[name="duct-custom-rough"]').value) || 0.09
            : emifreeRoughness[emifreeState.material];

        let emifreeTarget = 0;     // friction rate in Pa/m
        const emifreeMode = emifreeState.mode;

        let emifreeD_m = 0;
        let emifreeFric_Pa_m = 0;
        let emifreeV_m_s = 0;

        // Helper: convert a length entered in display units (mm or in) to meters.
        const emifreeLenToM = function (v) {
            return emifreeIsImp ? v * 0.0254 : v * 0.001;
        };

        if (emifreeMode === 'friction') {
            const emifreeFricInput = parseFloat(emifreeRoot.querySelector('[name="duct-friction"]').value) || 0.1;
            // Friction: Pa/m (metric) or in.wg/100ft (imperial) → Pa/m.
            // 1 in.wg per 100 ft = 248.84 Pa / 30.48 m ≈ 8.171 Pa/m.
            emifreeTarget = emifreeIsImp
                ? emifreeFricInput * 8.171
                : emifreeFricInput;
            emifreeD_m = emifreeBisectD(emifreeQ_m3s, emifreeTarget, emifreeEpsMm * 0.001, emifreeUnits);
            const emifreeArea = Math.PI * emifreeD_m * emifreeD_m / 4;
            emifreeV_m_s = emifreeQ_m3s / emifreeArea;
            emifreeFric_Pa_m = emifreeTarget;
        } else if (emifreeMode === 'velocity') {
            const emifreeVelInput = parseFloat(emifreeRoot.querySelector('[name="duct-velocity"]').value) || 1000;
            // Velocity: m/s (metric) or fpm (imperial) → m/s. 1 fpm = 0.00508 m/s.
            emifreeV_m_s = emifreeIsImp
                ? emifreeVelInput * 0.00508
                : emifreeVelInput;
            emifreeD_m = Math.sqrt(4 * emifreeQ_m3s / (Math.PI * emifreeV_m_s));
            const emifreeArea = Math.PI * emifreeD_m * emifreeD_m / 4;
            const emifreeRe = (emifreeV_m_s * emifreeD_m) / emifreeNu;
            const emifreeFf = emifreeSwameeJain(emifreeEpsMm * 0.001, emifreeD_m, emifreeRe);
            emifreeFric_Pa_m = emifreeDarcyWeisbach(emifreeV_m_s, emifreeD_m, emifreeFf, emifreeRho);
        } else { // known
            if (emifreeState.duct === 'round') {
                const emifreeDin = parseFloat(emifreeRoot.querySelector('[name="duct-d-round"]').value) || 12;
                emifreeD_m = emifreeLenToM(emifreeDin);
            } else {
                const emifreeW = parseFloat(emifreeRoot.querySelector('[name="duct-w"]').value) || 24;
                const emifreeH = parseFloat(emifreeRoot.querySelector('[name="duct-h"]').value) || 12;
                emifreeD_m = emifreeAshraeDe(emifreeLenToM(emifreeW), emifreeLenToM(emifreeH));
            }
            const emifreeArea = emifreeState.duct === 'round'
                ? Math.PI * emifreeD_m * emifreeD_m / 4
                : emifreeLenToM(parseFloat(emifreeRoot.querySelector('[name="duct-w"]').value) || 24) *
                  emifreeLenToM(parseFloat(emifreeRoot.querySelector('[name="duct-h"]').value) || 12);
            emifreeV_m_s = emifreeQ_m3s / emifreeArea;
            const emifreeRe = (emifreeV_m_s * emifreeD_m) / emifreeNu;
            const emifreeFf = emifreeSwameeJain(emifreeEpsMm * 0.001, emifreeD_m, emifreeRe);
            emifreeFric_Pa_m = emifreeDarcyWeisbach(emifreeV_m_s, emifreeD_m, emifreeFf, emifreeRho);
        }

        // Snap to standard size if requested
        let emifreeDfinal_in = emifreeD_m / 0.0254;
        let emifreeW_inches = 0, emifreeH_inches = 0;
        if (emifreeState.snap && emifreeMode !== 'known') {
            if (emifreeState.duct === 'round') {
                emifreeDfinal_in = emifreeSnap(emifreeDfinal_in, emifreeUnits);
                emifreeD_m = emifreeDfinal_in * 0.0254;
                const emifreeArea = Math.PI * emifreeD_m * emifreeD_m / 4;
                emifreeV_m_s = emifreeQ_m3s / emifreeArea;
                const emifreeRe = (emifreeV_m_s * emifreeD_m) / emifreeNu;
                const emifreeFf = emifreeSwameeJain(emifreeEpsMm * 0.001, emifreeD_m, emifreeRe);
                emifreeFric_Pa_m = emifreeDarcyWeisbach(emifreeV_m_s, emifreeD_m, emifreeFf, emifreeRho);
            } else {
                // For rectangular, snap area to standard W × H combinations.
                // Aspect ratio is hardcoded to 1.5 ± 0.3 (was state.aspectRatio,
                // but that state field had no UI control).
                const emifreeArea_in2 = (emifreeD_m * emifreeD_m / 0.0254 / 0.0254) * Math.PI / 4;
                let emifreeBestW = 6, emifreeBestH = 6, emifreeBestDiff = Infinity;
                for (let w = 6; w <= 48; w += 2) {
                    for (let h = 6; h <= 48; h += 2) {
                        if (Math.abs(w / h - 1.5) > 0.3) continue;
                        const emifreeAreaDiff = Math.abs(w * h - emifreeArea_in2);
                        if (emifreeAreaDiff < emifreeBestDiff) {
                            emifreeBestDiff = emifreeAreaDiff;
                            emifreeBestW = w; emifreeBestH = h;
                        }
                    }
                }
                emifreeW_inches = emifreeBestW; emifreeH_inches = emifreeBestH;
                emifreeD_m = emifreeAshraeDe(emifreeW_inches * 0.0254, emifreeH_inches * 0.0254);
                emifreeV_m_s = emifreeQ_m3s / (emifreeW_inches * 0.0254 * emifreeH_inches * 0.0254);
                const emifreeRe = (emifreeV_m_s * emifreeD_m) / emifreeNu;
                const emifreeFf = emifreeSwameeJain(emifreeEpsMm * 0.001, emifreeD_m, emifreeRe);
                emifreeFric_Pa_m = emifreeDarcyWeisbach(emifreeV_m_s, emifreeD_m, emifreeFf, emifreeRho);
            }
        } else if (emifreeState.duct === 'rect') {
            emifreeW_inches = parseFloat(emifreeRoot.querySelector('[name="duct-w"]').value) || 24;
            emifreeH_inches = parseFloat(emifreeRoot.querySelector('[name="duct-h"]').value) || 12;
            if (emifreeMode !== 'known') {
                emifreeD_m = emifreeAshraeDe(emifreeW_inches * 0.0254, emifreeH_inches * 0.0254);
            }
        }

        // Render output. Internal calcs run in SI; display units flip
        // based on emifreeState.units so metric users see mm / m·s /
        // Pa·m and imperial users see in / fpm / in.wg·100ft.
        const emifreeDiamFmt = emifreeState.duct === 'rect'
            ? (emifreeIsImp
                ? (emifreeW_inches.toFixed(1) + ' × ' + emifreeH_inches.toFixed(1) + ' in')
                : ((emifreeW_inches * 25.4).toFixed(0) + ' × ' + (emifreeH_inches * 25.4).toFixed(0) + ' mm'))
            : (emifreeIsImp
                ? (emifreeDfinal_in.toFixed(2) + ' in')
                : ((emifreeDfinal_in * 25.4).toFixed(0) + ' mm'));
        const emifreeVelFmt = emifreeIsImp
            ? ((emifreeV_m_s / 0.00508).toFixed(0) + ' fpm')
            : (emifreeV_m_s.toFixed(2) + ' m/s');
        // 1 in.wg per 100 ft = 248.84 Pa / 30.48 m ≈ 8.171 Pa/m.
        const emifreeFricFmt = emifreeIsImp
            ? ((emifreeFric_Pa_m / 8.171).toFixed(3) + ' in.wg/100ft')
            : (emifreeFric_Pa_m.toFixed(3) + ' Pa/m');

        const emifreeRe = (emifreeV_m_s * emifreeD_m) / emifreeNu;
        const emifreeFf = emifreeSwameeJain(emifreeEpsMm * 0.001, emifreeD_m, emifreeRe);

        const emifreeLines = {
            [emifreeI18n.labelDiameter || 'Diameter']: emifreeDiamFmt,
            [emifreeI18n.labelVelocity || 'Velocity']: emifreeVelFmt,
            [emifreeI18n.labelFriction || 'Friction rate']: emifreeFricFmt,
            [emifreeI18n.labelReynolds || 'Reynolds']: emifreeRe.toFixed(0),
            [emifreeI18n.labelFf || 'Friction factor']: emifreeFf.toFixed(4),
        };
        if (emifreeState.duct === 'rect' && emifreeMode !== 'known') {
            emifreeLines[emifreeI18n.labelEqDiameter || 'Equivalent Ø'] = emifreeIsImp
                ? ((emifreeD_m / 0.0254).toFixed(2) + ' in')
                : ((emifreeD_m * 1000).toFixed(0) + ' mm');
        }
        emifreeRenderResult({
            lines: emifreeLines,
            shape: emifreeState.duct,
            d_inches: emifreeDfinal_in,
            W_inches: emifreeW_inches,
            H_inches: emifreeH_inches,
        });
    }

    // --- UI show/hide --------------------------------------------------------
    // Helper: walk a container and disable every form control inside
    // when the container's visibility doesn't match the active state.
    // Disabled inputs are skipped by keyboard tab, ignored by browser
    // autofill, and not submitted with the form — so the Diameter
    // field (relevant only in "Known size" mode) can't be silently
    // modified while it's hidden in friction/velocity modes.
    function emifreeSetDisabled(container, disabled) {
        if (!container) return;
        container.querySelectorAll('input, select, textarea, button').forEach(function (el) {
            // Don't disable the reset button or other top-level
            // controls — only disable inputs that belong to this
            // container's content. Reset is outside [data-duct-show]
            // containers so it's already safe.
            el.disabled = disabled;
        });
    }

    function emifreeSyncUI() {
        // Walk every visibility-gated element. An element can have
        // multiple gating attributes (e.g. data-duct-show="known" +
        // data-duct-duct="round"); the element is visible ONLY if ALL
        // present gates pass. Doing this in two separate loops (one
        // for [data-duct-show], one for [data-duct-duct]) caused the
        // second loop to overwrite the first's hide — the Diameter
        // block was being un-hidden by the duct loop even though the
        // mode loop had hidden it.
        emifreeRoot.querySelectorAll('[data-duct-show], [data-duct-duct]').forEach(function (el) {
            let emifreeVisible = true;
            if (el.hasAttribute('data-duct-show')) {
                const emifreeModes = el.getAttribute('data-duct-show').split(',');
                emifreeVisible = emifreeVisible && (emifreeModes.indexOf(emifreeState.mode) >= 0);
            }
            if (el.hasAttribute('data-duct-duct')) {
                emifreeVisible = emifreeVisible && (el.getAttribute('data-duct-duct') === emifreeState.duct);
            }
            el.style.display = emifreeVisible ? '' : 'none';
            emifreeSetDisabled(el, !emifreeVisible);
        });
        // Units-gated labels (CFM/m³h, in.wg/Pa-m, fpm/m·s).
        emifreeRoot.querySelectorAll('[data-duct-units]').forEach(function (el) {
            const emifreeVisible = el.getAttribute('data-duct-units') === emifreeState.units;
            el.style.display = emifreeVisible ? '' : 'none';
            // These are <span>s, not form controls — no disable needed.
        });
        // Custom-roughness field — only shown when material === 'custom'.
        const emifreeCustomRough = emifreeRoot.querySelector('[name="duct-custom-rough"]');
        if (emifreeCustomRough) {
            const emifreeWrap = emifreeCustomRough.closest('label,div');
            const emifreeVisible = emifreeState.material === 'custom';
            if (emifreeWrap) emifreeWrap.style.display = emifreeVisible ? '' : 'none';
            emifreeCustomRough.disabled = !emifreeVisible;
        }
    }

    // --- event wiring --------------------------------------------------------
    function emifreeInit() {
        // Radio / select changes
        emifreeRoot.addEventListener('change', function (e) {
            const emifreeT = e.target;
            if (!emifreeT.name) return;
            const emifreeN = emifreeT.name;
            if (emifreeN === 'duct-mode')   emifreeState.mode = emifreeT.value;
            if (emifreeN === 'duct-shape')  emifreeState.duct = emifreeT.value;
            if (emifreeN === 'duct-units')  emifreeState.units = emifreeT.value;
            if (emifreeN === 'duct-material') emifreeState.material = emifreeT.value;
            if (emifreeN === 'duct-snap')   emifreeState.snap = emifreeT.checked;
            emifreeSyncUI();
            emifreeSolve();
        });
        emifreeRoot.addEventListener('input', function (e) {
            if (e.target.name && e.target.name.indexOf('duct-') === 0) {
                emifreeSolve();
            }
        });

        // Reset button — restores form fields + state to their initial
        // defaults (matching the markup's `value=` attributes and the
        // checked radios) and re-runs the solver. The defaults live on
        // the markup itself so this stays in sync if the PHP changes
        // the initial values (read them off the DOM rather than
        // duplicating here).
        const emifreeResetBtn = emifreeRoot.querySelector('[data-duct-reset]');
        if (emifreeResetBtn) {
            emifreeResetBtn.addEventListener('click', function () {
                emifreeResetToDefaults();
                emifreeSyncUI();
                emifreeSolve();
            });
        }
        emifreeCaptureDefaults();
        emifreeSyncUI();
        emifreeSolve();
    }

    // Reset form fields + state to initial values. Reads from the
    // DOM's checked radios and `value=` attributes so the source of
    // truth stays in the PHP template (the same values the page
    // loads with).
    function emifreeResetToDefaults() {
        // Reset state to the module's initial defaults.
        emifreeState.mode = 'friction';
        emifreeState.duct = 'round';
        emifreeState.units = 'metric';
        emifreeState.material = 'galvanized';
        emifreeState.customRough = 0.09;
        emifreeState.snap = true;

        // Restore every input to its markup default. Each input's
        // default is stored as a `data-duct-default` attribute when
        // first encountered (set lazily below), so we don't have to
        // hardcode the same values in two places.
        emifreeRoot.querySelectorAll('[data-duct-default]').forEach(function (el) {
            const emifreeDefault = el.getAttribute('data-duct-default');
            if (el.type === 'checkbox') {
                el.checked = emifreeDefault === 'true' || emifreeDefault === '1';
            } else if (el.type === 'radio') {
                el.checked = (el.value === emifreeDefault);
            } else {
                el.value = emifreeDefault;
            }
        });
        // For radios without an explicit default (only one is checked
        // by default in the markup), the loop above may not set them.
        // Walk radios by name group and pick the one that was
        // initially checked in the markup.
        emifreeRoot.querySelectorAll('input[type="radio"]').forEach(function (el) {
            if (el.hasAttribute('data-duct-default')) return;
            if (el.defaultChecked) el.checked = true;
        });
        // For text/number inputs that lack data-duct-default, fall back
        // to defaultValue (the markup `value=` attribute).
        emifreeRoot.querySelectorAll('input[type="number"], input[type="text"]').forEach(function (el) {
            if (el.hasAttribute('data-duct-default')) return;
            if ('defaultValue' in el) el.value = el.defaultValue;
        });
        // <select> elements aren't covered by the loops above. Walk
        // them and restore the option that was defaultSelected in the
        // markup — this keeps the visible dropdown label in sync with
        // the state that's just been reset to defaults.
        emifreeRoot.querySelectorAll('select').forEach(function (el) {
            for (let i = 0; i < el.options.length; i++) {
                if (el.options[i].defaultSelected) {
                    el.value = el.options[i].value;
                    break;
                }
            }
        });
    }

    // Capture initial defaults from the markup on load. The PHP
    // template owns the source-of-truth values via `value=` and
    // `checked` attributes; we copy them into data-duct-default so
    // emifreeResetToDefaults() can restore them.
    function emifreeCaptureDefaults() {
        emifreeRoot.querySelectorAll('input, select').forEach(function (el) {
            if (el.type === 'checkbox') {
                el.setAttribute('data-duct-default', el.checked ? 'true' : 'false');
            } else if (el.type === 'radio') {
                if (el.defaultChecked) el.setAttribute('data-duct-default', el.value);
            } else {
                el.setAttribute('data-duct-default', el.defaultValue);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', emifreeInit);
    } else {
        emifreeInit();
    }
})();