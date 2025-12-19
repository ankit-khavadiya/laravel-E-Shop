<!-- Sidebar -->
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.home') }}" class="sidebar-brand">
            <i class="fas fa-shopping-bag"></i>
            <span>E-Shop Admin</span>
        </a>
        <button class="sidebar-toggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a href="{{ route('admin.home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('products') }}"
               class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i>
                <span>Products</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('orders') }}"
               class="nav-link {{ request()->routeIs('orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customers') }}"
               class="nav-link {{ request()->routeIs('customers*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('categories') }}"
               class="nav-link {{ request()->routeIs('categories*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('payments') }}"
               class="nav-link {{ request()->routeIs('payments*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('settings') }}"
               class="nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="theme-toggle">
            <i class="fas fa-moon"></i>
            <span>Dark Mode</span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
            </div>
        </div>
        <a href="{{ route('logout') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</nav>
