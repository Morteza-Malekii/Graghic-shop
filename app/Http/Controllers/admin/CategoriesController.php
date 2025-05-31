<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategory;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\categories\UpdateRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class CategoriesController extends Controller
{
    public function create(){
        return view('admin.categories.create');
    }

    public function store(StoreRequest $request)
    {
        $category = Category::create($request->validated());
        if (!$category)
            return back()->with('failed','category was not created!');
        return back()->with('success','category created succcessfully!');
    }

    public function all()
    {
        $categories = Category::paginate(5);
        return view('admin.categories.all',compact('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();
        return back()->with('success','category was deleted.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    public function update(UpdateRequest $request ,Category $category)
    {
        if(!$category->update($request->validated()))
            return back()->with('failed', 'category was not updated');
        return back()->with('success', 'category updated successfully');
    }
    
}
