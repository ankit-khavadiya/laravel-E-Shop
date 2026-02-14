<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthenticateController extends Controller
{
    use ResponseTrait;
    public function login()
    {
        return view('admin.pages.login');
    }

    public function postLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|exists:admins,email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $login = Auth::guard('admin')->attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);

            if ($login) {
                $name = Admin::where('email', $request->email)->first();
                $name->update(['last_login_at' => now()]);
                session(['name' => $name->name]);
                session(['profile_image' => $name->profile_image]);
                return $this->sendSuccess('Login successfully');
            }else{
                return $this->sendError('Invalid email or password');
            }
        }catch (\Exception $exception){
           return $this->sendError($exception->getMessage());
        }
    }
}
