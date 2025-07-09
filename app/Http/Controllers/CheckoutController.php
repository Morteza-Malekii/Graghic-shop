<?php
namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    protected CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout(CheckoutRequest $request)
    {
        $customerData = $request->only(['name','email','mobile']);
        $cartItems    = $request->input('items');

        return $this->checkoutService->checkout($customerData, $cartItems);
    }
}
