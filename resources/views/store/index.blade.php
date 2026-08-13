@extends('store.layouts.app')

@section('title', 'أوركيدس — منتجات مميزة')

@section('meta_description')
أوركيدس — وجهتك لاكتشاف منتجات مميزة من علامات تجارية مختارة بعناية.
@endsection

@section('styles')

<style>
    /* =========================================================
       HERO
    ========================================================= */

    .hero {
        position: relative;
        min-height: 52vh;
        display: flex;
        align-items: center;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 85% 25%,
                rgba(139, 107, 177, .18),
                transparent 35%
            ),
            radial-gradient(
                circle at 10% 90%,
                rgba(139, 107, 177, .10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #faf7fd 0%,
                #f1eaf8 100%
            );
    }

    .hero::before {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: rgba(139, 107, 177, .08);
        top: -220px;
        right: -100px;
    }

    .hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(139, 107, 177, .06);
        bottom: -160px;
        left: 8%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 999px;
        background: rgba(139, 107, 177, .10);
        color: var(--purple-dark);
        font-size: 12px;
        font-weight: 700;
    }

    .hero-title {
        color: var(--text);
    }

    .hero-highlight {
        color: var(--purple);
    }

    .hero-description {
        color: var(--muted);
    }

    .primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        background: var(--purple);
        color: white;

        padding: 13px 25px;
        border-radius: 999px;

        font-size: 14px;
        font-weight: 700;

        transition:
            background .25s ease,
            transform .25s ease,
            box-shadow .25s ease;
    }

    .primary-btn:hover {
        background: var(--purple-dark);
        color: white;
        transform: translateY(-2px);

        box-shadow:
            0 10px 25px rgba(111, 79, 152, .20);
    }

    .secondary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 13px 25px;

        border-radius: 999px;

        border: 1px solid rgba(139, 107, 177, .25);

        color: var(--purple-dark);

        font-size: 14px;
        font-weight: 700;

        transition: all .25s ease;
    }

    .secondary-btn:hover {
        background: white;
        border-color: var(--purple);
        color: var(--purple-dark);
    }


    /* =========================================================
       HERO CARD
    ========================================================= */

    .hero-card {
        position: relative;

        width: min(100%, 420px);

        aspect-ratio: 1 / .78;

        border-radius: 28px;

        background:
            linear-gradient(
                145deg,
                rgba(255, 255, 255, .90),
                rgba(231, 220, 242, .75)
            );

        border:
            1px solid rgba(139, 107, 177, .14);

        box-shadow:
            0 25px 60px rgba(70, 45, 90, .10);

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;
    }

    .hero-card::before {
        content: "";

        position: absolute;

        width: 210px;
        height: 210px;

        border-radius: 50%;

        background: rgba(139, 107, 177, .15);
    }

    .hero-card-logo {
        position: relative;
        z-index: 2;

        font-family: 'El Messiri', serif;

        font-size: clamp(
            3rem,
            8vw,
            5rem
        );

        font-weight: 700;

        color: var(--purple);
    }

    .hero-card-small {
        position: absolute;

        bottom: 24px;
        left: 24px;
        right: 24px;

        background: rgba(255, 255, 255, .80);

        backdrop-filter: blur(10px);

        border:
            1px solid rgba(139, 107, 177, .10);

        border-radius: 16px;

        padding: 12px 16px;

        display: flex;
        justify-content: space-between;
        align-items: center;

        font-size: 12px;

        color: var(--muted);
    }


    /* =========================================================
       MARQUEE
    ========================================================= */

    .marquee-wrapper {
        overflow: hidden;
        background: var(--purple);
        color: white;
    }

    .marquee {
        display: flex;
        width: max-content;
        animation: marquee 30s linear infinite;
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(50%);
        }
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .section-label {
        color: var(--purple);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
    }


    /* =========================================================
       CATEGORIES
    ========================================================= */

    .category-card {
        min-height: 155px;
    }

    .category-card:hover {
        box-shadow:
            0 18px 40px rgba(70, 45, 90, .09);
    }


    /* =========================================================
       PRODUCTS
    ========================================================= */

    .product-card {
        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);

        box-shadow:
            0 20px 45px rgba(60, 40, 80, .10);

        border-color:
            rgba(139, 107, 177, .18);
    }

    .product-image {
        isolation: isolate;
    }

    .product-card .add-cart {
        min-height: 46px;
    }

    .product-card .details-btn {
        min-height: 46px;
    }


    /* =========================================================
       STORY
    ========================================================= */

    .story-section {
        background: var(--purple-soft);
    }

    .story-box {
        background: white;

        border-radius: 28px;

        border:
            1px solid rgba(139, 107, 177, .10);
    }

    .story-number {
        color: var(--purple);

        font-family: 'El Messiri', serif;

        font-size: 25px;

        font-weight: 700;
    }


    /* =========================================================
       FEATURES
    ========================================================= */

    .feature-card {
        background: white;

        border:
            1px solid rgba(40, 30, 50, .07);

        border-radius: 22px;

        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }

    .feature-card:hover {
        transform: translateY(-4px);

        box-shadow:
            0 15px 35px rgba(60, 40, 80, .08);
    }

    .feature-icon {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 52px;
        height: 52px;

        border-radius: 16px;

        background: var(--purple-soft);

        color: var(--purple);
    }


    /* =========================================================
       SPIN WHEEL
    ========================================================= */

    /* =========================
   SPIN TRIGGER
========================= */

.spin-trigger {
    position: relative;

    display: inline-flex;
    align-items: center;
    gap: 13px;

    width: 260px;
    min-height: 70px;

    padding: 10px 14px;

    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 18px;

    background: linear-gradient(
        135deg,
        #8b6bb1 0%,
        #6f4f98 100%
    );

    color: #ffffff !important;

    font-family: 'El Messiri', serif;

    cursor: pointer;

    box-shadow:
        0 14px 30px rgba(111, 79, 152, 0.22);

    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease,
        background 0.25s ease;

    overflow: hidden;

    appearance: none;
    -webkit-appearance: none;
}

/* منع أي تغيير للون النص */

.spin-trigger,
.spin-trigger:hover,
.spin-trigger:focus,
.spin-trigger:active {
    color: #ffffff !important;
}

/* إزالة أي outline غير مرغوب */

.spin-trigger:focus {
    outline: none;
}

/* تأثير الإضاءة */

.spin-trigger::before {
    content: "";

    position: absolute;

    width: 100px;
    height: 100px;

    top: -50px;
    left: -25px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.10);

    pointer-events: none;
}

/* Hover */

.spin-trigger:hover {
    transform: translateY(-3px);

    background: linear-gradient(
        135deg,
        #795a9d 0%,
        #634879 100%
    );

    box-shadow:
        0 18px 38px rgba(111, 79, 152, 0.32);
}

/* =========================
   ICON
========================= */

.spin-trigger-icon {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: center;

    width: 46px;
    height: 46px;

    flex-shrink: 0;

    border-radius: 14px;

    background: rgba(255, 255, 255, 0.16);

    border: 1px solid rgba(255, 255, 255, 0.18);

    color: #ffffff !important;

    font-size: 22px;

    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

/* =========================
   CONTENT
========================= */

.spin-trigger-content {
    position: relative;
    z-index: 2;

    display: flex;

    flex-direction: column;

    align-items: flex-start;

    flex: 1;

    text-align: right;

    color: #ffffff !important;
}

.spin-trigger-title {
    display: block;

    color: #ffffff !important;

    font-size: 14px;

    font-weight: 800;

    line-height: 1.5;
}

.spin-trigger-subtitle {
    display: block;

    margin-top: 2px;

    color: rgba(255, 255, 255, 0.78) !important;

    font-size: 10px;

    font-weight: 500;

    line-height: 1.6;
}

/* =========================
   ARROW
========================= */

.spin-trigger-arrow {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;
    justify-content: center;

    width: 31px;
    height: 31px;

    flex-shrink: 0;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.12);

    color: #ffffff !important;

    font-size: 15px;

    transition:
        transform 0.25s ease,
        background 0.25s ease;
}

.spin-trigger:hover .spin-trigger-arrow {
    transform: translateX(-4px);

    background: rgba(255, 255, 255, 0.22);

    color: #ffffff !important;
}

/* =========================
   MOBILE
========================= */

@media (max-width: 639px) {

    .spin-trigger {
        width: 100%;
        max-width: 340px;
    }

}
    .spin-modal {
        position: fixed;
        inset: 0;

        z-index: 9999;

        display: none;

        align-items: center;
        justify-content: center;

        padding: 20px;
    }

    .spin-modal.active {
        display: flex;
    }

    .spin-overlay {
        position: absolute;
        inset: 0;

        background: rgba(35, 27, 40, .65);

        backdrop-filter: blur(7px);
    }

    .spin-card {
        position: relative;
        z-index: 2;

        width: min(460px, 100%);

        padding: 30px 24px;

        border-radius: 30px;

        background: #fff;

        border:
            1px solid var(--orchid-200);

        box-shadow:
            0 30px 100px -30px rgba(40, 25, 50, .5);

        text-align: center;
    }

    .spin-close {
        position: absolute;

        top: 14px;
        right: 16px;

        width: 36px;
        height: 36px;

        border: none;
        border-radius: 50%;

        background: var(--orchid-100);
        color: var(--orchid-700);

        font-size: 24px;

        cursor: pointer;
    }

    .spin-kicker {
        display: inline-flex;

        padding: 6px 12px;

        border-radius: 999px;

        background: var(--orchid-100);

        border:
            1px solid var(--orchid-200);

        color: var(--orchid-700);

        font-size: 11px;
    }

    .spin-header h2 {
        margin-top: 12px;

        color: var(--ink);

        font-size: 28px;
    }

    .spin-header p {
        margin-top: 6px;

        color: var(--muted);

        font-size: 13px;
    }

    .wheel-wrapper {
        position: relative;

        width: 300px;
        height: 300px;

        margin: 28px auto;
    }

    .spin-wheel {
        position: relative;

        width: 300px;
        height: 300px;

        border-radius: 50%;

        overflow: hidden;

        border: 10px solid #fff;

        box-shadow:
            0 20px 45px -20px rgba(80, 50, 90, .45),
            0 0 0 1px var(--orchid-300);

        transition:
            transform 5s cubic-bezier(.12, .72, .16, 1);
    }

    .wheel-item {
        position: absolute;

        inset: 0;

        display: flex;

        align-items: flex-start;
        justify-content: center;

        padding-top: 30px;

        color: #fff;

        font-family: 'El Messiri', serif;

        font-size: 12px;
        font-weight: 700;

        transform-origin: center center;
    }

    .wheel-item span {
        width: 90px;

        text-align: center;

        transform: rotate(0deg);
    }

    .wheel-center {
        position: absolute;

        z-index: 5;

        top: 50%;
        left: 50%;

        width: 65px;
        height: 65px;

        display: flex;

        align-items: center;
        justify-content: center;

        transform:
            translate(-50%, -50%);

        border-radius: 50%;

        background: #fff;

        border:
            5px solid var(--orchid-500);

        box-shadow:
            0 8px 20px rgba(60, 40, 70, .2);

        font-size: 25px;
    }

    .wheel-pointer {
        position: absolute;

        z-index: 10;

        top: -13px;
        left: 50%;

        transform:
            translateX(-50%);

        color: var(--orchid-700);

        font-size: 30px;

        line-height: 1;
    }

    /* =========================
   SPIN BUTTON
========================= */

.spin-button {
    width: 100%;
    min-height: 56px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    border-radius: 999px;

    background: linear-gradient(
        135deg,
        #8b6bb1 0%,
        #6f4f98 100%
    );

    color: #ffffff !important;

    font-family: 'El Messiri', serif;
    font-size: 15px;
    font-weight: 700;

    cursor: pointer;

    box-shadow:
        0 15px 35px -15px rgba(125, 96, 147, .65);

    transition:
        transform .25s ease,
        background .25s ease,
        box-shadow .25s ease;

    appearance: none;
    -webkit-appearance: none;
}

/* مهم: تثبيت لون النص في جميع الحالات */

.spin-button,
.spin-button:hover,
.spin-button:focus,
.spin-button:active {
    color: #ffffff !important;
}

/* Hover */

.spin-button:hover {
    background: linear-gradient(
        135deg,
        #795a9d 0%,
        #634879 100%
    );

    color: #ffffff !important;

    transform: translateY(-2px);

    box-shadow:
        0 18px 40px -15px rgba(111, 79, 152, .75);
}

/* Focus */

.spin-button:focus {
    outline: none;
}

/* الضغط */

.spin-button:active {
    transform: translateY(0);

    color: #ffffff !important;
}

/* Disabled */

.spin-button:disabled {
    background: #b9abc4 !important;

    color: #ffffff !important;

    opacity: .65;

    cursor: not-allowed;

    transform: none;

    box-shadow: none;
}

    .spin-result {
        min-height: 55px;

        margin-top: 18px;
    }

    .spin-result-title {
        color: var(--orchid-700);

        font-family: 'El Messiri', serif;

        font-size: 19px;

        font-weight: 700;
    }

    .spin-coupon {
        margin-top: 8px;

        padding: 11px;

        border-radius: 13px;

        background: var(--orchid-100);

        border:
            1px dashed var(--orchid-400);

        color: var(--orchid-700);

        font-family: monospace;

        font-weight: 700;

        letter-spacing: 1px;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 767px) {

        .hero {
            min-height: auto;

            padding-top: 115px;
            padding-bottom: 55px;
        }

        .hero-card {
            margin: 20px auto 0;

            aspect-ratio: 1 / .65;
        }

        .hero-title {
            font-size: 42px;
        }
    }

    @media (max-width: 639px) {

        .category-card {
            min-height: 145px;
            padding: 16px;
        }
    }

    @media (max-width: 400px) {

        .wheel-wrapper,
        .spin-wheel {
            width: 260px;
            height: 260px;
        }
    }

    @media (max-width: 575px) {

        .product-card {
            border-radius: 20px;
        }

        .product-card .p-5 {
            padding: 18px;
        }
    }
</style>

@endsection


@section('content')

{{-- =========================================================
     HERO
========================================================= --}}

<section class="hero">

    <div class="mx-auto w-full max-w-7xl px-5 sm:px-8 lg:px-12">

        <div
            class="grid items-center gap-10 py-12 md:grid-cols-2 md:py-14 lg:gap-20"
        >

            <div class="hero-content">

                <span class="hero-label">

                    <span>✦</span>

                    منتجات مختارة بعناية

                </span>

                <h1
                    class="hero-title font-display mt-6 text-5xl font-bold leading-[1.15] sm:text-6xl lg:text-7xl"
                >

                    اكتشفي

                    <span class="hero-highlight">
                        المميز
                    </span>

                    <br>

                    في مكان واحد

                </h1>

                <p
                    class="hero-description mt-6 max-w-xl text-base leading-8 sm:text-lg"
                >

                    أوركيدس يجمع لك منتجات مميزة من علامات تجارية
                    مختارة بعناية، لتجدي ما يناسبك بسهولة وبثقة.

                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="#products"
                        class="primary-btn"
                    >

                        اكتشفي المنتجات

                        <span>←</span>

                    </a>

                    <a
                        href="#story"
                        class="secondary-btn"
                    >

                        تعرّفي على أوركيدس

                    </a>

                </div>

            </div>


            {{-- Hero Visual --}}

            <div class="hidden justify-center md:flex">

                <div class="hero-card">

                    <div class="hero-card-logo">
                        أوركيدس
                    </div>

                    <div class="hero-card-small">

                        <span>
                            مختارات مميزة
                        </span>

                        <span class="font-bold text-[var(--purple)]">
                            ORQUIDS
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     SPIN WHEEL BUTTON
========================================================= --}}

<div class="mx-auto flex max-w-7xl justify-center px-5 py-8">

<div class="mt-4">
    <button
        type="button"
        id="openSpinWheel"
        class="spin-trigger"
    >
        <span class="spin-trigger-icon">
            🎁
        </span>

        <span class="spin-trigger-content">
            <span class="spin-trigger-title">
                اربحي خصمك
            </span>

            <span class="spin-trigger-subtitle">
                لفة واحدة واحصلي على مفاجأتك
            </span>
        </span>

        <span class="spin-trigger-arrow">
            ←
        </span>
    </button>
</div>

</div>


{{-- =========================================================
     SPIN WHEEL MODAL
========================================================= --}}

<div
    id="spinWheelModal"
    class="spin-modal"
>

    <div class="spin-overlay"></div>

    <div class="spin-card">

        <button
            type="button"
            id="closeSpinWheel"
            class="spin-close"
        >
            ×
        </button>

        <div class="spin-header">

            <span class="spin-kicker">
                عرض خاص
            </span>

            <h2 class="font-display">
                عجلة أوركيدس
            </h2>

            <p>
                لفة واحدة فقط واحصلي على عرضك.
            </p>

        </div>


        <div class="wheel-wrapper">

            <div class="wheel-pointer">
                ▼
            </div>

            <div
                id="spinWheel"
                class="spin-wheel"
            >

                @php
                    $wheelPrizes = \App\Models\SpinPrize::where(
                        'is_active',
                        true
                    )
                    ->orderBy('sort_order')
                    ->get();
                @endphp

                @foreach($wheelPrizes as $prize)

                    <div
                        class="wheel-item"
                        data-prize-id="{{ $prize->id }}"
                    >

                        <span>
                            {{ $prize->name }}
                        </span>

                    </div>

                @endforeach

            </div>

            <div class="wheel-center">
                🎁
            </div>

        </div>


        <button
            type="button"
            id="spinButton"
            class="spin-button"
        >
            ابدأ الدوران
        </button>


        <div
            id="spinResult"
            class="spin-result"
        ></div>

    </div>

</div>


{{-- =========================================================
     SPIN WHEEL SCRIPT
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('spinWheelModal');
    const openButton = document.getElementById('openSpinWheel');
    const closeButton = document.getElementById('closeSpinWheel');
    const spinButton = document.getElementById('spinButton');
    const wheel = document.getElementById('spinWheel');
    const result = document.getElementById('spinResult');

    if (
        !modal ||
        !openButton ||
        !closeButton ||
        !spinButton ||
        !wheel
    ) {
        return;
    }

    const items = Array.from(
        wheel.querySelectorAll('.wheel-item')
    );

    const count = items.length;

    if (!count) {
        return;
    }

    const colors = [
        '#7d6093',
        '#9474aa',
        '#ae91c2',
        '#684f78',
        '#cdb8dc'
    ];

    const segment = 360 / count;

    const gradients = [];

    items.forEach(function (item, index) {

        const start = index * segment;
        const end = start + segment;

        gradients.push(
            `${colors[index % colors.length]} ${start}deg ${end}deg`
        );

        item.style.transform =
            `rotate(${start}deg)`;

        const span = item.querySelector('span');

        if (span) {

            span.style.transform =
                `rotate(${segment / 2}deg)`;
        }
    });

    wheel.style.background =
        `conic-gradient(${gradients.join(',')})`;


    /* =====================================================
       OPEN MODAL
    ===================================================== */

    openButton.addEventListener('click', function () {

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';

    });


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    closeButton.addEventListener('click', function () {

        modal.classList.remove('active');

        document.body.style.overflow = '';

    });


    /* =====================================================
       OVERLAY CLOSE
    ===================================================== */

    const overlay = modal.querySelector('.spin-overlay');

    if (overlay) {

        overlay.addEventListener('click', function () {

            modal.classList.remove('active');

            document.body.style.overflow = '';

        });
    }


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            modal.classList.contains('active')
        ) {

            modal.classList.remove('active');

            document.body.style.overflow = '';

        }

    });


    /* =====================================================
       SPIN
    ===================================================== */

    let currentRotation = 0;

    spinButton.addEventListener('click', async function () {

        spinButton.disabled = true;

        result.innerHTML = '';

        try {

            const response = await fetch(
                "{{ route('spin-wheel.spin') }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.getAttribute('content')
                    },

                    body: JSON.stringify({})
                }
            );


            const data = await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'حدث خطأ أثناء الدوران.'
                );
            }


            /* =================================================
               FIND WINNING PRIZE
            ================================================= */

            const winningIndex =
                items.findIndex(function (item) {

                    const text =
                        item.innerText.trim();

                    return text ===
                        data.prize.name;

                });


            if (winningIndex === -1) {

                throw new Error(
                    'تعذر تحديد الجائزة.'
                );
            }


            /* =================================================
               CALCULATE ROTATION
            ================================================= */

            const segmentCenter =
                (winningIndex * segment) +
                (segment / 2);

            const targetRotation =
                360 -
                segmentCenter;

            currentRotation +=
                360 * 6 +
                targetRotation;


            wheel.style.transform =
                `rotate(${currentRotation}deg)`;


            /* =================================================
               SHOW RESULT
            ================================================= */

            setTimeout(function () {

                let html = `
                    <div class="spin-result-title">
                        🎉 مبروك!
                    </div>

                    <div
                        style="
                            margin-top:6px;
                            color:#332b38;
                        "
                    >
                        ${escapeHtml(data.prize.name)}
                    </div>
                `;


                if (data.coupon_code) {

                    html += `
                        <div class="spin-coupon-wrapper">
                            <div class="spin-coupon">
                                ${escapeHtml(data.coupon_code)}
                            </div>

                            <button
                                type="button"
                                class="copy-spin-coupon"
                                data-code="${escapeHtml(data.coupon_code)}"
                                style="
                                    margin-top: 10px;
                                    background: #111;
                                    color: #fff;
                                    border: 0;
                                    padding: 8px 16px;
                                    border-radius: 8px;
                                    cursor: pointer;
                                    font-size: 12px;
                                "
                            >
                                <i class="bi bi-copy"></i>
                                نسخ الكود
                            </button>

                            <div
                                style="
                                    margin-top:7px;
                                    color:#8c8292;
                                    font-size:11px;
                                "
                            >
                                استخدم هذا الكود في صفحة إتمام الطلب.
                            </div>
                        </div>
                    `;
                }

                document.addEventListener('click', function (e) {

                const button = e.target.closest('.copy-spin-coupon');

                if (!button) return;

                const code = button.dataset.code;

                navigator.clipboard.writeText(code).then(() => {

                    const original = button.innerHTML;

                    button.innerHTML = `
                        <i class="bi bi-check-lg"></i>
                        تم النسخ
                    `;

                    setTimeout(() => {
                        button.innerHTML = original;
                    }, 1500);

                });

            });

                document.addEventListener('click', async function (e) {

                const button = e.target.closest('.copy-spin-coupon');

                if (!button) {
                    return;
                }

                const code = button.dataset.code;
                const icon = button.querySelector('i');

                try {

                    await navigator.clipboard.writeText(code);

                } catch (error) {

                    const textarea = document.createElement('textarea');

                    textarea.value = code;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';

                    document.body.appendChild(textarea);

                    textarea.select();
                    document.execCommand('copy');

                    textarea.remove();
                }

                const originalIcon = icon.className;

                icon.className = 'bi bi-check-lg';

                button.style.background = '#f3f8f4';
                button.style.color = '#386044';
                button.style.borderColor = '#cfe2d3';

                button.title = 'تم نسخ الكود';

                setTimeout(() => {

                    icon.className = originalIcon;

                    button.style.background = '#fff';
                    button.style.color = '#7d6093';
                    button.style.borderColor = '#e2d5ed';

                    button.title = 'نسخ الكود';

                }, 1500);

            });


                result.innerHTML = html;


                spinButton.innerText =
                    'تم استخدام فرصة الدوران';


            }, 5000);


        } catch (error) {

            console.error(error);


            result.innerHTML = `
                <div
                    style="
                        color:#873f4c;
                        font-size:13px;
                    "
                >
                    ${escapeHtml(error.message)}
                </div>
            `;


            spinButton.disabled = false;

        }

    });


    /* =====================================================
       SIMPLE HTML ESCAPE
    ===================================================== */

    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;
    }

});
</script>



{{-- =========================================================
     MARQUEE
========================================================= --}}

<section class="marquee-wrapper py-4">

    <div class="marquee">

        @for ($i = 0; $i < 2; $i++)

            <div class="flex shrink-0 items-center">

                @foreach([
                    'منتجات مميزة',
                    'علامات مختارة',
                    'جودة نهتم بها',
                    'تجربة سهلة',
                    'دفع آمن',
                    'شحن سريع'
                ] as $word)

                    <span
                        class="font-display px-8 text-lg font-medium"
                    >
                        {{ $word }}
                    </span>

                    <span class="text-sm opacity-70">
                        ✦
                    </span>

                @endforeach

            </div>

        @endfor

    </div>

</section>


{{-- =========================================================
     CATEGORIES
========================================================= --}}

<section
    id="categories"
    class="bg-[var(--cream)] py-20 sm:py-24"
>

    <div
        class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12"
    >

        {{-- Header --}}

        <div
            class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
        >

            <div>

                <span
                    class="inline-flex items-center gap-2 text-xs font-extrabold tracking-wider text-[var(--purple)]"
                >

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-[var(--purple)]"
                    ></span>

                    اكتشف مجموعتنا

                </span>


                <h2
                    class="font-display mt-2 text-2xl font-extrabold text-[var(--text)] sm:text-3xl"
                >
                    تصفح حسب التصنيف
                </h2>


                <p
                    class="mt-2 text-sm leading-7 text-[var(--muted)]"
                >
                    اختر التصنيف الذي يناسبك واستكشف المنتجات المتاحة.
                </p>

            </div>


            {{-- All Products --}}

            <button
                type="button"
                id="all-products-btn"
                class="group relative z-50 inline-flex w-fit cursor-pointer items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition
                {{ !request('category')
                    ? 'bg-[var(--purple)] text-white shadow-md shadow-purple-200'
                    : 'border border-gray-200 bg-white text-gray-700 hover:border-[var(--purple)] hover:text-[var(--purple)]' }}"
            >

                <span>
                    جميع المنتجات
                </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 6H18m0 0v4.5M18 6l-7 7"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18 13.5V18a1.5 1.5 0 01-1.5 1.5h-10A1.5 1.5 0 015 18V8a1.5 1.5 0 011.5-1.5H11"
                    />

                </svg>

            </button>

        </div>


        {{-- Categories --}}

        @if($categories->count())

            <div
                class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6"
            >

                @foreach($categories as $category)

                    @php

                        $isActive =
                            request('category') === $category->slug;

                        $categoryColors = [
                            'from-purple-50 to-white',
                            'from-violet-50 to-white',
                            'from-fuchsia-50 to-white',
                            'from-pink-50 to-white',
                            'from-indigo-50 to-white',
                            'from-slate-50 to-white',
                        ];

                        $colorClass =
                            $categoryColors[
                                $loop->index %
                                count($categoryColors)
                            ];

                    @endphp


                    <a
                        href="{{ route('store.index', ['category' => $category->slug]) }}"
                        class="category-card group relative overflow-hidden rounded-2xl border p-5 transition-all duration-300
                        {{ $isActive
                            ? 'border-[var(--purple)] bg-[var(--purple)] text-white shadow-lg shadow-purple-200'
                            : 'border-black/[0.06] bg-gradient-to-br ' . $colorClass . ' text-[var(--text)] hover:-translate-y-1 hover:border-[var(--purple)] hover:shadow-lg' }}"
                    >

                        {{-- Decorative Circle --}}

                        <div
                            class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full transition-all duration-500
                            {{ $isActive
                                ? 'bg-white/10'
                                : 'bg-[var(--purple)]/[0.05] group-hover:scale-150 group-hover:bg-[var(--purple)]/[0.08]' }}"
                        ></div>


                        {{-- Icon --}}

                        <div
                            class="relative mb-4 flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-300
                            {{ $isActive
                                ? 'bg-white/15 text-white'
                                : 'bg-[var(--purple-soft)] text-[var(--purple)] group-hover:bg-[var(--purple)] group-hover:text-white' }}"
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
                                    d="M4.5 5.25A2.25 2.25 0 016.75 3h4.5a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0111.25 12h-4.5A2.25 2.25 0 014.5 9.75v-4.5z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.5 14.25A2.25 2.25 0 0115.75 12h4.5a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0120.25 21h-4.5a2.25 2.25 0 01-2.25-2.25v-4.5z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.5 5.25A2.25 2.25 0 0115.75 3h4.5a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0120.25 12h-4.5a2.25 2.25 0 01-2.25-2.25v-4.5z"
                                />

                            </svg>

                        </div>


                        {{-- Category Name --}}

                        <div class="relative">

                            <h3
                                class="font-display line-clamp-1 text-base font-bold sm:text-lg"
                            >
                                {{ $category->name }}
                            </h3>


                            <div
                                class="mt-2 flex items-center gap-1.5 text-xs
                                {{ $isActive
                                    ? 'text-white/70'
                                    : 'text-[var(--muted)]' }}"
                            >

                                <span>
                                    {{ $category->products_count }}
                                </span>

                                <span>
                                    {{ $category->products_count == 1
                                        ? 'منتج'
                                        : 'منتجات'
                                    }}
                                </span>

                            </div>

                        </div>


                        {{-- Arrow --}}

                        <div
                            class="absolute bottom-4 left-4 flex h-7 w-7 items-center justify-center rounded-full transition-all duration-300
                            {{ $isActive
                                ? 'bg-white/10 text-white'
                                : 'bg-white text-gray-400 shadow-sm group-hover:-translate-x-1 group-hover:text-[var(--purple)]' }}"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-3.5 w-3.5"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5"
                                />

                            </svg>

                        </div>


                        {{-- Active Indicator --}}

                        @if($isActive)

                            <span
                                class="absolute right-3 top-3 flex h-2.5 w-2.5 rounded-full bg-white shadow-sm"
                            ></span>

                        @endif

                    </a>

                @endforeach

            </div>

        @else

            {{-- Empty Categories --}}

            <div
                class="rounded-3xl border border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center"
            >

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[var(--purple-soft)] text-[var(--purple)]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.5 5.25A2.25 2.25 0 016.75 3h4.5a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0111.25 12h-4.5A2.25 2.25 0 014.5 9.75v-4.5z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 14.25A2.25 2.25 0 0115.75 12h4.5a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0120.25 21h-4.5a2.25 2.25 0 01-2.25-2.25v-4.5z"
                        />

                    </svg>

                </div>

                <h3 class="mt-4 font-display text-lg font-bold">
                    لا توجد تصنيفات حاليًا
                </h3>

                <p class="mt-1 text-sm text-[var(--muted)]">
                    سيتم إضافة التصنيفات قريبًا.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     CATEGORY NAVIGATION SCRIPT
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const productsSection =
        document.getElementById('products');

    const allProductsButton =
        document.getElementById('all-products-btn');

    if (!productsSection) {
        return;
    }


    /* =====================================================
       CATEGORY PAGE
    ===================================================== */

    const url =
        new URL(window.location.href);

    const category =
        url.searchParams.get('category');


    if (category) {

        setTimeout(function () {

            productsSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 400);

    }


    /* =====================================================
       ALL PRODUCTS BUTTON
    ===================================================== */

    if (allProductsButton) {

        allProductsButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();


                sessionStorage.setItem(
                    'scrollToProducts',
                    '1'
                );


                const storeUrl =
                    @json(route('store.index'));


                window.location.href =
                    storeUrl;

            }
        );

    }


    /* =====================================================
       AFTER RELOAD
    ===================================================== */

    if (
        sessionStorage.getItem(
            'scrollToProducts'
        ) === '1'
    ) {

        sessionStorage.removeItem(
            'scrollToProducts'
        );


        setTimeout(function () {

            productsSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 500);

    }

});
</script>


{{-- =========================================================
     PRODUCTS
========================================================= --}}

<section
    id="products"
    class="bg-[var(--cream)] py-16 sm:py-20"
>

    <div
        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
    >

        {{-- =========================================================
             SECTION HEADER
        ========================================================== --}}

        <div
            class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
        >

            <div>

                <span class="section-label">
                    اختيارات أوركيدس
                </span>

                <h2
                    class="font-display mt-2 text-2xl font-bold sm:text-3xl"
                >
                    اكتشف منتجاتنا
                </h2>

                <p
                    class="mt-2 max-w-xl text-xs leading-6 text-[var(--muted)] sm:text-sm"
                >
                    مجموعة مختارة بعناية لتجد ما يناسبك بسهولة.
                </p>

            </div>


            {{-- عرض جميع المنتجات عند استخدام فلتر التصنيف --}}

            @if(request('category'))

                <a
                    href="{{ route('store.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-[var(--purple)] transition hover:opacity-70 sm:text-sm"
                >

                    عرض جميع المنتجات

                    <span>
                        ←
                    </span>

                </a>

            @endif

        </div>


        {{-- =========================================================
             PRODUCTS
        ========================================================== --}}

        @if($products->count())

            <div
                class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
            >

                @foreach($products as $product)

                    @php

                        $discount = null;

                        if (
                            $product->discount_price &&
                            $product->price > 0 &&
                            $product->discount_price < $product->price
                        ) {

                            $discount = round(
                                (
                                    (
                                        $product->price -
                                        $product->discount_price
                                    )
                                    /
                                    $product->price
                                ) * 100
                            );

                        }

                    @endphp


                    {{-- =================================================
                         PRODUCT CARD
                    ================================================== --}}

                    <article
                        class="product-card group overflow-hidden rounded-[18px] border border-black/[0.06] bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                    >

                        {{-- =================================================
                             PRODUCT IMAGE
                        ================================================== --}}

                        <a
                            href="{{ route('products.show', $product->slug) }}"
                            class="product-image relative block overflow-hidden bg-[#f7f5f8]"
                        >

                            @if($product->images->count())

                                <img
                                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    class="aspect-[4/4.5] w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                >

                            @else

                                <div
                                    class="flex aspect-[4/4.5] items-center justify-center text-xs text-[var(--muted)]"
                                >
                                    لا توجد صورة
                                </div>

                            @endif


                            {{-- Image Overlay --}}

                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"
                            ></div>


                            {{-- =================================================
                                 DISCOUNT
                            ================================================== --}}

                            @if($discount)

                                <span
                                    class="absolute right-2.5 top-2.5 rounded-full bg-[var(--purple)] px-2 py-1 text-[9px] font-bold text-white shadow-md sm:right-3 sm:top-3 sm:px-2.5 sm:py-1.5 sm:text-[10px]"
                                >
                                    خصم {{ $discount }}٪
                                </span>

                            @endif


                            {{-- =================================================
                                 CATEGORY ON IMAGE
                            ================================================== --}}

                            @if($product->category)

                                <span
                                    class="absolute bottom-2.5 right-2.5 rounded-full border border-white/60 bg-white/90 px-2 py-1 text-[9px] font-bold text-[var(--purple-dark)] shadow-sm backdrop-blur-md sm:bottom-3 sm:right-3 sm:px-2.5 sm:py-1.5 sm:text-[10px]"
                                >
                                    {{ $product->category->name }}
                                </span>

                            @endif

                        </a>


                        {{-- =================================================
                             PRODUCT INFO
                        ================================================== --}}

                        <div class="p-3 sm:p-3.5">

                            {{-- Category --}}

                            @if($product->category)

                                <a
                                    href="{{ route('store.index', [
                                        'category' => $product->category->slug
                                    ]) }}"
                                    class="mb-1.5 inline-flex items-center gap-1 text-[9px] font-bold text-[var(--purple)] transition hover:opacity-70 sm:text-[10px]"
                                >

                                    <span
                                        class="h-1 w-1 rounded-full bg-[var(--purple)] sm:h-1.5 sm:w-1.5"
                                    ></span>

                                    {{ $product->category->name }}

                                </a>

                            @endif


                            {{-- =================================================
                                 PRODUCT NAME
                            ================================================== --}}

                            <a
                                href="{{ route('products.show', $product->slug) }}"
                                class="block"
                            >

                                <h3
                                    class="product-title font-display line-clamp-1 text-sm font-bold text-[var(--text)] transition duration-200 group-hover:text-[var(--purple)] sm:text-base"
                                >
                                    {{ $product->name }}
                                </h3>

                            </a>


                            {{-- =================================================
                                 PRICE
                            ================================================== --}}

                            <div
                                class="mt-2.5 flex items-end justify-between gap-2"
                            >

                                <div>

                                    @if(
                                        $product->discount_price &&
                                        $product->discount_price < $product->price
                                    )

                                        <div
                                            class="flex flex-wrap items-center gap-1.5"
                                        >

                                            <span
                                                class="font-display text-base font-bold text-[var(--text)] sm:text-lg"
                                            >
                                                ${{ number_format($product->discount_price, 2) }}
                                            </span>

                                            <span
                                                class="text-[10px] text-gray-400 line-through sm:text-xs"
                                            >
                                                ${{ number_format($product->price, 2) }}
                                            </span>

                                        </div>

                                    @else

                                        <span
                                            class="font-display text-base font-bold text-[var(--text)] sm:text-lg"
                                        >
                                            ${{ number_format($product->price, 2) }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- =================================================
                                 ACTIONS
                            ================================================== --}}

                            <div
                                class="mt-3 grid grid-cols-[1fr_38px] gap-1.5 sm:grid-cols-[1fr_40px]"
                            >

                                {{-- Add To Cart --}}

                                <form
                                    action="{{ route('cart.add', $product) }}"
                                    method="POST"
                                    class="add-to-cart-form"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="quantity"
                                        value="1"
                                    >


                                    <button
                                        type="submit"
                                        class="add-cart add-to-cart-btn flex w-full items-center justify-center gap-1.5 rounded-lg bg-[var(--purple)] px-2 py-2.5 text-[10px] font-bold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-[var(--purple-dark)] hover:shadow-md sm:text-xs"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            class="h-3.5 w-3.5 sm:h-4 sm:w-4"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 15.75a2.25 2.25 0 002.184 1.7h7.132a2.25 2.25 0 002.184-1.7l1.644-6.578a.75.75 0 00-.728-.932H5.106"
                                            />

                                        </svg>


                                        <span class="add-to-cart-text">
                                            أضف للسلة
                                        </span>

                                    </button>

                                </form>


                                {{-- =================================================
                                     PRODUCT DETAILS
                                ================================================== --}}

                                <a
                                    href="{{ route('products.show', $product->slug) }}"
                                    class="details-btn flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 transition duration-300 hover:border-[var(--purple)] hover:bg-[var(--purple-soft)] hover:text-[var(--purple)]"
                                    title="عرض التفاصيل"
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
                                            d="M13.5 6H18m0 0v4.5M18 6l-7 7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M18 13.5V18a1.5 1.5 0 01-1.5 1.5h-10A1.5 1.5 0 015 18V8a1.5 1.5 0 011.5-1.5H11"
                                        />

                                    </svg>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- =========================================================
                 PAGINATION
            ========================================================== --}}

            @if(method_exists($products, 'links'))

                <div class="mt-10 flex justify-center">

                    {{ $products->withQueryString()->links() }}

                </div>

            @endif


        @else

            {{-- =========================================================
                 EMPTY STATE
            ========================================================== --}}

            <div
                class="rounded-[22px] border border-dashed border-purple-200 bg-white px-5 py-16 text-center shadow-sm"
            >

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[var(--purple-soft)] text-xl text-[var(--purple)]"
                >
                    ✦
                </div>

                <h3
                    class="font-display mt-4 text-xl font-bold"
                >
                    لا توجد منتجات حاليًا
                </h3>

                <p
                    class="mt-2 text-xs text-[var(--muted)] sm:text-sm"
                >
                    سيتم إضافة المنتجات قريبًا.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     STORY
========================================================= --}}

<section
    id="story"
    class="story-section py-20 sm:py-24"
>

    <div
        class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12"
    >

        <div
            class="grid items-center gap-12 lg:grid-cols-2"
        >

            <div class="story-box p-8 sm:p-12">

                <span class="section-label">
                    عن أوركيدس
                </span>

                <h2
                    class="font-display mt-4 text-4xl font-bold leading-tight sm:text-5xl"
                >

                    أكثر من متجر،

                    <br>

                    <span class="text-[var(--purple)]">
                        مساحة للاكتشاف.
                    </span>

                </h2>

                <p
                    class="mt-6 leading-8 text-[var(--muted)]"
                >

                    في أوركيدس، لا نريد أن نعرض لك مئات المنتجات
                    دون سبب. نبحث عن المنتجات التي تستحق أن نضعها
                    أمامك، من علامات تجارية مميزة وموثوقة.

                </p>

                <p
                    class="mt-4 leading-8 text-[var(--muted)]"
                >

                    هدفنا أن نجعل تجربة اكتشاف المنتجات وشرائها
                    أسهل، أبسط، وأكثر متعة.

                </p>

            </div>


            <div class="space-y-5">

                @foreach([
                    [
                        '01',
                        'اختيارات مميزة',
                        'نبحث عن المنتجات التي تتميز بالجودة والتفاصيل.'
                    ],
                    [
                        '02',
                        'علامات متنوعة',
                        'نمنحك فرصة اكتشاف منتجات من علامات تجارية مختلفة.'
                    ],
                    [
                        '03',
                        'تجربة بسيطة',
                        'من اكتشاف المنتج حتى إضافته للسلة، كل شيء واضح وسهل.'
                    ]
                ] as $item)

                    <div
                        class="flex gap-5 rounded-2xl bg-white p-6"
                    >

                        <span class="story-number">
                            {{ $item[0] }}
                        </span>

                        <div>

                            <h3
                                class="font-display text-xl font-bold"
                            >
                                {{ $item[1] }}
                            </h3>

                            <p
                                class="mt-2 text-sm leading-7 text-[var(--muted)]"
                            >
                                {{ $item[2] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     FEATURES
========================================================= --}}

<section
    id="features"
    class="bg-white py-20 sm:py-24"
>

    <div
        class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12"
    >

        <div class="mb-12 text-center">

            <span class="section-label">
                لماذا أوركيدس؟
            </span>

            <h2
                class="font-display mt-3 text-4xl font-bold sm:text-5xl"
            >
                تسوق ببساطة
            </h2>

        </div>


        <div class="grid gap-6 md:grid-cols-3">

            @foreach([
                [
                    'اختيارات مدروسة',
                    'نختار المنتجات بعناية بدلًا من عرض خيارات عشوائية.',
                    'M5 12l5 5L20 7'
                ],
                [
                    'دفع آمن',
                    'تجربة شراء آمنة وسهلة من خلال طرق الدفع المتاحة.',
                    'M9 12l2 2 4-4'
                ],
                [
                    'خدمة موثوقة',
                    'نهتم بتجربتك من لحظة اختيار المنتج وحتى استلام الطلب.',
                    'M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z'
                ]
            ] as $feature)

                <div class="feature-card p-8">

                    <div class="feature-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="{{ $feature[2] }}"
                            />

                        </svg>

                    </div>


                    <h3
                        class="font-display mt-6 text-xl font-bold"
                    >
                        {{ $feature[0] }}
                    </h3>


                    <p
                        class="mt-3 leading-7 text-[var(--muted)]"
                    >
                        {{ $feature[1] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection
