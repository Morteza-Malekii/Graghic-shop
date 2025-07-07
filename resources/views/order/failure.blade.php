@extends('layouts.frontend.master')

@section('content')

<div class="container py-5 text-center">
    <h1 class="text-danger">پرداخت ناموفق</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @else
        <p>متأسفانه پرداخت سفارش #{{ $order->id }} با خطا مواجه شد.</p>
    @endif

    <a href="{{ route('cart.index') }}" class="btn btn-secondary mt-3">
        بازگشت به سبد خرید
    </a>
@endsection
