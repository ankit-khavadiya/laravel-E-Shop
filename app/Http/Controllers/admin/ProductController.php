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
                ->addColumn('product_code', function ($row) {
                    return 'PRO-' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
                })
                ->editColumn('image', function ($row) {
                    $imageUrl = asset('upload/product/' . $row->image);
                    return "<img src='{$imageUrl}' class='rounded' width='40' height='40'>";

                })
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
                ->rawColumns(['action', 'status', 'image'])
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
                'short_description' => 'nullable|string',
                'price' => 'required|integer',
                'discount_price' => 'nullable|integer',
                'quantity' => 'required|integer',
                'is_active' => 'required|integer',
                'is_featured' => 'required|integer',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gallery_images.*' => 'nullable|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'dimensions' => 'nullable|string',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'meta_keyword' => 'nullable|string',
            ]);
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }

            $params = $request->only('category_id','name','description','short_description','price','discount_price','quantity','is_active','is_featured','dimensions','meta_title','meta_description','meta_keyword');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = fileName($image->getClientOriginalExtension());
                $image->move(public_path('upload/product'), $imageName);
                $params['image'] = $imageName;
            }

            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $galleryImage) {
                    $galleryName = fileName($galleryImage->getClientOriginalExtension());
                    $galleryImage->move(public_path('upload/product-gallery'), $galleryName);
                    $galleryImages[] = $galleryName;
                }
                $params['gallery_images'] = implode(',',$galleryImages);
            }

            $product = new Product();
            $insert = $product->fill($params)->save();

            if ($insert) {
                return $this->sendResponse('Product added successfully.',$product);
            }else{
                return $this->sendError('Failed to add product.');
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function editProduct(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'id' => 'required|integer',
            ]);

            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }

            $product = Product::with('category')->where(['id' => $request->id])->first();

            if ($product) {
                return $this->sendResponse('Product listed successfully.',$product);
            }else{
                return $this->sendError('Product listed not found.');
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function postEditProduct(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:products,id',
                'category_id' => 'required|integer',
                'name' => 'required|string|unique:products,name,'.$request->id,
                'description' => 'required|string',
                'short_description' => 'nullable|string',
                'price' => 'required',
                'discount_price' => 'nullable',
                'quantity' => 'required|integer',
                'is_active' => 'required|integer',
                'is_featured' => 'required|integer',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gallery_images.*' => 'nullable|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'dimensions' => 'nullable|string',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'meta_keyword' => 'nullable|string',
            ]);
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }


            $product = Product::with('category')->where(['id' => $request->id])->first();

            if (!$product) {
                return $this->sendError('Product not found.');
            }

            $params = $request->only('category_id','name','description','short_description','price','discount_price','quantity','is_active','is_featured','dimensions','meta_title','meta_description','meta_keyword');

            if ($request->hasFile('image')) {
                if ($product->image) {
                    $oldPath = public_path('upload/product/' . $product->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image = $request->file('image');
                $imageName = fileName($image->getClientOriginalExtension());
                $image->move(public_path('upload/product/'), $imageName);
                $params['image'] = $imageName;
            }

            if ($request->hasFile('gallery_images')) {
                if ($product->gallery_images) {
                    $images = explode(',', $product->gallery_images);
                    foreach ($images as $image) {
                        $imagePath = public_path('/upload/product-gallery/' . $image);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $galleryImage) {
                    $galleryName = fileName($galleryImage->getClientOriginalExtension());
                    $galleryImage->move(public_path('upload/product-gallery'), $galleryName);
                    $galleryImages[] = $galleryName;
                }
                $params['gallery_images'] = implode(',',$galleryImages);
            }

            $product->update($params);
            return $this->sendResponse('Product updated successfully.',$product);

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function deleteProduct(Request $request){
        try {
            $validator = Validator::make(request()->all(),[
                'id' => 'required|exists:products,id',
            ]);

            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }

            $product = Product::where(['id' => $request->id])->first();

            if ($product->image) {
                if ($product->image) {
                    $oldPath = public_path('upload/product/' . $product->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            if ($product->gallery_images) {
                $images = explode(',', $product->gallery_images);
                foreach ($images as $image) {
                    $imagePath = public_path('/upload/product-gallery/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }


            $deleted = Product::where(['id' => $request->id])->delete();

            if ($deleted) {
                return $this->sendSuccess('Product deleted successfully.');
            }else{
                return $this->sendError('Product not found.');
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }
}
