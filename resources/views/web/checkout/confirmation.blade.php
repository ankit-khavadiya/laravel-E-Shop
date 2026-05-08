@extends('web.master')

@section('title', 'Order Confirmation - E-Shop')

@section('page-content')
    <div class="confirmation-section">
        <div class="container">
            <div class="confirmation-card">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2>Thank You for Your Order!</h2>
                <p class="text-muted">Your order has been placed successfully</p>
                <div class="order-number">Order #: {{ $order->order_number }}</div>
                <p>A confirmation email has been sent to your email address.</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="order-details-card">
                        <h4 class="order-details-title">Order Items</h4>
                        @foreach($order->items as $item)
                            <div class="order-item">
                                <div>
                                    <strong>{{ $item->product_name }}</strong>
                                    <br><small class="text-muted">Qty: {{ $item->quantity }}</small>
                                </div>
                                <div class="fw-bold">${{ number_format($item->total, 2) }}</div>
                            </div>
                        @endforeach

                        <div class="order-item mt-3">
                            <strong>Subtotal</strong>
                            <strong>${{ number_format($order->subtotal, 2) }}</strong>
                        </div>
                        <div class="order-item">
                            <span>Shipping</span>
                            <span>${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="order-item">
                            <span>Tax</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="order-item border-top pt-3 mt-2">
                            <strong>Total</strong>
                            <strong class="text-primary fs-5">${{ number_format($order->total, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-details-card">
                        <h4 class="order-details-title">Shipping Info</h4>
                        <div class="info-row">
                            <div class="info-label">Name:</div>
                            <div class="info-value">{{ $order->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email:</div>
                            <div class="info-value">{{ $order->email }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Phone:</div>
                            <div class="info-value">{{ $order->phone }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Address:</div>
                            <div class="info-value">{{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}, {{ $order->country }}</div>
                        </div>
                    </div>

                    <div class="order-details-card">
                        <h4 class="order-details-title">Payment Info</h4>
                        <div class="info-row">
                            <div class="info-label">Method:</div>
                            <div class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status:</div>
                            <div class="info-value">
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endsection
