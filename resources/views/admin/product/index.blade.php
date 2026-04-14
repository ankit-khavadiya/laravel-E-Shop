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
                    <button class="btn btn-primary" id="addProductBtn" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-1"></i> Add Product
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
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
                    <h5 id="addProductTitle" class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id" id="product-id">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <label class="text-danger field-error" id="name-error"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value='' disabled selected>-- Please select category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <label class="text-danger field-error" id="category_name-error"></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                            <label class="text-danger field-error" id="description-error"></label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" id="short_description" rows="2"></textarea>
                            <label class="text-danger field-error" id="short_description-error"></label>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price *</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" >
                                <label class="text-danger field-error" id="price-error"></label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="number" class="form-control" name="discount_price" id="discount_price" step="0.01">
                                <label class="text-danger field-error" id="discount_price-error"></label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="0">
                                <label class="text-danger field-error" id="quantity-error"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="is_active" id="is_active">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <label class="text-danger field-error" id="is_active-error"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Featured *</label>
                                <select class="form-select" name="is_featured" id="is_featured">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <label class="text-danger field-error" id="is_featured-error"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Image</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                <label class="text-danger field-error" id="image-error"></label>
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" class="form-control" name="gallery_images[]" id="gallery_images" accept="image/*" multiple>
                                <label class="text-danger field-error" id="gallery_images-error"></label>
                                <div id="galleryPreview" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dimensions</label>
                            <input type="text" class="form-control" name="dimensions" id="dimensions" placeholder="L x W x H">
                            <label class="text-danger field-error" id="dimensions-error"></label>
                        </div>
                        <hr>

                        <h6 class="mb-3">SEO Details</h6>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title">
                            <label class="text-danger field-error" id="meta_title-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" rows="2"></textarea>
                            <label class="text-danger field-error" id="meta_description-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="comma,separated,keywords">
                            <label class="text-danger field-error" id="meta_keywords-error"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary" id="saveProductBtn">Save Product</button>
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
                    category_id:{ required:true },
                    description:{ required:true },
                    price:{ required:true },
                    quantity:{ required:true },
                    image: {
                        required: {
                            depends: function () {
                                return $('#product-id').val() === '';
                            }
                        }
                    }
                },
                messages:{
                    name:{
                        required:"please enter product name"
                    },
                    category_id:{
                        required:"Please select category"
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
                errorClass: "error text-danger",
                errorElement: "span",
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
                            $('.field-error,span').text('').hide();
                            $('.error').removeClass('error text-danger');
                            $('#saveProductBtn').attr('disabled', true);
                        },
                        success: function (res) {
                            toastr.success(res.message);
                            $('#addProductModal').modal('hide');
                            form.reset();
                            productTable.ajax.reload();
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            if (res?.error) {
                                if (res.error.id) {
                                    toastr.error(res.error.id[0]);
                                }if (res.error.name) {
                                    $('#name-error').html(res.error.name[0]).show();
                                }if (res.error.category_id) {
                                    $('#category_name-error').html(res.error.category_id[0]).show();
                                }if (res.error.description) {
                                    $('#description-error').html(res.error.phone[0]).show();
                                }if (res.error.short_description) {
                                    $('#short_description').html(res.error.short_description[0]).show();
                                }if (res.error.price) {
                                    $('#price-error').html(res.error.price[0]).show();
                                }if (res.error.discount_price) {
                                    $('#discount_price-error').html(res.error.discount_price[0]).show();
                                }if (res.error.quantity) {
                                    $('#quantity-error').html(res.error.quantity[0]).show();
                                }if (res.error.is_active) {
                                    $('#is_active-error').html(res.error.is_active[0]).show();
                                }if (res.error.is_featured) {
                                    $('#is_featured-error').html(res.error.is_featured[0]).show();
                                }if (res.error.image) {
                                    $('#image-error').html(res.error.image[0]).show();
                                }if (res.error['gallery_image.0']) {
                                    $('#gallery_images-error').html(res.error['gallery_image.0']).show();
                                }if (res.error.dimensions) {
                                    $('#dimensions-error').html(res.error.dimensions[0]).show();
                                }if (res.error.meta_title) {
                                    $('#meta_title-error').html(res.error.meta_title[0]).show();
                                }if (res.error.meta_description) {
                                    $('#meta_description-error').html(res.error.meta_description[0]).show();
                                }if (res.error.meta_keywords) {
                                    $('#meta_keywords-error').html(res.error.meta_keywords[0]).show();
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
            let productTable = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get-product') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    { data: 'product_code', orderable:false, searchable:true },
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'category.name', orderable: false, searchable: true },
                    {data: 'price',
                        render: function (data) {
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },
                    { data: 'quantity',orderable: false, searchable: false },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#addProductBtn').on('click', function () {
                $('#addProductForm')[0].reset();
                $('#product-id').val('');
                $('.field-error').text('').hide();
                $('.error').removeClass('error text-danger');
                $('#imagePreview,#galleryPreview').html('');
                $('#addProductTitle').text('Add Product');
                $('#saveProductBtn').text('Save Product');
            });

            // fill-up update form
            $(document).on('click','.editProduct',function (){
                var update_id = $(this).data('id');
                $.ajax({
                    url:"{{route('edit-product')}}",
                    method:'POST',
                    dataType:'JSON',
                    data:{_token: "{{ csrf_token() }}", id:update_id},
                    beforeSend:function (){
                        $('.field-error').text('').hide();
                        $('.error').removeClass('error text-danger');
                        $('#addProductForm')[0].reset();
                    },
                    success:function (response){
                        if (response.data) {
                            let p = response.data;
                            $('#product-id').val(p.id);
                            $('#name').val(p.name);
                            $('#description').val(p.description);
                            $('#short_description').val(p.short_description);
                            $('#category_id').val(p.category_id).change();
                            $('#is_active').val(p.is_active).change();
                            $('#is_featured').val(p.is_featured).change();
                            $('#price').val(p.price);
                            $('#discount_price').val(p.discount_price);
                            $('#quantity').val(p.quantity);
                            $('#dimensions').val(p.dimensions);
                            $('#meta_title').val(p.meta_title);
                            $('#meta_description').val(p.meta_description);
                            $('#meta_keywords').val(p.meta_keywords);
                            $('#addProductTitle').text('Edit Product');
                            $('#saveProductBtn').text('Update Product');
                            if (p.image) {
                                $('#imagePreview').html(
                                    `<img src="/upload/product/${p.image}" width="80" class="rounded">`
                                );
                            }
                            if (p.gallery_images) {
                                let imgs = p.gallery_images.split(',');
                                let html = '';
                                imgs.forEach(img => {
                                    html += `<img src="/upload/product-gallery/${img}" width="60" class="me-1 rounded">`;
                                });
                                $('#galleryPreview').html(html);
                            }
                        }
                    },
                    error: function (xhr) {
                        var errorresponse = JSON.parse(xhr.responseText)
                        toastr.error(errorresponse.message);
                    }
                })
            });

            // delete category
            $(document).on('click','.deleteProduct',function (){
                var delete_id = $(this).data('id');
                $.ajax({
                    url:"{{route('delete-product')}}",
                    method:'POST',
                    dataType:'JSON',
                    data:{_token: "{{ csrf_token() }}", id:delete_id},
                    success:function (response){
                        toastr.success(response.message);
                        productTable.ajax.reload();
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
