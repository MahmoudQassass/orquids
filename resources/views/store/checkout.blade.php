@extends('store.layouts.app')

@section('title', 'إتمام الطلب — أوركيدس')

@section('content')

<style>
    :root {
        --orchid-50: #fbf9fd;
        --orchid-100: #f7f3fb;
        --orchid-200: #eee7f5;
        --orchid-300: #e2d5ed;
        --orchid-400: #cdb8dc;
        --orchid-500: #ae91c2;
        --orchid-600: #9474aa;
        --orchid-700: #7d6093;

        --ink: #332b38;
        --muted: #8c8292;
    }

    .checkout-page {
        background: var(--orchid-50);
        color: var(--ink);
        font-family: 'Tajawal', sans-serif;
    }

    .font-display {
        font-family: 'El Messiri', serif;
        letter-spacing: .01em;
    }

    .link-underline {
        position: relative;
        display: inline-block;
    }

    .link-underline::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: -4px;
        width: 100%;
        height: 1px;
        background: currentColor;
        transform: scaleX(0);
        transform-origin: right center;
        transition: transform .4s ease;
    }

    .link-underline:hover::after {
        transform: scaleX(1);
        transform-origin: left center;
    }

    .page-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 999px;
        background: var(--orchid-100);
        border: 1px solid var(--orchid-300);
        color: var(--orchid-700);
        font-size: 12px;
        font-weight: 500;
    }

    .page-kicker-dot,
    .summary-count-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--orchid-600);
        display: inline-block;
    }

    .step-dot {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: var(--muted);
        border: 1px solid var(--orchid-300);
        font-family: 'El Messiri', serif;
        font-size: 13px;
        font-weight: 700;
    }

    .step-dot.done {
        background: var(--orchid-700);
        color: white;
        border-color: var(--orchid-700);
    }

    .step-dot.active {
        background: var(--orchid-500);
        color: white;
        border-color: var(--orchid-500);
        box-shadow: 0 7px 20px rgba(174,145,194,.30);
    }

    .step-line {
        flex: 1;
        height: 1px;
        margin: 0 12px;
        background: var(--orchid-300);
    }

    .step-line.done {
        background: var(--orchid-600);
    }

    .step-label {
        font-family: 'El Messiri', serif;
        font-size: 13px;
        color: var(--ink);
    }

    .step-label.muted {
        color: var(--muted);
    }

    .alert-base {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 15px 18px;
        border-radius: 18px;
        font-size: 14px;
    }

    .alert-success {
        background: #f5f1f8;
        border: 1px solid var(--orchid-300);
        color: var(--ink);
    }

    .alert-danger {
        background: #fff5f6;
        border: 1px solid #edc8ce;
        color: #873f4c;
    }

    .main-card,
    .summary-card {
        background: white;
        border: 1px solid rgba(125,96,147,.10);
        border-radius: 30px;
        box-shadow: 0 25px 70px -30px rgba(93,67,108,.22);
    }

    .section-icon {
        width: 48px;
        height: 48px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--orchid-100);
        color: var(--orchid-700);
        border: 1px solid var(--orchid-200);
    }

    .field-label {
        display: block;
        margin-bottom: 8px;
        color: var(--ink);
        font-family: 'El Messiri', serif;
        font-size: 14px;
        font-weight: 600;
    }

    .field-label .hint {
        margin-right: 5px;
        color: var(--muted);
        font-family: 'Tajawal', sans-serif;
        font-size: 11px;
        font-weight: 400;
    }

    .field {
        width: 100%;
        min-height: 54px;
        padding: 13px 16px;
        border-radius: 15px;
        background: #fdfcff;
        border: 1px solid rgba(125,96,147,.14);
        color: var(--ink);
        outline: none;
        font-family: 'Tajawal', sans-serif;
        font-size: 14px;
        transition:
            border-color .25s ease,
            box-shadow .25s ease,
            background .25s ease,
            transform .25s ease;
    }

    .field::placeholder {
        color: #aaa1af;
    }

    .field:hover {
        border-color: rgba(125,96,147,.28);
        background: white;
    }

    .field:focus {
        border-color: var(--orchid-500);
        background: white;
        box-shadow: 0 0 0 4px rgba(174,145,194,.13);
        transform: translateY(-1px);
    }

    textarea.field {
        min-height: 130px;
        resize: vertical;
        line-height: 1.8;
    }

    .btn-primary {
        width: 100%;
        min-height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 25px;
        border-radius: 999px;
        background: var(--orchid-700);
        color: white;
        border: 1px solid var(--orchid-700);
        font-family: 'El Messiri', serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 15px 35px -15px rgba(125,96,147,.55);
        transition:
            background .3s ease,
            transform .3s ease,
            box-shadow .3s ease;
    }

    .btn-primary:hover {
        background: #684f78;
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -15px rgba(125,96,147,.65);
    }

    .security-banner {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        border-radius: 15px;
        background: var(--orchid-50);
        border: 1px solid var(--orchid-200);
        color: var(--muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .security-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--orchid-200);
        color: var(--orchid-700);
    }

    .trust-card {
        padding: 17px 10px;
        text-align: center;
        background: white;
        border: 1px solid rgba(125,96,147,.09);
        border-radius: 18px;
        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .trust-card:hover {
        transform: translateY(-3px);
        border-color: var(--orchid-300);
        box-shadow: 0 15px 35px -20px rgba(93,67,108,.25);
    }

    .trust-icon {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--orchid-100);
        color: var(--orchid-700);
    }

    .summary-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        border-radius: 999px;
        background: var(--orchid-100);
        border: 1px solid var(--orchid-300);
        color: var(--orchid-700);
        font-size: 11px;
    }

    .product-thumb {
        width: 82px;
        height: 82px;
        flex-shrink: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        background: var(--orchid-100);
        border: 1px solid var(--orchid-200);
    }

    .summary-product {
        padding: 15px 0;
        border-bottom: 1px solid rgba(125,96,147,.08);
    }

    .summary-product:first-child {
        padding-top: 0;
    }

    .summary-product:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .price,
    .total-price {
        color: var(--orchid-700);
    }

    .shipping-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--orchid-100);
        border: 1px solid var(--orchid-300);
        color: var(--orchid-700);
        font-size: 11px;
    }

    .total-box {
        padding-top: 20px;
        border-top: 1px solid rgba(125,96,147,.10);
    }

    .payment-method {
        padding: 7px 11px;
        border-radius: 999px;
        background: var(--orchid-50);
        border: 1px solid var(--orchid-200);
        color: var(--ink);
        font-family: 'El Messiri', serif;
        font-size: 11px;
    }

    .fx-fade {
        opacity: 0;
        transform: translateY(18px);
    }

    .coupon-box {
        margin-top: 8px;
        padding: 22px;
        border-radius: 22px;
        background: linear-gradient(
            135deg,
            #fbf9fd,
            #f7f3fb
        );
        border: 1px solid var(--orchid-200);
    }

    .coupon-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 17px;
    }

    .coupon-header h3 {
        color: var(--ink);
    }

    .coupon-header p {
        margin-top: 4px;
        color: var(--muted);
        font-size: 12px;
    }

    .coupon-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: var(--orchid-700);
        color: #fff;
        font-family: 'El Messiri', serif;
        font-size: 20px;
        font-weight: 700;
    }

    .coupon-form {
        display: flex;
        gap: 10px;
    }

    .coupon-form .field {
        flex: 1;
        min-width: 0;
    }

    .coupon-button {
        min-width: 125px;
        padding: 0 18px;
        border: 1px solid var(--orchid-700);
        border-radius: 15px;
        background: var(--orchid-700);
        color: #fff;
        font-family: 'El Messiri', serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background .25s ease,
            transform .25s ease,
            box-shadow .25s ease;
    }

    .coupon-button:hover {
        background: #684f78;
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -12px rgba(125, 96, 147, .7);
    }

    .coupon-message {
        margin-bottom: 13px;
        padding: 11px 14px;
        border-radius: 13px;
        font-size: 12px;
    }

    .coupon-success {
        background: #f3f8f4;
        border: 1px solid #cfe2d3;
        color: #386044;
    }

    .coupon-error {
        background: #fff5f6;
        border: 1px solid #edc8ce;
        color: #873f4c;
    }

    .coupon-applied {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 15px;
        border-radius: 15px;
        background: #fff;
        border: 1px solid var(--orchid-300);
    }

    .coupon-applied-label {
        display: block;
        margin-bottom: 4px;
        color: var(--muted);
        font-size: 11px;
    }

    .coupon-applied strong {
        color: var(--orchid-700);
        font-family: monospace;
        letter-spacing: 1px;
    }

    .coupon-remove {
        border: none;
        background: transparent;
        color: #873f4c;
        font-family: 'Tajawal', sans-serif;
        font-size: 12px;
        cursor: pointer;
    }

    @media (min-width: 1024px) {
        .summary-sticky {
            position: sticky;
            top: 105px;
        }
    }

    @media (max-width: 640px) {
        .main-card,
        .summary-card {
            border-radius: 24px;
        }

        .step-label {
            font-size: 11px;
        }

        .step-line {
            margin: 0 7px;
        }

        .step-dot {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }

        .product-thumb {
            width: 70px;
            height: 70px;
        }

        .trust-card {
            padding: 13px 6px;
        }

        .trust-card p {
            font-size: 11px;
        }

        .coupon-form {
            flex-direction: column;
        }

        .coupon-button {
            min-height: 52px;
            width: 100%;
        }
    }
</style>

<div class="h-20"></div>

<div class="checkout-page min-h-screen antialiased">

    <main class="max-w-7xl mx-auto px-5 md:px-8 pb-10">

        {{-- BREADCRUMB --}}
        <nav class="pt-8 pb-5 text-sm text-gray-500 fx-fade" data-fx>
            <ol class="flex items-center gap-2">

                <li>
                    <a href="{{ url('/') }}"
                       class="link-underline hover:text-purple-700 transition">
                        المنتجات
                    </a>
                </li>

                <li class="opacity-40">/</li>

                <li>
                    <a href="{{ url('/cart') }}"
                       class="link-underline hover:text-purple-700 transition">
                        سلة التسوق
                    </a>
                </li>

                <li class="opacity-40">/</li>

                <li class="text-gray-800">
                    إتمام الطلب
                </li>

            </ol>
        </nav>


        {{-- HEADER --}}
        <section class="mt-2 mb-10 fx-fade" data-fx>

            <div class="page-kicker">
                <span class="page-kicker-dot"></span>
                خطوة أخيرة لإتمام طلبك
            </div>

            <div class="mt-5 flex flex-wrap items-end justify-between gap-6">

                <div class="max-w-2xl">

                    <h1 class="font-display text-4xl md:text-5xl lg:text-6xl leading-tight">
                        إتمام الطلب
                    </h1>

                    <p class="mt-4 text-gray-500 text-base md:text-lg leading-8">
                        أدخلي بياناتك لإتمام طلبك بسهولة وأمان،
                        واستعدّي لاستلام اختياراتك المميزة من أوركيدس.
                    </p>

                </div>

            </div>


            {{-- STEPS --}}
            <div class="mt-8 max-w-2xl">

                <div class="flex items-center">

                    <div class="flex items-center gap-2">
                        <span class="step-dot done">✓</span>

                        <span class="step-label">
                            السلة
                        </span>
                    </div>

                    <span class="step-line done"></span>

                    <div class="flex items-center gap-2">
                        <span class="step-dot active">2</span>

                        <span class="step-label">
                            البيانات
                        </span>
                    </div>

                    <span class="step-line"></span>

                    <div class="flex items-center gap-2">
                        <span class="step-dot">3</span>

                        <span class="step-label muted">
                            الدفع
                        </span>
                    </div>

                </div>

            </div>

        </section>


        {{-- FLASH SUCCESS --}}
        @if(session('success'))

            <div class="alert-base alert-success mb-6 fx-fade"
                 data-fx
                 role="alert">

                <span class="section-icon"
                      style="width:34px;height:34px;border-radius:10px;">
                    ✓
                </span>

                <p class="pt-1">
                    {{ session('success') }}
                </p>

            </div>

        @endif


        {{-- FLASH ERROR --}}
        @if(session('error'))

            <div class="alert-base alert-danger mb-6 fx-fade"
                 data-fx
                 role="alert">

                <span class="section-icon"
                      style="width:34px;height:34px;border-radius:10px;background:#f8dfe3;color:#873f4c;">
                    !
                </span>

                <p class="pt-1">
                    {{ session('error') }}
                </p>

            </div>

        @endif


        {{-- VALIDATION ERRORS --}}
        @if($errors->any())

            <div class="alert-base alert-danger mb-6 fx-fade"
                 data-fx
                 role="alert">

                <span class="section-icon"
                      style="width:34px;height:34px;border-radius:10px;background:#f8dfe3;color:#873f4c;">
                    !
                </span>

                <div class="flex-1">

                    <p class="font-display text-base mb-1">
                        يرجى تصحيح الأخطاء التالية:
                    </p>

                    <ul class="list-disc ps-5 space-y-1 text-sm">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- MAIN CONTENT --}}
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-7">


            {{-- CUSTOMER FORM --}}
            <div class="lg:col-span-2">

                <div class="main-card p-6 md:p-10 fx-fade"
                     data-fx>

                    <div class="flex items-center gap-4 mb-9">

                        <span class="section-icon">
                            👤
                        </span>

                        <div>

                            <h2 class="font-display text-2xl md:text-3xl">
                                بيانات العميل
                            </h2>

                            <p class="text-gray-500 text-sm mt-1">
                                نحتاج هذه البيانات لتوصيل طلبك إليك
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('store.processCheckout') }}"
                        method="POST"
                        class="space-y-6">

                        @csrf


                        {{-- NAME --}}
                        <div>

                            <label
                                class="field-label"
                                for="customer_name">

                                الاسم الكامل

                            </label>

                            <input
                                id="customer_name"
                                type="text"
                                name="customer_name"
                                class="field"
                                value="{{ old('customer_name') }}"
                                placeholder="أدخلي اسمك الكامل"
                                required>

                        </div>


                        {{-- PHONE --}}
                        <div>

                            <label
                                class="field-label"
                                for="phone">

                                رقم الهاتف

                            </label>

                            <input
                                id="phone"
                                type="tel"
                                name="phone"
                                class="field"
                                value="{{ old('phone') }}"
                                placeholder="مثال: +966 5XXXXXXXX"
                                required>

                        </div>


                        {{-- EMAIL --}}
                        <div>

                            <label
                                class="field-label"
                                for="email">

                                البريد الإلكتروني

                                <span class="hint">
                                    (اختياري)
                                </span>

                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="field"
                                value="{{ old('email') }}"
                                placeholder="example@email.com">

                        </div>


                        {{-- COUNTRY / CITY / ZIP --}}
                        <div class="space-y-6">

                            {{-- COUNTRY --}}
                            <div>

                                <label
                                    for="country"
                                    class="mb-2 block text-sm font-bold text-[var(--text)]"
                                >
                                    الدولة
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="country"
                                    name="country"
                                    required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-[var(--purple)]/10"
                                >

                                    <option value="">
                                        اختر الدولة
                                    </option>

                                    @foreach($countries as $country)

                                        <option
                                            value="{{ $country->id }}"
                                            data-country-code="{{ $country->code }}"
                                            {{ old('country') == $country->id ? 'selected' : '' }}
                                        >
                                            {{ $country->name }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('country')
                                    <p class="mt-2 text-xs font-medium text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                                {{-- Availability --}}
                                <div
                                    id="country-availability"
                                    class="mt-3 hidden rounded-xl px-4 py-3 text-sm font-bold"
                                >
                                </div>

                            </div>


                            {{-- CITY + ZIP --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- CITY --}}
                                <div>

                                    <label
                                        for="city"
                                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                                    >
                                        المدينة
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        required
                                        autocomplete="address-level2"
                                        placeholder="مثال: الرياض"
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-[var(--purple)]/10"
                                    >

                                    @error('city')
                                        <p class="mt-2 text-xs font-medium text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- ZIP --}}
                                <div>

                                    <label
                                        for="zip"
                                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                                    >
                                        الرمز البريدي
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="zip"
                                        name="zip"
                                        value="{{ old('zip') }}"
                                        required
                                        inputmode="numeric"
                                        autocomplete="postal-code"
                                        placeholder="مثال: 12345"
                                        maxlength="10"
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-[var(--purple)]/10"
                                    >

                                    @error('zip')
                                        <p class="mt-2 text-xs font-medium text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        <input
                            type="hidden"
                            id="checkout-product-ids"
                            value="{{ collect($items)->pluck('product.id')->implode(',') }}"
                        >


                        {{-- ADDRESS --}}
                        <div>

                            <label
                                class="field-label"
                                for="address">

                                العنوان بالتفصيل

                            </label>

                            <textarea
                                id="address"
                                name="address"
                                class="field"
                                placeholder="الشارع، المبنى، رقم الشقة، وأي علامة مميزة..."
                                required>{{ old('address') }}</textarea>

                        </div>


                        {{-- SUBMIT --}}
                        <div class="pt-2">

                            <button
                                type="submit"
                                class="btn-primary">

                                <span>
                                    متابعة إلى الدفع
                                </span>

                                <span>
                                    ←
                                </span>

                            </button>

                        </div>


                        {{-- SECURITY --}}
                        <div class="security-banner">

                            <span class="security-icon">
                                🔒
                            </span>

                            <span>
                                سيتم تحويلك إلى بوابة دفع آمنة
                                (PayTabs) لإتمام العملية بحماية
                                كاملة لبياناتك.
                            </span>

                        </div>

                    </form>


                    {{-- COUPON --}}
                    <div class="mt-7 pt-6 border-t border-purple-100">

                        <div class="coupon-header">

                            <div>
                                <h3 class="font-display text-lg">
                                    لديك كود خصم؟
                                </h3>

                                <p>
                                    أدخل الكود للحصول على الخصم مباشرة.
                                </p>
                            </div>

                            <div class="coupon-icon">
                                %
                            </div>

                        </div>


                        @if(session('coupon_success'))

                            <div class="coupon-message coupon-success">
                                {{ session('coupon_success') }}
                            </div>

                        @endif


                        @if(session('coupon_error'))

                            <div class="coupon-message coupon-error">
                                {{ session('coupon_error') }}
                            </div>

                        @endif


                        @if($coupon)

                            <div class="coupon-applied">

                                <div>

                                    <span class="coupon-applied-label">
                                        الكوبون المطبق
                                    </span>

                                    <strong>
                                        {{ $coupon->code }}
                                    </strong>

                                </div>

                                <form
                                    action="{{ route('store.removeCoupon') }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="coupon-remove">

                                        إزالة

                                    </button>

                                </form>

                            </div>

                        @else

                            <form
                                action="{{ route('store.applyCoupon') }}"
                                method="POST"
                                class="coupon-form">

                                @csrf

                                <input
                                    type="text"
                                    name="coupon_code"
                                    class="field"
                                    placeholder="أدخل كود الخصم"
                                    value="{{ old('coupon_code') }}"
                                    autocomplete="off">

                                <button
                                    type="submit"
                                    class="coupon-button">

                                    تطبيق

                                </button>

                            </form>

                        @endif

                    </div>

                </div>


                {{-- TRUST CARDS --}}
                <div
                    class="grid grid-cols-3 gap-3 mt-5 fx-fade"
                    data-fx>

                    <div class="trust-card">

                        <div class="trust-icon">
                            🛡️
                        </div>

                        <p class="mt-2 font-display text-xs">
                            دفع آمن
                        </p>

                    </div>


                    <div class="trust-card">

                        <div class="trust-icon">
                            🚚
                        </div>

                        <p class="mt-2 font-display text-xs">
                            شحن موثوق
                        </p>

                    </div>


                    <div class="trust-card">

                        <div class="trust-icon">
                            👤
                        </div>

                        <p class="mt-2 font-display text-xs">
                            دعم مباشر
                        </p>

                    </div>

                </div>

            </div>


            {{-- ORDER SUMMARY --}}
            <aside class="lg:col-span-1">

                <div
                    class="summary-sticky fx-fade"
                    data-fx>

                    <div class="summary-card p-6 md:p-8">


                        {{-- SUMMARY HEADER --}}
                        <div class="flex items-center justify-between mb-7">

                            <h2 class="font-display text-2xl md:text-3xl">
                                ملخص الطلب
                            </h2>

                            <span class="summary-count">

                                <span class="summary-count-dot"></span>

                                {{ $cartCount }}

                                {{ $cartCount == 1 ? 'قطعة' : 'قطع' }}

                            </span>

                        </div>


                        {{-- PRODUCTS --}}
                        <div>

                            @foreach($items as $item)

                                @php
                                    $product = $item['product'];
                                @endphp

                                <div class="summary-product flex items-start gap-4">

                                    <div class="product-thumb">

                                        @if($product->images->first())

                                            <img
                                                src="{{ asset('storage/' . $product->images->first()->image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover">

                                        @else

                                            <span class="text-gray-400">
                                                🖼️
                                            </span>

                                        @endif

                                    </div>


                                    <div class="flex-1 min-w-0">

                                        <div
                                            class="font-display text-base leading-tight truncate">

                                            {{ $product->name }}

                                        </div>


                                        <div
                                            class="text-gray-500 text-xs mt-2">

                                            الكمية:

                                            <span class="text-gray-800">
                                                {{ $item['quantity'] }}
                                            </span>

                                        </div>


                                        <div
                                            class="font-display text-base mt-2 price">

                                            {{ number_format($item['subtotal'], 2) }}

                                            <span class="text-xs ms-1">
                                                {{ config('services.paytabs.currency', 'EGP') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- SUMMARY --}}
                        <div class="mt-7 space-y-4">


                            {{-- عدد المنتجات --}}
                            <div class="flex items-center justify-between">

                                <span class="text-gray-500">
                                    عدد المنتجات
                                </span>

                                <span class="font-display">
                                    {{ $cartCount }}
                                </span>

                            </div>


                            {{-- SUBTOTAL --}}
                            <div class="flex items-center justify-between">

                                <span class="text-gray-500">
                                    المجموع الفرعي
                                </span>

                                <span class="font-display">

                                    {{ number_format($subtotal, 2) }}

                                    <span class="text-xs text-purple-600 ms-1">
                                        {{ config('services.paytabs.currency', 'EGP') }}
                                    </span>

                                </span>

                            </div>


                            {{-- COUPON DISCOUNT --}}
                            @if($coupon && $discount > 0)

                                <div class="flex items-center justify-between">

                                    <div>

                                        <span class="text-gray-500">
                                            الخصم
                                        </span>

                                        @if($coupon->discount_percent)
                                            <span class="text-xs text-green-600 ms-1">
                                                ({{ number_format((float) $coupon->discount_percent, 2) }}%)
                                            </span>
                                        @endif

                                    </div>

                                    <span class="font-display text-green-600">

                                        -{{ number_format($discount, 2) }}

                                        <span class="text-xs ms-1">
                                            {{ config('services.paytabs.currency', 'EGP') }}
                                        </span>

                                    </span>

                                </div>

                            @endif


                            {{-- SHIPPING --}}
                            <div class="flex items-center justify-between">

                                <span class="text-gray-500">
                                    الشحن
                                </span>

                                <span class="shipping-badge">

                                    <span class="summary-count-dot"></span>

                                    يُحدد لاحقاً

                                </span>

                            </div>

                        </div>


                        {{-- TOTAL --}}
                        <div class="total-box mt-7">

                            <div class="flex items-end justify-between gap-5">

                                <span class="font-display text-xl">
                                    الإجمالي
                                </span>


                                <div class="text-left">

                                    {{-- السعر قبل الخصم --}}
                                    @if($coupon && $discount > 0)

                                        <div class="text-sm text-gray-400 line-through mb-2">

                                            {{ number_format($subtotal, 2) }}

                                            {{ config('services.paytabs.currency', 'EGP') }}

                                        </div>

                                    @endif


                                    {{-- السعر النهائي --}}
                                    <span
                                        class="font-display text-4xl md:text-5xl leading-none total-price">

                                        {{ number_format($total, 2) }}

                                    </span>

                                    <span class="block text-gray-500 text-xs mt-2">

                                        {{ config('services.paytabs.currency', 'EGP') }}

                                    </span>

                                </div>

                            </div>


                            {{-- SAVING MESSAGE --}}
                            @if($coupon && $discount > 0)

                                <div class="mt-4 flex items-center justify-center gap-2 rounded-xl bg-green-50 border border-green-100 px-3 py-2">

                                    <span class="text-green-600">
                                        ✓
                                    </span>

                                    <span class="text-xs text-green-700">

                                        وفّرت
                                        <strong>
                                            {{ number_format($discount, 2) }}
                                        </strong>

                                        {{ config('services.paytabs.currency', 'EGP') }}

                                        باستخدام الكوبون

                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- PAYMENT METHODS --}}
                        <div class="mt-7 pt-5 border-t border-purple-100">

                            <p class="text-gray-500 text-xs mb-3">
                                طرق الدفع المتاحة
                            </p>

                            <div class="flex items-center gap-2 flex-wrap">

                                <span class="payment-method">
                                    Visa
                                </span>

                                <span class="payment-method">
                                    Mastercard
                                </span>

                                <span class="payment-method">
                                    Mada
                                </span>

                                <span class="payment-method">
                                    PayTabs
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- TERMS --}}
                    <p class="mt-4 text-center text-xs text-gray-500 leading-6">

                        بإتمام الطلب فأنتِ توافقين على

                        <a
                            href="{{ url('/terms') }}"
                            class="link-underline hover:text-purple-700">

                            شروط الاستخدام

                        </a>

                        و

                        <a
                            href="{{ url('/privacy') }}"
                            class="link-underline hover:text-purple-700">

                            سياسة الخصوصية

                        </a>.

                    </p>

                </div>

            </aside>

        </section>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const countrySelect =
        document.getElementById('country');

    const availability =
        document.getElementById('country-availability');

    const productIdsInput =
        document.getElementById('checkout-product-ids');

    if (!countrySelect || !availability || !productIdsInput) {
        return;
    }

    countrySelect.addEventListener('change', async function () {

        const countryId = this.value;

        availability.classList.add('hidden');
        availability.innerHTML = '';

        if (!countryId) {
            return;
        }

        const productIds = productIdsInput.value
            .split(',')
            .map(id => id.trim())
            .filter(id => id !== '');

        if (!productIds.length) {
            return;
        }

        availability.classList.remove('hidden');

        availability.className =
            'mt-3 rounded-xl bg-purple-50 px-4 py-3 text-sm font-bold text-purple-700';

        availability.textContent =
            'جاري التحقق من توفر المنتجات للشحن...';

        try {

            const response = await fetch(
                `/products/availability/${countryId}`,
                {
                    method: 'POST',

                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content')
                    },

                    body: JSON.stringify({
                        product_ids: productIds
                    })
                }
            );

            if (!response.ok) {
                throw new Error('Availability request failed');
            }

            const data = await response.json();

            availability.classList.remove('hidden');

            if (data.available) {

                availability.className =
                    'mt-3 rounded-xl bg-green-50 px-4 py-3 text-sm font-bold text-green-700';

                availability.textContent =
                    '✓ جميع المنتجات متوفرة للشحن إلى الدولة المختارة.';

            } else {

                availability.className =
                    'mt-3 rounded-xl bg-red-50 px-4 py-3 text-sm font-bold text-red-600';

                let html = `
                    <div class="mb-2">
                        ✕ بعض المنتجات غير متوفرة للشحن إلى الدولة المختارة:
                    </div>
                `;

                if (
                    Array.isArray(data.unavailable_products) &&
                    data.unavailable_products.length
                ) {

                    html += `
                        <ul class="list-disc pr-5 space-y-1">
                    `;

                    data.unavailable_products.forEach(product => {

                        html += `
                            <li>
                                ${escapeHtml(product.name)}
                            </li>
                        `;

                    });

                    html += `</ul>`;
                }

                availability.innerHTML = html;
            }

        } catch (error) {

            console.error(error);

            availability.classList.remove('hidden');

            availability.className =
                'mt-3 rounded-xl bg-yellow-50 px-4 py-3 text-sm font-bold text-yellow-700';

            availability.textContent =
                'تعذر التحقق من توفر المنتجات. يرجى المحاولة مرة أخرى.';
        }

    });


    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;
    }

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const elements = document.querySelectorAll('[data-fx]');

        if (!elements.length) {
            return;
        }

        if (window.gsap) {

            elements.forEach((el, index) => {

                gsap.to(el, {
                    opacity: 1,
                    y: 0,
                    duration: .85,
                    ease: 'power2.out',
                    delay: Math.min(index * .06, .35)
                });

            });

        } else {

            elements.forEach(el => {

                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';

            });

        }

    });
</script>

@endsection
