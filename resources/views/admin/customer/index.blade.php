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
                            <table class="table table-hover">
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
@session('js')

@endsession
