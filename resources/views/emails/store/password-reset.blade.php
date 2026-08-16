@extends('emails.store.layouts.app')

@section('title', 'إعادة تعيين كلمة المرور — أوركيدس')


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
    إعادة تعيين كلمة المرور
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
    تلقينا طلبًا لإعادة تعيين كلمة المرور
    الخاصة بحسابك في

    <strong style="color:#292331;">
        أوركيدس
    </strong>.
</p>


<p
    style="
        margin:0 0 30px;
        font-size:15px;
        line-height:2;
        color:#77717f;
    "
>
    إذا كنت قد طلبت إعادة تعيين كلمة المرور،
    يمكنك المتابعة من خلال الزر أدناه:
</p>


{{-- Button --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
>

    <tr>

        <td align="center">

            <a
                href="{{ $url }}"
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
                إعادة تعيين كلمة المرور
            </a>

        </td>

    </tr>

</table>


{{-- Expiration --}}

<div
    style="
        margin-top:30px;
        padding:16px 18px;
        background:#f6f2fa;
        border-radius:14px;
        border:1px solid #eee7f6;
    "
>

    <p
        style="
            margin:0;
            font-size:13px;
            line-height:1.9;
            color:#77717f;
        "
    >

        <strong style="color:#6f4f98;">
            ملاحظة:
        </strong>

        هذا الرابط صالح لمدة

        <strong style="color:#292331;">
            60 دقيقة
        </strong>

        فقط.

    </p>

</div>


{{-- Security --}}

<p
    style="
        margin:28px 0 0;
        padding-top:24px;
        border-top:1px solid #f0edf3;
        font-size:13px;
        line-height:2;
        color:#8a8590;
    "
>

    إذا لم تطلب إعادة تعيين كلمة المرور،
    يمكنك تجاهل هذا البريد بأمان.

    لن يتم تغيير كلمة المرور الخاصة بك
    ما لم تستخدم الرابط أعلاه.

</p>

@endsection


@section('fallback_url')

<p
    style="
        margin:0;
        font-size:10px;
        line-height:1.8;
        word-break:break-all;
        direction:ltr;
        text-align:left;
        color:#8b6bb1;
    "
>
    {{ $url }}
</p>

@endsection
