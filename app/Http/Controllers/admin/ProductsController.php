<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\products\StoreRequest;
use App\Http\Requests\Admin\products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);

        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $admin = User::where('email', 'morteza167@gmail.com')->first();
        $product = Product::create([
            'title'       => $data['title'],
            'description' => $data['description'],
            'price'       => $data['price'],
            'category_id' => $data['category_id'],
            'owner_id'    => $admin->id,
        ]);

        $publicFolder = public_path("products/{$product->id}");
        if (! is_dir($publicFolder)) {
            mkdir($publicFolder, 0755, true);
        }

        $paths = [];
        foreach (['thumbnail_url', 'demo_url'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = "{$field}_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                $sourcePath = $file->storeAs("products/{$product->id}", $filename, 'public_storage');
                $paths[$field] = "products/{$product->id}/{$filename}";
            }
        }

        if ($request->hasFile('source_url')) {
            $file = $request->file('source_url');
            $filename2 = "source_" . Str::random(12) . "." . $file->getClientOriginalExtension();
            $sourcePath = $file->storeAs("products/{$product->id}", $filename2, 'local_storage');
            $paths['source_url'] = $sourcePath;
        }

        $product->update($paths);
        return back()->with('success', 'محصول با موفقیت ذخیره شد.');
    }

    public function downloadDemo(Product $product)
    {
        $relativePath = $product->demo_url;
        $demoName = basename($relativePath);
        $disk = Storage::disk('public_storage');
        if (! $disk->exists($relativePath)) {
        return redirect()
            ->route('admin.products.index')
            ->with('failed', 'فایل دمو یافت نشد.');
        }
        return $disk->download($relativePath,$demoName);
    }

    public function downloadSource(Product $product)
    {
        $relativePath = $product->source_url;
        $demoName = basename($relativePath);
        $disk = Storage::disk('local_storage');
        return $disk->download($relativePath,$demoName);
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            Storage::disk('public_storage')->deleteDirectory("products/{$product->id}");
            Storage::disk('local_storage')->deleteDirectory("products/{$product->id}");
            $product->delete();
        });
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول و تمام فایل‌ها و پوشه‌های مرتبط حذف شدند.');
    }

    public function edit(Product $product )
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(UpdateRequest $request , Product $product)
    {
        $data = collect($request->validated())
                    ->except(['thumbnail_url','demo_url','source_url'])
                    ->toArray();

        DB::transaction(function () use($data , $product , $request) {
            $product->update($data);
            $filefields = [
                'thumbnail_url'=>'public_storage',
                'demo_url'=>'public_storage',
                'source_url'=>'local_storage'
            ];

            $paths = [];
            foreach ($filefields as $field => $disk_name)
            {
                if ($request->hasFile($field))
                {
                    $oldRelativePath = $product->$field;
                    $oldDiskPath = Storage::disk($disk_name);
                    if($oldRelativePath && $oldDiskPath->exists($oldRelativePath))
                    {
                        $oldDiskPath->delete($oldRelativePath);
                    }
                    $file = $request->file($field);
                    $fileName = $field . '_'. Str::random(8) .'.'. $file->getClientOriginalExtension();
                    $newRelativePath = $file->storeAs("products/{$product->id}",$fileName , $disk_name);
                    $paths[$field] = $newRelativePath;
                }
            }
            if (!empty($paths))
                {
                    $product->update($paths);
                }
            });
        return back()->with('success','product update successfulley !');
    }
}

