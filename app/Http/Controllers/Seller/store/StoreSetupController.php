<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Store\StoreSetupRequest;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreSetupController extends Controller
{
    public function create()
    {
        if (Auth::user()->store()->exists()) {
            return redirect('/')
                ->with('error', 'You already have a store.');
        }

        $categories = Category::where('status', 'active')->get();

        return view('seller.store.setup', compact('categories'));
    }

    public function store(StoreSetupRequest $request)
    {

        if (Auth::user()->store()->exists()) {
            return redirect('/')
                ->with('error', 'You already created a store.');
        }

        $data = $request->validated();

        $logoPath = null;
        $bannerPath = null;

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_logo_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('stores/logos', $logoName, 'public');
        }

        if ($request->hasFile('banner')) {

            $bannerFile = $request->file('banner');

            $bannerName = time() . '_banner_' . uniqid() . '.' . $bannerFile->getClientOriginalExtension();

            $bannerPath = $bannerFile->storeAs('stores/banners', $bannerName, 'public');
        }

        DB::transaction(function () use ($data, $logoPath, $bannerPath) {
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
        });


        return redirect('/')
            ->with('success', 'Your store has been created successfully.');
    }
}
