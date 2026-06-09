@extends('Backend.Layout.App')

@section('content')
<div class="main-content bc-page">
  {{-- ===== Header ===== --}}
  <header class="bc-head glass">
    <div class="bc-head__left">
      <div>
        <h1>Booking & Contact Overview</h1>
        <p>Filter by date • totals • compare booking vs contact</p>
        <span class="chip ghost">
          <i class="fas fa-calendar-week"></i>
          Range: {{ $rangeLabel ?? '—' }}
        </span>
      </div>
    </div>
    <div class="bc-head__right">
      <a href="{{ route('bookingandcontact.add') }}" class="btn btn-primary lift-sm">
        <i class="fas fa-plus"></i> Add New
      </a>
    </div>
  </header>

  {{-- ===== Filters ===== --}}
  <section class="bc-filters glass">
    <form method="GET" class="bc-filters__form">
      <div class="field">
        <label>Search</label>
        <input type="text" name="q" value="{{ $q }}" placeholder="Search note / value..." />
      </div>

      <div class="field">
        <label>Period</label>
        <select name="period" id="periodSelect">
          <option value="this_week" {{ $period === 'this_week' ? 'selected' : '' }}>This week</option>
          <option value="last_week" {{ $period === 'last_week' ? 'selected' : '' }}>Last week</option>
          <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
      </div>

      <div class="field custom-range {{ $period === 'custom' ? '' : 'hidden' }}" id="customRangeBox">
        <label>From</label>
        <input type="date" name="from" value="{{ isset($from) ? $from->format('Y-m-d') : '' }}">
      </div>
      <div class="field custom-range {{ $period === 'custom' ? '' : 'hidden' }}" id="customRangeBox2">
        <label>To</label>
        <input type="date" name="to" value="{{ isset($to) ? $to->format('Y-m-d') : '' }}">
      </div>

      <div class="field action">
        <button class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        <a href="{{ route('bookingandcontact.list') }}" class="btn ghost">Reset</a>
      </div>
    </form>
  </section>

  {{-- ===== KPI Row ===== --}}
  <section class="grid-2">
    <div class="card lift">
      <div class="kpis">
        <div class="kpi">
          <div class="kpi__icon badge booking"><i class="fas fa-book"></i></div>
          <div>
            <div class="kpi__label">Total Booking</div>
            {{-- now showing SUM from controller --}}
            <div class="kpi__val">{{ number_format($totalBooking) }}</div>
          </div>
        </div>
        <div class="kpi">
          <div class="kpi__icon badge contact"><i class="fas fa-user-plus"></i></div>
          <div>
            <div class="kpi__label">Total Contact</div>
            {{-- now showing SUM from controller --}}
            <div class="kpi__val">{{ number_format($totalContact) }}</div>
          </div>
        </div>
        <div class="kpi">
          <div class="kpi__icon badge {{ $delta >= 0 ? 'ok' : 'bad' }}"></div>
          <div>
            <div class="kpi__label">Δ Booking - Contact</div>
            <div class="kpi__val delta" data-positive="{{ $delta >= 0 ? '1' : '0' }}">
              {{ $delta >= 0 ? '+' : '' }}{{ number_format($delta) }}
            </div>
          </div>
        </div>
      </div>

      <div class="compare">
        <div class="compare__head">
          <span class="kpi__label">Booking vs Contact (share)</span>
          <span class="legend">
            <span class="dot booking"></span>Booking
            <span class="dot contact"></span>Contact
          </span>
        </div>
        <div class="bar" aria-label="Booking vs Contact">
          <div class="bar__segment booking" style="width:{{ $ratio }}%" title="Booking {{ $ratio }}%"></div>
          <div class="bar__segment contact" style="width:{{ 100 - $ratio }}%" title="Contact {{ 100 - $ratio }}%"></div>
        </div>
        <div class="compare__labels">
          <span>Booking {{ $ratio }}%</span>
          <span>Contact {{ 100 - $ratio }}%</span>
        </div>
      </div>
    </div>

    <div class="card lift donut-card">
      @php
        $book = max(0, (int) $totalBooking);
        $cont = max(0, (int) $totalContact);
        $sum  = max(1, $book + $cont);
        $bookPct = round(($book / $sum) * 100);
        $contPct = 100 - $bookPct;
      @endphp
      <div class="donut" style="--book: {{ $bookPct }};">
        <div class="donut__ring"></div>
        <div class="donut__center">
          <div class="donut__big">{{ $bookPct }}%</div>
          <div class="donut__sub">Booking share</div>
        </div>
      </div>
      <div class="donut__legend">
        <div><span class="dot booking"></span> Booking: <b>{{ number_format($book) }}</b></div>
        <div><span class="dot contact"></span> Contact: <b>{{ number_format($cont) }}</b></div>
      </div>
    </div>
  </section>

  {{-- ===== Table ===== --}}
  <section class="card lift mt-3">
    <header class="card-head">
      <h2 class="card-title"><i class="fas fa-list"></i> Records</h2>
      <p class="muted">Total rows: {{ number_format($totalRows) }}</p>
    </header>

    <div class="table-responsive">
      <table class="table bc-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Booking</th>
            <th>Contact</th>
            <th>Note</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $idx => $item)
            <tr>
              <td>{{ $items->firstItem() + $idx }}</td>
              <td>{{ $item->created_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</td>
              <td>
                @if($item->booking)
                  <span class="badge booking">{{ number_format($item->booking) }}</span>
                @else
                  <span class="muted">0</span>
                @endif
              </td>
              <td>
                @if($item->contact)
                  <span class="badge contact">{{ number_format($item->contact) }}</span>
                @else
                  <span class="muted">0</span>
                @endif
              </td>
              <td>{{ $item->note }}</td>
            <td class="actions">
            {{-- <a href="{{ route('bookingandcontact.select', ['id' => $item->id]) }}" class="btn tiny">
              <i class="fas fa-pen"></i> Edit
            </a> --}}
           <form action="{{ route('bookingandcontact.delete') }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this record?')">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $item->id }}">
            <button type="submit" class="btn tiny danger">
              <i class="fas fa-trash"></i> Delete
            </button>
          </form>

          </td>


            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center muted py-4">
                <i class="fas fa-inbox"></i> No records found for this filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-foot">
      {{ $items->links() }}
    </div>
  </section>
</div>

{{-- ===== Inline styles just to match your style names ===== --}}
<style>
  .bc-page{display:flex;flex-direction:column;gap:14px;padding:14px;}
  .glass{background:#fff;border:1px solid rgba(15,23,42,.04);border-radius:16px;box-shadow:0 14px 35px rgba(15,23,42,.03);}
  .bc-head{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:14px 16px;}
  .btn{display:inline-flex;align-items:center;gap:6px;border:none;border-radius:999px;padding:7px 14px;font-size:.85rem;cursor:pointer}
  .btn-primary{background:#3a0a3a;color:#fff;}
  .btn.ghost{background:transparent;border:1px solid #e5e7eb;}
  .chip{display:inline-flex;align-items:center;gap:4px;border-radius:999px;padding:4px 10px;font-size:.7rem;}
  .grid-2{display:grid;grid-template-columns:1.2fr .8fr;gap:14px;}
  .card{background:#fff;border-radius:16px;padding:14px;}
  .kpis{display:flex;gap:12px;flex-wrap:wrap;}
  .kpi{display:flex;gap:10px;align-items:center;background:rgba(58,10,58,.02);padding:8px 10px;border-radius:12px;flex:1 1 120px;}
  .kpi__label{font-size:.7rem;color:#6b7280;}
  .kpi__val{font-weight:600;font-size:1.25rem;}
  .badge.booking{background:rgba(88,28,135,.09);color:#581c87;}
  .badge.contact{background:rgba(59,130,246,.09);color:#5d0d57;}
  .badge.ok{background:rgba(34,197,94,.12);color:#15803d;}
  .badge.bad{background:rgba(248,113,113,.12);color:#b91c1c;}
  .compare{margin-top:16px;}
  .compare .bar{display:flex;height:14px;border-radius:999px;overflow:hidden;background:#e5e7eb;}
  .bar__segment.booking{background:#581c87;}
  .bar__segment.contact{background:#1d4ed8;}
  .compare__labels{display:flex;justify-content:space-between;margin-top:6px;font-size:.7rem;color:#6b7280;}
  .donut-card{display:flex;gap:16px;align-items:center;}
  .donut{position:relative;width:120px;height:120px;}
  .donut__ring{width:100%;height:100%;border-radius:999px;background:
    conic-gradient(#581c87 calc(var(--book)*1%), #1d4ed8 0);}
  .donut__center{position:absolute;inset:16px;background:#fff;border-radius:999px;display:flex;flex-direction:column;align-items:center;justify-content:center;}
  .donut__big{font-size:1.4rem;font-weight:600;}
  .donut__legend{display:flex;flex-direction:column;gap:4px;font-size:.75rem;}
  .dot{display:inline-block;width:10px;height:10px;border-radius:999px;margin-right:4px;}
  .dot.booking{background:#581c87;}
  .dot.contact{background:#1d4ed8;}
  .bc-filters__form{display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;padding:12px 16px;}
  .field{display:flex;flex-direction:column;gap:4px;}
  .field input,.field select{border:1px solid #e5e7eb;border-radius:10px;padding:5px 8px;min-width:140px;}
  .field.action{display:flex;gap:6px;align-items:center;}
  .hidden{display:none !important;}
  .table{width:100%;border-collapse:separate;border-spacing:0 6px;}
  .table thead th{font-size:.7rem;text-transform:uppercase;color:#6b7280;padding:8px 10px;}
  .table tbody tr{background:#fff;border-radius:14px;box-shadow:0 1px 0 rgba(15,23,42,.02);}
  .table tbody td{padding:10px;}
  .muted{color:#6b7280;}
  @media(max-width:980px){
    .grid-2{grid-template-columns:1fr;}
    .donut-card{flex-wrap:wrap;}
    .bc-filters__form{flex-direction:column;align-items:flex-start;}
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const period = document.getElementById('periodSelect');
    const c1 = document.getElementById('customRangeBox');
    const c2 = document.getElementById('customRangeBox2');
    function toggleCustom(){
      if(period.value === 'custom'){
        c1.classList.remove('hidden');
        c2.classList.remove('hidden');
      }else{
        c1.classList.add('hidden');
        c2.classList.add('hidden');
      }
    }
    period.addEventListener('change', toggleCustom);
    toggleCustom();
  });
</script>
@endsection
