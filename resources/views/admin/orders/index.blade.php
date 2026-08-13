@extends('admin.layouts.app')

@section('title', 'الطلبات')

@section('page-title', 'إدارة الطلبات')

@section('content')

<style>

    .orders-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    .orders-header {
        margin-bottom: 28px;
    }

    .orders-title {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 5px;
    }

    .orders-subtitle {
        color: #94a3b8;
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .action-btn {
        border-radius: 11px;
        font-weight: 700;
        padding: 10px 17px;
    }

    .filter-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,.05);
        margin-bottom: 24px;
    }

    .filter-card .card-body {
        padding: 22px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        border-radius: 11px;
        min-height: 44px;
        border-color: #e2e8f0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #94a3b8;
        box-shadow: 0 0 0 .2rem rgba(15,23,42,.06);
    }

    .orders-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .orders-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
    }

    .orders-count {
        font-weight: 800;
        color: #111827;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 16px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 17px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:last-child td {
        border-bottom: 0;
    }

    .order-number {
        font-weight: 800;
        color: #111827;
    }

    .customer-name {
        font-weight: 800;
        color: #1e293b;
    }

    .customer-meta {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 3px;
    }

    .product-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        color: #334155;
        padding: 6px 10px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 800;
    }

    .product-list {
        max-width: 250px;
    }

    .product-name {
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .more-products {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 3px;
    }

    .order-total {
        font-weight: 800;
        color: #111827;
        white-space: nowrap;
    }

    .currency {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-paid {
        background: #dcfce7;
        color: #15803d;
    }

    .status-paid .status-dot {
        background: #22c55e;
    }

    .status-pending {
        background: #fef3c7;
        color: #a16207;
    }

    .status-pending .status-dot {
        background: #eab308;
    }

    .status-failed {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-failed .status-dot {
        background: #ef4444;
    }

    .view-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        color: #334155;
        text-decoration: none;
        transition: .2s;
    }

    .view-btn:hover {
        background: #111827;
        color: #fff;
        border-color: #111827;
    }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 18px;
    }

    .empty-title {
        font-weight: 800;
        font-size: 18px;
        color: #334155;
    }

    .empty-text {
        color: #94a3b8;
        font-size: 14px;
        margin-top: 5px;
    }

    .pagination-wrapper {
        margin-top: 22px;
    }

    @media (max-width: 767px) {

        .orders-title {
            font-size: 23px;
        }

        .orders-header {
            align-items: flex-start !important;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .filter-card .card-body {
            padding: 17px;
        }

    }

    .order-status-form {
    margin: 0;
}

.order-status-select {
    min-width: 135px;
    min-height: 36px;
    padding: 5px 28px 5px 10px;
    border-radius: 999px;
    border: 1px solid transparent;
    font-family: 'Tajawal', sans-serif;
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    outline: none;
    transition: .2s ease;
}

.order-status-select:focus {
    box-shadow: 0 0 0 3px rgba(15, 23, 42, .08);
}


/* Pending */

.order-status-select.status-pending {
    background: #fef3c7;
    color: #a16207;
    border-color: #fde68a;
}


/* Processing */

.order-status-select.status-processing {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #bfdbfe;
}


/* Shipped */

.order-status-select.status-shipped {
    background: #ede9fe;
    color: #6d28d9;
    border-color: #ddd6fe;
}


/* Delivered */

.order-status-select.status-delivered {
    background: #dcfce7;
    color: #15803d;
    border-color: #bbf7d0;
}


/* Completed */

.order-status-select.status-completed {
    background: #d1fae5;
    color: #047857;
    border-color: #a7f3d0;
}


/* Cancelled */

.order-status-select.status-cancelled {
    background: #fee2e2;
    color: #b91c1c;
    border-color: #fecaca;
}

</style>

<div class="orders-page">

{{-- =====================================================
     HEADER
====================================================== --}}

<div class="orders-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

    <div>

        <div class="orders-title">
            الطلبات
        </div>

        <div class="orders-subtitle">
            إدارة ومتابعة جميع طلبات المتجر
        </div>

    </div>


    <div class="header-actions">

        <a
            href="{{ route('admin.products.index') }}"
            class="btn btn-outline-dark action-btn">

            🛍️ المنتجات

        </a>

    </div>

</div>


{{-- =====================================================
     FILTERS
====================================================== --}}

<div class="card filter-card">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('admin.orders.index') }}">

            <div class="row g-3 align-items-end">


                {{-- Search --}}

                <div class="col-lg-5">

                    <label class="filter-label">
                        البحث في الطلبات
                    </label>

                    <div class="position-relative">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="الاسم، الهاتف، البريد أو رقم العملية">

                    </div>

                </div>


                {{-- Payment Status --}}

                <div class="col-lg-3 col-md-6">

                    <label class="filter-label">
                        حالة الدفع
                    </label>

                    <select
                        name="payment_status"
                        class="form-select">

                        <option value="">
                            جميع الحالات
                        </option>

                        <option
                            value="paid"
                            @selected(request('payment_status') === 'paid')>

                            ✓ مدفوع

                        </option>

                        <option
                            value="pending"
                            @selected(request('payment_status') === 'pending')>

                            ⏳ قيد الانتظار

                        </option>

                        <option
                            value="failed"
                            @selected(request('payment_status') === 'failed')>

                            × فشل الدفع

                        </option>

                    </select>

                </div>

                {{-- Order Status --}}

                <div class="col-lg-3 col-md-6">

                    <label class="filter-label">
                        حالة الطلب
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            جميع الحالات
                        </option>

                        <option
                            value="pending"
                            @selected(request('status') === 'pending')>
                            قيد الانتظار
                        </option>

                        <option
                            value="processing"
                            @selected(request('status') === 'processing')>
                            قيد المعالجة
                        </option>

                        <option
                            value="shipped"
                            @selected(request('status') === 'shipped')>
                            تم الشحن
                        </option>

                        <option
                            value="delivered"
                            @selected(request('status') === 'delivered')>
                            تم التسليم
                        </option>

                        <option
                            value="cancelled"
                            @selected(request('status') === 'cancelled')>
                            ملغي
                        </option>

                        <option
                            value="completed"
                            @selected(request('status') === 'completed')>
                            مكتمل
                        </option>

                    </select>

                </div>


                {{-- Actions --}}

                <div class="col-lg-4 col-md-6">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-dark action-btn flex-grow-1">

                            🔎 بحث

                        </button>


                        @if(request()->hasAny(['search', 'payment_status', 'status']))

                            <a
                                href="{{ route('admin.orders.index') }}"
                                class="btn btn-outline-secondary action-btn">

                                إعادة ضبط

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================
     ORDERS
====================================================== --}}

<div class="card orders-card">


    {{-- Card Header --}}

    <div class="orders-card-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="orders-count">
                    جميع الطلبات
                </div>

                <div class="text-muted small mt-1">

                    {{ $orders->total() }}
                    طلب إجمالي

                </div>

            </div>


            @if(request('search') || request('payment_status'))

                <span class="badge bg-light text-dark">

                    نتائج البحث

                </span>

            @endif

        </div>

    </div>


    {{-- Table --}}

    <div class="table-responsive">

        <table class="table align-middle">


            <thead>

            <tr>

                <th>
                    الطلب
                </th>

                <th>
                    العميل
                </th>

                <th>
                    الحساب
                </th>

                <th>
                    المنتجات
                </th>

                <th>
                    الكمية
                </th>

                <th>
                    الإجمالي
                </th>

                <th>
                    الدفع
                </th>

                <th>
                  حالة الطلب
                </th>

                <th>
                    التاريخ
                </th>

                <th class="text-center">
                    عرض
                </th>

            </tr>

            </thead>


            <tbody>


            @forelse($orders as $order)


                <tr>


                    {{-- Order --}}

                    <td>

                        <div class="order-number">

                            #{{ $order->id }}

                        </div>

                    </td>


                    {{-- Customer --}}

                    <td>

                        <div class="customer-name">

                            {{ $order->customer_name }}

                        </div>

                        <div class="customer-meta">

                            {{ $order->phone }}

                        </div>

                        @if($order->email)

                            <div class="customer-meta">

                                {{ $order->email }}

                            </div>

                        @endif

                    </td>

                    <td>

                        @if($order->user_id)

                            <span class="account-badge registered">
                                <span class="account-dot"></span>
                                مسجل
                            </span>

                        @else

                            <span class="account-badge guest">
                                <span class="account-dot"></span>
                                زائر
                            </span>

                        @endif

                    </td>


                    {{-- Products --}}

                    <td>

                        @php

                            $items = $order->items ?? collect();

                        @endphp


                        @if($items->count())

                            <div class="product-list">

                                @foreach($items->take(2) as $item)

                                    <div class="product-name">

                                        {{ $item->product_name }}

                                    </div>

                                @endforeach


                                @if($items->count() > 2)

                                    <div class="more-products">

                                        + {{ $items->count() - 2 }}
                                        منتجات أخرى

                                    </div>

                                @endif

                            </div>

                        @else

                            <span class="text-muted">
                                لا توجد منتجات
                            </span>

                        @endif

                    </td>


                    {{-- Quantity --}}

                    <td>

                        <span class="product-count">

                            📦

                            {{ $order->quantity }}

                        </span>

                    </td>


                    {{-- Total --}}

                    <td>

                        <div class="order-total">

                            {{ number_format($order->total, 2) }}

                            <span class="currency">

                                {{ config('services.paytabs.currency', 'USD') }}

                            </span>

                        </div>

                    </td>


                    {{-- Status --}}

                    <td>


                        @if($order->payment_status === 'paid')

                            <span class="status-badge status-paid">

                                <span class="status-dot"></span>

                                مدفوع

                            </span>


                        @elseif($order->payment_status === 'failed')

                            <span class="status-badge status-failed">

                                <span class="status-dot"></span>

                                فشل الدفع

                            </span>


                        @else

                            <span class="status-badge status-pending">

                                <span class="status-dot"></span>

                                قيد الانتظار

                            </span>

                        @endif


                    </td>


                    {{-- Order Status --}}

                    <td>

                        @php

                            $status = $order->status ?? 'pending';

                            $statusLabels = [
                                'pending' => 'قيد الانتظار',
                                'processing' => 'قيد المعالجة',
                                'shipped' => 'تم الشحن',
                                'delivered' => 'تم التسليم',
                                'cancelled' => 'ملغي',
                                'completed' => 'مكتمل',
                            ];

                            $statusClasses = [
                                'pending' => 'status-pending',
                                'processing' => 'status-processing',
                                'shipped' => 'status-shipped',
                                'delivered' => 'status-delivered',
                                'cancelled' => 'status-cancelled',
                                'completed' => 'status-completed',
                            ];

                        @endphp


                        <form
                            action="{{ route('admin.orders.status', $order) }}"
                            method="POST"
                            class="order-status-form"
                        >

                            @csrf

                            @method('PATCH')

                            <select
                                name="status"
                                class="order-status-select {{ $statusClasses[$status] ?? 'status-pending' }}"
                                onchange="this.form.submit()"
                            >

                                @foreach($statusLabels as $value => $label)

                                    <option
                                        value="{{ $value }}"
                                        @selected($status === $value)
                                    >
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                        </form>

                    </td>


                    {{-- Date --}}

                    <td>

                        <div class="fw-semibold">

                            {{ $order->created_at->format('Y-m-d') }}

                        </div>

                        <div class="text-muted small">

                            {{ $order->created_at->format('H:i') }}

                        </div>

                    </td>


                    {{-- View --}}

                    <td class="text-center">

                        <a
                            href="{{ route('admin.orders.show', $order) }}"
                            class="view-btn"
                            title="عرض الطلب">

                            →

                        </a>

                    </td>


                </tr>


            @empty


                <tr>

                    <td colspan="9">

                        <div class="empty-state">

                            <div class="empty-icon">
                                🛒
                            </div>

                            <div class="empty-title">

                                لا توجد طلبات

                            </div>

                            <div class="empty-text">

                                لم يتم العثور على أي طلبات مطابقة للبحث الحالي.

                            </div>


                            @if(request()->hasAny(['search', 'payment_status', 'status']))

                                <a
                                    href="{{ route('admin.orders.index') }}"
                                    class="btn btn-outline-dark action-btn mt-4">

                                    عرض جميع الطلبات

                                </a>

                            @endif

                        </div>

                    </td>

                </tr>


            @endforelse


            </tbody>

        </table>

    </div>

</div>


{{-- =====================================================
     PAGINATION
====================================================== --}}

@if($orders->hasPages())

    <div class="pagination-wrapper">

        {{ $orders->withQueryString()->links() }}

    </div>

@endif

</div>

@endsection
