@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
    <div class="header bg-gradient-primary">
        <div>
            <h1>Create Booking</h1>
            <p>Create booking information</p>
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

    <!-- Edit Booking Form -->
    <div class="card glass-card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-edit mr-2"></i>Booking Information</h2>
        </div>
        <div class="card-body">
<form action="{{ route('store.booking') }}" method="POST" enctype="multipart/form-data">
    @csrf          
    <div class="form-grid">
        <!-- Left Column -->
        <div class="form-column">
            <!-- Name Field -->
            <div class="form-group floating-label">
                <input type="text" id="name" name="name" class="form-control" placeholder="Customer Name" required>
                <label for="name">Customer Name <span class="required">*</span></label>
            </div>                      
            <div class="form-group floating-label">
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Customer Phone" required>
                <label for="phone">Phone Number <span class="required">*</span></label>
            </div>
            
            <!-- Branch -->
            <div class="form-group floating-label">
               
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch<span class="required">*</span></option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Service (missing in original form but present in validation) -->
            <div class="form-group floating-label">
              
                <select name="service_id" class="form-control" required>
                    <option value="">Select Service<span class="required">*</span></option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
              <div class="form-group">
                <label>How did you know about us? <span class="required">*</span></label>
                <select name="know_through" class="form-control" required>
                    <option value="1">Facebook</option>
                    <option value="2">Tik Tok</option>
                    <option value="3">Telegram</option>
                    <option value="4">Website</option>
                    <option value="5">Instagram</option>
                    <option value="6">Other</option>
                </select>
            </div>   
            <div class="form-group">
                <label class="image-upload-label">Reference Image (Optional)</label>
                <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                <div class="image-upload-area" id="imageUpload" onclick="document.getElementById('imageInput').click()">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p>Drag & drop or click to upload</p>
                    <small>JPG, PNG, or GIF - Max 5MB</small>
                </div>
                <div id="imagePreview" style="display: none; margin-top: 10px;">
                    <img id="previewImage" src="#" alt="Preview" style="max-width: 100%; max-height: 150px;">
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="form-column">
                              
            <div class="form-group floating-label">
                <input type="date" id="date" name="booking_date" class="form-control" placeholder="" required>
                <label for="date">Booking Date <span class="required">*</span></label>
            </div>
            
            <div class="form-group floating-label">
                <input type="time" id="time" name="booking_time" class="form-control" placeholder=" " required>
                <label for="time">Booking Time <span class="required">*</span></label>   
            </div>

            <div class="form-group">
                <label>Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="confirmed">Confirmed</option>
                    <option value="processing">Processing</option>
                    <option value="cancel">Cancel</option>
                </select>
            </div>
            <div class="form-group floating-label">
    <input type="number" id="payment" name="payment" class="form-control" placeholder=" " min="0" step="0.01" required>
    <label for="payment">Payment Amount <span class="required">*</span></label>
</div>
            <div class="form-group floating-label">
                <textarea id="note" name="note" rows="3" class="form-control" placeholder=" "></textarea>
                <label for="note">Special Requests or Notes</label>
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="form-actions">
        <a href="{{ route('list.booking') }}" class="btn btn-outline">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary btn-animate">
            <i class="fas fa-save"></i> Create Booking
        </button>
    </div>
</form>

<script>
    // Image preview functionality
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const uploadArea = document.getElementById('imageUpload');
        
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.style.display = 'block';
                uploadArea.style.display = 'none';
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            uploadArea.style.display = 'block';
        }
    });
</script>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #9b1787;
        --primary-light: #d578c9;
        --primary-dark: #c6259e;
        --secondary: #ff9e00;
        --error: #ff4444;
        --success: #00c851;
        --dark: #3a0a3a;
        --light: #611255;
        --gray: #adb5bd;
        --border-radius: 12px;
        --box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    /* Base Styles */
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--dark);
    }
    
    /* Header Section */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        margin: -1rem -1rem 1rem -1rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: var(--box-shadow);
    }
    
    .header h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }
    
    .header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-info span {
        font-weight: 500;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Card Styles */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .card-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--primary);
        display: flex;
        align-items: center;
    }
    
    .card-header i {
        margin-right: 0.75rem;
    }
    
    .card-body {
        padding: 1.5rem 2rem;
    }
    
    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Form Group Styles */
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .floating-label {
        position: relative;
    }
    
    .floating-label label {
        position: absolute;
        top: 16px;
        left: 15px;
        color: var(--gray);
        font-size: 1rem;
        pointer-events: none;
        transition: var(--transition);
        background: white;
        padding: 0 5px;
        transform-origin: left top;
    }
    
    .floating-label .form-control:focus ~ label,
    .floating-label .form-control:not(:placeholder-shown) ~ label {
        transform: translateY(-24px) scale(0.85);
        color: var(--primary);
        background: linear-gradient(0deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 50%);
    }
    
    .form-control {
        width: 100%;
        padding: 16px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: var(--transition);
        background-color: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(123, 44, 191, 0.1);
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23adb5bd' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px 12px;
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    
    /* Required Field Indicator */
    .required {
        color: var(--error);
    }
    
    /* Service Options */
    .services-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .service-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .service-chip {
        padding: 0.5rem 1rem;
        background-color: #f0f0f0;
        border-radius: 50px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.9rem;
        color: #555;
        border: 1px solid #ddd;
    }
    
    .service-chip.selected {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    /* Status Buttons */
    .status-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .status-buttons {
        display: flex;
        gap: 0.75rem;
    }
    
    .status-option {
        flex: 1;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .status-option:hover {
        border-color: var(--primary-light);
    }
    
    .status-option.active {
        background-color: rgba(123, 44, 191, 0.1);
        border-color: var(--primary);
    }
    
    .status-indicator {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #ccc;
        position: relative;
    }
    
    .status-option.active .status-indicator {
        border-color: var(--primary);
        background-color: var(--primary);
    }
    
    .status-option.active .status-indicator::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
    }
    
    /* Image Upload */
    .image-upload-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .image-upload-area {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: rgba(240, 240, 240, 0.5);
    }
    
    .image-upload-area:hover {
        border-color: var(--primary);
        background-color: rgba(123, 44, 191, 0.05);
    }
    
    .upload-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }
    
    .image-upload-area p {
        margin: 0.5rem 0;
        font-weight: 500;
    }
    
    .image-upload-area small {
        color: var(--gray);
        font-size: 0.85rem;
    }
    
    /* Image Preview */
    .image-preview-container {
        margin-top: 1rem;
    }
    
    .preview-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .remove-image-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: var(--error);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .remove-image-btn:hover {
        transform: scale(1.1);
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        border: none;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    .btn-animate::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }
    
    .btn-animate:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }
    
    .btn-outline {
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
    }
    
    .btn-outline:hover {
        background-color: rgba(123, 44, 191, 0.1);
    }
    
    /* Error Messages */
    .error-message {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }
    
    /* Animations */
    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 1;
        }
        20% {
            transform: scale(25, 25);
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: scale(40, 40);
        }
    }
</style>


@endsection