<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public array $links;
    public $productIds;


    public function success(Order $order)
    {
        $orders = Order::with('items.product')->findOrFail($order->id);
        $links = $orders->items
                        ->map(fn($item) => route('download.file',['path'=>$item->product->source_url]) )
                        ->toArray();
        return view('order.success', compact('order','links'));
    }


    // نمایش صفحه پرداخت ناموفق
    public function failure(Order $order)
    {
        return view('order.failure', compact('order'));
    }
}
