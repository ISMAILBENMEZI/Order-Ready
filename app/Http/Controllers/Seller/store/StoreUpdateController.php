<?php

namespace App\Http\Controllers\Seller\store;

use App\Http\Controllers\Controller;
use App\Http\Requests\seller\store\StoreUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreUpdateController extends Controller
{
    public function edit()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store.setup');
        }

        $categories = Category::where('status', 'active')->get();
        $selectedCategories = $store->categories->pluck('id')->toArray();
        return view('seller.store.edit-store', compact('store', 'categories', 'selectedCategories'));
    }

    public function update(StoreUpdateRequest $request)
    {
        $store = Auth::user()->store;
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($store->logo_url) {
                Storage::disk('public')->delete($store->logo_url);
                $logoFile = $request->file('logo');
                $logoName = time() . '_logo_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
                $data['logo_url'] = $logoFile->storeAs('stores/logos', $logoName, 'public');
            }
        }

        if ($request->hasFile('banner')) {
            if ($store->banner_url) {
                Storage::disk('public')->delete($store->banner_url);
            }

            $bannerFile = $request->file('banner');
            $bannerName = time() . '_banner_' . uniqid() . '.' . $bannerFile->getClientOriginalExtension();
            $data['banner_url'] = $bannerFile->storeAs('stores/banners', $bannerName, 'public');
        }



        DB::transaction(function () use ($store, $data) {

            $store->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'location' => $data['location'],
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
                'logo_url' => $data['logo_url'] ?? $store->logo_url,
                'banner_url' => $data['banner_url'] ?? $store->banner_url
            ]);
            $store->categories()->sync($data['categories']);
        });

        return redirect()->route('seller.store.index')->with('success', 'Store information updated successfully!');
    }
}
