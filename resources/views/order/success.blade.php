@extends('layouts.frontend.master')

@section('content')
<div class="container py-5 text-center">
    <h1 class="text-success">پرداخت موفق بود!</h1>
    <p>سفارش شما با شمارهٔ {{ $order->id }} با موفقیت ثبت شد.</p>
    <a href="{{ route('home.products.index') }}" class="btn btn-primary mt-3">بازگشت به فروشگاه</a>
</div>
@endsection
