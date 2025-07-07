<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Home\ProductsController as HomeProductsController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function(){
    Route::get('',[HomeProductsController::class,'index'])->name('home.products.index');
    Route::get('{product}/show',[HomeProductsController::class,'show'])->name('home.products.show');
});

Route::get('products/admin',function(){
    return view('admin.index');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('clear', [CartController::class, 'clear'])->name('cart.clear');

});

Route::get('order/{order}/success', [OrderController::class, 'success'])
     ->name('order.success');
Route::get('order/{order}/failure', [OrderController::class, 'failure'])
     ->name('order.failure');


Route::post('checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::get('checkout/verify',[CheckoutController::class, 'verify'])->name('checkout.verify');
Route::get('payment/callback/{payment}',[PaymentController::class, 'callback'])->name('payment.callback');


Route::prefix('admin')->group(function(){
    Route::prefix('categories')->group(function(){
        Route::get('',[CategoriesController::class ,'index'])->name('admin.categories.index');
        Route::get('create',[CategoriesController::class ,'Create'])->name('admin.categories.create');
        Route::post('' , [CategoriesController::class ,'store'])->name('admin.categories.store');
        Route::delete('{category}/delete' , [CategoriesController::class ,'delete'])->name('admin.categories.delete');
        Route::get('{category}/edit' , [CategoriesController::class ,'edit'])->name('admin.categories.edit');
        Route::put('{category}/update' , [CategoriesController::class ,'update'])->name('admin.categories.update');
    });

    Route::prefix('products')->group(function(){
         Route::get('',[ProductsController::class, 'index'])->name('admin.products.index');
         Route::get('create',[ProductsController::class, 'create'])->name('admin.products.create');
         Route::post('',[ProductsController::class, 'store'])->name('admin.products.store');
         Route::get('{product}/download-demo',[ProductsController::class, 'downloadDemo'])->name('admin.products.download.demo');
         Route::get('{product}/download-source',[ProductsController::class, 'downloadSource'])->name('admin.products.download.source');
         Route::delete('{product}/destroy',[ProductsController::class, 'destroy'])->name('admin.products.destroy');
         Route::get('{product}/edit',[ProductsController::class, 'edit'])->name('admin.products.edit');
         Route::put('{product}/update',[ProductsController::class, 'update'])->name('admin.products.update');
    });

    Route::prefix('users')->group(function(){
         Route::get('',[UsersController::class, 'index'])->name('admin.users.index');
         Route::get('create',[UsersController::class, 'create'])->name('admin.users.create');
         Route::post('',[UsersController::class, 'store'])->name('admin.users.store');
         Route::delete('{user}/destroy',[UsersController::class, 'destroy'])->name('admin.users.destroy');
         Route::get('{user}/edit',[UsersController::class, 'edit'])->name('admin.users.edit');
         Route::put('{user}/update',[UsersController::class, 'update'])->name('admin.users.update');
    });

    Route::prefix('orders')->group(function(){
        Route::get('', [OrdersController::class, 'index'])->name('admin.orders.index');
    });

    Route::prefix('payments')->group(function(){
        Route::get('', [PaymentController::class, 'index'])->name('admin.payments.index');
    });

});
