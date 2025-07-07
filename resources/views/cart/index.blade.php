@extends('layouts.frontend.master')
@section('content')
<div class="container py-4">
    <h2>سبد خرید</h2>

    @if ($items->isEmpty())
        <p>سبد خرید شما خالی است.</p>
    @else
         {{-- دکمهٔ خالی کردن سبد با تأییدیه --}}
        <div class="mb-4">
            <a href="{{ route('cart.clear') }}"
               class="btn btn-danger"
               onclick="return confirm('آیا از خالی کردن سبد خرید مطمئن هستید؟')">
               خالی کردن سبد خرید
            </a>
        </div>
        {{-- فرم اطلاعات پرداخت و آیتم‌ها --}}
        <form action="{{ route('checkout') }}" method="POST" class="row">
          @csrf

          <div class="col-md-6">
            <h4 class="mtext-109 cl2 p-b-20">اطلاعات کاربری</h4>

            <div class="form-group mb-3">
              <label>نام و نام خانوادگی</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="نام و نام خانوادگی" required>
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
              <label>موبایل</label>
              <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="09xxxxxxxxx" required>
              @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-4">
              <label>ایمیل</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@mail.com" required>
              @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
          </div>

          <div class="col-md-6">
            {{-- جدول سبد --}}
            <table class="table">
              <thead>
                <tr>
                  <th>عکس</th>
                  <th>عنوان</th>
                  <th>قیمت</th>
                  <th>تعداد</th>
                  <th>جمع</th>
                  <th>عملیات</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr>
                    <td>
                      <img src="{{ Storage::url($item['product']['thumbnail_url']) }}" width="80" alt="تصویر محصول">
                    </td>
                    <td>{{ $item['product']['title'] }}</td>
                    <td>{{ number_format($item['product']['price']) }} تومان</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['product']['price'] * $item['quantity']) }} تومان</td>
                    <td>
                    <button type="button"
                            class="btn btn-danger btn-sm js-show-cart">
                        حذف از سبد خرید
                    </button>
                    </td>
                    {{-- این فیلدهای hidden حتماً باید داخل همین فرم اصلی باشند --}}
                    <input type="hidden" name="items[{{ $item['product']['id'] }}][quantity]"   value="{{ $item['quantity'] }}">
                    <input type="hidden" name="items[{{ $item['product']['id'] }}][unit_price]" value="{{ $item['product']['price'] }}">
                  </tr>
                @endforeach

                <tr>
                  <td colspan="4" class="text-right"><strong>مجموع قابل پرداخت:</strong></td>
                  <td colspan="2"><strong>{{ number_format($total) }} تومان</strong></td>
                </tr>
              </tbody>
            </table>

            <button type="submit" class="btn btn-success">
              نهایی‌سازی خرید و پرداخت
            </button>
          </div>
        </form>

    @endif
</div>
@endsection
