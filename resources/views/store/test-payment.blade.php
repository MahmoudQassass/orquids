@extends('store.layouts.app')

@section('title', 'الدفع — أوركيدس')

@section('content')

<section class="min-h-[80vh] bg-[var(--cream)] py-14 mt-7">

    <div class="mx-auto max-w-lg px-5">

        {{-- Header --}}
        <div class="mb-7 text-center">

            <div
                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[var(--purple)] text-white shadow-lg shadow-[var(--purple)]/20"
            >
                <svg
                    class="h-7 w-7"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="14"
                        rx="2"
                    />

                    <path d="M3 10h18" />

                    <path d="M7 15h3" />
                </svg>
            </div>

            <h1
                class="font-display text-2xl font-bold text-[var(--text)]"
            >
                إتمام الدفع
            </h1>

            <p
                class="mt-2 text-sm text-[var(--muted)]"
            >
                أدخل بيانات الاختبار لإكمال عملية الدفع
            </p>

        </div>


        {{-- Payment Card --}}
        <div
            class="overflow-hidden rounded-[30px] border border-black/[0.06] bg-white shadow-sm"
        >

            {{-- Amount Header --}}
            <div
                class="border-b border-gray-100 bg-[var(--purple-light)] px-6 py-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p
                            class="text-xs font-medium text-[var(--muted)]"
                        >
                            المبلغ المطلوب
                        </p>

                        <div
                            class="mt-1 flex items-baseline gap-2"
                        >

                            <span
                                class="text-3xl font-bold tracking-tight text-[var(--text)]"
                            >
                                {{$order->total}}
                            </span>

                            <span
                                class="text-sm font-semibold text-[var(--purple)]"
                            >
                                USD
                            </span>

                        </div>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[var(--purple)] shadow-sm"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M3 10h18"
                            />

                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                            />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <form
                id="payment-form"
                method="POST"
                action="{{ route('test.payment.pay') }}"
                class="space-y-5 p-6"
                novalidate
            >

                @csrf

                <input type="hidden" name="order_total" value="{{$order->total}}">

                {{-- Cardholder Name --}}
                <div>

                    <label
                        for="card_name"
                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                    >
                        اسم صاحب البطاقة
                    </label>

                    <input
                        id="card_name"
                        name="card_name"
                        type="text"
                        autocomplete="off"
                        value="{{ old('card_name') }}"
                        placeholder="الإسم كما هو في البطاقة"
                        maxlength="100"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3.5 text-sm outline-none transition placeholder:text-gray-300 focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                    >

                    <p
                        id="card-name-error"
                        class="mt-2 hidden text-xs font-medium text-red-600"
                    ></p>

                    @error('card_name')
                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Test Card --}}
                <div>

                    <label
                        for="test_card"
                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                    >
                         رقم البطاقة
                    </label>

                    <div class="relative">

                        <input
                            id="test_card"
                            name="card_number"
                            type="text"
                            inputmode="numeric"
                            autocomplete="off"
                            maxlength="19"
                            placeholder="4111 1111 1111 1111"
                            value="{{ old('card_number') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3.5 text-sm tracking-[2px] outline-none transition placeholder:text-gray-300 focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                        >

                    </div>

                    <p
                        id="test-card-error"
                        class="mt-2 hidden text-xs font-medium text-red-600"
                    ></p>

                    @error('test_card')

                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Test Expiry / OTP Simulation --}}
                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label
                            for="expiry"
                            class="mb-2 block text-sm font-bold text-[var(--text)]"
                        >
                            تاريخ الانتهاء
                        </label>

                        <input
                            id="expiry"
                            name="expiry"
                            type="text"
                            inputmode="numeric"
                            autocomplete="off"
                            maxlength="5"
                            placeholder="MM/YY"
                            value="{{ old('expiry') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3.5 text-sm tracking-[2px] outline-none transition placeholder:text-gray-300 focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                        >

                        <p
                            id="expiry-error"
                            class="mt-2 hidden text-xs font-medium text-red-600"
                        ></p>

                        @error('expiry')

                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <div>

                        <label
                            for="test_otp"
                            class="mb-2 block text-sm font-bold text-[var(--text)]"
                        >
                            CVV
                        </label>

                        <input
                            id="test_otp"
                            name="cvv"
                            type="text"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="3"
                            placeholder="123"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3.5 text-sm tracking-[3px] outline-none transition placeholder:text-gray-300 focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                        >

                    </div>

                </div>

                {{-- Submit --}}
                <button
                    id="pay-button"
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-[var(--purple)] px-5 py-4 text-sm font-bold text-white shadow-lg shadow-[var(--purple)]/20 transition hover:bg-[var(--purple-dark)] disabled:cursor-not-allowed disabled:opacity-60"
                >

                    <svg
                        id="pay-spinner"
                        class="hidden h-5 w-5 animate-spin"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        />

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        />
                    </svg>

                    <span id="pay-button-text">
                        متابعة الدفع
                    </span>

                </button>

            </form>

        </div>

    </div>

</section>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('payment-form');

    const expiry = document.getElementById('expiry');

    const expiryError = document.getElementById('expiry-error');

    const testCard = document.getElementById('test_card');

    const testCardError = document.getElementById('test-card-error');

    const button = document.getElementById('pay-button');

    const buttonText = document.getElementById('pay-button-text');

    const spinner = document.getElementById('pay-spinner');


    /*
    |--------------------------------------------------------------------------
    | Card Formatting - TEST ONLY
    |--------------------------------------------------------------------------
    */

    testCard.addEventListener('input', function () {

        let value = this.value.replace(/\D/g, '');

        value = value.substring(0, 16);

        const groups = value.match(/.{1,4}/g);

        this.value = groups
            ? groups.join(' ')
            : '';

        testCardError.classList.add('hidden');

    });


    /*
    |--------------------------------------------------------------------------
    | Expiry Formatting
    |--------------------------------------------------------------------------
    */

    expiry.addEventListener('input', function () {

        let value = this.value.replace(/\D/g, '');

        value = value.substring(0, 4);

        if (value.length >= 3) {

            value =
                value.substring(0, 2) +
                '/' +
                value.substring(2);

        }

        this.value = value;

        validateExpiry(false);

    });


    /*
    |--------------------------------------------------------------------------
    | Expiry Validation
    |--------------------------------------------------------------------------
    */

    function validateExpiry(showError = true) {

        const value = expiry.value.trim();

        expiry.classList.remove(
            'border-red-400',
            'border-green-400'
        );

        expiryError.classList.add('hidden');

        if (!value) {

            if (showError) {

                showExpiryError(
                    'يرجى إدخال تاريخ انتهاء البطاقة.'
                );

            }

            return false;
        }


        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(value)) {

            if (showError) {

                showExpiryError(
                    'أدخل تاريخ الانتهاء بالصيغة MM/YY.'
                );

            }

            return false;
        }


        const parts = value.split('/');

        const month = Number(parts[0]);

        const year = Number('20' + parts[1]);


        const now = new Date();

        const currentMonth = now.getMonth() + 1;

        const currentYear = now.getFullYear();


        /*
        |----------------------------------------------------------------------
        | Expired
        |----------------------------------------------------------------------
        */

        if (
            year < currentYear ||
            (
                year === currentYear &&
                month < currentMonth
            )
        ) {

            if (showError) {

                showExpiryError(
                    'تاريخ انتهاء البطاقة منتهي.'
                );

            }

            return false;
        }


        expiry.classList.add('border-green-400');

        return true;
    }


    function showExpiryError(message) {

        expiry.classList.add('border-red-400');

        expiryError.textContent = message;

        expiryError.classList.remove('hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | Submit Validation
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        button.disabled = true;

        spinner.classList.remove('hidden');

        buttonText.textContent =
            'جاري التحقق...';

    });

});

</script>

@endsection
