<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-shopping-bag me-2"></i>
                <span>E-SHOP</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Shop</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('shop') }}">All Products</a></li>
                            <li><a class="dropdown-item" href="#">New Arrivals</a></li>
                            <li><a class="dropdown-item" href="#">Best Sellers</a></li>
                            <li><a class="dropdown-item" href="#">On Sale</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Featured</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>

                <div class="header-actions">
                    <a href="#" class="search-toggle" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search"></i>
                    </a>

                    <a href="{{ route('wishlist') }}" class="wishlist-link">
                        <i class="far fa-heart"></i>
                        <span class="badge" id="wishlistCount">0</span>
                    </a>

                    <a href="{{ route('cart') }}" class="cart-link">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="badge" id="cartCount">0</span>
                    </a>

                    @auth
                        <div class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->profile_image ? asset('upload/'.Auth::user()->profile_image) : asset('assets/images/web/placeholders/user-placeholder.jpg') }}" alt="User" class="user-avatar">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{route('user-profile')}}"><i class="fas fa-user me-2"></i>My Account</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-bag me-2"></i>My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fas fa-heart me-2"></i>Wishlist</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Sign In</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>
