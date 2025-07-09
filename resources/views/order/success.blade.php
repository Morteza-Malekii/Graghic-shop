@extends('layouts.frontend.master')

@section('content')
{{-- <div class="container py-5 text-center">
    <h1 class="text-success">پرداخت موفق بود!</h1>
    <p>سفارش شما با شمارهٔ {{ $order->id }} با موفقیت ثبت شد.</p>
    <div>
        <table>
            <thead>
                <tr>
                <th>لینک دانلود تصویر خریداری شده </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($links as $link)
                <tr>
                    <td>
                        <a href="{{ $link }}" class="btn btn-outline-primary" download>لینک دانلود </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('home.products.index') }}" class="btn btn-primary mt-3">بازگشت به فروشگاه</a>
</div> --}}
<div class="container py-5 text-center">
    <h1 class="text-success">پرداخت موفق بود!</h1>
    <p>سفارش شما با شمارهٔ {{ $order->id }} با موفقیت ثبت شد.</p>

    {{-- اینجا dive رو به div تغییر بده --}}
    <div class="d-flex justify-content-center">
        <table class="table table-bordered mx-auto" style="width: auto;">
            <thead>
                <tr>
                    <th>لینک دانلود تصویر خریداری شده</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($links as $link)
                    <tr>
                        <td>
                            <a href="{{ $link }}"
                               class="btn btn-outline-primary"
                               download>
                                لینک دانلود
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('home.products.index') }}"
       class="btn btn-primary mt-3">
       بازگشت به فروشگاه
    </a>
</div>
@endsection
