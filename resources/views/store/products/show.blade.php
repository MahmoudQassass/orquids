@extends('store.layouts.app')

@section('title', $product->name . ' — أوركيدس')

@section('meta_description')
    {{ \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160) }}
@endsection

@section('og_title')
    {{ $product->name }} — أوركيدس
@endsection

@section('og_description')
    {{ \Illuminate\Support\Str::limit(strip_tags($product->description ?? 'اكتشف هذا المنتج المميز من أوركيدس.'), 200) }}
@endsection

@section('og_url')
    {{ url()->current() }}
@endsection

@section('og_type')
    product
@endsection

@section('og_image')
    {{ $product->images->first()?->image ?? asset('assets/images/logo-or.png') }}
@endsection

@section('og_image_alt')
    {{ $product->name }}
@endsection

@section('styles')

<style>
/* =========================================================
   ORQUIDS PRODUCT PAGE
========================================================= */

:root {
    --product-purple: #8b6bb1;
    --product-purple-dark: #6f4f98;
    --product-purple-soft: #eee7f6;

    --product-ink: #292331;
    --product-muted: #77717f;

    --product-border: rgba(139, 107, 177, 0.16);
}

/* =========================================================
   PAGE
========================================================= */

.product-page {
    min-height: 100vh;
    background: #fbf9fd;
    color: var(--product-ink);
    direction: rtl;
}

.product-page *,
.product-page *::before,
.product-page *::after {
    box-sizing: border-box;
}

/* =========================================================
   BREADCRUMB
========================================================= */

.product-breadcrumb {
    color: var(--product-muted);
    direction: rtl;
}

.product-breadcrumb a {
    color: var(--product-muted);
    text-decoration: none;
    transition: color .2s ease;
}

.product-breadcrumb a:hover {
    color: var(--product-purple);
}

.product-breadcrumb span {
    color: var(--product-ink);
}

/* =========================================================
   GALLERY
========================================================= */

.product-gallery {
    position: relative;
    overflow: hidden;

    background: linear-gradient(
        145deg,
        #faf7fd 0%,
        #f0e9f7 100%
    );

    border: 1px solid var(--product-border);
    border-radius: 22px;

    box-shadow:
        0 12px 35px rgba(70, 45, 90, .07);
}

.product-main-media {
    position: relative;
    overflow: hidden;
}

.product-main-media img {
    display: block;

    transition:
        transform .6s cubic-bezier(.16, 1, .3, 1),
        opacity .2s ease;
}

.product-main-media:hover img {
    transform: scale(1.025);
}

/* =========================================================
   DISCOUNT
========================================================= */

.product-discount {
    position: absolute;

    top: 14px;
    right: 14px;

    z-index: 30;

    display: inline-flex !important;

    align-items: center !important;
    justify-content: center !important;

    direction: rtl !important;

    min-width: max-content !important;

    padding: 7px 13px !important;

    border-radius: 999px !important;

    background: #8b6bb1 !important;
    background-color: #8b6bb1 !important;

    color: #ffffff !important;

    font-family: inherit !important;

    font-size: 12px !important;

    line-height: 1.2 !important;

    font-weight: 800 !important;

    white-space: nowrap !important;

    text-align: center !important;

    box-shadow:
        0 7px 20px rgba(111, 79, 152, .18) !important;
}

.product-discount * {
    color: #ffffff !important;
}

/* =========================================================
   THUMBNAILS
========================================================= */

.product-thumbnails {
    display: flex;

    gap: 9px;

    overflow-x: auto;

    padding: 4px 2px 6px;

    scrollbar-width: thin;

    scrollbar-color:
        var(--product-purple)
        transparent;
}

.product-thumbnail {
    position: relative;

    flex: 0 0 auto;

    width: 64px;
    height: 64px;

    overflow: hidden;

    padding: 0;

    border: 2px solid transparent;

    border-radius: 13px;

    background: #ffffff;

    cursor: pointer;

    transition:
        border-color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.product-thumbnail:hover {
    transform: translateY(-1px);

    box-shadow:
        0 6px 16px rgba(70, 45, 90, .08);
}

.product-thumbnail.active {
    border-color: var(--product-purple);

    box-shadow:
        0 0 0 2px rgba(139, 107, 177, .12);
}

.product-thumbnail img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}

/* =========================================================
   AVAILABILITY
========================================================= */

.product-availability {
    display: inline-flex !important;

    align-items: center !important;
    justify-content: center !important;

    direction: rtl !important;

    gap: 7px !important;

    min-height: 30px !important;

    padding: 6px 12px !important;

    border-radius: 999px !important;

    background: #eee7f6 !important;
    background-color: #eee7f6 !important;

    color: #6f4f98 !important;

    border: 1px solid #d9cce8 !important;

    font-family: inherit !important;

    font-size: 12px !important;

    line-height: 1 !important;

    font-weight: 800 !important;

    white-space: nowrap !important;
}

.product-availability-dot {
    display: block !important;

    width: 7px !important;
    height: 7px !important;

    min-width: 7px !important;
    min-height: 7px !important;

    flex: 0 0 7px !important;

    border-radius: 50% !important;

    background: #8b6bb1 !important;
}

/* =========================================================
   PRODUCT INFO
========================================================= */

.product-title {
    margin: 0;

    color: #292331 !important;

    font-family: 'El Messiri', serif;

    font-size: clamp(
        1.9rem,
        4vw,
        3rem
    );

    line-height: 1.3;

    font-weight: 700;

    letter-spacing: -0.02em;

    direction: rtl;

    text-align: right;
}

.product-stars {
    color: #8b6bb1 !important;

    font-size: 14px;

    letter-spacing: 2px;

    line-height: 1;
}

.product-description {
    max-width: 650px;

    color: #5f5967 !important;

    font-size: 14px;

    line-height: 1.9;

    direction: rtl;

    text-align: right;
}

/* =========================================================
   PRICE
========================================================= */

.product-price-row {
    display: flex;

    align-items: baseline;

    justify-content: flex-start;

    flex-wrap: wrap;

    gap: 10px;

    direction: rtl;
}

.product-current-price {
    color: #8b6bb1 !important;

    font-family: 'El Messiri', serif;

    font-size: 34px;

    line-height: 1;

    font-weight: 700;
}

.product-old-price {
    color: #99939f !important;

    font-size: 15px;

    text-decoration: line-through;
}

/* =========================================================
   DIVIDER
========================================================= */

.product-divider {
    width: 100%;

    height: 1px;

    background: rgba(41, 35, 49, .07);
}

/* =========================================================
   QUANTITY
========================================================= */

.product-quantity {
    display: flex;

    width: 145px;
    height: 46px;

    align-items: center;

    overflow: hidden;

    border: 1px solid var(--product-border);

    border-radius: 13px;

    background: #ffffff;

    box-shadow:
        0 5px 16px rgba(70, 45, 90, .04);

    direction: ltr;
}

.product-quantity-button {
    width: 43px;
    height: 100%;

    flex: 0 0 43px;

    display: flex;

    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0 !important;

    background: transparent !important;

    color: #8b6bb1 !important;

    cursor: pointer;

    font-family: inherit;

    font-size: 19px;

    font-weight: 700;

    transition:
        background .2s ease,
        color .2s ease;
}

.product-quantity-button:hover {
    background: #eee7f6 !important;

    color: #6f4f98 !important;
}

.product-quantity-input {
    width: 59px;
    height: 100%;

    padding: 0;

    border: 0 !important;

    outline: none !important;

    background: transparent !important;

    color: #292331 !important;

    text-align: center;

    font-family: inherit;

    font-weight: 800;
}

.product-quantity-input::-webkit-outer-spin-button,
.product-quantity-input::-webkit-inner-spin-button {
    margin: 0;

    -webkit-appearance: none;
}

.product-quantity-input {
    -moz-appearance: textfield;
}

/* =========================================================
   ACTION BUTTONS
========================================================= */

.product-actions {
    direction: rtl;
}

.product-action-button {
    appearance: none !important;
    -webkit-appearance: none !important;

    position: relative;

    display: flex !important;

    width: 100% !important;

    min-height: 48px !important;

    align-items: center !important;
    justify-content: center !important;

    gap: 8px !important;

    padding: 11px 17px !important;

    border-radius: 13px !important;

    font-family: inherit !important;

    font-size: 13px !important;

    font-weight: 800 !important;

    line-height: 1.2 !important;

    text-decoration: none !important;

    cursor: pointer;

    opacity: 1 !important;

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease,
        color .2s ease,
        border-color .2s ease;
}

.product-action-button span,
.product-action-button svg {
    color: inherit !important;
}

.product-action-button:hover,
.product-action-button:focus,
.product-action-button:active {
    text-decoration: none !important;
}

/* =========================================================
   ADD TO CART
========================================================= */

.product-add-button {
    background: #ffffff !important;
    background-color: #ffffff !important;

    color: #6f4f98 !important;

    border: 1px solid #cdbde0 !important;

    box-shadow:
        0 6px 18px rgba(70, 45, 90, .04) !important;
}

.product-add-button:hover,
.product-add-button:focus,
.product-add-button:active {
    background: #eee7f6 !important;
    background-color: #eee7f6 !important;

    color: #6f4f98 !important;

    border-color: #8b6bb1 !important;

    transform: translateY(-1px);
}

/* =========================================================
   BUY NOW
========================================================= */

.product-buy-button {
    background: #8b6bb1 !important;
    background-color: #8b6bb1 !important;

    color: #ffffff !important;

    border: 1px solid #8b6bb1 !important;

    box-shadow:
        0 8px 20px rgba(111, 79, 152, .18) !important;
}

.product-buy-button:hover,
.product-buy-button:focus,
.product-buy-button:active {
    background: #6f4f98 !important;
    background-color: #6f4f98 !important;

    color: #ffffff !important;

    border-color: #6f4f98 !important;

    transform: translateY(-1px);

    box-shadow:
        0 11px 25px rgba(111, 79, 152, .22) !important;
}

/* =========================================================
   FOCUS
========================================================= */

.product-action-button:focus-visible,
.product-quantity-button:focus-visible,
.product-thumbnail:focus-visible {
    outline: 3px solid rgba(139, 107, 177, .22) !important;

    outline-offset: 2px;
}

/* =========================================================
   TRUST CARDS
========================================================= */

.product-trust-card {
    padding: 11px 8px;

    text-align: center;

    border: 1px solid rgba(139, 107, 177, .10);

    border-radius: 14px;

    background: #ffffff;

    box-shadow:
        0 6px 18px rgba(70, 45, 90, .035);

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.product-trust-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 9px 22px rgba(70, 45, 90, .06);
}

.product-trust-icon {
    width: 34px;
    height: 34px;

    margin: auto;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #eee7f6;

    color: #8b6bb1;
}

.product-trust-icon svg {
    color: #8b6bb1 !important;
}

.product-trust-title {
    margin: 7px 0 0;

    color: #292331;

    font-family: 'El Messiri', serif;

    font-size: 10px;

    line-height: 1.3;

    font-weight: 700;
}

/* =========================================================
   ANIMATION
========================================================= */

[data-product-fade] {
    opacity: 0;

    transform: translateY(18px);
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 767px) {

    .product-page {
        overflow-x: hidden;
    }

    .product-title {
        font-size: 2rem;
    }

    .product-current-price {
        font-size: 30px;
    }

    .product-gallery {
        border-radius: 18px;
    }

    .product-main-media > div {
        aspect-ratio: 1 / 1;
    }

    .product-thumbnail {
        width: 58px;
        height: 58px;
    }

    .product-quantity {
        width: 140px;
        height: 44px;
    }

    .product-actions {
        grid-template-columns: 1fr !important;
    }

    .product-trust-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .product-trust-card {
        padding: 10px 5px;
    }

    .product-discount {
        top: 10px !important;
        right: 10px !important;

        padding: 6px 11px !important;

        font-size: 11px !important;
    }

    .product-availability {
        font-size: 11px !important;

        padding: 6px 10px !important;
    }
}

@media (max-width: 480px) {

    .product-title {
        font-size: 1.8rem;
    }

    .product-current-price {
        font-size: 28px;
    }

    .product-description {
        font-size: 13px;

        line-height: 1.85;
    }

    .product-trust-grid {
        gap: 6px !important;
    }

    .product-trust-card {
        border-radius: 12px;
    }

    .product-trust-icon {
        width: 32px;
        height: 32px;

        border-radius: 9px;
    }

    .product-trust-icon svg {
        width: 16px;
        height: 16px;
    }
}
</style>

@endsection


@section('content')

<div class="h-16"></div>

<div class="product-page">

    {{-- =====================================================
         BREADCRUMB
    ====================================================== --}}

    <div class="mx-auto max-w-7xl px-5 pt-4 sm:px-7 lg:px-10 lg:pt-5">

        <nav
            class="product-breadcrumb flex flex-wrap items-center gap-2 text-xs sm:text-sm"
            aria-label="مسار التنقل"
        >

            <a
                href="{{ route('store.index') }}"
            >
                المنتجات
            </a>

            <span class="opacity-40">
                /
            </span>

            <span class="font-medium">
                {{ $product->name }}
            </span>

        </nav>

    </div>


    {{-- =====================================================
         PRODUCT
    ====================================================== --}}

    <main
        class="mx-auto max-w-7xl px-5 py-5 sm:px-7 sm:py-7 lg:px-10 lg:py-9"
    >

        <div
            class="grid items-start gap-7 lg:grid-cols-2 lg:gap-10"
        >

            {{-- =================================================
                 GALLERY
            ================================================== --}}

            <section data-product-fade>

                <div class="product-gallery">

                    {{-- DISCOUNT --}}

                    @if($product->discount_price)

                        @php
                            $discount = $product->price > 0
                                ? round(
                                    (
                                        ($product->price - $product->discount_price)
                                        / $product->price
                                    ) * 100
                                )
                                : 0;
                        @endphp

                        @if($discount > 0)

                            <div class="product-discount">
                                خصم {{ $discount }}٪
                            </div>

                        @endif

                    @endif


                    {{-- MAIN IMAGE --}}

                    @if($product->images->count())

                        <div class="product-main-media">

                            <div
                                class="flex aspect-square items-center justify-center overflow-hidden"
                            >

                                <img
                                    id="mainProductImage"
                                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover"
                                    loading="eager"
                                >

                            </div>

                        </div>

                    @else

                        <div
                            class="flex aspect-square items-center justify-center text-sm text-[var(--product-muted)]"
                        >
                            لا توجد صورة لهذا المنتج
                        </div>

                    @endif

                </div>


                {{-- THUMBNAILS --}}

                @if($product->images->count() > 1)

                    <div class="product-thumbnails mt-3">

                        @foreach($product->images as $index => $image)

                            <button
                                type="button"
                                class="product-thumbnail {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeProductImage(
                                    @js(asset('storage/' . $image->image)),
                                    this
                                )"
                                aria-label="عرض صورة {{ $index + 1 }}"
                            >

                                <img
                                    src="{{ asset('storage/' . $image->image) }}"
                                    alt="{{ $product->name }} - صورة {{ $index + 1 }}"
                                    loading="lazy"
                                >

                            </button>

                        @endforeach

                    </div>

                @endif

            </section>


            {{-- =================================================
                 PRODUCT INFORMATION
            ================================================== --}}

            <section
                data-product-fade
                class="flex flex-col justify-center"
            >

                {{-- AVAILABILITY --}}

                <div class="mb-3">

                    <span class="product-availability">

                        <span class="product-availability-dot"></span>

                        <span>متوفر الآن</span>

                    </span>

                </div>


                {{-- TITLE --}}

                <h1 class="product-title">
                    {{ $product->name }}
                </h1>


                {{-- RATING --}}

                <div class="mt-3 flex flex-wrap items-center gap-2">

                    <div
                        class="product-stars"
                        aria-label="تقييم ممتاز"
                    >
                        ★★★★★
                    </div>

                    <span class="text-xs text-[var(--product-muted)] sm:text-sm">
                        منتج مختار بعناية
                    </span>

                </div>


                {{-- DESCRIPTION --}}

                @if($product->description)

                    <div class="product-description mt-4">

                        {!! nl2br(e($product->description)) !!}

                    </div>

                @endif


                {{-- PRICE --}}

                <div class="product-price-row mt-5">

                    @if($product->discount_price)

                        <span class="product-current-price">
                            ${{ number_format($product->discount_price, 2) }}
                        </span>

                        <span class="product-old-price">
                            ${{ number_format($product->price, 2) }}
                        </span>

                    @else

                        <span class="product-current-price">
                            ${{ number_format($product->price, 2) }}
                        </span>

                    @endif

                </div>


                {{-- DIVIDER --}}

                <div class="product-divider my-5"></div>


                {{-- QUANTITY --}}

                <div>

                    <label
                        for="quantity"
                        class="mb-2 block text-xs font-bold sm:text-sm"
                    >
                        الكمية
                    </label>

                    <div class="product-quantity">

                        <button
                            type="button"
                            class="product-quantity-button"
                            onclick="changeQuantity(-1)"
                            aria-label="إنقاص الكمية"
                        >
                            −
                        </button>

                        <input
                            id="quantity"
                            type="number"
                            value="1"
                            min="1"
                            max="100"
                            inputmode="numeric"
                            class="product-quantity-input"
                            aria-label="الكمية"
                        >

                        <button
                            type="button"
                            class="product-quantity-button"
                            onclick="changeQuantity(1)"
                            aria-label="زيادة الكمية"
                        >
                            +
                        </button>

                    </div>

                </div>


                {{-- ACTIONS --}}

                <div
                    class="product-actions mt-5 grid gap-2 sm:grid-cols-2"
                >

                    {{-- ADD TO CART --}}

                    <form
                        action="{{ route('cart.add', $product) }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            id="cartQuantity"
                            type="hidden"
                            name="quantity"
                            value="1"
                        >

                        <button
                            type="submit"
                            class="product-action-button product-add-button"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-5 w-5"
                                aria-hidden="true"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 15.75a2.25 2.25 0 002.184 1.7h7.132a2.25 2.25 0 002.184-1.7l1.644-6.578a.75.75 0 00-.728-.932H5.106"
                                />

                            </svg>

                            <span>
                                أضف إلى السلة
                            </span>

                        </button>

                    </form>


                    {{-- BUY NOW --}}

                    <form
                        action="{{ route('store.buyNow') }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="product_id"
                            value="{{ $product->id }}"
                        >

                        <input
                            id="buyNowQuantity"
                            type="hidden"
                            name="quantity"
                            value="1"
                        >

                        <button
                            type="submit"
                            class="product-action-button product-buy-button"
                        >

                            <span>
                                اشترِ الآن
                            </span>

                            <span aria-hidden="true">
                                ←
                            </span>

                        </button>

                    </form>

                </div>


                {{-- TRUST CARDS --}}

                <div
                    class="product-trust-grid mt-5 grid grid-cols-3 gap-2"
                >

                    {{-- SECURE PAYMENT --}}

                    <div class="product-trust-card">

                        <div class="product-trust-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                                aria-hidden="true"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4"
                                />

                            </svg>

                        </div>

                        <p class="product-trust-title">
                            دفع آمن
                        </p>

                    </div>


                    {{-- SHIPPING --}}

                    <div class="product-trust-card">

                        <div class="product-trust-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                                aria-hidden="true"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 7h11v10H3zM14 10h4l3 3v4h-7z"
                                />

                            </svg>

                        </div>

                        <p class="product-trust-title">
                            شحن سريع
                        </p>

                    </div>


                    {{-- QUALITY --}}

                    <div class="product-trust-card">

                        <div class="product-trust-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                                aria-hidden="true"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.563.563 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                                />

                            </svg>

                        </div>

                        <p class="product-trust-title">
                            جودة مضمونة
                        </p>

                    </div>

                </div>

            </section>

        </div>

    </main>

</div>

@endsection


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       PRODUCT ANIMATION
    ===================================================== */

    const fadeElements =
        document.querySelectorAll('[data-product-fade]');

    const gsapInstance = window.gsap;
    const scrollTriggerInstance = window.ScrollTrigger;

    if (gsapInstance && scrollTriggerInstance) {

        gsapInstance.registerPlugin(
            scrollTriggerInstance
        );

        gsapInstance
            .utils
            .toArray('[data-product-fade]')
            .forEach(function (element, index) {

                gsapInstance.to(element, {

                    opacity: 1,

                    y: 0,

                    duration: 0.65,

                    delay: index * 0.06,

                    ease: 'power3.out',

                    scrollTrigger: {

                        trigger: element,

                        start: 'top 92%',

                        once: true

                    }

                });

            });

    } else {

        fadeElements.forEach(function (element) {

            element.style.opacity = '1';

            element.style.transform = 'none';

        });

    }


    /* =====================================================
       QUANTITY INPUT
    ===================================================== */

    const quantityInput =
        document.getElementById('quantity');

    if (quantityInput) {

        quantityInput.addEventListener(
            'input',
            function () {

                let quantity =
                    parseInt(this.value, 10);

                if (isNaN(quantity)) {
                    quantity = 1;
                }

                quantity = Math.max(
                    1,
                    Math.min(100, quantity)
                );

                this.value = quantity;

                syncQuantity(quantity);

            }
        );


        quantityInput.addEventListener(
            'blur',
            function () {

                let quantity =
                    parseInt(this.value, 10);

                if (
                    isNaN(quantity) ||
                    quantity < 1
                ) {
                    quantity = 1;
                }

                quantity = Math.min(
                    100,
                    quantity
                );

                this.value = quantity;

                syncQuantity(quantity);

            }
        );

    }

});


/* =========================================================
   CHANGE PRODUCT IMAGE
========================================================= */

function changeProductImage(url, button) {

    const mainImage =
        document.getElementById(
            'mainProductImage'
        );

    if (!mainImage) {
        return;
    }

    mainImage.style.opacity = '0';

    setTimeout(function () {

        mainImage.src = url;

        mainImage.onload = function () {
            mainImage.style.opacity = '1';
        };

        if (mainImage.complete) {
            mainImage.style.opacity = '1';
        }

    }, 150);


    document
        .querySelectorAll('.product-thumbnail')
        .forEach(function (thumbnail) {

            thumbnail.classList.remove('active');

        });


    if (button) {
        button.classList.add('active');
    }

}


/* =========================================================
   SYNC QUANTITY
========================================================= */

function syncQuantity(quantity) {

    const cartQuantity =
        document.getElementById(
            'cartQuantity'
        );

    const buyNowQuantity =
        document.getElementById(
            'buyNowQuantity'
        );


    if (cartQuantity) {
        cartQuantity.value = quantity;
    }

    if (buyNowQuantity) {
        buyNowQuantity.value = quantity;
    }

}


/* =========================================================
   CHANGE QUANTITY
========================================================= */

function changeQuantity(amount) {

    const input =
        document.getElementById(
            'quantity'
        );

    if (!input) {
        return;
    }


    let quantity =
        parseInt(input.value, 10);

    if (isNaN(quantity)) {
        quantity = 1;
    }


    quantity += amount;


    quantity = Math.max(
        1,
        Math.min(100, quantity)
    );


    input.value = quantity;

    syncQuantity(quantity);

}
</script>

@endsection
