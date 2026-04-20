<?php

namespace App\Http\Controllers\Shop\Action;

use App\Http\Controllers\Controller;
use App\Mail\Shop\InterestMail;
use App\Models\Message;
use App\Models\Product;
use App\Models\InterestRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InterestController extends Controller
{
    public function interest(Product $product)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->store->seller_id,
            'product_id' => $product->id ?? null,
            'message' => 'I am interested in this product',
        ]);

        InterestRequest::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'message' => 'I am interested in this product',
        ]);

        Mail::to($product->store->contact_email)->send(
            new InterestMail($product, Auth::user())
        );
        return back();
    }
}
