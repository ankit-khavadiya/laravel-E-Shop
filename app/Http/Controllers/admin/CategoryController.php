<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.category.index');
    }
}
