<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();

        return view('store.catalog', compact('products', 'categories', 'brands'));
    }

    public function show(\App\Models\Product $product)
    {
        $product->load(['category', 'brand', 'reviews.user']);
        $userReview = \Illuminate\Support\Facades\Auth::check() ? $product->reviews()->where('user_id', \Illuminate\Support\Facades\Auth::id())->first() : null;
        $inWishlist = \Illuminate\Support\Facades\Auth::check() ? \App\Models\Wishlist::where('user_id', \Illuminate\Support\Facades\Auth::id())->where('product_id', $product->id)->exists() : false;

        return view('store.product', compact('product', 'userReview', 'inWishlist'));
    }
}
