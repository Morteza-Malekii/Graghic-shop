@extends('layouts.frontend.master')

@section('content')
    <!-- Product -->
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button class="mtext-106 cl6 hov1 bor3 trans-04 m-l-32 m-tb-5 how-active1" data-filter="*">
                        همه دسته بندی ها
                    </button>

                    @foreach ($categories as $category)
                        <button class="mtext-106 cl6 hov1 bor3 trans-04 m-l-32 m-tb-5"
                            data-filter=".category{{ $category->id }}">
                            {{ $category->title }}
                        </button>
                    @endforeach
                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-l-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-l-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        فیلتر کردن
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 m-r-8 js-show-search">
                        <i class="icon-search cl2 m-l-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-l-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        جستجو
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                            placeholder="متن خود را اینجا بنویسید و enter بزنید ...">
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    {{-- فرم فیلتر با کلاس wrap-filter --}}
                    <form method="GET" action="{{ route('home.products.index') }}"
                        class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">

                        {{-- ۱. دسته‌بندی‌ها (چندتایی) --}}
                        <div class="filter-col p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">دسته‌بندی</div>
                            @foreach ($categories as $cat)
                                <label class="stext-106 cl3 p-b-6 d-block">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                        {{ in_array($cat->id, request('categories', [])) ? 'checked' : '' }}>
                                    {{ $cat->title }}
                                </label>
                            @endforeach
                        </div>

                        {{-- ۲. بازهٔ قیمت --}}
                        <div class="filter-col p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">قیمت (هزار تومان)</div>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="از"
                                class="mtext-107 cl2 size-114 plh2 p-r-15 mb-2">
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="تا"
                                class="mtext-107 cl2 size-114 plh2 p-r-15">
                        </div>

                        {{-- ۳. جستجوی متن --}}
                        <div class="filter-col p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">جستجو</div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="متن خود را بنویسید…" class="mtext-107 cl2 size-114 plh2 p-r-15">
                        </div>

                        {{-- ۴. مرتب‌سازی --}}
                        <div class="filter-col p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">مرتب‌سازی</div>
                            <select name="orderby" class="stext-106 cl2">
                                <option value="">پیش‌فرض</option>
                                <option value="newest" {{ request('orderby') == 'newest' ? 'selected' : '' }}>جدیدترین
                                </option>
                                <option value="lowToHigh" {{ request('orderby') == 'lowToHigh' ? 'selected' : '' }}>قیمت
                                    صعودی</option>
                                <option value="highToLow" {{ request('orderby') == 'highToLow' ? 'selected' : '' }}>قیمت
                                    نزولی</option>
                                <option value="mostPopular" {{ request('orderby') == 'mostPopular' ? 'selected' : '' }}>
                                    محبوب‌ترین</option>
                            </select>
                        </div>

                        {{-- ۵. دکمه ارسال --}}
                        <div class="filter-col p-r-15 p-b-27">
                            <button type="submit"
                                class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                                اعمال فیلتر
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="row isotope-grid">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item category{{ $product->category_id }}">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ Storage::url($product->demo_url) }}" alt="IMG-PRODUCT">
                                <button
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                    data-thumb="{{ Storage::url($product->thumbnail_url) }}"
                                    data-demo="{{ Storage::url($product->demo_url) }}" data-title="{{ $product->title }}"
                                    data-price="{{ number_format($product->price) }} تومان"
                                    data-desc="{{ e($product->description) }}" data-id="{{ $product->id }}">
                                    مشاهده سریع
                                </button>
                            </div>
                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{ route('home.products.show', $product) }}"
                                        class="mtext-106 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $product->title }}
                                    </a>

                                    <span class="stext-105 cl3">
                                        {{ $product->price }} هزار تومان
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    مشاهده بیشتر
                </a>
            </div>
        </div>
    </div>

    <!-- Modal1 -->
    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
        <div class="overlay-modal1 js-hide-modal1"></div>

        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                    <img src="/images/icons/icon-close.png" alt="CLOSE">
                </button>

                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    <div class="item-slick3" data-thumb="">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-l-50 p-t-5 p-lr-0-lg">
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            </h4>
                            <span class="mtext-106 cl2">
                            </span>
                            <p class="stext-102 cl3 p-t-23">
                            </p>
                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="flex-w flex-m respon6-next">
                                        <form id="add-to-cart-form" method="POST"
                                            data-url-template="{{ route('cart.add', ['product' => '__ID__']) }}"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit">افزودن به سبد خرید</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
