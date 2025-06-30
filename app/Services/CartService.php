<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    public const CART_KEY = 'cart.items';

    /**
     * افزودن محصول به سبد (یا افزایش تعداد در صورت وجود)
     */
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

    /**
     * حذف کامل یک محصول از سبد
     */
    public function remove(int $productId): void
    {
        $cart = Session::get(self::CART_KEY, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put(self::CART_KEY, $cart);
        }
    }

    /**
     * بازگرداندن همه‌ی آیتم‌های سبد به صورت Collection
     */
    public function all(): Collection
    {
        $cart = Session::get(self::CART_KEY, []);
        return collect($cart);
    }

    /**
     *  تعداد کل آیتم‌های سبد خرید
    */
    public function count(): int
    {
        return $this->all()->sum('quantity');
    }


    /**
     * محاسبه مجموع قیمت قابل پرداخت
     */
    public function total(): float
    {
        return $this->all()->reduce(fn($sum, $item) =>
            $sum + $item['product']['price'] * $item['quantity'], 0
        );
    }

    /**
     * پاک کردن کامل سبد خرید
     */
    public function clear(): void
    {
        Session::forget(self::CART_KEY);
    }
}

