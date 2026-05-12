<?php

namespace App\Http\Controllers\Shop\Action;

use App\Http\Controllers\Controller;
use App\Models\InterestRequest;
use App\Models\Product;
use App\Services\InterestService;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{

    private InterestService $interestService;

    /**
     * Constructor - Inject InterestService via Dependency Injection
     *
     * Laravel automatically resolves this dependency from the service container.
     * This is cleaner than using Facades and makes testing much easier.
     *
     * @param InterestService $interestService
     */
    public function __construct(InterestService $interestService)
    {
        $this->interestService = $interestService;
    }

    /**
     * Handle user interest in a product
     *
     * Responsibilities:
     * 1. Extract HTTP request data (product and authenticated user)
     * 2. Delegate business logic to InterestService
     * 3. Return HTTP response
     *
     * @param Product 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function interest(InterestRequest $request,Product $product)
    {
        try {
            $this->interestService->sendInterest(Auth::user(), $product);
            return back()->with('success', 'Interest sent successfully');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something went wrong, please try again');
        }
    }
}
