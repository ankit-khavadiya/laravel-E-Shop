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
                            <button class="btn btn-outline-primary active">All</button>
                            <button class="btn btn-outline-primary">Successful</button>
                            <button class="btn btn-outline-primary">Failed</button>
                            <button class="btn btn-outline-primary">Pending</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
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
@session('js')

@endsession
