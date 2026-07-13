@extends('layouts.app')

@section('title', 'Buku Kas — Catatan Keuangan')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="header">
  <div class="brand">
    {{-- Custom SVG Logo --}}
    <svg class="brand-logo" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="bgGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#1B3D2A"/>
          <stop offset="100%" stop-color="#0E2118"/>
        </linearGradient>
        <linearGradient id="pageGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#F2E8CE"/>
          <stop offset="100%" stop-color="#DDD0A6"/>
        </linearGradient>
        <linearGradient id="foldGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#D9AC6C"/>
          <stop offset="100%" stop-color="#B98B4E"/>
        </linearGradient>
        <linearGradient id="coinGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#EDD08A"/>
          <stop offset="100%" stop-color="#B98B4E"/>
        </linearGradient>
      </defs>
      {{-- Book cover --}}
      <rect width="52" height="52" rx="12" fill="url(#bgGrad)"/>
      {{-- Spine line --}}
      <rect x="13" y="8" width="3" height="36" rx="1.5" fill="rgba(255,255,255,0.12)"/>
      {{-- Book pages --}}
      <rect x="16" y="8" width="24" height="32" rx="3" fill="url(#pageGrad)"/>
      {{-- Fold corner --}}
      <path d="M34 8 L40 8 L40 16 Z" fill="url(#foldGrad)" opacity="0.85"/>
      <path d="M34 8 L40 16 L34 16 Z" fill="rgba(0,0,0,0.12)"/>
      {{-- Coin --}}
      <circle cx="27" cy="38" r="9" fill="url(#coinGrad)" opacity="0.95"/>
      <circle cx="27" cy="38" r="7" fill="none" stroke="rgba(255,255,255,0.30)" stroke-width="1"/>
      <text x="27" y="42" text-anchor="middle" font-family="serif" font-weight="700" font-size="9" fill="#0E2118">Rp</text>
      {{-- Lines on page --}}
      <line x1="20" y1="14" x2="32" y2="14" stroke="#C5AE7A" stroke-width="1.2" stroke-linecap="round"/>
      <line x1="20" y1="18" x2="32" y2="18" stroke="#C5AE7A" stroke-width="1.2" stroke-linecap="round"/>
      <line x1="20" y1="22" x2="27" y2="22" stroke="#C5AE7A" stroke-width="1.2" stroke-linecap="round"/>
    </svg>

    <div class="brand-text">
      <p class="brand-title">Buku Kas</p>
      <p class="brand-sub">Catatan Keuangan Pribadi</p>
    </div>
  </div>

  <div class="header-right">
    <div class="date-stamp" id="dateStamp">—</div>
  </div>
</div>

{{-- ===== STATS STRIP ===== --}}
<div class="stats-strip">
  <div class="stat-pill">
    <div class="stat-pill-icon saldo">💰</div>
    <div>
      <div class="stat-pill-label">Saldo</div>
      <div class="stat-pill-value neutral" id="saldoNum" data-saldo="{{ $saldo }}">
        {{ 'Rp' . number_format($saldo, 0, ',', '.') }}
      </div>
    </div>
  </div>
  <div class="stat-pill">
    <div class="stat-pill-icon masuk">📈</div>
    <div>
      <div class="stat-pill-label">Pemasukan</div>
      <div class="stat-pill-value in">{{ 'Rp' . number_format($masuk, 0, ',', '.') }}</div>
    </div>
  </div>
  <div class="stat-pill">
    <div class="stat-pill-icon keluar">📉</div>
    <div>
      <div class="stat-pill-label">Pengeluaran</div>
      <div class="stat-pill-value out">{{ 'Rp' . number_format($keluar, 0, ',', '.') }}</div>
    </div>
  </div>
</div>

@if(session('stamped'))
  <div class="flash" id="flashMsg">
    <span>✅</span> Transaksi berhasil dicatat ke buku kas.
  </div>
@endif

<div class="spread">

  {{-- ===== PASSBOOK (KIRI) ===== --}}
  <div class="card passbook">
    <div class="pb-label">Saldo Bersih</div>
    <div class="pb-balance-row">
      <div class="pb-balance">{{ 'Rp' . number_format($saldo, 0, ',', '.') }}</div>
      <div class="seal {{ session('stamped') ? 'stamping' : '' }}" id="seal">SAH</div>
    </div>

    <div class="pb-summary">
      <div class="pb-summary-row">
        <span class="lbl"><span class="lbl-icon">📥</span>Pemasukan</span>
        <span class="val in">{{ 'Rp' . number_format($masuk, 0, ',', '.') }}</span>
      </div>
      <div class="pb-summary-row">
        <span class="lbl"><span class="lbl-icon">📤</span>Pengeluaran</span>
        <span class="val out">{{ 'Rp' . number_format($keluar, 0, ',', '.') }}</span>
      </div>
    </div>

    <div class="pb-cats">
      <div class="pb-cats-title">Kategori Pengeluaran Teratas</div>
      @if($catBreak->isNotEmpty())
        @foreach($catBreak as $cat)
          <div class="cat-bar-row">
            <div class="cat-bar-head">
              <span class="lbl">{{ $cat['cat'] }}</span>
              <span class="amt">{{ 'Rp' . number_format($cat['amt'], 0, ',', '.') }}</span>
            </div>
            <div class="cat-bar-track">
              <div class="cat-bar-fill"
                   data-width="{{ $maxCat > 0 ? max(6, ($cat['amt'] / $maxCat) * 100) : 6 }}"
                   style="background:{{ $cat['color'] }}; width:0%">
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="pb-empty-cats">Belum ada pengeluaran tercatat.</div>
      @endif
    </div>
  </div>

  {{-- ===== LEDGER (KANAN) ===== --}}
  <div class="card ledger">
    <div class="ledger-header">
      <div class="ledger-icon">📝</div>
      <h2 class="ledger-title">Catat Transaksi</h2>
    </div>

    <form class="entry-form" id="entryForm" method="POST" action="{{ route('transactions.store') }}">
      @csrf

      {{-- Type toggle --}}
      <div class="full type-toggle">
        <button type="button"
                class="type-btn {{ old('type', 'keluar') === 'keluar' ? 'active' : '' }}"
                data-type="keluar" id="btnKeluar">
          <span>📤</span> Pengeluaran
        </button>
        <button type="button"
                class="type-btn {{ old('type', 'keluar') === 'masuk' ? 'active' : '' }}"
                data-type="masuk" id="btnMasuk">
          <span>📥</span> Pemasukan
        </button>
        <input type="hidden" name="type" id="typeInput" value="{{ old('type', 'keluar') }}">
      </div>

      {{-- Tanggal --}}
      <div class="field">
        <label for="fDate">Tanggal</label>
        <input type="date" id="fDate" name="date"
               value="{{ old('date', date('Y-m-d')) }}" required>
        @error('date')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Kategori --}}
      <div class="field">
        <label for="fCategory">Kategori</label>
        <select id="fCategory" name="category"></select>
        @error('category')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Keterangan --}}
      <div class="field full">
        <label for="fDesc">Keterangan</label>
        <input type="text" id="fDesc" name="description"
               value="{{ old('description') }}"
               placeholder="mis. Makan siang di kantin" maxlength="60">
        @error('description')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Jumlah --}}
      <div class="field full">
        <label for="fAmount">Jumlah (Rp)</label>
        <input type="number" id="fAmount" name="amount"
               value="{{ old('amount') }}"
               placeholder="0" min="1" step="1" required>
        @error('amount')<div class="error">{{ $message }}</div>@enderror
      </div>

      <button type="submit" class="submit-btn">
        <span>✚</span> Tambahkan ke Buku Kas
      </button>
    </form>

    {{-- Filter Tabs --}}
    <div class="filter-tabs">
      <a href="{{ route('transactions.index', ['filter' => 'semua']) }}"
         class="filter-tab {{ $filter === 'semua' ? 'active' : '' }}">
        📋 Semua
      </a>
      <a href="{{ route('transactions.index', ['filter' => 'masuk']) }}"
         class="filter-tab {{ $filter === 'masuk' ? 'active' : '' }}">
        📥 Pemasukan
      </a>
      <a href="{{ route('transactions.index', ['filter' => 'keluar']) }}"
         class="filter-tab {{ $filter === 'keluar' ? 'active' : '' }}">
        📤 Pengeluaran
      </a>
    </div>

    {{-- Entries List --}}
    <div class="entries" id="entriesList">
      @if($transactions->isEmpty())
        <div class="empty-state">
          <div class="empty-state-icon">📒</div>
          <div class="t1">Buku ini masih kosong</div>
          <div class="t2">Catat transaksi pertamamu<br>lewat formulir di atas.</div>
        </div>
      @else
        @foreach($transactions as $t)
          <div class="entry-row" id="row-{{ $t->id }}">
            <div class="entry-date-badge">
              <div class="entry-date-d">{{ \Carbon\Carbon::parse($t->date)->format('d') }}</div>
              <div class="entry-date-m">{{ \Carbon\Carbon::parse($t->date)->translatedFormat('M') }}</div>
              <div class="entry-date-y">{{ \Carbon\Carbon::parse($t->date)->format('Y') }}</div>
            </div>
            <div class="entry-mid">
              <div class="entry-desc">{{ $t->description ?: $t->category }}</div>
              <div class="entry-cat">{{ $t->category }}</div>
            </div>
            <div class="entry-amt {{ $t->type === 'masuk' ? 'in' : 'out' }}">
              {{ $t->type === 'masuk' ? '+' : '−' }} {{ $t->formattedAmount() }}
            </div>
            <form method="POST"
                  action="{{ route('transactions.destroy', $t->id) }}"
                  onsubmit="return confirmDelete(event, {{ $t->id }})">
              @csrf
              @method('DELETE')
              <button type="submit" class="entry-del" title="Hapus" aria-label="Hapus transaksi">✕</button>
            </form>
          </div>
        @endforeach
      @endif
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script>
(function(){
  const CAT_MASUK  = ["Gaji","Bonus","Hadiah","Usaha Sampingan","Lainnya"];
  const CAT_KELUAR = ["Makanan","Transportasi","Belanja","Tagihan","Hiburan","Kesehatan","Pendidikan","Lainnya"];

  // ---- Date stamp ----
  const dateStamp = document.getElementById('dateStamp');
  if(dateStamp){
    dateStamp.textContent = new Date().toLocaleDateString('id-ID', {
      weekday:'long', day:'numeric', month:'long', year:'numeric'
    });
  }

  // ---- Type toggle ----
  const typeInput = document.getElementById('typeInput');
  const btnKeluar = document.getElementById('btnKeluar');
  const btnMasuk  = document.getElementById('btnMasuk');
  const catSelect = document.getElementById('fCategory');
  const oldType   = typeInput ? typeInput.value : 'keluar';
  const oldCat    = "{{ old('category', '') }}";

  function populateCats(type){
    if(!catSelect) return;
    const cats = type === 'masuk' ? CAT_MASUK : CAT_KELUAR;
    catSelect.innerHTML = cats.map(c =>
      `<option value="${c}"${oldCat === c ? ' selected' : ''}>${c}</option>`
    ).join('');
  }

  function setType(type){
    if(!typeInput) return;
    typeInput.value = type;
    btnKeluar.classList.toggle('active', type === 'keluar');
    btnMasuk.classList.toggle('active',  type === 'masuk');
    populateCats(type);
  }

  if(btnKeluar) btnKeluar.addEventListener('click', () => setType('keluar'));
  if(btnMasuk)  btnMasuk.addEventListener('click',  () => setType('masuk'));
  setType(oldType);

  // ---- Animate category bars ----
  setTimeout(() => {
    document.querySelectorAll('.cat-bar-fill').forEach(el => {
      const w = el.dataset.width;
      if(w) el.style.width = w + '%';
    });
  }, 100);

  // ---- Animate balance count-up (stats strip) ----
  const saldoEl = document.getElementById('saldoNum');
  if(saldoEl){
    const target = parseFloat(saldoEl.dataset.saldo) || 0;
    const start  = performance.now();
    const dur    = 750;
    function step(now){
      const p     = Math.min((now - start) / dur, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      const val   = target * eased;
      saldoEl.textContent = 'Rp' + Math.round(val).toLocaleString('id-ID');
      if(p < 1) requestAnimationFrame(step);
      else saldoEl.textContent = 'Rp' + Math.round(target).toLocaleString('id-ID');
    }
    requestAnimationFrame(step);
  }

  // ---- Stamp animation ----
  const seal = document.getElementById('seal');
  if(seal && seal.classList.contains('stamping')){
    void seal.offsetWidth;
  }

  // ---- Delete animation ----
  window.confirmDelete = function(e, id){
    e.preventDefault();
    const row = document.getElementById('row-' + id);
    if(!row) return true;
    row.style.transition = 'opacity 0.30s ease, transform 0.30s ease, max-height 0.35s ease, padding 0.35s ease, margin 0.35s ease';
    row.style.opacity    = '0';
    row.style.transform  = 'translateX(16px)';
    row.style.overflow   = 'hidden';
    row.style.maxHeight  = row.offsetHeight + 'px';
    setTimeout(() => { row.style.maxHeight = '0'; row.style.padding = '0'; row.style.margin = '0'; }, 60);
    setTimeout(() => { e.target.closest('form').submit(); }, 380);
    return false;
  };

  // ---- Auto-hide flash ----
  const flash = document.getElementById('flashMsg');
  if(flash){ setTimeout(() => flash.remove(), 3600); }

})();
</script>
@endpush
