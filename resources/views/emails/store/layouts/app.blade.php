<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'أوركيدس')
    </title>
</head>

<body
    style="
        margin:0;
        padding:0;
        background:#faf8fc;
        font-family:
            Arial,
            'Tahoma',
            sans-serif;
        color:#292331;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        background:#faf8fc;
        padding:40px 15px;
    "
>

    <tr>

        <td align="center">

            {{-- Main Email Container --}}

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width:600px;
                    background:#ffffff;
                    border-radius:24px;
                    overflow:hidden;
                    border:1px solid #eee7f6;
                    box-shadow:
                        0 10px 35px
                        rgba(80,50,100,0.07);
                "
            >

                {{-- Header --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding:35px 30px 28px;
                            background:#ffffff;
                            border-bottom:
                                1px solid #f1edf5;
                        "
                    >

                        <img
                            src="{{ asset('assets/images/logo-or.png') }}"
                            alt="أوركيدس"
                            style="
                                display:block;
                                max-width:170px;
                                height:auto;
                                margin:0 auto;
                                border:0;
                                outline:none;
                                text-decoration:none;
                            "
                        >

                    </td>

                </tr>


                {{-- Content --}}

                <tr>

                    <td
                        style="
                            padding:40px 35px;
                            text-align:right;
                        "
                    >

                        @yield('content')

                    </td>

                </tr>


                {{-- Footer --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding:25px 30px;
                            background:#f6f2fa;
                            border-top:
                                1px solid #eee7f6;
                        "
                    >

                        <p
                            style="
                                margin:0 0 8px;
                                font-size:13px;
                                font-weight:700;
                                color:#6f4f98;
                            "
                        >
                            أوركيدس
                        </p>

                        <p
                            style="
                                margin:0;
                                font-size:12px;
                                line-height:1.8;
                                color:#8a8590;
                            "
                        >
                            وجهتك لاكتشاف منتجات مميزة
                            من علامات تجارية مختارة بعناية.
                        </p>

                        <p
                            style="
                                margin:14px 0 0;
                                font-size:11px;
                                color:#aaa4af;
                            "
                        >
                            © {{ date('Y') }} أوركيدس.
                            جميع الحقوق محفوظة.
                        </p>

                    </td>

                </tr>

            </table>


            {{-- Fallback URL --}}

            @hasSection('fallback_url')

                <table
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    border="0"
                    style="
                        max-width:600px;
                    "
                >

                    <tr>

                        <td
                            style="
                                padding:25px 10px 0;
                                text-align:right;
                            "
                        >

                            <p
                                style="
                                    margin:0 0 8px;
                                    font-size:11px;
                                    line-height:1.8;
                                    color:#aaa4af;
                                "
                            >
                                إذا لم يعمل الزر،
                                يمكنك نسخ الرابط التالي
                                ولصقه في متصفحك:
                            </p>

                            @yield('fallback_url')

                        </td>

                    </tr>

                </table>

            @endif

        </td>

    </tr>

</table>

</body>

</html>
