@extends('web.master')

@section('title', 'My Wishlist - E-Shop')

@section('page-content')
    <div class="wishlist-section">
        <div class="container">
            <div class="wishlist-header">
                <h2>My Wishlist</h2>
                <p class="text-muted">Your favorite products saved for later</p>
            </div>

            <div class="wishlist-grid">
                @forelse($wishlistItems as $item)
                    <div class="wishlist-card" data-wishlist-id="{{ $item->id }}">
                        <div class="wishlist-image">
                            @php
                                $imagePath = public_path('upload/product/' . $item->product->image);
                                $imageUrl = file_exists($imagePath) && !empty($item->product->image) ? asset('upload/product/' . $item->product->image) : asset('assets/images/web/placeholders/no-image.png');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}">
                            <div class="remove-wishlist" onclick="removeFromWishlist({{ $item->id }})">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <div class="wishlist-info">
                            <h4 class="product-title">
                                <a href="{{ route('product-slug', ['slug' => base64_encode($item->product->id)]) }}">{{ $item->product->name }}</a>
                            </h4>
                            <div class="wishlist-price">
                                <span class="current-price">${{ number_format($item->product->discount_price ?? $item->product->price, 2) }}</span>
                                @if($item->product->discount_price)
                                    <span class="old-price">${{ number_format($item->product->price, 2) }}</span>
                                @endif
                            </div>
                            <div class="stock-status {{ $item->product->quantity > 0 ? 'in-stock' : 'out-stock' }}">
                                {{ $item->product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                            </div>
                            @if($item->product->quantity > 0)
                                <button class="btn-add-cart" onclick="addToCart({{ $item->product->id }})">
                                    <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                                </button>
                            @else
                                <button class="btn-add-cart" disabled style="opacity:0.5; cursor:not-allowed">
                                    <i class="fas fa-shopping-bag me-2"></i> Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-wishlist">
                        <i class="far fa-heart"></i>
                        <h4>Your wishlist is empty</h4>
                        <p>Save your favorite items here</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        function removeFromWishlist(wishlistId) {
            Swal.fire({
                title: 'Remove item?',
                text: 'Are you sure you want to remove this item from your wishlist?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('wishlist-remove') }}",
                        type: "GET",
                        data: { wishlist_id: wishlistId },
                        success: function(response) {
                            if (response.status) {
                                $(`.wishlist-card[data-wishlist-id="${wishlistId}"]`).fadeOut(300, function() {
                                    $(this).remove();
                                    updateWishlistCount();

                                    // Check if wishlist is empty
                                    if ($('.wishlist-card').length === 0) {
                                        location.reload();
                                    }
                                });
                                Swal.fire('Removed!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to remove item', 'error');
                        }
                    });
                }
            });
        }

        function addToCart(productId) {
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
        }
    </script>
@endsection
