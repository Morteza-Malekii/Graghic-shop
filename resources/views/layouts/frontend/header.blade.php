<!DOCTYPE html>
<html lang="ar" dir="rtl">
@inject('cart', 'App\Services\CartService')
<head>
    <title>GRAPHIC SHOP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="/images/icons/favicon.png"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/css/util.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <!--===============================================================================================-->
</head>
<body class="animsition">

<!-- Header -->
<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    کاملترین فروشگاه فایلهای گرافیکی با فرمت فورکا با بهترین قیمت
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        راهنمای خرید و قوانین
                    </a>

                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        اکانت من
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex-c-m trans-04 p-lr-25">
                        مدیریت سایت
                    </a>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="/" class="logo">
                    <img src="/images/icons/logo-01.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">

                        <li class="active-menu">
                            <a href="/">صفحه اصلی</a>
                        </li>
                        <li>
                            <a href="/">تماس با ما</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify={{ $cart->count() }}>
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="/images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-l-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li>
                <a href="/">صفحه اصلی</a>
            </li>
            <li>
                <a href="/">تماس با ما</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15" action="{{ route('home.products.index') }}">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="متن خود را اینجا بنویسید ...">
            </form>
        </div>
    </div>
</header>

<!-- Cart Modal -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        {{-- عنوان و دکمه بستن --}}
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                سبد خرید ({{ $cart->all()->count() }} آیتم)
            </span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            {{-- لیست آیتم‌ها --}}
            <ul class="header-cart-wrapitem w-full">
                @forelse($cart->all() as $productId => $item)
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        {{-- فرم حذف با متد DELETE --}}
                        <form action="{{ route('cart.remove', $productId) }}"
                              method="POST"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="header-cart-item-img btn-reset">
                                <img src="{{ Storage::url($item['product']['thumbnail_url']) }}"
                                     alt="{{ $item['product']['title'] }}">
                            </button>
                        </form>

                        {{-- عنوان و قیمت و تعداد --}}
                        <div class="header-cart-item-txt p-t-8">
                            <a href="{{ route('home.products.show', $productId) }}"
                               class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                {{ $item['product']['title'] }}
                            </a>
                            <span class="header-cart-item-info">
                                {{ $item['quantity'] }} × {{ number_format($item['product']['price']) }} تومان
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="header-cart-item flex-w flex-t m-b-12 text-center">
                        سبد خرید شما خالی است.
                    </li>
                @endforelse
            </ul>

            {{-- جمع کل و دکمه مشاهده جزئیات سبد --}}
            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    مجموع: {{ number_format($cart->total()) }} تومان
                </div>
                <div class="header-cart-buttons flex-w w-full">
                    <a href="{{ route('cart.index') }}"
                       class="flex-c-m stext-101 cl0 size-107 w-100 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-l-8 m-b-10">
                        مشاهده سبد خرید و پرداخت
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
