<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Services\OrderService;
use App\Services\PaymentService;

class CheckoutService
{
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService   = $orderService;
        $this->paymentService = $paymentService;
    }

    public function checkout(array $customerData, array $cartItems)
    {
        $user = User::create([
            'name'     => $customerData['name'],
            'email'    => $customerData['email'],
            'mobile'   => $customerData['mobile'],
            'password' => bcrypt(Str::random(12)),
        ]);
        $order = $this->orderService->createForUser($user, $cartItems);
        return $this->paymentService->generate($order);
    }
}
