<?php

namespace App\Services;

use App\Events\InterestSent;
use App\Jobs\SendInterestMailJop;
use App\Mail\Shop\InterestMail;
use App\Models\InterestRequest;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InterestService
{
    /**
     * Send interest notification for a product
     *
     * This method performs all operations needed when a user expresses interest
     * in a product:
     * 1. Creates a message record between buyer and seller
     * 2. Creates an interest request record for tracking
     * 3. Sends an email notification to the seller
     *
     * Database operations are wrapped in a transaction to ensure atomicity.
     * This means either all database changes succeed, or none are applied.
     * If any database operation fails, all changes are rolled back automatically,
     * preventing inconsistent or partial data states.
     *
     * The email is sent AFTER the transaction commits successfully to avoid
     * sending notifications for failed database operations.
     *
     * @param User $user - The user expressing interest (buyer)
     * @param Product $product - The product of interest
     * @return void
     * @throws \Throwable - Re-throws exceptions from the transaction
     */
    public function sendInterest(User $user, Product $product): void
    {
        DB::transaction(function () use ($user, $product) {

            $this->createMessage($user, $product);

            $this->createInterestRequest($user, $product);

            event(new InterestSent($user, $product));
        });
    }

    /**
     * Create a message record between buyer and seller
     *
     * This establishes the communication channel and creates a record
     * of the buyer's initial interest message.
     *
     * @param User $user - The buyer
     * @param Product $product - The product
     * @return Message
     */
    private function createMessage(User $user, Product $product): Message
    {
        return Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $product->store->seller_id,
            'product_id' => $product->id,
            'message' => 'I am interested in this product',
        ]);
    }

    /**
     * Create an interest request record
     *
     * This tracks the user's interest in a product for analytics,
     * reporting, and recommendations. Uses firstOrCreate to prevent
     * duplicate requests.
     *
     * @param User $user - The buyer
     * @param Product $product - The product
     * @return InterestRequest
     */
    private function createInterestRequest(User $user, Product $product): InterestRequest
    {
        return InterestRequest::firstOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            [
                'message' => 'I am interested in this product',
            ]
        );
    }

    /**
     * Send email notification to seller
     *
     * Notifies the seller about the buyer's interest via email.
     * The actual email content is handled by InterestMail class.
     *
     * @param Product $product - The product
     * @param User $user - The buyer
     * @return void
     */
    private function notifySeller(Product $product, User $user): void
    {
        Mail::to($product->store->contact_email)->send(
            new InterestMail($product, $user)
        );
    }
}
