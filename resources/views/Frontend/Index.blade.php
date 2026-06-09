<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Base -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>system | Booking</title>

  <!-- SEO / Social -->
  <meta name="description" content="Book your appointment at Maple Salon - Professional hair, beauty and spa services in Cambodia. Easy online booking available 24/7.">
  <meta name="keywords" content="Maple Salon, beauty salon Cambodia, hair salon booking, spa appointments, beauty services, salon near me">
  <meta name="author" content="Maple Salon">
  <meta property="og:title" content="Maple Salon | Online Booking">
  <meta property="og:description" content="Book your beauty and spa appointments online at Maple Salon. Professional services, experienced staff, convenient booking.">
  <meta property="og:image" content="{{ asset('images/maple-salon-og.jpg') }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="robots" content="index, follow">

  <!-- Security -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('User/maple.jpg') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('User/maple.jpg') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('User/maple.jpg') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">
  <meta name="theme-color" content="#2837e3">

  <!-- Fonts / Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

  <style>
    :root{
      --primary:#2837e3;
      --primary-soft:#e0e4ff;
      --primary-dark:#1b2bb0;
      --accent:#0ea5e9;
      --bg:#f3f4f8;
      --panel:#ffffff;
      --border:#e5e7eb;
      --dark:#0f172a;
      --text:#111827;
      --muted:#6b7280;
      --success:#16a34a;
      --error:#e11d48;

      --r-lg:18px;
      --r:12px;
      --gap:16px;
      --gap-lg:22px;
    }

    *{
      box-sizing:border-box;
      margin:0;
      padding:0;
    }

    html{
      -webkit-text-size-adjust:100%;
    }

    body{
      font-family:'Montserrat','Helvetica Neue',sans-serif;
      color:var(--text);
      background:
        radial-gradient(circle at top left, rgba(40,55,227,0.18), transparent 60%),
        radial-gradient(circle at bottom right, rgba(14,165,233,0.12), transparent 55%),
        var(--bg);
      min-height:100vh;
      padding:18px 12px;
      padding-bottom:calc(env(safe-area-inset-bottom,0) + 18px);
      line-height:1.6;
      display:flex;
      align-items:flex-start;
      justify-content:center;
    }

    .shell{
      width:100%;
      max-width:780px;
    }

    /* Top app bar / title card */
    .app-bar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:14px;
      gap:8px;
    }

    .app-brand{
      display:flex;
      align-items:center;
      gap:10px;
    }

    .app-logo{
      width:36px;
      height:36px;
      border-radius:999px;
      background:linear-gradient(135deg,var(--primary),var(--accent));
      display:flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-weight:700;
      font-size:0.9rem;
      box-shadow:0 8px 18px rgba(40,55,227,0.4);
    }

    .app-meta{
      display:flex;
      flex-direction:column;
      gap:2px;
    }

    .app-meta-title{
      font-size:0.9rem;
      font-weight:600;
      color:var(--dark);
    }

    .app-meta-sub{
      font-size:0.78rem;
      color:var(--muted);
    }

    .app-pill{
      padding:6px 10px;
      border-radius:999px;
      background:rgba(40,55,227,0.08);
      color:var(--primary-dark);
      font-size:0.75rem;
      font-weight:600;
      display:flex;
      align-items:center;
      gap:6px;
    }

    .app-pill i{
      font-size:0.8rem;
    }

    /* Main card */
    .container{
      background:var(--panel);
      border-radius:var(--r-lg);
      border:1px solid rgba(148,163,184,0.4);
      box-shadow:0 16px 32px rgba(15,23,42,0.12);
      padding:18px 16px 22px;
      position:relative;
      overflow:hidden;
    }

    .container::before{
      content:'';
      position:absolute;
      inset:auto -40px -60px auto;
      width:160px;
      height:160px;
      border-radius:999px;
      background:radial-gradient(circle, rgba(40,55,227,0.16), transparent 60%);
      opacity:.8;
      pointer-events:none;
    }

    .header{
      margin-bottom:var(--gap-lg);
    }

    .eyebrow{
      display:inline-flex;
      gap:6px;
      align-items:center;
      padding:4px 10px;
      border-radius:999px;
      background:#eff6ff;
      color:#1d4ed8;
      font-size:0.75rem;
      font-weight:600;
      margin-bottom:6px;
    }

    .eyebrow i{
      font-size:0.8rem;
    }

    .title-row{
      display:flex;
      justify-content:space-between;
      align-items:flex-start;
      gap:10px;
      flex-wrap:wrap;
    }

    .title-main h1{
      font-size:1.25rem;
      font-weight:700;
      color:var(--dark);
      letter-spacing:0.02em;
      margin-bottom:4px;
    }

    .title-main p{
      font-size:0.86rem;
      color:var(--muted);
    }

    .title-badge{
      display:flex;
      align-items:center;
      gap:6px;
      padding:6px 10px;
      border-radius:var(--r);
      background:#f9fafb;
      font-size:0.78rem;
      color:var(--muted);
      border:1px dashed rgba(148,163,184,0.7);
    }

    .title-badge span{
      font-weight:600;
      color:var(--primary-dark);
    }

    /* Form */
    .form-grid{
      display:grid;
      grid-template-columns:1fr;
      gap:var(--gap);
    }

    .form-group{
      position:relative;
    }

    label{
      display:block;
      margin-bottom:6px;
      font-weight:600;
      color:var(--dark);
      font-size:0.9rem;
    }

    .label-sub{
      display:block;
      font-size:0.8rem;
      color:var(--muted);
      font-weight:400;
    }

    .input-with-icon{
      position:relative;
    }

    .input-icon{
      position:absolute;
      left:12px;
      top:50%;
      transform:translateY(-50%);
      color:#64748b;
      font-size:0.95rem;
      pointer-events:none;
    }

    .font-khmer-hanuman{
      font-family:"Hanuman",serif;
    }

    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="password"],
    input[type="time"],
    input[type="date"],
    input[type="number"],
    select,
    textarea{
      width:100%;
      font-size:15px;
      padding:11px 12px 11px 38px;
      border-radius:10px;
      border:1px solid var(--border);
      background:#f9fafb;
      color:var(--text);
      transition:border-color .18s, box-shadow .18s, background .18s;
      -webkit-tap-highlight-color:transparent;
    }

    textarea{
      min-height:96px;
      padding-top:10px;
    }

    input:focus,
    select:focus,
    textarea:focus{
      outline:none;
      border-color:var(--primary);
      background:#ffffff;
      box-shadow:0 0 0 2px rgba(40,55,227,0.14);
    }

    select{
      appearance:none;
      background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat:no-repeat;
      background-position:right 11px center;
      background-size:16px;
    }

    .checkbox-stack{
      margin-top:8px;
      display:flex;
      flex-direction:column;
      gap:8px;
    }

    .checkbox-option{
      display:flex;
      align-items:flex-start;
      gap:10px;
      padding:10px 12px;
      background:#f9fafb;
      border-radius:10px;
      border:1px solid #e5e7eb;
      font-size:0.9rem;
      color:var(--dark);
      transition:background .15s, border-color .15s, transform .1s;
    }

    .checkbox-option:hover{
      background:#eef2ff;
      border-color:var(--primary-soft);
      transform:translateY(-1px);
    }

    .checkbox-option input{
      margin-top:3px;
      width:18px;
      height:18px;
      accent-color:var(--primary);
    }

    .toggle-btn,
    button[type="submit"]{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      width:100%;
      min-height:46px;
      border-radius:999px;
      border:none;
      cursor:pointer;
      font-weight:700;
      font-size:0.95rem;
      letter-spacing:0.02em;
      transition:transform .15s ease, box-shadow .2s ease, background .15s ease, opacity .15s ease;
    }

    .toggle-btn{
      background:#f1f5f9;
      color:var(--dark);
      padding:10px 14px;
    }

    .toggle-btn i{
      font-size:0.9rem;
    }

    .toggle-btn:hover{
      background:#e2e8f0;
    }

    .toggle-btn[aria-expanded="true"]{
      background:#e0ecff;
      color:#1d4ed8;
    }

    button[type="submit"]{
      margin-top:var(--gap-lg);
      background:linear-gradient(135deg,var(--primary),var(--primary-dark));
      color:#ffffff;
      box-shadow:0 10px 24px rgba(40,55,227,0.35);
      position:relative;
      overflow:hidden;
    }

    button[type="submit"]::after{
      content:'';
      position:absolute;
      inset:0;
      left:-100%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);
      transition:.5s;
    }

    button[type="submit"]:hover{
      transform:translateY(-1px);
    }

    button[type="submit"]:hover::after{
      left:100%;
    }

    .error{
      color:var(--error);
      font-size:0.82rem;
      margin-top:4px;
      display:none;
      font-weight:600;
    }

    .toggle-form-trigger{
      cursor:pointer;
      padding:10px 12px;
      background:#f9fafb;
      border-radius:10px;
      border:1px dashed #cbd5f5;
      text-align:center;
      font-size:0.85rem;
      color:var(--muted);
      display:flex;
      align-items:center;
      justify-content:center;
      gap:6px;
      margin-bottom:12px;
      margin-top:4px;
    }

    .toggle-form-trigger:hover{
      background:#eef2ff;
      color:#1d4ed8;
    }

    .toggle-form-trigger i{
      font-size:0.9rem;
    }

    .form-footer{
      margin-top:16px;
      text-align:center;
      font-size:0.85rem;
      color:var(--muted);
    }

    .form-footer a{
      color:var(--primary-dark);
      font-weight:700;
      text-decoration:none;
    }

    .form-footer a:hover{
      text-decoration:underline;
    }

    .hidden{
      display:none !important;
    }

    /* Success popup */
    .success-container{
      position:fixed;
      inset:0;
      display:flex;
      justify-content:center;
      align-items:center;
      padding:20px;
      background:rgba(15,23,42,0.55);
      backdrop-filter:blur(4px);
      z-index:9999;
      animation:fadeIn .3s ease-out;
    }

    .success-card{
      background:#ffffff;
      border-radius:16px;
      padding:20px 18px 18px;
      width:min(100%,420px);
      text-align:center;
      box-shadow:0 18px 38px rgba(15,23,42,0.5);
      position:relative;
      animation:slideUp .35s ease-out;
    }

    .success-icon{
      width:64px;
      height:64px;
      border-radius:999px;
      margin:0 auto 12px;
      display:flex;
      align-items:center;
      justify-content:center;
      background:#e0f2fe;
      color:var(--primary);
      box-shadow:0 10px 22px rgba(59,130,246,0.5);
    }

    .contact-phone{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:6px;
      margin-top:10px;
      padding:10px 18px;
      border-radius:999px;
      background:var(--primary);
      color:#ffffff;
      text-decoration:none;
      font-weight:700;
      font-size:0.9rem;
      box-shadow:0 8px 18px rgba(37,99,235,0.6);
    }

    .contact-phone:hover{
      background:var(--primary-dark);
      transform:translateY(-1px);
    }

    .success-decoration{
      display:flex;
      align-items:center;
      justify-content:center;
      gap:10px;
      margin-top:10px;
      color:#94a3b8;
    }

    .deco-line{
      flex:1;
      height:1px;
      background:#e2e8f0;
    }

    .deco-icon{
      font-size:1.05rem;
      color:var(--primary);
    }

    .close-success{
      position:absolute;
      top:8px;
      right:8px;
      width:32px;
      height:32px;
      border-radius:999px;
      border:none;
      background:#f3f4f6;
      color:#0f172a;
      font-size:18px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:background .15s, transform .1s;
    }

    .close-success:hover{
      background:#e5e7eb;
      transform:scale(1.04);
    }

    .success-container.closing{
      animation:fadeOut .2s ease-in forwards;
    }

    :focus-visible{
      outline:3px solid rgba(40,55,227,0.7);
      outline-offset:2px;
    }

    @media (prefers-reduced-motion: reduce){
      *{
        animation:none !important;
        transition:none !important;
      }
    }

    @media (min-width:720px){
      body{
        align-items:center;
      }
      .container{
        padding:20px 22px 24px;
      }
      .form-grid--two{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:var(--gap);
      }
    }

    @media (max-width:480px){
      body{
        padding:14px 10px;
      }
      .container{
        padding:16px 12px 20px;
      }
      .app-bar{
        margin-bottom:10px;
      }
      .title-main h1{
        font-size:1.1rem;
      }
      input[type="text"],
      input[type="tel"],
      input[type="email"],
      input[type="password"],
      input[type="time"],
      input[type="date"],
      input[type="number"],
      select,
      textarea{
        padding-left:36px;
      }
      .input-icon{
        left:10px;
      }
    }

    @keyframes fadeIn{
      from{opacity:0;}
      to{opacity:1;}
    }

    @keyframes fadeOut{
      from{opacity:1;}
      to{opacity:0;}
    }

    @keyframes slideUp{
      from{transform:translateY(12px);opacity:0;}
      to{transform:translateY(0);opacity:1;}
    }
  </style>
</head>
<body>
  <div class="shell">
    <!-- Small app bar -->
    <div class="app-bar">
      <div class="app-brand">
        <div class="app-logo">SB</div>
        <div class="app-meta">
          <span class="app-meta-title">System Booking</span>
          <span class="app-meta-sub">Quick request · Easy follow-up</span>
        </div>
      </div>
      <div class="app-pill">
        <i class="fa-regular fa-calendar-check"></i>
        <span>Online</span>
      </div>
    </div>

    <div class="container">
      <header class="header">
        <div class="eyebrow">
          <i class="fa-solid fa-sparkles"></i>
          Booking Request
        </div>

        <div class="title-row">
          <div class="title-main">
            <h1>Fill in your booking details</h1>
            <p class="font-khmer-hanuman">
              សូមបញ្ចូលព័ត៌មានរបស់អ្នក ដើម្បីផ្ញើសំណើរកក់។
            </p>
          </div>
          {{-- <div class="title-badge">
            <i class="fa-regular fa-clock"></i>
            <span>2–3 minutes</span> • simple form
          </div> --}}
        </div>
      </header>

      @if ($errors->any())
        <div class="alert alert-danger text-danger" role="alert" style="margin-bottom:12px">
          <ul style="padding-left:18px;">
            @foreach ($errors->all() as $error)
              <li style="font-size:0.86rem;">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('success'))
        <div class="success-container" id="successContainer" role="dialog" aria-modal="true" aria-labelledby="successTitle">
          <div class="success-card" role="document">
            <button class="close-success" id="closeSuccess" aria-label="Close popup">&times;</button>

            <div class="success-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="34" height="34">
                <path fill="currentColor" d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2m-2 15l-5-5l1.41-1.41L10 14.17L17.59 6.58L19 8z"/>
              </svg>
            </div>

            <h3 id="successTitle" class="font-khmer-hanuman" style="font-size:1.02rem;margin-bottom:6px">
              ✅ សំណើរកក់សេវាកម្ម របស់លោកអ្នកត្រូវបានទទួល។
            </h3>
            <p class="font-khmer-hanuman" style="margin-bottom:10px;font-size:0.9rem;">
              ក្រុមការងាររបស់យើង នឹងទាក់ទងវិញ ដើម្បីបញ្ជាក់ពេលវេលានិងសេវាកម្មរបស់អ្នក។
            </p>

            <a href="tel:069470215" class="contact-phone">
              <i class="fas fa-phone-alt" aria-hidden="true"></i>
              <span>069 470 215</span>
            </a>

            <div class="success-decoration" aria-hidden="true">
              <div class="deco-line"></div>
              <i class="fas fa-calendar-check deco-icon"></i>
              <div class="deco-line"></div>
            </div>
          </div>
        </div>
      @endif

      <form id="registrationForm" method="POST" action="{{ route('store.booking') }}" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="status" value="processing">

        <div class="form-grid">
          <div class="form-group font-khmer-hanuman">
            <label for="name">
              ឈ្មោះ/Name *
              <span class="label-sub">សូមបញ្ចូលឈ្មោះពេញរបស់លោកអ្នក</span>
            </label>
            <div class="input-with-icon">
              <i class="fas fa-user input-icon" aria-hidden="true"></i>
              <input
                type="text" id="name" name="name" class="font-khmer-hanuman"
                required placeholder="ឧ. ឡេក ឡាខេណា"
                autocomplete="name" inputmode="text"
              >
            </div>
            <div id="nameError" class="error font-khmer-hanuman">សូមបញ្ចូលឈ្មោះរបស់អ្នក</div>
          </div>

          <div class="form-group font-khmer-hanuman">
            <label for="phone">
              លេខទូរស័ព្ទ/Phone Number *
              <span class="label-sub">សម្រាប់ទំនាក់ទំនងវិញ</span>
            </label>
            <div class="input-with-icon">
              <i class="fas fa-phone-alt input-icon" aria-hidden="true"></i>
              <input
                type="tel" id="phone" name="phone" class="font-khmer-hanuman"
                required placeholder="ឧ. 071 854 5969"
                inputmode="tel" autocomplete="tel"
              >
            </div>
            <div id="phoneError" class="error font-khmer-hanuman">សូមបញ្ចូលលេខទូរស័ព្ទរបស់អ្នក</div>
          </div>
        </div>

        <div class="form-group font-khmer-hanuman" style="margin-top:var(--gap);">
          <label>
            សេវាកម្ម/Services *
            <span class="label-sub">អាចជ្រើសរើសបានច្រើនប្រភេទ</span>
          </label>
          <button type="button" id="toggleServices" class="toggle-btn font-khmer-hanuman" aria-expanded="false" aria-controls="servicesList">
            <i class="fas fa-list-check" aria-hidden="true"></i>
            សូមចុចទីនេះ ដើម្បីជ្រើសរើសសេវាកម្ម
          </button>

          <div id="servicesList" class="checkbox-stack" style="display:none;">
            @foreach($services as $service)
              <label class="checkbox-option font-khmer-hanuman">
                <input type="checkbox" name="service_id[]" value="{{ $service->id }}">
                <span>{{ $service->name }}</span>
              </label>
            @endforeach
          </div>

          <div id="serviceError" class="error font-khmer-hanuman">សូមជ្រើសរើសសេវាកម្មដែលអ្នកចង់ធ្វើ</div>
        </div>

        <div class="form-grid form-grid--two" style="margin-top:var(--gap);">
          <div class="form-group font-khmer-hanuman">
            <label for="date">
              កាលបរិច្ឆេទកក់/Date *
              <span class="label-sub">យ៉ាងហោចណាស់ថ្ងៃបន្ទាប់</span>
            </label>
            <div class="input-with-icon">
              <i class="far fa-calendar-alt input-icon" aria-hidden="true"></i>
              <input type="date" id="date" name="booking_date" required min="{{ date('Y-m-d') }}">
            </div>
            <div id="dateError" class="error font-khmer-hanuman">សូមជ្រើសរើសកាលបរិច្ឆេទត្រឹមត្រូវ</div>
          </div>

          <div class="form-group font-khmer-hanuman">
            <label for="time">
              ម៉ោងកក់/Time *
              <span class="label-sub">សូមជ្រើសរើសម៉ោងដែលអ្នកងាយស្រួល</span>
            </label>
            <div class="input-with-icon">
              <i class="far fa-clock input-icon" aria-hidden="true"></i>
              <select id="time" name="booking_time" class="font-khmer-hanuman" required>
                <option value="">សូមជ្រើសរើសម៉ោងកក់</option>
                <option value="08:00">8:00 AM</option>
                <option value="09:00">9:00 AM</option>
                <option value="10:00">10:00 AM</option>
                <option value="11:00">11:00 AM</option>
                <option value="12:00">12:00 PM</option>
                <option value="13:00">1:00 PM</option>
                <option value="14:00">2:00 PM</option>
                <option value="15:00">3:00 PM</option>
                <option value="16:00">4:00 PM</option>
                <option value="17:00">5:00 PM</option>
                <option value="18:00">6:00 PM</option>
              </select>
            </div>
            <div id="timeError" class="error font-khmer-hanuman">សូមជ្រើសរើសម៉ោងកក់</div>
          </div>
        </div>

        <div class="form-group font-khmer-hanuman" style="margin-top:var(--gap);">
          <label for="branch_id">
            សាខា/Branch *
            <span class="label-sub">សូមជ្រើសរើសសាខាដែលនៅជិតអ្នកបំផុត</span>
          </label>
          <div class="input-with-icon">
            <i class="fas fa-store input-icon" aria-hidden="true"></i>
            <select id="branch_id" name="branch_id" class="font-khmer-hanuman" required>
              <option value="">ជ្រើសរើសសាខា</option>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
              @endforeach
            </select>
          </div>
          <div id="branchError" class="error font-khmer-hanuman">សូមជ្រើសរើសសាខាដែលអ្នកពេញចិត្ត</div>
        </div>

        <div class="toggle-form-trigger font-khmer-hanuman" id="toggleFormTrigger" aria-controls="hiddenFormContainer" aria-expanded="false">
          <i class="fa-regular fa-message-lines"></i>
          <p>ចុចទីនេះ បើអ្នកមានសំណើពិសេសបន្ថែម</p>
        </div>

        <div id="hiddenFormContainer" style="display:none">
          <div class="form-group font-khmer-hanuman">
            <label for="note">សំណើពិសេស ឬកំណត់ចំណាំ</label>
            <div class="input-with-icon">
              <i class="fas fa-edit input-icon" style="top:20px" aria-hidden="true"></i>
              <textarea id="note" name="note" rows="3" placeholder="simple note"></textarea>
            </div>
          </div>
        </div>

        <button type="submit" class="font-khmer-hanuman">
          <i class="fas fa-calendar-check" aria-hidden="true"></i>
          ចាប់ផ្តើមផ្ញើសំណើរកក់
        </button>
      </form>

      <div class="form-footer font-khmer-hanuman">
        <p>
          ប្រសិនបើអ្នកត្រូវការជំនួយបន្ទាន់ សូមទាក់ទង
          <a href="tel:069470215"><i class="fas fa-phone"></i> 069 470 215</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const container = document.getElementById('successContainer');
      const closeBtn  = document.getElementById('closeSuccess');
      if (!container) return;

      function closeSuccess() {
        container.classList.add('closing');
        setTimeout(() => { container.classList.add('hidden'); }, 200);
      }
      closeBtn?.addEventListener('click', closeSuccess);
      container.addEventListener('click', (e) => { if (e.target === container) closeSuccess(); });
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSuccess(); });
    })();

    document.getElementById('toggleFormTrigger').addEventListener('click', function(){
      const box = document.getElementById('hiddenFormContainer');
      const p = this.querySelector('p');
      const expanded = this.getAttribute('aria-expanded') === 'true';
      const nowOpen = !expanded;

      box.style.display = nowOpen ? 'block' : 'none';
      this.setAttribute('aria-expanded', String(nowOpen));
      p.textContent = nowOpen
        ? 'បិទប្រអប់សំណើបន្ថែម'
        : 'ចុចទីនេះ បើអ្នកមានសំណើពិសេសបន្ថែម';
    });

    document.getElementById('toggleServices').addEventListener('click', function(){
      const list = document.getElementById('servicesList');
      const expanded = this.getAttribute('aria-expanded') === 'true';
      const nowOpen = !expanded;

      list.style.display = nowOpen ? 'flex' : 'none';
      this.setAttribute('aria-expanded', String(nowOpen));
      this.innerHTML = nowOpen
        ? '<i class="fas fa-chevron-up" aria-hidden="true"></i> លាក់បញ្ជីសេវាកម្ម'
        : '<i class="fas fa-list-check" aria-hidden="true"></i> សូមចុចទីនេះ ដើម្បីជ្រើសរើសសេវាកម្ម';
    });

    document.getElementById('registrationForm').addEventListener('submit', function(e){
      let ok = true;

      const name = document.getElementById('name').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const services = document.querySelectorAll('input[name="service_id[]"]:checked');
      const dateVal = document.getElementById('date').value;
      const timeVal = document.getElementById('time').value;
      const branchVal = document.getElementById('branch_id').value;

      function show(id, cond){
        document.getElementById(id).style.display = cond ? 'block' : 'none';
      }

      show('nameError', !name);                    ok = ok && !!name;
      show('phoneError', !phone);                  ok = ok && !!phone;
      show('serviceError', services.length === 0); ok = ok && services.length > 0;
      show('dateError', !dateVal);                 ok = ok && !!dateVal;
      show('timeError', !timeVal);                 ok = ok && !!timeVal;
      show('branchError', !branchVal);             ok = ok && !!branchVal;

      if (!ok) e.preventDefault();
    });
  </script>
</body>
</html>
