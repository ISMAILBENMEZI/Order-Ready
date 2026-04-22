<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function show(Store $store, Request $request)
    {
        $query = $store->products()->with('primaryImage', 'category')
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
}
