@extends('web.master')

@section('title', 'Shopping Cart - E-Shop')

@section('page-content')
    <div class="cart-section">
        <div class="container">
            <div class="cart-header">
                <h2>Shopping Cart</h2>
                <p class="text-muted">Review and manage your items</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="cartItems">
                            @forelse($cartItems as $item)
                                <tr id="cart-row-{{ $item->id }}">
                                    <td data-label="Product">
                                        <div class="cart-product">
                                            @php
                                                $imagePath = public_path('upload/product/' . $item->product->image);
                                                $imageUrl = file_exists($imagePath) && !empty($item->product->image) ? asset('upload/product/' . $item->product->image) : asset('assets/images/web/placeholders/no-image.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" class="cart-product-img" alt="{{ $item->product->name }}">
                                            <div>
                                                <a href="{{ route('product-slug', ['slug' => base64_encode($item->product->id)]) }}" class="text-decoration-none fw-bold">
                                                    {{ $item->product->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Price">
                                        ${{ number_format($item->product->discount_price ?? $item->product->price, 2) }}
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="quantity-control">
                                            <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 'minus')"> - </button>
                                            <input type="number" class="cart-quantity" id="qty_{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" readonly>
                                            <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 'plus')"> + </button>
                                        </div>
                                    </td>
                                    <td data-label="Total" id="total_{{ $item->id }}">
                                        ${{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 2) }}
                                    </td>
                                    <td data-label="Action">
                                        <i class="fas fa-trash-alt remove-item" onclick="removeFromCart({{ $item->id }})"></i>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                            <h4>Your cart is empty</h4>
                                            <p>Looks like you haven't added any items yet</p>
                                            <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="summary-title">Order Summary</h4>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <span id="shipping">${{ number_format($shipping, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span id="tax">${{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <strong id="total">${{ number_format($total, 2) }}</strong>
                        </div>

                        <a href="{{ route('checkout') }}" >
                            <button class="btn-checkout">
                                <i class="fas fa-lock me-2"></i> Proceed to Checkout
                            </button>
                        </a>

                        <div class="text-center mt-3">
                            <a href="{{ route('shop') }}" class="text-muted">
                                <i class="fas fa-arrow-left me-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        function updateQuantity(cartId, type) {
            let qtyInput = $('#qty_' + cartId);
            let currentQty = parseInt(qtyInput.val());
            let newQty = type === 'plus' ? currentQty + 1 : currentQty - 1;

            if (newQty < 1) {
                return;
            }

            $.ajax({
                url: "{{ route('cart-update') }}",
                type: "GET",
                data: {
                    cart_id: cartId,
                    quantity: newQty
                },
                success: function(response) {
                    if (response.status) {
                        qtyInput.val(newQty);
                        $('#total_' + cartId).text('$' + response.data.item_total);
                        $('#subtotal').text('$' + response.data.subtotal);
                        $('#shipping').text('$' + response.data.shipping);
                        $('#tax').text('$' + response.data.tax);
                        $('#total').text('$' + response.data.total);

                        updateCartCount();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to update quantity', 'error');
                }

            });

        }

        function removeFromCart(cartId) {
            Swal.fire({
                title: 'Remove item?',
                text: 'Are you sure you want to remove this item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('cart-delete') }}",
                        type: "GET",
                        data: {
                            cart_id: cartId
                        },
                        success: function(response) {
                            if (response.status) {
                                $('#cart-row-' + cartId).remove();
                                $('#subtotal').text('$' + response.data.subtotal);
                                $('#shipping').text('$' + response.data.shipping);
                                $('#tax').text('$' + response.data.tax);
                                $('#total').text('$' + response.data.total);

                                updateCartCount();

                                if (response.data.is_empty) {
                                    location.reload();
                                }

                                Swal.fire('Removed!', response.message, 'success');

                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
