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
        Route::get('',[CategoriesController::class ,'all'])->name('admin.categories.all');
        Route::get('create',[CategoriesController::class ,'Create'])->name('admin.categories.create');
        Route::post('store' , [CategoriesController::class ,'store'])->name('admin.categories.store');
        Route::delete('{category}/delete' , [CategoriesController::class ,'delete'])->name('admin.categories.delete');
        Route::get('{category}/edit' , [CategoriesController::class ,'edit'])->name('admin.categories.edit');
        Route::put('{category}/update' , [CategoriesController::class ,'update'])->name('admin.categories.update');
    });
});