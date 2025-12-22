<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg top-navbar">
    <div class="container-fluid">
        <button class="sidebar-collapse-btn">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Search Bar -->
        <form class="d-flex search-form">
            <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                <input type="text" class="form-control" placeholder="Search products, orders, customers...">
            </div>
        </form>
        <!-- Navbar Right -->
        <div class="navbar-right">
            <!-- Notifications Dropdown -->
            <div class="dropdown notifications-dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-danger">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Notifications</h6>
                    <a href="#" class="dropdown-item">
                        <div class="notification-item">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <div class="notification-content">
                                <p class="mb-0">New order received</p>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="notification-item">
                            <i class="fas fa-user-check text-success"></i>
                            <div class="notification-content">
                                <p class="mb-0">New customer registered</p>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="notification-item">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            <div class="notification-content">
                                <p class="mb-0">Low stock alert</p>
                                <small class="text-muted">5 hours ago</small>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center">View all notifications</a>
                </div>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown profile-dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <div class="profile-avatar">
                        @if(request()->routeIs('admin-profile'))
                            <img src="{{ $adminDetails->profile_image ? asset('upload/' . $adminDetails->profile_image) : asset('assets/images/user.png') }}" alt="Admin User" class="profile-image">
                        @else
                            <img src="{{ session('profile_image') ? asset('upload/' . session('profile_image')) : asset('assets/images/user.png') }}" alt="Admin User" class="profile-image">
                        @endif
                    </div>
                    @if(request()->routeIs('admin-profile'))
                        <span class="profile-name" id="headerprofileNameDisplay">{{$adminDetails->name}}</span>
                    @else
                        <span class="profile-name">{{session('name')}}</span>
                    @endif
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{route('admin-profile')}}" class="dropdown-item">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                    <a href="{{route('settings')}}" class="dropdown-item">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('logout')}}" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

