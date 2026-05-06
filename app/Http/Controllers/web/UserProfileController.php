<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    use ResponseTrait;

    public function index(){
        return view('web.pages.user-profile');
    }

    public function getStats(){

    }

    public function getRecentOrders(){

    }

    public function getAllOrders()
    {

    }

    // Update user profile image
    public function userProfileImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'    => 'required|exists:users,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $user = User::find($request->id);

            if ($request->hasFile('image')) {
                if ($user->profile_image) {
                    $oldPath = public_path('upload/web/' . $user->profile_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image = $request->file('image');
                $imageName = fileName($image->getClientOriginalExtension());
                $image->move(public_path('upload/web'), $imageName);
                $user->profile_image = $imageName;
            }

            $user->save();

            return $this->sendResponse('Profile image updated successfully.',$user->profile_image);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    public function updateProfile(request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'id'    => 'required|exists:users,id',
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,'.$request->id,
                'phone' => 'nullable|numeric',
                'address' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'country' => 'nullable',
                'zip_code' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $user = User::find($request->id);
            $user->fill($request->only('name','email','phone','address','city','state','country','zip_code'))->save();

            return $this->sendResponse('Profile updated successfully.',$user);

        }catch (\Exception $exception){
            return $this->sendException($exception->getMessage());
        }
    }

    // Change password
    public function changePassword(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'currentPassword' => 'required',
                'newPassword' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $user = Auth::guard('web')->user();

            if (!Hash::check($request->get('currentPassword'), $user->password)) {
                return $this->sendError('Current password does not match.');
            }

            if(strcmp($request->get('currentPassword'), $request->get('newPassword')) == 0){
                return $this->sendError('New Password cannot be same as your current password.');
            }

            $user = User::find($user->id);
            $user->password = Hash::make($request->get('newPassword'));
            $user->save();

            return $this->sendSuccess('Password Changed Successfully');

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function deleteAccount()
    {
        try {
            $user = Auth::guard('web')->user();

            if (!$user) {
                return $this->sendException('User not authenticated.');
            }

            Auth::logout(); // logout before deleting (safer)

            $user->delete();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return $this->sendSuccess('User deleted successfully.');
        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }
}
