<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الصفحة غير موجودة | Orquids</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orquids: {
                            50: '#FAF7FF',
                            100: '#F3EAFE',
                            200: '#E6D5F5',
                            300: '#D0B5E9',
                            400: '#B58BD5',
                            500: '#9662C0',
                            600: '#6D3FA0',
                            700: '#583181',
                            800: '#452665',
                            900: '#352344',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="h-screen overflow-hidden bg-gradient-to-br from-orquids-50 via-white to-purple-100
             flex items-center justify-center px-4">

    <!-- Decorative Background -->
    <div class="fixed -top-32 -right-32 w-80 h-80
                bg-purple-200/40 rounded-full blur-3xl"></div>

    <div class="fixed -bottom-32 -left-32 w-96 h-96
                bg-orquids-200/40 rounded-full blur-3xl"></div>

    <main class="relative w-full max-w-3xl">

        <div class="bg-white/90 backdrop-blur-xl
                    rounded-[35px]
                    border border-orquids-100
                    shadow-[0_25px_80px_rgba(109,63,160,0.14)]
                    px-5 sm:px-10 md:px-14
                    py-6 sm:py-8
                    text-center">

            <!-- Logo -->
            <div class="flex justify-center mb-3">

                <div class="relative">

                    <div class="absolute inset-0
                                bg-purple-300/30
                                blur-2xl
                                rounded-full
                                scale-125"></div>

                    <img
                        src="{{ asset('assets/images/logo-or.png') }}"
                        alt="Orquids"
                        class="relative
                               w-32 h-32
                               sm:w-40 sm:h-40
                               md:w-48 md:h-48
                               object-contain
                               drop-shadow-[0_12px_20px_rgba(109,63,160,0.18)]"
                    >

                </div>

            </div>

            <!-- 404 -->
            <div class="text-[75px] sm:text-[95px] md:text-[115px]
                        leading-none
                        font-black
                        tracking-[-6px]
                        bg-gradient-to-l
                        from-orquids-700
                        via-orquids-600
                        to-orquids-400
                        bg-clip-text
                        text-transparent">

                404

            </div>

            <!-- Title -->
            <h1 class="mt-2
                       text-xl sm:text-2xl md:text-3xl
                       font-bold
                       text-orquids-900">

                الصفحة غير موجودة

            </h1>

            <!-- Message -->
            <p class="mt-3 mx-auto max-w-lg
                      text-sm sm:text-base
                      leading-7
                      text-orquids-500">

                عذرًا، الصفحة التي تبحث عنها غير موجودة
                أو ربما تم نقلها إلى مكان آخر.

            </p>

            <!-- Button -->
            <div class="mt-5">

                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center justify-center gap-2
                           px-7 py-3
                           rounded-xl
                           bg-gradient-to-l
                           from-orquids-700
                           to-orquids-500
                           text-white
                           font-bold
                           text-sm sm:text-base
                           shadow-lg
                           shadow-orquids-600/25
                           transition-all duration-300
                           hover:-translate-y-1
                           hover:shadow-xl"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4m4 0h4a1 1 0 001-1V10M9 21v-6h6v6"
                        />
                    </svg>

                    العودة إلى الرئيسية

                </a>

            </div>

        </div>

        <!-- Brand -->
        <div class="mt-3 text-center text-xs sm:text-sm text-orquids-400">

            <a
                href="{{ url('/') }}"
                class="font-bold text-orquids-600 hover:text-orquids-700 transition"
            >
                Orquids
            </a>

            <span class="mx-1">—</span>

            تجربة رقمية أجمل

        </div>

    </main>

</body>


</html>
