@extends('store.layouts.app')

@section('title', 'التحقق — أوركيدس')

@section('content')

<section class="min-h-[80vh] bg-[var(--cream)] py-16 mt-7">

    <div class="mx-auto max-w-md px-5">

        <div
            class="rounded-[28px] border border-black/[0.06] bg-white p-7 text-center shadow-sm"
        >

            <div
                class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-[var(--purple-soft)] text-xl text-[var(--purple)]"
            >
                ✓
            </div>


            <h1 class="font-display text-2xl font-bold text-[var(--text)]">
                تحقق
            </h1>


            <p class="mt-3 text-sm leading-7 text-[var(--muted)]">
             أدخل رمز التحقق المكون من 6 أرقام.
            </p>

            <form
                method="POST"
                action="{{ route('test.payment.otp.verify') }}"
                class="mt-6"
            >

                @csrf


                <input
                    name="otp"
                    type="text"
                    inputmode="numeric"
                    maxlength="6"
                    autocomplete="off"
                    placeholder="000000"
                    class="w-full rounded-xl border border-gray-200 px-4 py-4 text-center text-xl font-bold tracking-[8px] outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-[var(--purple)]/10"
                >


                @error('otp')

                    <p class="mt-3 text-xs text-red-600">
                        {{ $message }}
                    </p>

                @enderror


                <button
                    type="submit"
                    class="mt-5 w-full rounded-xl bg-[var(--purple)] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                >
                    استمرار
                </button>

            </form>

        </div>

    </div>

</section>

@endsection
