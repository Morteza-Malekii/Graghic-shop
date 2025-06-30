<?php
namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    /**
     * نمایش سبد خرید و مجموع
     */
    public function index()
    {
        $items = $this->cart->all();
        $total = $this->cart->total();
        return view('cart.index', compact('items', 'total'));
    }

    /**
     * اضافه کردن محصول به سبد
     */
    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        $this->cart->add($product, $quantity);
        return redirect()->route('cart.index')
                         ->with('success', 'محصول به سبد اضافه شد.');
    }

    /**
     * حذف محصول از سبد
     */
    public function remove(Product $product)
    {
        $this->cart->remove($product->id);
        return redirect()->route('cart.index')
                         ->with('success', 'محصول از سبد حذف شد.');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.index');
                    // ->with('success', 'سبد خرید خالی شد .');
    }
}
