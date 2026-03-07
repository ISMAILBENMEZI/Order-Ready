<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreSetupRequest;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreSetupController extends Controller
{
    public function create()
    {
        $categories = Category::where('status', 'active')->get();

        return view('seller.store.setup', compact('categories'));
    }

    public function store(StoreSetupRequest $request)
    {
        // dd($request->all());

        $data = $request->validated();

        $logoPath = null;
        $bannerPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
        }

        $store = Store::create([
            'seller_id' => Auth::id(),
            'name' => $data['name'],
            'description' => $data['description'],
            'location' => $data['location'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'],
            'logo_url' => $logoPath,
            'banner_url' => $bannerPath,
            'status' => 'active',
        ]);

        $store->categories()->sync($data['categories']);

        return redirect('/')
            ->with('success', 'Your store has been created successfully.');
    }
}
