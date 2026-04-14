<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::whereHas('favorites', function ($q) {
            $q->where('user_id', Auth::id());
        })->with(['primaryImage', 'category']);

        if ($request->filled('search')) {
            $query->where('name', 'like' , '%' . $request->search . '%');
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
                $query->withAvg('ratings', 'rating')
                    ->orderByDesc('ratings_avg_rating');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        return view('shop.favorites.index', compact('products', 'categories'));
    }
}
