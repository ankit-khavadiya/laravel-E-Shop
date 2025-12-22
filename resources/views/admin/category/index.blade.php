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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="categoryTableBody">
                                <!-- Loaded via AJAX -->
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
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name *</label>
                            <input type="text" class="form-control" name="name">
                            <label class="text-danger error" id="categoryName-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" rows="3"></textarea>
                            <label class="text-danger error" id="categoryDescription-error"></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select class="form-select" id="parentCategorySelect" name="parent_id">
                                <option value='' disabled selected>-- Please select a category --</option>
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
                            <select class="form-select" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="2">In active</option>
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
                submitHandler:function (form,e) {
                    e.preventDefault();
                    let formData = new FormData(form);
                    $.ajax({
                        url: "{{ route('add-category') }}",
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
                            if (!res.data.parent_id) {
                                $('#parentCategorySelect').append(
                                    `<option value="${res.data.id}"> ${res.data.name} </option>`
                                );
                            }
                            // loadCategories();
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            if (res?.error) {
                                if (res.error.name) {
                                    $('#categoryName-error').text(res.error.name[0]);
                                }
                                if (res.error.description) {
                                    $('#categoryDescription-error').text(res.error.description[0]);
                                }
                                if (res.error.is_active) {
                                    $('#categoryStatus-error').text(res.error.is_active[0]);
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
        });
    </script>
@endsection
