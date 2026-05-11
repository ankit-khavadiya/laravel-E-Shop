@extends('web.master')

@section('title', 'Track Order - E-Shop')

@section('page-content')
    <div class="track-section">
        <div class="container">
            <div class="track-header">
                <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                <h2>Track Your Order</h2>
                <div class="track-order-number">Order #: {{ $order->order_number }}</div>
                <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</p>
            </div>

            <!-- Progress Tracker -->
            <div class="progress-container">
                <div class="progress-track">
                    @foreach($timeline as $step)
                        <div class="progress-step">
                            <div class="step-icon
                        @if($step['completed']) completed
                        @elseif($step['status'] == $order->status) active
                        @endif">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>
                            <div class="step-title">{{ $step['status'] }}</div>
                            <div class="step-description">{{ $step['description'] }}</div>
                            @if($step['date'])
                                <div class="step-date">{{ \Carbon\Carbon::parse($step['date'])->format('M d, h:i A') }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Progress</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="order-info-card">
                        <h5 class="mb-3">Order Summary</h5>
                        <div class="info-row">
                            <span class="info-label">Order Status</span>
                            <span class="info-value">
                            <span class="badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Payment Method</span>
                            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Payment Status</span>
                            <span class="info-value">
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Amount</span>
                            <span class="info-value fw-bold text-primary">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="order-info-card">
                        <h5 class="mb-3">Shipping Address</h5>
                        <div class="info-row">
                            <span class="info-label">Name</span>
                            <span class="info-value">{{ $order->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $order->phone }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Address</span>
                            <span class="info-value">
                            {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}, {{ $order->country }}
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('my-orders') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Orders
                </a>
                @if($order->status != 'cancelled')
                    <button onclick="window.print()" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-print me-2"></i> Print Details
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
