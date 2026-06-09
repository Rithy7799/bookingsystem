@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
  <header class="header">
    <div>
      <h1>Update Product</h1>
      <p>Edit product information and save changes</p>
    </div>
    <div class="user-info">
      <span class="profile-username">
        <span class="fw-bold">{{ Auth::user()->name }}</span>
      </span>
      <div class="avatar-sm">
        <img src="{{ asset('User/' . Auth::user()->image) }}" alt="avatar" class="avatar-img rounded-circle"/>
      </div>
    </div>
  </header>

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

  <div class="card">
    <div class="card-header"><h2>Product Information</h2></div>

    <div class="card-body">
      {{-- Update form --}}
      <form action="{{ route('update.product', $product) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="form-grid">
          <div class="form-column">
            <div class="form-group">
              <label for="customer">Customer (name) <span class="required">*</span></label>
              <input id="customer" name="customer" type="text" class="form-control"
                     value="{{ old('customer', $product->customer) }}" maxlength="120"
                     placeholder="e.g., Sokha Phan" required>
              @error('customer') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="name">Product Name <span class="required">*</span></label>
              <input id="name" name="name" type="text" class="form-control"
                     value="{{ old('name', $product->name) }}" required>
              @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="price">Price (USD) <span class="required">*</span></label>
              <input id="price" name="price" type="number" class="form-control"
                     value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
              @error('price') <span class="error-message">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-column">
            <div class="form-group">
              <label for="qty">Quantity <span class="required">*</span></label>
              <input id="qty" name="qty" type="number" class="form-control"
                     value="{{ old('qty', $product->qty) }}" step="1" min="0" required>
              @error('qty') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Calculated total (kept hidden; DB field exists) --}}
            <div class="form-group d-none">
              <label for="total_view">Total Price</label>
              <input id="total_view" type="text" class="form-control"
                     value="{{ old('total', number_format((float)$product->total, 2, '.', '')) }}" readonly>
              <input id="total" name="total" type="hidden"
                     value="{{ old('total', number_format((float)$product->total, 2, '.', '')) }}">
              @error('total') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="memo">Memo</label>
              <textarea id="memo" name="memo" class="form-control" rows="1" maxlength="255" placeholder="Optional">{{ old('memo', $product->memo) }}</textarea>
              @error('memo') <span class="error-message">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('list.product') }}" class="btn btn-cancel"><i class="fas fa-arrow-left"></i> Back</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.alert{padding:10px 12px;border-radius:8px;margin:10px 0;font-size:.95rem}
.alert.success{background:#e6f6ee;color:#117a37;border:1px solid #b7e2c6}
.alert.danger{background:#ffecec;color:#a40000;border:1px solid #ffb3b3}
.card{background:#fff;border-radius:10px;padding:20px;box-shadow:0 4px 6px rgba(0,0,0,.1);margin-top:20px}
.card-header{padding-bottom:15px;margin-bottom:20px;border-bottom:1px solid #eee}
.card-header h2{color:var(--primary);margin:0;font-size:1.5rem}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:30px}
.form-group{margin-bottom:20px}
label{display:block;margin-bottom:8px;font-weight:500;color:var(--dark)}
.required{color:var(--error)}
.form-control{width:100%;padding:10px 15px;border:1px solid #ddd;border-radius:5px;font-size:1rem;transition:border-color .3s}
.form-control:focus{outline:0;border-color:var(--primary);box-shadow:0 0 0 2px rgba(142,27,150,.2)}
.form-actions{display:flex;justify-content:flex-end;gap:15px;margin-top:30px;padding-top:20px;border-top:1px solid #eee}
.btn{padding:10px 20px;border-radius:5px;font-size:1rem;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .3s}
.btn-primary{background-color:var(--primary);color:#fff;border:0}
.btn-primary:hover{background-color:#7a1a85}
.btn-cancel{background-color:#f5f5f5;color:#666;border:1px solid #ddd}
.btn-cancel:hover{background-color:#eaeaea}
.error-message{color:var(--error);font-size:.85rem;margin-top:5px;display:block}
@media (max-width:768px){.form-grid{grid-template-columns:1fr}.form-actions{justify-content:center}}
</style>

@push('scripts')
<script>
(function () {
  const price = document.getElementById('price');
  const qty   = document.getElementById('qty');
  const tv    = document.getElementById('total_view');
  const th    = document.getElementById('total');

  function calc() {
    const p = parseFloat(price?.value || 0);
    const q = parseFloat(qty?.value   || 0);
    const t = p * q;
    const fixed = isFinite(t) ? t.toFixed(2) : '0.00';
    if(tv) tv.value = fixed;
    if(th) th.value = fixed;
  }

  ['input','change'].forEach(evt => {
    price?.addEventListener(evt, calc);
    qty?.addEventListener(evt, calc);
  });

  // initialize with current values
  calc();
})();
</script>
@endpush
@endsection
