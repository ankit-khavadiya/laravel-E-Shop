<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(){
        return view('admin.payment.index');
    }
}
