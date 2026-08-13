@extends('store.layouts.app')

@section('title', 'حسابي — أوركيدس')

@section('content')

<section class="bg-[var(--cream)] py-12 sm:py-16">

    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">

        {{-- Header --}}
        <div class="mb-10">

            <span class="text-xs font-bold text-[var(--purple)]">
                حسابي
            </span>

            <h1 class="font-display mt-3 text-3xl font-bold sm:text-4xl">
                مرحبًا، {{ $user->name }} 👋
            </h1>

            <p class="mt-2 text-sm text-[var(--muted)]">
                من هنا يمكنك إدارة بياناتك ومتابعة طلباتك.
            </p>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-6 rounded-2xl border border-green-100 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>

        @endif


        <div class="grid gap-6 lg:grid-cols-3">


            {{-- Profile --}}
            <div class="rounded-[24px] border border-black/[0.06] bg-white p-6 shadow-sm lg:col-span-1">

                <h2 class="font-display text-xl font-bold">
                    معلومات الحساب
                </h2>


                <form
                    action="{{ route('store.account.profile') }}"
                    method="POST"
                    class="mt-6 space-y-4"
                >

                    @csrf
                    @method('PUT')


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            الاسم
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[var(--purple)]"
                        >

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            value="{{ $user->email }}"
                            disabled
                            class="w-full cursor-not-allowed rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-gray-400"
                        >

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            رقم الهاتف
                        </label>

                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[var(--purple)]"
                        >

                    </div>


                    <button
                        type="submit"
                        class="w-full rounded-xl bg-[var(--purple)] px-5 py-3 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                    >
                        حفظ التغييرات
                    </button>

                </form>

            </div>


            {{-- Right --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- Marketing --}}
                <div class="rounded-[24px] border border-black/[0.06] bg-white p-6 shadow-sm">

                    <div class="flex items-start justify-between gap-5">

                        <div>

                            <h2 class="font-display text-xl font-bold">
                                العروض والتحديثات
                            </h2>

                            <p class="mt-2 text-sm leading-7 text-[var(--muted)]">
                                اختر ما إذا كنت ترغب في استقبال العروض والخصومات
                                والتحديثات من أوركيدس.
                            </p>

                        </div>

                        <div class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[var(--purple-soft)] text-[var(--purple)] sm:flex">

                            ✦

                        </div>

                    </div>


                    <form
                        action="{{ route('store.account.marketing') }}"
                        method="POST"
                        class="mt-5"
                    >

                        @csrf
                        @method('PUT')


                        <label class="flex cursor-pointer items-center gap-3">

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


                {{-- Orders --}}
                <div class="rounded-[24px] border border-black/[0.06] bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <h2 class="font-display text-xl font-bold">
                                طلباتي
                            </h2>

                            <p class="mt-1 text-sm text-[var(--muted)]">
                                جميع طلباتك السابقة.
                            </p>

                        </div>

                        <span class="rounded-full bg-[var(--purple-soft)] px-3 py-1 text-xs font-bold text-[var(--purple)]">
                            {{ $orders->total() }}
                        </span>

                    </div>


                    <div class="mt-6 overflow-x-auto">

                        @if($orders->count())

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

                                        <tr class="border-b border-gray-50 last:border-0">

                                            <td class="px-4 py-4">

                                                <span class="font-bold">
                                                    #{{ $order->id }}
                                                </span>

                                            </td>


                                            <td class="px-4 py-4 text-sm text-gray-500">

                                                {{ $order->created_at?->format('Y-m-d') }}

                                            </td>


                                            <td class="px-4 py-4">

                                                @php
                                                    $status = $order->status ?? 'pending';

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


                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-600' }}"
                                                >
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

                                <div class="text-3xl">
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
                                    class="mt-5 inline-flex rounded-xl bg-[var(--purple)] px-5 py-3 text-sm font-bold text-white"
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
