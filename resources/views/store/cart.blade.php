@extends('store.layouts.app')

@section('title', 'سلة التسوق — أوركيدس')

@section('meta_description', 'راجع منتجاتك وأكمل طلبك بسهولة من سلة التسوق في أوركيدس.')

@section('styles')

<style>
    /* =========================
       CART PAGE
    ========================= */

    .breadcrumb {
        color: var(--muted);
    }

    .breadcrumb a {
        transition: color .25s ease;
    }

    .breadcrumb a:hover {
        color: var(--purple);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--muted);
        transition: color .25s ease;
    }

    .back-link:hover {
        color: var(--purple);
    }

    .count-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 999px;
        background: var(--purple-soft);
        color: var(--purple-dark);
        font-size: 12px;
        font-weight: 700;
    }

    .count-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--purple);
    }

    /* =========================
       SUCCESS
    ========================= */

    .success-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 18px;
        border-radius: 16px;
        background: #f1eaf8;
        border: 1px solid rgba(139,107,177,.18);
        color: var(--text);
    }

    .success-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--purple);
        color: white;
    }

    /* =========================
       EMPTY CART
    ========================= */

    .empty-cart {
        background: white;
        border: 1px solid rgba(139,107,177,.10);
        border-radius: 28px;
        padding: 70px 25px;
        text-align: center;
        box-shadow: 0 12px 40px rgba(80,50,100,.05);
    }

    .empty-icon {
        width: 82px;
        height: 82px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--purple-soft);
        color: var(--purple);
    }

    /* =========================
       CART ITEM
    ========================= */

    .cart-item {
        background: white;
        border: 1px solid rgba(40,30,50,.07);
        border-radius: 24px;
        padding: 18px;
        box-shadow: 0 10px 35px rgba(70,45,90,.04);

        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }

    .cart-item:hover {
        transform: translateY(-2px);
        border-color: rgba(139,107,177,.16);
        box-shadow: 0 15px 40px rgba(70,45,90,.07);
    }

    .product-image {
        width: 150px;
        height: 150px;
        flex-shrink: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        background: var(--purple-light);
        border: 1px solid rgba(139,107,177,.08);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-name {
        color: var(--text);
        transition: color .25s ease;
    }

    .product-name:hover {
        color: var(--purple);
    }

    /* =========================
       REMOVE
    ========================= */

    .remove-button {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: white;
        color: #aaa3af;
        border: 1px solid rgba(40,30,50,.08);
        transition: all .25s ease;
        cursor: pointer;
    }

    .remove-button:hover {
        color: #b04444;
        border-color: rgba(176,68,68,.25);
        background: #fff6f6;
    }

    /* =========================
       QUANTITY
    ========================= */

    .quantity-control {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 4px;
        background: var(--purple-light);
        border: 1px solid rgba(139,107,177,.12);
    }

    .quantity-button {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--purple);
        font-size: 18px;
        cursor: pointer;

        transition:
            background .2s ease,
            color .2s ease;
    }

    .quantity-button:hover {
        background: var(--purple);
        color: white;
    }

    .quantity-input {
        width: 42px;
        text-align: center;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--text);
        font-family: 'El Messiri', serif;
        font-weight: 700;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity-input[type=number] {
        -moz-appearance: textfield;
    }

    /* =========================
       UPDATE
    ========================= */

    .update-button {
        padding: 8px 15px;
        border-radius: 999px;
        background: white;
        color: var(--purple);
        border: 1px solid rgba(139,107,177,.20);
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .25s ease;
    }

    .update-button:hover {
        background: var(--purple);
        color: white;
        border-color: var(--purple);
    }

    /* =========================
       SUMMARY
    ========================= */

    .summary-card {
        background: white;
        border: 1px solid rgba(139,107,177,.12);
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 15px 45px rgba(70,45,90,.06);
    }

    .summary-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 14px;
    }

    .summary-label {
        color: var(--muted);
    }

    .summary-value {
        font-weight: 700;
    }

    .summary-divider {
        height: 1px;
        background: rgba(40,30,50,.08);
        margin: 12px 0;
    }

    .shipping-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--purple-soft);
        color: var(--purple-dark);
        font-size: 10px;
        font-weight: 700;
    }

    .shipping-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--purple);
    }

    .total-price {
        color: var(--purple);
        font-family: 'El Messiri', serif;
        font-size: 38px;
        font-weight: 700;
    }

    /* =========================
       BUTTONS
    ========================= */

    .primary-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border-radius: 999px;
        background: var(--purple);
        color: white;
        font-weight: 700;
        cursor: pointer;

        transition:
            background .25s ease,
            transform .25s ease,
            box-shadow .25s ease;
    }

    .primary-button:hover {
        background: var(--purple-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(111,79,152,.20);
    }

    .secondary-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border-radius: 999px;
        background: white;
        color: var(--purple-dark);
        border: 1px solid rgba(139,107,177,.22);
        font-size: 14px;
        font-weight: 700;
        transition: all .25s ease;
    }

    .secondary-button:hover {
        background: var(--purple-soft);
        border-color: var(--purple);
        color: var(--purple-dark);
    }

    /* =========================
       TRUST
    ========================= */

    .trust-card {
        padding: 13px 8px;
        text-align: center;
        border-radius: 16px;
        background: var(--purple-light);
        border: 1px solid rgba(139,107,177,.08);
    }

    .trust-icon {
        width: 38px;
        height: 38px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--purple-soft);
        color: var(--purple);
    }

    .trust-title {
        margin-top: 8px;
        font-family: 'El Messiri', serif;
        font-size: 12px;
        font-weight: 700;
    }

    @media (max-width: 640px) {

        .product-image {
            width: 100%;
            height: 210px;
        }

        .cart-item {
            padding: 14px;
        }

        .summary-card {
            padding: 22px;
        }

        .total-price {
            font-size: 32px;
        }
    }
</style>

@endsection


@section('content')

@php
    $itemsCount = isset($items) && is_countable($items)
        ? count($items)
        : 0;
@endphp


<main class="mx-auto max-w-7xl px-5 pb-24 sm:px-8 lg:px-12">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb pt-8 pb-4 text-sm">

        <ol class="flex items-center gap-2">

            <li>
                <a href="{{ url('/') }}">
                    المنتجات
                </a>
            </li>

            <li class="opacity-50">
                /
            </li>

            <li class="text-[var(--text)]">
                سلة التسوق
            </li>

        </ol>

    </nav>


    {{-- Header --}}
    <section class="mb-10 mt-5">

        <a
            href="{{ url('/') }}"
            class="back-link text-sm"
        >

            <span class="text-lg">
                →
            </span>

            <span>
                متابعة التسوق
            </span>

        </a>


        <div class="mt-5 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">

            <div class="max-w-2xl">

                <h1 class="font-display text-4xl font-bold leading-tight md:text-5xl">
                    سلة التسوق
                </h1>

                <p class="mt-3 text-base leading-8 text-[var(--muted)]">
                    راجع منتجاتك قبل إتمام الطلب واستمتع بتجربة
                    تسوق بسيطة وسهلة مع أوركيدس.
                </p>

            </div>


            @if($itemsCount > 0)

                <span class="count-pill">

                    <span class="count-dot"></span>

                    {{ $itemsCount }}

                    {{ $itemsCount == 1 ? 'منتج' : 'منتجات' }}

                    في السلة

                </span>

            @endif

        </div>

    </section>


    {{-- Success --}}
    @if(session('success'))

        <div class="success-card mb-8">

            <div class="success-icon">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />

                </svg>

            </div>

            <p class="text-sm">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- EMPTY CART --}}
    @if(empty($items) || $itemsCount === 0)

        <section>

            <div class="empty-cart">

                <div class="empty-icon">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-9 w-9"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 2.7A1 1 0 006.54 17H19M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
                        />

                    </svg>

                </div>


                <h2 class="font-display mt-7 text-3xl font-bold md:text-4xl">
                    سلتك فارغة
                </h2>


                <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-[var(--muted)]">
                    يبدو أنك لم تضف أي منتجات بعد.
                    اكتشف منتجاتنا المختارة وأضف ما يعجبك إلى سلتك.
                </p>


                <a
                    href="{{ url('/') }}"
                    class="primary-button mx-auto mt-8 max-w-xs"
                >

                    <span>
                        تصفح المنتجات
                    </span>

                    <span>
                        ←
                    </span>

                </a>

            </div>

        </section>


    @else


        {{-- CART --}}
        <section class="grid grid-cols-1 gap-8 lg:grid-cols-3">


            {{-- ITEMS --}}
            <div class="space-y-5 lg:col-span-2">


                @foreach($items as $key => $item)

                    @php

                        $product = $item['product'] ?? $item;

                        $quantity = $item['quantity'] ?? 1;

                        $price = $item['price']
                            ?? ($product->price ?? 0);

                        $itemSubtotal = $item['subtotal']
                            ?? ($price * $quantity);


                        /*
                         * اسم المنتج
                         */
                        $productName = is_object($product)
                            ? ($product->name ?? '')
                            : ($product['name'] ?? '');


                        /*
                         * صورة المنتج
                         */
                        $productImage = $item['image'] ?? null;

                        /*
                         * وصف المنتج
                         */
                        $productDesc = '';

                        if (is_object($product)) {

                            $productDesc =
                                $product->short_description ?? '';

                            /*
                             * إذا لم يوجد وصف،
                             * نحاول الحصول على اسم التصنيف.
                             */
                            if (!$productDesc && isset($product->category)) {

                                $category = $product->category;

                                if (is_object($category)) {

                                    $productDesc =
                                        $category->name ?? '';

                                } elseif (is_array($category)) {

                                    $productDesc =
                                        $category['name'] ?? '';

                                } elseif (is_string($category)) {

                                    /*
                                     * إذا كانت category عبارة عن JSON
                                     */
                                    $decodedCategory =
                                        json_decode($category, true);

                                    if (
                                        json_last_error() === JSON_ERROR_NONE &&
                                        is_array($decodedCategory)
                                    ) {

                                        $productDesc =
                                            $decodedCategory['name'] ?? '';

                                    } else {

                                        $productDesc = $category;
                                    }
                                }
                            }

                        } else {

                            $productDesc =
                                $product['short_description'] ?? '';

                            /*
                             * إذا لم يوجد وصف،
                             * نحاول الحصول على اسم التصنيف.
                             */
                            if (!$productDesc && isset($product['category'])) {

                                $category = $product['category'];

                                if (is_array($category)) {

                                    $productDesc =
                                        $category['name'] ?? '';

                                } elseif (is_string($category)) {

                                    /*
                                     * إذا كانت category عبارة عن JSON
                                     */
                                    $decodedCategory =
                                        json_decode($category, true);

                                    if (
                                        json_last_error() === JSON_ERROR_NONE &&
                                        is_array($decodedCategory)
                                    ) {

                                        $productDesc =
                                            $decodedCategory['name'] ?? '';

                                    } else {

                                        $productDesc = $category;
                                    }
                                }
                            }
                        }


                        /*
                         * حماية إضافية:
                         * إذا كان الوصف نفسه JSON فلا نعرضه.
                         */
                        if (is_string($productDesc)) {

                            $decodedDescription =
                                json_decode($productDesc, true);

                            if (
                                json_last_error() === JSON_ERROR_NONE &&
                                is_array($decodedDescription)
                            ) {

                                $productDesc = '';

                            }
                        }

                    @endphp


                    <article class="cart-item">

                        <div class="flex flex-col gap-5 sm:flex-row">


                            {{-- IMAGE --}}
                            <div class="product-image">

                            @if($productImage)

                                <img
                                    src="{{ $productImage }}"
                                    alt="{{ $productName }}"
                                    loading="lazy"
                                >

                            @else

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-12 w-12 text-[var(--purple)] opacity-50"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.2"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4z"
                                    />

                                </svg>

                            @endif

                        </div>


                            {{-- DETAILS --}}
                            <div class="flex min-w-0 flex-1 flex-col">


                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">

                                        <h3 class="product-name font-display truncate text-2xl font-bold">
                                            {{ $productName }}
                                        </h3>


                                        @if($productDesc)

                                            <p class="mt-1 line-clamp-2 text-sm leading-6 text-[var(--muted)]">
                                                {{ $productDesc }}
                                            </p>

                                        @endif


                                        <div class="mt-3 flex items-center gap-2">

                                            <span class="text-xs text-[var(--muted)]">
                                                السعر
                                            </span>

                                            <span class="font-display font-bold">
                                                ${{ number_format($price, 2) }}
                                            </span>

                                        </div>

                                    </div>


                                    {{-- REMOVE --}}
                                    <form
                                        action="{{ route('cart.remove', $product) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="remove-button"
                                            title="حذف المنتج"
                                            aria-label="حذف المنتج"
                                        >

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m-7 0v12a2 2 0 002 2h6a2 2 0 002-2V7"
                                                />

                                            </svg>

                                        </button>

                                    </form>

                                </div>


                                {{-- CONTROLS --}}
                                <div class="mt-6 flex flex-wrap items-center justify-between gap-5">


                                    <form
                                        action="{{ route('cart.update', $product) }}"
                                        method="POST"
                                        class="flex items-center gap-3"
                                        data-cart-form
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <div
                                            class="quantity-control"
                                            role="group"
                                            aria-label="تحديد الكمية"
                                        >

                                            <button
                                                type="button"
                                                class="quantity-button"
                                                data-qty-dec
                                                aria-label="إنقاص"
                                            >
                                                −
                                            </button>


                                            <input
                                                type="number"
                                                name="quantity"
                                                min="1"
                                                max="99"
                                                value="{{ $quantity }}"
                                                class="quantity-input"
                                                data-qty-input
                                            >


                                            <button
                                                type="button"
                                                class="quantity-button"
                                                data-qty-inc
                                                aria-label="زيادة"
                                            >
                                                +
                                            </button>

                                        </div>


                                        <button
                                            type="submit"
                                            class="update-button"
                                        >
                                            تحديث
                                        </button>

                                    </form>


                                    <div class="text-left">

                                        <span class="block text-xs text-[var(--muted)]">
                                            الإجمالي
                                        </span>

                                        <span class="font-display text-2xl font-bold text-[var(--purple)]">
                                            ${{ number_format($itemSubtotal, 2) }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach


                {{-- CLEAR CART --}}
                <div class="pt-2">

                    <form
                        action="{{ route('cart.clear') }}"
                        method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف جميع المنتجات؟');"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 text-sm text-[var(--muted)] transition hover:text-red-500"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m-7 0v12a2 2 0 002 2h6a2 2 0 002-2V7"
                                />

                            </svg>

                            حذف جميع المنتجات

                        </button>

                    </form>

                </div>

            </div>


            {{-- SUMMARY --}}
            <aside>

                <div class="summary-card lg:sticky lg:top-28">


                    <h2 class="font-display text-2xl font-bold md:text-3xl">
                        ملخص الطلب
                    </h2>


                    <p class="mt-1 text-sm text-[var(--muted)]">
                        مراجعة أخيرة قبل إتمام الطلب
                    </p>


                    @php

                        $totalQty = 0;

                        foreach($items as $i) {

                            $totalQty +=
                                ($i['quantity'] ?? 1);

                        }

                    @endphp


                    <div class="mt-6">


                        <div class="summary-line">

                            <span class="summary-label">
                                المنتجات
                            </span>

                            <span class="summary-value">
                                {{ $itemsCount }}
                            </span>

                        </div>


                        <div class="summary-line">

                            <span class="summary-label">
                                إجمالي الكمية
                            </span>

                            <span class="summary-value">
                                {{ $totalQty }}
                            </span>

                        </div>


                        <div class="summary-line">

                            <span class="summary-label">
                                الشحن
                            </span>

                            <span class="shipping-pill">

                                <span class="shipping-dot"></span>

                                يُحدد عند الطلب

                            </span>

                        </div>

                    </div>


                    <div class="summary-divider"></div>


                    <div class="flex items-end justify-between">

                        <span class="font-display text-lg font-bold">
                            الإجمالي
                        </span>

                        <div class="text-left">

                            <span class="total-price">
                                ${{ number_format($subtotal ?? 0, 2) }}
                            </span>

                            <span class="block text-xs text-[var(--muted)]">
                                USD
                            </span>

                        </div>

                    </div>


                    {{-- CHECKOUT --}}
                    <form
                        action="{{ route('store.checkout') }}"
                        method="GET"
                        class="mt-7"
                    >

                        <button
                            type="submit"
                            class="primary-button"
                        >

                            <span>
                                إتمام الطلب
                            </span>

                            <span>
                                ←
                            </span>

                        </button>

                    </form>


                    {{-- CONTINUE --}}
                    <a
                        href="{{ url('/') }}"
                        class="secondary-button mt-3"
                    >
                        متابعة التسوق
                    </a>


                    {{-- TRUST --}}
                    <div class="mt-7 grid grid-cols-3 gap-2">


                        <div class="trust-card">

                            <div class="trust-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                    />

                                </svg>

                            </div>

                            <p class="trust-title">
                                دفع آمن
                            </p>

                        </div>


                        <div class="trust-card">

                            <div class="trust-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.6"
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


                        <div class="trust-card">

                            <div class="trust-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12l2 2 4-4"
                                    />

                                </svg>

                            </div>

                            <p class="trust-title">
                                حماية البيانات
                            </p>

                        </div>

                    </div>


                    <p class="mt-6 text-center text-xs leading-6 text-[var(--muted)]">

                        بإتمام الطلب فأنت توافق على

                        <a
                            href="{{ url('/terms') }}"
                            class="font-medium text-[var(--purple)] hover:underline"
                        >
                            شروط الاستخدام
                        </a>

                        و

                        <a
                            href="{{ url('/privacy') }}"
                            class="font-medium text-[var(--purple)] hover:underline"
                        >
                            سياسة الخصوصية
                        </a>.

                    </p>

                </div>

            </aside>

        </section>

    @endif


</main>

@endsection


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       QUANTITY CONTROLS
    ========================= */

    document
        .querySelectorAll('[data-cart-form]')
        .forEach(function (form) {

            const input =
                form.querySelector('[data-qty-input]');

            const dec =
                form.querySelector('[data-qty-dec]');

            const inc =
                form.querySelector('[data-qty-inc]');


            if (!input || !dec || !inc) {
                return;
            }


            function clamp(value) {

                const parsed =
                    parseInt(value || 1, 10);

                if (isNaN(parsed)) {
                    return 1;
                }

                return Math.max(
                    1,
                    Math.min(99, parsed)
                );
            }


            dec.addEventListener(
                'click',
                function () {

                    input.value =
                        clamp(
                            Number(input.value) - 1
                        );

                }
            );


            inc.addEventListener(
                'click',
                function () {

                    input.value =
                        clamp(
                            Number(input.value) + 1
                        );

                }
            );


            input.addEventListener(
                'input',
                function () {

                    input.value =
                        clamp(input.value);

                }
            );

        });


    /* =========================
       LEGACY HELPER
    ========================= */

    window.changeCartQuantity =
        function (key, delta) {

            const form =
                document.querySelector(
                    `form[action*="/cart/update/${key}"], form[action$="/cart/${key}"]`
                );


            if (!form) {
                return;
            }


            const input =
                form.querySelector('[data-qty-input]');


            if (!input) {
                return;
            }


            const current =
                parseInt(input.value, 10) || 1;


            const next =
                Math.max(
                    1,
                    Math.min(
                        99,
                        current + delta
                    )
                );


            input.value = next;

            form.submit();

        };

});
</script>

@endsection
