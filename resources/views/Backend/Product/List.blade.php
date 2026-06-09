@extends('Backend.Layout.App')

@section('content')
<div class="main-content products-page">
  <header class="page-head">
    <div class="ph-left">
      <div class="badge"><i class="fas fa-boxes-stacked"></i> Products</div>
      <h1>Products Overview</h1>
      <p class="muted">
        Manage products, prices & stock •
        <span class="chip ghost">
          <i class="fas fa-calendar-week"></i>
          {{ $rangeLabel }} ({{ $from }} → {{ $to }})
        </span>
      </p>
    </div>
    <div class="ph-right">
      <span class="profile-username"><span class="fw-bold">{{ Auth::user()->name }}</span></span>
      <div class="avatar-sm">
        <img src="{{ asset('User/' . Auth::user()->image) }}" alt="avatar" class="avatar-img rounded-circle"/>
      </div>
    </div>
  </header>

  @if(session('success'))
    <div class="alert success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <section class="panel">
    <div class="panel-body">
      <form method="GET" action="{{ route('list.product') }}" class="toolbar" id="filtersForm">
        <div class="input-wrap">
          <i class="fas fa-magnifying-glass"></i>
          <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search customer, product name or memo…">
        </div>

        <select name="period" id="period" class="select" onchange="toggleCustomDates(this); this.form.submit()">
          <option value="this_week" {{ $period==='this_week' ? 'selected' : '' }}>This Week</option>
          <option value="last_week" {{ $period==='last_week' ? 'selected' : '' }}>Last Week</option>
          <option value="custom"    {{ $period==='custom' ? 'selected' : '' }}>Custom</option>
        </select>

        <input type="date" name="from" id="from" value="{{ $from }}" {{ $period==='custom' ? '' : 'disabled' }}>
        <input type="date" name="to"   id="to"   value="{{ $to }}"   {{ $period==='custom' ? '' : 'disabled' }}>

        <button class="btn light" type="submit"><i class="fas fa-filter-circle-dollar"></i> Apply</button>
        <a href="{{ route('list.product') }}" class="btn ghost">Clear</a>

        <div style="margin-left:auto; display:flex; gap:8px; flex-wrap:wrap">
          <button type="button" class="btn primary" id="btnExportPdf">
            <i class="fas fa-file-pdf"></i> Export PDF
          </button>
          <button type="button" class="btn light" id="btnExportExcel">
            <i class="fas fa-file-excel"></i> Export Excel
          </button>
        </div>
      </form>

      @php
        $wowUp   = $wowAbs >= 0;
        $wowCls  = $wowUp ? 'badge-up' : 'badge-down';
        $wowIcon = $wowUp ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
        $wowTxt  = ($wowUp ? '+' : '').number_format($wowPct, 2).' %';
      @endphp

      <div class="stats">
        <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-calendar-week"></i></div>
          <div>
            <div class="kpi__label">This Week ({{ $thisWeekLabel }})</div>
            <div class="kpi__val">${{ number_format($thisWeekRevenue, 2) }}</div>
          </div>
        </div>
        <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-arrow-rotate-left"></i></div>
          <div>
            <div class="kpi__label">Last Week ({{ $lastWeekLabel }})</div>
            <div class="kpi__val">${{ number_format($lastWeekRevenue, 2) }}</div>
          </div>
        </div>
        <div class="kpi">
          <div class="kpi__icon"><i class="fas {{ $wowIcon }}"></i></div>
          <div>
            <div class="kpi__label">WoW Change</div>
            <div class="kpi__val">
              <span class="wow {{ $wowCls }}">{{ $wowTxt }}</span>
              <small class="muted" style="margin-left:6px;">(${{ number_format($wowAbs, 2) }})</small>
            </div>
          </div>
        </div>
      </div>

      <div class="stats">
        <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-sack-dollar"></i></div>
          <div>
            <div class="kpi__label">Total Revenue</div>
            <div class="kpi__val">${{ number_format($totalRevenue,2) }}</div>
          </div>
        </div>
          <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-cubes"></i></div>
          <div>
            <div class="kpi__label">Total of Products</div>
            <div class="kpi__val">{{ number_format($totalProductsQty) }}</div>
          </div>
        </div>
        <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-layer-group"></i></div>
          <div>
            <div class="kpi__label">Total Quantity (Top)</div>
            <div class="kpi__val">{{ number_format($totalQty) }}</div>
          </div>
        </div>
      
        <div class="kpi">
          <div class="kpi__icon"><i class="fas fa-ranking-star"></i></div>
          <div>
            <div class="kpi__label">Top Products</div>
            <div class="kpi__val">{{ $topProducts->count() }}</div>
          </div>
        </div>
      </div>

      <div class="panel soft">
        <div class="panel-head"><h3><i class="fas fa-trophy"></i> Top & Repeat of Products </h3></div>
        <div class="panel-body">
          <div class="table-wrap">
            <table class="table compact" id="tbl-top-products">
              <thead>
                <tr>
                  <th>Repeat ID</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Revenue</th>
                  <th>Percentage</th>
                </tr>
              </thead>
              @php
                $repeatOnly = $topProducts->filter(fn($row) => (int)$row->qty_sum >= 2);
              @endphp
              <tbody>
                @forelse($repeatOnly as $row)
                  <tr>
                    <td>RID{{ $loop->iteration }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ number_format($row->qty_sum) }}</td>
                    <td>${{ number_format($row->revenue,2) }}</td>
                    <td>{{ number_format($row->percent,2) }}%</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="ta-center muted">No data in this range.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="panel-head">
        <h2><i class="fas fa-filter"></i> Filters</h2>
        <a href="{{ route('add.product') }}" class="btn primary"><i class="fas fa-plus"></i> Add Product</a>
      </div>

      <div class="table-wrap">
        <table class="table" id="tbl-products">
          <thead>
            <tr>
              <th>P-ID</th>
              <th>Customer Information</th>
              <th>Name</th>
              <th class="ta-right">Qty</th>
              <th class="ta-right">Price</th>
              <th class="ta-right">Total</th>
              <th>Memo</th>
              <th>Created</th>
              <th class="ta-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $p)
              <tr>
                <td>PID{{ $p->id }}</td>
                <td class="name"><span class="name__text">{{ $p->customer }}</span></td>
                <td>{{ $p->name }}</td>
                <td class="ta-right">{{ (int) $p->qty }}</td>
                <td class="ta-right">${{ number_format((float)$p->price,2) }}</td>
                <td class="ta-right strong">${{ number_format((float)$p->total,2) }}</td>
                <td class="muted">{{ $p->memo }}</td>
                <td>{{ optional($p->created_at)->format('Y-m-d') }}</td>
                <td class="ta-right actions">
                  <a href="{{ route('select.product',$p->id) }}" class="btn tiny"><i class="fas fa-pen-to-square"></i> Edit</a>
                  <form action="{{ route('delete.product', $p) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn tiny danger"><i class="fas fa-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="9" class="ta-center muted">No products found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Laravel pagination --}}
      <div class="pagination-wrap">
        {{ $products->links() }}
      </div>

    </div>
  </section>
</div>

<style>
  .wow.badge-up{background:rgba(22,163,74,.1); color:#16a34a; border:1px solid rgba(22,163,74,.25); padding:2px 8px; border-radius:999px; font-weight:700}
  .wow.badge-down{background:rgba(239,68,68,.1); color:#ef4444; border:1px solid rgba(239,68,68,.25); padding:2px 8px; border-radius:999px; font-weight:700}
  :root{
    --bg:#f6f7fb; --panel:#ffffff; --ink:#0b1324; --muted:#6b7280; --line:#e6e9f2;
    --primary:#701573; --primary-600:#5c115f; --accent:#d434bc; --ok:#16a34a; --danger:#ef4444;
    --shadow:0 10px 28px rgba(2,6,23,.06); --shadow-lg:0 18px 42px rgba(2,6,23,.12);
    --r1:14px; --r2:18px; --anim:.22s cubic-bezier(.2,.7,.2,1);
  }
  .products-page{background:var(--bg); padding:18px}
  .page-head{display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px}
  .page-head .badge{display:inline-flex; gap:8px; align-items:center; background:#faf5ff; color:var(--primary); border:1px dashed var(--line); padding:6px 10px; border-radius:999px; font-weight:600}
  .page-head h1{margin:6px 0 4px 0; font-size:22px; color:var(--ink)}
  .page-head .muted{color:var(--muted)}
  .ph-right{display:flex; gap:10px; align-items:center}
  .panel{background:var(--panel); border:1px solid var(--line); border-radius:var(--r2); box-shadow:var(--shadow); margin:8px 0}
  .panel.soft{margin-top:18px}
  .panel-head{display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-bottom:1px solid var(--line)}
  .panel-head h2, .panel-head h3{margin:0; font-size:18px; color:var(--ink)}
  .panel-body{padding:14px 16px}
  .toolbar{display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:14px}
  .input-wrap{display:flex; align-items:center; gap:8px; padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:#fff; min-width:240px}
  .input-wrap input{border:0; outline:0; width:220px}
  .select, .toolbar input[type="date"]{padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:#fff}
  .btn{display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px; border:1px solid transparent; cursor:pointer; transition:transform var(--anim), box-shadow var(--anim); font-weight:600}
  .btn:hover{transform:translateY(-1px); box-shadow:var(--shadow)}
  .btn.primary{background:linear-gradient(135deg, var(--primary), var(--accent)); color:#fff}
  .btn.light{background:#f7f7f9; color:#0b1324; border-color:var(--line)}
  .btn.ghost{background:#fff; color:#6b7280; border-color:var(--line)}
  .btn.tiny{padding:8px 10px; border-radius:8px}
  .btn.danger{background:var(--danger); color:#fff}
  .chip{display:inline-flex; gap:6px; align-items:center; padding:4px 8px; border-radius:999px; background:#faf7fb; color:#701573; border:1px solid var(--line); font-size:12px}
  .chip.ghost{background:#fff}
  .kpi{display:flex; gap:10px; align-items:center; background:#fff; border:1px solid var(--line); border-radius:14px; padding:12px 14px; box-shadow:var(--shadow)}
  .kpi__icon{width:38px; height:38px; display:grid; place-items:center; background:#faf5ff; color:#701573; border-radius:10px}
  .kpi__label{font-size:12px; color:#6b7280}
  .kpi__val{font-size:20px; font-weight:800; color:#701573}
  .stats{display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:12px; margin:8px 0 16px}
  .table-wrap{overflow:auto; border:1px solid var(--line); border-radius:14px}
  .table{width:100%; border-collapse:separate; border-spacing:0}
  .table thead th{position:sticky; top:0; background:#fbf7fc; color:#5c115f; padding:11px 12px; border-bottom:1px solid var(--line); text-align:left}
  .table.compact thead th{background:#fbfbfc}
  .table tbody td{padding:11px 12px; border-bottom:1px solid #f2f3f7; vertical-align:middle}
  .table tbody tr:hover{background:#fbfbfc}
  .ta-right{text-align:right}
  .ta-center{text-align:center}
  .name{display:flex; align-items:center; gap:8px}
  .strong{font-weight:700; color:#5c115f}
  .actions{display:flex; justify-content:flex-end; gap:8px}
  .inline{display:inline}
  .alert{padding:10px 12px; border-radius:12px; border:1px solid #cfe8d9; background:#eaf7f0; color:#0a6b3c; margin:10px 0}

  /* ===== Pagination style for Laravel's {{ $products->links() }} ===== */
  .pagination-wrap{
    margin-top:16px;
    display:flex;
    justify-content:flex-end;
  }
  .pagination-wrap nav{
    display:flex;
    gap:6px;
    background:#fff;
    border:1px solid rgba(112,21,115,.12);
    border-radius:999px;
    padding:4px 6px;
    box-shadow:0 10px 25px rgba(0,0,0,.02);
  }
  .pagination-wrap nav .hidden{
    display:none; /* hide "showing x to y of z" when Laravel outputs it */
  }
  .pagination-wrap nav a,
  .pagination-wrap nav span{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:34px;
    height:32px;
    padding:0 12px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
    color:#5c115f;
    text-decoration:none;
    transition:.15s ease;
  }
  .pagination-wrap nav a:hover{
    background:rgba(112,21,115,.06);
  }
  .pagination-wrap nav .active > span,
  .pagination-wrap nav span[aria-current="page"]{
    background:linear-gradient(135deg,#701573,#d434bc);
    color:#fff;
    box-shadow:0 12px 25px rgba(112,21,115,.35);
  }
  @media (max-width:900px){
    .table thead{display:none}
    .table tbody tr{display:grid; grid-template-columns:1fr 1fr; gap:6px; padding:10px}
    .table tbody td{border:0; padding:4px 0}
    .table tbody td.ta-right{text-align:left}
    .table tbody td:last-child{grid-column:1/-1}
    .pagination-wrap{justify-content:center;}
    .pagination-wrap nav{flex-wrap:wrap; justify-content:center;}
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" crossorigin="anonymous"></script>

<script>
  function toggleCustomDates(sel){
    const isCustom = sel.value === 'custom';
    document.getElementById('from').disabled = !isCustom;
    document.getElementById('to').disabled   = !isCustom;
  }
  document.addEventListener('DOMContentLoaded', () => {
    toggleCustomDates(document.getElementById('period'));

    const btnPdf   = document.getElementById('btnExportPdf');
    const btnExcel = document.getElementById('btnExportExcel');

    function currentStamp() {
      const period = document.getElementById('period')?.value || 'this_week';
      return `${period}-{{ $from }}_to_{{ $to }}`.replace(/\s+/g,'_');
    }

    if (btnPdf) btnPdf.addEventListener('click', () => {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF({ unit: 'pt', format: 'a4' });

      doc.setFontSize(13);
      doc.text('Products Overview', 40, 40);

      doc.setFontSize(11);
      if (document.querySelector('#tbl-top-products thead')) {
        doc.text('Top Products (by revenue)', 40, 70);
        doc.autoTable({
          html: '#tbl-top-products',
          startY: 80,
          styles: { fontSize: 9, cellPadding: 4 },
          headStyles: { fillColor: [112,21,115] }
        });
      }

      const afterTop = (doc.lastAutoTable && doc.lastAutoTable.finalY ? doc.lastAutoTable.finalY : 70) + 24;
      doc.text('Products', 40, afterTop);
      doc.autoTable({
        html: '#tbl-products',
        startY: afterTop + 10,
        styles: { fontSize: 9, cellPadding: 4 },
        headStyles: { fillColor: [112,21,115] },
        didParseCell: (data) => {
          if (data.section === 'body') {
            const lastIdx = data.table.columns.length - 1;
            if (data.column.index === lastIdx) data.cell.text = [''];
          }
        }
      });

      doc.save(`Products-${currentStamp()}.pdf`);
    });

    if (btnExcel) btnExcel.addEventListener('click', () => {
      if (!window.XLSX) return alert('Excel library failed to load.');
      const wb = XLSX.utils.book_new();

      const topEl = document.getElementById('tbl-top-products');
      if (topEl && topEl.querySelector('thead')) {
        const wsTop  = XLSX.utils.table_to_sheet(topEl, { raw: true });
        XLSX.utils.book_append_sheet(wb, wsTop,  'TopProducts');
      }

      const prodEl = document.getElementById('tbl-products');
      if (!prodEl) return alert('Products table not found.');
      const wsProd = XLSX.utils.table_to_sheet(prodEl, { raw: true });

      const rangeProd = XLSX.utils.decode_range(wsProd['!ref']);
      const lastCol = rangeProd.e.c;
      for (let r = rangeProd.s.r; r <= rangeProd.e.r; r++) {
        const addr = XLSX.utils.encode_cell({ r, c: lastCol });
        if (wsProd[addr]) delete wsProd[addr];
      }
      rangeProd.e.c = lastCol - 1;
      wsProd['!ref'] = XLSX.utils.encode_range(rangeProd);

      XLSX.utils.book_append_sheet(wb, wsProd, 'Products');
      XLSX.writeFile(wb, `Products-${currentStamp()}.xlsx`);
    });
  });
</script>
@endsection
