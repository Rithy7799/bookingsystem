@extends('Backend.Layout.App')

@section('content')
<div class="main-content">
    <!-- Header Section -->
      <div class="header d-flex justify-content-between align-items-center">
        <h1>User Management</h1>
        <div class="user-info">
             <span class="profile-username">
             <span class="fw-bold">{{ Auth::user()->name }}</span>
             </span>
            <div class="avatar-sm">
            <img src="{{ asset('User/'. Auth::user()->image) }}" alt="..." class="avatar-img rounded-circle" />
            </div>
            </div>
    </div>

    <!-- Filter Controls -->
    <div class="filter-section">
        <div class="filter-row">
            <!-- Quick Date Filters -->
            {{-- <div class="filter-group">
                <label for="date-range"><i class="fas fa-clock"></i> Quick Filters</label>
                <select id="date-range" class="form-select">
                    <option value="">Select Time Period</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="thisweek">This Week</option>
                    <option value="lastweek">Last Week</option>
                    <option value="thismonth">This Month</option>
                    <option value="lastmonth">Last Month</option>
                </select>
            </div> --}}

            <!-- Custom Date Range -->
            {{-- <div class="filter-group">
                <label><i class="fas fa-calendar-alt"></i> Custom Date Range</label>
                <div class="date-range-picker">
                    <input type="date" id="from-date" class="form-control date-input">
                    <span class="date-separator">to</span>
                    <input type="date" id="to-date" class="form-control date-input">
                </div>
            </div> --}}

            <!-- Action Buttons -->
            {{-- <div class="filter-actions">
                <button class="btn btn-primary" id="apply-filters">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="btn btn-secondary" id="reset-filters">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div> --}}
        </div>
        
        <!-- Search Box -->
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="customer-search" class="search-input" placeholder="Search bookings...">
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        {{-- <th>Service</th> --}}
                        <th>Branch</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($confirmedBookings as $booking)
                    <tr>
                        <td>#{{ $booking->id }}</td>
                        <td>{{ $booking->name }}</td>
                        <td>{{ $booking->phone }}</td>
                        {{-- <td>{{ $booking->service->name ?? '-' }}</td> --}}
                        <td>{{ $booking->branch->name ?? '-' }}</td>
                        <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y H:i') : '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('view.booking', $booking->id) }}" class="btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>

                             {{-- <a href="{{ route('view.booking', $booking->id) }}" class="action-btn view-btn" title="View Booking">
        <i class="fas fa-eye"></i>
    </a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary: #86118d;
        --secondary: #9822a0;
        --accent: #e74c3c;
        --light: #ecf0f1;
        --dark: #3a0a3a;
        --success: #2ecc71;
        --warning: #f39c12;
        --danger: #e74c3c;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        color: #333;
        line-height: 1.6;
    }
    
    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    
    .header-content h1 {
        color: var(--secondary);
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }
    
    .header-content p {
        color: #7f8c8d;
        margin: 5px 0 0;
        font-size: 14px;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
    }
    
    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid var(--light);
    }
    
    .profile-name {
        font-weight: 500;
        color: var(--secondary);
    }
    
    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--dark);
    }
    
    .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: white;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    .form-select:focus {
        border-color: var(--primary);
        outline: none;
    }
    
    .date-range-picker {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .date-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
    
    .date-separator {
        color: #7f8c8d;
        font-size: 14px;
    }
    
    .filter-actions {
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }
    
    .btn {
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #2980b9;
    }
    
    .btn-secondary {
        background-color: var(--light);
        color: var(--dark);
    }
    
    .btn-secondary:hover {
        background-color: #dfe6e9;
    }
    
    /* Search Box */
    .search-container {
        margin-top: 15px;
    }
    
    .search-box {
        position: relative;
        max-width: 400px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: var(--primary);
        outline: none;
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px;
    }
    
    .booking-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .booking-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid #e0e0e0;
        font-size: 14px;
    }
    
    .booking-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }
    
    .booking-table tr:hover td {
        background-color: #f8f9fa;
    }
    
    .actions {
        white-space: nowrap;
    }
    
    .btn-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        transition: all 0.3s;
    }
    
    .btn-view:hover {
        background-color: #2980b9;
        transform: scale(1.1);
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
        .filter-row {
            flex-direction: column;
        }
        
        .filter-group {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .date-range-picker {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .date-separator {
            display: none;
        }
    }
</style>

<script>
$(document).ready(function() {
    // Initialize with today's date
    const today = new Date().toISOString().split('T')[0];
    $('#from-date').val(today);
    $('#to-date').val(today);

    // Client-side search
    $('#customer-search').on('input', function() {
        const term = $(this).val().toLowerCase();
        $('.booking-table tbody tr').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(term));
        });
    });

    // Date range presets
    $('#date-range').change(function() {
        const range = $(this).val();
        if (!range) return;
        
        const today = new Date();
        let startDate, endDate;
        
        switch(range) {
            case 'today':
                startDate = endDate = today.toISOString().split('T')[0];
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate = endDate = yesterday.toISOString().split('T')[0];
                break;
            case 'thisweek':
                startDate = getWeekStart(today).toISOString().split('T')[0];
                endDate = getWeekEnd(today).toISOString().split('T')[0];
                break;
            case 'lastweek':
                const lastWeek = new Date(today);
                lastWeek.setDate(lastWeek.getDate() - 7);
                startDate = getWeekStart(lastWeek).toISOString().split('T')[0];
                endDate = getWeekEnd(lastWeek).toISOString().split('T')[0];
                break;
            case 'thismonth':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                break;
            case 'lastmonth':
                const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                startDate = lastMonth.toISOString().split('T')[0];
                endDate = new Date(lastMonth.getFullYear(), lastMonth.getMonth() + 1, 0).toISOString().split('T')[0];
                break;
        }
        
        $('#from-date').val(startDate);
        $('#to-date').val(endDate);
    });

    // Apply filters
    $('#apply-filters').click(function() {
        const fromDate = $('#from-date').val();
        const toDate = $('#to-date').val();
        
        if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
            alert('End date must be after start date');
            return;
        }
        
        // In a real implementation, this would be an AJAX call
        window.location.href = "{{ url()->current() }}?from_date=" + fromDate + "&to_date=" + toDate;
    });

    // Reset filters
    $('#reset-filters').click(function() {
        $('#date-range').val('');
        $('#from-date').val('');
        $('#to-date').val('');
        $('#customer-search').val('');
        window.location.href = "{{ url()->current() }}";
    });

    // Helper functions
    function getWeekStart(date) {
        const d = new Date(date);
        const day = d.getDay();
        const diff = d.getDate() - day + (day === 0 ? -6 : 1);
        return new Date(d.setDate(diff));
    }
    
    function getWeekEnd(date) {
        const start = getWeekStart(date);
        const end = new Date(start);
        end.setDate(start.getDate() + 6);
        return end;
    }
});
</script>
@endsection