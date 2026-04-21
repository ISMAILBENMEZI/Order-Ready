<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $reason;

    public function __construct($product, $reason)
    {
        $this->product = $product;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Important update concerning your product')
            ->view('emails.admin.seller_action')
            ->with([
                'reason' => $this->reason,
                'product' => $this->product,
            ]);
    }
}
