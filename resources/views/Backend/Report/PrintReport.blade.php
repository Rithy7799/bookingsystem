@php
    /**
     * Expected variables (same as reports.index):
     * $from (Carbon), $to (Carbon), $branches (Collection),
     * $totalRevenue (float), $totalBooking (int),
     * $statusConfirmed (int), $statusCancelled (int), $statusProcessing (int),
     * $feedbackyes (int), $feedbackno (int),
     * $revenueByBranch (Collection|array branch_id => amount),
     * $revenueByService (Collection|array service_id => amount),
     * $revenueByKnowThrough (Collection|array know_code => amount),
     * $services (Collection)
     */
    $branchId = request('branch_id');
    $selectedBranch = $branchId ? optional($branches->firstWhere('id', $branchId))->name : 'All Branches';
    $knowThroughLabels = [1=>'Facebook',2=>'TikTok',3=>'Telegram',4=>'Website',5=>'Instagram',6=>'Phone Number'];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Print Report – Maple Salon</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Noto+Sans+Khmer:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    /* ========= THEME (brand: #490d4c) ========= */
    :root{
      --brand:#490d4c;             /* primary plum */
      --brand-600:#5d1361;         /* hover/strong */
      --brand-100:#f6f0f7;         /* subtle tint */
      --ink:#121016;               /* near-black text */
      --muted:#6b6470;             /* soft text */
      --light:#faf9fb;             /* panels */
      --border:#ece7f0;            /* borders tuned to brand */
      --ring: rgba(73,13,76,.14);  /* focus ring */
      --ok:#16a34a; --warn:#d97706; --bad:#dc2626;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      font-family:Inter,system-ui,Roboto,Arial,"Noto Sans Khmer",sans-serif;
      color:var(--ink); margin:0; background:#fff;
      -webkit-print-color-adjust:exact; print-color-adjust:exact;
    }

    /* ========= LAYOUT ========= */
    .sheet{
      max-width:980px; margin:20px auto; padding:24px 24px 16px;
      border:1px solid var(--border); border-radius:16px;
      background:#fff;
      box-shadow:0 10px 24px rgba(73,13,76,.06);
    }

    /* ========= HEADER ========= */
    .header{
      display:flex; justify-content:space-between; gap:16px;
      border-bottom:2px solid var(--border); padding-bottom:16px
    }
    .brand{display:flex; gap:12px; align-items:center}
    .logo{
      width:56px; height:56px; border-radius:14px;
      background:conic-gradient(from 210deg,var(--brand), var(--brand-600) 55%, #8b2f90 80%, var(--brand));
      display:grid; place-items:center; color:#fff; font-weight:800; letter-spacing:.5px;
      box-shadow:0 6px 16px rgba(73,13,76,.25), inset 0 0 0 2px rgba(255,255,255,.2);
      text-shadow:0 1px 0 rgba(0,0,0,.25);
    }
    .brand h1{font-size:20px; margin:0; color:var(--brand-600)}
    .sub{color:var(--muted); font-size:12px; margin-top:2px}
    .title{text-align:right}
    .title h2{margin:0; font-size:24px; color:var(--brand)}

    .kh{font-family:"Noto Sans Khmer",Inter,sans-serif}

    /* ========= INFO CARDS ========= */
    .meta{display:grid; grid-template-columns:1fr 1fr; gap:14px; padding-top:12px}
    .card{
      border:1px solid var(--border); border-radius:14px; padding:12px;
      background:linear-gradient(180deg,#fff, var(--light));
    }
    .card h3{
      margin:0 0 8px; color:var(--brand-600); font-size:12px;
      text-transform:uppercase; letter-spacing:.08em
    }
    .grid2{display:grid; grid-template-columns:1fr 1fr; gap:8px}
    .row{display:flex; gap:8px}
    .row label{min-width:120px; color:var(--muted)}

    /* ========= STATS ========= */
    .stats{display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:10px; margin-top:10px}
    .stat{
      border:1px solid var(--border); border-radius:12px; padding:12px;
      background:#fff;
    }
    .stat .cap{color:var(--muted); font-size:12px}
    .stat .val{font-size:20px; font-weight:800; margin-top:6px; color:var(--ink)}
    .stat:nth-child(1), .stat:nth-child(2){
      background:linear-gradient(0deg,var(--brand-100),#fff);
      border-color:#e9d9ee;
    }

    /* ========= TABLES ========= */
    table{width:100%; border-collapse:separate; border-spacing:0; margin-top:10px; border:1px solid var(--border); border-radius:12px; overflow:hidden; background:#fff}
    thead th{
      background:linear-gradient(0deg,var(--brand-100),#fff);
      color:#3a2f3f;
      text-align:left; font-weight:700; font-size:13px; padding:10px 12px; border-bottom:1px solid var(--border)
    }
    tbody td{padding:10px 12px; border-bottom:1px dashed var(--border); color:#231f24}
    tbody tr:last-child td{border-bottom:none}
    tbody tr:hover td{background:#fdfbfe}
    .num{text-align:right; white-space:nowrap}
    .center{text-align:center}

    /* ========= SECTIONS ========= */
    .section{margin-top:18px}
    .section h3{
      margin:0 0 8px; font-size:16px; color:var(--brand-600);
      border-left:4px solid var(--brand); padding-left:10px
    }

    /* ========= FOOTER / ACTIONS ========= */
    .footer{margin-top:18px; color:var(--muted); font-size:12px; display:flex; justify-content:space-between; align-items:center}
    .actions{display:flex; gap:8px; justify-content:flex-end; margin-top:14px}
    .btn{
      border:1px solid var(--border); background:#fff; padding:10px 14px; border-radius:12px; cursor:pointer; font-weight:700;
      transition:.18s ease; box-shadow:0 2px 6px rgba(73,13,76,.06)
    }
    .btn:focus{outline:none; box-shadow:0 0 0 4px var(--ring)}
    .btn:hover{transform:translateY(-1px)}
    .btn.primary{background:var(--brand); color:#fff; border-color:var(--brand)}
    .btn.primary:hover{background:var(--brand-600); border-color:var(--brand-600)}

    /* ========= PRINT ========= */
    @media print{
      .sheet{border:none; border-radius:0; margin:0; padding:0; box-shadow:none}
      @page{size:A4; margin:12mm}
      .actions{display:none}
      .logo{filter:none}
    }
  </style>
</head>
<body>
  <div class="sheet">
    <div class="header">
      <div class="brand">
        <div class="logo">MS</div>
        <div>
          <h1>Maple Salon <span class="kh">• របាយការណ៍</span></h1>
          <div class="sub"> <div class="row"><div>{{ $selectedBranch }}</div></div></div>
        </div>
      </div>
      <div class="title">
        <h2>Booking Report</h2>
        <div class="sub">Date: <strong>{{ $from->format('Y-m-d') }}</strong> → <strong>{{ $to->format('Y-m-d') }}</strong></div>
        <div class="sub">Branch: <strong>{{ $selectedBranch }}</strong></div>
        <div class="sub">Generated: <strong>{{ now()->format('Y-m-d H:i') }}</strong></div>
      </div>
    </div>

    <div class="meta">
      <div class="card">
        <h3>Overview</h3>
        <div class="stats">
          <div class="stat"><div class="cap">Total Revenue</div><div class="val">${{ number_format($totalRevenue,2) }}</div></div>
          <div class="stat"><div class="cap">Total Bookings</div><div class="val">{{ $totalBooking }}</div></div>
             <div class="stat"><div class="cap">Feedback 👍</div><div class="val">{{ $feedbackyes }}</div></div>
          <div class="stat"><div class="cap">Feedback 👎</div><div class="val">{{ $feedbackno }}</div></div>

        
        </div>
      </div>
      <div class="card">
        <h3>Status</h3>
        <div class="grid2">
          {{-- <div class="row"><label>From</label><div>{{ $from->format('d M ') }}</div></div>
          <div class="row"><label>To</label><div>{{ $to->format('d M ') }}</div></div> --}}
          {{-- <div class="row"><label>Branch</label><div>{{ $selectedBranch }}</div></div> --}}
          {{-- <div class="row"><label>User</label><div>{{ optional(auth()->user())->name ?? '—' }}</div></div> --}}
          <div class="stat"><div class="cap">Confirmed</div><div class="val">{{ $statusConfirmed }}</div></div>
          <div class="stat"><div class="cap">Cancelled</div><div class="val">{{ $statusCancelled }}</div></div>
          <div class="stat"><div class="cap">Processing</div><div class="val">{{ $statusProcessing }}</div></div>
         
        </div>
      </div>
    </div>

    <div class="section">
      <h3>Revenue by Branch</h3>
      @php $totalBranchRevenue = collect($revenueByBranch)->sum(); @endphp
      <table>
        <thead>
          <tr><th>Branch</th><th class="num">Revenue</th><th class="num">% Percentage</th></tr>
        </thead>
        <tbody>
          @foreach($revenueByBranch as $branchId => $amount)
            @php
              $branch = $branches->find($branchId);
              $pct = $totalBranchRevenue>0 ? ($amount/$totalBranchRevenue*100) : 0;
            @endphp
            @if($branch)
              <tr>
                <td>{{ $branch->name }}</td>
                <td class="num">${{ number_format($amount,2) }}</td>
                <td class="num">{{ number_format($pct,1) }}%</td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="section">
      <h3>Revenue by Service</h3>
      @php $totalServiceRevenue = collect($revenueByService)->sum(); @endphp
      <table>
        <thead><tr><th>Service</th><th class="num">Revenue</th><th class="num">% Percentage</th></tr></thead>
        <tbody>
          @forelse(collect($revenueByService)->sortDesc() as $serviceId => $amount)
            @php
              $service = $services->find($serviceId);
              $pct = $totalServiceRevenue>0 ? ($amount/$totalServiceRevenue*100) : 0;
            @endphp
            @if($service)
              <tr>
                <td>{{ $service->name }}</td>
                <td class="num">${{ number_format($amount,2) }}</td>
                <td class="num">{{ number_format($pct,1) }}%</td>
              </tr>
            @endif
          @empty
            <tr><td colspan="3" class="center">No revenue data available.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="section">
      <h3>Know Through (Revenue)</h3>
      @php $totalKT = collect($revenueByKnowThrough)->sum(); @endphp
      <table>
        <thead><tr><th>Reference</th><th class="num">Revenue</th><th class="num">% Percentage</th></tr></thead>
        <tbody>
          @foreach($revenueByKnowThrough as $knowId => $amount)
            @php $pct = $totalKT>0 ? ($amount/$totalKT*100) : 0; @endphp
            <tr>
              <td>{{ $knowThroughLabels[$knowId] ?? 'Other/Unknown' }}</td>
              <td class="num">${{ number_format($amount,2) }}</td>
              <td class="num">{{ number_format($pct,1) }}%</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if(!empty($repeatCustomers))
    <div class="section">
      <h3>Repeat Customers</h3>
      <table>
        <thead>
          <tr><th>Customer Name</th><th>Phone</th><th class="num">Bookings</th><th class="center">First</th><th class="center">Last</th></tr>
        </thead>
        <tbody>
          @forelse($repeatCustomers as $c)
            <tr>
              <td>{{ $c['name'] }}</td>
              <td>{{ $c['phone'] }}</td>
              <td class="num">{{ $c['total_bookings'] }}</td>
              <td class="center">{{ \Carbon\Carbon::parse($c['first_booking'])->format('d-M-Y') }}</td>
              <td class="center">{{ \Carbon\Carbon::parse($c['last_booking'])->format('d-M-Y') }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="center">No repeat customers yet</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @endif

    <div class="footer">
      <div>© {{ date('Y') }} Maple Salon • Generated by Digital Booking Report</div>
      <div>Date: {{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</div>
    </div>

    <div class="actions">
      <button class="btn" onclick="window.print()">Print</button>
      <button class="btn primary" onclick="window.print()">Save PDF</button>
    </div>
  </div>
</body>
</html>
