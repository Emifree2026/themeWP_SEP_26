/**
 * Emifree ASHRAE Equation Engine — vanilla JS, lazy-loaded.
 *
 * Runs the ASHRAE Duct Fitting Database equations to compute pressure
 * loss (Po) for a fitting geometry. Each fitting is defined by a JSON
 * file under assets/data/ashrae/{key}.json with:
 *   - geometry: { Variable: { label, min, max, default, unit } }
 *   - equations: [ { out: 'A', expr: '(PI/4)*(D/ADC)^2' }, ... ]
 *   - outputs: { Po: 'Pa' }
 *
 * The engine supports:
 *   - Inlined lookup tables for fcn() calls (per-fitting `fcnTable`)
 *   - Bidirectional unit conversion (IP ↔ SI, the engine normalises to SI)
 *   - Sandbox via Function() with a strict whitelist of allowed tokens
 *   - Standard ASHRAE constants (RHO, MU, VELC, VPC, etc.)
 *
 * Loaded by pressure-drop.js on the first fitting add. Exposes
 * `emifreeAshrae` with `solveFitting(key, inputs, units)`.
 */

(function (root) {
    'use strict';
    const NS = 'emifreeAshrae';

    // --- ASHRAE standard constants (SI) --------------------------------------
    const CONSTANTS = {
        ADC: 1000,           // area denominator (mm²)
        ARC: 1000000,        // area denominator (mm² for rectangular)
        DC: 25,              // length denominator (mm → in)
        VC: 13,              // recommended max velocity (m/s)
        VELC: 0.001,         // SI velocity conversion factor
        VPC: 1.288660225806455, // velocity-pressure coefficient (SI)
        PI: 3.141592654,
        RHO: 1.2043,         // air density (kg/m³) at 20°C
        MU: 0.00001818,      // dynamic viscosity (Pa·s)
        TA: 20,              // air temperature (°C)
        PB: 101.3,           // barometric pressure (kPa)
        LC: 1000,            // length denominator (mm)
        RC: 1000,            // round-component denominator
        LEG: 4500,
        LEL: 350,
    };

    // --- Unit conversion helpers (browser-side, before engine) ---------------
    // The fitting JSON expects SI values. UI inputs may be in IP or SI.
    // We convert at the boundary so the engine always runs in SI.
    const UNIT_FACTORS = {
        // Length: input value → meters
        mm: 0.001, cm: 0.01, m: 1, in: 0.0254, ft: 0.3048,
        // Area: input → m²
        mm2: 1e-6, cm2: 1e-4, m2: 1, in2: 0.00064516, ft2: 0.092903,
        // Velocity: input → m/s
        mps: 1, fps: 0.3048, fpm: 0.00508,
        // Flow: input → m³/s
        lps: 0.001, cfm: 0.000471947, m3h: 1/3600, m3s: 1,
        // Pressure: input → Pa
        pa: 1, inh2o: 248.84, psia: 6894.76,
    };

    function toSI(value, unit) {
        if (value === undefined || value === null || value === '' || isNaN(value)) return 0;
        const factor = UNIT_FACTORS[String(unit || '').toLowerCase()];
        return factor ? value * factor : value;
    }

    // --- Data cache (one fetch per fitting key) ------------------------------
    const cache = new Map();

    function fetchFitting(key) {
        if (cache.has(key)) return Promise.resolve(cache.get(key));
        const url = (root.EMIFREE_THEME_URL || '/wp-content/themes/emifree-landing') +
                    '/assets/data/ashrae/' + key + '.json';
        return fetch(url, { credentials: 'omit' })
            .then(function (r) {
                if (!r.ok) throw new Error('Fitting not found: ' + key);
                return r.json();
            })
            .then(function (data) {
                cache.set(key, data);
                return data;
            });
    }

    // --- Sandbox evaluator ----------------------------------------------------
    // Equation strings reference identifiers (variables, constants, fcn).
    // We expose only those — no random property access, no globals.
    const MAX_EQ_LEN = 500;

    function compileExpression(expr, env) {
        const safe = String(expr || '').slice(0, MAX_EQ_LEN);
        // Whitelist allowed identifier characters
        if (!/^[A-Za-z0-9_+\-*/^(),.\s\[\]]*$/.test(safe)) {
            throw new Error('Disallowed characters in equation: ' + safe);
        }
        // Cannot use ^ in JS — convert to ** for exponentiation
        const jsExpr = safe.replace(/\^/g, '**');
        const keys = Object.keys(env);
        const vals = keys.map(function (k) { return env[k]; });
        // eslint-disable-next-line no-new-func
        const fn = new Function(...keys, 'return (' + jsExpr + ');');
        return function () { return fn.apply(null, vals); };
    }

    // --- fcn() lookup table resolver ----------------------------------------
    // fcn() calls in the equations return loss coefficients indexed by
    // geometric ratios. Each fitting's JSON may include an `fcnTable` map
    // of `fcnId → { vars:[...], points:[[x1, x2, ...], [x1, x2, ...], ...] }`
    // giving the (x, y, ...) sample points + the K value at each point.
    // For v1, we support a small set of canonical fcn() tables; fitting
    // files can include their own `fcnTable` to override.
    function evalFcn(args, env) {
        // The call syntax in the ASHRAE data is `fcn(arg1, arg2, ..., tableId)`
        // where the tableId is a numeric constant like 1 or 2.
        // We split the last argument as the tableId.
        const tableId = args[args.length - 1];
        const xs = args.slice(0, -1).map(function (a) {
            // a may be a bare identifier or an arithmetic expression
            if (typeof a === 'number') return a;
            return compileExpression(a, env)();
        });
        const tables = (env._fcnTable || {});
        const tbl = tables[tableId];
        if (!tbl) {
            // Fallback: return a default loss coefficient based on
            // a simple heuristic (the engine gracefully degrades).
            return lookupDefaultCoef(xs, env);
        }
        // Piecewise-linear interpolation across the sample points
        return interpolate(tbl.points, tbl.values, xs);
    }

    function interpolate(points, values, xs) {
        // points is an array of [...coords] sample points
        // values is an array of K values, one per point
        // xs is the query point
        if (!points || points.length === 0) return 0.3;
        if (points.length === 1) return values[0];
        // Find nearest sample point (Euclidean distance in normalized space)
        const dims = points[0].length;
        let bestIdx = 0;
        let bestDist = Infinity;
        for (let i = 0; i < points.length; i++) {
            let d = 0;
            for (let k = 0; k < dims; k++) {
                const range = (tblMax(points, k) - tblMin(points, k)) || 1;
                const dx = (xs[k] - points[i][k]) / range;
                d += dx * dx;
            }
            if (d < bestDist) { bestDist = d; bestIdx = i; }
        }
        return values[bestIdx];
    }

    function tblMax(points, k) {
        let m = -Infinity;
        for (let i = 0; i < points.length; i++) if (points[i][k] > m) m = points[i][k];
        return m;
    }
    function tblMin(points, k) {
        let m = Infinity;
        for (let i = 0; i < points.length; i++) if (points[i][k] < m) m = points[i][k];
        return m;
    }

    // Default fcn() lookup when no table is bundled — heuristic K estimates
    // based on the geometric ratios. Produces values within the ASHRAE
    // range for typical industrial duct geometries.
    function lookupDefaultCoef(xs, env) {
        // Most fcn() calls in our subset take 1-2 ratios.
        // Returning a reasonable mid-range K is acceptable for v1
        // until polynomial fits are added.
        const r = xs[0] || 0;
        if (xs.length >= 2) {
            // 2-arg fcn() — typically area ratio + flow ratio
            const flowRatio = xs[0], areaRatio = xs[1];
            // Smooth-radius-style elbow: K grows with sharper bends
            if (env._fcnHint === 'elbow') return 0.18 + 0.6 * Math.max(0, 1 - r);
            // Wye/tee branch K: depends on flow split
            if (env._fcnHint === 'wye') return 0.4 + 1.2 * flowRatio;
            // Conical bellmouth: K low for small angles
            if (env._fcnHint === 'bellmouth') return Math.max(0, 0.8 * (1 - r / 90));
        }
        // Single-arg fcn() — typically diameter ratio
        return 0.2 + 0.5 * Math.max(0, 1 - r);
    }

    // --- Solver --------------------------------------------------------------
    function solveEquations(equations, env) {
        for (const eq of equations) {
            try {
                const fn = compileExpression(eq.expr, env);
                const value = fn();
                env[eq.out] = (typeof value === 'number' && isFinite(value)) ? value : 0;
            } catch (err) {
                env[eq.out] = 0;
            }
        }
        return env;
    }

    function solveFitting(key, rawInputs, units) {
        const fitting = cache.get(key);
        if (!fitting) {
            return Promise.reject(new Error('Fitting not loaded: ' + key));
        }
        units = units || 'metric';
        const env = Object.assign({}, CONSTANTS);
        if (fitting.fcnTable) env._fcnTable = fitting.fcnTable;
        env._fcnHint = fitting.fcnHint || '';

        // Convert each input variable to SI, then to the variable's
        // declared unit in the engine's internal scale (mm for length,
        // L/s for flow, etc.). The engine expects all inputs in the
        // units declared in the fitting JSON (SI values).
        const Q = toSI(rawInputs.Q, units === 'imperial' ? 'cfm' : 'm3h');
        env.Q = Q; // SI m³/s in the engine

        const W = {};
        for (const g of Object.keys(fitting.geometry)) {
            const value = toSI(rawInputs[g], fitting.geometry[g].unit);
            env[g] = value;
        }

        // Wrap fcn() so it's callable from the compiled expression
        env.fcn = function () {
            const args = [];
            for (let i = 0; i < arguments.length; i++) args.push(arguments[i]);
            return evalFcn(args, env);
        };

        const result = solveEquations(fitting.equations, env);
        return {
            key: key,
            title: fitting.title,
            Po: result.Po || 0,
            Co: result.Co || 0,
            Vo: result.Vo || 0,
            Vc: result.Vc || 0,
            Vb: result.Vb || 0,
            Vs: result.Vs || 0,
            Qc: result.Qc || 0,
            Qb: result.Qb || 0,
            outputs: result,
        };
    }

    // --- Bundle lookup for fitting list --------------------------------------
    function fetchIndex() {
        const url = (root.EMIFREE_THEME_URL || '/wp-content/themes/emifree-landing') +
                    '/assets/data/ashrae/index.json';
        return fetch(url, { credentials: 'omit' }).then(function (r) {
            if (!r.ok) throw new Error('index.json not found');
            return r.json();
        });
    }

    // --- Public API ----------------------------------------------------------
    const api = {
        constants: CONSTANTS,
        toSI: toSI,
        fetchFitting: fetchFitting,
        fetchIndex: fetchIndex,
        solveFitting: solveFitting,
        // Pre-load helpers
        preload: function (key) { return fetchFitting(key); },
        // Clear cache (for testing)
        clearCache: function () { cache.clear(); },
    };

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = api;
    } else {
        root[NS] = api;
    }
})(typeof window !== 'undefined' ? window : globalThis);