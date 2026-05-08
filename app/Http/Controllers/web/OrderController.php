<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ResponseTrait;

    /**
     * Display user's all orders
     */
    public function myOrders()
    {
        try {
            $orders = Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('web.order.index', compact('orders'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display order details
     */
    public function orderDetails($orderId)
    {
        try {
            $order = Order::with(['items', 'payment'])
                ->where('user_id', Auth::id())
                ->findOrFail($orderId);

            // Order timeline
            $timeline = $this->getOrderTimeline($order);

            return view('web.order.details', compact('order', 'timeline'));

        } catch (\Exception $exception) {
            return redirect()->route('my-orders')->with('error', 'Order not found!');
        }
    }

    /**
     * Track order by order number
     */
    public function trackOrder($orderNumber)
    {
        try {
            $order = Order::with(['items'])
                ->where('order_number', $orderNumber)
                ->firstOrFail();

            // Get order progress percentage
            $progress = $this->getOrderProgress($order);

            // Get timeline
            $timeline = $this->getOrderTimeline($order);

            return view('web.order.track', compact('order', 'progress', 'timeline'));

        } catch (\Exception $exception) {
            return redirect()->route('my-orders')->with('error', 'Order not found!');
        }
    }

    /**
     * Cancel order
     */
    public function cancelOrder($orderId)
    {
        try {
            $order = Order::where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'confirmed'])
                ->findOrFail($orderId);

            $order->status = 'cancelled';
            $order->save();

            return $this->sendResponse('Order cancelled successfully!', ['order_id' => $orderId]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * Get order progress percentage
     */
    private function getOrderProgress($order)
    {
        $statuses = [
            'pending' => 10,
            'confirmed' => 25,
            'processing' => 50,
            'shipped' => 75,
            'delivered' => 100,
            'cancelled' => 0
        ];

        return $statuses[$order->status] ?? 0;
    }

    /**
     * Get order timeline
     */
    private function getOrderTimeline($order)
    {
        $timeline = [];

        // Order placed
        $timeline[] = [
            'status' => 'Order Placed',
            'description' => 'Your order has been placed successfully',
            'date' => $order->created_at,
            'icon' => 'fa-shopping-bag',
            'completed' => true,
            'color' => 'success'
        ];

        // Order confirmed
        $timeline[] = [
            'status' => 'Order Confirmed',
            'description' => 'Your order has been confirmed and is being processed',
            'date' => $order->status != 'pending' ? $order->updated_at : null,
            'icon' => 'fa-check-circle',
            'completed' => in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']),
            'color' => 'primary'
        ];

        // Processing
        $timeline[] = [
            'status' => 'Processing',
            'description' => 'Your order is being prepared for shipment',
            'date' => in_array($order->status, ['processing', 'shipped', 'delivered']) ? $order->updated_at : null,
            'icon' => 'fa-cog',
            'completed' => in_array($order->status, ['processing', 'shipped', 'delivered']),
            'color' => 'info'
        ];

        // Shipped
        $timeline[] = [
            'status' => 'Shipped',
            'description' => 'Your order has been shipped and is on its way',
            'date' => in_array($order->status, ['shipped', 'delivered']) ? $order->updated_at : null,
            'icon' => 'fa-truck',
            'completed' => in_array($order->status, ['shipped', 'delivered']),
            'color' => 'warning'
        ];

        // Delivered
        $timeline[] = [
            'status' => 'Delivered',
            'description' => 'Your order has been delivered successfully',
            'date' => $order->status == 'delivered' ? $order->updated_at : null,
            'icon' => 'fa-box-open',
            'completed' => $order->status == 'delivered',
            'color' => 'success'
        ];

        return $timeline;
    }
}
