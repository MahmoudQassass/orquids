@extends('store.layouts.app')

@section('title', 'إعادة تعيين كلمة المرور — أوركيدس')

@section('content')

<div class="min-h-[75vh] flex items-center justify-center px-5 py-16 mt-10">

    <div class="w-full max-w-md">

        <div class="rounded-3xl border border-[var(--purple)]/10 bg-white p-7 shadow-sm sm:p-9">

            <div class="text-center">

                <img
                    src="{{ asset('assets/images/logo-or.png') }}"
                    alt="أوركيدس"
                    class="mx-auto h-16 w-auto"
                >

                <h1 class="mt-6 font-display text-2xl font-bold text-[var(--text)]">
                    إعادة تعيين كلمة المرور
                </h1>

                <p class="mt-3 text-sm leading-7 text-[var(--muted)]">
                    اختر كلمة مرور جديدة لحسابك.
                </p>

            </div>


            <form
                action="{{ route('store.password.update') }}"
                method="POST"
                class="mt-7"
            >

                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >


                {{-- Email --}}
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
                        value="{{ old('email', $email) }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                    >

                    @error('email')

                        <p class="mt-2 text-xs font-medium text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Password --}}
                <div class="mt-5">

                    <label
                        for="password"
                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                    >
                        كلمة المرور الجديدة
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="8 أحرف على الأقل"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                    >

                    @error('password')

                        <p class="mt-2 text-xs font-medium text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Confirm --}}
                <div class="mt-5">

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-bold text-[var(--text)]"
                    >
                        تأكيد كلمة المرور
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="أعد كتابة كلمة المرور"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-[var(--purple)] focus:ring-4 focus:ring-[var(--purple)]/10"
                    >

                </div>


                <button
                    type="submit"
                    class="mt-6 w-full rounded-xl bg-[var(--purple)] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[var(--purple-dark)]"
                >
                    حفظ كلمة المرور
                </button>

            </form>


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
