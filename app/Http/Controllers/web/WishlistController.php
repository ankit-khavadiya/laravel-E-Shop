<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    use ResponseTrait;

    /*
    |--------------------------------------------------------------------------
    | WISHLIST PAGE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $wishlistItems = $this->getWishlistItems();

        return view('web.wishlist.index', compact('wishlistItems'));
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE WISHLIST
    |--------------------------------------------------------------------------
    */
    public function toggle(Request $request)
    {
        try {

            if (!Auth::check()) {
                return $this->sendError('Please login first.');
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $wishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | REMOVE FROM WISHLIST
            |--------------------------------------------------------------------------
            */
            if ($wishlist) {

                $wishlist->delete();

                return $this->sendResponse(
                    'Product removed from wishlist.',
                    [
                        'added' => false,
                        'wishlist_count' => $this->getWishlistCount()
                    ]
                );

            }

            /*
            |--------------------------------------------------------------------------
            | ADD TO WISHLIST
            |--------------------------------------------------------------------------
            */
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);

            return $this->sendResponse('Product added to wishlist.', ['added' => true, 'wishlist_count' => $this->getWishlistCount()]);

        } catch (\Exception $exception) {

            return $this->sendError($exception->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE ITEM
    |--------------------------------------------------------------------------
    */
    public function remove(Request $request)
    {
        try {

            if (!Auth::check()) {
                return $this->sendError('Please login first.');
            }

            $validator = Validator::make($request->all(), [
                'wishlist_id' => 'required|exists:wishlists,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $wishlist = Wishlist::where('id', $request->wishlist_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$wishlist) {
                return $this->sendError('Wishlist item not found.');
            }

            $wishlist->delete();

            return $this->sendResponse(
                'Item removed from wishlist.',
                [
                    'wishlist_count' => $this->getWishlistCount()
                ]
            );

        } catch (\Exception $exception) {

            return $this->sendError($exception->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | WISHLIST COUNT
    |--------------------------------------------------------------------------
    */
    public function count()
    {
        try {
            return $this->sendResponse('Wishlist count fetched successfully.', ['count' => $this->getWishlistCount()]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK PRODUCT IN WISHLIST
    |--------------------------------------------------------------------------
    */
    public function check(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            if (!Auth::check()) {

                return $this->sendResponse(
                    'Wishlist checked.',
                    [
                        'in_wishlist' => false
                    ]
                );

            }

            $inWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->exists();

            return $this->sendResponse(
                'Wishlist checked.',
                [
                    'in_wishlist' => $inWishlist
                ]
            );

        } catch (\Exception $exception) {

            return $this->sendError($exception->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET WISHLIST API
    |--------------------------------------------------------------------------
    */
    public function getWishlist()
    {
        try {

            if (!Auth::check()) {

                return $this->sendResponse('Wishlist fetched.', [
                        'items' => [],
                        'count' => 0
                    ]
                );

            }

            $wishlistItems = $this->getWishlistItems();

            $items = $wishlistItems->map(function ($item) {

                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'image' => $item->product->image,
                    'price' => $item->product->discount_price ?? $item->product->price,
                    'original_price' => $item->product->price,
                    'stock' => $item->product->quantity,
                    'in_stock' => $item->product->quantity > 0,
                ];

            });

            return $this->sendResponse(
                'Wishlist fetched successfully.',
                [
                    'items' => $items,
                    'count' => $items->count()
                ]
            );

        } catch (\Exception $exception) {

            return $this->sendError($exception->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE METHODS
    |--------------------------------------------------------------------------
    */
    private function getWishlistItems()
    {
        if (!Auth::check()) {
            return collect();
        }

        return Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    private function getWishlistCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        return Wishlist::where('user_id', Auth::id())->count();
    }
}
