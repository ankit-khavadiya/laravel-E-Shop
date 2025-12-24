@extends('admin.master')
@section('title','Product')
@section('page-content')
<!-- Products Page -->
<section id="products" class="page">
    <div class="page-header">
        <h2>Products</h2>
        <p class="text-muted">Manage your product inventory and listings.</p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Product List</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-1"></i> Add Product
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="productTableBody">
                            <!-- Products will be loaded here via JavaScript -->
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
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id" id="product-id">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="name" required>
                                <label class="text-danger error" id="categoryName-error"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category_id" required>
                                    <option value='' disabled selected>-- Please select category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                            <label class="text-danger error" id="description-error"></label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" id="short_description" rows="2"></textarea>
                            <label class="text-danger error" id="short_description-error"></label>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price *</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                                <label class="text-danger error" id="price-error"></label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="number" class="form-control" name="discount_price" id="discount_price" step="0.01">
                                <label class="text-danger error" id="discount_price-error"></label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="0" required>
                                <label class="text-danger error" id="quantity-error"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="is_active" id="is_active">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <label class="text-danger error" id="is_active-error"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Featured *</label>
                                <select class="form-select" name="is_featured" id="is_featured">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <label class="text-danger error" id="is_featured-error"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Image</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                <label class="text-danger error" id="image-error"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" class="form-control" name="gallery_images[]" id="gallery_images" accept="image/*" multiple>
                                <label class="text-danger error" id="gallery_images-error"></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dimensions</label>
                            <input type="text" class="form-control" name="dimensions" id="dimensions" placeholder="L x W x H">
                            <label class="text-danger error" id="dimensions-error"></label>

                        </div>
                        <hr>

                        <h6 class="mb-3">SEO Details</h6>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title">
                            <label class="text-danger error" id="meta_title-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" rows="2"></textarea>
                            <label class="text-danger error" id="meta_description-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="comma,separated,keywords">
                            <label class="text-danger error" id="meta_keywords-error"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function (){
            // Add category form
            $('#addProductForm').validate({
                rules:{
                    name:{ required:true },
                    description:{ required:true },
                    price:{ required:true },
                    quantity:{ required:true },
                    image:{ required:true },
                },
                messages:{
                    name:{
                        required:"please enter product name"
                    },
                    description:{
                        required:"please enter product description"
                    },
                    price:{
                        required:"please enter product price"
                    },
                    quantity:{
                        required:"please enter product quantity"
                    },
                    image:{
                        required:"please enter product image"
                    }
                },
                errorClass : "error text-danger",
                submitHandler:function (form) {
                    let formData = new FormData(form);
                    let id = $('#product-id').val();
                    let url = id ? "{{ route('post-edit-product') }}" : "{{ route('add-product') }}";
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend:function (){
                            $('#saveProductBtn').attr('disabled', true);
                        },
                        success: function (res) {
                            toastr.success(res.message);
                            $('#addProductModal').modal('hide');
                            form.reset();
                            // categoryTable.ajax.reload();
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            if (res?.error) {
                                if (res.error.id) {
                                    toastr.error(res.error.id[0]);
                                }
                                if (res.error.name) {
                                    $('#categoryName-error').html(res.error.name[0]).show();
                                }
                                if (res.error.description) {
                                    $('#categoryDescription-error').html(res.error.phone[0]).show();
                                }
                            } else if (res?.message) {
                                toastr.error(res.message);
                            }
                        },
                        complete:function (){
                            $('#saveProductBtn').attr('disabled', false);
                        }
                    });
                }
            });

            // display category
            let categoryTable = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get-category') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.category_type = $('#categoryTypeFilter').val(); // 🔥 FILTER
                    }
                },
                columns: [
                    { data: 'category_code', orderable:false, searchable:true },
                    { data: 'name' },
                    { data: 'parent_category', orderable:true ,searchable: false },
                    { data: 'description', orderable: false, searchable: false },
                    { data: 'status', orderable:false, searchable:false },
                    { data: 'action', orderable:false, searchable:false }
                ]
            });

            $('#categoryTypeFilter').on('change', function () {
                categoryTable.ajax.reload();
            });

            $('#addCategoryBtn').on('click', function () {
                $('#addCategoryForm')[0].reset();
                $('#category-id').val('');
                $('#categoryModalTitle').text('Add Product');
                $('#saveCategoryBtn').text('Save Product');
            });

            // fill-up update form
            $(document).on('click','.editCategory',function (){
                var update_id = $(this).data('id');
                $.ajax({
                    url:"{{route('edit-category')}}",
                    method:'POST',
                    dataType:'JSON',
                    data:{_token: "{{ csrf_token() }}", update_id:update_id},
                    beforeSend:function (){
                        $('#category-name-error, #category-description-error').hide();
                        $('#categoryName-error, #categoryDescription-error').hide();
                        $('#category-name, #category-description').removeClass('text-danger');
                    },
                    success:function (response){
                        if(response.data){
                            var item = response.data;
                            $('#category-id').val(item.id);
                            $('#category-name').val(item.name);
                            $('#category-description').val(item.description);
                            if(item.parent_id){
                                $('#parentCategorySelect').val(item.parent_id);
                            }else {
                                $('#parentCategorySelect').val('');
                            }
                            $('#category-status').val(item.is_active);
                            $('#categoryModalTitle').text('Edit Category');
                            $('#saveCategoryBtn').text('Update Category');
                        }
                    },
                    error: function (xhr) {
                        var errorresponse = JSON.parse(xhr.responseText)
                        toastr.error(errorresponse.message);
                    }
                })
            });

            // delete category
            $(document).on('click','.deleteCategory',function (){
                var delete_id = $(this).data('id');
                $.ajax({
                    url:"{{route('delete-category')}}",
                    method:'POST',
                    dataType:'JSON',
                    data:{_token: "{{ csrf_token() }}", id:delete_id},
                    success:function (response){
                        toastr.success(response.message);
                        categoryTable.ajax.reload();
                    },
                    error: function (xhr) {
                        var errorresponse = JSON.parse(xhr.responseText)
                        toastr.error(errorresponse.message);
                    }
                })
            });
        });
    </script>
@endsection
