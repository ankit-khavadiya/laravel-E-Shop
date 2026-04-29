@extends('web.master')

@section('title', 'E-Shop - Premium Online Store')

@section('page-content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <span class="hero-badge">Summer Sale 2024</span>
                        <h1 class="hero-title">Elevate Your Style with Premium Products</h1>
                        <p class="hero-text">Discover the latest trends and exclusive collections. Shop now and enjoy up to 50% off on selected items.</p>
                        <div class="hero-buttons">
                            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">Shop Now</a>
                            <a href="#" class="btn btn-outline-primary btn-lg">Explore Collection</a>
                        </div>
                        <div class="hero-stats">
                            <div class="stat">
                                <h3>500+</h3>
                                <p>Products</p>
                            </div>
                            <div class="stat">
                                <h3>10k+</h3>
                                <p>Happy Customers</p>
                            </div>
                            <div class="stat">
                                <h3>50+</h3>
                                <p>Brands</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image">
                        <img src="{{ asset('frontend/images/hero-image.png') }}" alt="Hero Image" class="img-fluid">
                        <div class="floating-card card-1">
                            <i class="fas fa-truck"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="floating-card card-3">
                            <i class="fas fa-headset"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-subtitle">Shop by Category</span>
                <h2 class="section-title">Popular Categories</h2>
                <p class="section-text">Explore our wide range of products across different categories</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Electronics</h4>
                        <p>120 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <h4>Fashion</h4>
                        <p>350 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4>Home & Living</h4>
                        <p>280 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <h4>Sports</h4>
                        <p>95 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4>Books</h4>
                        <p>200 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="350">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h4>Toys & Games</h4>
                        <p>150 Products</p>
                        <a href="#">Shop Now →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="products-section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-subtitle">Featured Products</span>
                <h2 class="section-title">Best Selling Items</h2>
                <p class="section-text">Hand-picked products just for you</p>
            </div>

            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                        <div class="product-card">
                            <div class="product-badge">
                                @if($product->discount_price)
                                    <span class="badge-sale">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="badge-featured">Featured</span>
                                @endif
                            </div>
                            <div class="product-actions">
                                <a href="#" class="wishlist-btn" data-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="#" class="quick-view-btn" data-id="{{ $product->id }}">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                            <div class="product-image">
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
                                <div class="hover-overlay">
                                    <button class="add-to-cart-btn" data-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $product->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span>({{ $product->reviews_count }})</span>
                                </div>
                                <h4 class="product-title">
                                    <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                </h4>
                                <div class="product-price">
                                    @if($product->discount_price)
                                        <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                        <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('shop') }}" class="btn btn-outline-primary btn-lg">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="banner-card banner-1">
                        <div class="banner-content">
                            <span class="banner-subtitle">Limited Time Offer</span>
                            <h3>Summer Collection</h3>
                            <p>Up to 40% off on selected items</p>
                            <a href="#" class="btn btn-light">Shop Now →</a>
                        </div>
                        <div class="banner-image">
                            <img src="{{ asset('frontend/images/banner-1.png') }}" alt="Banner">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="banner-card banner-2">
                        <div class="banner-content">
                            <span class="banner-subtitle">New Arrivals</span>
                            <h3>Electronics Sale</h3>
                            <p>Get the latest gadgets at best prices</p>
                            <a href="#" class="btn btn-light">Shop Now →</a>
                        </div>
                        <div class="banner-image">
                            <img src="{{ asset('frontend/images/banner-2.png') }}" alt="Banner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-subtitle">Testimonials</span>
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-text">Join thousands of satisfied customers worldwide</p>
            </div>

            <div class="testimonials-slider" data-aos="fade-up">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-quote">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                <div class="testimonial-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <p class="testimonial-text">{{ $testimonial->comment }}</p>
                                <div class="testimonial-author">
                                    <img src="{{ asset('storage/testimonials/' . $testimonial->image) }}" alt="{{ $testimonial->name }}">
                                    <div>
                                        <h5>{{ $testimonial->name }}</h5>
                                        <span>{{ $testimonial->position }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="brands-section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/nike.png') }}" alt="Nike">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/adidas.png') }}" alt="Adidas">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/apple.png') }}" alt="Apple">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="250">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/samsung.png') }}" alt="Samsung">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/sony.png') }}" alt="Sony">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="350">
                    <div class="brand-logo">
                        <img src="{{ asset('frontend/images/brands/lg.png') }}" alt="LG">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Free Shipping</h4>
                        <p>On orders over $50</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h4>30-Day Returns</h4>
                        <p>Easy returns policy</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Secure Payment</h4>
                        <p>100% secure transactions</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p>Dedicated customer support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('webJs')
    <script>
        // Initialize Swiper Slider
        new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        });

        // Add to Cart
        $('.add-to-cart-btn').click(function(e) {
            e.preventDefault();
            let productId = $(this).data('id');

            $.ajax({
                url: "{{ route('cart-add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'Product added successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    updateCartCount();
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to add product', 'error');
                }
            });
        });

        // Add to Wishlist
        $('.wishlist-btn').click(function(e) {
            e.preventDefault();
            let productId = $(this).data('id');
            let icon = $(this).find('i');

            $.ajax({
                url: "{{ route('wishlist.toggle') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.added) {
                        icon.removeClass('far').addClass('fas');
                        Swal.fire('Added!', 'Added to wishlist', 'success');
                    } else {
                        icon.removeClass('fas').addClass('far');
                        Swal.fire('Removed!', 'Removed from wishlist', 'info');
                    }
                    updateWishlistCount();
                }
            });
        });
    </script>
@endsection
