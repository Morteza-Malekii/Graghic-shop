@extends('layouts.frontend.master')
@section('content')
    <div class="container py-4">
        <h2>سبد خرید</h2>
        @if ($items->isEmpty())
            <p>سبد خرید شما خالی است.</p>
        @else
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
                            <td><img src="{{ Storage::url($item['product']['thumbnail_url']) }}" width="80"></td>
                            <td>{{ $item['product']['title'] }}</td>
                            <td>{{ number_format($item['product']['price']) }} تومان</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['product']['price'] * $item['quantity']) }} تومان</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']['id']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">حذف</button>
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
            <a href="{{ route('cart.clear') }}" class="btn btn-danger"> خالی کردن سبد خرید </a>
    </div>

    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
            <h4 class="mtext-109 cl2 p-b-30">
                اطلاعات کاربری
            </h4>
            <form action="" method="post">
                <div class="flex-w flex-t">
                    <div class="w-full">
                        <div class="p-t-15">
                            <div class="bor8 bg0 m-b-12">
                                <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="family"
                                    placeholder="نام و نام خانوادگی">
                            </div>
                            <div class="bor8 bg0 m-b-12">
                                <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="mobile"
                                    placeholder="موبایل">
                            </div>
                            <div class="bor8 bg0 m-b-22">
                                <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="email"
                                    placeholder="ایمیل">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-success">نهایی‌سازی خرید و پرداخت</a>
            </form>

        </div>
    </div>
    @endif
@endsection
