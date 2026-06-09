@extends('Backend.Layout.App')

@section('content')
<div class="container-fluid report-shell">

    <div class="report-header mb-3">
        <div>
            <div class="report-eyebrow">
                <span class="dot"></span>
                <span>Booking & Revenue Report</span>
            </div>
            <h1>Reports Overview</h1>
            <p>Analyze revenue, bookings, and customer feedback across branches and services.</p>
        </div>
    </div>

    <div class="card mb-4 filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label filter-label">From Date</label>
                        <input type="date" name="from_date" value="{{ $from->format('Y-m-d') }}" class="form-control filter-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label filter-label">To Date</label>
                        <input type="date" name="to_date" value="{{ $to->format('Y-m-d') }}" class="form-control filter-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label filter-label">Branch</label>
                        <select name="branch_id" class="form-control filter-control">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="w-100 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary flex-fill btn-main">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>

                            <button
                                type="submit"
                                class="btn btn-success flex-fill btn-ghost"
                                formaction="{{ route('reports.export') }}"
                                formmethod="GET"
                                formtarget="_blank"
                            >
                                <i class="fas fa-file-excel me-1"></i> Export
                            </button>

                            <button
                                type="submit"
                                class="btn btn-info flex-fill btn-ghost"
                                formaction="{{ route('print.report') }}"
                                formmethod="GET"
                                formtarget="_blank"
                            >
                                 Print
                            </button>
                        </div>
                    </div>
                </div>

                <div class="period-pills">
                    <button type="submit" name="period" value="this_week" class="pill-btn-outline">
                        <i class="fas fa-calendar-week me-1"></i> This Week
                    </button>
                    <button type="submit" name="period" value="last_week" class="pill-btn-outline">
                        <i class="fas fa-calendar me-1"></i> Last Week
                    </button>
                    <button type="submit" name="period" value="this_month" class="pill-btn-outline">
                        <i class="fas fa-calendar-alt me-1"></i> This Month
                    </button>
                    <button type="submit" name="period" value="last_month" class="pill-btn-outline">
                        <i class="fas fa-calendar me-1"></i> Last Month
                    </button>
                    <button type="submit" name="period" value="this_year" class="pill-btn-outline">
                        <i class="fas fa-calendar me-1"></i> This Year
                    </button>
                    <button type="submit" name="period" value="last_year" class="pill-btn-outline">
                        <i class="fas fa-calendar me-1"></i> Last Year
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-wrapper mb-4">
        <div class="stats-title-row">
            <h2 class="stats-title">
                <i class="fas fa-chart-bar me-2"></i> Overview
            </h2>
            <span class="stats-subtitle">Revenue · Bookings · Feedback</span>
        </div>

        <div class="stats-container">
            <div class="stat-card stat-accent">
                <div class="stat-info">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-helper">For current filter range</div>
                </div>
                <div class="stat-icon soft-brand">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">This Week</div>
                    <div class="stat-value">${{ number_format($thisWeekRevenue, 2) }}</div>
                    <div class="stat-helper">Compared with last week</div>
                    <div class="stat-trend">
                        @if(!is_null($weekOverWeekChange) && $lastWeekRevenue > 0)
                            @php $absChange = abs($weekOverWeekChange); @endphp

                            @if($weekTrend === 'up')
                                <span class="trend-badge up">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    +{{ number_format($absChange, 1) }}% vs last week
                                </span>
                            @elseif($weekTrend === 'down')
                                <span class="trend-badge down">
                                    <i class="fas fa-arrow-down me-1"></i>
                                    -{{ number_format($absChange, 1) }}% vs last week
                                </span>
                            @else
                                <span class="trend-badge neutral">
                                    <i class="fas fa-minus me-1"></i>0.0% vs last week
                                </span>
                            @endif
                        @else
                            <span class="trend-badge neutral">
                                No data for last week
                            </span>
                        @endif
                    </div>
                </div>
                <div class="stat-icon soft-green">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Last Week</div>
                    <div class="stat-value">${{ number_format($lastWeekRevenue, 2) }}</div>
                    <div class="stat-helper">Baseline for comparison</div>
                </div>
                <div class="stat-icon soft-indigo">
                    <i class="fas fa-history"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Total Bookings</div>
                    <div class="stat-value">{{ $totalBooking }}</div>
                    <div class="stat-helper">All booking statuses</div>
                </div>
                <div class="stat-icon soft-blue">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Confirmed</div>
                    <div class="stat-value">{{ $statusConfirmed }}</div>
                    <div class="stat-helper">Confirmed</div>
                </div>
                <div class="stat-icon soft-green">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Cancelled</div>
                    <div class="stat-value">{{ $statusCancelled }}</div>
                    <div class="stat-helper">Cancelled</div>
                </div>
                <div class="stat-icon soft-red">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Processing</div>
                    <div class="stat-value">{{ $statusProcessing }}</div>
                    <div class="stat-helper">Pending confirmation</div>
                </div>
                <div class="stat-icon soft-amber">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Feedback Like</div>
                    <div class="stat-value">{{ $feedbackyes }}</div>
                    <div class="stat-helper">Positive feedback</div>
                </div>
                <div class="stat-icon soft-green">
                    <i class="fas fa-thumbs-up"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Feedback Empty</div>
                    <div class="stat-value">{{ $feedbackempty }}</div>
                    <div class="stat-helper">No response from customer</div>
                </div>
                <div class="stat-icon soft-grey">
                    <i class="fas fa-comment-slash"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <div class="stat-label">Feedback Dislike</div>
                    <div class="stat-value">{{ $feedbackno }}</div>
                    <div class="stat-helper">Need follow-up care</div>
                </div>
                <div class="stat-icon soft-red">
                    <i class="fas fa-thumbs-down"></i>
                </div>
            </div>
        </div>
    </div>

 
    <div class="card mb-4 table-card">
        <div class="card-header table-card-header">
            <h3 class="mb-0">
                <i class="fas fa-cut me-2"></i>Revenue By Service
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Revenue</th>
                            <th>Users</th>
                            <th>Percentage of Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalServiceRevenue = ($revenueByService ?? collect())->sum();
                            $usersMap  = collect($usersByService ?? []);
                            $totalUsers = $usersMap->sum();
                        @endphp

                        @forelse(($revenueByService ?? collect())->sortDesc() as $serviceId => $revenue)
                            @php
                                $service    = $services->find($serviceId);
                                $percentage = $totalServiceRevenue > 0 ? ($revenue / $totalServiceRevenue) * 100 : 0;
                                $users      = (int) $usersMap->get($serviceId, 0);
                                $userShare  = $totalUsers > 0 ? ($users / $totalUsers) * 100 : 0;
                            @endphp

                            @if($service)
                                <tr>
                                    <td class="khmer-text">{{ $service->name }}</td>
                                    <td>${{ number_format($revenue, 2) }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ number_format($users) }}
                                        </span>
                                        @if($totalUsers > 0)
                                            <small class="text-muted">({{ number_format($userShare, 1) }}%)</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2 slim-progress">
                                                <div
                                                    class="progress-bar"
                                                    role="progressbar"
                                                    style="width: {{ $percentage }}%; background-color: {{ $loop->index % 2 === 0 ? '#891b96' : '#d434bc' }};"
                                                    aria-valuenow="{{ $percentage }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                ></div>
                                            </div>
                                            <span class="percent-label">{{ number_format($percentage, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No revenue data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   <div class="card mb-4 table-card">
        <div class="card-header table-card-header">
            <h3 class="mb-0">
                <i class="fas fa-building me-2"></i>Revenue By Branch
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Revenue</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalBranchRevenue = $revenueByBranch->sum();
                        @endphp
                        @foreach($revenueByBranch as $branchId => $revenue)
                            @php
                                $branch = $branches->find($branchId);
                            @endphp
                            @if($branch)
                                @php
                                    $percent = $totalBranchRevenue > 0 ? ($revenue / $totalBranchRevenue) * 100 : 0;
                                @endphp
                                <tr>
                                    <td><span class="khmer-text">{{ $branch->name }}</span></td>
                                    <td>${{ number_format($revenue, 2) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2 slim-progress">
                                                <div
                                                    class="progress-bar"
                                                    role="progressbar"
                                                    style="width: {{ $percent }}%; background-color: {{ $loop->index % 2 == 0 ? '#891b96' : '#d434bc' }};"
                                                    aria-valuenow="{{ $percent }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                ></div>
                                            </div>
                                            <span class="percent-label">{{ number_format($percent, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4 table-card">
        <div class="card-header table-card-header">
            <h3 class="mb-0">
                <i class="fas fa-bullhorn me-2"></i>Know Through (Revenue)
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Revenue</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $knowThroughLabels = [
                                1 => 'Facebook',
                                2 => 'TikTok',
                                3 => 'Telegram',
                                4 => 'Website',
                                5 => 'Instagram',
                                6 => 'Phone Number',
                            ];
                            $totalRevenueKnowThrough = $revenueByKnowThrough->sum();
                        @endphp

                        @foreach($revenueByKnowThrough as $knowId => $amount)
                            @php
                                $percent = $totalRevenueKnowThrough > 0
                                    ? ($amount / $totalRevenueKnowThrough) * 100
                                    : 0;
                            @endphp
                            <tr>
                                <td>{{ $knowThroughLabels[$knowId] ?? 'Other/Unknown' }}</td>
                                <td>${{ number_format($amount, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2 slim-progress">
                                            <div
                                                class="progress-bar"
                                                role="progressbar"
                                                style="width: {{ $percent }}%; background-color: {{ $loop->index % 2 == 0 ? '#891b96' : '#d434bc' }};"
                                                aria-valuenow="{{ $percent }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <span class="percent-label">{{ number_format($percent, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4 table-card">
        <div class="card-header table-card-header">
            <h3 class="mb-0">
                <i class="fas fa-users me-2"></i>Repeat Customers
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Total Bookings</th>
                            <th>First Booking</th>
                            <th>Last Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($repeatCustomers as $customer)
                            <tr>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['phone'] }}</td>
                                <td>{{ $customer['total_bookings'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($customer['first_booking'])->format('d-M-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($customer['last_booking'])->format('d-M-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No repeat customers yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
.khmer-text{
  font-family:"Battambang",system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
  font-size:.95rem;
}

:root{
  --brand:#150aa5;
  --brand-soft:rgba(109,10,97,.06);
  --ink:#0f172a;
  --muted:#6b7280;
  --bg-soft:#f9fafb;
}

.report-shell{
  padding-top:8px;
}

.report-header{
  padding:16px 18px;
  border-radius:18px;
  background:linear-gradient(120deg,rgba(4, 3, 57, 0.96),rgba(3, 13, 76, 0.96));
  color:#f9fafb;
  box-shadow:0 18px 45px rgba(15,23,42,.25);
  border:1px solid rgba(248,250,252,.06);
  position:relative;
  overflow:hidden;
}

.report-header::after{
  content:"";
  position:absolute;
  inset:auto -40px -60px auto;
  width:190px;
  height:190px;
  border-radius:999px;
  background:radial-gradient(circle at center,rgba(245,231,255,.9),transparent 65%);
  opacity:.16;
}

.report-eyebrow{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 12px;
  border-radius:999px;
  border:1px solid rgba(248,250,252,.32);
  font-size:11px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:#e5e7eb;
  background:rgba(15,23,42,.28);
  margin-bottom:6px;
}

.report-eyebrow .dot{
  width:8px;
  height:8px;
  border-radius:999px;
  background:#22c55e;
  box-shadow:0 0 0 6px rgba(34,197,94,.45);
}

.report-header h1{
  margin:0;
  font-size:22px;
  font-weight:700;
}

.report-header p{
  margin:2px 0 0;
  font-size:13px;
  color:#e5e7eb;
}

.filter-card{
  border-radius:16px;
  border:1px solid rgba(148,163,184,.25);
  box-shadow:0 10px 28px rgba(15,23,42,.08);
}

.filter-label{
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.09em;
  color:var(--muted);
  margin-bottom:2px;
}

.filter-control{
  font-size:13px;
  border-radius:999px;
  border:1px solid #e5e7eb;
  padding:.45rem .85rem;
  transition:border-color .15s ease,box-shadow .15s ease,transform .08s ease;
}

.filter-control:focus{
  border-color:#7c3aed;
  box-shadow:0 0 0 1px rgba(124,58,237,.25);
  transform:translateY(-1px);
}

.btn-main{
  border-radius:999px;
  font-size:.85rem;
  font-weight:600;
}

.btn-ghost{
  border-radius:999px;
  font-size:.82rem;
  font-weight:500;
  border:none;
  box-shadow:0 6px 18px rgba(15,23,42,.08);
}

.btn-ghost.btn-success{
  background:linear-gradient(120deg,#16a34a,#22c55e);
}

.btn-ghost.btn-info{
  background:linear-gradient(120deg,#0ea5e9,#38bdf8);
  color:#0f172a;
}

.period-pills{
  display:flex;
  flex-wrap:wrap;
  gap:.45rem;
  margin-top:.35rem;
}

.pill-btn-outline{
  border-radius:999px;
  border:1px solid rgba(148,163,184,.7);
  background:#fff;
  color:#4b5563;
  font-size:.78rem;
  padding:.3rem .75rem;
  display:inline-flex;
  align-items:center;
  gap:.3rem;
  cursor:pointer;
  transition:background .15s ease,box-shadow .15s ease,transform .08s ease,border-color .15s ease;
}

.pill-btn-outline:hover{
  background:rgba(109,10,97,.06);
  border-color:#190f9c;
  transform:translateY(-1px);
  box-shadow:0 8px 20px rgba(148,163,184,.35);
}

.stats-wrapper{
  margin-top:.25rem;
}

.stats-title-row{
  display:flex;
  justify-content:space-between;
  align-items:flex-end;
  margin-bottom:.5rem;
}

.stats-title{
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
  margin:0;
}

.stats-subtitle{
  font-size:.8rem;
  color:var(--muted);
}

.stats-container{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(210px,1fr));
  gap:.9rem;
}

.stat-card{
  background:#fff;
  border-radius:16px;
  padding:1.05rem 1rem;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:.75rem;
  border:1px solid rgba(148,163,184,.25);
  box-shadow:0 12px 35px rgba(15,23,42,.08);
  position:relative;
  overflow:hidden;
  transition:transform .15s ease,box-shadow .15s ease,border-color .15s ease;
}

.stat-card::before{
  content:"";
  position:absolute;
  inset:0;
  background:radial-gradient(circle at top right,rgba(212,52,188,.16),transparent 60%);
  opacity:0;
  transition:opacity .2s ease;
}

.stat-card:hover{
  transform:translateY(-1px);
  box-shadow:0 18px 45px rgba(15,23,42,.12);
  border-color:rgba(109,10,97,.35);
}

.stat-card:hover::before{
  opacity:1;
}

.stat-accent{
  background:radial-gradient(circle at top left,rgba(109,10,97,.14),#fff);
  border-color:rgba(10, 15, 160, 0.4);
}

.stat-info{
  position:relative;
  z-index:1;
}

.stat-label{
  font-size:.78rem;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:var(--muted);
  font-weight:600;
  margin-bottom:.15rem;
}

.stat-value{
  font-size:1.55rem;
  font-weight:700;
  color:var(--ink);
  line-height:1.1;
}

.stat-helper{
  font-size:.75rem;
  color:#9ca3af;
  margin-top:.2rem;
}

.stat-trend{
  margin-top:.3rem;
  font-size:.78rem;
}

.trend-badge{
  display:inline-flex;
  align-items:center;
  gap:.25rem;
  padding:.15rem .6rem;
  border-radius:999px;
  font-size:.75rem;
  font-weight:600;
  white-space:nowrap;
}

.trend-badge.up{
  background:rgba(34,197,94,.12);
  color:#16a34a;
}

.trend-badge.down{
  background:rgba(239,68,68,.14);
  color:#dc2626;
}

.trend-badge.neutral{
  background:#f3f4f6;
  color:#6b7280;
}

.stat-icon{
  position:relative;
  z-index:1;
  width:50px;
  height:50px;
  border-radius:999px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:1.35rem;
  background:var(--bg-soft);
  color:var(--brand);
  flex-shrink:0;
}

.soft-brand{
  background:var(--brand-soft);
  color:var(--brand);
}

.soft-green{
  background:#e8f5e9;
  color:#4caf50;
}

.soft-blue{
  background:#e3f2fd;
  color:#2196f3;
}

.soft-indigo{
  background:#e0e7ff;
  color:#4f46e5;
}

.soft-red{
  background:#ffebee;
  color:#ef4444;
}

.soft-amber{
  background:#fff8e1;
  color:#f59e0b;
}

.soft-grey{
  background:#f3f4f6;
  color:#4b5563;
}

.table-card{
  border-radius:16px;
  border:none;
  box-shadow:0 10px 28px rgba(15,23,42,.08);
}

.table-card-header{
  background:#f9fafb;
  border-bottom:1px solid #e5e7eb;
  border-radius:16px 16px 0 0;
  padding:12px 18px;
}

.table-card-header h3{
  font-size:.95rem;
  font-weight:600;
  color:var(--ink);
}

.table th{
  border-top:none;
  font-weight:600;
  color:#111827;
  background:#f9fafb;
  font-size:.82rem;
}

.table td{
  font-size:.8rem;
}

.slim-progress{
  background-color:#f3f4f6;
  border-radius:999px;
  height:8px;
}

.slim-progress .progress-bar{
  border-radius:999px;
}

.percent-label{
  font-size:.78rem;
  color:#374151;
}

@media (max-width:768px){
  .report-header{
    padding:14px 14px;
  }
  .stats-title-row{
    flex-direction:column;
    align-items:flex-start;
    gap:.1rem;
  }
  .stat-card{
    padding:.9rem .85rem;
  }
  .stat-value{
    font-size:1.35rem;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        const label = item.querySelector('span')?.textContent?.trim();
        if (label === 'Report') {
            item.classList.add('active');
        }
    });
});
</script>
@endsection
