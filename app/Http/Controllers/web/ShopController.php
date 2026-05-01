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

    public function detail(){

    }


}
