@extends('store.layouts.app')

@section('title', 'إنشاء حساب — أوركيدس')

@section('content')

<section class="min-h-[80vh] bg-[var(--cream)] py-16">

    <div class="mx-auto max-w-md px-5">

        <div class="rounded-[28px] border border-black/[0.06] bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-8 text-center">

                <span class="text-xs font-bold text-[var(--purple)]">
                    أوركيدس
                </span>

                <h1 class="font-display mt-3 text-3xl font-bold">
                    إنشاء حساب
                </h1>

                <p class="mt-2 text-sm leading-7 text-[var(--muted)]">
                    أنشئ حسابك واحصل على تجربة تسوق أسهل.
                </p>

            </div>


            @if($errors->any())

                <div class="mb-5 rounded-2xl bg-red-50 p-4 text-sm text-red-700">

                    <ul class="space-y-1">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('store.register.submit') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                {{-- Name --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        الاسم
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="أدخل اسمك"
                    >

                </div>


                {{-- Email --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        البريد الإلكتروني
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="name@example.com"
                    >

                </div>


                {{-- Phone --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        رقم الهاتف
                        <span class="font-normal text-gray-400">
                            (اختياري)
                        </span>
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="رقم الهاتف"
                    >

                </div>


                {{-- Password --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        كلمة المرور
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="8 أحرف على الأقل"
                    >

                </div>


                {{-- Password Confirmation --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        تأكيد كلمة المرور
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[var(--purple)] focus:ring-2 focus:ring-purple-100"
                        placeholder="أعد كتابة كلمة المرور"
                    >

                </div>


                {{-- Marketing --}}
                <label
                    class="flex cursor-pointer gap-3 rounded-2xl border border-gray-100 bg-gray-50 p-4"
                >

                    <input
                        type="checkbox"
                        name="marketing_consent"
                        value="1"
                        {{ old('marketing_consent') ? 'checked' : '' }}
                        class="mt-1 h-4 w-4 rounded border-gray-300 text-[var(--purple)] focus:ring-[var(--purple)]"
                    >

                    <span class="text-xs leading-6 text-gray-600">

                        أوافق على استقبال العروض والخصومات
                        والتحديثات من أوركيدس.

                    </span>

                </label>


                <button
                    type="submit"
                    class="w-full rounded-xl bg-[var(--purple)] px-5 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[var(--purple-dark)] hover:shadow-lg"
                >

                    إنشاء الحساب

                </button>

            </form>


            <div class="mt-7 text-center text-sm text-gray-500">

                لديك حساب بالفعل؟

                <a
                    href="{{ route('store.login') }}"
                    class="font-bold text-[var(--purple)] hover:underline"
                >
                    تسجيل الدخول
                </a>

            </div>

        </div>

    </div>

</section>

@endsection
