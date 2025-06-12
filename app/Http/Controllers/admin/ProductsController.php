<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\products\StoreRequest;
use App\Http\Requests\admin\products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductsController extends Controller
{
    public function all()
    {
        $products = Product::paginate(5);

        return view('admin.products.all', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        // ۱. ایجاد رکورد محصول
        $admin = User::where('email', 'morteza167@gmail.com')->first();
        $product = Product::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'category_id' => $validated['category_id'],
            'owner_id'    => $admin->id,
        ]);

        // ۲. پوشه‌ی مقصد در public (مثلاً public/products/ID)
        $publicFolder = public_path("products/{$product->id}");
        if (! is_dir($publicFolder)) {
            mkdir($publicFolder, 0755, true);
        }

        // ۳. ذخیره‌ی thumbnail و demo در public و ساخت مسیر نسبی
        $paths = [];
        foreach (['thumbnail_url', 'demo_url'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = "{$field}_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                $sourcePath = $file->storeAs("products/{$product->id}", $filename, 'public_storage');
                // $file->move($publicFolder, $filename);

                // مسیر نسبی برای دیتابیس
                $paths[$field] = "products/{$product->id}/{$filename}";
            }
        }

        // ۴. ذخیره‌ی source در پوشه‌ی private (storage/app/private)
        if ($request->hasFile('source_url')) {
            $file = $request->file('source_url');
            $filename2 = "source_" . Str::random(12) . "." . $file->getClientOriginalExtension();
            // local_storage در config/filesystems تعریف شده به storage/app/private
            $sourcePath = $file->storeAs("products/{$product->id}", $filename2, 'local_storage');
            $paths['source_url'] = $sourcePath;
        }

        // ۵. به‌روزرسانی مسیرها در دیتابیس
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
            ->route('admin.products.all')
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
    // همه چیز را در یک تراکنش انجام می‌دهیم
    DB::transaction(function () use ($product) {
        // حذف کامل پوشه‌ی محصولات برای فایل‌های عمومی
        Storage::disk('public_storage')->deleteDirectory("products/{$product->id}");

        // حذف پوشه‌ی محصولات برای فایل‌های خصوصی
        Storage::disk('local_storage')->deleteDirectory("products/{$product->id}");

        // حذف رکورد محصول از دیتابیس
        $product->delete();
    });
    return redirect()
        ->route('admin.products.all')
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

