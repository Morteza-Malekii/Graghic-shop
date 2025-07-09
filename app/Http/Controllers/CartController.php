<?php
namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index()
    {
        $items = $this->cart->all();
        $total = $this->cart->total();
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        $this->cart->add($product, $quantity);
        return redirect()->route('cart.index')
                         ->with('success', 'محصول به سبد اضافه شد.');
    }

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
    }
}
