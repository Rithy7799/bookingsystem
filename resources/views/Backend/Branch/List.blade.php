@extends('Backend.Layout.App') 

@section('content')
<div class="branch-page">

    <header class="branch-header">
        <div class="header-left">
            <div class="eyebrow">
                <span class="dot"></span>
                <span>Maple · Branch Management</span>
            </div>
            <h1>Branch Management</h1>
            <p>View, filter, and manage all Maple Salon branches in one place.</p>
        </div>

        <div class="user-info">
            <div class="profile-username">
                <span class="hi">Signed in as</span>
                <span class="fw-bold">{{ Auth::user()->name }}</span>
            </div>
            <div class="avatar-sm">
                <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
        </div>
    </header>

    <section class="branch-card">
        <div class="table-header">
            <div class="title-block">
                <h2>All Branches</h2>
                <span class="subtitle">Manage branch locations, contacts, and status.</span>
            </div>

            <div class="table-tools">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="branch-search" placeholder="Search branches by name, location, manager...">
                </div>

                <a href="{{ route('create.branch') }}" class="btn-add-branch">
                    <i class="fas fa-plus"></i>
                    <span>Add Branch</span>
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="branch-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Branch Name</th>
                        <th>Location</th>
                        <th>Manager</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="branch-table-body">
                    @foreach($branches as $branch)
                        <tr class="branch-row">
                            <td class="cell-id">#{{ $branch->id }}</td>
                            <td class="cell-name">{{ $branch->name }}</td>
                            <td class="cell-location">{{ $branch->location }}</td>
                            <td class="cell-manager">{{ $branch->manager }}</td>
                            <td>
                                @php
                                    $statusClass = $branch->status == 'active'
                                        ? 'status-active'
                                        : ($branch->status == 'inactive' ? 'status-inactive' : 'status-pending');
                                @endphp
                                <span class="status-pill {{ $statusClass }}">
                                    {{ ucfirst($branch->status) }}
                                </span>
                            </td>
                            <td class="cell-actions">
                                <a href="{{ route('formupdate.branch', $branch->id) }}"
                                   class="action-btn edit-btn"
                                   title="Edit Branch">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('delete.branch', $branch->id) }}"
                                      method="POST"
                                      class="inline-form"
                                      onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="action-btn delete-btn"
                                            title="Delete Branch">
                                        <i class="fas fa-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- If later you use pagination, you can put it here --}}
        {{-- <div class="table-footer mt-3">
            {{ $branches->links('pagination::bootstrap-5') }}
        </div> --}}
    </section>

</div>

<style>
:root{
  --brand:#6d0a61;
  --brand-2:#4c0c5a;
  --ink:#0f172a;
  --muted:#6b7280;
  --line:#e5e7eb;
  --panel:#ffffff;
  --bg:#f3f4f8;
  --danger:#ef4444;
}

.branch-page{
  padding:20px;
  background:
    radial-gradient(circle at top left,rgba(129,140,248,.16),transparent 60%),
    radial-gradient(circle at bottom right,rgba(236,72,153,.18),transparent 60%),
    var(--bg);
}

/* HEADER */
.branch-header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:18px;
  padding:16px 18px;
  border-radius:18px;
  background:linear-gradient(120deg,rgba(15,23,42,.98),rgba(15,23,42,.94));
  color:#e5e7eb;
  box-shadow:0 18px 45px rgba(15,23,42,.25);
  border:1px solid rgba(148,163,184,.5);
  margin-bottom:18px;
  position:relative;
  overflow:hidden;
}

.branch-header::after{
  content:"";
  position:absolute;
  inset:auto -40px -60px auto;
  width:200px;
  height:200px;
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
  box-shadow:0 0 0 6px rgba(34,197,94,.45);
}

.header-left h1{
  margin:0;
  font-size:22px;
  font-weight:700;
  letter-spacing:.02em;
}

.header-left p{
  margin:0;
  font-size:12.5px;
  color:#d1d5db;
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
  color:#e5e7eb;
}

.profile-username .hi{
  font-size:11px;
  color:#9ca3af;
}

.profile-username .fw-bold{
  font-size:13px;
  font-weight:600;
}

.avatar-sm{
  width:40px;
  height:40px;
  border-radius:999px;
  overflow:hidden;
  border:2px solid rgba(129,140,248,.9);
  box-shadow:0 10px 25px rgba(129,140,248,.7);
}

.avatar-img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* CARD + TABLE */
.branch-card{
  background:var(--panel);
  border-radius:18px;
  border:1px solid var(--line);
  box-shadow:0 12px 35px rgba(15,23,42,.08);
  padding:16px 16px 14px;
}

.table-header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:14px;
  margin-bottom:10px;
  flex-wrap:wrap;
}

.title-block h2{
  margin:0;
  font-size:16px;
  font-weight:700;
  color:var(--ink);
}

.title-block .subtitle{
  font-size:11px;
  color:var(--muted);
}

.table-tools{
  display:flex;
  align-items:center;
  gap:10px;
  flex-wrap:wrap;
}

/* SEARCH */
.search-bar{
  position:relative;
  min-width:220px;
}

.search-bar input{
  width:100%;
  padding:8px 11px 8px 28px;
  border-radius:999px;
  border:1px solid var(--line);
  font-size:13px;
  outline:none;
  transition:border-color .15s ease,box-shadow .15s ease,transform .08s ease;
}

.search-bar input:focus{
  border-color:#6366f1;
  box-shadow:0 0 0 1px rgba(99,102,241,.28);
  transform:translateY(-1px);
}

.search-bar i{
  position:absolute;
  left:10px;
  top:50%;
  transform:translateY(-50%);
  font-size:11px;
  color:#9ca3af;
}

/* ADD BRANCH BUTTON */
.btn-add-branch{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:8px 14px;
  border-radius:999px;
  background:linear-gradient(120deg,var(--brand),var(--brand-2));
  color:#f9fafb;
  font-size:12px;
  font-weight:600;
  text-decoration:none;
  border:none;
  box-shadow:0 12px 28px rgba(109,10,97,.35);
  transition:filter .15s ease,transform .08s ease,box-shadow .15s ease;
  white-space:nowrap;
}

.btn-add-branch i{
  font-size:11px;
}

.btn-add-branch:hover{
  filter:brightness(1.05);
  transform:translateY(-1px);
  box-shadow:0 16px 40px rgba(109,10,97,.45);
}

/* TABLE */
.table-wrapper{
  margin-top:6px;
  border-radius:14px;
  border:1px solid var(--line);
  overflow-x:auto;
}

.branch-table{
  width:100%;
  border-collapse:collapse;
  font-size:13px;
}

.branch-table thead{
  background:#f9fafb;
}

.branch-table th{
  padding:9px 10px;
  border-bottom:1px solid var(--line);
  font-size:12px;
  font-weight:600;
  color:#6b7280;
  white-space:nowrap;
}

.branch-table tbody tr{
  transition:background .15s ease,transform .08s ease,box-shadow .12s ease;
  opacity:0;
  animation:rowFade .35s ease forwards;
}

.branch-table tbody tr:nth-child(1){animation-delay:.02s;}
.branch-table tbody tr:nth-child(2){animation-delay:.04s;}
.branch-table tbody tr:nth-child(3){animation-delay:.06s;}
.branch-table tbody tr:nth-child(4){animation-delay:.08s;}
.branch-table tbody tr:nth-child(5){animation-delay:.10s;}

.branch-table tbody tr:nth-child(even){
  background:#fdfdfd;
}

.branch-table tbody tr:hover{
  background:#f3e8ff;
  transform:translateY(-1px);
  box-shadow:0 12px 26px rgba(148,163,184,.4);
}

.branch-table td{
  padding:8px 10px;
  border-bottom:1px solid var(--line);
  vertical-align:middle;
}

.cell-id{
  font-weight:600;
  color:#4b5563;
}

.cell-name{
  font-weight:500;
  color:var(--ink);
}

.cell-location,
.cell-manager{
  color:#374151;
}

/* STATUS */
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

.status-active{
  background:rgba(22,163,74,.08);
  border-color:rgba(22,163,74,.25);
  color:#166534;
}

.status-inactive{
  background:rgba(156,163,175,.14);
  border-color:rgba(156,163,175,.4);
  color:#374151;
}

.status-pending{
  background:rgba(234,179,8,.10);
  border-color:rgba(234,179,8,.3);
  color:#92400e;
}

/* ACTIONS */
.cell-actions{
  display:flex;
  justify-content:flex-end;
  gap:6px;
  white-space:nowrap;
}

.inline-form{
  display:inline-block;
  margin:0;
}

.action-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  padding:6px 10px;
  border-radius:999px;
  border:1px solid var(--line);
  background:#ffffff;
  font-size:12px;
  color:#4b5563;
  cursor:pointer;
  text-decoration:none;
  transition:background .15s ease,color .15s ease,box-shadow .15s ease,transform .08s ease;
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

.edit-btn{
  border-color:rgba(59,130,246,.35);
  color:#1d4ed8;
}

.edit-btn:hover{
  background:rgba(59,130,246,.08);
}

.delete-btn{
  border-color:rgba(239,68,68,.45);
  color:#b91c1c;
}

.delete-btn:hover{
  background:rgba(239,68,68,.08);
}

/* ANIM */
@keyframes rowFade{
  from{opacity:0;transform:translateY(6px);}
  to{opacity:1;transform:translateY(0);}
}

/* RESPONSIVE */
@media (max-width:960px){
  .branch-header{
    flex-direction:column;
    align-items:flex-start;
  }
  .user-info{
    align-self:flex-end;
  }
}

@media (max-width:768px){
  .branch-page{
    padding:12px;
  }
  .table-header{
    align-items:flex-start;
  }
  .table-tools{
    width:100%;
    justify-content:space-between;
  }
  .search-bar{
    flex:1;
  }
}

@media (max-width:520px){
  .table-tools{
    flex-direction:column;
    align-items:stretch;
  }
  .btn-add-branch{
    justify-content:center;
    width:100%;
  }
  .action-btn span{
    display:none;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('branch-search');
    const rows = document.querySelectorAll('.branch-row');

    function filterBranches() {
        const q = (searchInput.value || '').toLowerCase();

        rows.forEach(row => {
            const name     = row.querySelector('.cell-name')?.textContent.toLowerCase() || '';
            const location = row.querySelector('.cell-location')?.textContent.toLowerCase() || '';
            const manager  = row.querySelector('.cell-manager')?.textContent.toLowerCase() || '';
            const joined   = [name, location, manager].join(' ');

            row.style.display = !q || joined.includes(q) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterBranches);
});
</script>
@endsection
