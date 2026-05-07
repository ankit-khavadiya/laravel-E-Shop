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
                @foreach($popularCategories as $popularCategory)
                    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h4>{{$popularCategory['name']}}</h4>
                            <p>{{$popularCategory['total_products']}} Products</p>
                            <a href="{{ route('shop') }}">Shop Now →</a>
                        </div>
                    </div>
                @endforeach
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
            @if($featuredProducts)
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
                                    <a href="{{ route('product-slug', ['slug' => base64_encode($product->id)]) }}" class="quick-view-btn" data-id="{{ $product->id }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                                <div class="product-image">
                                    @php
                                        $imagePath = public_path('upload/product/' . $product->image);
                                        $imageUrl = file_exists($imagePath) && !empty($product->image) ? asset('upload/product/' . $product->image) : asset('assets/images/web/placeholders/no-image.png');
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
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
                                        <a href="{{ route('product-slug', ['slug' => base64_encode($product->id)]) }}">{{ $product->name }}</a>
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
            @else
                <div class="row justify-content-center g-3" data-aos="fade-up">
                    <div class="col-12">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="text-center d-flex flex-column justify-content-center">
                                <h4 class="mb-1">No Featured Products Available</h4>
                                <span class="fs-16px mb-0 text-muted">Please check back later for updates</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
{{--    <section class="testimonials-section">--}}
{{--        <div class="container">--}}
{{--            <div class="section-header text-center" data-aos="fade-up">--}}
{{--                <span class="section-subtitle">Testimonials</span>--}}
{{--                <h2 class="section-title">What Our Customers Say</h2>--}}
{{--                <p class="section-text">Join thousands of satisfied customers worldwide</p>--}}
{{--            </div>--}}

{{--            <div class="testimonials-slider" data-aos="fade-up">--}}
{{--                <div class="swiper-wrapper">--}}
{{--                    @foreach($testimonials as $testimonial)--}}
{{--                        <div class="swiper-slide">--}}
{{--                            <div class="testimonial-card">--}}
{{--                                <div class="testimonial-quote">--}}
{{--                                    <i class="fas fa-quote-left"></i>--}}
{{--                                </div>--}}
{{--                                <div class="testimonial-rating">--}}
{{--                                    @for($i = 1; $i <= 5; $i++)--}}
{{--                                        <i class="fas fa-star"></i>--}}
{{--                                    @endfor--}}
{{--                                </div>--}}
{{--                                <p class="testimonial-text">{{ $testimonial->comment }}</p>--}}
{{--                                <div class="testimonial-author">--}}
{{--                                    <img src="{{ asset('upload/web/' . $testimonial->image) }}" alt="{{ $testimonial->name }}">--}}
{{--                                    <div>--}}
{{--                                        <h5>{{ $testimonial->name }}</h5>--}}
{{--                                        <span>{{ $testimonial->position }}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--                <div class="swiper-pagination"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <!-- Brands Section -->
    <section class="brands-section">
        <div class="container">
            <div class="row g-4 align-items-center">
                @foreach($brand as $brands)
                    <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="brand-logo">
{{--                            <img src="{{ asset('frontend/images/brands/nike.png') }}" alt="Nike">--}}
                            <h4>{{$brands['name']}}</h4>
                        </div>
                    </div>
                @endforeach

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


    </script>
@endsection
