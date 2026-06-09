@extends('Backend.Layout.App')

@section('content')
<div class="main-content">

  {{-- ===== Header ===== --}}
  <header class="header" style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px">
    <div>
      <h1 style="margin:0;font-size:1.4rem">Create Booking & Contact</h1>
      <p style="margin:.25rem 0 0;color:#6b7280">Add a new record to the system</p>
    </div>
    <div class="user-info" style="display:flex;align-items:center;gap:10px">
      <span class="profile-username"><span class="fw-bold">{{ Auth::user()->name ?? 'User' }}</span></span>
      @isset($authUserImage)
      <div class="avatar-sm">
        <img src="{{ asset('User/' . $authUserImage) }}" alt="avatar" class="avatar-img rounded-circle"/>
      </div>
      @endisset
    </div>
  </header>

  {{-- ===== Alerts ===== --}}
  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert danger">
      <ul class="mb-0">
        @foreach($errors->all() as $msg)
          <li>{{ $msg }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- ===== Card ===== --}}
  <div class="card">
    <div class="card-header"><h2>Booking & Contact Information</h2></div>

    <div class="card-body">
      <form action="{{ route('bookingandcontact.store') }}" method="POST" novalidate>
        @csrf

        <div class="form-grid">
          <div class="form-group">
            <label for="booking">Booking <span class="required">*</span></label>
            <input
              id="booking"
              name="booking"
              type="text"
              class="form-control"
              value="{{ old('booking') }}"
              maxlength="255"
              placeholder="e.g.5"
              required
            >
            @error('booking') <span class="error-message">{{ $message }}</span> @enderror
          </div>

          <div class="form-group">
            <label for="contact">Contact <span class="required">*</span></label>
            <input
              id="contact"
              name="contact"
              type="text"
              class="form-control"
              value="{{ old('contact') }}"
              maxlength="255"
              placeholder="e.g.10"
              required
            >
            @error('contact') <span class="error-message">{{ $message }}</span> @enderror
          </div>

          <div class="form-group" style="grid-column:1 / -1">
            <label for="note">Note</label>
            <textarea
              id="note"
              name="note"
              class="form-control"
              rows="3"
              maxlength="1000"
              placeholder="Optional notes about this booking/contact..."
            >{{ old('note') }}</textarea>
            @error('note') <span class="error-message">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('bookingandcontact.list') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left"></i> Back
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Create
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== Minimal styles (kept lightweight, no conflict) ===== --}}
<style>
  :root{
    --primary:#3a0a3a; --error:#ef4444;
  }
  .alert{padding:10px 12px;border-radius:8px;margin:10px 0;font-size:.95rem}
  .alert.success{background:#e6f6ee;color:#117a37;border:1px solid #b7e2c6}
  .alert.danger{background:#ffecec;color:#a40000;border:1px solid #ffb3b3}

  .card{background:#fff;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(2,6,23,.06)}
  .card-header{padding-bottom:12px;margin-bottom:16px;border-bottom:1px solid #eee}
  .card-header h2{margin:0;font-size:1.15rem;color:#0b1324}

  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
  @media (max-width:768px){.form-grid{grid-template-columns:1fr}}

  .form-group{display:flex;flex-direction:column;gap:8px}
  label{font-weight:600;color:#0b1324}
  .required{color:var(--error)}
  .form-control{width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;font-size:1rem;transition:border-color .2s, box-shadow .2s}
  .form-control:focus{outline:0;border-color:var(--primary);box-shadow:0 0 0 3px rgba(58,10,58,.12)}
  .error-message{color:var(--error);font-size:.85rem}

  .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:18px;padding-top:12px;border-top:1px solid #eee}
  .btn{padding:10px 16px;border-radius:10px;font-weight:600;display:inline-flex;align-items:center;gap:8px;cursor:pointer;border:1px solid transparent;transition:transform .08s ease, box-shadow .2s}
  .btn:active{transform:scale(.98)}
  .btn-primary{background:var(--primary);color:#fff}
  .btn-primary:hover{box-shadow:0 8px 22px rgba(58,10,58,.18)}
  .btn-cancel{background:#f8f8f8;color:#374151;border-color:#e5e7eb}
  .btn-cancel:hover{background:#f2f2f2}
</style>
@endsection
