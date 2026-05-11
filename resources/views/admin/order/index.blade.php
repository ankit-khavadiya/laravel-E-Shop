@extends('admin.master')
@section('title','Order')
@section('page-content')
    <!-- Orders Page -->
    <section id="orders" class="page">
        <div class="page-header">
            <h2>Orders</h2>
            <p class="text-muted">Manage and track customer orders.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Order List</h5>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary active" data-status="all">All</button>
                            <button class="btn btn-outline-primary" data-status="pending">Pending</button>
                            <button class="btn btn-outline-primary" data-status="processing">Processing</button>
                            <button class="btn btn-outline-primary" data-status="shipped">Shipped</button>
                            <button class="btn btn-outline-primary" data-status="delivered">Delivered</button>
                            <button class="btn btn-outline-primary" data-status="cancelled">Cancelled</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="orderTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('model')
    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Order Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="orderDetailsContent"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let orderTable = $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get-orders') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('.btn-group .active').data('status');
                    }
                },
                columns: [
                    { data: 'order_code'},
                    { data: 'customer', orderable:false },
                    { data: 'created_at' },
                    { data: 'items_count' },
                    { data: 'total' },
                    { data: 'status_badge', orderable:false },
                    { data: 'action', orderable:false, searchable:false }
                ]
            });

            // Filter
            $('.btn-group button').click(function () {

                $('.btn-group button').removeClass('active');

                $(this).addClass('active');

                orderTable.ajax.reload();
            });

            // Update status
            $(document).on('click', '.updateStatus', function () {
                let id = $(this).data('id');
                let status = $(this).data('status');
                $.ajax({
                    url: "{{ route('update-order-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message);
                            orderTable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            });

            // Delete order
            $(document).on('click', '.deleteOrder', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this order?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete-order') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function (response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    orderTable.ajax.reload();
                                } else {
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                });
            });

            // View Order Details
            $(document).on('click', '.viewOrder', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin-order-details') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (response) {
                        let order = response.data;
                        let productsHtml = '';
                        order.items.forEach(item => {
                            let image = item.image_url;
                            productsHtml += `
                                <tr>
                                    <td>
                                        <img src="${image}" width="50" height="50" class="rounded">
                                    </td>
                                    <td>${item.product_name}</td>
                                    <td>$${parseFloat(item.price).toFixed(2)}</td>
                                    <td>${item.quantity}</td>
                                    <td>$${parseFloat(item.total).toFixed(2)}</td>
                                </tr>
                            `;
                        });

                        let html = `
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Customer Information</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <td>${order.name}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>${order.email}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>${order.phone}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>
                                                ${order.address},
                                                ${order.city},
                                                ${order.state},
                                                ${order.country}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Order Information</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Order Number</th>
                                            <td>${order.order_number}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>${order.status}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>${order.payment_method}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>${order.payment_status}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>$${parseFloat(order.total).toFixed(2)}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <h5 class="mb-3">Products</h5>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${productsHtml}
                                    </tbody>
                                </table>
                            </div>
                        `;
                        $('#orderDetailsContent').html(html);
                        $('#orderDetailsModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
