<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(){
        return view('admin.customer.index');
    }
}
