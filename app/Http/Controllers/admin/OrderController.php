<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.order.index');
    }

    // display orders
    public function getOrders(Request $request)
    {
        try {

            $orders = Order::with('items');

            if ($request->status && $request->status != 'all') {
                $orders->where('status', $request->status);
            }

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_code', function ($row) {
                    return 'ORD-' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
                })
                ->addColumn('customer', function ($row) {
                    return "
                        <div>
                            <strong>{$row->name}</strong><br>
                            <small>{$row->email}</small>
                        </div>
                    ";
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->addColumn('items_count', function ($row) {
                    return $row->items->count() . ' Items';
                })
                ->editColumn('total', function ($row) {
                    return '$' . number_format($row->total, 2);
                })
                ->addColumn('status_badge', function ($row) {
                    $class = match ($row->status) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    };
                    return "<span class='badge bg-{$class}'>" . ucfirst($row->status) . "</span>";
                })
                ->addColumn('action', function ($row) {
                    return "
                    <div class='dropdown'>
                        <button class='btn btn-sm btn-outline-primary dropdown-toggle' type='button' data-bs-toggle='dropdown'>Action</button>
                        <ul class='dropdown-menu'>
                            <li>
                                <button class='dropdown-item viewOrder' data-id='{$row->id}'>View Details</button>
                            </li>
                            <li><hr class='dropdown-divider'></li>
                            <li>
                                <a class='dropdown-item updateStatus' data-id='{$row->id}' data-status='pending'>Pending</a>
                                <a class='dropdown-item updateStatus' data-id='{$row->id}' data-status='processing'>Processing</a>
                                <a class='dropdown-item updateStatus' data-id='{$row->id}' data-status='shipped'>Shipped</a>
                                <a class='dropdown-item updateStatus' data-id='{$row->id}' data-status='delivered'>Delivered</a>
                                <a class='dropdown-item text-danger updateStatus' data-id='{$row->id}' data-status='cancelled'>Cancelled</a>
                            </li>
                            <li><hr class='dropdown-divider'></li>
                            <li>
                                <button class='dropdown-item text-danger deleteOrder' data-id='{$row->id}'>Delete</button>
                            </li>
                        </ul>
                    </div>
                ";
                })
                ->rawColumns(['customer', 'status_badge', 'action'])
                ->make(true);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function orderDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:orders,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $order = Order::with(['items.product'])->find($request->id);

            foreach ($order->items as $item) {
                $imagePath = public_path('upload/product/' . $item->product?->image);
                $item->image_url = (!empty($item->product?->image) && file_exists($imagePath)) ? asset('upload/product/' . $item->product->image) : asset('assets/images/web/placeholders/no-image.png');
            }

            return $this->sendResponse('Order details', $order);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // update order status
    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:orders,id',
                'status' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            $order = Order::find($request->id);
            if (!$order) {
                return $this->sendError('Order not found.');
            }
            $order->status = $request->status;
            if ($request->status == 'delivered') {
                $order->payment_status = 'paid';
            }
            $order->save();
            return $this->sendSuccess('Order status updated successfully.');

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    // delete order
    public function deleteOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:orders,id',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }
            $deleted = Order::where('id', $request->id)->delete();
            if ($deleted) {
                return $this->sendSuccess('Order deleted successfully.');
            } else {
                return $this->sendError('Order not deleted.');
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }
}
