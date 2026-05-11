@extends('admin.master')
@section('title','Customer')
@section('page-content')
    <!-- Customers Page -->
    <section id="customers" class="page">
        <div class="page-header">
            <h2>Customers</h2>
            <p class="text-muted">Manage your customer database.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Customer List</h5>
                        <button class="btn btn-primary">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="customerTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="customerTableBody">
                                <!-- Customers will be loaded here via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('model')
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Customer Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="customerModalContent"></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let customerTable = $('#customerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-customers') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {data: 'customer_id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'phone'},
                    {data: 'orders_count'},
                    {data: 'total_spent'},
                    {data: 'action', orderable: false, searchable: false}
                ]
            });

            // VIEW CUSTOMER
            $(document).on('click', '.viewCustomer', function () {
                $.post("{{ route('customer-details') }}", {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                }, function (res) {
                    let c = res.data;
                    let ordersHtml = '';
                    c.orders.forEach(order => {
                        ordersHtml += `
                            <tr>
                                <td>ORD-${order.id}</td>
                                <td>$${parseFloat(order.total).toFixed(2)}</td>
                                <td>${order.status}</td>
                            </tr>
                        `;
                    });

                    let html = `
                        <h5>Customer Info</h5>
                        <p><b>Name:</b> ${c.name}</p>
                        <p><b>Email:</b> ${c.email}</p>
                        <p><b>Phone:</b> ${c.phone ?? '-'}</p>

                        <hr>

                        <h5>Orders</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Order</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                            ${ordersHtml}
                        </table>
                    `;

                    $('#customerModalContent').html(html);
                    $('#customerModal').modal('show');
                });
            });

            // DELETE CUSTOMER
            $(document).on('click', '.deleteCustomer', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Delete customer?",
                    icon: "warning",
                    showCancelButton: true
                }).then((r) => {
                    if (r.isConfirmed) {
                        $.post("{{ route('delete-customer') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function (res) {
                            toastr.success(res.message);
                            customerTable.ajax.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection

