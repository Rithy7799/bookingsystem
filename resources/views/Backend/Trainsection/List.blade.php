@extends('Backend.Layout.App')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="header">
        <div class="user-info">
        </div>
    </div>
    <!-- Transactions Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-receipt me-2"></i>Transactions</h3>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search transactions..." id="transactionSearch">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Transactions ID</th>
                            <th>Booking Name</th>
                            <th>Branch</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($confirmedBookings as $trx)
                        <tr>
                            <td>TID{{ $trx->id }}</td>
                            <td>{{ $trx->name }}</td>
                            <td>{{ $trx->branch->name }}</td>
                            <td>${{ number_format($trx->payment, 2) }}</td>
                            <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('view.booking', $trx->id) }}" 
                                   class="btn btn-sm btn-primary d-inline-flex align-items-center" 
                                   title="View Booking">
                                    <i class="fas fa-calendar-check me-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-info h3 {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .stat-info p {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .stat-icon.revenue {
        background: #e8f5e9;
        color: #4caf50;
    }
    
    .stat-icon.bookings {
        background: #e3f2fd;
        color: #2196f3;
    }
    
    .search-bar {
        position: relative;
    }
    
    .search-bar i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .search-bar input {
        padding-left: 35px;
        border-radius: 20px;
        border: 1px solid #ddd;
    }
    
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background-color: #f9f9f9;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: var(--dark);
        background-color: #f9f9f9;
    }
    
    .progress {
        background-color: #f0f0f0;
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality for transactions table
        const transactionSearch = document.getElementById('transactionSearch');
        if (transactionSearch) {
            transactionSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#transactionsTable tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
        
        // Add active class to report nav item
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            if (item.querySelector('span') && item.querySelector('span').textContent === 'Report') {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    });
</script>
@endsection