<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['store', 'images', 'category'])
            ->whereIn('status', ['approved', 'sold'])
            ->latest()
            ->paginate(12);

        if ($request->ajax()) {
            return view('shop.products.partials.products', compact('products'))->render();
        }
        
        return view('shop.products.index', compact('products'));
    }
}
