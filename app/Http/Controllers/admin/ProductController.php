<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ResponseTrait;
    public function index(){
        $categories = Category::all();
        return view('admin.product.index', compact('categories'));
    }

    public function getProducts(){
        try{
            $products = Product::with('category');

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $class = $row->is_active == 1 ? 'success' : 'danger';
                    $text  = $row->is_active == 1 ? 'Active' : 'Inactive';

                    return "<span class='badge bg-$class'>$text</span>";
                })
                ->addColumn('action', function ($row) {
                    return "
                    <button class='btn btn-sm btn-outline-primary editProduct' data-bs-toggle='modal' data-bs-target='#addProductModal' data-id='{$row->id}'>
                        <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-sm btn-outline-danger deleteProduct' data-id='{$row->id}'>
                        <i class='fas fa-trash'></i>
                    </button>";
                })
                ->rawColumns(['action', 'status'])
                ->make(true);

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }
    public function addProduct(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'category_id' => 'required|integer',
                'name' => 'required|string|unique:products',
                'description' => 'required|string',
                'short_description' => 'sometimes|string',
                'price' => 'required|integer',
                'discount_price' => 'sometimes|integer',
                'quantity' => 'required|integer',
                'is_active' => 'required|integer',
                'is_featured' => 'required|integer',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gallery_images.*' => 'required|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'dimensions' => 'sometimes|string',
                'meta_title' => 'sometimes|string',
                'meta_description' => 'sometimes|string',
                'meta_keyword' => 'sometimes|string',
            ]);
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }

            $params = $request->only('category_id','name','description','short_description','price','discount_price','quantity','is_active','is_featured','dimensions','meta_title','meta_description','meta_keyword');

            if($request->hasFile('image')){
                $image = $request->file('image');
                
            }


        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function editProduct(){

    }

    public function postEditProduct(){

    }

    public function deleteProduct(){

    }
}
