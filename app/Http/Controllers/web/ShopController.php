<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    use ResponseTrait;

    public function index(){
        $products = Product::all();
        $categories = Category::all();
        return view('web.shop.index', compact('products', 'categories'));
    }

    public function filter(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'filters' => 'required|array'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $filters = $request->filters;

            $query = Product::query()->with('category');

            /*
            |--------------------------------------------------------------------------
            | CATEGORY FILTER
            |--------------------------------------------------------------------------
            */
            if (!empty($filters['categories'])) {
                $childIds = Category::whereIn('parent_id', $filters['categories'])->pluck('id')->toArray();
                $allCategoryIds = array_merge($filters['categories'], $childIds);
                $query->whereIn('category_id', $allCategoryIds);
            }

            /*
            |--------------------------------------------------------------------------
            | BRAND FILTER
            |--------------------------------------------------------------------------
            */
            if (!empty($filters['brands'])) {
                $query->whereIn('category_id', $filters['brands']);
            }

            /*
            |--------------------------------------------------------------------------
            | PRICE FILTER
            |--------------------------------------------------------------------------
            */
            if (!empty($filters['maxPrice'])) {
                $min = $filters['minPrice'] ?? 0;
                $max = $filters['maxPrice'];
                $query->where(function ($q) use ($min, $max) {
                    $q->whereBetween('price', [$min, $max])
                        ->orWhereBetween('discount_price', [$min, $max]);
                });
            }

            /*
            |--------------------------------------------------------------------------
            | RATING FILTER
            |--------------------------------------------------------------------------
            */
            if (!empty($filters['ratings'])) {
                $query->where(function ($q) use ($filters) {
                    foreach ($filters['ratings'] as $rating) {
                        $q->orWhere('rating', '>=', $rating);
                    }
                });
            }

            /*
            |--------------------------------------------------------------------------
            | SORTING
            |--------------------------------------------------------------------------
            */
            if (!empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'price_low':
                        $query->orderByRaw('COALESCE(discount_price, price) ASC');
                        break;

                    case 'price_high':
                        $query->orderByRaw('COALESCE(discount_price, price) DESC');
                        break;

                    case 'popular':
                        $query->orderBy('reviews_count', 'DESC');
                        break;

                    default:
                        $query->latest();
                        break;
                }
            } else {
                $query->latest();
            }

            $products = $query->get();

            $html = view('web.shop.product-grid-component', compact('products'))->render();

            return $this->sendResponse('Filter',['html' => $html, 'count' => $products->count()]);

        } catch (\Exception $exception) {

            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function detail(request $request){
        $productId = base64_decode($request->slug);
        $product = Product::where('id', $productId)->with('category')->first();
        $relatedProducts = Product::where('category_id', $product->category->id)->with('category')->get();
        return view('web.product.index', compact('product', 'relatedProducts'));
    }


}
