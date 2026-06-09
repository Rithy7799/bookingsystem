@extends('Backend.Layout.App')
@section('content')
<style>
    /* Main Content Styling */
    .main-content {
        background-color: #f8f9fc;
        padding: 20px;
        min-height: calc(100vh - 70px);
    }
    
    /* Header Section */
    .header {
        background: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .header h1 {
        color: #600857;
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }
    
    .user-info {
        background: #f8f9fa;
        padding: 8px 15px;
        border-radius: 50px;
    }
    
    .user-info img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    /* Card Styling */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .card-header {
        background: white;
        padding: 20px 25px;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .card-header h2 {
        color: #6d0674;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }
    
    /* Search Bar */
    .search-bar {
        width: 250px;
    }
    
    .search-bar .input-group-text {
        background: white;
        border-right: none;
    }
    
    .search-bar .form-control {
        border-left: none;
        padding: 10px 15px;
    }
    
    /* Button Styling */
    .custom-btn {
        background-color: #580c54;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        color: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
    }
    
    .custom-btn:hover {
        background-color: #6a0a58;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        color: white;
    }
    
    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
    }
    
    .optimized-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .optimized-table thead th {
        background-color: #f8f9fc;
        color: #5a5c69;
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: 2px solid #e3e6f0;
        position: sticky;
        top: 0;
    }
    
    .optimized-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
        background: white;
    }
    
    .optimized-table tbody tr:hover td {
        background-color: #f8f9fc;
    }
    
    /* User Info Container */
    .user-info-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #e9ecef;
    }
    
    /* Status Badges */
    .status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .status.confirmed {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status.cancelled {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    /* Action Buttons */
    .btn-group {
        display: flex;
        gap: 8px;
    }
    
    .btn-outline-danger {
        border-color: #f8d7da;
        color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    
    /* Pagination Styling */
    .pagination {
        justify-content: center;
        padding: 20px 0;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .page-link {
        color: #4e73df;
        border: 1px solid #d1d3e2;
        margin: 0 5px;
        border-radius: 5px !important;
    }
    
    .page-link:hover {
        color: #2e59d9;
        background-color: #f8f9fc;
        border-color: #d1d3e2;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .search-bar {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

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

    <!-- Users Table - Optimized -->
    <div class="bookings-table card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h2 class="mb-3 mb-md-0">All Users</h2>
            <div class="d-flex flex-wrap">
                <div class="search-bar input-group me-3">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search users...">
                </div>
              
                <a href="{{ route('create.user') }}" class="custom-btn">
                    <i class="fas fa-plus me-1"></i> Add New User
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="optimized-table">
                <colgroup>
                    <col style="width: 5%">
                    <col style="width: 20%">
                    <col style="width: 25%">
                    <col style="width: 15%">
                    <col style="width: 15%">
                    <col style="width: 10%">
                    <col style="width: 10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>
                            <div class="user-info-container">
                                @if($u->image)
                                    <img class="user-avatar" src="{{ asset('User/' . $u->image) }}" alt="{{ $u->name }}">
                                @else
                                    <img class="user-avatar" src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=random" alt="{{ $u->name }}">
                                @endif
                                <span>{{ $u->name }}</span>
                            </div>
                        </td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->hasRole('admin'))
                                <span class="badge bg-primary">Administrator</span>
                            @elseif($u->hasRole('staff'))
                                <span class="badge bg-info">Staff Member</span>
                            @else
                                <span class="badge bg-secondary">No Role Assigned</span>
                            @endif
                        </td>
                       
                        <td>
                            <span class="status {{ $u->status == 'active' ? 'confirmed' : 'cancelled' }}">
                                {{ ucfirst($u->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                               
                                <form action="{{ route('delete.user', $u->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $user->links('pagination::bootstrap-5') }}
            </div> 
        </div>
    </div>
</div>
@endsection