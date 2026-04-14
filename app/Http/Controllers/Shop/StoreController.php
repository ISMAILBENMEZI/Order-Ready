<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function show(Store $store, Request $request)
    {
        $query = $store->products()->with('primaryImage', 'category');

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
            case 'top_rated':
                $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('shop.store.show', compact('store', 'products', 'categories'));
    }

    public function toggleFollow(Store $store)
    {
        Auth::user()->followedStores()->toggle($store->id);
        return back()->with('success', 'Operation successful');
    }

    public function report(Request $request, Product $product)
    {
        $request->validate([
            'reason' => 'required|in:spam,scam,fake_product,inappropriate_content,other',
            'description' => 'nullable|string|max:1000',
        ]);

        Report::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'reason' => $request->reason,
                'description' => $request->description,
                'status' => 'pending',
            ]
        );

        return redirect()
            ->route('shop.products.show', $product->slug)
            ->with('success', 'Report sent successfully');
    }

    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Review saved successfully.');
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
