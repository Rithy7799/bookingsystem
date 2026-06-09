@extends('Backend.Layout.App')

@section('content')

<div class="booking-page">
    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="eyebrow">
                <span class="dot"></span>
                <span>Maple · Bookings Management</span>
            </div>
            <h1>Bookings Management</h1>
            <p>Filter, review, and manage the latest bookings across branches.</p>
        </div>

        <div class="user-info">
            <div class="profile-username">
                <span class="hi">Welcome back,</span>
                <span class="fw-bold">{{ Auth::user()->name }}</span>
            </div>
            <div class="avatar-sm">
                <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
        </div>
    </div>

    {{-- KPI METRICS --}}
    @php
        $timeLabel = $time === 'last_week' ? 'Last week' : 'This week';
    @endphp

    <div class="booking-metrics">
        <div class="metric-head">
            <div>
                <span class="metric-chip">
                    <i class="fa-regular fa-calendar-check"></i>
                    {{ $timeLabel }}
                </span>
                <h2>Booking Summary</h2>
                <p>Quick overview of booking performance by status.</p>
            </div>

            <div class="metric-time-toggle">
                <a href="{{ route('list.booking', ['time' => 'this_week']) }}"
                   class="time-pill {{ $time === 'this_week' ? 'active' : '' }}">
                    This week
                </a>
                <a href="{{ route('list.booking', ['time' => 'last_week']) }}"
                   class="time-pill {{ $time === 'last_week' ? 'active' : '' }}">
                    Last week
                </a>
            </div>
        </div>

        <div class="metric-grid">
            <div class="metric-card metric-all">
                <div class="metric-label">Total Bookings</div>
                <div class="metric-value">{{ $totalBookings }}</div>
                <div class="metric-sub">All statuses combined</div>
            </div>

            <div class="metric-card metric-confirmed">
                <div class="metric-label">Confirmed</div>
                <div class="metric-value">{{ $totalConfirmed }}</div>
                <div class="metric-sub">Successfully confirmed bookings</div>
            </div>

            <div class="metric-card metric-processing">
                <div class="metric-label">Processing</div>
                <div class="metric-value">{{ $totalProcessing }}</div>
                <div class="metric-sub">Waiting for confirmation</div>
            </div>

            <div class="metric-card metric-cancel">
                <div class="metric-label">Cancelled</div>
                <div class="metric-value">{{ $totalCancel }}</div>
                <div class="metric-sub">Cancelled by staff/customer</div>
            </div>
        </div>
    </div>

    {{-- FILTERS / SEARCH --}}
    <div class="actions-container">
        <div class="left-actions">
            <div class="filter-dropdown">
                <label class="filter-label">Branch</label>
                <div class="filter-inner">
                    <select id="branch-filter" class="filter-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <div class="filter-dropdown">
                <label class="filter-label">Status</label>
                <div class="filter-inner">
                    <select id="status-filter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="cancel">Cancel</option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <div class="date-range">
                <label class="filter-label">From date</label>
                <div class="date-row">
                    <input type="date" id="from-date" class="filter-date-input">
                    <button type="button" id="clear-dates" class="pill-btn">
                        <i class="fas fa-eraser"></i>
                        <span>Clear</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="search-container">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search bookings by name, phone, branch..." id="booking-search">
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bookings-table">
        <div class="table-head-row">
            <h2>Recent Bookings</h2>
            <span class="sub">
                Showing {{ $bookings->count() }} of {{ $bookings->total() }} records · {{ $timeLabel }}
            </span>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Branch</th>
                        <th>Booking Time</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bookings as $booking)
                        <tr
                            data-branch="{{ $booking->branch_id }}"
                            data-status="{{ $booking->status }}"
                            data-booking-date="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}"
                        >
                            <td class="cell-id">#{{ $booking->id }}</td>

                            <td>
                                <div class="customer-info">
                                    <span class="customer-name kh-battambang">{{ $booking->name }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="customer-contact">
                                    <i class="fas fa-phone-alt"></i>
                                    <span>{{ $booking->phone }}</span>
                                </div>
                            </td>

                            <td class="kh-battambang">
                                {{ $booking->branch->name ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="date-stack">
                                    <span class="date-main">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}
                                    </span>
                                    <span class="date-sub">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:ia') }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="status-pill status-{{ $booking->status ?? 'unknown' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td class="cell-actions">
                                <a href="{{ route('view.booking', $booking->id) }}"
                                   class="action-btn view-btn"
                                   title="View Booking">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>

                                <a href="{{ route('formupdate.booking', $booking->id) }}"
                                   class="action-btn edit-btn"
                                   title="Edit Booking">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>

                                <a href="{{ route('delete.booking', $booking->id) }}"
                                   class="action-btn delete-btn"
                                   title="Delete Booking"
                                   onclick="return confirm('Are you sure you want to delete this booking?')">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
:root{
  --brand:#021937;
  --brand-soft:#041f46;
  --accent:#0ea5e9;

  --ink:#020617;
  --muted:#6b7280;
  --bg:#f3f4f8;
  --panel:#ffffff;
  --line:#e5e7eb;

  --ok:#16a34a;
  --warn:#eab308;
  --bad:#ef4444;

  --radius-lg:18px;
  --radius-md:12px;
  --shadow-lg:0 22px 55px rgba(2,15,33,.40);
  --shadow-md:0 12px 28px rgba(15,23,42,.16);
}

body{
  font-family:"Battambang","Khmer OS Battambang","Noto Sans Khmer","Hanuman",system-ui,sans-serif;
  background:
    radial-gradient(circle at top left,rgba(2,25,55,.16),transparent 60%),
    radial-gradient(circle at bottom right,rgba(37,99,235,.16),transparent 60%),
    #e5e7eb;
}

.kh-battambang{
  font-family:"Khmer OS Battambang","Battambang","Noto Sans Khmer","Hanuman",system-ui,sans-serif !important;
  font-weight:400;
}

.booking-page{
  padding:20px;
}

/* HEADER */
.header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:18px;
  margin-bottom:18px;
  padding:16px 18px;
  background:linear-gradient(135deg,#021937,#041f46);
  border-radius:var(--radius-lg);
  border:1px solid rgba(148,163,184,.8);
  box-shadow:var(--shadow-lg);
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
}
.header::after{
  content:"";
  position:absolute;
  right:-60px;
  bottom:-80px;
  width:260px;
  height:260px;
  background:radial-gradient(circle at center,rgba(248,250,252,.9),transparent 65%);
  opacity:.18;
  border-radius:999px;
}
.header-left{
  display:flex;
  flex-direction:column;
  gap:6px;
  position:relative;
  z-index:1;
}

.eyebrow{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 12px;
  border-radius:999px;
  border:1px solid rgba(148,163,184,.7);
  font-size:11px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:#cbd5f5;
  background:rgba(15,23,42,.6);
}

.eyebrow .dot{
  width:8px;
  height:8px;
  border-radius:999px;
  background:#22c55e;
  box-shadow:0 0 0 6px rgba(34,197,94,.35);
}

.header-left h1{
  margin:0;
  font-size:22px;
  font-weight:700;
  letter-spacing:.02em;
  color:#f9fafb;
}

.header-left p{
  margin:0;
  font-size:12.5px;
  color:#9ca3af;
}

.user-info{
  display:flex;
  align-items:center;
  gap:10px;
  position:relative;
  z-index:1;
}

.profile-username{
  display:flex;
  flex-direction:column;
  text-align:right;
  font-size:12px;
  color:#cbd5f5;
}

.profile-username .hi{
  font-size:11px;
  color:#9ca3af;
}

.profile-username .fw-bold{
  font-size:13px;
  font-weight:600;
  color:#e5e7eb;
}

.avatar-sm{
  width:40px;
  height:40px;
  border-radius:999px;
  overflow:hidden;
  border:2px solid rgba(125,211,252,.9);
  box-shadow:0 10px 25px rgba(56,189,248,.7);
}

.avatar-img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* METRICS */
.booking-metrics{
  margin:18px 0;
  padding:16px 18px 14px;
  border-radius:var(--radius-lg);
  background:linear-gradient(135deg,rgba(15,23,42,.96),#020617);
  border:1px solid rgba(148,163,184,.8);
  box-shadow:var(--shadow-md);
  color:#e5e7eb;
}

.metric-head{
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:16px;
  margin-bottom:12px;
}

.metric-head h2{
  margin:4px 0 2px;
  font-size:17px;
  font-weight:600;
  color:#e5e7eb;
}

.metric-head p{
  margin:0;
  font-size:12px;
  color:#9ca3af;
}

.metric-chip{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:5px 10px;
  border-radius:999px;
  background:rgba(15,23,42,.9);
  border:1px solid rgba(148,163,184,.7);
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.12em;
}
.metric-chip i{
  font-size:11px;
  color:#38bdf8;
}

.metric-time-toggle{
  display:flex;
  gap:8px;
}

.time-pill{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:6px 12px;
  border-radius:999px;
  border:1px solid rgba(148,163,184,.7);
  font-size:11px;
  color:#e5e7eb;
  text-decoration:none;
  background:rgba(15,23,42,.85);
  transition:background .18s ease, border-color .18s ease, transform .08s ease, box-shadow .12s ease;
}
.time-pill:hover{
  transform:translateY(-1px);
  box-shadow:0 12px 30px rgba(15,23,42,.7);
}
.time-pill.active{
  background:linear-gradient(135deg,#0ea5e9,#38bdf8);
  border-color:transparent;
  color:#0b1120;
  font-weight:600;
}

/* METRIC CARDS GRID */
.metric-grid{
  display:grid;
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:12px;
}

.metric-card{
  padding:10px 12px;
  border-radius:var(--radius-md);
  background:rgba(15,23,42,.88);
  border:1px solid rgba(148,163,184,.7);
  box-shadow:0 14px 45px rgba(15,23,42,.75);
  position:relative;
  overflow:hidden;
  transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease, background .12s ease;
}
.metric-card::after{
  content:"";
  position:absolute;
  right:-26px;
  bottom:-26px;
  width:80px;
  height:80px;
  border-radius:999px;
  background:radial-gradient(circle at center,rgba(248,250,252,.45),transparent 60%);
  opacity:.2;
}
.metric-card:hover{
  transform:translateY(-3px);
  box-shadow:0 18px 55px rgba(15,23,42,.9);
  border-color:#38bdf8;
}

.metric-label{
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.13em;
  color:#9ca3af;
  margin-bottom:4px;
}

.metric-value{
  font-size:22px;
  font-weight:700;
  color:#f9fafb;
  margin-bottom:2px;
}

.metric-sub{
  font-size:11px;
  color:#9ca3af;
}

/* color accents for each card */
.metric-all{
  box-shadow:0 18px 55px rgba(56,189,248,.42);
}
.metric-confirmed{
  border-color:rgba(34,197,94,.6);
}
.metric-processing{
  border-color:rgba(234,179,8,.7);
}
.metric-cancel{
  border-color:rgba(239,68,68,.7);
}

/* ACTION BAR */
.actions-container{
  display:flex;
  justify-content:space-between;
  align-items:flex-end;
  margin:18px 0 18px;
  flex-wrap:wrap;
  gap:16px;
}

.left-actions{
  display:flex;
  align-items:flex-end;
  gap:14px;
  flex-wrap:wrap;
}

.filter-dropdown{
  display:flex;
  flex-direction:column;
  gap:4px;
  min-width:170px;
}

.filter-label{
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:#6b7280;
}

.filter-inner{
  position:relative;
}

.filter-select{
  appearance:none;
  padding:9px 32px 9px 11px;
  border-radius:var(--radius-md);
  border:1px solid var(--line);
  background:#ffffff;
  font-size:13px;
  cursor:pointer;
  width:100%;
  outline:none;
  transition:border-color .18s ease,
           box-shadow .18s ease,
           background .18s ease,
           transform .08s ease;
}

.filter-select:focus{
  border-color:#0ea5e9;
  box-shadow:0 0 0 1px rgba(14,165,233,.35);
  transform:translateY(-1px);
}

.filter-dropdown i{
  position:absolute;
  right:10px;
  top:50%;
  transform:translateY(-50%);
  pointer-events:none;
  color:#9ca3af;
  font-size:11px;
}

.date-range{
  display:flex;
  flex-direction:column;
  gap:4px;
}

.date-row{
  display:flex;
  align-items:center;
  gap:8px;
  flex-wrap:wrap;
}

.filter-date-input{
  padding:8px 10px;
  border-radius:var(--radius-md);
  border:1px solid var(--line);
  background:#ffffff;
  font-size:13px;
  outline:none;
  transition:border-color .18s ease, box-shadow .18s ease;
}

.filter-date-input:focus{
  border-color:#0ea5e9;
  box-shadow:0 0 0 1px rgba(14,165,233,.35);
}

.pill-btn{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:8px 11px;
  border-radius:999px;
  border:1px solid #e5e7eb;
  background:#f9fafb;
  font-size:12px;
  cursor:pointer;
  color:#1f2937;
  transition:background .15s ease,
           box-shadow .15s ease,
           transform .08s ease;
}
.pill-btn i{
  font-size:11px;
  color:#6b7280;
}
.pill-btn:hover{
  background:#e5e7eb;
  box-shadow:0 8px 20px rgba(148,163,184,.35);
  transform:translateY(-1px);
}

.search-container{
  display:flex;
  align-items:flex-end;
}

.search-bar{
  position:relative;
  min-width:240px;
}

.search-bar input{
  width:100%;
  padding:9px 11px 9px 30px;
  border-radius:999px;
  border:1px solid var(--line);
  background:#ffffff;
  font-size:13px;
  outline:none;
  transition:border-color .18s ease, box-shadow .18s ease;
}

.search-bar input:focus{
  border-color:#0ea5e9;
  box-shadow:0 0 0 1px rgba(14,165,233,.35);
}

.search-bar i{
  position:absolute;
  left:10px;
  top:50%;
  transform:translateY(-50%);
  font-size:11px;
  color:#9ca3af;
}

/* TABLE CARD */
.bookings-table{
  background:var(--panel);
  border-radius:var(--radius-lg);
  padding:16px 16px 12px;
  box-shadow:var(--shadow-md);
  border:1px solid #e5e7eb;
}

.table-head-row{
  display:flex;
  align-items:baseline;
  justify-content:space-between;
  margin-bottom:10px;
}

.table-head-row h2{
  margin:0;
  font-size:16px;
  font-weight:700;
  color:var(--ink);
}

.table-head-row .sub{
  font-size:11px;
  color:var(--muted);
}

/* TABLE */
.table-wrapper{
  width:100%;
  overflow-x:auto;
  border-radius:var(--radius-md);
  border:1px solid #e5e7eb;
}

table{
  width:100%;
  border-collapse:collapse;
  font-size:13px;
}

thead{
  background:#f9fafb;
}

thead th{
  text-align:left;
  padding:9px 10px;
  border-bottom:1px solid #e5e7eb;
  font-weight:600;
  color:#6b7280;
  white-space:nowrap;
  font-size:12px;
}

tbody tr{
  transition:background .15s ease,
             transform .08s ease,
             box-shadow .12s ease;
  opacity:0;
  animation:rowFade .35s ease forwards;
}

tbody tr:nth-child(1){animation-delay:.02s;}
tbody tr:nth-child(2){animation-delay:.04s;}
tbody tr:nth-child(3){animation-delay:.06s;}
tbody tr:nth-child(4){animation-delay:.08s;}
tbody tr:nth-child(5){animation-delay:.10s;}

tbody tr:nth-child(even){
  background:#fdfdfd;
}

tbody tr:hover{
  background:rgba(2,25,55,.03);
  transform:translateY(-1px);
  box-shadow:0 12px 26px rgba(148,163,184,.35);
}

tbody td{
  padding:8px 10px;
  border-bottom:1px solid #e5e7eb;
  vertical-align:middle;
}

.cell-id{
  font-weight:600;
  color:#1f2937;
}

.customer-info{
  display:flex;
  flex-direction:column;
}

.customer-name{
  font-weight:500;
  color:#111827;
}

.customer-contact{
  display:inline-flex;
  align-items:center;
  gap:6px;
  color:#374151;
  font-size:12px;
}

.customer-contact i{
  font-size:11px;
  color:#6b7280;
}

.date-stack{
  display:flex;
  flex-direction:column;
  gap:2px;
}

.date-main{
  font-weight:500;
  color:#111827;
}

.date-sub{
  font-size:11px;
  color:#6b7280;
}

/* STATUS PILL */
.status-pill{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-width:80px;
  padding:5px 9px;
  border-radius:999px;
  font-size:11px;
  font-weight:700;
  text-transform:capitalize;
  border:1px solid transparent;
}
.status-confirmed{
  background:rgba(22,163,74,.08);
  border-color:rgba(22,163,74,.25);
  color:#166534;
}
.status-processing{
  background:rgba(234,179,8,.10);
  border-color:rgba(234,179,8,.3);
  color:#92400e;
}
.status-cancel{
  background:rgba(239,68,68,.08);
  border-color:rgba(239,68,68,.28);
  color:#991b1b;
}
.status-unknown{
  background:rgba(148,163,184,.18);
  border-color:rgba(148,163,184,.4);
  color:#374151;
}

/* ACTION BUTTONS */
.cell-actions{
  display:flex;
  justify-content:flex-end;
  gap:6px;
  white-space:nowrap;
}

.action-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  padding:6px 10px;
  border-radius:999px;
  border:1px solid #e5e7eb;
  background:#ffffff;
  font-size:12px;
  color:#4b5563;
  cursor:pointer;
  transition:background .15s ease,
           color .15s ease,
           box-shadow .15s ease,
           transform .08s ease;
}
.action-btn i{
  font-size:11px;
}
.action-btn span{
  font-size:11px;
  font-weight:600;
}
.action-btn:hover{
  transform:translateY(-1px);
  box-shadow:0 8px 18px rgba(148,163,184,.45);
}

.view-btn{
  border-color:rgba(14,165,233,.3);
  color:#0369a1;
}
.view-btn:hover{
  background:rgba(14,165,233,.08);
}

.edit-btn{
  border-color:rgba(2,25,55,.45);
  color:#021937;
}
.edit-btn:hover{
  background:rgba(2,25,55,.06);
}

.delete-btn{
  border-color:rgba(239,68,68,.4);
  color:#b91c1c;
}
.delete-btn:hover{
  background:rgba(239,68,68,.08);
}

.table-footer{
  margin-top:10px;
}

/* ANIMATION */
@keyframes rowFade{
  from{opacity:0;transform:translateY(6px);}
  to{opacity:1;transform:translateY(0);}
}

/* RESPONSIVE */
@media (max-width:960px){
  .header{
    flex-direction:column;
    align-items:flex-start;
  }
  .user-info{
    align-self:flex-end;
  }
  .metric-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}

@media (max-width:768px){
  .booking-page{
    padding:12px;
  }
  .actions-container{
    flex-direction:column;
    align-items:flex-start;
  }
  .search-bar{
    width:100%;
  }
}

@media (max-width:640px){
  .metric-head{
    flex-direction:column;
    align-items:flex-start;
  }
  .metric-time-toggle{
    width:100%;
  }
  .metric-time-toggle .time-pill{
    flex:1;
    justify-content:center;
  }
}

@media (max-width:480px){
  .action-btn span{
    display:none;
  }
  .metric-grid{
    grid-template-columns:1fr;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const branchFilter  = document.getElementById('branch-filter');
    const statusFilter  = document.getElementById('status-filter');
    const searchInput   = document.getElementById('booking-search');
    const fromDateInput = document.getElementById('from-date');
    const clearDatesBtn = document.getElementById('clear-dates');
    const bookingRows   = document.querySelectorAll('.bookings-table tbody tr');

    function parseISODate(str) {
        if (!str) return null;
        const [y, m, d] = str.split('-').map(Number);
        if (!y || !m || !d) return null;
        return new Date(y, m - 1, d);
    }

    function filterBookings() {
        const branchValue = branchFilter.value;
        const statusValue = statusFilter.value;
        const searchValue = (searchInput.value || '').toLowerCase();
        const fromDate    = parseISODate(fromDateInput.value);

        bookingRows.forEach(row => {
            const rowBranch = row.getAttribute('data-branch');
            const rowStatus = row.getAttribute('data-status');
            const rowDate   = parseISODate(row.getAttribute('data-booking-date'));
            const text      = row.textContent.toLowerCase();

            const branchMatch = !branchValue || rowBranch === branchValue;
            const statusMatch = !statusValue || rowStatus === statusValue;
            const textMatch   = !searchValue || text.includes(searchValue);

            let dateMatch = true;
            if (fromDate) {
                dateMatch = !!rowDate && rowDate >= fromDate;
            }

            const show = branchMatch && statusMatch && textMatch && dateMatch;
            row.style.display = show ? '' : 'none';
        });
    }

    branchFilter.addEventListener('change', filterBookings);
    statusFilter.addEventListener('change', filterBookings);
    searchInput.addEventListener('input', filterBookings);
    fromDateInput.addEventListener('change', filterBookings);
    clearDatesBtn.addEventListener('click', () => {
        fromDateInput.value = '';
        filterBookings();
    });
});
</script>

@endsection
