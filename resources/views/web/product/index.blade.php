@extends('web.master')

@section('title', $product->name . ' - E-Shop')

@section('page-content')
    <div class="product-detail-section">
        <div class="container">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        @php
                            $imagePath = public_path('upload/product/' . $product->image);
                            $imageUrl = file_exists($imagePath) && !empty($product->image)
                                ? asset('upload/product/' . $product->image)
                                : asset('assets/images/web/placeholders/no-image.png');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="main-image" id="mainImage">
                        @php
                            $gallery = $product->gallery_images ? json_decode($product->gallery_images, true) : [];
                        @endphp

                        @if(count($gallery) > 0)
                            <div class="thumbnail-list">
                                <img src="{{ $imageUrl }}" class="thumbnail active" onclick="changeImage(this.src)">
                                @foreach($gallery as $image)
                                    <img src="{{ asset('upload/product-gallery/' . $image) }}" class="thumbnail" onclick="changeImage(this.src)">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <a href="#" class="product-category">
                            {{ $product->category->name }}
                        </a>

                        <h1 class="product-title">{{ $product->name }}</h1>

                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count">({{ $product->reviews_count }} reviews)</span>
                        </div>

                        <div class="product-price">
                            @if($product->discount_price)
                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                <span class="discount-badge">
                                -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                            </span>
                            @else
                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <div class="product-description">
                            {{ $product->short_description ?? Str::limit($product->description, 200) }}
                        </div>

                        <div class="product-meta">
                            <div class="meta-item">
                                <div class="meta-label">Availability:</div>
                                <div class="meta-value">
                                    @if($product->quantity > 10)
                                        <span class="stock-status in-stock">In Stock</span>
                                    @elseif($product->quantity > 0)
                                        <span class="stock-status low-stock">Only {{ $product->quantity }} left</span>
                                    @else
                                        <span class="stock-status out-stock">Out of Stock</span>
                                    @endif
                                </div>
                            </div>

                            @if($product->dimensions)
                                <div class="meta-item">
                                    <div class="meta-label">Dimensions:</div>
                                    <div class="meta-value">{{ $product->dimensions }}</div>
                                </div>
                            @endif

                            <div class="meta-item">
                                <div class="meta-label">SKU:</div>
                                <div class="meta-value">PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>

                        @if($product->quantity > 0)
                            <div class="quantity-selector">
                                <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                                <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->quantity }}">
                                <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                            </div>

                            <div class="action-buttons">
                                <button class="btn-add-cart" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                                </button>
                                <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlist({{ $product->id }})">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i> This product is currently out of stock.
                            </div>
                        @endif

                        <div class="share-section">
                            <span>Share:</span>
                            <div class="share-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ $product->name }}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . Request::url()) }}" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-headers">
                    <button class="tab-btn active" onclick="switchTab('description')">Description</button>
                    <button class="tab-btn" onclick="switchTab('specifications')">Specifications</button>
                    <button class="tab-btn" onclick="switchTab('reviews')">Reviews ({{ $product->reviews_count }})</button>
                </div>

                <div id="descriptionTab" class="tab-content active">
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>

                <div id="specificationsTab" class="tab-content">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Product Name</th>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $product->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price</th>
                                            <td>${{ number_format($product->discount_price ?? $product->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stock Status</th>
                                            <td>{{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        @if($product->dimensions)
                                            <tr>
                                                <th width="40%">Dimensions</th>
                                                <td>{{ $product->dimensions }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>SKU</th>
                                            <td>PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rating</th>
                                            <td>{{ $product->rating }} / 5 ({{ $product->reviews_count }} reviews)</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="reviewsTab" class="tab-content">
                    <div class="card">
                        <div class="card-body">
                            @if(Auth::check())
                                <div class="write-review mb-4">
                                    <h5>Write a Review</h5>
                                    <form id="reviewForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <div class="rating-input">
                                                <i class="far fa-star" data-rating="1"></i>
                                                <i class="far fa-star" data-rating="2"></i>
                                                <i class="far fa-star" data-rating="3"></i>
                                                <i class="far fa-star" data-rating="4"></i>
                                                <i class="far fa-star" data-rating="5"></i>
                                                <input type="hidden" name="rating" id="ratingValue" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Review</label>
                                            <textarea name="comment" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                            @endif

                            <div id="reviewsList">
                                <!-- Reviews will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="related-products">
                    <h3 class="section-title">You May Also Like</h3>
                    <div class="row g-4">
                        @foreach($relatedProducts as $related)
                            @php
                                $imagePath = public_path('upload/product/' . $related->image);
                                $imageUrl = file_exists($imagePath) && !empty($related->image)
                                    ? asset('upload/product/' . $related->image)
                                    : asset('assets/images/web/placeholders/no-image.png');
                            @endphp
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="{{ $imageUrl }}" alt="{{ $related->name }}">
                                        <div class="hover-overlay">
                                            <button class="add-to-cart-btn" onclick="addToCart({{ $related->id }})">
                                                <i class="fas fa-shopping-bag"></i> Quick Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="product-title">
                                            <a href="{{ route('product-slug', ['slug' => base64_encode($related->id)]) }}">{{ $related->name }}</a>
                                        </h4>
                                        <div class="product-price">
                                            @if($related->discount_price)
                                                <span class="current-price">${{ number_format($related->discount_price, 2) }}</span>
                                                <span class="old-price">${{ number_format($related->price, 2) }}</span>
                                            @else
                                                <span class="current-price">${{ number_format($related->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        // Change main image
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
                if (thumb.src === src) {
                    thumb.classList.add('active');
                }
            });
        }

        // Quantity functions
        function incrementQuantity() {
            let input = document.getElementById('quantity');
            let max = parseInt(input.getAttribute('max'));
            let value = parseInt(input.value);
            if (value < max) {
                input.value = value + 1;
            }
        }

        function decrementQuantity() {
            let input = document.getElementById('quantity');
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        }

        // Add to cart
        function addToCart(productId) {
            let quantity = document.getElementById('quantity')?.value || 1;

            $.ajax({
                url: "{{ route('cart-add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: quantity,
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
                error: function(xhr) {
                    let message = xhr.responseJSON?.message || 'Failed to add product';
                    Swal.fire('Error!', message, 'error');
                }
            });
        }

        // Toggle wishlist
        function toggleWishlist(productId) {
            let btn = $('#wishlistBtn');

            $.ajax({
                url: "{{ route('toggle') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.added) {
                        btn.addClass('active');
                        btn.html('<i class="fas fa-heart"></i>');
                        Swal.fire('Added!', 'Added to wishlist', 'success');
                    } else {
                        btn.removeClass('active');
                        btn.html('<i class="far fa-heart"></i>');
                        Swal.fire('Removed!', 'Removed from wishlist', 'info');
                    }
                    updateWishlistCount();
                },
                error: function() {
                    Swal.fire('Error!', 'Please login to add to wishlist', 'error');
                }
            });
        }

        // Switch tabs
        function switchTab(tab) {
            $('.tab-btn').removeClass('active');
            $('.tab-content').removeClass('active');

            $(`button:contains(${tab})`).addClass('active');
            $(`#${tab}Tab`).addClass('active');
        }

        // Star rating
        $('.rating-input i').hover(function() {
            let rating = $(this).data('rating');
            $('.rating-input i').each(function(index) {
                if (index < rating) {
                    $(this).removeClass('far').addClass('fas');
                } else {
                    $(this).removeClass('fas').addClass('far');
                }
            });
        });

        $('.rating-input i').click(function() {
            let rating = $(this).data('rating');
            $('#ratingValue').val(rating);
            $('.rating-input i').each(function(index) {
                if (index < rating) {
                    $(this).removeClass('far').addClass('fas');
                } else {
                    $(this).removeClass('fas').addClass('far');
                }
            });
        });

        // Submit review
        {{--$('#reviewForm').submit(function(e) {--}}
        {{--    e.preventDefault();--}}

        {{--    let rating = $('#ratingValue').val();--}}
        {{--    if (!rating) {--}}
        {{--        Swal.fire('Error!', 'Please select a rating', 'error');--}}
        {{--        return;--}}
        {{--    }--}}

        {{--    $.ajax({--}}
        {{--        url: "{{ route('', $product->id) }}",--}}
        {{--        type: "POST",--}}
        {{--        data: $(this).serialize(),--}}
        {{--        success: function(response) {--}}
        {{--            Swal.fire('Success!', 'Review submitted successfully', 'success');--}}
        {{--            $('#reviewForm')[0].reset();--}}
        {{--            loadReviews();--}}
        {{--        },--}}
        {{--        error: function() {--}}
        {{--            Swal.fire('Error!', 'Failed to submit review', 'error');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        // Load reviews
        {{--function loadReviews() {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('product.reviews', $product->id) }}",--}}
        {{--        type: "GET",--}}
        {{--        success: function(response) {--}}
        {{--            let html = '';--}}
        {{--            response.reviews.forEach(review => {--}}
        {{--                html += `--}}
        {{--                <div class="review-card">--}}
        {{--                    <div class="review-header">--}}
        {{--                        <span class="reviewer-name">${review.user_name}</span>--}}
        {{--                        <span class="review-date">${review.date}</span>--}}
        {{--                    </div>--}}
        {{--                    <div class="stars mb-2">--}}
        {{--                        ${'<i class="fas fa-star"></i>'.repeat(review.rating)}--}}
        {{--                        ${'<i class="far fa-star"></i>'.repeat(5 - review.rating)}--}}
        {{--                    </div>--}}
        {{--                    <div class="review-text">${review.comment}</div>--}}
        {{--                </div>--}}
        {{--            `;--}}
        {{--            });--}}
        {{--            $('#reviewsList').html(html);--}}
        {{--        }--}}
        {{--    });--}}
        // }

        // loadReviews();
    </script>
@endsection
