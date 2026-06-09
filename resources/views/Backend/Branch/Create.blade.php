@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
  <div class="header">
    <div>
      <h1>Create New Branch</h1>
      <p>Add a new salon branch to the system</p>
    </div>
    <div class="user-info">
      <span class="profile-username"><span class="fw-bold">{{ Auth::user()->name }}</span></span>
      <div class="avatar-sm">
        <img src="{{ asset('User/' . Auth::user()->image) }}" alt="avatar" class="avatar-img rounded-circle" />
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h2>Branch Information</h2>
    </div>
    <div class="card-body">
      <form action="{{ route('store.branch') }}" method="POST">
        @csrf
        <div class="form-grid">
          <div class="form-column">
            <div class="form-group">
              <label for="name">Branch Name <span class="required">*</span></label>
              <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
              @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="location">Location <span class="required">*</span></label>
              <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}" required>
              @error('location') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="manager">Manager Name <span class="required">*</span></label>
              <input type="text" id="manager" name="manager" class="form-control" value="{{ old('manager') }}" required>
              @error('manager') <span class="error-message">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-column">
            <div class="form-group">
              <label for="phone">Phone Number <span class="required">*</span></label>
              <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
              @error('phone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Status <span class="required">*</span></label>
              <div class="radio-group">
                <label class="radio-option">
                  <input type="radio" name="status" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                  <span class="radio-checkmark"></span>
                  <span class="radio-label">Active</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="status" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                  <span class="radio-checkmark"></span>
                  <span class="radio-label">Inactive</span>
                </label>
              </div>
              @error('status') <span class="error-message">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('list.branch') }}" class="btn btn-cancel"><i class="fas fa-times"></i> Cancel</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Branch</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.card{background:#fff;border-radius:10px;padding:20px;box-shadow:0 4px 6px rgba(0,0,0,.1);margin-top:20px}
.card-header{padding-bottom:15px;margin-bottom:20px;border-bottom:1px solid #eee}
.card-header h2{color:var(--primary);margin:0;font-size:1.5rem}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:30px}
.form-group{margin-bottom:20px}
label{display:block;margin-bottom:8px;font-weight:500;color:var(--dark)}
.required{color:var(--error)}
.form-control{width:100%;padding:10px 15px;border:1px solid #ddd;border-radius:5px;font-size:1rem;transition:border-color .3s}
.form-control:focus{outline:0;border-color:var(--primary);box-shadow:0 0 0 2px rgba(142,27,150,.2)}
.radio-group{display:flex;gap:20px;margin-top:8px}
.radio-option{display:flex;align-items:center;cursor:pointer;position:relative}
.radio-option input{position:absolute;opacity:0}
.radio-checkmark{height:18px;width:18px;border:2px solid #ddd;border-radius:50%;margin-right:8px;position:relative}
.radio-option input:checked~.radio-checkmark{border-color:var(--primary)}
.radio-checkmark:after{content:"";position:absolute;display:none;top:3px;left:3px;width:8px;height:8px;border-radius:50%;background:var(--primary)}
.radio-option input:checked~.radio-checkmark:after{display:block}
.form-actions{display:flex;justify-content:flex-end;gap:15px;margin-top:30px;padding-top:20px;border-top:1px solid #eee}
.btn{padding:10px 20px;border-radius:5px;font-size:1rem;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .3s}
.btn-primary{background-color:var(--primary);color:#fff;border:0}
.btn-primary:hover{background-color:#7a1a85}
.btn-cancel{background-color:#f5f5f5;color:#666;border:1px solid #ddd}
.btn-cancel:hover{background-color:#eaeaea}
.error-message{color:var(--error);font-size:.85rem;margin-top:5px;display:block}
@media (max-width:768px){.form-grid{grid-template-columns:1fr}.form-actions{justify-content:center}}
</style>

<script>
document.addEventListener('DOMContentLoaded',function(){
  const phoneInput=document.getElementById('phone');
  if(phoneInput){
    phoneInput.addEventListener('input',function(){
      this.value=this.value.replace(/[^0-9+]/g,'');
    });
  }
});
</script>
@endsection
