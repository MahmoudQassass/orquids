@extends('store.layouts.app')

@section('title', 'تسجيل الدخول — أوركيدس')

@section('content')

<section class="min-h-[80vh] bg-[var(--cream)] py-16 mt-10">

    <div class="mx-auto max-w-md px-5">

        <div class="rounded-[28px] border border-black/[0.06] bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-8 text-center">

                <span class="text-xs font-bold text-[var(--purple)]">
                    أوركيدس
                </span>

                <h1 class="font-display mt-3 text-3xl font-bold">
                    تسجيل الدخول
                </h1>

                <p class="mt-2 text-sm leading-7 text-[var(--muted)]">
                    سجّل الدخول للوصول إلى حسابك وطلباتك.
                </p>

            </div>


            @if($errors->any())

                <div class="mb-5 rounded-2xl bg-red-50 p-4 text-sm text-red-700">

                    @foreach($errors->all() as $error)

                        <p>
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif

            @if(session('status'))

                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">

                    <div class="flex items-center gap-2">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5 shrink-0"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                        <span>
                            {{ session('status') }}
                        </span>

                    </div>

                </div>

            @endif


            <form
                action="{{ route('store.login.submit') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        البريد الإلكتروني
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="name@example.com"
                    >

                </div>


                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <label class="text-sm font-bold">
                            كلمة المرور
                        </label>

                    </div>

                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="أدخل كلمة المرور"
                    >

                </div>

                <div class="mt-2 text-left">

                    <a
                        href="{{ route('store.password.request') }}"
                        class="text-xs font-bold text-[var(--purple)] transition hover:text-[var(--purple-dark)]"
                    >
                        نسيت كلمة المرور؟
                    </a>

                </div>


                <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-500">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="h-4 w-4 rounded border-gray-300 text-[var(--purple)]"
                    >

                    تذكرني

                </label>


                <button
                    type="submit"
                    class="w-full rounded-xl bg-[var(--purple)] px-5 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[var(--purple-dark)] hover:shadow-lg"
                >

                    تسجيل الدخول

                </button>

            </form>


            <div class="mt-7 text-center text-sm text-gray-500">

                ليس لديك حساب؟

                <a
                    href="{{ route('store.register') }}"
                    class="font-bold text-[var(--purple)] hover:underline"
                >
                    إنشاء حساب جديد
                </a>

            </div>

        </div>

    </div>

</section>

@endsection
