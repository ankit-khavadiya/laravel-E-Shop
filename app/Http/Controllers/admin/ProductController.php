<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
        return view('admin.product.index');
    }
}
