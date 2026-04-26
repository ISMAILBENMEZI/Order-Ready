<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreStatisticsController extends Controller
{
    public function index(Store $store)
    {
        $totalProducts = $store->products()->count();

        $availableProducts = $store->products()
            ->where('status', 'available')
            ->count();

        $negotiatingProducts = $store->products()
            ->where('status', 'negotiating')
            ->count();

        $soldoutProducts = $store->products()
            ->where('status', 'sold_out')
            ->count();

        $followers = $store->followers()->count();

        $topFavoritedProducts = $store->products()
            ->withCount('favorites')
            ->having('favorites_count', '>=', 10)
            ->count();

        $reports = $store->products()
            ->withCount('reports')
            ->get()
            ->sum('reports_count');

        $goodRatedProducts = $store->products()
            ->withAvg('ratings', 'rating')
            ->having('ratings_avg_rating', '>=', 4)
            ->count();

        $interests = $store->products()
            ->withCount('interestRequests')
            ->get()
            ->sum('interest_requests_count');


        $deadProducts = $store->products()
            ->whereDoesntHave('favorites')
            ->whereDoesntHave('interestRequests')
            ->get();

        return view('seller.statistic.statistics', compact(
            'store',
            'topFavoritedProducts',
            'totalProducts',
            'availableProducts',
            'negotiatingProducts',
            'soldoutProducts',
            'followers',
            'reports',
            'goodRatedProducts',
            'interests',
            'deadProducts'
        ));
    }

    public function favorites(Store $store)
    {
        $products = $store->products()
            ->with('primaryImage')
            ->withCount('favorites')
            ->orderBy('favorites_count', 'desc')
            ->take(12)
            ->get();

        return view('seller.statistic.favorites', compact('store', 'products'));
    }

    public function interests(Store $store)
    {
        $products = $store->products()
            ->withCount('interestRequests')
            ->orderByDesc('interest_requests_count')
            ->take(12)
            ->get();

        return view('seller.statistic.interests', compact('store', 'products'));
    }

    public function reports(Store $store)
    {
        $products = $store->products()
            ->withCount('reports')
            ->orderByDesc('reports_count')
            ->take(12)
            ->get();

        return view('seller.statistic.reports', compact('store', 'products'));
    }

    public function deadProducts(Store $store)
    {
        $products = $store->products()
            ->doesntHave('favorites')
            ->doesntHave('interestRequests')
            ->take(12)
            ->get();

        return view('seller.statistic.deadProducts', compact('store', 'products'));
    }
}
