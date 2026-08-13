@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('page-title', 'لوحة التحكم')

@section('content')

<div class="container-fluid px-0">

{{-- =========================================================
     Header
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            مرحبًا بك 👋
        </h2>

        <p class="text-muted mb-0">
            إليك نظرة شاملة على أداء متجرك.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.products.create') }}"
            class="btn btn-dark">

            <i class="bi bi-plus-lg me-1"></i>

            إضافة منتج

        </a>

        <a
            href="{{ route('admin.orders.index') }}"
            class="btn btn-outline-dark">

            <i class="bi bi-receipt me-1"></i>

            الطلبات

        </a>

    </div>

</div>


{{-- =========================================================
     Main Statistics
========================================================== --}}

<div class="row g-3 mb-4">

    {{-- Total Sales --}}

    <div class="col-12 col-sm-6 col-xl-3">

        <div class="dashboard-card stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">
                        إجمالي المبيعات
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalSales, 2) }}
                        <small>USD</small>
                    </div>

                </div>

                <div class="stat-icon stat-icon-dark">
                    <i class="bi bi-currency-dollar"></i>
                </div>

            </div>

            <div class="stat-footer text-success">

                <i class="bi bi-graph-up-arrow"></i>

                إجمالي الطلبات المدفوعة

            </div>

        </div>

    </div>


    {{-- Today Sales --}}

    <div class="col-12 col-sm-6 col-xl-3">

        <div class="dashboard-card stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">
                        مبيعات اليوم
                    </div>

                    <div class="stat-value">
                        {{ number_format($todaySales, 2) }}
                        <small>USD</small>
                    </div>

                </div>

                <div class="stat-icon stat-icon-green">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>

            </div>

            <div class="stat-footer">

                {{ $todayOrders }}

                طلب اليوم

            </div>

        </div>

    </div>


    {{-- Monthly Sales --}}

    <div class="col-12 col-sm-6 col-xl-3">

        <div class="dashboard-card stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">
                        مبيعات هذا الشهر
                    </div>

                    <div class="stat-value">
                        {{ number_format($monthlySales, 2) }}
                        <small>USD</small>
                    </div>

                </div>

                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-calendar3"></i>
                </div>

            </div>

            <div class="stat-footer">

                أداء الشهر الحالي

            </div>

        </div>

    </div>


    {{-- Average Order --}}

    <div class="col-12 col-sm-6 col-xl-3">

        <div class="dashboard-card stat-card">

            <div class="stat-top">

                <div>

                    <div class="stat-label">
                        متوسط قيمة الطلب
                    </div>

                    <div class="stat-value">
                        {{ number_format($averageOrderValue, 2) }}
                        <small>USD</small>
                    </div>

                </div>

                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-cart-check"></i>
                </div>

            </div>

            <div class="stat-footer">

                متوسط الطلبات المدفوعة

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     Orders Statistics
========================================================== --}}

<div class="row g-3 mb-4">

    {{-- Total Orders --}}

    <div class="col-6 col-xl-3">

        <div class="mini-stat">

            <div class="mini-icon bg-dark">
                <i class="bi bi-bag"></i>
            </div>

            <div>

                <div class="mini-label">
                    إجمالي الطلبات
                </div>

                <div class="mini-value">
                    {{ $totalOrders }}
                </div>

            </div>

        </div>

    </div>


    {{-- Paid --}}

    <div class="col-6 col-xl-3">

        <div class="mini-stat">

            <div class="mini-icon bg-success">
                <i class="bi bi-check-lg"></i>
            </div>

            <div>

                <div class="mini-label">
                    مدفوعة
                </div>

                <div class="mini-value text-success">
                    {{ $paidOrders }}
                </div>

            </div>

        </div>

    </div>


    {{-- Pending --}}

    <div class="col-6 col-xl-3">

        <div class="mini-stat">

            <div class="mini-icon bg-warning">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div>

                <div class="mini-label">
                    قيد الانتظار
                </div>

                <div class="mini-value text-warning">
                    {{ $pendingOrders }}
                </div>

            </div>

        </div>

    </div>


    {{-- Failed --}}

    <div class="col-6 col-xl-3">

        <div class="mini-stat">

            <div class="mini-icon bg-danger">
                <i class="bi bi-x-lg"></i>
            </div>

            <div>

                <div class="mini-label">
                    فشل الدفع
                </div>

                <div class="mini-value text-danger">
                    {{ $failedOrders }}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     Sales Chart + Products
========================================================== --}}

<div class="row g-4 mb-4">


    {{-- Sales Chart --}}

    <div class="col-xl-8">

        <div class="dashboard-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="fw-bold mb-1">
                        المبيعات
                    </h5>

                    <p class="text-muted small mb-0">
                        أداء المبيعات خلال آخر 7 أيام
                    </p>

                </div>

                <span class="badge bg-light text-dark border">
                    آخر 7 أيام
                </span>

            </div>

            <div class="chart-container">

                <canvas id="salesChart"></canvas>

            </div>

        </div>

    </div>


    {{-- Best Selling --}}

    <div class="col-xl-4">

        <div class="dashboard-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="fw-bold mb-1">
                        الأكثر مبيعًا
                    </h5>

                    <p class="text-muted small mb-0">
                        أفضل المنتجات أداءً
                    </p>

                </div>

            </div>


            <div class="best-products">

                @forelse($bestSellingProducts as $item)

                    <div class="product-row">

                        <div class="product-rank">
                            {{ $loop->iteration }}
                        </div>

                        <div class="product-info">

                            <div class="fw-bold">

                                {{ $item->product->name ?? $item->product_name ?? 'منتج محذوف' }}

                            </div>

                            <div class="text-muted small">

                                {{ $item->total_quantity }}

                                قطعة مباعة

                            </div>

                        </div>

                        <div class="product-sales">

                            {{ number_format($item->total_sales, 2) }}

                            <small>USD</small>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <p>
                            لا توجد مبيعات حتى الآن.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     Products Overview
========================================================== --}}

<div class="row g-4 mb-4">

    <div class="col-md-6">

        <div class="dashboard-card product-overview">

            <div class="overview-icon bg-dark">

                <i class="bi bi-box-seam"></i>

            </div>

            <div class="overview-content">

                <div class="text-muted small">
                    إجمالي المنتجات
                </div>

                <div class="overview-number">
                    {{ $totalProducts }}
                </div>

            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn btn-sm btn-outline-dark">

                إدارة المنتجات

            </a>

        </div>

    </div>


    <div class="col-md-6">

        <div class="dashboard-card product-overview">

            <div class="overview-icon bg-success">

                <i class="bi bi-check-circle"></i>

            </div>

            <div class="overview-content">

                <div class="text-muted small">
                    المنتجات النشطة
                </div>

                <div class="overview-number text-success">
                    {{ $activeProducts }}
                </div>

            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn btn-sm btn-outline-success">

                عرض المنتجات

            </a>

        </div>

    </div>

</div>


{{-- =========================================================
     Recent Orders
========================================================== --}}

<div class="dashboard-card">

    <div class="card-header-custom">

        <div>

            <h5 class="fw-bold mb-1">
                آخر الطلبات
            </h5>

            <p class="text-muted small mb-0">
                أحدث عمليات الشراء في متجرك
            </p>

        </div>

        <a
            href="{{ route('admin.orders.index') }}"
            class="btn btn-sm btn-outline-dark">

            عرض الكل

            <i class="bi bi-arrow-left ms-1"></i>

        </a>

    </div>


    <div class="table-responsive">

        <table class="table orders-table align-middle mb-0">

            <thead>

            <tr>

                <th>
                    الطلب
                </th>

                <th>
                    العميل
                </th>

                <th>
                    المنتجات
                </th>

                <th>
                    الإجمالي
                </th>

                <th>
                    الحالة
                </th>

                <th>
                    التاريخ
                </th>

                <th>
                </th>

            </tr>

            </thead>

            <tbody>

            @forelse($recentOrders as $order)

                <tr>

                    {{-- Order --}}

                    <td>

                        <span class="fw-bold">
                            #{{ $order->id }}
                        </span>

                    </td>


                    {{-- Customer --}}

                    <td>

                        <div class="fw-semibold">
                            {{ $order->customer_name }}
                        </div>

                        <div class="text-muted small">
                            {{ $order->phone }}
                        </div>

                    </td>


                    {{-- Items --}}

                    <td>

                        <div class="order-products">

                            @forelse($order->items->take(2) as $item)

                                <span class="product-badge">

                                    {{ $item->product_name }}

                                    ×{{ $item->quantity }}

                                </span>

                            @empty

                                <span class="text-muted">
                                    لا توجد منتجات
                                </span>

                            @endforelse


                            @if($order->items->count() > 2)

                                <span class="more-products">

                                    +{{ $order->items->count() - 2 }}

                                </span>

                            @endif

                        </div>

                    </td>


                    {{-- Total --}}

                    <td>

                        <strong>

                            {{ number_format($order->total, 2) }}

                            <small class="text-muted">
                                USD
                            </small>

                        </strong>

                    </td>


                    {{-- Payment Status --}}

                    <td>

                        @if($order->payment_status === 'paid')

                            <span class="status-badge status-paid">

                                <span></span>

                                مدفوع

                            </span>

                        @elseif($order->payment_status === 'failed')

                            <span class="status-badge status-failed">

                                <span></span>

                                فشل

                            </span>

                        @else

                            <span class="status-badge status-pending">

                                <span></span>

                                قيد الانتظار

                            </span>

                        @endif

                    </td>


                    {{-- Date --}}

                    <td>

                        <div class="small">

                            {{ $order->created_at->format('Y-m-d') }}

                        </div>

                        <div class="text-muted small">

                            {{ $order->created_at->format('H:i') }}

                        </div>

                    </td>


                    {{-- Action --}}

                    <td>

                        <a
                            href="{{ route('admin.orders.show', $order) }}"
                            class="btn btn-sm btn-light border">

                            <i class="bi bi-eye"></i>

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-5">

                        <div class="empty-icon mx-auto mb-3">

                            <i class="bi bi-receipt"></i>

                        </div>

                        <div class="fw-bold">
                            لا توجد طلبات حتى الآن
                        </div>

                        <div class="text-muted small mt-1">
                            ستظهر الطلبات الجديدة هنا.
                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
```

</div>

{{-- =========================================================
Chart.js
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('salesChart');

    if (!canvas) {
        return;
    }

    const chartData = @json($salesChart);

    new Chart(canvas, {

        type: 'line',

        data: {

            labels: chartData.map(item => item.label),

            datasets: [

                {

                    label: 'المبيعات',

                    data: chartData.map(item => item.sales),

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true,

                    pointRadius: 4,

                    pointHoverRadius: 7

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    rtl: true,

                    textDirection: 'rtl',

                    callbacks: {

                        label: function(context) {

                            return ' ' +
                                Number(context.raw).toLocaleString(
                                    'en-US',
                                    {
                                        minimumFractionDigits: 2
                                    }
                                ) +
                                ' USD';

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return value + ' USD';

                        }

                    },

                    grid: {

                        drawBorder: false

                    }

                },

                x: {

                    grid: {

                        display: false

                    }

                }

            }

        }

    });

});

</script>

<style>

/* =========================================================
   Dashboard
========================================================= */

.dashboard-card {

    background: #fff;

    border: 1px solid #eef0f3;

    border-radius: 18px;

    box-shadow: 0 8px 30px rgba(15, 23, 42, .04);

    overflow: hidden;

}


/* =========================================================
   Statistics
========================================================= */

.stat-card {

    padding: 22px;

}

.stat-top {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

}

.stat-label {

    color: #6b7280;

    font-size: 14px;

    margin-bottom: 8px;

}

.stat-value {

    font-size: 28px;

    font-weight: 800;

    letter-spacing: -.5px;

}

.stat-value small {

    font-size: 11px;

    color: #9ca3af;

    font-weight: 700;

}

.stat-icon {

    width: 48px;

    height: 48px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 21px;

}

.stat-icon-dark {

    background: #111827;

    color: white;

}

.stat-icon-green {

    background: #dcfce7;

    color: #15803d;

}

.stat-icon-blue {

    background: #dbeafe;

    color: #2563eb;

}

.stat-icon-purple {

    background: #ede9fe;

    color: #7c3aed;

}

.stat-footer {

    margin-top: 18px;

    font-size: 12px;

    color: #9ca3af;

}


/* =========================================================
   Mini Stats
========================================================= */

.mini-stat {

    background: #fff;

    border: 1px solid #eef0f3;

    border-radius: 16px;

    padding: 18px;

    display: flex;

    align-items: center;

    gap: 14px;

}

.mini-icon {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #fff;

}

.mini-label {

    color: #6b7280;

    font-size: 13px;

}

.mini-value {

    font-size: 22px;

    font-weight: 800;

    margin-top: 2px;

}


/* =========================================================
   Header
========================================================= */

.card-header-custom {

    padding: 22px 24px;

    border-bottom: 1px solid #f1f3f5;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

}


/* =========================================================
   Chart
========================================================= */

.chart-container {

    height: 330px;

    padding: 25px;

}


/* =========================================================
   Best Products
========================================================= */

.best-products {

    padding: 8px 20px 20px;

}

.product-row {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 15px 4px;

    border-bottom: 1px solid #f1f3f5;

}

.product-row:last-child {

    border-bottom: 0;

}

.product-rank {

    width: 34px;

    height: 34px;

    border-radius: 10px;

    background: #f3f4f6;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 800;

    font-size: 13px;

}

.product-info {

    flex: 1;

    min-width: 0;

}

.product-info .fw-bold {

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}

.product-sales {

    font-size: 13px;

    font-weight: 800;

    white-space: nowrap;

}

.product-sales small {

    color: #9ca3af;

    font-size: 9px;

}


/* =========================================================
   Products Overview
========================================================= */

.product-overview {

    padding: 22px;

    display: flex;

    align-items: center;

    gap: 15px;

}

.overview-icon {

    width: 50px;

    height: 50px;

    border-radius: 14px;

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

}

.overview-content {

    flex: 1;

}

.overview-number {

    font-size: 25px;

    font-weight: 800;

    margin-top: 2px;

}


/* =========================================================
   Orders Table
========================================================= */

.orders-table th {

    background: #fafafa;

    color: #6b7280;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    padding: 15px 18px;

}

.orders-table td {

    padding: 16px 18px;

    border-color: #f1f3f5;

}

.order-products {

    display: flex;

    flex-wrap: wrap;

    gap: 5px;

    max-width: 270px;

}

.product-badge {

    background: #f3f4f6;

    border-radius: 7px;

    padding: 4px 8px;

    font-size: 11px;

    color: #374151;

}

.more-products {

    background: #111827;

    color: white;

    border-radius: 7px;

    padding: 4px 8px;

    font-size: 11px;

}


/* =========================================================
   Status
========================================================= */

.status-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 10px;

    border-radius: 999px;

    font-size: 11px;

    font-weight: 700;

}

.status-badge span {

    width: 6px;

    height: 6px;

    border-radius: 50%;

}

.status-paid {

    background: #dcfce7;

    color: #15803d;

}

.status-paid span {

    background: #22c55e;

}

.status-pending {

    background: #fef3c7;

    color: #a16207;

}

.status-pending span {

    background: #f59e0b;

}

.status-failed {

    background: #fee2e2;

    color: #b91c1c;

}

.status-failed span {

    background: #ef4444;

}


/* =========================================================
   Empty State
========================================================= */

.empty-state {

    text-align: center;

    padding: 40px 20px;

    color: #9ca3af;

}

.empty-icon {

    width: 48px;

    height: 48px;

    border-radius: 14px;

    background: #f3f4f6;

    color: #9ca3af;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

}


/* =========================================================
   Mobile
========================================================= */

@media (max-width: 767px) {

    .stat-value {

        font-size: 23px;

    }

    .chart-container {

        height: 260px;

        padding: 15px;

    }

    .card-header-custom {

        padding: 18px;

    }

    .orders-table {

        min-width: 850px;

    }

    .product-overview {

        flex-wrap: wrap;

    }

}

</style>

@endsection
