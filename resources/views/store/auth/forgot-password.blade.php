@extends('store.layouts.app')

@section('title', 'نسيت كلمة المرور — أوركيدس')

@section('content')

<div class="min-h-[75vh] flex items-center justify-center px-5 py-16  mt-10">

    <div class="w-full max-w-md">

        <div class="rounded-3xl border border-[var(--purple)]/10 bg-white p-7 shadow-sm sm:p-9">

            {{-- Header --}}
            <div class="text-center">

                <img
                    src="{{ asset('assets/images/logo-or.png') }}"
                    alt="أوركيدس"
                    class="mx-auto h-16 w-auto"
                >

                <h1 class="mt-6 font-display text-2xl font-bold text-[var(--text)]">
                    نسيت كلمة المرور؟
                </h1>

                <p class="mt-3 text-sm leading-7 text-[var(--muted)]">
                    أدخل بريدك الإلكتروني وسنرسل لك رابطًا
                    لإعادة تعيين كلمة المرور.
                </p>

            </div>


            {{-- Success --}}
            @if(session('status'))

                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm leading-6 text-green-700">
                    {{ session('status') }}
                </div>

            @endif


            {{-- Form --}}
            <form
                action="{{ route('store.password.email') }}"
                method="POST"
                class="mt-7"
            >

                @csrf

                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                    >
                        البريد الإلكتروني
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="example@email.com"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                    >

                    @error('email')

                        <p class="mt-2 text-xs font-medium text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="mt-5 w-full rounded-xl bg-[var(--purple)] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                >
                    إرسال رابط إعادة التعيين
                </button>

            </form>


            {{-- Back --}}
            <div class="mt-6 text-center">

                <a
                    href="{{ route('store.login') }}"
                    class="text-sm font-bold text-[var(--purple)] transition hover:text-[var(--purple-dark)]"
                >
                    ← العودة إلى تسجيل الدخول
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
