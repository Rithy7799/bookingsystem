@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
    <div class="header">
        <div>
            <h1>Create New User</h1>
            <p>Add a new user to the system</p>
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

    <!-- Create User Form -->
    <div class="card">
        <div class="card-header">
            <h2>User Information</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('store.user') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <!-- Left Column -->
                    <div class="form-column">
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <div class="password-input">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Role Field -->
                        <div class="form-group">
                            <label for="role">Role <span class="required">*</span></label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff Member</option>
                            </select>
                            @error('role')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="form-column">
                        <!-- Profile Image Field -->
                        <div class="form-group">
                            <label for="image">Profile Image</label>
                            <div class="image-upload">
                                <div class="image-preview" id="imagePreview">
                                    <img src="" alt="Image Preview" class="image-preview__image">
                                    <span class="image-preview__default-text">Image Preview</span>
                                </div>
                                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                            </div>
                            @error('image')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Status Field -->
                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="status" value="active" checked>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Active</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="status" value="inactive">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Inactive</span>
                                </label>
                            </div>
                            @error('status')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                       
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('list.user') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create User
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
    
    .password-input {
        position: relative;
    }
    
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--secondary);
        cursor: pointer;
    }
    
    /* Image Upload */
    .image-upload {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .image-preview {
        width: 150px;
        height: 150px;
        border: 2px dashed #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        background-color: #f9f9f9;
    }
    
    .image-preview__image {
        display: none;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-preview__default-text {
        font-size: 0.9rem;
        color: #888;
        text-align: center;
        padding: 0 10px;
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
        // Image Preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = imagePreview.querySelector('.image-preview__image');
        const previewDefaultText = imagePreview.querySelector('.image-preview__default-text');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                previewDefaultText.style.display = 'none';
                previewImage.style.display = 'block';
                
                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                });
                
                reader.readAsDataURL(file);
            } else {
                previewDefaultText.style.display = 'block';
                previewImage.style.display = 'none';
                previewImage.setAttribute('src', '');
            }
        });
        
        // Toggle Password Visibility
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endsection