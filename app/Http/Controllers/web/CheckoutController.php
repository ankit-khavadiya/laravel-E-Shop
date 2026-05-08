<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use ResponseTrait;

    /**
     * Display checkout page
     */
    public function index()
    {
        try {
            $cartItems = $this->getCartItems();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty!');
            }

            $lastOrder = null;

            if (Auth::check()) {
                $lastOrder = Order::where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $subtotal += $price * $item->quantity;
            }

            $shipping = $subtotal > 50 ? 0 : 5.00;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $shipping + $tax;

            return view('web.checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total','lastOrder'));

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * Process order
     */
    public function processOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'zip_code' => 'required|string|max:20',
                'country' => 'required|string|max:100',
                'payment_method' => 'required|in:cod,stripe,paypal,bank_transfer',
                'note' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            // Get cart items
            $cartItems = $this->getCartItems();

            if ($cartItems->isEmpty()) {
                return $this->sendError('Your cart is empty!', [], 400);
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $subtotal += $price * $item->quantity;
            }

            $shipping = $subtotal > 50 ? 0 : 5.00;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $shipping + $tax;

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

            // Create order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'discount' => 0,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'note' => $request->note
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?? $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $price * $item->quantity
                ]);

                // Update product stock
                $product = Product::find($item->product_id);
                $product->quantity -= $item->quantity;
                $product->save();
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_id' => null,
                'method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
                'response' => null
            ]);

            // Clear cart
            $this->clearCart();

            DB::commit();

            return $this->sendResponse('Order placed successfully!', ['order_id' => $order->id, 'order_number' => $order->order_number, 'payment_method' => $request->payment_method]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * Order confirmation page
     */
    public function orderConfirmation($orderId)
    {
        try {
            $order = Order::with(['items', 'payment'])->findOrFail($orderId);

            // Verify order ownership
            if (Auth::check() && $order->user_id != Auth::id()) {
                abort(403);
            }

            return view('web.checkout.confirmation', compact('order'));

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /**
     * Get cart items
     */
    private function getCartItems()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = !$userId ? Session::getId() : null;

        $query = Cart::with('product');

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->get();
    }

    /**
     * Clear cart after order
     */
    private function clearCart()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = !$userId ? Session::getId() : null;

        Cart::when($userId, function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->when(!$userId, function($query) use ($sessionId) {
            $query->where('session_id', $sessionId);
        })->delete();
    }

}
