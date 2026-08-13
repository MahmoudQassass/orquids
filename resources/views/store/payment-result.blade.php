@extends('store.layouts.app')

@section('title')
@if($order->payment_status === 'paid')
تم الدفع بنجاح
@elseif($order->payment_status === 'failed')
فشل الدفع
@else
الدفع قيد المعالجة
@endif
| أوركيدس
@endsection

@section('meta_description', 'نتيجة عملية الدفع الخاصة بطلبك من أوركيدس')

@section('styles')

<style>
    /* =========================
       PAYMENT PAGE
    ========================= */

    body {
        background:
            radial-gradient(
                circle at 50% -10%,
                rgba(196, 181, 253, .35),
                transparent 40%
            ),
            #f5f3ff;
    }

    .payment-page {
        color: #2e1b47;
    }

    /* =========================
       MAIN CARD
    ========================= */

    .payment-card {
        background: #ffffff;
        border: 1px solid rgba(139, 92, 246, .10);
        border-radius: 2rem;
        overflow: hidden;

        box-shadow:
            0 30px 80px -25px rgba(76, 29, 149, .20);
    }

    /* =========================
       HERO
    ========================= */

    .hero {
        position: relative;
        overflow: hidden;

        padding: 3.8rem 1.5rem 3.2rem;

        text-align: center;
    }

    .hero::before {
        content: "";

        position: absolute;

        width: 420px;
        height: 420px;

        top: -260px;
        left: 50%;

        transform: translateX(-50%);

        border-radius: 50%;

        background:
            radial-gradient(
                circle,
                rgba(255,255,255,.65),
                transparent 70%
            );

        pointer-events: none;
    }

    .hero-paid {
        background:
            radial-gradient(
                circle at 50% 0%,
                rgba(167, 139, 250, .42),
                transparent 58%
            ),
            linear-gradient(
                135deg,
                #f5f3ff,
                #ede9fe
            );
    }

    .hero-failed {
        background:
            radial-gradient(
                circle at 50% 0%,
                rgba(244, 114, 182, .16),
                transparent 58%
            ),
            #fff4f7;
    }

    .hero-pending {
        background:
            radial-gradient(
                circle at 50% 0%,
                rgba(196, 181, 253, .38),
                transparent 58%
            ),
            #f5f3ff;
    }

    /* =========================
       STATUS ICON
    ========================= */

    .status-ring {
        width: 7rem;
        height: 7rem;

        margin-inline: auto;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9999px;

        border: 8px solid rgba(255,255,255,.9);

        box-shadow:
            0 20px 50px -20px rgba(76, 29, 149, .30);
    }

    .status-ring.paid {
        background: rgba(167, 139, 250, .32);
    }

    .status-ring.failed {
        background: rgba(244, 114, 182, .18);
    }

    .status-ring.pending {
        background: rgba(196, 181, 253, .28);
    }

    .status-inner {
        width: 4.5rem;
        height: 4.5rem;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9999px;
    }

    .status-inner.paid {
        background:
            linear-gradient(
                135deg,
                #7c3aed,
                #8b5cf6
            );

        color: #ffffff;

        box-shadow:
            0 12px 30px rgba(139, 92, 246, .35);
    }

    .status-inner.failed {
        background: #c2415a;
        color: #ffffff;

        box-shadow:
            0 12px 30px rgba(194, 65, 90, .25);
    }

    .status-inner.pending {
        background:
            linear-gradient(
                135deg,
                #a78bfa,
                #c4b5fd
            );

        color: #2e1b47;
    }

    .status-pop {
        animation:
            statusPop .8s cubic-bezier(.2, .9, .3, 1.2) both;
    }

    @keyframes statusPop {
        0% {
            transform: scale(.4);
            opacity: 0;
        }

        60% {
            transform: scale(1.08);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* =========================
       CHIPS
    ========================= */

    .chip {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: .5rem;

        padding: .48rem 1rem;

        border-radius: 9999px;

        font-size: .75rem;
        font-weight: 700;

        border: 1px solid transparent;
    }

    .chip .dot {
        width: .5rem;
        height: .5rem;

        border-radius: 9999px;

        flex-shrink: 0;
    }

    .chip-paid {
        background: rgba(255,255,255,.85);
        color: #5b21b6;

        border-color: rgba(139, 92, 246, .28);
    }

    .chip-paid .dot {
        background: #8b5cf6;
    }

    .chip-failed {
        background: #ffffff;
        color: #9f1239;

        border-color: rgba(194, 65, 90, .25);
    }

    .chip-failed .dot {
        background: #c2415a;
    }

    .chip-pending {
        background: #ffffff;
        color: #5b21b6;

        border-color: rgba(139, 92, 246, .28);
    }

    .chip-pending .dot {
        background: #8b5cf6;

        animation:
            pulseDot 1.4s ease-in-out infinite;
    }

    @keyframes pulseDot {
        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .5;
            transform: scale(1.35);
        }
    }

    /* =========================
       DETAILS
    ========================= */

    .details-box {
        overflow: hidden;

        border: 1px solid rgba(139, 92, 246, .10);

        border-radius: 1.25rem;

        background: #ffffff;

        box-shadow:
            0 8px 30px rgba(76, 29, 149, .04);
    }

    .row-item {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 1rem;

        padding: 1rem 1.15rem;
    }

    .row-item + .row-item {
        border-top: 1px solid rgba(139, 92, 246, .08);
    }

    .row-key {
        color: #8b8197;
        font-size: .9rem;
    }

    .row-val {
        color: #2e1b47;

        font-family: 'El Messiri', serif;

        font-weight: 600;

        text-align: left;
    }

    /* =========================
       INFO BOX
    ========================= */

    .info-card {
        display: flex;

        align-items: flex-start;

        gap: .9rem;

        padding: 1rem 1.15rem;

        border-radius: 1.25rem;

        border: 1px solid rgba(139, 92, 246, .10);

        background:
            linear-gradient(
                135deg,
                #f5f3ff,
                #ede9fe
            );
    }

    .info-card.warn {
        background:
            linear-gradient(
                135deg,
                #fff4f7,
                #fff1f4
            );

        border-color: rgba(194, 65, 90, .16);
    }

    .info-card.wait {
        background:
            linear-gradient(
                135deg,
                #f5f3ff,
                #ede9fe
            );
    }

    .icon-square {
        width: 2.5rem;
        height: 2.5rem;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: .75rem;

        background:
            linear-gradient(
                135deg,
                #7c3aed,
                #8b5cf6
            );

        color: #ffffff;

        box-shadow:
            0 8px 20px rgba(139, 92, 246, .22);
    }

    .info-card.warn .icon-square {
        background: #c2415a;
        color: #ffffff;
    }

    .info-card.wait .icon-square {
        background:
            linear-gradient(
                135deg,
                #a78bfa,
                #c4b5fd
            );

        color: #2e1b47;
    }

    /* =========================
       BUTTONS
    ========================= */

    .payment-btn {
        width: 100%;

        min-height: 3.5rem;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: .6rem;

        padding: 1rem 1.5rem;

        border-radius: 9999px;

        font-family: 'El Messiri', serif;

        font-weight: 600;

        transition:
            transform .3s ease,
            background-color .3s ease,
            color .3s ease,
            border-color .3s ease,
            box-shadow .3s ease;
    }

    .payment-btn-primary {
        background:
            linear-gradient(
                135deg,
                #6d28d9,
                #8b5cf6
            );

        color: #ffffff;

        border: 1px solid #7c3aed;

        box-shadow:
            0 14px 30px -15px rgba(109, 40, 217, .65);
    }

    .payment-btn-primary:hover {
        background:
            linear-gradient(
                135deg,
                #7c3aed,
                #a78bfa
            );

        border-color: #8b5cf6;

        box-shadow:
            0 18px 38px -15px rgba(139, 92, 246, .65);

        transform: translateY(-2px);
    }

    .payment-btn-secondary {
        background: #ffffff;

        color: #4c1d95;

        border: 1px solid rgba(139, 92, 246, .20);
    }

    .payment-btn-secondary:hover {
        background: #ede9fe;

        color: #5b21b6;

        border-color: rgba(139, 92, 246, .35);

        transform: translateY(-2px);
    }

    .arrow {
        display: inline-block;

        transition:
            transform .3s ease;
    }

    .payment-btn-primary:hover .arrow {
        transform: translateX(-5px);
    }

    /* =========================
       SPINNER
    ========================= */

    .spinner {
        width: 2rem;
        height: 2rem;

        border: 3px solid rgba(46, 27, 71, .12);

        border-top-color: #6d28d9;

        border-radius: 9999px;

        animation:
            spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* =========================
       SPARKLES
    ========================= */

    .sparkle {
        position: absolute;

        width: 7px;
        height: 7px;

        border-radius: 9999px;

        background:
            radial-gradient(
                circle,
                #8b5cf6,
                #c4b5fd
            );

        box-shadow:
            0 0 12px rgba(139, 92, 246, .55);

        opacity: 0;
    }

    /* =========================
       ANIMATION
    ========================= */

    .fx-fade {
        opacity: 0;
        transform: translateY(18px);
    }

    /* =========================
       SELECTION
    ========================= */

    .payment-page ::selection {
        background: #c4b5fd;
        color: #2e1b47;
    }

    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 640px) {

        .hero {
            padding:
                2.75rem
                1.25rem
                2.5rem;
        }

        .status-ring {
            width: 6.25rem;
            height: 6.25rem;
        }

        .status-inner {
            width: 4rem;
            height: 4rem;
        }

        .row-item {
            padding:
                .9rem 1rem;
        }

        .row-key {
            font-size: .82rem;
        }

        .row-val {
            font-size: .9rem;
        }
    }
</style>

@endsection

@section('content')

<div class="payment-page">

```
<main class="px-5 md:px-8 py-10 md:py-14">

    <div class="max-w-2xl mx-auto">

        {{-- =================================================
             SUCCESS
        ================================================= --}}

        @if($order->payment_status === 'paid')

            <article
                class="payment-card fx-fade"
                data-fx>

                {{-- HERO --}}

                <div class="hero hero-paid">

                    {{-- Sparkles --}}

                    <span
                        class="sparkle"
                        style="top:14%; right:18%;"></span>

                    <span
                        class="sparkle"
                        style="top:28%; left:22%;"></span>

                    <span
                        class="sparkle"
                        style="top:44%; right:12%;"></span>

                    <span
                        class="sparkle"
                        style="top:20%; left:44%;"></span>

                    <span
                        class="sparkle"
                        style="top:56%; left:14%;"></span>

                    <span
                        class="sparkle"
                        style="top:36%; right:38%;"></span>


                    {{-- STATUS --}}

                    <div class="status-ring paid status-pop">

                        <div class="status-inner paid">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-9 h-9"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                    </div>


                    <div class="mt-6">

                        <span class="chip chip-paid">

                            <span class="dot"></span>

                            تم تأكيد الدفع

                        </span>


                        <h1
                            class="font-display text-3xl sm:text-4xl md:text-5xl text-ink mt-4 leading-tight">

                            طلبك في أيدٍ أمينة

                        </h1>


                        <p
                            class="text-stone mt-3 leading-7 max-w-md mx-auto">

                            شكراً لثقتك بأوركيدس — تم استلام طلبك وتأكيد عملية الدفع بنجاح.

                        </p>

                    </div>

                </div>


                {{-- CONTENT --}}

                <div class="p-6 sm:p-8">

                    <div class="mb-5">

                        <h2 class="font-display text-xl text-ink">
                            تفاصيل الطلب
                        </h2>

                        <p class="text-stone text-sm mt-1">
                            احتفظي برقم الطلب للمتابعة.
                        </p>

                    </div>


                    <div class="details-box">

                        <div
                            class="row-item"
                            style="background:#f5f3ff;">

                            <span class="row-key">
                                رقم الطلب
                            </span>

                            <span class="row-val">
                                #{{ $order->id }}
                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                المبلغ المدفوع
                            </span>

                            <span class="row-val text-lg">

                                {{ number_format($order->total, 2) }}

                                <span class="text-purple text-xs">
                                    {{ config('services.paytabs.currency', 'EGP') }}
                                </span>

                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                الكمية
                            </span>

                            <span class="row-val">
                                {{ $order->quantity }}
                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                حالة الطلب
                            </span>

                            <span class="chip chip-paid">

                                <span class="dot"></span>

                                مدفوع

                            </span>

                        </div>

                    </div>


                    {{-- INFO --}}

                    <div class="info-card mt-6">

                        <span class="icon-square">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.6">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4" />

                            </svg>

                        </span>


                        <div>

                            <div class="font-display text-base">
                                ماذا بعد؟
                            </div>

                            <p class="text-stone text-sm mt-1 leading-6">

                                تم تسجيل طلبك بنجاح، وسيتواصل معك فريقنا خلال ساعات لتأكيد التفاصيل وتجهيز الشحن.

                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ route('store.index') }}"
                        class="payment-btn payment-btn-primary mt-7">

                        <span>
                            العودة إلى المتجر
                        </span>

                        <span class="arrow">
                            ←
                        </span>

                    </a>

                </div>

            </article>


        {{-- =================================================
             FAILED
        ================================================= --}}

        @elseif($order->payment_status === 'failed')

            <article
                class="payment-card fx-fade"
                data-fx>

                <div class="hero hero-failed">

                    <div class="status-ring failed status-pop">

                        <div class="status-inner failed">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-9 h-9"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 6l12 12M18 6L6 18" />

                            </svg>

                        </div>

                    </div>


                    <div class="mt-6">

                        <span class="chip chip-failed">

                            <span class="dot"></span>

                            لم يتم الدفع

                        </span>


                        <h1
                            class="font-display text-3xl sm:text-4xl md:text-5xl text-ink mt-4 leading-tight">

                            لم تكتمل عملية الدفع

                        </h1>


                        <p
                            class="text-stone mt-3 leading-7 max-w-md mx-auto">

                            لم نتمكن من تأكيد عملية الدفع لهذا الطلب. لا تقلقي — يمكنك المحاولة مرة أخرى بأمان.

                        </p>

                    </div>

                </div>


                <div class="p-6 sm:p-8">

                    <div class="details-box">

                        <div
                            class="row-item"
                            style="background:#fff1f4;">

                            <span class="row-key">
                                رقم الطلب
                            </span>

                            <span class="row-val">
                                #{{ $order->id }}
                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                المبلغ
                            </span>

                            <span class="row-val">

                                {{ number_format($order->total, 2) }}

                                <span class="text-purple text-xs">
                                    {{ config('services.paytabs.currency', 'EGP') }}
                                </span>

                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                حالة الدفع
                            </span>

                            <span class="chip chip-failed">

                                <span class="dot"></span>

                                فشل الدفع

                            </span>

                        </div>

                    </div>


                    <div class="info-card warn mt-6">

                        <span class="icon-square">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />

                            </svg>

                        </span>


                        <div>

                            <div class="font-display text-base">
                                ماذا يمكنك أن تفعلي؟
                            </div>

                            <p class="text-stone text-sm mt-1 leading-6">

                                تأكدي من بيانات البطاقة والرصيد المتاح، ثم أعيدي المحاولة أو استخدمي بطاقة أخرى.

                            </p>

                        </div>

                    </div>


                    <div class="grid sm:grid-cols-2 gap-3 mt-7">

                        <a
                            href="{{ route('store.checkout', ['quantity' => $order->quantity]) }}"
                            class="payment-btn payment-btn-primary">

                            <span>
                                المحاولة مرة أخرى
                            </span>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 4v6h6M20 20v-6h-6M5 10a8 8 0 0114-4M19 14a8 8 0 01-14 4" />

                            </svg>

                        </a>


                        <a
                            href="{{ route('store.index') }}"
                            class="payment-btn payment-btn-secondary">

                            العودة للمتجر

                        </a>

                    </div>

                </div>

            </article>


        {{-- =================================================
             PENDING
        ================================================= --}}

        @else

            <article
                class="payment-card fx-fade"
                data-fx>

                <div class="hero hero-pending">

                    <div class="status-ring pending status-pop">

                        <div class="status-inner pending">

                            <div class="spinner"></div>

                        </div>

                    </div>


                    <div class="mt-6">

                        <span class="chip chip-pending">

                            <span class="dot"></span>

                            قيد المعالجة

                        </span>


                        <h1
                            class="font-display text-3xl sm:text-4xl md:text-5xl text-ink mt-4 leading-tight">

                            الدفع قيد المعالجة

                        </h1>


                        <p
                            class="text-stone mt-3 leading-7 max-w-md mx-auto">

                            تم استلام طلبك، وننتظر التأكيد النهائي من بوابة الدفع. سيتم تحديث الحالة تلقائياً.

                        </p>

                    </div>

                </div>


                <div class="p-6 sm:p-8">

                    <div class="details-box">

                        <div
                            class="row-item"
                            style="background:#f5f3ff;">

                            <span class="row-key">
                                رقم الطلب
                            </span>

                            <span class="row-val">
                                #{{ $order->id }}
                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                المبلغ
                            </span>

                            <span class="row-val">

                                {{ number_format($order->total, 2) }}

                                <span class="text-purple text-xs">
                                    {{ config('services.paytabs.currency', 'EGP') }}
                                </span>

                            </span>

                        </div>


                        <div class="row-item">

                            <span class="row-key">
                                الحالة
                            </span>

                            <span class="chip chip-pending">

                                <span class="dot"></span>

                                قيد المعالجة

                            </span>

                        </div>

                    </div>


                    <div class="info-card wait mt-6">

                        <span class="icon-square">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                            </svg>

                        </span>


                        <div>

                            <div class="font-display text-base">
                                لا تقلقي
                            </div>

                            <p class="text-stone text-sm mt-1 leading-6">

                                قد يستغرق التأكيد بضع لحظات. الرجاء عدم إرسال طلب جديد — ستُحدَّث هذه الصفحة تلقائياً.

                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ route('store.index') }}"
                        class="payment-btn payment-btn-secondary mt-7">

                        العودة إلى المتجر

                    </a>


                    <div
                        class="mt-5 flex items-center justify-center gap-2 text-xs text-stone">

                        <span
                            class="inline-block w-2 h-2 rounded-full bg-purple animate-pulse">
                        </span>

                        <span>
                            سيتم التحديث خلال ثوانٍ...
                        </span>

                    </div>

                </div>

            </article>

        @endif


        {{-- =========================
             PAYMENT NOTE
        ========================= --}}

        <div class="text-center mt-8">

            <p
                class="text-xs text-stone inline-flex items-center gap-2">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-3.5 h-3.5 text-purple"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zM8 11V7a4 4 0 118 0v4" />

                </svg>

                تتم معالجة المدفوعات بأمان عبر

                <span class="text-ink font-display">
                    PayTabs
                </span>

            </p>

        </div>

    </div>

</main>
```

</div>

@endsection

@section('scripts')

{{-- GSAP --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* =========================
           GSAP
        ========================= */

        if (window.gsap) {

            gsap.utils
                .toArray('[data-fx]')
                .forEach((element, index) => {

                    gsap.to(element, {

                        opacity: 1,

                        y: 0,

                        duration: .9,

                        ease: 'power2.out',

                        delay: Math.min(
                            index * .08,
                            .3
                        )

                    });

                });


            /* Success sparkles */

            gsap.utils
                .toArray('.sparkle')
                .forEach((sparkle, index) => {

                    gsap.to(sparkle, {

                        opacity: 1,

                        y: -20,

                        duration: 1.6,

                        delay: .4 + index * .12,

                        ease: 'sine.out',

                        yoyo: true,

                        repeat: -1

                    });

                });

        }


        /* =========================
           PENDING AUTO REFRESH
        ========================= */

        @if($order->payment_status !== 'paid' && $order->payment_status !== 'failed')

            (function () {

                let attempts = 0;

                const maxAttempts = 6;

                const interval = setInterval(function () {

                    attempts++;

                    if (attempts >= maxAttempts) {

                        clearInterval(interval);

                        return;

                    }

                    window.location.reload();

                }, 5000);

            })();

        @endif

    });
</script>

@endsection
