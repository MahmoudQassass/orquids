@extends('store.layouts.app')

@section('title', 'الطلب قيد المعالجة — أوركيدس')

@section('content')

<section class="min-h-[80vh] bg-[var(--cream)] py-20 mt-7">

    <div class="mx-auto max-w-md px-5">

        <div
            class="rounded-[30px] border border-black/[0.06] bg-white p-8 text-center shadow-sm"
        >

            <div
                class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--purple-soft)]"
            >

                <div
                    class="h-9 w-9 animate-spin rounded-full border-4 border-[var(--purple)]/20 border-t-[var(--purple)]"
                ></div>

            </div>


            <h1 class="font-display text-2xl font-bold text-[var(--text)]">
                الطلب قيد المعالجة
            </h1>


            <p class="mt-3 text-sm leading-7 text-[var(--muted)]">
                تم استلام عملية الدفع التجريبية بنجاح.
                جاري معالجة الطلب.
            </p>


            <div
                class="mt-6 rounded-2xl bg-[var(--purple-light)] px-4 py-4"
            >

                <p class="text-xs text-[var(--muted)]">
                    رقم العملية
                </p>

                <p class="mt-1 font-mono text-sm font-bold text-[var(--text)]">
                    {{ $payment['transaction_id'] }}
                </p>

            </div>


            <div
                class="mt-5 inline-flex items-center gap-2 rounded-full bg-green-50 px-4 py-2 text-xs font-bold text-green-700"
            >

                <span class="h-2 w-2 rounded-full bg-green-500"></span>

                 PAYMENT

            </div>

        </div>

    </div>

</section>

@endsection
