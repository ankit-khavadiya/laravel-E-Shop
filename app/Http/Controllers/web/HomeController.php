<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $featuredProducts = Product::where('is_featured', 1)->take(4)->get();
        return view('web.home.index', compact('featuredProducts'));
    }
}
