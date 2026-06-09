@extends('Backend.Layout.App')
@section('content')
<div class="wrap">
  <header class="bar">
    <div class="bar-left">
      <h1>Bookings Dashboard</h1>
      <p>Snapshot of bookings, revenue & trends</p>
    </div>
    <div class="bar-right">
      <div class="u-text">
        <span class="hi">Welcome back,</span>
        <span class="name">{{ Auth::user()->name }}</span>
      </div>
      <div class="u-avt">
        <img src="{{ asset('User/' . Auth::user()->image) }}" alt="avatar">
      </div>
    </div>
  </header>

  <section class="grid">
    <article class="card">
      <div class="card-head">
        <div class="ico tone-navy"><i class="fas fa-calendar-check"></i></div>
        <span class="lab">Today's Bookings</span>
      </div>
      <div class="card-body">
        <div class="val" id="todayBookings">{{ $todaysBookings }}</div>
        <div class="trend" id="todayTrend">
          <span class="chip {{ $trend >= 0 ? 'up' : 'down' }}">
            @if($trend >= 0) ↑ @else ↓ @endif {{ abs(round($trend, 2)) }}%
          </span>
          <span class="muted">vs yesterday</span>
        </div>
      </div>
    </article>

    <article class="card">
      <div class="card-head">
        <div class="ico tone-green"><i class="fas fa-dollar-sign"></i></div>
        <span class="lab">Total Revenue</span>
      </div>
      <div class="card-body">
        <div class="val" id="totalRevenue">${{ number_format($totalRevenue, 2) }}</div>
        <div class="trend" id="revenueTrend">
          <span class="chip {{ $percentIncrease >= 0 ? 'up' : 'down' }}">
            @if($percentIncrease >= 0) ↑ @else ↓ @endif {{ abs(round($percentIncrease, 2)) }}%
          </span>
          <span class="muted">vs last week</span>
        </div>
      </div>
    </article>

    <article class="card">
      <div class="card-head">
        <div class="ico tone-amber"><i class="fas fa-book"></i></div>
        <span class="lab">Total Bookings</span>
      </div>
      <div class="card-body">
        <div class="val" id="totalBookings">{{ $totalBookings }}</div>
        <span class="muted">All-time</span>
      </div>
    </article>

    <article class="card">
      <div class="card-head">
        <div class="ico tone-indigo"><i class="fas fa-check-circle"></i></div>
        <span class="lab">Confirmed</span>
      </div>
      <div class="card-body">
        <div class="val" id="confirmedBookings">{{ $confirmedBookings }}</div>
        <span class="tag">confirmed</span>
      </div>
    </article>
  </section>

  <section class="panel">
    <div class="ph"><h3>Revenue & Status Summary</h3></div>
    <div class="pb sums">
      <div class="sum">
        <small>This Week</small>
        <h4 id="thisWeekPayment">${{ number_format($thisWeekRevenue,2) }}</h4>
      </div>
      <div class="sum">
        <small>Last Week</small>
        <h4 id="lastWeekPayment">${{ number_format($lastWeekRevenue,2) }}</h4>
      </div>
      <div class="sum">
        <small>This Month</small>
        <h4 id="thisMonthPayment">${{ number_format($thisMonthPayment,2) }}</h4>
      </div>
      <div class="sum">
        <small>Last Month</small>
        <h4 id="lastMonthPayment">${{ number_format($lastMonthPayment,2) }}</h4>
      </div>
      <div class="sum">
        <small>Processing</small>
        <h4 id="processingCount">{{ $processingCount }}</h4>
      </div>
      <div class="sum">
        <small>Confirmed</small>
        <h4 id="summaryConfirmed">{{ $confirmedBookings }}</h4>
      </div>
      <div class="sum">
        <small>Cancelled</small>
        <h4 id="cancelledCount">{{ $cancelledCount }}</h4>
      </div>
    </div>
  </section>

  <section class="panel">
    <div class="ph"><h3>Filter</h3></div>
    <div class="pb">
      <form id="filterForm" class="controls">
        @csrf
        <input type="hidden" id="period" name="period" value="this_week">
        <div class="pills" role="tablist" aria-label="Period filter">
          <button type="button" class="pill active" data-period="this_week">This Week</button>
          <button type="button" class="pill" data-period="last_week">Last Week</button>
          <button type="button" class="pill" data-period="this_month">This Month</button>
          <button type="button" class="pill" data-period="last_month">Last Month</button>
        </div>
        <button type="submit" class="btn">
          <i class="fas fa-filter"></i> Apply
        </button>
      </form>
    </div>
  </section>

  <section class="panel">
    <div class="ph"><h3>Booking Status Trends</h3></div>
    <div class="pb chart">
      <div class="loader" id="chartLoader" hidden>
        <div class="spin"></div>
        <span>Updating…</span>
      </div>
      <canvas id="bookingStatusChart" height="360"></canvas>
    </div>
  </section>
</div>

<style>
:root{
  /* Main color #021937 */
  --brand:#021937;
  --brand-2:#083062;
  --accent:#0ea5e9;

  --ink:#0b1324;
  --muted:#6b7280;
  --bg:#f3f5fa;
  --panel:#ffffff;
  --line:#e1e5ef;

  --ok:#16a34a;
  --warn:#eab308;
  --bad:#ef4444;

  --shadow:0 12px 32px rgba(2,17,37,.12);
  --r:16px;
  --r2:12px;
}

*{box-sizing:border-box}
body{
  background:
    radial-gradient(circle at top left,rgba(2,25,55,.12),transparent 60%),
    radial-gradient(circle at bottom right,rgba(37,99,235,.10),transparent 55%),
    var(--bg);
  font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;
}
.wrap{
  padding:28px;
  color:var(--ink);
}

/* Top bar */
.bar{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:16px;
  flex-wrap:wrap;
  background:linear-gradient(120deg,#021937,#041f46);
  border-radius:20px;
  padding:16px 20px;
  box-shadow:0 18px 45px rgba(2,15,33,.6);
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
}
.bar::after{
  content:"";
  position:absolute;
  inset:auto -40px -80px auto;
  width:220px;
  height:220px;
  background:radial-gradient(circle at center,rgba(248,250,252,.9),transparent 65%);
  opacity:.16;
  border-radius:999px;
}
.bar-left{
  position:relative;
  z-index:1;
}
.bar-left h1{
  margin:0;
  font-size:22px;
  font-weight:800;
  letter-spacing:.2px;
}
.bar-left p{
  margin:4px 0 0;
  color:#cbd5f5;
  font-size:12.5px;
}
.bar-right{
  display:flex;
  align-items:center;
  gap:12px;
  position:relative;
  z-index:1;
}
.u-text{
  display:flex;
  flex-direction:column;
  text-align:right;
}
.hi{
  font-size:11px;
  color:#9ca3af;
}
.name{
  font-size:14px;
  font-weight:700;
  color:#f9fafb;
}
.u-avt{
  width:40px;
  height:40px;
  border-radius:12px;
  overflow:hidden;
  border:2px solid rgba(125,211,252,.9);
  box-shadow:0 10px 25px rgba(56,189,248,.7);
}
.u-avt img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* KPI grid */
.grid{
  display:grid;
  grid-template-columns:repeat(12,1fr);
  gap:14px;
  margin:20px 0;
}
.card{
  grid-column:span 3/span 3;
  background:var(--panel);
  border:1px solid var(--line);
  border-radius:var(--r);
  padding:14px 14px;
  box-shadow:var(--shadow);
  transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
  position:relative;
  overflow:hidden;
}
.card::before{
  content:"";
  position:absolute;
  inset:-40% -40% auto auto;
  background:radial-gradient(circle at top,rgba(14,165,233,.20),transparent 60%);
  opacity:0;
  transition:opacity .2s ease;
}
.card:hover{
  transform:translateY(-3px);
  box-shadow:0 18px 42px rgba(2,15,33,.18);
  border-color:rgba(2,25,55,.35);
}
.card:hover::before{
  opacity:1;
}
.card-head{
  display:flex;
  align-items:center;
  gap:10px;
}
.ico{
  width:36px;
  height:36px;
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  box-shadow:0 8px 22px rgba(15,23,42,.4);
}
.tone-navy{
  background:linear-gradient(135deg,#021937,#0ea5e9);
}
.tone-green{
  background:linear-gradient(135deg,#16a34a,#22c55e);
}
.tone-amber{
  background:linear-gradient(135deg,#f59e0b,#fb923c);
}
.tone-indigo{
  background:linear-gradient(135deg,#1d4ed8,#4f46e5);
}
.lab{
  font-size:12px;
  color:var(--muted);
  font-weight:700;
}
.card-body{
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-top:10px;
}
.val{
  font-size:28px;
  font-weight:900;
  color:var(--ink);
}
.trend{
  display:flex;
  align-items:center;
  gap:8px;
}
.chip{
  padding:4px 8px;
  border-radius:999px;
  font-size:12px;
  font-weight:800;
  border:1px solid var(--line);
  background:#f9fafb;
}
.chip.up{
  background:rgba(22,163,74,.08);
  color:#166534;
  border-color:rgba(22,163,74,.25);
}
.chip.down{
  background:rgba(239,68,68,.08);
  color:#991b1b;
  border-color:rgba(239,68,68,.25);
}
.muted{
  color:var(--muted);
  font-size:12px;
}
.tag{
  padding:4px 8px;
  border-radius:8px;
  background:rgba(2,25,55,.08);
  border:1px solid rgba(2,25,55,.25);
  color:var(--brand);
  font-size:11px;
  font-weight:800;
}

/* Panels */
.panel{
  background:var(--panel);
  border:1px solid var(--line);
  border-radius:var(--r);
  box-shadow:var(--shadow);
  margin-bottom:16px;
}
.ph{
  padding:12px 14px;
  border-bottom:1px solid var(--line);
}
.ph h3{
  margin:0;
  font-size:14px;
  font-weight:800;
  color:var(--ink);
}
.pb{
  padding:14px;
}

/* Controls */
.controls{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  flex-wrap:wrap;
}
.pills{
  display:flex;
  gap:8px;
  flex-wrap:wrap;
}
.pill{
  background:#fff;
  color:var(--brand);
  border:1px solid var(--line);
  padding:8px 12px;
  border-radius:999px;
  cursor:pointer;
  font-weight:800;
  font-size:12.5px;
  letter-spacing:.2px;
  transition:background .15s ease, box-shadow .15s ease, color .15s ease, transform .08s ease, border-color .15s ease;
}
.pill:hover{
  box-shadow:0 8px 20px rgba(2,15,33,.15);
  transform:translateY(-1px);
}
.pill.active{
  background:linear-gradient(90deg,var(--brand),var(--brand-2));
  color:#fff;
  border-color:transparent;
  box-shadow:0 10px 26px rgba(2,15,33,.35);
}
.btn{
  background:linear-gradient(90deg,var(--brand),var(--brand-2));
  color:#fff;
  border:none;
  padding:10px 14px;
  border-radius:12px;
  font-weight:900;
  letter-spacing:.3px;
  cursor:pointer;
  box-shadow:0 12px 30px rgba(2,15,33,.45);
  display:inline-flex;
  align-items:center;
  gap:6px;
}
.btn:hover{
  filter:brightness(1.05);
}

/* Chart */
.chart{
  position:relative;
  min-height:360px;
}
.loader{
  position:absolute;
  inset:0;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:8px;
  background:rgba(255,255,255,.6);
  backdrop-filter:blur(3px);
  border-radius:12px;
}
.spin{
  width:22px;
  height:22px;
  border:3px solid rgba(15,23,42,.12);
  border-top-color:var(--brand);
  border-radius:50%;
  animation:rot .8s linear infinite;
}
@keyframes rot{
  to{transform:rotate(360deg)}
}

/* Summary */
.sums{
  display:grid;
  grid-template-columns:repeat(7,minmax(140px,1fr));
  gap:10px;
}
.sum{
  background:#fff;
  border:1px solid var(--line);
  border-radius:12px;
  padding:12px 14px;
  text-align:center;
  box-shadow:0 10px 26px rgba(15,23,42,.05);
  position:relative;
  overflow:hidden;
}
.sum::before{
  content:"";
  position:absolute;
  inset:auto -40% -60% auto;
  background:radial-gradient(circle at center,rgba(2,25,55,.14),transparent 65%);
  opacity:0;
  transition:opacity .2s ease;
}
.sum:hover::before{
  opacity:1;
}
.sum small{
  display:block;
  color:var(--muted);
  font-weight:800;
  margin-bottom:6px;
  font-size:11px;
}
.sum h4{
  margin:0;
  font-weight:900;
  font-size:18px;
  color:var(--ink);
}

/* Responsive */
@media (max-width:1200px){
  .card{grid-column:span 6/span 6}
  .sums{grid-template-columns:repeat(3,1fr)}
}
@media (max-width:768px){
  .card{grid-column:span 12/span 12}
  .sums{grid-template-columns:repeat(2,1fr)}
  .wrap{padding:16px;}
}
@media (max-width:520px){
  .sums{grid-template-columns:1fr}
  .bar{align-items:flex-start;}
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  const statsUrl='{{ route('filter.data') }}';
  const csrfToken='{{ csrf_token() }}';
  const form=document.getElementById('filterForm');
  const pills=document.querySelectorAll('.pill');
  const periodEl=document.getElementById('period');
  const loader=document.getElementById('chartLoader');
  const ctx=document.getElementById('bookingStatusChart').getContext('2d');

  // Navy-themed gradients for chart
  const g1=ctx.createLinearGradient(0,0,0,360);
  g1.addColorStop(0,'rgba(2,25,55,.45)');
  g1.addColorStop(1,'rgba(2,25,55,.03)');

  const g2=ctx.createLinearGradient(0,0,0,360);
  g2.addColorStop(0,'rgba(34,197,94,.40)');
  g2.addColorStop(1,'rgba(34,197,94,.06)');

  const g3=ctx.createLinearGradient(0,0,0,360);
  g3.addColorStop(0,'rgba(239,68,68,.40)');
  g3.addColorStop(1,'rgba(239,68,68,.06)');

  let chart=null;
  const $=id=>document.getElementById(id);
  const n=v=>{
    const x=(typeof v==='number')?v:parseFloat(v);
    return isNaN(x)?0:x;
  };

  const setActive=p=>pills.forEach(b=>b.classList.toggle('active',b.dataset.period===p));

  function run(period){
    loader.hidden=false;
    const fd=new FormData();
    fd.append('period',period);

    fetch(statsUrl,{
      method:'POST',
      headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'},
      body:fd
    })
    .then(r=>r.json())
    .then(d=>{
      if(d.error){loader.hidden=true;return}

      $('todayBookings').textContent=n(d.todaysBookings);
      const t=n(d.trend);
      $('todayTrend').innerHTML=
        `<span class="chip ${t>=0?'up':'down'}">${t>=0?'↑':'↓'} ${Math.abs(t).toFixed(2)}%</span> 
         <span class="muted">vs yesterday</span>`;

      $('totalRevenue').textContent='$'+n(d.totalRevenue).toFixed(2);
      const p=n(d.percentIncrease);
      $('revenueTrend').innerHTML=
        `<span class="chip ${p>=0?'up':'down'}">${p>=0?'↑':'↓'} ${Math.abs(p).toFixed(2)}%</span> 
         <span class="muted">vs last week</span>`;

      $('totalBookings').textContent=n(d.totalBookings);
      $('confirmedBookings').textContent=n(d.confirmedBookings);
      $('processingCount').textContent=n(d.processingCount);
      $('summaryConfirmed').textContent=n(d.confirmedBookings);
      $('cancelledCount').textContent=n(d.cancelledCount);
      $('thisWeekPayment').textContent='$'+n(d.thisWeekPayment).toFixed(2);
      $('lastWeekPayment').textContent='$'+n(d.lastWeekPayment).toFixed(2);
      $('thisMonthPayment').textContent='$'+n(d.thisMonthPayment).toFixed(2);
      $('lastMonthPayment').textContent='$'+n(d.lastMonthPayment).toFixed(2);

      if(chart) chart.destroy();
      chart=new Chart(ctx,{
        type:'line',
        data:{
          labels:d.labels||[],
          datasets:[
            {
              label:'Processing',
              data:d.processing||[],
              borderColor:'#021937',
              backgroundColor:g1,
              fill:true,
              tension:.35,
              borderWidth:2,
              pointRadius:2.5,
              pointHoverRadius:4
            },
            {
              label:'Confirmed',
              data:d.confirmed||[],
              borderColor:'#16a34a',
              backgroundColor:g2,
              fill:true,
              tension:.35,
              borderWidth:2,
              pointRadius:2.5,
              pointHoverRadius:4
            },
            {
              label:'Cancelled',
              data:d.cancelled||[],
              borderColor:'#ef4444',
              backgroundColor:g3,
              fill:true,
              tension:.35,
              borderWidth:2,
              pointRadius:2.5,
              pointHoverRadius:4
            }
          ]
        },
        options:{
          responsive:true,
          maintainAspectRatio:false,
          plugins:{
            legend:{position:'top',labels:{color:'#374151'}},
            title:{display:false}
          },
          scales:{
            y:{
              beginAtZero:true,
              ticks:{color:'#4b5563'},
              grid:{color:'#e5e7eb'},
              title:{display:true,text:'Bookings',color:'#4b5563'}
            },
            x:{
              ticks:{color:'#4b5563'},
              grid:{color:'#f3f4f6'},
              title:{display:true,text:'Days',color:'#4b5563'}
            }
          },
          interaction:{intersect:false,mode:'index'}
        }
      });
    })
    .finally(()=>{loader.hidden=true});
  }

  pills.forEach(b=>b.addEventListener('click',()=>{
    const p=b.dataset.period;
    periodEl.value=p;
    setActive(p);
  }));

  form.addEventListener('submit',e=>{
    e.preventDefault();
    run(periodEl.value);
  });

  setActive('this_week');
  run('this_week');
});
</script>
@endsection
