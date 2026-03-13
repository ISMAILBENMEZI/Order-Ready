<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Store\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function myStore()
    {
        $store = Auth::user()->store;

        $products = $store->Products()->with('primaryImage')
            ->latest()
            ->get();

        return view('seller.store.my-store', compact('products'));
    }

    public function createProduct()
    {
        $categories  = Category::all();

        return view('seller.store.create-product', compact('categories'));
    }

    public function storeProduct(StoreProductRequest $request)
    {
        try {
            $store = Auth::user()->store;

            $product = $store->products()->create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'is_negotiable' => $request->is_negotiable ?? false,
                'category_id' => $request->category_id,
                'status' => 'pending',
            ]);

            if ($request->hasFile('primary_image')) {
                $file = $request->file('primary_image');
                $fileName = time() . '_primary_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('stores/products', $fileName, 'public');

                $product->images()->create([
                    'image_url' => '/storage/stores/products/' . $fileName,
                    'is_primary' => true
                ]);
            }

            if ($request->hasFile('imagesinternal')) {
                foreach ($request->file('imagesinternal') as $image) {
                    $fileName = time() . '_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('stores/products', $fileName, 'public');

                    $product->images()->create([
                        'image_url' => '/storage/' . $path,
                        'is_primary' => false
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'redirect' => route('seller.store.index'),
                'message' => 'Product created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
