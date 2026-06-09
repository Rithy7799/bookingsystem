@extends('Backend.Layout.App')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&display=swap" rel="stylesheet">

<style>
        :root{
          --brand:#1c12a3;
          --brand-600:#132890;
          --accent:#a34cab;
          --ink:#0b1324;
          --muted:#6b7280;
          --bg:#f5f3fb;
          --panel:#ffffff;
          --line:#e6e3f2;
          --good:#16a34a;
          --warn:#f59e0b;
          --bad:#ef4444;
          --r:18px;
          --shadow:0 14px 40px rgba(17, 12, 34, .13);
          --anim:.22s cubic-bezier(.2,.7,.2,1);
        }
      td.name-cell.khmer-battambang,
      td.name-cell.khmer-battambang .name{
        font-family:"Khmer OS Battambang","Battambang",
          system-ui,-apple-system,"Segoe UI",Roboto,
          "Helvetica Neue",Arial,"Noto Sans","Khmer OS",sans-serif !important;
        font-size:.98rem;
        font-weight:400;
        line-height:1.5;
        letter-spacing:0;
      }


        .services-page{
          padding:18px;
          background:
            radial-gradient(circle at top left, rgba(163,76,171,.12), transparent 60%),
            radial-gradient(circle at top right, rgba(112,21,115,.12), transparent 60%),
            var(--bg);
          min-height:calc(100vh - 80px);
        }

        .services-page *{
          box-sizing:border-box;
        }

        .sp-head{
          display:flex;
          justify-content:space-between;
          align-items:center;
          gap:16px;
          padding:18px 20px;
          border-radius:24px;
          background:
            radial-gradient(1200px 240px at 5% -10%, rgba(163,76,171,.25), transparent 55%),
            radial-gradient(1200px 260px at 100% -30%, rgba(112,21,115,.18), transparent 65%),
            linear-gradient(135deg, rgba(255,255,255,.96), rgba(248,245,255,.96));
          border:1px solid rgba(255,255,255,.6);
          box-shadow:var(--shadow);
          position:relative;
          overflow:hidden;
        }

        .sp-head::after{
          content:"";
          position:absolute;
          inset:auto -80px -120px auto;
          width:220px;
          height:220px;
          border-radius:999px;
          background:radial-gradient(circle, rgba(255,255,255,.26), transparent 70%);
          opacity:.8;
        }

        .sp-left{
          position:relative;
          z-index:1;
        }

        .badge{
          display:inline-flex;
          gap:8px;
          align-items:center;
          padding:6px 12px;
          border-radius:999px;
          font-weight:700;
          font-size:.88rem;
          color:var(--brand);
          background:rgba(112,21,115,.08);
          border:1px dashed rgba(112,21,115,.25);
        }

        .sp-left h1{
          margin:.4rem 0 .15rem;
          font-size:1.65rem;
          font-weight:800;
        }

        .sp-left .muted{
          font-size:.9rem;
          color:var(--muted);
        }

        .sp-right{
          position:relative;
          z-index:1;
          display:flex;
          gap:10px;
          align-items:center;
        }

        .profile-username{
          font-size:.92rem;
          color:#111827;
        }

        .profile-username .fw-bold{
          font-weight:700;
        }

        .avatar-sm{
          width:40px;
          height:40px;
          border-radius:999px;
          overflow:hidden;
          border:2px solid #fff;
          box-shadow:0 4px 14px rgba(15,23,42,.25);
        }

        .avatar-img{
          width:100%;
          height:100%;
          object-fit:cover;
        }

        .actions{
          position:sticky;
          top:10px;
          z-index:5;
          display:flex;
          flex-wrap:wrap;
          gap:12px;
          justify-content:space-between;
          align-items:center;
          margin:18px 0 16px;
        }

        .btn{
          display:inline-flex;
          align-items:center;
          gap:8px;
          font-weight:700;
          font-size:.92rem;
          padding:10px 14px;
          border-radius:999px;
          border:1px solid transparent;
          cursor:pointer;
          text-decoration:none;
          transition:
            transform var(--anim),
            filter var(--anim),
            box-shadow var(--anim),
            background var(--anim),
            border-color var(--anim);
          white-space:nowrap;
        }

        .btn.primary{
          background:linear-gradient(135deg,var(--brand),var(--brand-600));
          color:#fff;
          box-shadow:0 14px 32px rgba(112,21,115,.35);
        }

        .btn.primary:hover{
          transform:translateY(-1px);
          filter:brightness(1.03);
        }

        .btn.outline{
          background:#fff;
          border-color:#e7e7ef;
          color:#374151;
        }

        .btn.outline:hover{
          border-color:var(--brand);
          box-shadow:0 6px 16px rgba(15,23,42,.08);
        }

        .btn.danger{
          background:linear-gradient(135deg,#f97373,#e11d48);
          color:#fff;
          box-shadow:0 10px 26px rgba(225,29,72,.35);
        }

        .btn.danger:hover{
          filter:brightness(.97);
        }

        .btn.tiny{
          padding:7px 10px;
          font-size:.86rem;
          border-radius:12px;
        }

        .hide-sm{display:inline;}

        @media (max-width:520px){
          .hide-sm{display:none;}
        }

        .search-wrap{
          position:relative;
          display:flex;
          align-items:center;
          min-width:220px;
          flex:1;
          max-width:420px;
        }

        .search-wrap i{
          position:absolute;
          left:12px;
          color:var(--muted);
          font-size:.9rem;
        }

        .search-input{
          width:100%;
          padding:10px 12px 10px 34px;
          border:1px solid rgba(226,232,240,1);
          background:#fff;
          border-radius:999px;
          outline:none;
          font-size:.9rem;
          transition:border var(--anim), box-shadow var(--anim), background var(--anim);
        }

        .search-input::placeholder{
          color:#9ca3af;
        }

        .search-input:focus{
          border-color:var(--brand);
          box-shadow:0 0 0 3px rgba(112,21,115,.15);
          background:#fff;
        }

        .card{
          background:var(--panel);
          border-radius:24px;
          box-shadow:var(--shadow);
          overflow:hidden;
          border:1px solid rgba(255,255,255,.9);
        }

        .card-head{
          display:flex;
          justify-content:space-between;
          align-items:center;
          gap:10px;
          padding:14px 18px;
          border-bottom:1px solid var(--line);
          background:linear-gradient(180deg,#ffffff,#faf7ff);
        }

        .pill{
          display:inline-flex;
          align-items:center;
          gap:8px;
          padding:8px 13px;
          border-radius:999px;
          background:linear-gradient(180deg,#faf6ff,#f3ecff);
          color:var(--brand);
          font-weight:800;
          font-size:.9rem;
          border:1px solid #efe8fb;
        }

        .pill strong{
          font-weight:800;
        }

        .pill.ghost{
          background:#f9fafb;
          color:#4b5563;
          border-color:#edf1f5;
          font-weight:600;
        }

        .table-wrap{
          overflow:auto;
        }

        .tbl{
          width:100%;
          border-collapse:separate;
          border-spacing:0;
          font-size:.9rem;
        }

        .tbl thead th{
          position:sticky;
          top:0;
          z-index:1;
          text-align:left;
          font-weight:800;
          letter-spacing:.22px;
          padding:12px 16px;
          background:linear-gradient(180deg,#ffffff,#f8f4ff);
          border-bottom:1px solid var(--line);
          color:#374151;
          font-size:.88rem;
          text-transform:uppercase;
        }

        .tbl tbody td{
          padding:11px 16px;
          border-bottom:1px solid var(--line);
          vertical-align:middle;
        }

        .tbl tbody tr:nth-child(even){
          background:#fdfbff;
        }

        .tbl tbody tr{
          transition:background var(--anim), transform var(--anim), box-shadow var(--anim);
        }

        .tbl tbody tr:hover{
          background:#faf5ff;
          transform:translateY(-1px);
          box-shadow:0 4px 14px rgba(148,112,177,.18);
        }

        /* softer style for name cell */
        .name-cell .name{
          font-weight:400 !important;
          font-size:.98rem;
        }

        .text-right{
          text-align:right;
        }

        td .btn{
          margin:1px 1px;
        }

        form.inline{
          display:inline-block;
        }

        .empty-row td{
          padding:28px 16px !important;
        }

        .empty{
          display:grid;
          place-items:center;
          gap:6px;
          color:var(--muted);
          text-align:center;
        }

        .empty i{
          font-size:1.6rem;
          color:#c4b2d6;
        }

        .empty .muted{
          font-size:.88rem;
        }

        .pager{
          padding:12px 14px 14px;
          display:flex;
          justify-content:center;
          background:#fff;
        }

        @media (max-width:768px){
          .actions{
            position:relative;
            gap:10px;
          }

          #addServiceBtn{
            position:fixed;
            right:16px;
            bottom:16px;
            border-radius:999px;
            padding:11px 16px;
            box-shadow:0 18px 40px rgba(112,21,115,.40);
            font-size:.9rem;
            z-index:20;
          }

          .sp-head{
            flex-direction:column;
            align-items:flex-start;
          }

          .sp-left h1{
            font-size:1.4rem;
          }
        }

        *{
          scroll-behavior:smooth;
        }
</style>

<div class="main-content services-page">
  <header class="sp-head">
    <div class="sp-left">
      <div class="badge">
        <i class="fas fa-scissors"></i>
        <span>Services / សេវាកម្ម</span>
      </div>
      <h1>Services Management</h1>
      <p class="muted">Create • Update • Delete • Manage price & packages</p>
    </div>
    <div class="sp-right">
      <span class="profile-username">
        <span class="fw-bold">{{ Auth::user()->name }}</span>
      </span>
      <div class="avatar-sm">
        <img src="{{ asset('User/' . Auth::user()->image) }}" alt="avatar" class="avatar-img rounded-circle">
      </div>
    </div>
  </header>

  <section class="actions">
    <a href="{{ route('create.service') }}" class="btn primary" id="addServiceBtn">
      <i class="fas fa-plus"></i>
      <span>New Service</span>
    </a>

    <div class="search-wrap">
      <i class="fas fa-search" aria-hidden="true"></i>
      <input
        type="text"
        id="serviceSearch"
        class="search-input"
        placeholder="Search services / ស្វែងរកសេវាកម្ម..."
      >
    </div>
  </section>

  <section class="card">
    <div class="card-head">
      <div class="pill">
        <i class="fas fa-list-ul"></i>
        <span>Total: <strong>{{ $services->total() }}</strong></span>
      </div>
      <div class="pill ghost">
        <i class="fas fa-layer-group"></i>
        <span>Page {{ $services->currentPage() }} / {{ $services->lastPage() }}</span>
      </div>
    </div>

    <div class="table-wrap">
      <table class="tbl" id="servicesTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Service Name</th>
            <th>Created</th>
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody id="servicesTbody">
          @forelse ($services as $service)
            <tr>
              <td>SID{{ $service->id }}</td>
            <td class="name-cell khmer-battambang">
                <span class="name">{{ $service->name }}</span>
            </td>

              <td>{{ $service->created_at?->format('d.m.Y') }}</td>
              <td class="text-right">
                <a
                  href="{{ route('formupdate.service', $service->id) }}"
                  class="btn tiny outline"
                  title="Edit"
                >
                  <i class="fas fa-edit"></i>
                  <span class="hide-sm">Edit</span>
                </a>

                <form
                  action="{{ route('delete.service', $service->id) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('Are you sure you want to delete {{ $service->name }}? This cannot be undone.')"
                >
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn tiny danger" title="Delete">
                    <i class="fas fa-trash"></i>
                    <span class="hide-sm">Delete</span>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr class="empty-row">
              <td colspan="4">
                <div class="empty">
                  <i class="fa-regular fa-box-open"></i>
                  <div>No services yet</div>
                  <p class="muted">Click “New Service” to create your first service.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="pager">
      {{ $services->links('pagination::bootstrap-5') }}
    </div>
  </section>
</div>

<script>
  (function () {
    const q = document.getElementById('serviceSearch');
    const tbody = document.getElementById('servicesTbody');
    const rows = Array.from(tbody.querySelectorAll('tr'))
      .filter(r => !r.classList.contains('empty-row'));

    if (!q || rows.length === 0) return;

    q.addEventListener('input', () => {
      const term = q.value.toLowerCase().trim();
      let visible = 0;

      rows.forEach(r => {
        const show = r.innerText.toLowerCase().includes(term);
        r.style.display = show ? '' : 'none';
        if (show) visible++;
      });

      let dynamicEmpty = tbody.querySelector('tr.__dynamic_empty');

      if (visible === 0) {
        if (!dynamicEmpty) {
          dynamicEmpty = document.createElement('tr');
          dynamicEmpty.className = 'empty-row __dynamic_empty';
          dynamicEmpty.innerHTML = `
            <td colspan="4">
              <div class="empty">
                <i class="fa-regular fa-face-frown"></i>
                <div>No matches</div>
                <p class="muted">Try a different keyword.</p>
              </div>
            </td>`;
          tbody.appendChild(dynamicEmpty);
        }
      } else if (dynamicEmpty) {
        dynamicEmpty.remove();
      }
    });
  })();
</script>
@endsection
