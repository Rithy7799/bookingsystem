<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Maple Salon · Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    :root {
      --primary:#1d2cf3;
      --primary-soft:#eef1ff;
      --primary-dark:#151a5c;
      --accent:#f97316;
      --accent-soft:rgba(249,115,22,.12);
      --bg:#050816;
      --card:#ffffff;
      --ink:#0f172a;
      --muted:#6b7280;

      --radius-xl:26px;
      --radius-lg:18px;
      --shadow-xl:0 24px 70px rgba(15,23,42,.55);
      --shadow-md:0 18px 40px rgba(15,23,42,.30);
    }

    * {
      box-sizing:border-box;
      margin:0;
      padding:0;
    }

    body {
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
      font-family:'Poppins',sans-serif;
      color:var(--ink);
      background:
        radial-gradient(circle at 10% 0%, rgba(59,130,246,.16), transparent 55%),
        radial-gradient(circle at 90% 100%, rgba(236,72,153,.20), transparent 55%),
        radial-gradient(circle at 50% 120%, rgba(56,189,248,.15), transparent 55%),
        #020617;
      overflow:hidden;
      position:relative;
    }

    /* floating glow orbs */
    .orb {
      position:absolute;
      border-radius:999px;
      filter:blur(36px);
      opacity:.55;
      mix-blend-mode:screen;
      pointer-events:none;
      animation:float 12s ease-in-out infinite alternate;
    }
    .orb.orb-1 {
      width:280px;height:280px;
      background:rgba(59,130,246,.65);
      top:-80px;left:-60px;
      animation-delay:-2s;
    }
    .orb.orb-2 {
      width:260px;height:260px;
      background:rgba(236,72,153,.65);
      bottom:-60px;right:-30px;
      animation-delay:-4s;
    }
    .orb.orb-3 {
      width:200px;height:200px;
      background:rgba(34,197,94,.55);
      top:50%;right:10%;
      transform:translateY(-50%);
      animation-delay:-6s;
    }

    @keyframes float {
      0%   {transform:translate3d(0,0,0);}
      100% {transform:translate3d(30px,-30px,0);}
    }

    /* AUTH SHELL */
    .auth-shell {
      position:relative;
      width:100%;
      max-width:980px;
      border-radius:32px;
      padding:1px;
      background:linear-gradient(135deg,rgba(148,163,184,.7),rgba(59,130,246,.85),rgba(236,72,153,.9));
      box-shadow:var(--shadow-xl);
      z-index:10;
    }

    .auth-inner {
      display:grid;
      grid-template-columns:minmax(0,1.1fr) minmax(0,1.1fr);
      gap:0;
      background:linear-gradient(145deg,rgba(15,23,42,.96),rgba(15,23,42,.94));
      border-radius:32px;
      overflow:hidden;
      backdrop-filter:blur(26px);
    }

    /* LEFT SIDE: BRAND */
    .auth-side {
      position:relative;
      padding:36px 32px 32px 32px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      color:#e5e7eb;
      border-right:1px solid rgba(148,163,184,.3);
      background:
        radial-gradient(circle at 0 0, rgba(59,130,246,.45), transparent 55%),
        radial-gradient(circle at 100% 100%, rgba(236,72,153,.45), transparent 55%),
        radial-gradient(circle at 50% 0, rgba(56,189,248,.28), transparent 50%),
        transparent;
    }

    .brand-pill {
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:6px 14px;
      border-radius:999px;
      background:rgba(15,23,42,.7);
      border:1px solid rgba(148,163,184,.5);
      font-size:11px;
      letter-spacing:.08em;
      text-transform:uppercase;
    }
    .brand-pill span.dot {
      width:8px;height:8px;
      border-radius:999px;
      background:#22c55e;
      box-shadow:0 0 0 6px rgba(34,197,94,.38);
    }

    .brand-title {
      margin-top:18px;
    }
    .brand-title h1 {
      font-size:30px;
      line-height:1.25;
      font-weight:600;
      color:#f9fafb;
      letter-spacing:.02em;
    }
    .brand-title h1 span {
      background:linear-gradient(135deg,#38bdf8,#a855f7,#f97316);
      -webkit-background-clip:text;
      background-clip:text;
      color:transparent;
    }
    .brand-title p {
      margin-top:10px;
      font-size:13px;
      color:#cbd5f5;
      max-width:260px;
    }

    .badge-row {
      margin-top:26px;
      display:flex;
      flex-wrap:wrap;
      gap:10px;
    }
    .pill {
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:6px 12px;
      border-radius:999px;
      border:1px solid rgba(148,163,184,.55);
      background:rgba(15,23,42,.65);
      font-size:11px;
      color:#e5e7eb;
    }
    .pill i {
      font-size:11px;
      color:#38bdf8;
    }

    .side-footer {
      margin-top:32px;
      font-size:11px;
      color:#9ca3af;
      display:flex;
      flex-direction:column;
      gap:4px;
    }
    .side-footer strong {
      color:#e5e7eb;
      font-weight:500;
    }

    /* RIGHT SIDE: FORM */
    .auth-main {
      position:relative;
      padding:34px 32px 32px 32px;
      background:radial-gradient(circle at top, rgba(15,23,42,1), rgba(15,23,42,.96));
      color:var(--ink);
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .main-head {
      margin-bottom:22px;
    }
    .main-head h2 {
      font-size:22px;
      font-weight:600;
      color:#f9fafb;
      display:flex;
      align-items:center;
      gap:8px;
    }
    .main-head h2 .icon-badge {
      width:26px;height:26px;
      border-radius:999px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background:linear-gradient(145deg,#4f46e5,#9333ea);
      color:#e5e7eb;
      font-size:13px;
      box-shadow:0 10px 25px rgba(79,70,229,.55);
    }
    .main-head p {
      margin-top:4px;
      font-size:13px;
      color:#9ca3af;
    }

    .status-tag {
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:6px 11px;
      border-radius:999px;
      font-size:11px;
      margin-bottom:14px;
      background:rgba(15,23,42,.7);
      color:#e5e7eb;
      border:1px solid rgba(148,163,184,.45);
    }
    .status-tag .dot {
      width:8px;height:8px;
      border-radius:999px;
      background:#22c55e;
    }

    form {
      margin-top:4px;
    }

    .form-group {
      margin-bottom:18px;
      position:relative;
    }

    .form-label {
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:6px;
      font-size:13px;
      color:#e5e7eb;
      font-weight:500;
    }
    .form-label span.sub {
      font-size:11px;
      color:#9ca3af;
    }

    .input-wrap {
      position:relative;
    }

    .input-icon {
      position:absolute;
      left:12px;
      top:50%;
      transform:translateY(-50%);
      font-size:13px;
      color:#64748b;
      transition:color .25s ease, transform .25s ease;
      pointer-events:none;
    }

    .form-control {
      width:100%;
      padding:11px 12px 11px 36px;
      border-radius:12px;
      border:1px solid rgba(148,163,184,.55);
      background:rgba(15,23,42,.9);
      color:#e5e7eb;
      font-size:13px;
      outline:none;
      transition:border-color .2s ease, box-shadow .2s ease, background .2s ease, transform .08s ease;
      box-shadow:0 0 0 0 rgba(59,130,246,0);
    }

    .form-control::placeholder {
      color:#6b7280;
    }

    .form-control:focus {
      border-color:#60a5fa;
      background:rgba(15,23,42,.98);
      box-shadow:0 0 0 1px rgba(96,165,250,.5);
      transform:translateY(-1px);
    }

    .form-control:focus + .input-focus-ring {
      opacity:1;
      transform:scale(1.02);
    }

    .input-focus-ring {
      pointer-events:none;
      position:absolute;
      inset:-2px;
      border-radius:14px;
      border:1px solid rgba(96,165,250,.45);
      opacity:0;
      transform:scale(.98);
      transition:all .2s ease-out;
    }

    .input-icon.active {
      color:#60a5fa;
      transform:translate3d(0,-2px,0);
    }

    .input-row {
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:16px;
      margin-top:4px;
      font-size:12px;
      color:#9ca3af;
      gap:10px;
    }

    .remember-me {
      display:inline-flex;
      align-items:center;
      gap:6px;
    }
    .remember-me input[type="checkbox"] {
      width:14px;height:14px;
      accent-color:#4f46e5;
    }
    .remember-me label {
      cursor:pointer;
    }

    .forgot-link {
      color:#93c5fd;
      text-decoration:none;
      font-size:12px;
      display:inline-flex;
      align-items:center;
      gap:4px;
      transition:color .2s ease, transform .08s ease;
    }
    .forgot-link i {
      font-size:11px;
    }
    .forgot-link:hover {
      color:#bfdbfe;
      transform:translateY(-1px);
    }

    .login-btn {
      width:100%;
      margin-top:4px;
      padding:11px 14px;
      border-radius:999px;
      border:none;
      cursor:pointer;
      font-size:14px;
      font-weight:500;
      letter-spacing:.03em;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      color:#f9fafb;
      background:linear-gradient(135deg,#4f46e5,#6366f1,#a855f7);
      box-shadow:0 18px 40px rgba(79,70,229,.6);
      transition:transform .12s ease, box-shadow .12s ease, filter .12s ease;
    }

    .login-btn i {
      font-size:14px;
    }

    .login-btn:hover {
      transform:translateY(-2px);
      filter:brightness(1.05);
      box-shadow:0 22px 55px rgba(79,70,229,.75);
    }

    .login-btn:active {
      transform:translateY(0);
      box-shadow:0 12px 25px rgba(79,70,229,.6);
    }

    .login-meta {
      margin-top:16px;
      font-size:11px;
      color:#6b7280;
      display:flex;
      justify-content:space-between;
      gap:8px;
      flex-wrap:wrap;
    }
    .login-meta span strong {
      color:#e5e7eb;
      font-weight:500;
    }

    /* small helper tag at top-right */
    .corner-tag {
      position:absolute;
      top:16px;
      right:16px;
      padding:5px 10px;
      border-radius:999px;
      border:1px solid rgba(148,163,184,.5);
      background:rgba(15,23,42,.9);
      color:#9ca3af;
      font-size:10px;
      display:inline-flex;
      align-items:center;
      gap:6px;
    }
    .corner-tag i {
      color:#38bdf8;
      font-size:11px;
    }

    /* RESPONSIVE */
    @media (max-width:880px) {
      body {
        padding:16px;
      }
      .auth-inner {
        grid-template-columns:minmax(0,1fr);
      }
      .auth-side {
        display:none;
      }
      .auth-main {
        padding:26px 22px 22px;
      }
      .corner-tag {
        top:10px;right:10px;
      }
    }

    @media (max-width:480px) {
      body {
        padding:12px;
      }
      .auth-shell {
        border-radius:24px;
      }
      .auth-inner {
        border-radius:24px;
      }
      .main-head h2 {
        font-size:19px;
      }
    }
  </style>
</head>
<body>
  <!-- background orbs -->
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="auth-shell">
    <div class="auth-inner">
      <!-- LEFT SIDE -->
      <aside class="auth-side">
        <div>
          <div class="brand-pill">
            <span class="dot"></span>
            <span>Maple Salon · Staff Portal</span>
          </div>

          <div class="brand-title">
            <h1>Welcome back to <span>Booking system</span></h1>
            <p>Manage your daily performance, bookings, and branch activity from a single, secure place.</p>
          </div>

          <div class="badge-row">
            <div class="pill">
              <i class="fas fa-shield-alt"></i>
              <span>Secure access</span>
            </div>
            <div class="pill">
              <i class="fas fa-chart-line"></i>
              <span>Live KPI tracking</span>
            </div>
            <div class="pill">
              <i class="fas fa-users"></i>
              <span>Team-friendly system</span>
            </div>
          </div>
        </div>

        <div class="side-footer">
          <span><strong>Tip:</strong> Use your staff email to sign in.</span>
          <span>Having trouble? Contact your branch manager or System IT support.</span>
        </div>
      </aside>

      <!-- RIGHT SIDE -->
      <main class="auth-main">
        <div class="corner-tag">
          <i class="fas fa-sparkles"></i>
          <span>Booking System</span>
        </div>

        <header class="main-head">
          <div class="status-tag">
            <span class="dot"></span>
            <span>System online · All branches</span>
          </div>

          <h2>
            <span class="icon-badge">
              <i class="fas fa-lock"></i>
            </span>
            Sign in to your account
          </h2>
          <p>Use your registered booking system login to continue.</p>
        </header>

        <form action="{{ route('loginprocess') }}" method="POST" novalidate>
          @csrf

          <div class="form-group">
            <label for="email" class="form-label">
              <span>Email address</span>
              <span class="sub">Use your work email</span>
            </label>
            <div class="input-wrap">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email"
                     id="email"
                     name="email"
                     class="form-control"
                     required
                     autocomplete="email"
                     placeholder="you@email.com">
              <span class="input-focus-ring"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">
              <span>Password</span>
              <span class="sub">Keep it private</span>
            </label>
            <div class="input-wrap">
              <i class="fas fa-lock input-icon"></i>
              <input type="password"
                     id="password"
                     name="password"
                     class="form-control"
                     required
                     autocomplete="current-password"
                     placeholder="••••••••••">
              <span class="input-focus-ring"></span>
            </div>
          </div>

          <div class="input-row">
            <div class="remember-me">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember me on this device</label>
            </div>
            <a href="#" class="forgot-link">
              <i class="fas fa-key"></i>
              <span>Forgot password?</span>
            </a>
          </div>

          <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt"></i>
            <span>Login to Dashboard</span>
          </button>

          <div class="login-meta">
            <span>Protected by <strong>Booking system Security</strong></span>
            <span>© {{ date('Y') }} Booking system</span>
          </div>
        </form>
      </main>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // animate form groups in
      const groups = document.querySelectorAll('.form-group, .input-row, .login-btn');
      groups.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(14px)';
        el.style.transition = 'opacity .45s ease, transform .45s ease';
        setTimeout(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }, 80 + index * 60);
      });

      // icon active on focus
      const inputs = document.querySelectorAll('.form-control');
      inputs.forEach(input => {
        input.addEventListener('focus', function () {
          const icon = this.parentElement.querySelector('.input-icon');
          if (icon) icon.classList.add('active');
        });
        input.addEventListener('blur', function () {
          const icon = this.parentElement.querySelector('.input-icon');
          if (icon) icon.classList.remove('active');
        });
      });
    });
  </script>
</body>
</html>
