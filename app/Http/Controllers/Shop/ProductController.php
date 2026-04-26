<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category', 'primaryImage'])
            ->where('status', 'available')
            ->where('admin_status', 'active');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.products', compact('products'))->render(),
                'next_page' => $products->nextPageUrl(),
            ]);
        }

        return view('shop.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load([
            'store',
            'category',
            'images',
            'ratings.user',
        ]);

        $averageRating = $product->ratings()->avg('rating');

        return view('shop.products.show', [
            'product' => $product,
            'averageRating' => $averageRating,
        ]);
    }
}
