@extends('admin.master')
@section('title','Payment')
@section('page-content')
    <!-- Payments Page -->
    <section id="payments" class="page">
        <div class="page-header">
            <h2>Payments</h2>
            <p class="text-muted">View and manage payment transactions.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Payment History</h5>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary active filterBtn" data-status="all">All</button>
                            <button class="btn btn-outline-primary filterBtn" data-status="success">Successful</button>
                            <button class="btn btn-outline-primary filterBtn" data-status="failed">Failed</button>
                            <button class="btn btn-outline-primary filterBtn" data-status="pending">Pending</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="paymentTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody id="paymentTableBody">
                                <!-- Payments will be loaded here via JavaScript -->
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
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="paymentModalContent">
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let paymentTable = $('#paymentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-payments') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('.filterBtn.active').data('status'); // FIXED
                    }
                },
                columns: [
                    {data: 'transaction_id'},
                    {data: 'order_number'},
                    {data: 'customer', orderable: false},
                    {data: 'created_at'},
                    {data: 'amount'},
                    {data: 'method'},
                    {data: 'status_badge', orderable: false},
                    {data: 'action', orderable: false}
                ]
            });

            // ✅ FILTER FIXED
            $(document).on('click', '.filterBtn', function () {

                $('.filterBtn').removeClass('active');
                $(this).addClass('active');

                paymentTable.ajax.reload();
            });

            // UPDATE STATUS
            $(document).on('click', '.updatePaymentStatus', function () {
                $.post("{{ route('update-payment-status') }}", {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id'),
                    status: $(this).data('status')
                }, function (res) {
                    toastr.success(res.message);
                    paymentTable.ajax.reload();
                });
            });

            // DELETE
            $(document).on('click', '.deletePayment', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Delete payment?",
                    icon: "warning",
                    showCancelButton: true
                }).then((r) => {
                    if (r.isConfirmed) {

                        $.post("{{ route('delete-payment') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function (res) {
                            toastr.success(res.message);
                            paymentTable.ajax.reload();
                        });

                    }
                });
            });

            // VIEW PAYMENT
            $(document).on('click', '.viewPayment', function () {
                $.post("{{ route('payment-details') }}", {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                }, function (res) {
                    let p = res.data;
                    let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <tr>
                                    <th>Transaction</th>
                                    <td>${p.payment_id ?? '-'}</td>
                                </tr>

                                <tr>
                                    <th>Order ID</th>
                                    <td>${p.order_id}</td>
                                </tr>

                                <tr>
                                    <th>Amount</th>
                                    <td>$${parseFloat(p.amount).toFixed(2)}</td>
                                </tr>

                                <tr>
                                    <th>Method</th>
                                    <td>${p.method}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>${p.status}</td>
                                </tr>

                            </table>
                        </div>
                    `;

                    $('#paymentModalContent').html(html);
                    $('#paymentModal').modal('show');
                });
            });

        });
    </script>
@endsection
