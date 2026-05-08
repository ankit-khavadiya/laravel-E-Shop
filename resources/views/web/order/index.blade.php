@extends('web.master')

@section('title', 'My Orders - E-Shop')

@section('page-content')
    <div class="orders-section">
        <div class="container">
            <div class="orders-header">
                <h2>My Orders</h2>
                <p class="text-muted">View and track all your orders</p>
            </div>

            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <span class="order-number">Order #: {{ $order->order_number }}</span>
                                <span class="order-date ms-3">Placed on {{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                        <span class="order-status status-{{ $order->status }}">
                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                            </div>
                        </div>

                        <div class="order-items">
                            @foreach($order->items->take(2) as $item)
                                <div class="order-item">
                                    @php
                                        $imagePath = public_path('upload/product/' . $item->product->image);
                                        $imageUrl = file_exists($imagePath) && !empty($item->product->image)
                                            ? asset('upload/product/' . $item->product->image)
                                            : asset('assets/images/web/placeholders/no-image.png');
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="order-item-img" alt="{{ $item->product_name }}">
                                    <div class="flex-grow-1">
                                        <strong>{{ $item->product_name }}</strong>
                                        <div class="text-muted small">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                                    </div>
                                    <div class="fw-bold">${{ number_format($item->total, 2) }}</div>
                                </div>
                            @endforeach

                            @if($order->items->count() > 2)
                                <div class="text-muted small mt-2">
                                    + {{ $order->items->count() - 2 }} more item(s)
                                </div>
                            @endif
                        </div>

                        <div class="order-footer">
                            <div>
                                <span class="order-total">Total: ${{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="order-actions">
                                <a href="{{ route('order-details', $order->id) }}" class="btn-view">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                <a href="{{ route('track-order', $order->order_number) }}" class="btn-track">
                                    <i class="fas fa-truck me-1"></i> Track Order
                                </a>
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <button onclick="cancelOrder({{ $order->id }})" class="btn-cancel">
                                        <i class="fas fa-times me-1"></i> Cancel Order
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="empty-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h4>No Orders Yet</h4>
                    <p>You haven't placed any orders yet</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        function cancelOrder(orderId) {
            Swal.fire({
                title: 'Cancel Order?',
                text: 'Are you sure you want to cancel this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, cancel it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('cancel-order') }}/" + orderId,
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Cancelled!', 'Order cancelled successfully', 'success');
                                location.reload();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to cancel order', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endsection
