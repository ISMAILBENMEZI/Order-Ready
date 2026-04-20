<?php

namespace App\Http\Controllers\Shop\Action;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
}
