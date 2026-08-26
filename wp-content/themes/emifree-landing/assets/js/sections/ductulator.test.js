// Standalone sanity test for ductulator math.
// Inlines the math so we don't have to break the IIFE in the source file.

const rho = 1.204;
const nu  = 1.51e-5;

function swameeJain(eps, D, Re) {
    if (Re <= 0 || D <= 0) return 0.02;
    const term = (eps / (3.7 * D)) + (5.74 / Math.pow(Re, 0.9));
    return 0.25 / Math.pow(Math.log10(term), 2);
}
function darcyWeisbach(V, D, f) {
    return f * (V * V / (2 * D)) * rho;
}
function bisectD(Q, targetFric, eps, units) {
    let lo = units === 'imperial' ? 0.0254 : 0.025;
    let hi = units === 'imperial' ? 1.2192 : 1.250;
    for (let i = 0; i < 60; i++) {
        const mid = (lo + hi) / 2;
        const A = Math.PI * mid * mid / 4;
        const V = Q / A;
        const Re = V * mid / nu;
        const f = swameeJain(eps, mid, Re);
        const fp = darcyWeisbach(V, mid, f);
        if (fp < targetFric) hi = mid; else lo = mid;
        if (Math.abs(hi - lo) < 1e-7) return mid;
    }
    return (lo + hi) / 2;
}

console.log('=== METRIC SPOT-CHECK ===');
console.log('Input: 1700 m³/h at 0.85 Pa/m, galvanized steel (ε = 0.09 mm)');
const Q = 1700 / 3600;
const eps = 0.09e-3;
const D = bisectD(Q, 0.85, eps, 'metric');
const A = Math.PI * D * D / 4;
const V = Q / A;
const Re = V * D / nu;
const f = swameeJain(eps, D, Re);
const fric = darcyWeisbach(V, D, f);
console.log(`  D = ${(D * 1000).toFixed(1)} mm`);
console.log(`  V = ${V.toFixed(2)} m/s`);
console.log(`  f = ${f.toFixed(5)}`);
console.log(`  friction = ${fric.toFixed(3)} Pa/m  (target = 0.850)`);
console.log(`  Re = ${Re.toFixed(0)}`);

console.log('\n=== IMPERIAL SPOT-CHECK ===');
console.log('Input: 1000 CFM at 0.10 in.wg/100ft, galvanized steel');
const Qi = 1000 * 0.000471947;
const targetGood = 0.10 * 8.171;
const Di = bisectD(Qi, targetGood, eps, 'imperial');
const Ai = Math.PI * Di * Di / 4;
const Vi = Qi / Ai;
console.log(`  target = ${targetGood.toFixed(3)} Pa/m (= 0.10 in.wg/100ft via 8.171)`);
console.log(`  D = ${(Di * 1000).toFixed(0)} mm = ${(Di / 0.0254).toFixed(1)} in`);
console.log(`  V = ${Vi.toFixed(2)} m/s = ${(Vi / 0.00508).toFixed(0)} fpm`);

console.log('\n=== OLD BUG (factor 2.4884) for comparison ===');
const Dw = bisectD(Qi, 0.10 * 2.4884, eps, 'imperial');
console.log(`  with 2.4884: D = ${(Dw * 1000).toFixed(0)} mm (under-sized)`);