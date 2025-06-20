<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('frontend.products.all', compact('categories','products'));
    }

    public function show(Product $product)
    {
        $simillerProducts = Product::where('category_id',$product->category_id)
                                        ->where('id','<>',$product->id)
                                        ->take(4)->get();
        return view('frontend.products.show',compact('product','simillerProducts'));
    }
}
