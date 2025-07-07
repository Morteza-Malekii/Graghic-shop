<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // نمایش صفحه پرداخت موفق
    public function success(Order $order)
    {
        return view('order.success', compact('order'));
    }

    // نمایش صفحه پرداخت ناموفق
    public function failure(Order $order)
    {
        return view('order.failure', compact('order'));
    }
}
