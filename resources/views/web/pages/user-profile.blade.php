@extends('web.master')

@section('title', 'My Profile - E-Shop')

@section('page-content')
    <style>
        /* Profile Section Styles */
        .profile-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        /* Profile Sidebar */
        .profile-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            color: white;
            height: 100%;
        }

        .avatar-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            cursor: pointer;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }

        .avatar-overlay {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .avatar-overlay:hover {
            transform: scale(1.1);
        }

        .profile-sidebar h4 {
            font-weight: 700;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .profile-menu {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .profile-menu li {
            margin-bottom: 10px;
        }

        .profile-menu li a,
        .profile-menu li button {
            display: block;
            padding: 12px 20px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 1rem;
            cursor: pointer;
        }

        .profile-menu li.active a,
        .profile-menu li a:hover,
        .profile-menu li button:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateX(5px);
        }

        .profile-menu li a i,
        .profile-menu li button i {
            width: 25px;
            margin-right: 10px;
        }

        /* Profile Content */
        .profile-content {
            padding: 40px;
            background: white;
        }

        .profile-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }

        .profile-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            color: #1f2937;
        }

        .profile-header p {
            color: #6b7280;
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .stats-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .stats-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1f2937;
        }

        .stats-card p {
            color: #6b7280;
            margin: 0;
        }

        /* Profile Cards */
        .profile-card {
            background: #f8f9fa;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .profile-card .card-header {
            background: white;
            padding: 20px 25px;
            border-bottom: 1px solid #e5e7eb;
        }

        .profile-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        .profile-card .card-header h4 i {
            color: #667eea;
            margin-right: 10px;
        }

        .profile-card .card-body {
            padding: 25px;
        }

        /* Form Styles */
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .form-control, .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-danger {
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
        }

        .btn-outline-danger:hover {
            background: #ef4444;
            color: white;
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table th {
            background: #f8f9fa;
            padding: 12px;
            font-weight: 600;
            color: #1f2937;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: #10b981;
            color: white;
        }

        .badge-warning {
            background: #f59e0b;
            color: white;
        }

        /* Password Strength */
        .password-strength .progress {
            height: 4px;
            border-radius: 2px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .profile-sidebar {
                text-align: center;
            }

            .profile-menu li a,
            .profile-menu li button {
                text-align: center;
            }

            .profile-menu li a i,
            .profile-menu li button i {
                margin-right: 0;
                display: block;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 768px) {
            .profile-section {
                padding: 20px;
            }

            .profile-content {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                flex-direction: column;
            }

            .profile-actions .btn {
                width: 100%;
            }
        }
    </style>
    <div class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="row g-0">
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="profile-sidebar">
                            <div class="avatar-wrapper" onclick="document.getElementById('profileImageInput').click()">
                                <img src="{{ asset('upload/'.Auth::user()->profile_image) ?? asset('frontend/images/default-avatar.png') }}"
                                     alt="Profile Image"
                                     id="profileImagePreview"
                                     class="profile-img">
                                <div class="avatar-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <input type="file" name="profile_image" id="profileImageInput" class="d-none" accept="image/*">

                            <h4 id="userName">{{ Auth::user()->name }}</h4>
                            <p>{{ Auth::user()->email }}</p>

                            <ul class="profile-menu">
                                <li class="active" data-tab="dashboard">
                                    <a href="javascript:void(0)" class="tab-link" data-tab="dashboard">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li data-tab="profile">
                                    <a href="javascript:void(0)" class="tab-link" data-tab="profile">
                                        <i class="fas fa-user"></i> My Profile
                                    </a>
                                </li>
                                <li data-tab="orders">
                                    <a href="javascript:void(0)" class="tab-link" data-tab="orders">
                                        <i class="fas fa-shopping-bag"></i> My Orders
                                    </a>
                                </li>
                                <li data-tab="security">
                                    <button class="tab-link" data-tab="security">
                                        <i class="fas fa-key"></i> Security
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-8">
                        <div class="profile-content">
                            <!-- Dashboard Tab -->
                            <div id="dashboardTab" class="tab-content active">
                                <div class="profile-header">
                                    <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
                                    <p>Here's what's happening with your account today.</p>
                                </div>

                                <div class="stats-grid">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        <h3 id="totalOrders">0</h3>
                                        <p>Total Orders</p>
                                    </div>

                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <h3 id="totalSpent">$0</h3>
                                        <p>Total Spent</p>
                                    </div>

                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <h3 id="wishlistCount">0</h3>
                                        <p>Wishlist Items</p>
                                    </div>
                                </div>

                                <div class="profile-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-clock"></i> Recent Orders</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="recentOrdersTable">
                                                <tr>
                                                    <td colspan="5" class="text-center">Loading...</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Tab -->
                            <div id="profileTab" class="tab-content">
                                <div class="profile-header">
                                    <h2>My Profile</h2>
                                    <p>Manage your account information</p>
                                </div>

                                <form id="profileForm">
                                    @csrf
                                    @method('PUT')

                                    <div class="profile-card">
                                        <div class="card-header">
                                            <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Full Name *</label>
                                                    <input type="text" name="name" class="form-control"
                                                           value="{{ Auth::user()->name }}" required>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Email Address *</label>
                                                    <input type="email" name="email" class="form-control"
                                                           value="{{ Auth::user()->email }}" required>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="tel" name="phone" class="form-control"
                                                           value="{{ Auth::user()->phone }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-card">
                                        <div class="card-header">
                                            <h4><i class="fas fa-map-marker-alt"></i> Address Information</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Street Address</label>
                                                    <textarea name="address" class="form-control" rows="2">{{ Auth::user()->address }}</textarea>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="city" class="form-control"
                                                           value="{{ Auth::user()->city }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">State</label>
                                                    <input type="text" name="state" class="form-control"
                                                           value="{{ Auth::user()->state }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">ZIP Code</label>
                                                    <input type="text" name="zip_code" class="form-control"
                                                           value="{{ Auth::user()->zip_code }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Country</label>
                                                    <select name="country" class="form-select">
                                                        <option value="">Select Country</option>
                                                        <option value="US" {{ Auth::user()->country == 'US' ? 'selected' : '' }}>United States</option>
                                                        <option value="UK" {{ Auth::user()->country == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                                        <option value="CA" {{ Auth::user()->country == 'CA' ? 'selected' : '' }}>Canada</option>
                                                        <option value="AU" {{ Auth::user()->country == 'AU' ? 'selected' : '' }}>Australia</option>
                                                        <option value="IN" {{ Auth::user()->country == 'IN' ? 'selected' : '' }}>India</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Update Profile
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" id="deleteAccountBtn">
                                            <i class="fas fa-trash me-2"></i> Delete Account
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Orders Tab -->
                            <div id="ordersTab" class="tab-content">
                                <div class="profile-header">
                                    <h2>My Orders</h2>
                                    <p>View and track your orders</p>
                                </div>

                                <div class="profile-card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="allOrdersTable">
                                                <tr>
                                                    <td colspan="6" class="text-center">Loading orders...</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Tab -->
                            <div id="securityTab" class="tab-content">
                                <div class="profile-header">
                                    <h2>Security Settings</h2>
                                    <p>Manage your password and security preferences</p>
                                </div>

                                <div class="profile-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-key"></i> Change Password</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="changePasswordForm">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Current Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="current_password" class="form-control" id="currentPassword" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="new_password" class="form-control" id="newPassword" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-strength mt-2">
                                                    <small class="text-muted">Password strength:</small>
                                                    <div class="progress mt-1">
                                                        <div class="progress-bar" id="strengthBar" style="width: 0%"></div>
                                                    </div>
                                                    <small id="strengthText" class="text-muted">Enter a password</small>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="new_password_confirmation" class="form-control" id="confirmPassword" required>
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div id="passwordMatchMsg" class="mt-2"></div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i> Update Password
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="profile-card mt-3">
                                    <div class="card-header">
                                        <h4><i class="fas fa-shield-alt"></i> Account Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <strong>Account Created:</strong><br>
                                                {{ Auth::user()->created_at->format('F d, Y') }}
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Email Status:</strong><br>
                                                @if(Auth::user()->email_verified_at)
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-warning">Not Verified</span>
                                                @endif
                                            </div>
                                            @if(Auth::user()->provider)
                                                <div class="col-md-12 mt-2">
                                                    <strong>Connected with:</strong><br>
                                                    <span class="badge bg-info">
                                                <i class="fab fa-{{ Auth::user()->provider }} me-1"></i>
                                                {{ ucfirst(Auth::user()->provider) }}
                                            </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h5>Are you sure you want to delete your account?</h5>
                        <p class="text-muted">This action cannot be undone. All your data will be permanently removed.</p>
                        <div class="alert alert-warning">
                            <small>Please type <strong>DELETE</strong> to confirm</small>
                        </div>
                        <input type="text" id="deleteConfirmInput" class="form-control" placeholder="Type DELETE here">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>Delete Account</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function showTab(tabName) {
            $('.tab-content').removeClass('active');
            $('#' + tabName + 'Tab').addClass('active');
            $('.profile-menu li').removeClass('active');
            $('.profile-menu li[data-tab="' + tabName + '"]').addClass('active');
        }
        $(document).on('click', '.tab-link', function(e) {
            e.preventDefault();

            let tabName = $(this).data('tab');

            if (!tabName) return; // safety

            showTab(tabName);
        });
        $(document).ready(function() {
            // Load dashboard stats on page load
            loadDashboardStats();
            loadRecentOrders();
            loadAllOrders();

            // Tab switching function
            // // GLOBAL FUNCTION (must be outside document.ready)
            // function showTab(tabName) {
            //     document.querySelectorAll('.tab-content').forEach(tab => {
            //         tab.classList.remove('active');
            //     });
            //
            //     let activeTab = document.getElementById(tabName + 'Tab');
            //     if (activeTab) {
            //         activeTab.classList.add('active');
            //     }
            //
            //     document.querySelectorAll('.profile-menu li').forEach(li => {
            //         li.classList.remove('active');
            //     });
            //
            //     let activeMenu = document.querySelector('.profile-menu li[data-tab="' + tabName + '"]');
            //     if (activeMenu) {
            //         activeMenu.classList.add('active');
            //     }
            //
            //     // Optional loading
            //     if (tabName === 'dashboard') {
            //         loadDashboardStats();
            //         loadRecentOrders();
            //     } else if (tabName === 'orders') {
            //         loadAllOrders();
            //     }
            // }



            // Load dashboard statistics
            function loadDashboardStats() {
                $.ajax({
                    url: "{{ route('stats') }}",
                    type: "GET",
                    success: function(response) {
                        $('#totalOrders').text(response.total_orders);
                        $('#totalSpent').text('$' + response.total_spent);
                        $('#wishlistCount').text(response.wishlist_count);
                    }
                });
            }

            // Load recent orders
            function loadRecentOrders() {
                $.ajax({
                    url: "{{ route('recent-orders') }}",
                    type: "GET",
                    success: function(response) {
                        let html = '';
                        if (response.orders.length === 0) {
                            html = '<tr><td colspan="5" class="text-center">No orders yet</td></tr>';
                        } else {
                            response.orders.forEach(order => {
                                html += `
                            <tr>
                                <td>#${order.order_number}</td>
                                <td>${order.date}</td>
                                <td>$${order.total_amount}</td>
                                <td><span class="badge ${order.order_status === 'delivered' ? 'badge-success' : 'badge-warning'}">${order.order_status}</span></td>
                                <td><button class="btn btn-sm btn-outline-primary" onclick="viewOrder(${order.id})">View</button></td>
                            </tr>
                        `;
                            });
                        }
                        $('#recentOrdersTable').html(html);
                    }
                });
            }

            // Load all orders
            function loadAllOrders() {
                $.ajax({
                    url: "{{ route('all-orders') }}",
                    type: "GET",
                    success: function(response) {
                        let html = '';
                        if (response.orders.length === 0) {
                            html = '<tr><td colspan="6" class="text-center">No orders found</td></tr>';
                        } else {
                            response.orders.forEach(order => {
                                html += `
                            <tr>
                                <td>#${order.order_number}</td>
                                <td>${order.date}</td>
                                <td>${order.items_count}</td>
                                <td>$${order.total_amount}</td>
                                <td><span class="badge ${order.order_status === 'delivered' ? 'badge-success' : 'badge-warning'}">${order.order_status}</span></td>
                                <td><button class="btn btn-sm btn-outline-primary" onclick="viewOrder(${order.id})">View Details</button></td>
                            </tr>
                        `;
                            });
                        }
                        $('#allOrdersTable').html(html);
                    }
                });
            }

            // Profile Image Upload
            $('#profileImageInput').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profileImagePreview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                    uploadProfileImage(file);
                }
            });

            function uploadProfileImage(file) {
                const formData = new FormData();
                formData.append('profile_image', file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('upload-image') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', 'Profile picture updated', 'success');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to upload image', 'error');
                    }
                });
            }

            // Profile Form Submission
            $('#profileForm').submit(function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const submitBtn = $(this).find('button[type="submit"]');

                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('profile-update') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Profile updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#userName').text(response.data.name);
                        }
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'Failed to update profile';
                        Swal.fire('Error!', message, 'error');
                    },
                    complete: function() {
                        submitBtn.html('<i class="fas fa-save me-2"></i> Update Profile');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // Password Strength Checker
            $('#newPassword').on('input', function() {
                let password = $(this).val();
                let strength = 0;

                if (password.length >= 8) strength += 25;
                if (password.match(/[a-z]/)) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 25;
                if (password.match(/[^a-zA-Z0-9]/)) strength += 25;

                if (strength > 100) strength = 100;

                $('#strengthBar').css('width', strength + '%');

                if (strength <= 25) {
                    $('#strengthBar').removeClass('bg-success bg-warning').addClass('bg-danger');
                    $('#strengthText').text('Weak');
                } else if (strength <= 50) {
                    $('#strengthBar').removeClass('bg-success bg-danger').addClass('bg-warning');
                    $('#strengthText').text('Fair');
                } else if (strength <= 75) {
                    $('#strengthBar').removeClass('bg-danger bg-warning').addClass('bg-info');
                    $('#strengthText').text('Good');
                } else {
                    $('#strengthBar').removeClass('bg-danger bg-warning bg-info').addClass('bg-success');
                    $('#strengthText').text('Strong');
                }

                checkPasswordMatch();
            });

            function checkPasswordMatch() {
                let password = $('#newPassword').val();
                let confirm = $('#confirmPassword').val();

                if (confirm.length > 0) {
                    if (password === confirm) {
                        $('#passwordMatchMsg').html('<small class="text-success"><i class="fas fa-check-circle"></i> Passwords match</small>');
                    } else {
                        $('#passwordMatchMsg').html('<small class="text-danger"><i class="fas fa-times-circle"></i> Passwords do not match</small>');
                    }
                } else {
                    $('#passwordMatchMsg').html('');
                }
            }

            $('#confirmPassword').on('input', checkPasswordMatch);

            // Toggle Password Visibility
            $('.toggle-password').click(function() {
                let targetId = $(this).data('target');
                let input = $('#' + targetId);
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            // Change Password Form Submission
            $('#changePasswordForm').submit(function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const submitBtn = $(this).find('button[type="submit"]');

                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Updating...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('password-change') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', 'Password changed successfully', 'success');
                            $('#changePasswordForm')[0].reset();
                            $('#strengthBar').css('width', '0%');
                            $('#passwordMatchMsg').html('');
                        }
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'Failed to change password';
                        Swal.fire('Error!', message, 'error');
                    },
                    complete: function() {
                        submitBtn.html('<i class="fas fa-save me-2"></i> Update Password');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // Delete Account
            $('#deleteAccountBtn').click(function() {
                $('#deleteAccountModal').modal('show');
            });

            $('#deleteConfirmInput').on('input', function() {
                let value = $(this).val();
                $('#confirmDeleteBtn').prop('disabled', value !== 'DELETE');
            });

            $('#confirmDeleteBtn').click(function() {
                $.ajax({
                    url: "{{ route('delete') }}",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Account Deleted',
                                text: 'Your account has been deleted. Redirecting...',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('home') }}";
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete account', 'error');
                    }
                });
            });
        });

        // View order details
        function viewOrder(orderId) {
            Swal.fire({
                title: 'Order Details',
                text: 'Order #' + orderId,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection
