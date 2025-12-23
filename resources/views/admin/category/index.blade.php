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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Category List</h5>
                        <button class="btn btn-primary" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <select id="categoryTypeFilter" class="form-select mb-3" style="width:200px">
                                <option value="">All Categories</option>
                                <option value="parent">Parent Categories</option>
                                <option value="child">Child Categories</option>
                            </select>
                            <table class="table table-hover" id="categoryTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('model')
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalTitle">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="category-id">
                            <label class="form-label">Category Name *</label>
                            <input type="text" class="form-control" name="name" id="category-name">
                            <label class="text-danger error" id="categoryName-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" rows="3" id="category-description"></textarea>
                            <label class="text-danger error" id="categoryDescription-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select class="form-select" id="parentCategorySelect" name="parent_id">
                                <option value='' disabled selected>-- Please select parent category --</option>
                                @foreach($categories as $category)
                                    @if(!$category->parent_id)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label class="text-danger error" id="categoryStatus-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-select" id="category-status" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <label class="text-danger error" id="categoryStatus-error"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary" id="saveCategoryBtn">
                            Save Category
                        </button>
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
            $('#addCategoryForm').validate({
                rules:{
                    name:{ required:true },
                    description:{ required:true },
                },
                messages:{
                    name:{
                        required:"please enter category name"
                    },
                    description:{
                        required:"please enter category description"
                    }
                },
                errorClass : "error text-danger",
                submitHandler:function (form) {
                    let formData = new FormData(form);
                    let id = $('#category-id').val();
                    let url = id ? "{{ route('post-edit-category') }}" : "{{ route('add-category') }}";
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend:function (){
                            $('#saveCategoryBtn').attr('disabled', true);
                        },
                        success: function (res) {
                            toastr.success(res.message);
                            $('#addCategoryModal').modal('hide');
                            form.reset();
                            console.log(res.data);
                            if (res.data && !res.data.parent_id) {
                                $('#parentCategorySelect').append(
                                    `<option value="${res.data.id}">${res.data.name}</option>`
                                );
                            }
                            categoryTable.ajax.reload();
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
                            $('#saveCategoryBtn').attr('disabled', false);
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
                $('#categoryModalTitle').text('Add Category');
                $('#saveCategoryBtn').text('Save Category');
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
