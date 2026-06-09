@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
   <div class="header">
        <h1>Bookings Management</h1>
         <div class="user-info">
             <span class="profile-username">
             <span class="fw-bold">{{ Auth::user()->name }}</span>
             </span>
            <div class="avatar-sm">
            <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
            </div>
    </div>

    <!-- Main Content -->
    <div class="content-container">
        <div class="booking-card">
            <div class="card-header">
                <div class="header-left">
                    <i class="fas fa-calendar-edit"></i>
                    <h2>Booking Information</h2>
                </div>
                <div class="header-right">
                    <a href="{{ route('list.booking') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">
{{--                display error--}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
               <form action="{{ route('update.booking', $booking->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
     @method('PUT')
    <div class="form-columns">
        <!-- Left Column -->
        <div class="form-column">
            <div class="form-group">
                <label for="name">Customer Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name', $booking->name) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone" class="form-control"
                       value="{{ old('phone', $booking->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="branch_id">Branch <span class="required">*</span></label>
                <select name="branch_id" id="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $booking->branch_id) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group font-khmer-hanuman">
                <label>សេវាកម្ម/Services<span class="required">*</span></label>
                <div class="input-with-icon">
                    @foreach($services as $service)
                        <label class="checkbox-option">
                            <input type="checkbox"
                                   name="service_id[]"
                                   value="{{ $service->id }}"
                                {{ in_array($service->id, old('service_id', $booking->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $service->name }}
                        </label>
                    @endforeach
                </div>
                <div id="serviceError" class="error font-khmer-hanuman">សូមជ្រើសរើសសេវាកម្មដែលអ្នកចង់ធ្វើ</div>
            </div>

          <div class="form-group">
    <label for="image">Upload Proof</label>
    <div class="image-upload-container">
        <div class="image-upload-box">
            <input type="file" id="imageInput" name="image" accept="image/*" class="image-input">

            @if(!empty($booking->image))
                <div class="image-preview mt-2">
                    <img src="{{ asset('Booking/' . $booking->image) }}" 
                         alt="Current Image" 
                         style="max-height:150px;">
                </div>
            @else
                <div class="upload-placeholder">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Click to upload image</p>
                    <small>JPG, PNG or GIF (Max 5MB)</small>
                </div>
            @endif
        </div>
    </div>
</div>


        </div>

        <!-- Right Column -->
        <div class="form-column">
            <div class="form-group">
                <label for="know_through">How did you know about us? <span class="required">*</span></label>
                <select name="know_through" id="know_through" class="form-control" required>
                    <option value="1" {{ old('know_through', $booking->know_through) == '1' ? 'selected' : '' }}>Facebook</option>
                    <option value="2" {{ old('know_through', $booking->know_through) == '2' ? 'selected' : '' }}>Tik Tok</option>
                    <option value="3" {{ old('know_through', $booking->know_through) == '3' ? 'selected' : '' }}>Telegram</option>
                    <option value="4" {{ old('know_through', $booking->know_through) == '4' ? 'selected' : '' }}>Website</option>
                    <option value="5" {{ old('know_through', $booking->know_through) == '5' ? 'selected' : '' }}>Instagram</option>
                    <option value="6" {{ old('know_through', $booking->know_through) == '6' ? 'selected' : '' }}>Phone Number</option>
                   
                </select>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group half-width">
                    <label for="date">Booking Date <span class="required">*</span></label>
                    <input type="date" id="date" name="booking_date" class="form-control"
                           value="{{ old('booking_date', \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')) }}" required>
                </div>
           <div class="form-group half-width">
    <label for="time">Booking Time <span class="required">*</span></label>
    <select id="time" name="booking_time" class="form-control font-khmer-hanuman" required>
        <option value="">ជ្រើសរើសម៉ោង</option>
        <option value="08:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '08:00' ? 'selected' : '' }}>8:00 AM</option>
        <option value="09:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
        <option value="10:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
        <option value="11:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
        <option value="12:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
        <option value="13:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
        <option value="14:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
        <option value="15:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
        <option value="16:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
        <option value="17:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '17:00' ? 'selected' : '' }}>5:00 PM</option>
        <option value="18:00" {{ old('booking_time', isset($booking) ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '') == '18:00' ? 'selected' : '' }}>6:00 PM</option>
    </select>
</div>

            </div>





            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="processing" {{ old('status', $booking->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="cancel" {{ old('status', $booking->status) == 'cancel' ? 'selected' : '' }}>Cancel</option>
                </select>
            </div>



            <div class="form-group">
                <label for="note">Special Requests or Notes</label>
                <textarea id="note" name="note" rows="3" class="form-control">{{ old('note', $booking->note) }}</textarea>
            </div>


           <div class="form-group">
    <label for="payment">Payment</label>
    <input type="number" step="any" id="payment" name="payment" class="form-control" value="{{ old('payment', $booking->payment) }}">
</div>

<div class="form-group">
  
    <div>
        

        <!-- No Option -->
      <div class="form-group">
    <label for="feedback">Feedback <span class="required">*</span></label>
    <div>
        <div class="form-check">
            <input type="radio" name="feedback" id="feedback_yes" value="yes"
                   class="form-check-input"
                   {{ old('feedback', $booking->feedback) === 'yes' ? 'checked' : '' }} required>
            <label for="feedback_yes" class="form-check-label">Yes (Like)</label>
        </div>

        <div class="form-check">
            <input type="radio" name="feedback" id="feedback_no" value="no"
                   class="form-check-input"
                   {{ old('feedback', $booking->feedback) === 'no' ? 'checked' : '' }} required>
            <label for="feedback_no" class="form-check-label">No (Dislike)</label>
        </div>

        <div class="form-check">
            <input type="radio" name="feedback" id="feedback_empty" value="empty"
                   class="form-check-input"
                   {{ old('feedback', $booking->feedback) === 'empty' ? 'checked' : '' }} required>
            <label for="feedback_empty" class="form-check-label">Empty (Not Given)</label>
        </div>
    </div>
</div>

    </div>
</div>




        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="submit-button">
            <i class="fas fa-save"></i> Update Booking
        </button>
        <a href="{{ route('list.booking') }}" class="cancel-button">
            <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

<script>
    // Image upload functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploadArea = document.getElementById('imageUploadArea');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageUploadArea.addEventListener('click', function() {
            imageInput.click();
        });

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!imagePreview) {
                        // Create new preview if it doesn't exist
                        const newPreview = document.createElement('div');
                        newPreview.id = 'imagePreview';
                        newPreview.className = 'image-preview';
                        newPreview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                        imageUploadArea.innerHTML = '';
                        imageUploadArea.appendChild(newPreview);
                    } else {
                        imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Allow drag and drop
        imageUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        imageUploadArea.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });

        imageUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        });
    });
</script>

<style>
    /* Color Variables */
    :root {
        --primary-color: #8d146a;
        --primary-dark: #b62f8b;
        --primary-light: #aa2ea0;
        --secondary-color: #00cec9;
        --accent-color: #fd79a8;
        --text-color: #2d3436;
        --text-light: #636e72;
        --border-color: #dfe6e9;
        --bg-light: #f5f6fa;
        --white: #ffffff;
        --success: #00b894;
        --warning: #fdcb6e;
        --danger: #d63031;
        --info: #0984e3;
        --border-radius: 8px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Base Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-light);
        color: var(--text-color);
        line-height: 1.6;
    }

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--box-shadow);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-text h1 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .header-text p {
        opacity: 0.9;
        font-size: 0.95rem;
        margin: 0;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-details {
        text-align: right;
        margin-right: 1rem;
    }

    .username {
        display: block;
        font-weight: 500;
    }

    .user-role {
        font-size: 0.85rem;
        opacity: 0.8;
    }

    .avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    /* Content Container */
    .content-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Booking Card */
    .booking-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .header-left {
        display: flex;
        align-items: center;
    }

    .header-left i {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-right: 1rem;
    }

    .header-left h2 {
        font-size: 1.4rem;
        margin: 0;
        font-weight: 600;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: var(--white);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .back-button i {
        margin-right: 0.5rem;
    }

    .back-button:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Layout */
    .form-columns {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .form-column {
        flex: 1;
        min-width: 300px;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .half-width {
        flex: 1;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background-color: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c5ce7' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .required {
        color: var(--danger);
    }

    /* Image Upload */
    .image-upload-container {
        margin-top: 0.5rem;
    }

    .image-upload-box {
        border: 2px dashed var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-upload-box:hover {
        border-color: var(--primary-color);
    }

    .image-upload-box.dragover {
        background-color: rgba(108, 92, 231, 0.05);
        border-color: var(--primary-color);
    }

    .image-input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        top: 0;
        left: 0;
    }

    .upload-placeholder i {
        font-size: 2.5rem;
        color: var(--primary-light);
        margin-bottom: 0.5rem;
    }

    .upload-placeholder p {
        margin: 0.5rem 0;
        font-weight: 500;
        color: var(--text-color);
    }

    .upload-placeholder small {
        color: var(--text-light);
        font-size: 0.8rem;
    }

    .image-preview {
        width: 100%;
        text-align: center;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: var(--border-radius);
        object-fit: contain;
    }

    .image-remove-option {
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    .image-remove-option input {
        margin-right: 0.5rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .submit-button {
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
    }

    .submit-button i {
        margin-right: 0.5rem;
    }

    .submit-button:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
    }

    .cancel-button {
        background-color: var(--white);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        padding: 0.8rem 2rem;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .cancel-button i {
        margin-right: 0.5rem;
    }

    .cancel-button:hover {
        background-color: var(--bg-light);
        border-color: var(--text-light);
        transform: translateY(-2px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-info {
            margin-top: 1rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-right {
            margin-top: 1rem;
            width: 100%;
        }

        .back-button {
            width: 100%;
            justify-content: center;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .form-actions {
            flex-direction: column;
        }

        .submit-button, .cancel-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
