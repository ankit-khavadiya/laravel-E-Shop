<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $featuredProducts = Product::where('is_featured', 1)->with([
            'wishlist' => function ($query) {
                $query->where('user_id', auth()->id());
            }])->take(4)->get();
//        return $featuredProducts;
        $popularCategories = Category::where('parent_id', 0)
            ->withCount('products')
            ->with(['children' => function ($q) {
                $q->withCount('products');
            }])
            ->take(6)
            ->get()
            ->map(function ($category) {
                $childCount = $category->children->sum('products_count');
                $category->total_products = $category->products_count + $childCount;
                return $category;
            });
        $brand = Category::where('parent_id', '>' , 0)->take(6)->get();
        return view('web.home.index', compact('featuredProducts', 'popularCategories', 'brand'));
    }
}
