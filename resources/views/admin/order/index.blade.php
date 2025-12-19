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
                            <button class="btn btn-outline-primary active">All</button>
                            <button class="btn btn-outline-primary">Pending</button>
                            <button class="btn btn-outline-primary">Shipped</button>
                            <button class="btn btn-outline-primary">Delivered</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
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
                                <tbody id="orderTableBody">
                                <!-- Orders will be loaded here via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
