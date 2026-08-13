@extends('store.layouts.app')

@section('title', $product->name . ' | أوركيدس')

@section('content')

<style>
    :root {
        --purple: #8b6bb1;
        --purple-dark: #6e4d98;
        --purple-soft: #eee7f6;
        --purple-light: #f8f5fb;

        --ink: #292331;
        --ink-soft: #4a4352;
        --muted: #817b87;

        --white: #ffffff;
        --border: rgba(139, 107, 177, .14);
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        overflow-x: hidden;
        background: #fbf9fd;
        color: var(--ink);
        font-family: 'Tajawal', sans-serif;
    }

    ::selection {
        background: var(--purple);
        color: #fff;
    }

    .font-display {
        font-family: 'El Messiri', serif;
    }

    /* =====================================================
       NAVBAR
    ===================================================== */

    #site-nav {
        background: rgba(255, 255, 255, .95);
        border-bottom: 1px solid rgba(139, 107, 177, .10);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);

        transition:
            box-shadow .3s ease,
            background .3s ease;
    }

    #site-nav.scrolled {
        box-shadow: 0 8px 30px rgba(70, 45, 90, .07);
    }

    .nav-link {
        position: relative;
        color: var(--ink);
        transition: color .25s ease;
    }

    .nav-link:hover {
        color: var(--purple);
    }

    .nav-link::after {
        content: '';

        position: absolute;
        right: 0;
        bottom: -7px;

        width: 0;
        height: 2px;

        border-radius: 999px;
        background: var(--purple);

        transition: width .3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* =====================================================
       CART
    ===================================================== */

    .cart-button {
        position: relative;

        display: flex;

        width: 44px;
        height: 44px;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: var(--purple);
        background: #fff;

        border: 1px solid var(--border);

        transition:
            transform .25s ease,
            background .25s ease;
    }

    .cart-button:hover {
        transform: translateY(-2px);
        background: var(--purple-soft);
    }

    .cart-badge {
        position: absolute;

        top: -5px;
        left: -5px;

        min-width: 20px;
        height: 20px;

        padding: 0 5px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 999px;

        background: var(--purple);
        color: #fff;

        border: 2px solid #fff;

        font-size: 10px;
        font-weight: 800;
    }

    /* =====================================================
       BREADCRUMB
    ===================================================== */

    .breadcrumb {
        color: var(--muted);
    }

    .breadcrumb a {
        color: var(--muted);
        transition: color .25s ease;
    }

    .breadcrumb a:hover {
        color: var(--purple);
    }

    /* =====================================================
       PRODUCT GALLERY
    ===================================================== */

    .product-gallery {
        position: relative;

        background: linear-gradient(
            145deg,
            #faf7fd,
            #f0e9f7
        );

        border: 1px solid var(--border);

        border-radius: 32px;

        overflow: hidden;

        box-shadow:
            0 20px 55px rgba(80, 50, 100, .07);
    }

    .main-media {
        position: relative;
        overflow: hidden;
    }

    .main-media img {
        transition:
            transform 1s cubic-bezier(.16, 1, .3, 1),
            opacity .2s ease;
    }

    .main-media:hover img {
        transform: scale(1.035);
    }

    /* =====================================================
       DISCOUNT
    ===================================================== */

    .discount-badge {
        position: absolute;

        right: 20px;
        top: 20px;

        z-index: 20;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 9px 16px;

        border-radius: 999px;

        background: var(--purple);

        /*
         * مهم:
         * لون النص أبيض بشكل صريح
         */
        color: #ffffff !important;

        font-family: 'Tajawal', sans-serif;
        font-size: 13px;
        font-weight: 800;

        line-height: 1;

        box-shadow:
            0 8px 25px rgba(111, 79, 152, .25);
    }

    /* =====================================================
       THUMBNAILS
    ===================================================== */

    .thumb {
        position: relative;

        overflow: hidden;

        border-radius: 17px;

        background: #fff;

        border: 2px solid transparent;

        transition:
            border-color .25s ease,
            transform .25s ease,
            box-shadow .25s ease;
    }

    .thumb:hover {
        transform: translateY(-2px);

        box-shadow:
            0 8px 20px rgba(70, 45, 90, .07);
    }

    .thumb.active {
        border-color: var(--purple);

        box-shadow:
            0 0 0 3px rgba(139, 107, 177, .10);
    }

    /* =====================================================
       PRODUCT INFO
    ===================================================== */

    .availability {
        display: inline-flex;

        align-items: center;
        gap: 8px;

        padding: 8px 14px;

        border-radius: 999px;

        color: var(--purple-dark);

        background: var(--purple-soft);

        border: 1px solid rgba(139, 107, 177, .13);

        font-size: 12px;
        font-weight: 800;
    }

    .availability-dot {
        width: 7px;
        height: 7px;

        flex-shrink: 0;

        border-radius: 50%;

        background: var(--purple);
    }

    .product-title {
        font-size: clamp(2.3rem, 5vw, 4rem);
        line-height: 1.2;
        color: var(--ink);
    }

    .stars {
        color: var(--purple);
        letter-spacing: 3px;
    }

    .description {
        color: rgba(41, 35, 49, .68);
        line-height: 2;
        font-size: 15px;
    }

    /* =====================================================
       PRICE
    ===================================================== */

    .current-price {
        color: var(--purple);

        font-family: 'El Messiri', serif;

        font-size: 42px;

        font-weight: 700;
    }

    .old-price {
        color: #9d98a2;

        font-size: 17px;

        text-decoration: line-through;
    }

    /* =====================================================
       DIVIDER
    ===================================================== */

    .soft-divider {
        height: 1px;
        background: rgba(41, 35, 49, .08);
    }

    /* =====================================================
       QUANTITY
    ===================================================== */

    .quantity-control {
        display: flex;

        width: 170px;
        height: 54px;

        align-items: center;

        overflow: hidden;

        border-radius: 999px;

        background: #fff;

        border: 1px solid var(--border);

        box-shadow:
            0 6px 20px rgba(70, 45, 90, .04);
    }

    .quantity-button {
        width: 50px;
        height: 100%;

        display: flex;

        align-items: center;
        justify-content: center;

        color: var(--purple);

        background: transparent;

        border: 0;

        font-size: 20px;
        font-weight: 700;

        cursor: pointer;

        transition:
            background .2s ease,
            color .2s ease;
    }

    .quantity-button:hover {
        background: var(--purple-soft);
        color: var(--purple-dark);
    }

    .qty-input {
        width: 70px;
        height: 100%;

        text-align: center;

        background: transparent;

        border: 0;
        outline: none;

        color: var(--ink);

        font-weight: 800;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .qty-input {
        -moz-appearance: textfield;
    }

    /* =====================================================
       BUTTONS
    ===================================================== */

    .btn-primary,
    .btn-secondary {
        position: relative;

        display: flex;

        width: 100%;

        min-height: 54px;

        align-items: center;
        justify-content: center;

        gap: 9px;

        padding: 15px 20px;

        border-radius: 999px;

        font-family: 'Tajawal', sans-serif;
        font-size: 14px;
        font-weight: 800;

        cursor: pointer;

        transition:
            transform .25s ease,
            box-shadow .25s ease,
            background .25s ease,
            color .25s ease,
            border-color .25s ease;
    }

    /* ADD TO CART */

    .btn-secondary {
        background: #ffffff;
        color: var(--purple-dark);

        border: 1px solid rgba(139, 107, 177, .30);

        box-shadow:
            0 8px 20px rgba(70, 45, 90, .04);
    }

    .btn-secondary:hover {
        background: var(--purple-soft);
        color: var(--purple-dark);

        border-color: var(--purple);

        transform: translateY(-2px);

        box-shadow:
            0 12px 25px rgba(111, 79, 152, .10);
    }

    .btn-secondary svg {
        color: var(--purple);
    }

    /* BUY NOW */

    .btn-primary {
        background: var(--purple);
        color: #ffffff !important;

        border: 1px solid var(--purple);

        box-shadow:
            0 12px 25px rgba(111, 79, 152, .20);
    }

    .btn-primary:hover {
        background: var(--purple-dark);
        color: #ffffff !important;

        border-color: var(--purple-dark);

        transform: translateY(-2px);

        box-shadow:
            0 16px 30px rgba(111, 79, 152, .28);
    }

    .btn-primary span {
        color: #ffffff;
    }

    .btn-primary:active,
    .btn-secondary:active {
        transform: translateY(0);
    }

    /* =====================================================
       TRUST CARDS
    ===================================================== */

    .trust-card {
        padding: 15px 10px;

        text-align: center;

        border-radius: 18px;

        background: #fff;

        border: 1px solid rgba(139, 107, 177, .10);

        box-shadow:
            0 8px 25px rgba(70, 45, 90, .04);

        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .trust-card:hover {
        transform: translateY(-3px);

        box-shadow:
            0 12px 30px rgba(70, 45, 90, .07);
    }

    .trust-icon {
        width: 40px;
        height: 40px;

        margin: auto;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background: var(--purple-soft);
        color: var(--purple);
    }

    .trust-title {
        margin-top: 9px;

        font-family: 'El Messiri', serif;

        font-size: 11px;

        font-weight: 700;

        color: var(--ink);
    }

    /* =====================================================
       REVEAL
    ===================================================== */

    [data-fade] {
        opacity: 0;
        transform: translateY(25px);
    }

    /* =====================================================
       MOBILE
    ===================================================== */

    @media (max-width: 767px) {

        .product-title {
            font-size: 2.4rem;
        }

        .current-price {
            font-size: 36px;
        }

        .product-gallery {
            border-radius: 24px;
        }

        .main-media > div {
            aspect-ratio: 1 / 1;
        }

        .discount-badge {
            right: 14px;
            top: 14px;

            padding: 8px 13px;

            font-size: 12px;
        }

        .quantity-control {
            width: 150px;
        }

        .quantity-button {
            width: 45px;
        }

        .qty-input {
            width: 60px;
        }

        .btn-primary,
        .btn-secondary {
            min-height: 52px;
        }
    }
</style>


{{-- =========================================================
     BREADCRUMB
========================================================= --}}

<div class="mx-auto max-w-7xl px-5 pt-8 sm:px-8 lg:px-12">

    <nav class="breadcrumb flex items-center gap-2 text-sm">

        <a
            href="{{ route('store.index') }}"
            class="transition"
        >
            المنتجات
        </a>

        <span class="opacity-40">
            /
        </span>

        <span class="font-medium text-[var(--ink)]">
            {{ $product->name }}
        </span>

    </nav>

</div>


{{-- =========================================================
     PRODUCT
========================================================= --}}

<main class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:px-12 lg:py-14">

    <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">

        {{-- =================================================
             GALLERY
        ================================================== --}}

        <div data-fade>

            <div class="product-gallery">

                {{-- DISCOUNT --}}

                @if($product->discount_price)

                    @php
                        $discount = $product->price > 0
                            ? round(
                                (($product->price - $product->discount_price)
                                / $product->price) * 100
                            )
                            : 0;
                    @endphp

                    <div class="discount-badge">
                        خصم {{ $discount }}٪
                    </div>

                @endif


                {{-- MAIN IMAGE --}}

                @if($product->images->count())

                    <div class="main-media">

                        <div class="flex aspect-square items-center justify-center overflow-hidden">

                            <img
                                id="mainProductImage"
                                src="{{ asset('storage/' . $product->images->first()->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                            >

                        </div>

                    </div>

                @else

                    <div class="flex aspect-square items-center justify-center text-[var(--muted)]">

                        لا توجد صورة

                    </div>

                @endif

            </div>


            {{-- THUMBNAILS --}}

            @if($product->images->count() > 1)

                <div class="mt-4 flex gap-3 overflow-x-auto pb-2">

                    @foreach($product->images as $index => $image)

                        <button
                            type="button"
                            onclick="changeProductImage(
                                '{{ asset('storage/' . $image->image) }}',
                                this
                            )"
                            class="product-thumbnail thumb {{ $index === 0 ? 'active' : '' }} h-20 w-20 flex-shrink-0"
                        >

                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                            >

                        </button>

                    @endforeach

                </div>

            @endif

        </div>


        {{-- =================================================
             PRODUCT INFO
        ================================================== --}}

        <div data-fade class="flex flex-col justify-center">

            {{-- AVAILABILITY --}}

            <div class="mb-5">

                <span class="availability">

                    <span class="availability-dot"></span>

                    متوفر الآن

                </span>

            </div>


            {{-- TITLE --}}

            <h1 class="product-title font-display font-bold tracking-tight">

                {{ $product->name }}

            </h1>


            {{-- RATING --}}

            <div class="mt-5 flex items-center gap-3">

                <div class="stars text-base">
                    ★★★★★
                </div>

                <span class="text-sm text-[var(--muted)]">
                    منتج مختار بعناية
                </span>

            </div>


            {{-- DESCRIPTION --}}

            @if($product->description)

                <div class="description mt-6">

                    {!! nl2br(e($product->description)) !!}

                </div>

            @endif


            {{-- PRICE --}}

            <div class="mt-7 flex items-end gap-4">

                @if($product->discount_price)

                    <span class="current-price">

                        ${{ number_format($product->discount_price, 2) }}

                    </span>

                    <span class="old-price pb-1.5">

                        ${{ number_format($product->price, 2) }}

                    </span>

                @else

                    <span class="current-price">

                        ${{ number_format($product->price, 2) }}

                    </span>

                @endif

            </div>


            <div class="soft-divider my-8"></div>


            {{-- QUANTITY --}}

            <div>

                <label class="mb-3 block text-sm font-bold">

                    الكمية

                </label>


                <div class="quantity-control">

                    <button
                        type="button"
                        onclick="changeQuantity(-1)"
                        class="quantity-button"
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
                        class="qty-input"
                    >


                    <button
                        type="button"
                        onclick="changeQuantity(1)"
                        class="quantity-button"
                        aria-label="زيادة الكمية"
                    >
                        +
                    </button>

                </div>

            </div>


            {{-- ACTIONS --}}

            <div class="mt-7 grid gap-3 sm:grid-cols-2">

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
                        class="btn-secondary"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4"
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
                        class="btn-primary"
                    >

                        <span>
                            اشترِ الآن
                        </span>

                        <span>
                            ←
                        </span>

                    </button>

                </form>

            </div>


            {{-- TRUST --}}

            <div class="mt-8 grid gap-3 sm:grid-cols-3">

                {{-- SECURE PAYMENT --}}

                <div class="trust-card">

                    <div class="trust-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
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

                    <p class="trust-title">
                        دفع آمن
                    </p>

                </div>


                {{-- SHIPPING --}}

                <div class="trust-card">

                    <div class="trust-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 7h11v10H3zM14 10h4l3 3v4h-7z"
                            />

                        </svg>

                    </div>

                    <p class="trust-title">
                        شحن سريع
                    </p>

                </div>


                {{-- QUALITY --}}

                <div class="trust-card">

                    <div class="trust-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.563.563 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                            />

                        </svg>

                    </div>

                    <p class="trust-title">
                        جودة مضمونة
                    </p>

                </div>

            </div>

        </div>

    </div>

</main>


{{-- =========================================================
     SCRIPTS
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | NAVBAR
    |--------------------------------------------------------------------------
    */

    const nav = document.getElementById('site-nav');

    function updateNavbar() {

        if (!nav) {
            return;
        }

        if (window.scrollY > 20) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }

    window.addEventListener(
        'scroll',
        updateNavbar,
        { passive: true }
    );

    updateNavbar();


    /*
    |--------------------------------------------------------------------------
    | GSAP ANIMATION
    |--------------------------------------------------------------------------
    */

    const g = window.gsap;

    if (g && window.ScrollTrigger) {

        g.registerPlugin(window.ScrollTrigger);

        g.utils
            .toArray('[data-fade]')
            .forEach((el, i) => {

                g.to(el, {

                    opacity: 1,

                    y: 0,

                    duration: .9,

                    ease: 'power3.out',

                    delay: i * .08,

                    scrollTrigger: {

                        trigger: el,

                        start: 'top 90%'

                    }

                });

            });

    } else {

        document
            .querySelectorAll('[data-fade]')
            .forEach(el => {

                el.style.opacity = 1;
                el.style.transform = 'none';

            });

    }

});


/*
|--------------------------------------------------------------------------
| CHANGE PRODUCT IMAGE
|--------------------------------------------------------------------------
*/

function changeProductImage(url, button) {

    const mainImage =
        document.getElementById('mainProductImage');

    if (mainImage) {

        mainImage.style.opacity = 0;

        setTimeout(() => {

            mainImage.src = url;

            mainImage.style.opacity = 1;

        }, 150);

    }

    document
        .querySelectorAll('.product-thumbnail')
        .forEach(item => {

            item.classList.remove('active');

        });

    if (button) {
        button.classList.add('active');
    }
}


/*
|--------------------------------------------------------------------------
| SYNC QUANTITY
|--------------------------------------------------------------------------
*/

function syncQuantity(quantity) {

    const cartQuantity =
        document.getElementById('cartQuantity');

    const buyNowQuantity =
        document.getElementById('buyNowQuantity');

    if (cartQuantity) {
        cartQuantity.value = quantity;
    }

    if (buyNowQuantity) {
        buyNowQuantity.value = quantity;
    }
}


/*
|--------------------------------------------------------------------------
| CHANGE QUANTITY
|--------------------------------------------------------------------------
*/

function changeQuantity(amount) {

    const input =
        document.getElementById('quantity');

    if (!input) {
        return;
    }

    let quantity =
        parseInt(input.value) || 1;

    quantity += amount;

    quantity =
        Math.max(
            1,
            Math.min(100, quantity)
        );

    input.value = quantity;

    syncQuantity(quantity);
}


/*
|--------------------------------------------------------------------------
| MANUAL QUANTITY INPUT
|--------------------------------------------------------------------------
*/

document
    .getElementById('quantity')
    ?.addEventListener(
        'input',
        function () {

            let quantity =
                parseInt(this.value) || 1;

            quantity =
                Math.max(
                    1,
                    Math.min(100, quantity)
                );

            this.value = quantity;

            syncQuantity(quantity);

        }
    );
</script>

@endsection
