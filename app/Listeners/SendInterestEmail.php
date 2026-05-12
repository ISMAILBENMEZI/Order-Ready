<?php

namespace App\Listeners;

use App\Events\InterestSent;
use App\Mail\Shop\InterestMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInterestEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InterestSent $event): void
    {
        Mail::to($event->product->store->contact_email)
            ->send(new InterestMail($event->product , $event->user));
    }
}
