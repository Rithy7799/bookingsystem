<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&display=swap" rel="stylesheet">
<style>
  .kh-battambang{
    font-family: "Battambang","Khmer OS Battambang","Noto Sans Khmer","Hanuman",system-ui,sans-serif;
    font-weight: 400; 
  }
</style>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    :root {
      --primary: #1b3ba5;
      --secondary: #1b0f79;
      --accent: #c77dff;
      --light: #faf5ff;
      --dark: #021937;
      --success: #5a8b46;
      --error: #ff4d6d;
      --warning: #ffaa00;
      --sidebar-width: 250px;
      --sidebar-collapsed: 80px;
      --transition-speed: 0.3s;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
    body { background-color: #f5f5f5; color: #333; line-height: 1.6; transition: margin-left var(--transition-speed); }
    a { text-decoration: none; color: inherit; }
    .dashboard-container { display: grid; grid-template-columns: var(--sidebar-width) 1fr; min-height: 100vh; transition: grid-template-columns var(--transition-speed); }
    .sidebar { background: var(--dark); color: #fff; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: sticky; top: 0; height: 100vh; overflow-y: auto; transition: width var(--transition-speed); z-index: 1000; }
    .logo { text-align: center; padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; gap: 10px; transition: padding var(--transition-speed); }
    .logo h2 { color: #fff; font-size: 1.5rem; margin: 0; transition: opacity var(--transition-speed), font-size var(--transition-speed); white-space: nowrap; overflow: hidden; }
    .logo-icon { font-size: 1.8rem; color: var(--accent); }
    .nav-menu { margin-top: 30px; }
    .nav-item { padding: 15px 20px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; margin: 8px 15px; border-radius: 8px; position: relative; overflow: hidden; }
    .nav-item::before { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 4px; background: var(--accent); transform: scaleY(0); transition: transform 0.2s ease; }
    .nav-item:hover, .nav-item.active { background: rgba(137,27,150,0.2); }
    .nav-item.active::before { transform: scaleY(1); }
    .nav-item i { margin-right: 15px; font-size: 1.2rem; min-width: 24px; transition: margin var(--transition-speed); }
    .nav-item span { transition: opacity var(--transition-speed), transform var(--transition-speed); white-space: nowrap; }
    .nav-item:hover span { transform: translateX(5px); }
    .main-content { padding: 20px; overflow-x: hidden; transition: padding var(--transition-speed); }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); flex-wrap: wrap; gap: 15px; }
    .header h1 { color: var(--primary); margin: 0; font-weight: 600; font-size: 1.8rem; }
    .user-info { display: flex; align-items: center; gap: 15px; position: relative; }
    .user-info img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent); }
    .user-details { display: flex; flex-direction: column; }
    .user-name { font-weight: 500; }
    .user-role { font-size: 0.8rem; color: #777; }
    .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; overflow: hidden; }
    .stat-card::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg,var(--primary),var(--secondary)); transform: scaleX(0); transform-origin: left; transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
    .stat-card:hover::after { transform: scaleX(1); }
    .stat-info h3 { color: #555; font-size: 0.95rem; margin-bottom: 10px; font-weight: 500; }
    .stat-info p { font-size: 2rem; font-weight: 700; color: var(--primary); margin: 0; }
    .stat-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .bookings { background: #e3f2fd; color: #1976d2; }
    .revenue { background: #e8f5e9; color: var(--success); }
    .customers { background: #f3e5f5; color: var(--primary); }
    .services { background: #fff8e1; color: var(--warning); }
    .bookings-table { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-top: 30px; overflow-x: auto; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .table-header h2 { color: var(--dark); margin: 0; font-weight: 600; }
    .search-bar { display: flex; align-items: center; background: #f5f5f5; padding: 10px 20px; border-radius: 25px; min-width: 250px; transition: box-shadow 0.3s ease; }
    .search-bar:focus-within { box-shadow: 0 0 0 2px var(--accent); }
    .search-bar input { border: none; background: transparent; outline: none; margin-left: 10px; width: 100%; }
    table { width: 100%; border-collapse: collapse; min-width: 600px; }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
    th { color: var(--dark); font-weight: 600; background-color: #f9f9f9; position: sticky; top: 0; }
    tr { transition: background-color 0.2s ease; }
    tr:hover { background-color: #f5f5f5; }
    .status { padding: 7px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: inline-block; transition: transform 0.2s ease; }
    .status:hover { transform: scale(1.05); }
    .confirmed { background: #e8f5e9; color: var(--success); }
    .pending { background: #fff8e1; color: var(--warning); }
    .cancelled { background: #ffebee; color: var(--error); }
    .action-btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; margin-right: 5px; font-size: 0.8rem; transition: all 0.2s ease; }
    .action-btn:hover { transform: translateY(-2px); box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .edit-btn { background: var(--primary); color: #fff; }
    .cancel-btn { background: var(--error); color: #fff; }
    .sidebar-collapsed .dashboard-container { grid-template-columns: var(--sidebar-collapsed) 1fr; }
    .sidebar-collapsed .logo h2 { opacity: 0; font-size: 0; }
    .sidebar-collapsed .nav-item span { opacity: 0; transform: translateX(-10px); }
    .sidebar-collapsed .nav-item i { margin-right: 0; }
    .sidebar-collapsed .main-content { padding-left: 30px; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.5s ease forwards; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    @media (max-width: 992px) {
      .dashboard-container { grid-template-columns: var(--sidebar-collapsed) 1fr; }
      .logo h2, .nav-item span { opacity: 0; }
      .nav-item { justify-content: center; padding: 15px 0; margin: 8px 10px; }
      .nav-item i { margin-right: 0; font-size: 1.3rem; }
    }
    @media (max-width: 768px) {
      .stats-container { grid-template-columns: 1fr 1fr; }
      .sidebar { position: fixed; left: -100%; transition: left var(--transition-speed); }
      .sidebar-open .sidebar { left: 0; }
      .sidebar-open .main-content { margin-left: var(--sidebar-width); }
      .mobile-menu-toggle { display: block; position: fixed; top: 20px; left: 20px; background: var(--primary); color: #fff; border: none; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 999; }
    }
    @media (max-width: 576px) {
      .stats-container { grid-template-columns: 1fr; }
      .header, .table-header { flex-direction: column; align-items: flex-start; }
      .search-bar { width: 100%; }
      .header { padding: 15px; }
      .user-info { flex-direction: column; align-items: flex-start; }
      .user-details { margin-top: 10px; }
    }
  </style>
</head>
<body>
  <button class="mobile-menu-toggle" style="display:none;"><i class="fas fa-bars"></i></button>
  <div class="dashboard-container">
    <div class="sidebar">
      <div class="logo">
        <i class="fas fa-spa logo-icon"></i>
        <h2>Dashboard</h2>
      </div>
      <div class="nav-menu">
        <a href="{{ url('/Admin') }}" class="nav-item {{request()->routeIs('dashboard') ? 'active' : ''}} animate-fadeIn delay-1">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('list.booking') }}"
          class="nav-item {{ request()->routeIs('list.booking') ? 'active' : '' }} animate-fadeIn delay-2">
          <i class="fas fa-calendar-check"></i>
          <span>Bookings</span>
        </a>

        {{-- <a href="{{ route('list.product') }}"
          class="nav-item {{ request()->routeIs('list.product') ? 'active' : '' }} animate-fadeIn delay-2">
          <i class="fas fa-box-open"></i>
          <span>Product</span>
        </a> --}}

        {{-- <a href="{{ route('bookingandcontact.list') }}"
          class="nav-item {{ request()->routeIs('bookingandcontact.list')  }} animate-fadeIn delay-2">
          <i class="fas fa-address-book"></i>
          <span>Booking & Contact</span>
        </a> --}}

        <a href="{{ route('list.service') }}" class="nav-item animate-fadeIn delay-3">
          <i class="fas fa-spa"></i>
          <span>Services</span>
        </a>

        <a href="{{ route('list.branch') }}" class="nav-item {{request()->routeIs('list.branch') ? 'active' : ''}} animate-fadeIn delay-4">
          <i class="fas fa-store"></i>
          <span>Branch</span>
        </a>

        <a href="{{ route('reports.index') }}" class="nav-item animate-fadeIn">
          <i class="fas fa-chart-line"></i>
          <span>Report</span>
        </a>

        <a href="{{ route('list.user') }}" class="nav-item animate-fadeIn">
          <i class="fas fa-users"></i>
          <span>User</span>
        </a>

        <a href="{{ route('login') }}" class="nav-item animate-fadeIn">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </div>
    </div>

    @yield('content')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
      const body = document.body;

      if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function () {
          body.classList.toggle('sidebar-open');
        });
      }

      const navItems = document.querySelectorAll('.nav-item');
      navItems.forEach((item) => {
        item.addEventListener('mouseenter', function () {
          this.style.transform = 'translateX(5px)';
        });
        item.addEventListener('mouseleave', function () {
          this.style.transform = 'translateX(0)';
        });
      });

      const searchInput = document.querySelector('.search-bar input');
      if (searchInput) {
        searchInput.addEventListener('input', function () {
          const searchTerm = this.value.toLowerCase();
          const rows = document.querySelectorAll('tbody tr');
          rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
            if (text.includes(searchTerm)) row.style.animation = 'fadeIn 0.5s ease';
          });
        });
      }

      const editButtons = document.querySelectorAll('.edit-btn');
      const cancelButtons = document.querySelectorAll('.cancel-btn');

      editButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
          const bookingId = this.closest('tr')?.querySelector('td')?.textContent?.trim() || '';
          if (bookingId) alert(`Edit booking ${bookingId}`);
        });
      });

      cancelButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
          const tr = this.closest('tr');
          const bookingId = tr?.querySelector('td')?.textContent?.trim() || '';
          if (bookingId && confirm(`Are you sure you want to cancel booking ${bookingId}?`)) {
            const statusSpan = tr.querySelector('.status');
            if (statusSpan) {
              statusSpan.textContent = 'Cancelled';
              statusSpan.className = 'status cancelled';
            }
          }
        });
      });

      const statCards = document.querySelectorAll('.stat-card');
      statCards.forEach((card, index) => {
        card.style.animation = `fadeIn 0.5s ease ${index * 0.1}s forwards`;
        card.style.opacity = 0;
      });
    });
  </script>
</body>
</html>
