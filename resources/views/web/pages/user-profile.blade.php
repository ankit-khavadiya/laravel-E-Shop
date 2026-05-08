@extends('web.master')

@section('title', 'My Profile - E-Shop')

@section('page-content')
    <div class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="row g-0">
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="profile-sidebar">
                            <div class="avatar-wrapper" onclick="document.getElementById('profileImageInput').click()">
                                <img src="{{ Auth::user()->profile_image ? asset('upload/web/'.Auth::user()->profile_image) : asset('assets/images/web/placeholders/user-placeholder.jpg') }}"
                                     alt="Profile Image"
                                     id="profileImage"
                                     class="profile-img profile">
                                <div class="avatar-overlay" onclick="document.getElementById('profileImageInput').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <form id="imageUploadForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <input type="file" name="image" id="profileImageInput" class="d-none" accept="image/*">
                                <label id="profileImageInput-error" class="error gt-s1error text-danger" for="profileImageInput" style="display: none"></label>
                            </form>

                            <h4 id="userName">{{ Auth::user()->name }}</h4>
                            <p>{{ Auth::user()->email }}</p>

                            <ul class="profile-menu">
                                <li class="active" data-tab="dashboard">
                                    <a href="javascript:void(0)" onclick="showTab('dashboard'); return false;">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li data-tab="profile">
                                    <a href="javascript:void(0)" onclick="showTab('profile'); return false;">
                                        <i class="fas fa-user"></i> My Profile
                                    </a>
                                </li>
                                <li data-tab="orders">
                                    <a href="javascript:void(0)" onclick="showTab('orders'); return false;">
                                        <i class="fas fa-shopping-bag"></i> My Orders
                                    </a>
                                </li>
                                <li data-tab="security">
                                    <a href="javascript:void(0)" onclick="showTab('security'); return false;">
                                        <i class="fas fa-key"></i> Security
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
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
                                        <h3 id="userWishlistCount">0</h3>
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
                                    <div class="profile-card">
                                        <div class="card-header">
                                            <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                                    <label class="form-label">Full Name *</label>
                                                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter your name">
                                                    <label id="name-error" class="error text-danger" for="name" style="display: none"></label>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Email Address *</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter your email">
                                                    <label id="email-error" class="error text-danger" for="name" style="display: none"></label>

                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}" placeholder="Enter your phone">
                                                    <label id="phone-error" class="error text-danger" for="phone" style="display: none"></label>
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
                                                    <textarea type="text" name="address" id="address" class="form-control" rows="2" placeholder="Enter your address">{{ Auth::user()->address }}</textarea>
                                                    <label id="address-error" class="error text-danger" for="address" style="display: none"></label>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="city" class="form-control" id="city" value="{{ Auth::user()->city }}" placeholder="Enter your city">
                                                    <label id="city-error" class="error text-danger" for="city" style="display: none"></label>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">State</label>
                                                    <input type="text" name="state" class="form-control" id="state" value="{{ Auth::user()->state }}" placeholder="Enter your state">
                                                    <label id="state-error" class="error text-danger" for="state" style="display: none"></label>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">ZIP Code</label>
                                                    <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ Auth::user()->zip_code }}" placeholder="Enter your Zip code">
                                                    <label id="zip_code-error" class="error text-danger" for="zip_code" style="display: none"></label>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Country</label>
                                                    <select name="country" class="form-select">
                                                        <option value='' disabled selected>-- Please select a category --</option>                                                        <option value="US" {{ Auth::user()->country == 'US' ? 'selected' : '' }}>United States</option>
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
                                        <button type="submit" name="submit" id="updateBtn" class="btn btn-primary"><i class="fas fa-save me-2"></i> Update Profile</button>
                                        <button type="button" class="btn btn-outline-danger" id="deleteAccountBtn"><i class="fas fa-trash me-2"></i> Delete Account</button>
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
                                            <table id="allOrdersTable" class="table">
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
                                                <tbody id="allOrdersTableBody">
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
                                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <label id="currentPassword-error" class="error text-danger" for="currentPassword" style="display: none"></label>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="newPassword" class="form-control" id="newPassword">
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
                                                <label id="newPassword-error" class="error text-danger" for="newPassword" style="display: none"></label>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <label id="confirmPassword-error" class="error text-danger" for="confirmPassword" style="display: none"></label>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-primary">
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

@section('webJs')
    <script>
        $(document).ready(function() {
            // Load dashboard stats on page load
            loadDashboardStats();
            loadRecentOrders();
            loadAllOrders();

            // Tab switching function
            window.showTab = function(tabName) {
                // Hide all tabs
                $('.tab-content').removeClass('active');
                // Show selected tab
                $('#' + tabName + 'Tab').addClass('active');

                // Update active menu
                $('.profile-menu li').removeClass('active');
                $('.profile-menu li[data-tab="' + tabName + '"]').addClass('active');

                // Load data based on tab
                if (tabName === 'dashboard') {
                    loadDashboardStats();
                    loadRecentOrders();
                } else if (tabName === 'orders') {
                    loadAllOrders();
                }
            };

            // Load dashboard statistics
            function loadDashboardStats() {
                $.ajax({
                    url: "{{ route('stats') }}",
                    type: "GET",
                    success: function(response) {
                        $('#totalOrders').text(response.total_orders);
                        $('#totalSpent').text('$' + response.total_spent);
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
                        if (!response.orders) {
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

                $('#allOrdersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,

                    ajax: "{{ route('all-orders') }}",

                    columns: [
                        { data: 'order_number', name: 'order_number' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'items', name: 'items' },
                        { data: 'total', name: 'total' },
                        { data: 'status', name: 'status', orderable: false, searchable: false },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ]
                });
            }

            // Profile Image Upload
            $('#profileImageInput').on('change', function () {
                $('#imageUploadForm').submit();
            });

            $('#imageUploadForm').validate({
                rules: {
                    image: { required: true },
                },
                submitHandler: function (form) {
                    let formData = new FormData(form);
                    $.ajax({
                        url: "{{ route('user-profile-image') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            const imageUrl = "{{ asset('upload') }}/web/" + res.data;

                            $('.profile').attr('src', imageUrl + '?t=' + new Date().getTime()); // cache busting

                            toastr.success(res.message);
                            $('#userProfileImage-error').hide();
                        },
                        error: function (xhr) {
                            const res = xhr.responseJSON;
                            if (res?.error?.image) {
                                $('#profileImageInput-error').html(res.error.image[0]).show();
                            } else {
                                toastr.error('Image upload failed');
                            }
                        }
                    });
                }
            });

            // Profile Form Submission
            $('#profileForm').validate({
                rules: {
                    name: { required: true },
                    email: { required: true,email: true}
                },
                submitHandler: function (form) {
                    var formData = new FormData(form)
                    $.ajax({
                        url: "{{ route('profile-update') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend:function (){
                            $('#updateBtn').html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');
                            $('#updateBtn').attr('disabled', true);
                        },
                        success: function (response) {
                            if (response.status) {
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
                        error: function (xhr) {
                            let message = xhr.responseJSON?.message || 'Failed to update profile';
                            Swal.fire('Error!', message, 'error');
                        },
                        complete: function () {
                            $('#updateBtn').html('<i class="fas fa-save me-2"></i> Update Profile');
                            $('#updateBtn').attr('disabled', false);
                        }
                    })
                }
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
                        $('#confirmPassword-error').html('<small class="text-success"><i class="fas fa-check-circle"></i> Passwords match</small>');
                    } else {
                        $('#confirmPassword-error').html('<small class="text-danger"><i class="fas fa-times-circle"></i> Passwords do not match</small>');
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
            $('#changePasswordForm').validate({
                rules: {
                    currentPassword: {required: true},
                    newPassword: {required: true},
                    confirmPassword: {required: true}
                },
                messages: {
                    currentPassword: {
                        required: "please enter currentPassword",
                    },
                    newPassword: {
                        required: "please enter newPassword",
                    },
                    confirmPassword: {
                        required: "please enter confirmPassword"
                    }
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    $.ajax({
                        url: "{{route('user-password-change')}}",
                        method: "POST",
                        dataType: "JSON",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#changePasswordBtn').html('<i class="fas fa-spinner fa-spin me-2"></i> Updating...');
                            $('#changePasswordBtn').attr('disabled', true);
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Password changed successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#changePasswordForm')[0].reset();
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            console.log(res);
                            if (res?.error) {
                                if (res.error.currentPassword) {
                                    $('#currentPassword-error').html(res.error.currentPassword[0]).show();
                                }
                                if (res.error.newPassword) {
                                    $('#newPassword-error').html(res.error.newPassword[0]).show();
                                }
                            } else if (res?.message) {
                                toastr.error(res.message);
                            }
                        },
                        complete: function () {
                            $('#changePasswordBtn').html('<i class="fas fa-save me-2"></i> Update Password');
                            $('#changePasswordBtn').attr('disabled', false);
                        }
                    });
                }
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
                const userId = {{ Auth::user()->id }}
                $.ajax({
                    url: "{{route('user-password-change')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: { id: userId },
                    beforeSend: function () {
                        $('#confirmDeleteBtn').html('<i class="fas fa-spinner fa-spin me-2"></i> Deleteing...');
                        $('#confirmDeleteBtn').attr('disabled', true);
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
                    },
                    complete: function () {
                        $('#confirmDeleteBtn').html('Delete Account');
                        $('#confirmDeleteBtn').attr('disabled', false);
                    }
                });
            });
        });

        // View order details
        function viewOrder(orderId) {
            window.location.href = "{{ url('order-details') }}/" + orderId;
        }
    </script>
@endsection
