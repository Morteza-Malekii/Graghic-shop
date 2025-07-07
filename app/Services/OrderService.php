<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;

class OrderService
{
    /**
     * ایجاد سفارش همراه با آیتم‌ها
     */
    public function createForUser(User $user, array $items): Order
    {
        // محاسبه مبلغ کل
        $total = collect($items)
            ->sum(fn($i) => $i['unit_price'] * $i['quantity']);

        // ایجاد سفارش
        $order = Order::create([
            'user_id'      => $user->id,
            'total_amount' => $total,
            'status'       => 'pending',
        ]);

        // ذخیره آیتم‌ها
        foreach ($items as $productId => $item) {
            $order->items()->create([
                'product_id'  => $productId,
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'total_price' => $item['unit_price'] * $item['quantity'],
            ]);
        }

        return $order;
    }
}
