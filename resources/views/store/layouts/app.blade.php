<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="@yield('meta_description', 'أوركيدس — وجهتك لاكتشاف منتجات مميزة من علامات تجارية مختارة بعناية.')"
    >

    <title>
        @yield('title', 'أوركيدس — منتجات مميزة')
    </title>


    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- Vite --}}
    @vite(['resources/css/app.css'])


    {{-- Store Global Styles --}}
    <style>

        :root {
            --purple: #8b6bb1;
            --purple-dark: #6f4f98;
            --purple-soft: #eee7f6;
            --purple-light: #f6f2fa;

            --text: #292331;
            --muted: #77717f;

            --white: #ffffff;
            --cream: #faf8fc;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            margin: 0;
            font-family: 'Tajawal', sans-serif;
            background: var(--cream);
            color: var(--text);
            overflow-x: hidden;
        }


        .font-display {
            font-family: 'El Messiri', serif;
        }


        /* =========================
           NAVBAR
        ========================= */

        #navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(139, 107, 177, 0.10);
        }


        .nav-link {
            position: relative;
            color: var(--text);
            transition: color 0.25s ease;
        }


        .nav-link::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: -7px;
            width: 0;
            height: 2px;
            border-radius: 999px;
            background: var(--purple);
            transition: width 0.25s ease;
        }


        .nav-link:hover {
            color: var(--purple);
        }


        .nav-link:hover::after {
            width: 100%;
        }


        /* =========================
           PRODUCT CARDS
        ========================= */

        .product-card {
            background: white;
            border: 1px solid rgba(40, 30, 50, 0.07);
            border-radius: 22px;
            overflow: hidden;

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                border-color 0.3s ease;
        }


        .product-card:hover {
            transform: translateY(-5px);

            border-color: rgba(139, 107, 177, 0.20);

            box-shadow:
                0 18px 45px rgba(60, 40, 80, 0.09);
        }


        .product-image {
            position: relative;
            overflow: hidden;
            background: var(--purple-light);
        }


        .product-image img {
            transition: transform 0.5s ease;
        }


        .product-card:hover .product-image img {
            transform: scale(1.04);
        }


        .discount {
            position: absolute;
            top: 14px;
            right: 14px;

            background: var(--purple);
            color: white;

            border-radius: 999px;
            padding: 6px 10px;

            font-size: 11px;
            font-weight: 800;
        }


        .product-title {
            transition: color 0.25s ease;
        }


        .product-title:hover {
            color: var(--purple);
        }


        .add-cart {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            background: var(--purple);
            color: white;

            border: none;
            border-radius: 12px;
            padding: 11px 14px;

            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            transition: background 0.25s ease;
        }


        .add-cart:hover {
            background: var(--purple-dark);
        }


        .add-cart:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }


        .details-btn {
            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid rgba(40, 30, 50, 0.12);
            border-radius: 12px;

            padding: 10px 14px;

            font-size: 12px;
            font-weight: 700;

            transition: all 0.25s ease;
        }


        .details-btn:hover {
            border-color: var(--purple);
            color: var(--purple);
        }


        /* =========================
           CART TOAST
        ========================= */

        #cart-toast {
            pointer-events: none;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #f1ebf7;
            border-top: 1px solid rgba(139, 107, 177, 0.10);
        }


        .footer-link {
            color: var(--muted);
            transition: color 0.25s ease;
        }


        .footer-link:hover {
            color: var(--purple);
        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 767px) {

            .product-card {
                border-radius: 18px;
            }

        }


        {{-- Page-specific styles --}}
        @yield('styles')

    </style>

</head>


<body>


{{-- =========================================================
     NAVBAR
========================================================= --}}

{{-- =========================================================
     RESPONSIVE NAVBAR
========================================================= --}}

<header
    id="navbar"
    class="fixed inset-x-0 top-0 z-50 border-b border-[var(--purple)]/10 bg-white/95 backdrop-blur-xl transition-all duration-300"
>
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">

        {{-- =========================
             DESKTOP / MAIN NAVBAR
        ========================== --}}
        <div class="flex h-20 items-center justify-between">

            {{-- Logo --}}
            <a
                href="{{ route('store.index') }}"
                aria-label="أوركيدس"
                class="relative z-50 shrink-0"
            >
                <img
                    src="{{ asset('assets/images/logo-or.png') }}"
                    alt="أوركيدس"
                    class="h-14 w-auto"
                >
            </a>


            {{-- =========================
                 DESKTOP NAVIGATION
            ========================== --}}
            <nav class="hidden items-center gap-8 md:flex">

                <a
                    href="{{ route('store.index') }}#products"
                    class="nav-link text-sm font-medium"
                >
                    المنتجات
                </a>

                <a
                    href="{{ route('store.index') }}#categories"
                    class="nav-link text-sm font-medium"
                >
                    التصنيفات
                </a>

                <a
                    href="{{ route('store.index') }}#story"
                    class="nav-link text-sm font-medium"
                >
                    عن أوركيدس
                </a>

                <a
                    href="{{ route('store.index') }}#features"
                    class="nav-link text-sm font-medium"
                >
                    لماذا نحن
                </a>

            </nav>


            {{-- =========================
                 RIGHT SIDE
            ========================== --}}
            <div class="flex items-center gap-3">

                {{-- Account --}}
                @auth

                    <div class="relative group">

                        <a
                            href="{{ route('store.account') }}"
                            class="hidden md:flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.7"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 20.25a7.5 7.5 0 0115 0"
                                />
                            </svg>

                            <span>
                                {{ auth()->user()->name }}
                            </span>

                        </a>

                    </div>

                @else

                    {{-- Login --}}
                    <a
                        href="{{ route('store.login') }}"
                        class="hidden md:flex items-center rounded-xl px-3 py-2 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                    >
                        تسجيل الدخول
                    </a>

                    {{-- Register --}}
                    <a
                        href="{{ route('store.register') }}"
                        class="hidden md:flex items-center rounded-xl bg-[var(--purple)] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                    >
                        إنشاء حساب
                    </a>

                @endauth


                {{-- Cart --}}
                @php
                    $cart = session('cart', []);
                    $cartCount = array_sum($cart);
                @endphp

                <a
                    href="{{ route('cart.index') }}"
                    class="relative flex h-11 w-11 items-center justify-center rounded-full border border-purple-200 bg-white text-[var(--purple)] transition hover:scale-105"
                    aria-label="السلة"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 15.75a2.25 2.25 0 002.184 1.7h7.132a2.25 2.25 0 002.184-1.7l1.644-6.578a.75.75 0 00-.728-.932H5.106m3.478 14.25a1.125 1.125 0 11-2.25 0 1.125 1.125 0 012.25 0zm9.75 0a1.125 1.125 0 11-2.25 0 1.125 1.125 0 012.25 0z"
                        />
                    </svg>

                    <span
                        id="cart-count"
                        class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-[var(--purple)] px-1 text-[10px] font-black text-white"
                    >
                        {{ $cartCount }}
                    </span>

                </a>


                {{-- =========================
                     MOBILE MENU BUTTON
                ========================== --}}
                <button
                    type="button"
                    id="mobile-menu-button"
                    aria-label="فتح القائمة"
                    aria-expanded="false"
                    class="relative z-50 flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-[var(--text)] transition hover:border-[var(--purple)] hover:text-[var(--purple)] md:hidden"
                >

                    {{-- Hamburger --}}
                    <span
                        id="menu-icon"
                        class="flex flex-col items-center justify-center gap-1.5"
                    >
                        <span class="menu-line block h-0.5 w-5 rounded-full bg-current transition-all duration-300"></span>
                        <span class="menu-line block h-0.5 w-5 rounded-full bg-current transition-all duration-300"></span>
                        <span class="menu-line block h-0.5 w-5 rounded-full bg-current transition-all duration-300"></span>
                    </span>

                </button>

            </div>

        </div>


        {{-- =====================================================
             MOBILE MENU
        ====================================================== --}}
        <div
            id="mobile-menu"
            class="hidden overflow-hidden border-t border-[var(--purple)]/10 md:hidden"
        >

            <nav class="flex flex-col gap-2 py-5">

                {{-- Products --}}
                <a
                    href="{{ route('store.index') }}#products"
                    class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3.5 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                >
                    <span>المنتجات</span>

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
                            d="M15.75 19.5L8.25 12l7.5-7.5"
                        />
                    </svg>
                </a>


                {{-- Categories --}}
                <a
                    href="{{ route('store.index') }}#categories"
                    class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3.5 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                >
                    <span>التصنيفات</span>

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
                            d="M15.75 19.5L8.25 12l7.5-7.5"
                        />
                    </svg>
                </a>


                {{-- Story --}}
                <a
                    href="{{ route('store.index') }}#story"
                    class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3.5 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                >
                    <span>عن أوركيدس</span>

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
                            d="M15.75 19.5L8.25 12l7.5-7.5"
                        />
                    </svg>
                </a>


                {{-- Features --}}
                <a
                    href="{{ route('store.index') }}#features"
                    class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3.5 text-sm font-bold text-[var(--text)] transition hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                >
                    <span>لماذا نحن</span>

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
                            d="M15.75 19.5L8.25 12l7.5-7.5"
                        />
                    </svg>
                </a>


                {{-- Mobile Cart --}}
                <a
                    href="{{ route('cart.index') }}"
                    class="mt-2 flex items-center justify-between rounded-xl bg-[var(--purple-soft)] px-4 py-3.5 text-sm font-bold text-[var(--purple)]"
                >

                    <div class="flex items-center gap-3">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 15.75a2.25 2.25 0 002.184 1.7h7.132a2.25 2.25 0 002.184-1.7l1.644-6.578a.75.75 0 00-.728-.932H5.106"
                            />
                        </svg>

                        <span>
                            السلة
                        </span>

                    </div>


                    @if($cartCount > 0)

                        <span
                            class="flex h-6 min-w-6 items-center justify-center rounded-full bg-[var(--purple)] px-1.5 text-[10px] font-black text-white"
                        >
                            {{ $cartCount }}
                        </span>

                    @endif

                </a>

            </nav>

        </div>

    </div>
</header>


{{-- =========================================================
     MOBILE NAVBAR SCRIPT
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!menuButton || !mobileMenu) {
        return;
    }

    const lines = menuButton.querySelectorAll('.menu-line');
    const mobileLinks = mobileMenu.querySelectorAll('.mobile-nav-link');

    function openMenu() {

        mobileMenu.classList.remove('hidden');

        menuButton.setAttribute('aria-expanded', 'true');
        menuButton.setAttribute('aria-label', 'إغلاق القائمة');

        if (lines.length >= 3) {

            lines[0].classList.add(
                'translate-y-2',
                'rotate-45'
            );

            lines[1].classList.add(
                'opacity-0'
            );

            lines[2].classList.add(
                '-translate-y-2',
                '-rotate-45'
            );
        }
    }


    function closeMenu() {

        mobileMenu.classList.add('hidden');

        menuButton.setAttribute('aria-expanded', 'false');
        menuButton.setAttribute('aria-label', 'فتح القائمة');

        if (lines.length >= 3) {

            lines[0].classList.remove(
                'translate-y-2',
                'rotate-45'
            );

            lines[1].classList.remove(
                'opacity-0'
            );

            lines[2].classList.remove(
                '-translate-y-2',
                '-rotate-45'
            );
        }
    }


    function toggleMenu() {

        if (mobileMenu.classList.contains('hidden')) {
            openMenu();
        } else {
            closeMenu();
        }

    }


    menuButton.addEventListener(
        'click',
        toggleMenu
    );


    mobileLinks.forEach(function (link) {

        link.addEventListener(
            'click',
            function () {
                closeMenu();
            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Close menu when clicking outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                mobileMenu.classList.contains('hidden')
            ) {
                return;
            }

            if (
                !mobileMenu.contains(event.target) &&
                !menuButton.contains(event.target)
            ) {
                closeMenu();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close menu with ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeMenu();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close mobile menu when switching to desktop
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        function () {

            if (window.innerWidth >= 768) {
                closeMenu();
            }

        }
    );

});
</script>


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<main>

    @yield('content')

</main>


{{-- =========================================================
     FOOTER
========================================================= --}}

<footer class="py-14">

    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">

        <div
            class="grid gap-10 border-b border-[var(--purple)]/10 pb-10 md:grid-cols-3"
        >

            {{-- Brand --}}
            <div>

                <img
                    src="{{ asset('assets/images/logo-or.png') }}"
                    alt="أوركيدس"
                    class="h-16 w-auto"
                >


                <p class="mt-4 max-w-sm text-sm leading-7 text-[var(--muted)]">

                    أوركيدس — وجهتك لاكتشاف منتجات
                    مميزة من علامات تجارية مختارة بعناية.

                </p>

            </div>


            {{-- Links --}}
            <div>

                <h3 class="font-bold">
                    استكشف
                </h3>


                <div class="mt-5 flex flex-col gap-3 text-sm">

                    <a
                        href="{{ route('store.index') }}#products"
                        class="footer-link"
                    >
                        المنتجات
                    </a>


                    <a
                        href="{{ route('store.index') }}#story"
                        class="footer-link"
                    >
                        عن أوركيدس
                    </a>


                    <a
                        href="{{ route('store.index') }}#features"
                        class="footer-link"
                    >
                        لماذا نحن
                    </a>

                </div>

            </div>


        {{-- Social Media --}}
        <div>

            <h3 class="font-bold">
                تابعنا
            </h3>

            <p class="mt-3 text-sm leading-7 text-[var(--muted)]">
                تابع أوركيدس واكتشف أحدث المنتجات والعروض.
            </p>

            <div class="mt-5 flex items-center gap-3">

                {{-- Facebook --}}
                <a
                    href="https://facebook.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Facebook"
                    class="group flex h-11 w-11 items-center justify-center
                        rounded-xl
                        bg-[var(--purple)]/5
                        text-[var(--purple)]
                        transition-all duration-300
                        hover:-translate-y-1
                        hover:bg-[var(--purple)]
                        hover:text-white
                        hover:shadow-lg
                        hover:shadow-[var(--purple)]/20"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.413c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.973h-1.514c-1.491 0-1.956.93-1.956 1.886v2.26h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
                    </svg>
                </a>


                {{-- Instagram --}}
                <a
                    href="https://instagram.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Instagram"
                    class="group flex h-11 w-11 items-center justify-center
                        rounded-xl
                        bg-[var(--purple)]/5
                        text-[var(--purple)]
                        transition-all duration-300
                        hover:-translate-y-1
                        hover:bg-[var(--purple)]
                        hover:text-white
                        hover:shadow-lg
                        hover:shadow-[var(--purple)]/20"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="3"
                            width="18"
                            height="18"
                            rx="5"
                            ry="5"
                        />

                        <circle cx="12" cy="12" r="4"/>

                        <circle
                            cx="17.5"
                            cy="6.5"
                            r="1"
                            fill="currentColor"
                            stroke="none"
                        />
                    </svg>
                </a>


                {{-- TikTok --}}
                <a
                    href="https://tiktok.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="TikTok"
                    class="group flex h-11 w-11 items-center justify-center
                        rounded-xl
                        bg-[var(--purple)]/5
                        text-[var(--purple)]
                        transition-all duration-300
                        hover:-translate-y-1
                        hover:bg-[var(--purple)]
                        hover:text-white
                        hover:shadow-lg
                        hover:shadow-[var(--purple)]/20"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.4V2h-3.6v13.67a2.9 2.9 0 1 1-2-2.76V9.27a6.5 6.5 0 1 0 5.6 6.4V8.84a8.4 8.4 0 0 0 4.92 1.58V6.83a4.8 4.8 0 0 1-1.15-.14z"/>
                    </svg>
                </a>

            </div>

        </div>



            {{-- Customer
            <div>

                <h3 class="font-bold">
                    خدمة العملاء
                </h3>


                <div class="mt-5 flex flex-col gap-3 text-sm">

                    <a href="#" class="footer-link">
                        تواصل معنا
                    </a>


                    <a href="#" class="footer-link">
                        الشحن والتوصيل
                    </a>


                    <a href="#" class="footer-link">
                        سياسة الاسترجاع
                    </a>

                </div>

            </div>--}}

        </div>


        <div
            class="flex flex-col gap-3 pt-7 text-xs text-[var(--muted)] sm:flex-row sm:items-center sm:justify-between"
        >

            <span>
                © {{ date('Y') }} أوركيدس. جميع الحقوق محفوظة.
            </span>


            <span>
                اكتشف ما يناسبك.
            </span>

        </div>

    </div>

</footer>


{{-- =========================================================
     CART TOAST
========================================================= --}}

<div
    id="cart-toast"
    class="fixed bottom-6 left-1/2 z-[150] w-[calc(100%-32px)] max-w-sm -translate-x-1/2 translate-y-5 rounded-2xl border border-[var(--purple)]/20 bg-white px-5 py-4 text-[var(--text)] opacity-0 shadow-2xl transition-all duration-300"
>

    <div class="flex items-center gap-3">

        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--purple)] text-white"
        >
            ✓
        </div>


        <div>

            <div class="font-display text-sm font-bold text-[var(--purple)]">
                تمت الإضافة للسلة
            </div>


            <div class="mt-0.5 text-xs text-[var(--muted)]">
                تمت إضافة المنتج بنجاح.
            </div>

        </div>

    </div>

</div>

{{-- =========================================================
     FLOATING WHATSAPP
========================================================= --}}

<a
    href="https://wa.me/970XXXXXXXXX"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="تواصل معنا عبر واتساب"
    class="fixed bottom-7 right-10 z-[100] group"
>

    {{-- Tooltip --}}
    <span
        class="pointer-events-none absolute right-full top-1/2 mr-3
               -translate-y-1/2 translate-x-2
               whitespace-nowrap rounded-xl
               bg-[var(--text)] px-4 py-2
               text-xs font-bold text-white
               opacity-0 shadow-lg
               transition-all duration-300
               group-hover:translate-x-0
               group-hover:opacity-100"
    >
        تواصل معنا عبر واتساب
    </span>


    {{-- WhatsApp Button --}}
    <span
        class="relative flex h-14 w-14 items-center justify-center
               rounded-full
               bg-[#25D366]
               text-white
               shadow-[0_8px_25px_rgba(37,211,102,0.30)]
               transition-all duration-300
               hover:-translate-y-1
               hover:scale-110
               hover:shadow-[0_12px_30px_rgba(37,211,102,0.45)]"
    >

        {{-- Pulse --}}
        <span
            class="absolute inset-0
                   rounded-full
                   bg-[#25D366]
                   opacity-20
                   animate-ping"
        ></span>


        {{-- WhatsApp Icon --}}
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="relative z-10 h-7 w-7"
        >
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.008-.372-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"
            />

            <path
                d="M20.52 3.449C18.24 1.245 15.236.034 12.037.034 5.486.034.15 5.37.15 11.921c0 2.104.549 4.159 1.59 5.971L.062 23.927l6.173-1.62a11.87 11.87 0 0 0 5.802 1.474h.005c6.55 0 11.887-5.336 11.887-11.887 0-3.18-1.237-6.176-3.409-8.445zM12.04 21.785h-.004a9.85 9.85 0 0 1-5.02-1.374l-.36-.214-3.663.961.978-3.572-.234-.367a9.86 9.86 0 0 1-1.51-5.298c0-5.463 4.448-9.91 9.917-9.91 2.65 0 5.143 1.034 7.015 2.91a9.87 9.87 0 0 1 2.895 7.02c-.003 5.46-4.45 9.908-9.914 9.908z"
            />
        </svg>

    </span>

</a>


{{-- =========================================================
     GLOBAL SCRIPTS
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | Add To Cart
    |--------------------------------------------------------------------------
    */

    const forms =
        document.querySelectorAll('.add-to-cart-form');


    const cartCountElement =
        document.getElementById('cart-count');


    const toast =
        document.getElementById('cart-toast');


    let toastTimer = null;


    function showToast() {

        if (!toast) {
            return;
        }


        clearTimeout(toastTimer);


        toast.classList.remove(
            'opacity-0',
            'translate-y-5'
        );


        toast.classList.add(
            'opacity-100',
            'translate-y-0'
        );


        toastTimer = setTimeout(function () {

            toast.classList.remove(
                'opacity-100',
                'translate-y-0'
            );


            toast.classList.add(
                'opacity-0',
                'translate-y-5'
            );

        }, 2500);

    }


    forms.forEach(function (form) {

        form.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                const button =
                    form.querySelector('.add-to-cart-btn');


                const buttonText =
                    form.querySelector('.add-to-cart-text');


                if (!button || button.disabled) {
                    return;
                }


                const originalText =
                    buttonText
                        ? buttonText.textContent
                        : 'أضف للسلة';


                button.disabled = true;


                if (buttonText) {

                    buttonText.textContent =
                        'جاري الإضافة...';

                }


                try {

                    const response =
                        await fetch(
                            form.action,
                            {
                                method: 'POST',

                                headers: {

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute(
                                                'content'
                                            ),

                                    'X-Requested-With':
                                        'XMLHttpRequest',

                                    'Accept':
                                        'application/json'

                                },

                                body:
                                    new FormData(form)
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            'حدث خطأ أثناء إضافة المنتج'
                        );

                    }


                    const data =
                        await response.json();


                    const newCount =
                        data.cart_count ??
                        data.count;


                    if (
                        cartCountElement &&
                        newCount !== undefined
                    ) {

                        cartCountElement.textContent =
                            newCount;


                        if (Number(newCount) > 0) {

                            cartCountElement.classList.remove(
                                'hidden'
                            );

                        } else {

                            cartCountElement.classList.add(
                                'hidden'
                            );

                        }

                    }


                    showToast();


                    if (buttonText) {

                        buttonText.textContent =
                            'تمت الإضافة ✓';

                    }


                    setTimeout(function () {

                        if (buttonText) {

                            buttonText.textContent =
                                originalText;

                        }


                        button.disabled = false;

                    }, 1200);


                } catch (error) {

                    console.error(error);


                    if (buttonText) {

                        buttonText.textContent =
                            'حاولي مرة أخرى';

                    }


                    setTimeout(function () {

                        if (buttonText) {

                            buttonText.textContent =
                                originalText;

                        }


                        button.disabled = false;

                    }, 1500);

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Smooth Anchors
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('a[href*="#"]')
        .forEach(function (link) {

            link.addEventListener(
                'click',
                function (event) {

                    const url =
                        new URL(
                            link.href,
                            window.location.origin
                        );


                    if (
                        url.pathname !==
                        window.location.pathname
                    ) {
                        return;
                    }


                    const id =
                        url.hash;


                    if (!id) {
                        return;
                    }


                    const element =
                        document.querySelector(id);


                    if (!element) {
                        return;
                    }


                    event.preventDefault();


                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Navbar Shadow
    |--------------------------------------------------------------------------
    */

    const navbar =
        document.getElementById('navbar');


    window.addEventListener(
        'scroll',
        function () {

            if (!navbar) {
                return;
            }


            if (window.scrollY > 20) {

                navbar.style.boxShadow =
                    '0 5px 25px rgba(80,50,100,.06)';

            } else {

                navbar.style.boxShadow =
                    'none';

            }

        },
        {
            passive: true
        }
    );

});

</script>


@yield('scripts')



</body>
</html>
