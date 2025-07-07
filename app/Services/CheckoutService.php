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

    public function __construct(
        OrderService $orderService,
        PaymentService $paymentService
    ) {
        $this->orderService   = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * انجام کل فرایند Checkout و بازگشت
     * فرم پرداخت یا URL درگاه
     */
    public function checkout(array $customerData, array $cartItems)
    {
        // ۱. ایجاد کاربر
        $user = User::create([
            'name'     => $customerData['name'],
            'email'    => $customerData['email'],
            'mobile'   => $customerData['mobile'],
            'password' => bcrypt(Str::random(12)),
        ]);

        // ۲. ایجاد سفارش و آیتم‌ها
        $order = $this->orderService->createForUser($user, $cartItems);

        // ۳. شروع پرداخت
        return $this->paymentService->generate($order);
    }
}
