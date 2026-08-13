@extends('admin.layouts.app')

@section('title', 'العملاء')

@section('page-title', 'العملاء')

@section('content')

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="customers-header">

        <div>

            <h2 class="customers-title">
                إدارة العملاء
            </h2>

            <p class="customers-description">
                عرض وإدارة بيانات العملاء والاشتراك في الرسائل التسويقية.
            </p>

        </div>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- Total --}}

        <div class="col-12 col-md-6 col-xl-4">

            <div class="customer-stat-card">

                <div class="customer-stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="customer-stat-content">

                    <div class="customer-stat-label">
                        إجمالي العملاء
                    </div>

                    <div class="customer-stat-value">
                        {{ number_format($totalCustomers) }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Marketing subscribed --}}

        <div class="col-12 col-md-6 col-xl-4">

            <div class="customer-stat-card">

                <div class="customer-stat-icon success">
                    <i class="bi bi-megaphone-fill"></i>
                </div>

                <div class="customer-stat-content">

                    <div class="customer-stat-label">
                        مشتركو التسويق
                    </div>

                    <div class="customer-stat-value">
                        {{ number_format($subscribedCustomers) }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Not subscribed --}}

        <div class="col-12 col-md-6 col-xl-4">

            <div class="customer-stat-card">

                <div class="customer-stat-icon muted">
                    <i class="bi bi-person-dash-fill"></i>
                </div>

                <div class="customer-stat-content">

                    <div class="customer-stat-label">
                        غير المشتركين
                    </div>

                    <div class="customer-stat-value">
                        {{ number_format($unsubscribedCustomers) }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CUSTOMERS CARD
    ========================================================== --}}

    <div class="card customers-card">

        {{-- Card Header --}}

        <div class="card-header customers-card-header">

            <div>

                <div class="customers-card-title">
                    قائمة العملاء
                </div>

                <div class="customers-card-subtitle">
                    {{ number_format($customers->total()) }}
                    عميل
                </div>

            </div>

        </div>


        {{-- Filters --}}

        <div class="customers-filters">

            <form
                method="GET"
                action="{{ route('admin.customers.index') }}"
                class="row g-2 align-items-center">

                {{-- Search --}}

                <div class="col-12 col-lg-6">

                    <div class="customer-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="ابحث بالاسم أو البريد أو الهاتف..."
                        >

                    </div>

                </div>


                {{-- Marketing --}}

                <div class="col-12 col-md-6 col-lg-3">

                    <select
                        name="marketing"
                        class="form-select">

                        <option value="">
                            جميع العملاء
                        </option>

                        <option
                            value="subscribed"
                            {{ request('marketing') === 'subscribed' ? 'selected' : '' }}>
                            مشتركو التسويق
                        </option>

                        <option
                            value="unsubscribed"
                            {{ request('marketing') === 'unsubscribed' ? 'selected' : '' }}>
                            غير المشتركين
                        </option>

                    </select>

                </div>


                {{-- Filter button --}}

                <div class="col-12 col-md-6 col-lg-3">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-dark flex-grow-1">

                            <i class="bi bi-funnel me-1"></i>

                            تصفية

                        </button>

                        @if(request()->hasAny(['search', 'marketing']))

                            <a
                                href="{{ route('admin.customers.index') }}"
                                class="btn btn-light border"
                                title="إعادة تعيين">

                                <i class="bi bi-x-lg"></i>

                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>


        {{-- =====================================================
             TABLE
        ====================================================== --}}

        <div class="table-responsive">

            <table class="table table-hover align-middle customers-table">

                <thead>

                    <tr>

                        <th>
                            العميل
                        </th>

                        <th>
                            البريد الإلكتروني
                        </th>

                        <th>
                            الهاتف
                        </th>

                        <th>
                            التسويق
                        </th>

                        <th>
                            تاريخ التسجيل
                        </th>

                        <th class="text-center">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($customers as $customer)

                        <tr>

                            {{-- Customer --}}

                            <td>

                                <div class="customer-info">

                                    <div class="customer-avatar">

                                        {{ mb_strtoupper(
                                            mb_substr($customer->name, 0, 1)
                                        ) }}

                                    </div>

                                    <div>

                                        <div class="customer-name">
                                            {{ $customer->name }}
                                        </div>

                                        <div class="customer-id">
                                            #{{ $customer->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}

                            <td>

                                <div class="customer-email">

                                    <i class="bi bi-envelope"></i>

                                    {{ $customer->email }}

                                </div>

                            </td>


                            {{-- Phone --}}

                            <td>

                                @if($customer->phone)

                                    <div class="customer-phone">

                                        <i class="bi bi-telephone"></i>

                                        {{ $customer->phone }}

                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Marketing --}}

                            <td>

                                @if($customer->marketing_consent)

                                    <span class="marketing-badge subscribed">

                                        <i class="bi bi-check-circle-fill"></i>

                                        مشترك

                                    </span>

                                @else

                                    <span class="marketing-badge unsubscribed">

                                        <i class="bi bi-dash-circle-fill"></i>

                                        غير مشترك

                                    </span>

                                @endif

                            </td>


                            {{-- Created --}}

                            <td>

                                <div class="created-date">

                                    <div>
                                        {{ $customer->created_at?->format('Y/m/d') }}
                                    </div>

                                    <small>
                                        {{ $customer->created_at?->format('h:i A') }}
                                    </small>

                                </div>

                            </td>


                            {{-- Actions --}}

                            <td>

                                <div class="customer-actions">

                                    <button
                                        type="button"
                                        class="customer-action-btn"
                                        title="عرض">

                                        <i class="bi bi-eye"></i>

                                    </button>


                                    <form
                                        action="{{ route(
                                            'admin.customers.destroy',
                                            $customer
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟');">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="customer-action-btn danger"
                                            title="حذف">

                                            <i class="bi bi-trash3"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="customers-empty">

                                <div class="empty-icon">

                                    <i class="bi bi-people"></i>

                                </div>

                                <div class="empty-title">
                                    لا يوجد عملاء
                                </div>

                                <div class="empty-description">

                                    @if(request()->hasAny(['search', 'marketing']))

                                        لم يتم العثور على عملاء مطابقين لخيارات البحث.

                                    @else

                                        لا يوجد عملاء مسجلون حتى الآن.

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if($customers->hasPages())

            <div class="customers-pagination">

                {{ $customers->links() }}

            </div>

        @endif

    </div>

@endsection


@push('styles')

<style>

    /* =========================================================
       HEADER
    ========================================================= */

    .customers-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .customers-title {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: #111827;
    }

    .customers-description {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       STATISTICS
    ========================================================= */

    .customer-stat-card {
        background: #fff;
        border: 1px solid #e9ebf0;
        border-radius: 16px;
        min-height: 100px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all .2s ease;
        box-shadow: 0 4px 20px rgba(17, 24, 39, .035);
    }

    .customer-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(17, 24, 39, .07);
    }

    .customer-stat-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #111827;
        font-size: 20px;
    }

    .customer-stat-icon.success {
        background: #ecfdf3;
        color: #16a34a;
    }

    .customer-stat-icon.muted {
        background: #f3f4f6;
        color: #6b7280;
    }

    .customer-stat-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .customer-stat-value {
        color: #111827;
        font-size: 22px;
        font-weight: 800;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .customers-card {
        overflow: hidden;
    }

    .customers-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .customers-card-title {
        color: #111827;
        font-size: 16px;
        font-weight: 800;
    }

    .customers-card-subtitle {
        color: #9ca3af;
        font-size: 11px;
        margin-top: 3px;
    }


    /* =========================================================
       FILTERS
    ========================================================= */

    .customers-filters {
        padding: 18px 22px;
        border-bottom: 1px solid #e9ebf0;
        background: #fcfcfd;
    }

    .customer-search {
        position: relative;
    }

    .customer-search > i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 2;
    }

    .customer-search .form-control {
        padding-right: 40px;
    }


    /* =========================================================
       CUSTOMER
    ========================================================= */

    .customer-info {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #111827;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
    }

    .customer-name {
        color: #111827;
        font-size: 13px;
        font-weight: 800;
    }

    .customer-id {
        color: #9ca3af;
        font-size: 10px;
        margin-top: 2px;
    }

    .customer-email,
    .customer-phone {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #4b5563;
        font-size: 12px;
    }

    .customer-email i,
    .customer-phone i {
        color: #9ca3af;
    }


    /* =========================================================
       MARKETING BADGE
    ========================================================= */

    .marketing-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .marketing-badge.subscribed {
        color: #15803d;
        background: #dcfce7;
    }

    .marketing-badge.unsubscribed {
        color: #6b7280;
        background: #f3f4f6;
    }


    /* =========================================================
       CREATED
    ========================================================= */

    .created-date {
        color: #374151;
        font-size: 12px;
        font-weight: 600;
    }

    .created-date small {
        display: block;
        color: #9ca3af;
        font-size: 10px;
        margin-top: 2px;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .customer-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .customer-actions form {
        margin: 0;
    }

    .customer-action-btn {
        width: 34px;
        height: 34px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s ease;
    }

    .customer-action-btn:hover {
        background: #f9fafb;
        color: #111827;
        border-color: #d1d5db;
    }

    .customer-action-btn.danger:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .customers-empty {
        padding: 70px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 14px;
        border-radius: 16px;
        background: #f3f4f6;
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .empty-title {
        color: #374151;
        font-size: 15px;
        font-weight: 800;
    }

    .empty-description {
        color: #9ca3af;
        font-size: 12px;
        margin-top: 5px;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .customers-pagination {
        padding: 18px 22px;
        border-top: 1px solid #e9ebf0;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 767.98px) {

        .customers-title {
            font-size: 20px;
        }

        .customers-description {
            font-size: 12px;
        }

        .customers-filters {
            padding: 15px;
        }

        .customers-table {
            min-width: 850px;
        }

    }

</style>

@endpush
