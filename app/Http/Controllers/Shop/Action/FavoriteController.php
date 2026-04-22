<?php

namespace App\Http\Controllers\Shop\Action;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
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

    public function toggleFavorite(Product $product)
    {
        $userId = Auth::id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Remove form favorite');
        }

        Favorite::create([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);
        return back()->with('success', 'added to favorites');
    }
}
