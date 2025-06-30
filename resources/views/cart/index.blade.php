@extends('layouts.frontend.master')
@section('content')
<div class="container py-4">
    <h2>سبد خرید</h2>
    @if($items->isEmpty())
        <p>سبد خرید شما خالی است.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>عکس</th><th>عنوان</th><th>قیمت</th>
                    <th>تعداد</th><th>جمع</th><th>عملیات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
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
        <a href="#" class="btn btn-success">نهایی‌سازی خرید</a>
    @endif
</div>
@endsection
