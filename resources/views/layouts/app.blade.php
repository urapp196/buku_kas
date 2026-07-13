<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Buku Kas — Catatan Keuangan')</title>
<meta name="description" content="Buku Kas — Aplikasi pencatatan keuangan pribadi. Catat pemasukan dan pengeluaran dengan mudah.">
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23142A1E'/><path d='M8 7h10l6 6v12H8V7z' fill='%23D9AC6C' opacity='.9'/><path d='M18 7l6 6h-6V7z' fill='%23B98B4E'/><line x1='11' y1='14' x2='21' y2='14' stroke='%23142A1E' stroke-width='1.2'/><line x1='11' y1='17' x2='21' y2='17' stroke='%23142A1E' stroke-width='1.2'/><line x1='11' y1='20' x2='17' y2='20' stroke='%23142A1E' stroke-width='1.2'/></svg>">
<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap');

:root {
  --cover:        #0E2118;
  --cover-mid:    #142A1E;
  --cover-deep:   #081410;
  --paper:        #F2E8CE;
  --paper-warm:   #EAD9B0;
  --paper-dark:   #D9C898;
  --paper-line:   #C5AE7A;
  --ink:          #1E1A10;
  --ink-soft:     #4D4635;
  --ink-faint:    #7A7060;
  --gold:         #B98B4E;
  --gold-bright:  #D9AC6C;
  --gold-glow:    rgba(217,172,108,0.35);
  --red:          #8C3328;
  --red-soft:     rgba(140,51,40,0.12);
  --green:        #2D5A38;
  --green-soft:   rgba(45,90,56,0.12);
  --shadow-deep:  rgba(8,20,16,0.55);
  --shadow-card:  rgba(8,20,16,0.30);
  --glass:        rgba(255,255,255,0.04);
  --glass-border: rgba(217,172,108,0.20);
}

*, *::before, *::after { box-sizing: border-box; }
html, body { margin: 0; padding: 0; }

body {
  background-color: var(--cover);
  background-image:
    radial-gradient(ellipse 80% 60% at 10% -10%, rgba(45,90,56,0.50) 0%, transparent 60%),
    radial-gradient(ellipse 60% 50% at 95% 110%, rgba(45,90,56,0.35) 0%, transparent 55%),
    radial-gradient(ellipse 40% 30% at 50% 50%, rgba(185,139,78,0.06) 0%, transparent 70%);
  color: var(--ink);
  font-family: 'Plus Jakarta Sans', sans-serif;
  min-height: 100vh;
  padding: 36px 16px 72px;
  overflow-x: hidden;
}

/* Subtle noise texture overlay */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
  opacity: 0.5;
}

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
}

.wrap { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }

/* ========== HEADER ========== */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 32px;
  padding: 0 4px;
}

.brand {
  display: flex;
  align-items: center;
  gap: 16px;
}

/* --- NEW LOGO --- */
.brand-logo {
  width: 52px;
  height: 52px;
  flex-shrink: 0;
  filter: drop-shadow(0 4px 12px rgba(185,139,78,0.40));
  transition: filter 0.3s ease, transform 0.3s ease;
}
.brand-logo:hover {
  filter: drop-shadow(0 6px 20px rgba(185,139,78,0.65));
  transform: translateY(-2px) rotate(-3deg);
}

.brand-text {}
.brand-title {
  font-family: 'Fraunces', serif;
  font-weight: 700;
  font-optical-sizing: auto;
  font-size: clamp(26px, 4vw, 40px);
  color: var(--paper);
  letter-spacing: 0.3px;
  margin: 0;
  line-height: 1.1;
  background: linear-gradient(135deg, var(--paper) 40%, var(--gold-bright));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.brand-sub {
  font-size: 11px;
  color: var(--gold-bright);
  letter-spacing: 3px;
  text-transform: uppercase;
  margin-top: 5px;
  opacity: 0.85;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.date-stamp {
  font-family: 'JetBrains Mono', monospace;
  font-size: 11.5px;
  color: var(--paper);
  background: var(--glass);
  border: 1px solid var(--glass-border);
  padding: 8px 16px;
  border-radius: 100px;
  letter-spacing: 0.5px;
  backdrop-filter: blur(8px);
  opacity: 0.85;
}

/* ========== STATS STRIP ========== */
.stats-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  margin-bottom: 24px;
}
@media(max-width: 600px) {
  .stats-strip { grid-template-columns: 1fr; }
}
.stat-pill {
  background: var(--glass);
  border: 1px solid var(--glass-border);
  border-radius: 14px;
  padding: 14px 18px;
  backdrop-filter: blur(12px);
  display: flex;
  align-items: center;
  gap: 12px;
  transition: transform 0.2s ease, border-color 0.2s ease;
}
.stat-pill:hover {
  transform: translateY(-2px);
  border-color: var(--gold-bright);
}
.stat-pill-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px;
  flex-shrink: 0;
}
.stat-pill-icon.saldo  { background: rgba(185,139,78,0.18); }
.stat-pill-icon.masuk  { background: rgba(45,90,56,0.22); }
.stat-pill-icon.keluar { background: rgba(140,51,40,0.18); }
.stat-pill-label {
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(242,232,206,0.55);
  margin-bottom: 2px;
}
.stat-pill-value {
  font-family: 'JetBrains Mono', monospace;
  font-weight: 600;
  font-size: 15px;
  color: var(--paper);
  white-space: nowrap;
}
.stat-pill-value.in  { color: #5DB87A; }
.stat-pill-value.out { color: #D4766A; }
.stat-pill-value.neutral { color: var(--gold-bright); }

/* ========== FLASH ========== */
.flash {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(45,90,56,0.20);
  border: 1px solid rgba(93,184,122,0.40);
  color: #A8E6BC;
  padding: 12px 18px;
  border-radius: 12px;
  margin-bottom: 20px;
  font-size: 13.5px;
  animation: fadeFlash 3.5s ease forwards;
}
@keyframes fadeFlash {
  0%   { opacity: 0; transform: translateY(-8px); }
  8%   { opacity: 1; transform: translateY(0); }
  80%  { opacity: 1; }
  100% { opacity: 0; }
}

/* ========== GRID ========== */
.spread {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}
@media(min-width: 940px) {
  .spread { grid-template-columns: 0.82fr 1.18fr; align-items: start; }
}

/* ========== CARD ========== */
.card {
  background: var(--paper);
  border-radius: 18px;
  box-shadow:
    0 24px 48px var(--shadow-deep),
    0 1px 0 rgba(255,255,255,0.55) inset,
    0 -1px 0 rgba(0,0,0,0.08) inset;
  position: relative;
  overflow: hidden;
}
.card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 4px;
  background: linear-gradient(90deg, var(--gold), var(--gold-bright), #EDD08A, var(--gold-bright), var(--gold));
  background-size: 200% 100%;
  animation: shimmerBar 4s linear infinite;
}
@keyframes shimmerBar {
  0%   { background-position: 100% 0; }
  100% { background-position: -100% 0; }
}

/* ========== PASSBOOK (LEFT) ========== */
.passbook { padding: 28px 26px 24px; }

.pb-label {
  font-size: 10px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--ink-faint);
  margin-bottom: 8px;
}

.pb-balance-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}
.pb-balance {
  font-family: 'Fraunces', serif;
  font-weight: 700;
  font-size: clamp(28px, 4vw, 40px);
  color: var(--ink);
  white-space: nowrap;
}

/* Redesigned Seal */
.seal {
  flex-shrink: 0;
  width: 58px; height: 58px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--gold), var(--gold-bright));
  box-shadow: 0 4px 12px rgba(185,139,78,0.45), 0 1px 0 rgba(255,255,255,0.3) inset;
  display: flex; align-items: center; justify-content: center;
  color: var(--cover-deep);
  font-family: 'Fraunces', serif;
  font-weight: 700;
  font-size: 9.5px;
  letter-spacing: 1.5px;
  text-align: center;
  transform: scale(1) rotate(0deg);
  opacity: 1;
  transition: box-shadow 0.3s ease;
}
.seal:hover { box-shadow: 0 6px 20px rgba(185,139,78,0.65), 0 1px 0 rgba(255,255,255,0.3) inset; }
.seal.stamping { animation: stampDown 0.55s cubic-bezier(.2,1.6,.4,1); }
@keyframes stampDown {
  0%   { transform: scale(2.0) rotate(-16deg); opacity: 0; }
  55%  { transform: scale(0.90) rotate(4deg);  opacity: 1; }
  100% { transform: scale(1) rotate(0deg);     opacity: 1; }
}

/* Summary rows */
.pb-summary {
  display: flex;
  flex-direction: column;
  gap: 0;
  border-top: 1px solid var(--paper-line);
  padding-top: 18px;
  margin-bottom: 22px;
}
.pb-summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13.5px;
  padding: 8px 10px;
  border-radius: 8px;
  transition: background 0.15s ease;
}
.pb-summary-row:hover { background: rgba(185,139,78,0.08); }
.pb-summary-row .lbl { color: var(--ink-soft); font-size: 13px; }
.pb-summary-row .lbl-icon { margin-right: 6px; font-size: 13px; }
.pb-summary-row .val {
  font-family: 'JetBrains Mono', monospace;
  font-weight: 600;
  font-size: 13px;
}
.val.in  { color: var(--green); }
.val.out { color: var(--red); }

/* Category bars */
.pb-cats { border-top: 1px solid var(--paper-line); padding-top: 18px; }
.pb-cats-title {
  font-size: 10px;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--ink-faint);
  margin-bottom: 14px;
}
.cat-bar-row { margin-bottom: 12px; }
.cat-bar-head {
  display: flex; justify-content: space-between;
  font-size: 12.5px; margin-bottom: 5px;
}
.cat-bar-head .lbl { color: var(--ink-soft); font-weight: 500; }
.cat-bar-head .amt { font-family: 'JetBrains Mono', monospace; color: var(--ink-faint); font-size: 12px; }
.cat-bar-track {
  height: 7px;
  background: var(--paper-dark);
  border-radius: 100px;
  overflow: hidden;
}
.cat-bar-fill {
  height: 100%;
  border-radius: 100px;
  width: 0%;
  transition: width 0.8s cubic-bezier(.2,.9,.3,1);
}
.pb-empty-cats {
  font-size: 13px;
  color: var(--ink-faint);
  font-style: italic;
  text-align: center;
  padding: 12px 0;
}

/* ========== LEDGER (RIGHT) ========== */
.ledger { padding: 28px 26px 22px; }
.ledger-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 18px;
}
.ledger-icon {
  width: 32px; height: 32px;
  background: linear-gradient(135deg, var(--cover-mid), var(--cover));
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px;
  box-shadow: 0 2px 8px var(--shadow-card);
  flex-shrink: 0;
}
.ledger-title {
  font-family: 'Fraunces', serif;
  font-weight: 600;
  font-size: 19px;
  margin: 0;
  color: var(--ink);
}

/* Form */
.entry-form {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin-bottom: 22px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--paper-line);
}
.entry-form .full { grid-column: 1/-1; }

.field label {
  display: block;
  font-size: 10px;
  letter-spacing: 1.8px;
  text-transform: uppercase;
  color: var(--ink-faint);
  margin-bottom: 5px;
  font-weight: 600;
}
.field input, .field select {
  width: 100%;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13.5px;
  padding: 9px 12px;
  border: 1.5px solid var(--paper-dark);
  border-radius: 9px;
  background: rgba(255,255,255,0.55);
  color: var(--ink);
  outline: none;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}
.field input:focus, .field select:focus {
  border-color: var(--gold);
  background: rgba(255,255,255,0.85);
  box-shadow: 0 0 0 3px rgba(185,139,78,0.18);
}
.field .error {
  font-size: 11px;
  color: var(--red);
  margin-top: 4px;
}

/* Type toggle */
.type-toggle { display: flex; gap: 8px; }
.type-btn {
  flex: 1;
  padding: 10px 8px;
  border-radius: 9px;
  border: 1.5px solid var(--paper-dark);
  background: rgba(255,255,255,0.45);
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  color: var(--ink-soft);
  transition: all 0.18s ease;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.type-btn:hover { background: rgba(255,255,255,0.70); }
.type-btn.active[data-type="masuk"]  {
  background: var(--green);
  border-color: var(--green);
  color: #fff;
  box-shadow: 0 4px 12px rgba(45,90,56,0.35);
}
.type-btn.active[data-type="keluar"] {
  background: var(--red);
  border-color: var(--red);
  color: #fff;
  box-shadow: 0 4px 12px rgba(140,51,40,0.35);
}

/* Submit */
.submit-btn {
  grid-column: 1/-1;
  margin-top: 4px;
  padding: 12px;
  border: none;
  border-radius: 10px;
  background: linear-gradient(135deg, #1B3D2A, var(--cover-mid));
  color: var(--paper);
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700;
  font-size: 13.5px;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  box-shadow: 0 4px 14px var(--shadow-card);
  display: flex; align-items: center; justify-content: center; gap: 8px;
}
.submit-btn:hover  { box-shadow: 0 6px 20px var(--shadow-deep); transform: translateY(-2px); }
.submit-btn:active { transform: translateY(0); box-shadow: 0 2px 8px var(--shadow-card); }

/* Filter tabs */
.filter-tabs { display: flex; gap: 6px; margin-bottom: 16px; flex-wrap: wrap; }
.filter-tab {
  padding: 6px 14px;
  border-radius: 100px;
  border: 1.5px solid var(--paper-line);
  background: transparent;
  font-size: 12px;
  font-weight: 600;
  color: var(--ink-soft);
  cursor: pointer;
  font-family: 'Plus Jakarta Sans', sans-serif;
  text-decoration: none;
  display: inline-flex; align-items: center; gap: 5px;
  transition: all 0.18s ease;
  letter-spacing: 0.3px;
}
.filter-tab.active {
  background: var(--gold);
  border-color: var(--gold);
  color: #fff;
  box-shadow: 0 3px 10px rgba(185,139,78,0.35);
}
.filter-tab:hover:not(.active) { background: rgba(185,139,78,0.12); border-color: var(--gold); color: var(--ink); }

/* Entries list */
.entries {
  display: flex;
  flex-direction: column;
  max-height: 490px;
  overflow-y: auto;
  padding-right: 2px;
}
.entries::-webkit-scrollbar { width: 5px; }
.entries::-webkit-scrollbar-thumb { background: var(--paper-line); border-radius: 10px; }

.entry-row {
  display: grid;
  grid-template-columns: 52px 1fr auto auto;
  align-items: center;
  gap: 12px;
  padding: 10px 8px;
  border-radius: 10px;
  margin-bottom: 3px;
  animation: writeIn 0.35s cubic-bezier(.2,.8,.3,1);
  transition: background 0.15s ease;
}
@keyframes writeIn {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}
.entry-row:hover { background: rgba(185,139,78,0.09); }

.entry-date-badge {
  background: linear-gradient(135deg, var(--paper-warm), var(--paper-dark));
  border-radius: 8px;
  width: 48px; height: 48px;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  text-align: center;
  border: 1px solid var(--paper-line);
}
.entry-date-d  { font-family: 'Fraunces', serif; font-weight: 700; font-size: 16px; color: var(--ink); line-height: 1; }
.entry-date-m  { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ink-faint); margin-top: 1px; }
.entry-date-y  { font-family: 'JetBrains Mono', monospace; font-size: 9px; color: var(--ink-faint); }

.entry-mid { min-width: 0; }
.entry-desc { font-size: 13.5px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--ink); }
.entry-cat  { font-size: 11px; color: var(--ink-faint); text-transform: uppercase; letter-spacing: 0.7px; margin-top: 2px; font-weight: 500; }

.entry-amt {
  font-family: 'JetBrains Mono', monospace;
  font-weight: 700;
  font-size: 13.5px;
  white-space: nowrap;
  padding: 4px 8px;
  border-radius: 7px;
}
.entry-amt.in  { color: var(--green); background: var(--green-soft); }
.entry-amt.out { color: var(--red);   background: var(--red-soft); }

.entry-del {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--ink-faint);
  font-size: 14px;
  opacity: 0.45;
  padding: 6px;
  line-height: 1;
  border-radius: 6px;
  transition: all 0.15s ease;
  display: flex; align-items: center; justify-content: center;
}
.entry-del:hover { opacity: 1; color: var(--red); background: var(--red-soft); }

/* Empty state */
.empty-state { text-align: center; padding: 44px 10px; color: var(--ink-soft); }
.empty-state-icon {
  width: 64px; height: 64px;
  margin: 0 auto 14px;
  background: var(--paper-warm);
  border: 1.5px solid var(--paper-line);
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px;
}
.empty-state .t1 { font-family: 'Fraunces', serif; font-size: 17px; color: var(--ink); margin-bottom: 5px; font-weight: 600; }
.empty-state .t2 { font-size: 13px; color: var(--ink-faint); line-height: 1.5; }

/* Footer */
.footer-note {
  text-align: center;
  margin-top: 28px;
  font-size: 11px;
  color: rgba(242,232,206,0.30);
  letter-spacing: 1px;
  text-transform: uppercase;
  display: flex; align-items: center; justify-content: center; gap: 8px;
}
.footer-note::before, .footer-note::after { content: '·'; }
</style>
@stack('styles')
</head>
<body>

<div class="wrap">
  @yield('content')
  <p class="footer-note">Dicatat dan disimpan langsung di buku ini &nbsp; tidak dibagikan ke siapa pun</p>
</div>

@stack('scripts')
</body>
</html>
