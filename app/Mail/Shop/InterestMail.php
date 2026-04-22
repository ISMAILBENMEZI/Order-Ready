<?php

namespace App\Mail\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $buyer;

    /**
     * Create a new message instance.
     */
    public function __construct($product, $buyer)
    {
        $this->product = $product;
        $this->buyer = $buyer;
    }

    public function build()
    {
        return $this->subject('Someone is interested in your product')->view('emails.shop.interest')->with([
            'product' => $this->product,
            'buyer' => $this->buyer,
        ]);
    }
}
