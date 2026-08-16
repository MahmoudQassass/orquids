@extends('emails.store.layouts.app')

@section('title', 'مرحبًا بك في أوركيدس')


@section('content')

<h1
    style="
        margin:0 0 18px;
        font-size:25px;
        line-height:1.6;
        font-weight:700;
        color:#292331;
    "
>
    مرحبًا بك في أوركيدس 🌸
</h1>


<p
    style="
        margin:0 0 18px;
        font-size:16px;
        line-height:2;
        color:#55505d;
    "
>
    مرحبًا

    <strong style="color:#8b6bb1;">
        {{ $user->name }}
    </strong>،
</p>


<p
    style="
        margin:0 0 22px;
        font-size:15px;
        line-height:2;
        color:#77717f;
    "
>
    يسعدنا انضمامك إلى

    <strong style="color:#292331;">
        أوركيدس
    </strong>.
</p>


<p
    style="
        margin:0 0 28px;
        font-size:15px;
        line-height:2;
        color:#77717f;
    "
>
    تم إنشاء حسابك بنجاح، وأصبح بإمكانك الآن
    الاستفادة من تجربة تسوق أكثر سهولة،
    ومتابعة طلباتك والوصول إلى منتجاتنا
    المميزة من مكان واحد.
</p>


{{-- Account Info --}}

<div
    style="
        margin:0 0 28px;
        padding:18px 20px;
        background:#f6f2fa;
        border-radius:14px;
        border:1px solid #eee7f6;
    "
>

    <p
        style="
            margin:0 0 8px;
            font-size:13px;
            color:#77717f;
        "
    >
        البريد الإلكتروني المسجل:
    </p>

    <p
        style="
            margin:0;
            font-size:14px;
            font-weight:700;
            color:#292331;
            direction:ltr;
            text-align:left;
        "
    >
        {{ $user->email }}
    </p>

</div>


{{-- Account Button --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
>

    <tr>

        <td align="center">

            <a
                href="{{ route('store.account') }}"
                style="
                    display:inline-block;
                    padding:15px 34px;
                    background:#8b6bb1;
                    color:#ffffff;
                    text-decoration:none;
                    border-radius:13px;
                    font-size:15px;
                    font-weight:700;
                "
            >
                الدخول إلى حسابي
            </a>

        </td>

    </tr>

</table>


<p
    style="
        margin:30px 0 0;
        padding-top:24px;
        border-top:1px solid #f0edf3;
        font-size:13px;
        line-height:2;
        color:#8a8590;
    "
>
    شكرًا لاختيارك أوركيدس.
    نتمنى لك تجربة تسوق مميزة معنا.
</p>

@endsection
