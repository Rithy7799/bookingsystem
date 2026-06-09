@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
    <div class="header">
        <div>
            <h1>Update Branch</h1>
            <p>Edit existing salon branch information</p>
        </div>
         <div class="user-info">
             <span class="profile-username">
             <span class="fw-bold">{{ Auth::user()->name }}</span>
             </span>
            <div class="avatar-sm">
            <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
            </div>
    </div>

    <!-- Update Branch Form -->
    <div class="card">
        <div class="card-header">
            <h2>Branch Information</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('update.branch', $branch->id) }}" method="POST">
                @csrf
                <div class="form-grid">
                    <!-- Left Column -->
                    <div class="form-column">
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">Branch Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Location Field -->
                        <div class="form-group">
                            <label for="location">Location <span class="required">*</span></label>
                            <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $branch->location) }}" required>
                            @error('location')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Manager Field -->
                        <div class="form-group">
                            <label for="manager">Manager Name <span class="required">*</span></label>
                            <input type="text" id="manager" name="manager" class="form-control" value="{{ old('manager', $branch->manager) }}" required>
                            @error('manager')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="form-column">
                        <!-- Phone Field -->
                        <div class="form-group">
                            <label for="text">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}" required>
                            @error('phone')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Status Field -->
                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="status" value="active" {{ old('status', $branch->status) == 'active' ? 'checked' : '' }}>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Active</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="status" value="inactive" {{ old('status', $branch->status) == 'inactive' ? 'checked' : '' }}>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Inactive</span>
                                </label>
                            </div>
                            @error('status')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- User Assignment -->
                        {{-- <div class="form-group">
                            <label for="user_id">Assign to User</label>
                            <select id="user_id" name="user_id" class="form-control">
                                <option value="">Select User (Optional)</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $branch->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div> --}}
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('list.branch') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Form Styles */
    .card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-top: 20px;
    }
    
    .card-header {
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .card-header h2 {
        color: var(--primary);
        margin: 0;
        font-size: 1.5rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark);
    }
    
    .required {
        color: var(--error);
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(142, 27, 150, 0.2);
    }
    
    /* Radio Buttons */
    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 8px;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    
    .radio-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .radio-checkmark {
        height: 18px;
        width: 18px;
        border: 2px solid #ddd;
        border-radius: 50%;
        margin-right: 8px;
        position: relative;
    }
    
    .radio-option input:checked ~ .radio-checkmark {
        border-color: var(--primary);
    }
    
    .radio-checkmark:after {
        content: "";
        position: absolute;
        display: none;
        top: 3px;
        left: 3px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
    }
    
    .radio-option input:checked ~ .radio-checkmark:after {
        display: block;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #7a1a85;
    }
    
    .btn-cancel {
        background-color: #f5f5f5;
        color: #666;
        border: 1px solid #ddd;
    }
    
    .btn-cancel:hover {
        background-color: #eaeaea;
    }
    
    /* Error Messages */
    .error-message {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 5px;
        display: block;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Phone number input formatting
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });
        }
    });
</script>
@endsection