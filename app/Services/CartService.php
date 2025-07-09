<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    public const CART_KEY = 'cart.items';

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = Session::get(self::CART_KEY, []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'product' => [
                    'id'    => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'thumbnail_url' => $product->thumbnail_url,
                ],
                'quantity' => $quantity,
            ];
        }

        Session::put(self::CART_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = Session::get(self::CART_KEY, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put(self::CART_KEY, $cart);
        }
    }

    public function all(): Collection
    {
        $cart = Session::get(self::CART_KEY, []);
        return collect($cart);
    }

    public function count(): int
    {
        return $this->all()->sum('quantity');
    }

    public function total(): float
    {
        return $this->all()->reduce(fn($sum, $item) =>
            $sum + $item['product']['price'] * $item['quantity'], 0
        );
    }

    public function clear(): void
    {
        Session::forget(self::CART_KEY);
    }
}

