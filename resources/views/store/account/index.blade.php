@extends('store.layouts.app')

@section('title', 'حسابي — أوركيدس')

@section('content')

<style>
    .account-card {
        background: #fff;
        border: 1px solid rgba(40, 30, 50, .06);
        border-radius: 26px;
        box-shadow: 0 12px 35px rgba(70, 45, 90, .045);
    }

    .account-input {
        width: 100%;
        border: 1px solid #e8e3ec;
        border-radius: 14px;
        background: #fff;
        padding: 12px 15px;
        color: var(--text);
        outline: none;
        transition: all .2s ease;
    }

    .account-input:focus {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(139, 107, 177, .08);
    }

    .account-input:disabled {
        background: #f8f7f9;
        color: #aaa4af;
        cursor: not-allowed;
    }

    .section-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: var(--purple-soft);
        color: var(--purple);
        flex-shrink: 0;
    }

    .logout-card {
        border: 1px solid rgba(190, 65, 65, .10);
        background: linear-gradient(
            135deg,
            #fff,
            #fffafa
        );
        border-radius: 22px;
    }

    .logout-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 13px;
        background: #fff;
        border: 1px solid rgba(190, 65, 65, .20);
        color: #b04444;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 700;
        transition: all .25s ease;
        cursor: pointer;
    }

    .logout-button:hover {
        background: #b04444;
        border-color: #b04444;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(176, 68, 68, .15);
    }

    .logout-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #fff1f1;
        color: #b04444;
        flex-shrink: 0;
    }

    .marketing-card {
        position: relative;
        overflow: hidden;
    }

    .marketing-card::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(139, 107, 177, .045);
        left: -60px;
        top: -70px;
        pointer-events: none;
    }

    .order-row {
        transition: background .2s ease;
    }

    .order-row:hover {
        background: #fbf9fd;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .account-stat {
        border-radius: 18px;
        background: var(--purple-light);
        border: 1px solid rgba(139, 107, 177, .08);
        padding: 15px;
    }

    .account-stat-value {
        font-family: 'El Messiri', serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--purple-dark);
    }

    .account-stat-label {
        margin-top: 3px;
        font-size: 11px;
        color: var(--muted);
    }

    @media (max-width: 640px) {

        .logout-card {
            padding: 17px !important;
        }

        .logout-button {
            width: 100%;
        }

    }
</style>


<section class="bg-[var(--cream)] pt-24 pb-12 sm:pt-28 sm:pb-16">

    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">


        {{-- =========================================================
             HEADER
        ========================================================== --}}

        <div class="mb-8">

            <span class="text-xs font-bold tracking-wide text-[var(--purple)]">
                حسابي
            </span>

            <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <h1 class="font-display text-3xl font-bold sm:text-4xl">
                        مرحبًا، {{ $user->name }} 👋
                    </h1>

                    <p class="mt-2 text-sm leading-7 text-[var(--muted)]">
                        إدارة بيانات حسابك ومتابعة طلباتك بسهولة.
                    </p>

                </div>

                <div class="hidden rounded-full bg-white px-4 py-2 text-xs font-bold text-[var(--purple)] shadow-sm sm:block">

                    عضو في أوركيدس

                </div>

            </div>

        </div>


        {{-- =========================================================
             SUCCESS
        ========================================================== --}}

        @if(session('success'))

            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-100 bg-green-50 p-4 text-sm text-green-700">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">

                    ✓

                </div>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- =========================================================
             ERRORS
        ========================================================== --}}

        @if($errors->any())

            <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">

                <div class="font-bold">
                    يرجى مراجعة البيانات التالية:
                </div>

                <ul class="mt-2 list-inside list-disc space-y-1">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =========================================================
             MAIN GRID
        ========================================================== --}}

        <div class="grid gap-6 lg:grid-cols-3">


            {{-- =====================================================
                 LEFT COLUMN
            ====================================================== --}}

            <div class="space-y-6 lg:col-span-1">


                {{-- PROFILE --}}

                <div class="account-card p-6">

                    <div class="flex items-center gap-3">

                        <div class="section-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
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

                        </div>

                        <div>

                            <h2 class="font-display text-xl font-bold">
                                معلومات الحساب
                            </h2>

                            <p class="mt-1 text-xs text-[var(--muted)]">
                                بياناتك الأساسية
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('store.account.profile') }}"
                        method="POST"
                        class="mt-7 space-y-5"
                    >

                        @csrf
                        @method('PUT')


                        {{-- NAME --}}

                        <div>

                            <label class="mb-2 block text-sm font-bold">
                                الاسم
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                maxlength="255"
                                class="account-input"
                            >

                        </div>


                        {{-- EMAIL --}}

                        <div>

                            <label class="mb-2 block text-sm font-bold">
                                البريد الإلكتروني
                            </label>

                            <input
                                type="email"
                                value="{{ $user->email }}"
                                disabled
                                class="account-input"
                            >

                            <p class="mt-2 text-[11px] text-[var(--muted)]">
                                لا يمكن تغيير البريد الإلكتروني من هذه الصفحة.
                            </p>

                        </div>


                        {{-- PHONE --}}

                        <div>

                            <label class="mb-2 block text-sm font-bold">
                                رقم الهاتف
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                maxlength="30"
                                class="account-input"
                            >

                        </div>


                        <button
                            type="submit"
                            class="w-full rounded-xl bg-[var(--purple)] px-5 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[var(--purple-dark)] hover:shadow-lg"
                        >

                            حفظ التغييرات

                        </button>

                    </form>

                </div>


                {{-- =================================================
                     LOGOUT
                ================================================== --}}

                <div class="logout-card p-5">

                    <div class="flex items-center gap-4">

                        <div class="logout-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 8.25l3.75 3.75L18 15.75M21.75 12H9"
                                />

                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <h3 class="text-sm font-bold text-[var(--text)]">
                                تسجيل الخروج
                            </h3>

                            <p class="mt-1 text-[11px] leading-5 text-[var(--muted)]">
                                إنهاء الجلسة الحالية على هذا الجهاز.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('store.logout') }}"
                        method="POST"
                        class="mt-4"
                        onsubmit="return confirm('هل تريد تسجيل الخروج من حسابك؟');"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="logout-button"
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
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 8.25l3.75 3.75L18 15.75M21.75 12H9"
                                />

                            </svg>

                            تسجيل الخروج

                        </button>

                    </form>

                </div>

            </div>


            {{-- =====================================================
                 RIGHT COLUMN
            ====================================================== --}}

            <div class="space-y-6 lg:col-span-2">


                {{-- =================================================
                     QUICK STATS
                ================================================== --}}

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">

                    <div class="account-stat">

                        <div class="account-stat-value">
                            {{ $orders->total() }}
                        </div>

                        <div class="account-stat-label">
                            إجمالي الطلبات
                        </div>

                    </div>


                    <div class="account-stat">

                        <div class="account-stat-value">
                            {{ $user->marketing_consent ? 'نعم' : 'لا' }}
                        </div>

                        <div class="account-stat-label">
                            العروض والتحديثات
                        </div>

                    </div>


                    <div class="account-stat col-span-2 sm:col-span-1">

                        <div class="account-stat-value">
                            {{ $user->created_at?->format('Y') }}
                        </div>

                        <div class="account-stat-label">
                            عضو منذ
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     MARKETING
                ================================================== --}}

                <div class="account-card marketing-card p-6">

                    <div class="relative z-10 flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="section-icon hidden sm:flex">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3v18M3 12h18"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h2 class="font-display text-xl font-bold">
                                    العروض والتحديثات
                                </h2>

                                <p class="mt-2 max-w-xl text-sm leading-7 text-[var(--muted)]">
                                    اختر ما إذا كنت ترغب في استقبال العروض
                                    والخصومات والتحديثات من أوركيدس.
                                </p>

                            </div>

                        </div>

                    </div>


                    <form
                        action="{{ route('store.account.marketing') }}"
                        method="POST"
                        class="relative z-10 mt-5"
                    >

                        @csrf
                        @method('PUT')


                        <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[var(--purple-light)] px-4 py-3">

                            <input
                                type="checkbox"
                                name="marketing_consent"
                                value="1"
                                {{ $user->marketing_consent ? 'checked' : '' }}
                                onchange="this.form.submit()"
                                class="h-5 w-5 rounded border-gray-300 text-[var(--purple)] focus:ring-[var(--purple)]"
                            >

                            <span class="text-sm font-bold">
                                أريد استقبال العروض والتحديثات
                            </span>

                        </label>

                    </form>

                </div>


                {{-- =================================================
                     ORDERS
                ================================================== --}}

                <div class="account-card p-6">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <h2 class="font-display text-xl font-bold">
                                طلباتي
                            </h2>

                            <p class="mt-1 text-sm text-[var(--muted)]">
                                جميع طلباتك السابقة.
                            </p>

                        </div>


                        <span class="rounded-full bg-[var(--purple-soft)] px-3 py-1.5 text-xs font-bold text-[var(--purple)]">

                            {{ $orders->total() }}

                        </span>

                    </div>


                    <div class="mt-6 overflow-x-auto">

                        @if($orders->count())

                            @php

                                $statusLabels = [
                                    'pending' => 'قيد الانتظار',
                                    'processing' => 'قيد المعالجة',
                                    'shipped' => 'تم الشحن',
                                    'delivered' => 'تم التسليم',
                                    'cancelled' => 'ملغي',
                                    'completed' => 'مكتمل',
                                ];

                                $statusClasses = [
                                    'pending' => 'bg-yellow-50 text-yellow-700',
                                    'processing' => 'bg-blue-50 text-blue-700',
                                    'shipped' => 'bg-purple-50 text-purple-700',
                                    'delivered' => 'bg-green-50 text-green-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                    'completed' => 'bg-green-50 text-green-700',
                                ];

                            @endphp


                            <table class="w-full min-w-[600px] text-right">

                                <thead>

                                    <tr class="border-b border-gray-100 text-xs text-gray-400">

                                        <th class="px-4 py-3 font-bold">
                                            الطلب
                                        </th>

                                        <th class="px-4 py-3 font-bold">
                                            التاريخ
                                        </th>

                                        <th class="px-4 py-3 font-bold">
                                            الحالة
                                        </th>

                                        <th class="px-4 py-3 font-bold">
                                            الإجمالي
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($orders as $order)

                                        @php

                                            $status =
                                                $order->status ?? 'pending';

                                        @endphp

                                        <tr class="order-row border-b border-gray-50 last:border-0">

                                            <td class="px-4 py-4">

                                                <span class="font-bold">
                                                    #{{ $order->id }}
                                                </span>

                                            </td>


                                            <td class="px-4 py-4 text-sm text-gray-500">

                                                {{ $order->created_at?->format('Y-m-d') }}

                                            </td>


                                            <td class="px-4 py-4">

                                                <span
                                                    class="status-pill {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-600' }}"
                                                >

                                                    <span class="status-dot"></span>

                                                    {{ $statusLabels[$status] ?? $status }}

                                                </span>

                                            </td>


                                            <td class="px-4 py-4 font-bold">

                                                ${{ number_format($order->total ?? 0, 2) }}

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>


                        @else

                            <div class="rounded-2xl bg-gray-50 px-6 py-12 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[var(--purple-soft)] text-2xl">

                                    🛍️

                                </div>

                                <h3 class="font-display mt-4 text-lg font-bold">
                                    لا توجد طلبات بعد
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    ابدأ باكتشاف منتجات أوركيدس.
                                </p>

                                <a
                                    href="{{ route('store.index') }}#products"
                                    class="mt-5 inline-flex rounded-xl bg-[var(--purple)] px-5 py-3 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                                >
                                    اكتشف المنتجات
                                </a>

                            </div>

                        @endif

                    </div>


                    @if($orders->hasPages())

                        <div class="mt-6">

                            {{ $orders->links() }}

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
