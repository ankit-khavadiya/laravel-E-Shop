@extends('admin.master')
@section('title','Home')
@section('page-content')

    <!-- Dashboard Page -->
    <section id="dashboard" class="page active">
        <div class="page-header">
            <h2>Dashboard</h2>
            <p class="text-muted">Welcome back, Admin! Here's what's happening with your store today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="row stats-cards">

            <!-- TOTAL SALES -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Total Sales</h6>
                                <h3 class="mb-0">${{ number_format($totalSales, 2) }}</h3>
                                <small class="text-success"><i class="fas fa-chart-line"></i> Successful Payments</small>
                            </div>
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOTAL ORDERS -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Total Orders</h6>
                                <h3 class="mb-0">{{ $totalOrders }}</h3>
                                <small class="text-success"><i class="fas fa-shopping-cart"></i> All Orders</small>
                            </div>
                            <div class="stat-icon bg-success">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOTAL CUSTOMERS -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Total Customers</h6>
                                <h3 class="mb-0">{{ $totalCustomers }}</h3>
                                <small class="text-info"><i class="fas fa-users"></i> Registered Users</small>
                            </div>
                            <div class="stat-icon bg-info">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REVENUE -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Revenue</h6>
                                <h3 class="mb-0">${{ number_format($revenue, 2) }}</h3>
                                <small class="text-warning"><i class="fas fa-wallet"></i> Delivered Orders</small>
                            </div>
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mt-4 dashboard-row">
            <!-- SALES CHART -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sales Analytics</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 400px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOP PRODUCTS -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Selling Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="top-products-list">
                            <ul class="list-group list-group-flush">
                                @foreach($topProducts as $product)
                                    @php
                                        $imagePath = public_path('upload/product/' . $product->image);
                                        $imageUrl =file_exists($imagePath) && !empty($product->image) ? asset('upload/product/' . $product->image) : asset('assets/images/web/placeholders/no-image.png');
                                    @endphp
                                    <li class="list-group-item d-flex align-items-center">
                                        <img src="{{ $imageUrl }}" class="rounded me-3" width="45" height="45">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $product->name }}</h6>
                                            <small class="text-muted">{{ $product->order_items_count }}Orders</small>
                                        </div>
                                        <span class="badge bg-primary">${{ number_format($product->price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                        <a href="{{ route('orders') }}" class="btn btn-sm btn-primary">View All</a>
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
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @php
                                                $class = match($order->status) {
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $class }}">{{ ucfirst($order->status) }}</span>
                                        </td>

                                        <td>
                                            <a href="{{ route('orders') }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                datasets: [{
                    label: 'Sales',
                    data: @json($salesData),
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
