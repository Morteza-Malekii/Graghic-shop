<?php

use App\Http\Controllers\admin\CategoriesController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;

Route::get('products/all', function(){
    return view('frontend.products.all');
});

Route::get('products/admin',function(){
    return view('admin.index');
});

Route::prefix('admin')->group(function(){
    Route::prefix('categories')->group(function(){
        Route::get('create',[CategoriesController::class , 'Create']);
        Route::post('store' , [CategoriesController::class , 'store'])->name('admin.categories.store');
    });
});