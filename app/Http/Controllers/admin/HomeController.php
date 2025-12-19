<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use ResponseTrait;
    public function index(){
        return view('admin.home.index');
    }

    public function adminProfile()
    {
        $adminDetails = Auth::guard('admin')->user();
        return view('admin.pages.admin-profile', compact('adminDetails'));
    }


        public function adminProfileEdit(Request $request){
            try{
                $validator = Validator::make($request->all(),[
                    'id' => 'required|exists:admins,id',
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'phone' => 'nullable|numeric',
                    'address' => 'nullable|string',
                    'country' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    return $this->sendValidationError($validator->errors());
                }

                $admin = Admin::find($request->id);
                $admin->fill($request->only(['name', 'email', 'phone', 'address', 'country']))->save();
                session(['name' => $admin->name]);

                return $this->sendResponse('Profile Updated Successfully',$admin->name);

            }catch (\Exception $exception){
                return $this->sendError($exception->getMessage());
            }
        }
}
