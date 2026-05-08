@extends('web.master')

@section('title', 'Checkout - E-Shop')

@section('page-content')
    <div class="checkout-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <form id="checkoutForm">
                        @csrf
                        <!-- Billing Information -->
                        <div class="checkout-card">
                            <h4 class="card-title"><i class="fas fa-user"></i> Billing Information</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $lastOrder->name ?? Auth::user()->name ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $lastOrder->email ?? Auth::user()->email ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone *</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $lastOrder->phone ?? Auth::user()->phone ?? '') }}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address *</label>
                                    <textarea name="address" class="form-control" rows="2" required>{{ old('address', $lastOrder->address ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $lastOrder->city ?? '') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State *</label>
                                    <input type="text" name="state" class="form-control" value="{{ old('state', $lastOrder->state ?? '') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">ZIP Code *</label>
                                    <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code', $lastOrder->zip_code ?? '') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Country *</label>
                                    <select name="country" class="form-select" required>
                                        <option value="">Select Country</option>
                                        <option value="US" {{ old('country', $lastOrder->country ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="UK" {{ old('country', $lastOrder->country ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="CA" {{ old('country', $lastOrder->country ?? '') == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="IN" {{ old('country', $lastOrder->country ?? '') == 'IN' ? 'selected' : '' }}>India</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-card">
                            <h4 class="card-title"><i class="fas fa-credit-card"></i> Payment Method</h4>

                            <div class="payment-method active" data-method="cod">
                                <label class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="cod" class="payment-method-radio" checked>
                                    <span class="ms-2"><strong>Cash on Delivery</strong><br><small class="text-muted">Pay when you receive</small></span>
                                </label>
                            </div>

                            <div class="payment-method" data-method="stripe">
                                <label class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="stripe" class="payment-method-radio">
                                    <span class="ms-2"><strong>Credit/Debit Card</strong><br><small class="text-muted">Secure Stripe payment</small></span>
                                </label>
                            </div>

                            <div class="payment-method" data-method="paypal">
                                <label class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="paypal" class="payment-method-radio">
                                    <span class="ms-2"><strong>PayPal</strong><br><small class="text-muted">Fast & secure</small></span>
                                </label>
                            </div>

                            <div class="payment-method" data-method="bank_transfer">
                                <label class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="payment-method-radio">
                                    <span class="ms-2"><strong>Bank Transfer</strong><br><small class="text-muted">Direct bank transfer</small></span>
                                </label>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="checkout-card">
                            <h4 class="card-title"><i class="fas fa-pencil-alt"></i> Order Notes</h4>
                            <textarea name="note" class="form-control" rows="3" placeholder="Special notes for delivery..."></textarea>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="order-summary">
                        <h4 class="card-title">Order Summary</h4>

                        @foreach($cartItems as $item)
                            @php $price = $item->product->discount_price ?? $item->product->price; @endphp
                            <div class="order-item">
                                @php
                                    $imagePath = public_path('upload/product/' . $item->product->image);
                                    $imageUrl = file_exists($imagePath) && !empty($item->product->image)
                                        ? asset('upload/product/' . $item->product->image)
                                        : asset('assets/images/web/placeholders/no-image.png');
                                @endphp
                                <img src="{{ $imageUrl }}" class="order-item-img" alt="{{ $item->product->name }}">
                                <div class="flex-grow-1">
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                </div>
                                <div class="fw-bold">${{ number_format($price * $item->quantity, 2) }}</div>
                            </div>
                        @endforeach

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <strong>${{ number_format($total, 2) }}</strong>
                        </div>

                        <button type="button" class="btn-place-order" onclick="placeOrder()">
                            <i class="fas fa-check-circle me-2"></i> Place Order
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ route('cart') }}" class="text-muted">← Back to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingOverlay" style="display: none;">
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
            <div class="loading-text mt-3 text-white">Processing your order...</div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        $(document).ready(function() {
            // Payment method selection
            $('.payment-method').click(function() {
                $('.payment-method').removeClass('active');
                $(this).addClass('active');
                $(this).find('.payment-method-radio').prop('checked', true);
            });
        });

        function placeOrder() {
            // Validate form
            if (!$('#checkoutForm')[0].checkValidity()) {
                $('#checkoutForm')[0].reportValidity();
                return;
            }

            $('#loadingOverlay').fadeIn();

            $.ajax({
                url: "{{ route('checkout-process') }}",
                type: "POST",
                data: $('#checkoutForm').serialize(),
                success: function(response) {
                    if (response.status) {
                        window.location.href = "{{ url('order-confirmation') }}/" + response.data.order_id;
                    } else {
                        $('#loadingOverlay').fadeOut();
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    $('#loadingOverlay').fadeOut();
                    let message = xhr.responseJSON?.message || 'Failed to place order';
                    Swal.fire('Error!', message, 'error');
                },
            });
        }
    </script>
@endsection
