@extends('admin.master')
@section('title','Category')
@section('page-content')
    <!-- Categories Page -->
    <section id="categories" class="page">
        <div class="page-header">
            <h2>Categories</h2>
            <p class="text-muted">Manage product categories and subcategories.</p>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Category List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="categoryTableBody">
                                <!-- Categories will be loaded here via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New Category</h5>
                    </div>
                    <div class="card-body">
                        <form id="addCategoryForm">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="categoryStatus" class="form-label">Status</label>
                                <select class="form-select" id="categoryStatus">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@session('js')

@endsession
