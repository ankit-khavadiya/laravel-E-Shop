@extends('admin.master')
@section('title','Home')
@section('page-content')
<!-- Dashboard Page (default) -->
<section id="dashboard" class="page active">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Welcome back, Admin! Here's what's happening with your store today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row stats-cards">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Sales</h6>
                            <h3 class="mb-0">$24,580</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 12.5% from last month</small>
                        </div>
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h3 class="mb-0">1,248</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 8.2% from last month</small>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Customers</h6>
                            <h3 class="mb-0">5,420</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 5.7% from last month</small>
                        </div>
                        <div class="stat-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Revenue</h6>
                            <h3 class="mb-0">$18,250</h3>
                            <small class="text-danger"><i class="fas fa-arrow-down"></i> 3.4% from last month</small>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mt-4 dashboard-row">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sales Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="top-products-list">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <img src="https://placehold.co/40x40/7c3aed/ffffff&text=WH" class="rounded me-3" alt="Product">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Wireless Headphones</h6>
                                    <small class="text-muted">Electronics</small>
                                </div>
                                <span class="badge bg-primary">$129.99</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="https://placehold.co/40x40/3b82f6/fff?text=SW" class="rounded me-3" alt="Product">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Smart Watch</h6>
                                    <small class="text-muted">Electronics</small>
                                </div>
                                <span class="badge bg-primary">$249.99</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="https://placehold.co/40x40/10b981/fff?text=RS" class="rounded me-3" alt="Product">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Running Shoes</h6>
                                    <small class="text-muted">Fashion</small>
                                </div>
                                <span class="badge bg-primary">$89.99</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="https://placehold.co/40x40/8b5cf6/fff?text=CM" class="rounded me-3" alt="Product">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Coffee Maker</h6>
                                    <small class="text-muted">Home Appliances</small>
                                </div>
                                <span class="badge bg-primary">$79.99</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="https://placehold.co/40x40/6366f1/fff?text=BP" class="rounded me-3" alt="Product">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Backpack</h6>
                                    <small class="text-muted">Fashion</small>
                                </div>
                                <span class="badge bg-primary">$49.99</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <a href="#orders" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>#ORD-7841</td>
                                <td>John Smith</td>
                                <td>May 15, 2023</td>
                                <td>$249.99</td>
                                <td><span class="badge bg-success">Delivered</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-7840</td>
                                <td>Sarah Johnson</td>
                                <td>May 14, 2023</td>
                                <td>$129.99</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-7839</td>
                                <td>Michael Brown</td>
                                <td>May 13, 2023</td>
                                <td>$89.99</td>
                                <td><span class="badge bg-info">Shipped</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-7838</td>
                                <td>Emily Davis</td>
                                <td>May 12, 2023</td>
                                <td>$199.99</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-7837</td>
                                <td>Robert Wilson</td>
                                <td>May 11, 2023</td>
                                <td>$149.99</td>
                                <td><span class="badge bg-success">Delivered</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


