<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
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
});
