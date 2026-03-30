<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Store\StoreProductRequest;
use App\Http\Requests\seller\Store\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class StoreController extends Controller
{
    public function myStore()
    {
        $store = Auth::user()->store;

        $products = $store->products()
            ->with('primaryImage')
            ->latest()
            ->paginate(12);

        return view('seller.store.my-store', compact('products', 'store'));
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

            session()->flash('success', 'Product created successfully!');

            return response()->json([
                'success' => true,
                'redirect' => route('seller.store.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editProduct(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $categories = Category::all();

        $product->load('images');

        return view('seller.store.edit-product', compact('product', 'categories'));
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        try {
            $store = Auth::user()->store;
            if (!$store) {
                return response()->json(['success' => false, 'message' => 'You have no store'], 403);
            }

            $product = $store->products()->findOrFail($id);

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'is_negotiable' => $request->is_negotiable ?? false,
                'category_id' => $request->category_id,
            ]);

            if ($request->hasFile('primary_image')) {
                $primary = $product->images()->where('is_primary', true)->first();
                if ($primary && $primary->image_url) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $primary->image_url));
                    $primary->delete();
                }

                $file = $request->file('primary_image');
                $fileName = time() . '_primary_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('stores/products', $fileName, 'public');

                $product->images()->create([
                    'image_url' => '/storage/' . $path,
                    'is_primary' => true
                ]);
            }

            $deletedIds = json_decode($request->deleted_images ?? '[]', true);
            if (is_array($deletedIds)) {
                foreach ($deletedIds as $imageId) {
                    $image = $product->images()->find($imageId);
                    if ($image && $image->image_url) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_url));
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('imagesinternal')) {
                $images = $request->file('imagesinternal');
                if (is_array($images)) {
                    foreach ($images as $image) {
                        $fileName = time() . '_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $path = $image->storeAs('stores/products', $fileName, 'public');

                        $product->images()->create([
                            'image_url' => '/storage/' . $path,
                            'is_primary' => false
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'redirect' => route('seller.store.index'),
                'message' => 'Product updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function deleteProduct(Product $product)
    {
        if ($product->store->seller_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        foreach ($product->images as $image) {
            $path = str_replace('/storage/', '', $image->image_url);
            if (file_exists(public_path($image->image_url))) {
                unlink(public_path($image->image_url));
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }

    public function showProduct($id)
    {
        $product = Auth::user()->store->products()
            ->with('category')
            ->findOrFail($id);
            
        return view('seller.store.show-product', compact('product'));
    }
}
