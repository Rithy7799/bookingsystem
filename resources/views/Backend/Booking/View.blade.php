@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
   <div class="header">
        <h1>View Bookings Management</h1>
          <div class="user-info">
             <span class="profile-username">
             <span class="fw-bold">{{ Auth::user()->name }}</span>
             </span>
            <div class="avatar-sm">
            <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
            </div>
    </div>

    <!-- Booking Details Card -->
    <div class="card glass-card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-alt mr-2"></i>Booking ID: {{ $booking->id }}</h2>
            <div class="status-badge {{ $booking->status }}">
                {{ ucfirst($booking->status) }}
            </div>
        </div>
        <div class="card-body">
            <div class="details-grid">
                <!-- Left Column -->
                <div class="details-column">
                    <div class="detail-item">
                        <h3>Customer Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">{{ $booking->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value">{{ $booking->phone }}</span>
                        </div>
                         <td>
                         <div>Date:{{ $booking->created_at }}</div>
                        </td>
                    </div>

                    <div class="detail-item">
                        <h3>Booking Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Service:</span>

                           @foreach ($booking->services as $service)
                                {{ $service->name }}<br>
                            @endforeach
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Branch:</span>
                            <span class="detail-value">{{ $booking->branch->name }}</span>
                        </div>
                          <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">{{ $booking->booking_date }}</span>
                        </div>
                          <div class="detail-row">
                            <span class="detail-label">Time:</span>
                            <span class="detail-value">{{ $booking->booking_time }}</span>
                        </div>
                   <div class="detail-row">
                            <span class="detail-label">Feedback:</span>
                            <span class="detail-value">{{ $booking->feedback }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Reference:</span>
                            <span class="detail-value">
                                @switch($booking->know_through)
                                    @case(1) Facebook @break
                                    @case(2) TikTok @break
                                    @case(3) Telegram @break
                                    @case(4) Website @break
                                    @case(5) Instagram @break
                                    @case(6) Phone Number @break
                                  
                                        
                                    @break
                                @endswitch
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="details-column">
                    <div class="detail-item">
                        <h3>Special Requests</h3>
                        <div class="detail-note">
                            {{ $booking->note ?? 'No special requests' }}
                        </div>
                    </div>
                      <div class="detail-item">
                        <h3>Payment</h3>
                        <div class="detail-note">
                            ${{ $booking->payment ?? 'No payment' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <h3>Proof</h3>
                        @if($booking->image)
                            <div class="image-preview-container">
                                <div class="preview-wrapper">
                                    <img src="{{ asset('Booking/' . $booking->image) }}"
                                         alt="Reference Image"
                                         class="image-preview"
                                         onclick="window.open(this.src, '_blank')">
                                </div>
                            </div>
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <p>No reference image provided</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="form-actions">
                <a href="{{ route('list.booking') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
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
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    /* Status Badge */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .status-badge.confirmed {
        background-color: rgba(0, 200, 81, 0.1);
        color: var(--success);
        border: 1px solid var(--success);
    }

    .status-badge.processing {
        background-color: rgba(255, 158, 0, 0.1);
        color: var(--secondary);
        border: 1px solid var(--secondary);
    }

    .status-badge.cancle {
        background-color: rgba(255, 68, 68, 0.1);
        color: var(--error);
        border: 1px solid var(--error);
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Detail Items */
    .detail-item {
        margin-bottom: 2rem;
    }

    .detail-item h3 {
        color: var(--primary);
        font-size: 1.2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .detail-row {
        display: flex;
        margin-bottom: 0.75rem;
    }

    .detail-label {
        font-weight: 500;
        color: var(--dark);
        min-width: 120px;
    }

    .detail-value {
        color: #555;
    }

    .detail-note {
        background-color: #f9f9f9;
        padding: 1rem;
        border-radius: 8px;
        border-left: 3px solid var(--primary);
        color: #555;
        line-height: 1.6;
    }

    /* Image Preview */
    .image-preview-container {
        margin-top: 1rem;
    }

    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: var(--transition);
    }

    .image-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .no-image {
        text-align: center;
        padding: 2rem;
        background-color: #f9f9f9;
        border-radius: 8px;
        color: var(--gray);
    }

    .no-image i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #ddd;
    }

    .no-image p {
        margin: 0;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
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

    .btn-outline {
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-outline:hover {
        background-color: rgba(123, 44, 191, 0.1);
    }
</style>

@endsection
