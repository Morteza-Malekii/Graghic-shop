<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\products\StoreRequest;
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
}

