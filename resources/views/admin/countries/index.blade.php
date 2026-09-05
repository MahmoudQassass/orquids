@extends('admin.layouts.app')

@section('title', 'إدارة الدول')

@section('page-title', 'إدارة الدول')

@section('content')

<style>
    .countries-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    .page-header-card,
    .filters-card,
    .table-card {
        background: #fff;
        border: 1px solid #e9e7ef;
        box-shadow: 0 3px 15px rgba(25, 20, 50, .035);
    }

    .page-header-card {
        border-radius: 18px;
        padding: 22px 24px;
        margin-bottom: 22px;
    }

    .page-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-heading {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        color: #29243a;
    }

    .page-description {
        margin: 5px 0 0;
        color: #8a8598;
        font-size: 13px;
    }

    .btn-primary-custom {
        background: #6f42c1;
        border-color: #6f42c1;
        color: #fff;
        border-radius: 11px;
        padding: 10px 17px;
        font-weight: 700;
        font-size: 13px;
    }

    .btn-primary-custom:hover {
        background: #5e35aa;
        border-color: #5e35aa;
        color: #fff;
    }

    .filters-card {
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 22px;
    }

    .filter-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #625d70;
        margin-bottom: 7px;
    }

    .custom-input,
    .custom-select {
        height: 43px;
        border: 1px solid #e2dfea;
        border-radius: 10px;
        font-size: 13px;
        box-shadow: none !important;
    }

    .custom-input:focus,
    .custom-select:focus {
        border-color: #8b68d1;
    }

    .filter-btn {
        height: 43px;
        border-radius: 10px;
        background: #29243a;
        border: 0;
        color: #fff;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .reset-btn {
        height: 43px;
        border-radius: 10px;
        background: #f5f3f8;
        border: 1px solid #e9e5ef;
        color: #625d70;
        padding: 0 17px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .table-card {
        border-radius: 18px;
        overflow: hidden;
    }

    .table-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eeeaf2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
        color: #29243a;
    }

    .results-count {
        color: #928d9e;
        font-size: 12px;
    }

    .countries-table {
        margin: 0;
    }

    .countries-table thead th {
        background: #faf9fc;
        color: #716c7d;
        font-size: 12px;
        font-weight: 800;
        border-bottom: 1px solid #eeeaf2;
        padding: 15px 20px;
        white-space: nowrap;
    }

    .countries-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-color: #f0edf4;
        color: #403b4c;
        font-size: 13px;
    }

    .country-name {
        font-weight: 800;
        color: #29243a;
    }

    .country-code {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        height: 28px;
        padding: 0 8px;
        border-radius: 7px;
        background: #f2eefb;
        color: #6f42c1;
        font-size: 11px;
        font-weight: 800;
        direction: ltr;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-badge.active {
        background: #eaf8f0;
        color: #23834d;
    }

    .status-badge.inactive {
        background: #f9ecee;
        color: #b54759;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .addresses-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 35px;
        height: 28px;
        padding: 0 9px;
        border-radius: 8px;
        background: #f2eefb;
        color: #6f42c1;
        font-weight: 800;
        font-size: 12px;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1px solid #e8e4ed;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .18s ease;
        font-size: 13px;
    }

    .action-btn.edit {
        color: #6f42c1;
    }

    .action-btn.edit:hover {
        background: #f4effc;
    }

    .action-btn.delete {
        color: #c04a5a;
    }

    .action-btn.delete:hover {
        background: #fff1f2;
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        background: #f4f0fa;
        color: #6f42c1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 800;
        color: #332e40;
        margin-bottom: 6px;
    }

    .empty-text {
        color: #918b9c;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #eeeaf2;
    }
</style>

<div class="countries-page">

    <div class="page-header-card">

        <div class="page-header-content">

            <div>
                <h2 class="page-heading">الدول</h2>

                <p class="page-description">
                    إدارة الدول المتاحة للشحن والعملاء داخل المتجر.
                </p>
            </div>

            <a
                href="{{ route('admin.countries.create') }}"
                class="btn btn-primary-custom"
            >
                <i class="bi bi-plus-lg ms-1"></i>
                إضافة دولة
            </a>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 small mb-4">
            <i class="bi bi-check-circle ms-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 small mb-4">
            <i class="bi bi-exclamation-circle ms-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="filters-card">

        <form method="GET" action="{{ route('admin.countries.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-6">

                    <label class="filter-label">
                        البحث
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control custom-input"
                        placeholder="ابحث باسم الدولة أو رمزها..."
                    >

                </div>

                <div class="col-lg-3">

                    <label class="filter-label">
                        الحالة
                    </label>

                    <select name="status" class="form-select custom-select">

                        <option value="">كل الحالات</option>

                        <option
                            value="active"
                            {{ request('status') === 'active' ? 'selected' : '' }}
                        >
                            نشطة
                        </option>

                        <option
                            value="inactive"
                            {{ request('status') === 'inactive' ? 'selected' : '' }}
                        >
                            غير نشطة
                        </option>

                    </select>

                </div>

                <div class="col-lg-3 d-flex gap-2">

                    <button type="submit" class="filter-btn flex-grow-1">
                        <i class="bi bi-search ms-1"></i>
                        بحث
                    </button>

                    <a
                        href="{{ route('admin.countries.index') }}"
                        class="reset-btn"
                    >
                        إعادة ضبط
                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="table-card">

        <div class="table-header">

            <h3 class="table-title">
                قائمة الدول
            </h3>

            <span class="results-count">
                {{ $countries->total() }} دولة
            </span>

        </div>

        @if($countries->count())

            <div class="table-responsive">

                <table class="table countries-table">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>الدولة</th>
                        <th>رمز الدولة</th>
                        <th>عناوين الشحن</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>

                    </thead>

                    <tbody>

                    @foreach($countries as $country)

                        <tr>

                            <td>
                                {{ $countries->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="country-name">
                                    {{ $country->name }}
                                </span>
                            </td>

                            <td>
                                <span class="country-code">
                                    {{ strtoupper($country->code) }}
                                </span>
                            </td>

                            <td>

                                <span class="addresses-count">
                                    {{ $country->shipping_addresses_count ?? $country->shippingAddresses()->count() }}
                                </span>

                            </td>

                            <td>

                                @if($country->active)

                                    <span class="status-badge active">
                                        <span class="status-dot"></span>
                                        نشطة
                                    </span>

                                @else

                                    <span class="status-badge inactive">
                                        <span class="status-dot"></span>
                                        غير نشطة
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $country->created_at?->format('Y-m-d') }}
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="{{ route('admin.countries.edit', $country) }}"
                                        class="action-btn edit"
                                        title="تعديل"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.countries.destroy', $country) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الدولة؟');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete"
                                            title="حذف"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            @if($countries->hasPages())

                <div class="pagination-wrapper">
                    {{ $countries->withQueryString()->links() }}
                </div>

            @endif

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-globe2"></i>
                </div>

                <div class="empty-title">
                    لا توجد دول
                </div>

                <div class="empty-text">
                    لم يتم العثور على أي دول مطابقة للبحث.
                </div>

                <a
                    href="{{ route('admin.countries.create') }}"
                    class="btn btn-primary-custom"
                >
                    <i class="bi bi-plus-lg ms-1"></i>
                    إضافة أول دولة
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
