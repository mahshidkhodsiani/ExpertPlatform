@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- User Profile Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff"
                                    alt="Profile" class="rounded-circle" width="80">
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h2 class="mb-1">Welcome, {{ auth()->user()->name }}!</h2>
                                <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                                <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="#" class="btn btn-outline-secondary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-lg bg-light-primary rounded-circle mb-3 mx-auto">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <h3 class="mb-1">1,254</h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="#" class="btn btn-sm btn-link text-primary stretched-link">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-lg bg-light-success rounded-circle mb-3 mx-auto">
                            <i class="fas fa-shopping-cart text-success"></i>
                        </div>
                        <h3 class="mb-1">324</h3>
                        <p class="text-muted mb-0">New Orders</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="#" class="btn btn-sm btn-link text-success stretched-link">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-lg bg-light-warning rounded-circle mb-3 mx-auto">
                            <i class="fas fa-chart-line text-warning"></i>
                        </div>
                        <h3 class="mb-1">$12,345</h3>
                        <p class="text-muted mb-0">Total Revenue</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="#" class="btn btn-sm btn-link text-warning stretched-link">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-lg bg-light-info rounded-circle mb-3 mx-auto">
                            <i class="fas fa-tasks text-info"></i>
                        </div>
                        <h3 class="mb-1">56</h3>
                        <p class="text-muted mb-0">Pending Tasks</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="#" class="btn btn-sm btn-link text-info stretched-link">View Details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>New user registration</td>
                                        <td>2 mins ago</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>System update</td>
                                        <td>1 hour ago</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Order #12345 processed</td>
                                        <td>3 hours ago</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Database backup</td>
                                        <td>5 hours ago</td>
                                        <td><span class="badge bg-info">In Progress</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Add New User
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-file-export me-2"></i> Generate Report
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="fas fa-cog me-2"></i> Settings
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .icon-lg {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endpush
