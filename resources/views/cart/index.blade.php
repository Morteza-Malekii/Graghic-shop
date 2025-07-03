@extends('layouts.frontend.master')
@section('content')
    <div class="container py-4">
    <h2>سبد خرید</h2>

    @if ($items->isEmpty())
        <p>سبد خرید شما خالی است.</p>
    @else
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
                            <form action="{{ route('cart.remove', $item['product']['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right"><strong>مجموع قابل پرداخت:</strong></td>
                    <td colspan="2"><strong>{{ number_format($total) }} تومان</strong></td>
                </tr>
            </tbody>
        </table>

        {{-- دکمه‌ی خالی کردن سبد --}}
        <div class="mb-4">
            <a href="{{ route('cart.clear') }}" class="btn btn-danger">خالی کردن سبد خرید</a>
        </div>

        {{-- فرم اطلاعات پرداخت --}}
        <form action="{{ route('payment') }}" method="POST" class="row">
            @csrf

            <div class="col-md-6">
                <h4 class="mtext-109 cl2 p-b-20">اطلاعات کاربری</h4>

                <div class="form-group mb-3">
                    <label>نام و نام خانوادگی</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           placeholder="نام و نام خانوادگی">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>موبایل</label>
                    <input type="text"
                           name="mobile"
                           value="{{ old('mobile') }}"
                           class="form-control"
                           placeholder="09xxxxxxxxx">
                    @error('mobile')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label>ایمیل</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           placeholder="example@mail.com">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    نهایی‌سازی خرید و پرداخت
                </button>
            </div>
        </form>

    @endif
</div>
@endsection
