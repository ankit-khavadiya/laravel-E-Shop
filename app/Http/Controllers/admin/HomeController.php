<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        session(['profile_image' => $adminDetails->profile_image]);
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

            $admin = Admin::find($request->get('id'));
            $admin->fill($request->only(['name', 'email', 'phone', 'address', 'country']))->save();
            session(['name' => $admin->name]);
            return $this->sendResponse('Profile Updated Successfully',$admin->name);

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function adminProfileImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'    => 'required|exists:admins,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $admin = Admin::find($request->id);

            if ($request->hasFile('image')) {
                if ($admin->profile_image) {
                    $oldPath = public_path('upload/' . $admin->profile_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image = $request->file('image');
                $imageName = fileName($image->getClientOriginalExtension());
                $image->move(public_path('upload'), $imageName);
                $admin->profile_image = $imageName;
            }

            $admin->save();
            session(['profile_image' => $admin->profile_image]);
            return $this->sendResponse('Profile image updated successfully.',$admin->profile_image);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }


    public function adminChangePassword(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'currentPassword' => 'required',
                'newPassword' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $admin = Auth::guard('admin')->user();

            if (!Hash::check($request->get('currentPassword'), $admin->password)) {
                return $this->sendError('Current password does not match.');
            }

            if(strcmp($request->get('currentPassword'), $request->get('newPassword')) == 0){
                return $this->sendError('New Password cannot be same as your current password.');
            }

            $admin = Admin::find($admin->id);
            $admin->password = Hash::make($request->get('newPassword'));
            $admin->save();

            return $this->sendSuccess('Password Changed Successfully');

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }
}
