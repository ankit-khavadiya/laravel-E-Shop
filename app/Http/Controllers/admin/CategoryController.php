<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ResponseTrait;
    public function index(){
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    public function addCategory(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'=>'required|unique:categories,name',
                'description'=>'required',
                'is_active'=>'required'
            ]);
            if($validator->fails()){
                return $this->sendError( $validator->errors());
            }
            if($request->parent_id){
                $params = $request->only(['name','description','parent_id','is_active']);
                $category = new Category();
                $category->fill($params)->save();

                return $this->sendSuccess( 'Add Child Category added successfully.');
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
}
