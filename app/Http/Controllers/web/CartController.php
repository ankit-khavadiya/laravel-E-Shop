<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use ResponseTrait;

    /*
    |--------------------------------------------------------------------------
    | CART PAGE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $cartItems = $this->getCartItems();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $shipping = $subtotal > 50 ? 0 : 5.00;
        $tax = $subtotal * 0.10;
        $total = $subtotal + $shipping + $tax;

        return view('web.cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */
    public function add(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $product = Product::findOrFail($request->product_id);

            if ($product->quantity < $request->quantity) {
                return $this->sendError('Not enough stock available!');
            }

            $userId = Auth::check() ? Auth::id() : null;
            $sessionId = !$userId ? Session::getId() : null;

            $cart = Cart::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->where('product_id', $request->product_id)->first();

            if ($cart) {

                $newQty = $cart->quantity + $request->quantity;

                if ($product->quantity < $newQty) {
                    return $this->sendError('Not enough stock available!');
                }

                $cart->update(['quantity' => $newQty]);

            } else {

                Cart::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }

            return $this->sendResponse('Product added to cart!', ['cart_count' => $this->getCartCount()]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:carts,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $cart = Cart::findOrFail($request->cart_id);

            if (!$this->verifyCartOwnership($cart)) {
                return $this->sendError('Unauthorized access!', 403);
            }

            $product = Product::findOrFail($cart->product_id);

            if ($product->quantity < $request->quantity) {
                return $this->sendError('Not enough stock available!');
            }

            $cart->update(['quantity' => $request->quantity]);

            $cartItems = $this->getCartItems();

            $subtotal = $cartItems->sum(function ($item) {
                $price = $item->product->discount_price ?? $item->product->price;
                return $price * $item->quantity;
            });

            $shipping = $subtotal > 50 ? 0 : 5.00;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $shipping + $tax;

            return $this->sendResponse('Cart updated successfully!', [
                'subtotal' => number_format($subtotal, 2),
                'shipping' => number_format($shipping, 2),
                'tax' => number_format($tax, 2),
                'total' => number_format($total, 2),
                'item_total' => number_format(($product->discount_price ?? $product->price) * $request->quantity, 2)
            ]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CART ITEM
    |--------------------------------------------------------------------------
    */
    public function delete(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:carts,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $cart = Cart::findOrFail($request->cart_id);

            if (!$this->verifyCartOwnership($cart)) {
                return $this->sendError('Unauthorized access!', 403);
            }

            $cart->delete();

            $cartItems = $this->getCartItems();

            $subtotal = $cartItems->sum(function ($item) {
                $price = $item->product->discount_price ?? $item->product->price;
                return $price * $item->quantity;
            });

            $shipping = $subtotal > 50 ? 0 : 5.00;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $shipping + $tax;

            return $this->sendResponse('Item removed from cart!', [
                'cart_count' => $this->getCartCount(),
                'subtotal' => number_format($subtotal, 2),
                'shipping' => number_format($shipping, 2),
                'tax' => number_format($tax, 2),
                'total' => number_format($total, 2),
                'is_empty' => $cartItems->isEmpty()
            ]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CART COUNT
    |--------------------------------------------------------------------------
    */
    public function count()
    {
        return $this->sendResponse('Cart count', ['count' => $this->getCartCount()]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    private function getCartItems()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = !$userId ? Session::getId() : null;

        return Cart::with('product')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->get();
    }

    private function getCartCount()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = !$userId ? Session::getId() : null;

        return Cart::when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->sum('quantity');
    }

    private function verifyCartOwnership($cart)
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = !$userId ? Session::getId() : null;

        return (
            ($userId && $cart->user_id == $userId) ||
            (!$userId && $cart->session_id == $sessionId)
        );
    }

    /**
     * Get cart summary for checkout
     */
    public function getCartSummary()
    {
        try {
            $userId = Auth::check() ? Auth::id() : null;
            $sessionId = !$userId ? Session::getId() : null;

            $cartItems = Cart::with('product')
                ->when($userId, function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->when(!$userId, function($query) use ($sessionId) {
                    $query->where('session_id', $sessionId);
                })->get();

            $items = [];
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $total = $price * $item->quantity;
                $subtotal += $total;

                $items[] = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'image' => $item->product->image,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $total
                ];
            }

            $shipping = $subtotal > 50 ? 0 : 5.00;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $shipping + $tax;

            return $this->sendResponse('Cart summary', [
                'items' => $items,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'item_count' => count($items)
            ]);

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }
}
