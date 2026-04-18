<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductActionController extends Controller
{
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
