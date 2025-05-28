<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategory;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create(){
        return view('admin.categories.create');
    }

    public function store(StoreRequest $request)
    {
        // $storeRequest = $request->validate();
        $categoryStore = Category::create([
            'title'=>$request->title,
            'slug'=>$request->slug
        ]);
        if (!$categoryStore)
            return back()->with('failed','category is not created !');
        return back()->with('success','category is create succcessfully!');
    }

    public function all()
    {
        $categories = Category::paginate(5);
        return view('admin.categories.all',compact('categories'));
    }
}
