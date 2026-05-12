<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use ResponseTrait;

    //
    // Return admin home page blade(Dashboard)
    public function index()
    {
        // COUNTS
        $totalSales = Payment::where('status', 'success')->sum('amount');

        $totalOrders = Order::count();

        $totalCustomers = User::count();

        $revenue = Order::where('status', 'delivered')->sum('total');

        // RECENT ORDERS
        $recentOrders = Order::latest()->take(5)->get();

        // TOP PRODUCTS
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'DESC')
            ->take(5)
            ->get();

        // SALES CHART
        $monthlySales = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'success')
            ->groupBy('month')
            ->pluck('total', 'month');

        $salesData = [];

        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = $monthlySales[$i] ?? 0;
        }

        return view('admin.home.index', compact('totalSales', 'totalOrders', 'totalCustomers', 'revenue', 'recentOrders', 'topProducts', 'salesData'));
    }

    // Return admin profile blade
    public function adminProfile()
    {
        $adminDetails = Auth::guard('admin')->user();
        session(['profile_image' => $adminDetails->profile_image]);
        return view('admin.pages.admin-profile', compact('adminDetails'));
    }

    // Update admin profile
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

    // Update admin profile image
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

    // Change admin password
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
