@extends('web.master')

@section('title', 'Order Details - E-Shop')

@section('page-content')
    <div class="order-details-section">
        <div class="container">
            <a href="{{ route('my-orders') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to My Orders
            </a>

            <div class="order-info-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                    <h3 class="mb-0">Order #: {{ $order->order_number }}</h3>
                    <span class="order-status-badge status-{{ $order->status }}">
                    <i class="fas fa-circle" style="font-size: 8px;"></i>
                    {{ ucfirst($order->status) }}
                </span>
                </div>
                <p class="text-muted">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div class="order-info-card">
                        <h4 class="section-title">Order Items</h4>
                        <div class="table-responsive">
                            <table class="items-table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>>
                                            <strong>{{ $item->product_name }}</strong>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                    <td>${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Discount</strong></td>
                                        <td>-${{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping</strong></td>
                                    <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tax</strong></td>
                                    <td>${{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr class="total-row">
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Shipping Information -->
                    <div class="order-info-card">
                        <h4 class="section-title">Shipping Information</h4>
                        <div class="info-item">
                            <div class="info-label">Name</div>
                            <div class="info-value">{{ $order->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $order->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $order->phone }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Address</div>
                            <div class="info-value">
                                {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}, {{ $order->country }}
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="order-info-card">
                        <h4 class="section-title">Payment Information</h4>
                        <div class="info-item">
                            <div class="info-label">Method</div>
                            <div class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Note -->
                    @if($order->note)
                        <div class="order-info-card">
                            <h4 class="section-title">Order Note</h4>
                            <p class="mb-0">{{ $order->note }}</p>
                        </div>
                    @endif

                    <!-- Track Order Link -->
                    <div class="order-info-card text-center">
                        <a href="{{ route('track-order', $order->order_number) }}" class="track-link">
                            <i class="fas fa-truck me-2"></i> Track Your Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
