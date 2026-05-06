<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $products = Product::all();
        $categories = Category::all();
        return view('web.shop.index', compact('products', 'categories'));
    }

    public function filter(){

    }

    public function detail(request $request){
        $productId = base64_decode($request->slug);
        $product = Product::where('id', $productId)->with('category')->first();
        $relatedProducts = Product::where('category_id', $product->category->id)->with('category')->get();
        return view('web.product.index', compact('product', 'relatedProducts'));
    }


}
