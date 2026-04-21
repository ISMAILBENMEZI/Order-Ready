<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Report;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $productsCount = Product::Count();
        $storesCount = Store::count();

        $bannedProducts = Product::where('admin_status', 'banned')->count();
        $activeProducts = Product::where('admin_status', 'active')->count();

        $sellersCount = User::whereHas('role', function ($q) {
            $q->where('name', 'seller');
        })->count();

        return view('admin.dashboard', compact(
            'usersCount',
            'productsCount',
            'storesCount',
            'bannedProducts',
            'activeProducts',
            'sellersCount'
        ));
    }
}
