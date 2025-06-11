<?php

use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\ProductsController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;


Route::get('products/all', function(){
    return view('frontend.products.all');
});
Route::get('test', function(){
    return view('test');
});

Route::get('products/admin',function(){
    return view('admin.index');
});

Route::prefix('admin')->group(function(){
    Route::prefix('categories')->group(function(){
        Route::get('',[CategoriesController::class ,'all'])->name('admin.categories.all');
        Route::get('create',[CategoriesController::class ,'Create'])->name('admin.categories.create');
        Route::post('' , [CategoriesController::class ,'store'])->name('admin.categories.store');
        Route::delete('{category}/delete' , [CategoriesController::class ,'delete'])->name('admin.categories.delete');
        Route::get('{category}/edit' , [CategoriesController::class ,'edit'])->name('admin.categories.edit');
        Route::put('{category}/update' , [CategoriesController::class ,'update'])->name('admin.categories.update');
    });

    Route::prefix('products')->group(function(){
         Route::get('',[ProductsController::class, 'all'])->name('admin.products.all');
         Route::get('create',[ProductsController::class, 'create'])->name('admin.products.create');
         Route::post('',[ProductsController::class, 'store'])->name('admin.products.store');
         Route::get('{product}/download-demo',[ProductsController::class, 'downloadDemo'])->name('admin.products.download.demo');
         Route::get('{product}/download-source',[ProductsController::class, 'downloadSource'])->name('admin.products.download.source');
         Route::delete('{product}/delete',[ProductsController::class, 'destroy'])->name('admin.products.delete');
    });
});
