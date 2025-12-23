<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use ResponseTrait;
    public function index(){
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    // display category
    public function getCategory(Request $request)
    {
        try {
            $categories = Category::with('parent')
                ->select('id', 'parent_id', 'name', 'description', 'is_active', 'created_at');

            if ($request->category_type === 'parent') {
                $categories->where('parent_id', 0);
            }
            if ($request->category_type === 'child') {
                $categories->where('parent_id', '!=', 0);
            }

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('category_code', function ($row) {
                    return 'CAT-' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
                })
                ->addColumn('parent_category', function ($row) {
                    return $row->parent ? $row->parent->name : '—';
                })
                ->addColumn('status', function ($row) {
                    $class = $row->is_active == 1 ? 'success' : 'danger';
                    $text  = $row->is_active == 1 ? 'Active' : 'Inactive';

                    return "<span class='badge bg-$class'>$text</span>";
                })
                ->addColumn('action', function ($row) {
                    return "
                    <button class='btn btn-sm btn-outline-primary editCategory' data-bs-toggle='modal' data-bs-target='#addCategoryModal' data-id='{$row->id}'>
                        <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-sm btn-outline-danger deleteCategory' data-id='{$row->id}'>
                        <i class='fas fa-trash'></i>
                    </button>";
                })
                ->rawColumns(['status', 'action'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    // add category
    public function addCategory(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'=>'required|unique:categories,name',
                'description'=>'required',
                'is_active'=>'required'
            ]);
            if($validator->fails()){
                return $this->sendValidationError( $validator->errors());
            }
            if($request->parent_id){
                $params = $request->only(['name','description','parent_id','is_active']);
                $category = new Category();
                $category->fill($params)->save();

                return $this->sendSuccess( 'Child Category added successfully.');
            }else{
                $params = $request->only(['name','description','is_active']);
                $category = new Category();
                $category->fill($params)->save();

                return $this->sendResponse( 'Category added successfully.',$category);
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    // edit category display in form
    public function editCategory(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'update_id' => 'required|exists:categories,id',
            ]);
            if($validator->fails()){
                return $this->sendValidationError( $validator->errors());
            }

            $category = Category::where('id',$request->update_id)->first();

            if ($category) {
                return $this->sendResponse('Category List successfully.',$category);
            }else{
                return $this->sendError('Category List not found.');
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    // edit category
    public function postEditCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:categories,id',
                'name' => 'required|unique:categories,name,' . $request->id,
                'description' => 'required',
                'is_active' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $category = Category::find($request->id);
            if (!$category) {
                return $this->sendError('Category not found');
            }

            if ($request->parent_id) {
                $params = $request->only(['name', 'description', 'parent_id', 'is_active']);
            } else {
                $params = $request->only(['name', 'description', 'is_active']);
            }

            $category->update($params);
            return $this->sendResponse('Category updated successfully.', $category);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    //delete category
    public function deleteCategory(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:categories,id',
            ]);
            if($validator->fails()){
                return $this->sendValidationError( $validator->errors());
            }

            $hasChildren = Category::where('parent_id', $request->id)->exists();
            if ($hasChildren) {
                return $this->sendError('This category has sub-categories and cannot be deleted.');
            }

            $deleted = Category::where('id', $request->id)->delete();
            if ($deleted) {
                return $this->sendSuccess('Category deleted successfully.');
            }else{
                return $this->sendError('Category not deleted successfully.');
            }
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

}
