<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserProfileController extends Controller
{
    use ResponseTrait;

    public function index(){
        return view('web.pages.user-profile');
    }

    /**
     * Dashboard Stats
     */
    public function getStats()
    {
        try {
            $user = Auth::user();
            $totalOrders = Order::where('user_id', $user->id)->count();
            $totalSpent = Order::where('user_id', $user->id)
                ->where('payment_status', '!=', 'cancelled')
                ->sum('total');
            $wishlistCount = Wishlist::where('user_id', $user->id)->count();
            return response()->json(['total_orders'  => $totalOrders, 'total_spent'   => number_format($totalSpent, 2), 'wishlist_count'=> $wishlistCount,]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * Recent Orders
     */
    public function getRecentOrders()
    {
        try {
            $orders = Order::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'id'            => $order->id,
                        'order_number'  => $order->order_number,
                        'date'          => $order->created_at->format('d M Y'),
                        'total_amount'  => number_format($order->total, 2),
                        'order_status'  => ucfirst($order->status),
                    ];
                });

            return response()->json(['orders' => $orders]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * All Orders - Yajra Datatable
     */
    public function getAllOrders()
    {
        try {
            $orders = Order::withCount('items')->where('user_id', Auth::id())->latest();

            return DataTables::of($orders)
                ->addIndexColumn()
                ->editColumn('order_number', function ($row) {
                    return '#' . $row->order_number;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->addColumn('items', function ($row) {
                    return $row->items_count;
                })
                ->editColumn('total', function ($row) {
                    return '$' . number_format($row->total, 2);
                })
                ->addColumn('status', function ($row) {
                    $class = match($row->status) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };

                    return "<span class='badge bg-{$class}'>" . ucfirst($row->status) . "</span>";
                })

                ->addColumn('action', function ($row) {
                    return "
                        <a href='".route('order-details', $row->id)."' class='btn btn-sm btn-outline-primary'>
                            <i class='fas fa-eye'></i> View
                        </a>
                    ";
                })
                ->rawColumns(['status', 'action'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
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
