<?php

namespace App\Http\Controllers\Seller\store;

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

        return view('seller.store.statistics', compact(
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
}
