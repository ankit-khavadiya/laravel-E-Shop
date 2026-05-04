<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
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

    // Update admin image
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

            $admin = User::find($request->id);

            if ($request->hasFile('image')) {
                if ($admin->profile_image) {
                    $oldPath = public_path('upload/web' . $admin->profile_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image = $request->file('image');
                $imageName = fileName($image->getClientOriginalExtension());
                $image->move(public_path('upload/web'), $imageName);
                $admin->profile_image = $imageName;
            }

            $admin->save();
            session(['profile_image' => $admin->profile_image]);
            return $this->sendResponse('Profile image updated successfully.',$admin->profile_image);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function updateProfile()
    {

    }

    public function changePassword()
    {

    }

    public function deleteAccount()
    {

    }
}
