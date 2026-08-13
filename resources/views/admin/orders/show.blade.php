@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('page-title', 'تفاصيل الطلب')

@section('content')

<style>

    .order-page {
        max-width: 1400px;
        margin: 0 auto;
    }

    .order-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: #fff;
        border-radius: 22px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 15px 40px rgba(0,0,0,.08);
    }

    .order-header h2 {
        font-weight: 800;
        margin-bottom: 6px;
    }

    .order-id {
        color: rgba(255,255,255,.65);
        font-size: 14px;
    }

    .status-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .status-box {
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .status-icon {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        flex-shrink: 0;
    }

    .status-paid {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-failed {
        background: #fee2e2;
        color: #dc2626;
    }

    .section-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,.05);
        margin-bottom: 24px;
    }

    .section-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 24px;
    }

    .section-card .card-body {
        padding: 24px;
    }

    .section-title {
        font-weight: 800;
        margin: 0;
    }

    .info-item {
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 700;
        color: #1e293b;
        word-break: break-word;
    }

    .product-row {
        border-bottom: 1px solid #f1f5f9;
    }

    .product-row:last-child {
        border-bottom: 0;
    }

    .product-image {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 14px;
        background: #f8fafc;
    }

    .product-placeholder {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .product-name {
        font-weight: 800;
        color: #1e293b;
    }

    .product-price {
        color: #64748b;
        font-size: 14px;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        color: #64748b;
    }

    .summary-total {
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
        padding-top: 18px;
        font-size: 21px;
        font-weight: 800;
        color: #111827;
    }

    .reference-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        padding: 14px;
        word-break: break-all;
    }

    .action-btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 11px 18px;
    }

    .customer-avatar {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        background: #111827;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        font-weight: 800;
    }

    .timeline {
        position: relative;
    }

    .timeline-item {
        display: flex;
        gap: 14px;
        padding-bottom: 20px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #111827;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .timeline-content strong {
        display: block;
        font-size: 14px;
    }

    .timeline-content span {
        color: #94a3b8;
        font-size: 12px;
    }

    @media (max-width: 767px) {

        .order-header {
            padding: 20px;
            border-radius: 16px;
        }

        .section-card .card-body,
        .section-card .card-header {
            padding: 18px;
        }

        .product-row {
            padding: 15px 0 !important;
        }

    }

</style>

<div class="order-page">

{{-- =====================================================
     HEADER
====================================================== --}}

<div class="order-header">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

        <div>

            <div class="order-id mb-2">
                تفاصيل الطلب
            </div>

            <h2>
                الطلب #{{ $order->id }}
            </h2>

            <div class="order-id">

                تم إنشاء الطلب في
                {{ $order->created_at->format('Y-m-d') }}
                الساعة
                {{ $order->created_at->format('H:i') }}

            </div>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{ route('admin.orders.index') }}"
                class="btn btn-light action-btn">

                ← العودة للطلبات

            </a>

        </div>

    </div>

</div>


{{-- =====================================================
     PAYMENT STATUS
====================================================== --}}

<div class="status-card mb-4">

    <div class="status-box">

        @if($order->payment_status === 'paid')

            <div class="status-icon status-paid">
                ✓
            </div>

            <div>

                <div class="fw-bold fs-5">
                    تم الدفع بنجاح
                </div>

                <div class="text-muted small">
                    تم تأكيد عملية الدفع لهذا الطلب.
                </div>

            </div>


        @elseif($order->payment_status === 'failed')

            <div class="status-icon status-failed">
                ×
            </div>

            <div>

                <div class="fw-bold fs-5">
                    فشلت عملية الدفع
                </div>

                <div class="text-muted small">
                    لم يتم تأكيد عملية الدفع.
                </div>

            </div>


        @else

            <div class="status-icon status-pending">
                ⏳
            </div>

            <div>

                <div class="fw-bold fs-5">
                    الدفع قيد الانتظار
                </div>

                <div class="text-muted small">
                    لم يتم تأكيد الدفع حتى الآن.
                </div>

            </div>

        @endif

    </div>

</div>


<div class="row g-4">


    {{-- =================================================
         LEFT COLUMN
    ================================================== --}}

    <div class="col-lg-8">


        {{-- =================================================
             CUSTOMER
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <div class="d-flex align-items-center gap-2">

                    <span class="fs-5">
                        👤
                    </span>

                    <h5 class="section-title">
                        بيانات العميل
                    </h5>

                </div>

            </div>


            <div class="card-body">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="customer-avatar">

                        {{ mb_substr($order->customer_name, 0, 1) }}

                    </div>

                    <div>

                        <div class="fw-bold fs-5">
                            {{ $order->customer_name }}
                        </div>

                        <div class="text-muted small">
                            عميل الطلب
                        </div>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6">

                        <div class="info-item">

                            <div class="info-label">
                                رقم الهاتف
                            </div>

                            <div class="info-value">
                                {{ $order->phone }}
                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="info-item">

                            <div class="info-label">
                                البريد الإلكتروني
                            </div>

                            <div class="info-value">

                                @if($order->email)

                                    {{ $order->email }}

                                @else

                                    <span class="text-muted">
                                        غير متوفر
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="info-item">

                            <div class="info-label">
                                الدولة
                            </div>

                            <div class="info-value">
                                {{ $order->country }}
                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="info-item">

                            <div class="info-label">
                                المدينة
                            </div>

                            <div class="info-value">
                                {{ $order->city }}
                            </div>

                        </div>

                    </div>


                    <div class="col-12">

                        <div class="info-item">

                            <div class="info-label">
                                عنوان الشحن
                            </div>

                            <div class="info-value">
                                {{ $order->address }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             ORDER ITEMS
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-2">

                        <span class="fs-5">
                            🛍️
                        </span>

                        <h5 class="section-title">
                            المنتجات
                        </h5>

                    </div>


                    <span class="badge bg-light text-dark">

                        {{ $order->items->count() }}
                        منتجات

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                @forelse($order->items as $item)

                    <div class="product-row p-4">

                        <div class="d-flex align-items-center gap-3">


                            {{-- Product Image --}}

                            @if($item->product && $item->product->images->first())

                                <img
                                    src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                    class="product-image"
                                    alt="{{ $item->product_name }}">

                            @else

                                <div class="product-placeholder">
                                    🛍️
                                </div>

                            @endif


                            {{-- Product Info --}}

                            <div class="flex-grow-1">

                                <div class="product-name">

                                    {{ $item->product_name }}

                                </div>

                                <div class="product-price mt-1">

                                    {{ number_format($item->price, 2) }}

                                    {{ config('services.paytabs.currency', 'USD') }}

                                    ×

                                    {{ $item->quantity }}

                                </div>

                            </div>


                            {{-- Subtotal --}}

                            <div class="text-end">

                                <div class="fw-bold">

                                    {{ number_format($item->subtotal, 2) }}

                                    {{ config('services.paytabs.currency', 'USD') }}

                                </div>

                                <div class="text-muted small">
                                    الإجمالي
                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5 text-muted">

                        لا توجد منتجات مرتبطة بهذا الطلب.

                    </div>

                @endforelse

            </div>

        </div>


        {{-- =================================================
             PAYMENT REFERENCE
        ================================================== --}}

        @if($order->payment_reference)

            <div class="section-card">

                <div class="card-header">

                    <div class="d-flex align-items-center gap-2">

                        <span class="fs-5">
                            💳
                        </span>

                        <h5 class="section-title">
                            معلومات الدفع
                        </h5>

                    </div>

                </div>


                <div class="card-body">

                    <div class="info-label mb-2">
                        مرجع عملية الدفع
                    </div>

                    <div class="reference-box">

                        <code>
                            {{ $order->payment_reference }}
                        </code>

                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- =================================================
         RIGHT COLUMN
    ================================================== --}}

    <div class="col-lg-4">


        {{-- =================================================
             ORDER SUMMARY
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <div class="d-flex align-items-center gap-2">

                    <span class="fs-5">
                        💰
                    </span>

                    <h5 class="section-title">
                        ملخص الطلب
                    </h5>

                </div>

            </div>


            <div class="card-body">

                <div class="summary-box">


                    <div class="summary-row">

                        <span>
                            عدد المنتجات
                        </span>

                        <strong>
                            {{ $order->items->count() }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            إجمالي القطع
                        </span>

                        <strong>
                            {{ $order->quantity }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            المجموع الفرعي
                        </span>

                        <strong>

                            {{ number_format($order->subtotal, 2) }}

                            {{ config('services.paytabs.currency', 'USD') }}

                        </strong>

                    </div>


                    <div class="summary-row summary-total">

                        <span>
                            الإجمالي
                        </span>

                        <span>

                            {{ number_format($order->total, 2) }}

                            <small class="text-muted fs-6">

                                {{ config('services.paytabs.currency', 'USD') }}

                            </small>

                        </span>

                    </div>


                </div>

            </div>

        </div>


        {{-- =================================================
             PAYMENT STATUS CARD
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <h5 class="section-title">
                    حالة الدفع
                </h5>

            </div>


            <div class="card-body">

                @if($order->payment_status === 'paid')

                    <div class="alert alert-success border-0 mb-0">

                        <div class="fw-bold">
                            ✓ تم الدفع
                        </div>

                        <small>
                            تم تأكيد العملية بنجاح.
                        </small>

                    </div>

                @elseif($order->payment_status === 'failed')

                    <div class="alert alert-danger border-0 mb-0">

                        <div class="fw-bold">
                            × فشل الدفع
                        </div>

                        <small>
                            لم يتم إتمام العملية.
                        </small>

                    </div>

                @else

                    <div class="alert alert-warning border-0 mb-0">

                        <div class="fw-bold">
                            ⏳ قيد الانتظار
                        </div>

                        <small>
                            في انتظار تأكيد بوابة الدفع.
                        </small>

                    </div>

                @endif

            </div>

        </div>


        {{-- =================================================
             ORDER TIMELINE
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <h5 class="section-title">
                    معلومات الطلب
                </h5>

            </div>


            <div class="card-body">

                <div class="timeline">


                    <div class="timeline-item">

                        <div class="timeline-dot"></div>

                        <div class="timeline-content">

                            <strong>
                                تم إنشاء الطلب
                            </strong>

                            <span>
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </span>

                        </div>

                    </div>


                    @if($order->payment_status === 'paid')

                        <div class="timeline-item">

                            <div class="timeline-dot bg-success"></div>

                            <div class="timeline-content">

                                <strong>
                                    تم تأكيد الدفع
                                </strong>

                                <span>
                                    حالة الدفع: مدفوع
                                </span>

                            </div>

                        </div>

                    @elseif($order->payment_status === 'failed')

                        <div class="timeline-item">

                            <div class="timeline-dot bg-danger"></div>

                            <div class="timeline-content">

                                <strong>
                                    فشلت عملية الدفع
                                </strong>

                                <span>
                                    لم يتم تأكيد العملية
                                </span>

                            </div>

                        @else

                            <div class="timeline-item">

                                <div class="timeline-dot bg-warning"></div>

                                <div class="timeline-content">

                                    <strong>
                                        الدفع قيد الانتظار
                                    </strong>

                                    <span>
                                        في انتظار التأكيد
                                    </span>

                                </div>

                            </div>

                        @endif


                    <div class="timeline-item">

                        <div class="timeline-dot"></div>

                        <div class="timeline-content">

                            <strong>
                                آخر تحديث
                            </strong>

                            <span>
                                {{ $order->updated_at->format('Y-m-d H:i') }}
                            </span>

                        </div>

                    </div>


                </div>

            </div>

        </div>


        {{-- =================================================
             QUICK ACTIONS
        ================================================== --}}

        <div class="section-card">

            <div class="card-header">

                <h5 class="section-title">
                    إجراءات سريعة
                </h5>

            </div>


            <div class="card-body d-grid gap-2">

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="btn btn-dark action-btn">

                    ← العودة إلى الطلبات

                </a>


                @if($order->phone)

                    <a
                        href="tel:{{ $order->phone }}"
                        class="btn btn-outline-dark action-btn">

                        📞 الاتصال بالعميل

                    </a>

                @endif


                @if($order->email)

                    <a
                        href="mailto:{{ $order->email }}"
                        class="btn btn-outline-dark action-btn">

                        ✉️ إرسال بريد

                    </a>

                @endif

            </div>

        </div>

    </div>

</div>
</div>

@endsection
