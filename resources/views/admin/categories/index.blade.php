@extends('admin.layouts.app')

@section('title', 'إدارة التصنيفات')

@section('page-title', 'إدارة التصنيفات')

@section('content')

<style>
    .categories-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    .page-header-card {
        background: #fff;
        border: 1px solid #e9e7ef;
        border-radius: 18px;
        padding: 22px 24px;
        margin-bottom: 22px;
        box-shadow: 0 3px 15px rgba(25, 20, 50, .035);
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
        transition: .2s ease;
    }

    .btn-primary-custom:hover {
        background: #5e35aa;
        border-color: #5e35aa;
        color: #fff;
        transform: translateY(-1px);
    }

    .filters-card {
        background: #fff;
        border: 1px solid #e9e7ef;
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
        background: #fff;
        border: 1px solid #e9e7ef;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(25, 20, 50, .035);
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

    .categories-table {
        margin: 0;
    }

    .categories-table thead th {
        background: #faf9fc;
        color: #716c7d;
        font-size: 12px;
        font-weight: 800;
        border-bottom: 1px solid #eeeaf2;
        padding: 15px 20px;
        white-space: nowrap;
    }

    .categories-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-color: #f0edf4;
        color: #403b4c;
        font-size: 13px;
    }

    .category-name {
        font-weight: 800;
        color: #29243a;
    }

    .category-slug {
        color: #9691a0;
        font-size: 12px;
        direction: ltr;
        display: inline-block;
    }

    .description-text {
        color: #777181;
        max-width: 350px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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

    .products-count {
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
        border-color: #dcd0ef;
    }

    .action-btn.delete {
        color: #c04a5a;
    }

    .action-btn.delete:hover {
        background: #fff1f2;
        border-color: #f0ccd1;
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

    @media (max-width: 768px) {
        .page-header-card {
            padding: 18px;
        }

        .page-header-content {
            align-items: stretch;
        }

        .btn-primary-custom {
            width: 100%;
        }

        .filters-card {
            padding: 14px;
        }

        .categories-table {
            min-width: 900px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<div class="categories-page">

    {{-- Header --}}
    <div class="page-header-card">
        <div class="page-header-content">

            <div>
                <h2 class="page-heading">التصنيفات</h2>
                <p class="page-description">
                    إدارة تصنيفات المنتجات وتنظيم محتوى المتجر.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
               class="btn btn-primary-custom">
                <i class="bi bi-plus-lg ms-1"></i>
                إضافة تصنيف
            </a>

        </div>
    </div>

    {{-- Alerts --}}
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

    {{-- Filters --}}
    <div class="filters-card">

        <form method="GET" action="{{ route('admin.categories.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-6">
                    <label class="filter-label">البحث</label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control custom-input"
                        placeholder="ابحث باسم التصنيف أو الرابط..."
                    >
                </div>

                <div class="col-lg-3">
                    <label class="filter-label">الحالة</label>

                    <select name="status" class="form-select custom-select">

                        <option value="">كل الحالات</option>

                        <option value="active"
                            {{ request('status') === 'active' ? 'selected' : '' }}>
                            نشط
                        </option>

                        <option value="inactive"
                            {{ request('status') === 'inactive' ? 'selected' : '' }}>
                            غير نشط
                        </option>

                    </select>
                </div>

                <div class="col-lg-3 d-flex gap-2">

                    <button type="submit" class="filter-btn flex-grow-1">
                        <i class="bi bi-search ms-1"></i>
                        بحث
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="reset-btn">
                        إعادة ضبط
                    </a>

                </div>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="table-card">

        <div class="table-header">

            <h3 class="table-title">
                قائمة التصنيفات
            </h3>

            <span class="results-count">
                {{ $categories->total() }} تصنيف
            </span>

        </div>

        @if($categories->count())

            <div class="table-responsive">

                <table class="table categories-table align-middle">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>التصنيف</th>
                        <th>الرابط</th>
                        <th>الوصف</th>
                        <th>المنتجات</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($categories as $category)

                        <tr>

                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="category-name">
                                    {{ $category->name }}
                                </div>
                            </td>

                            <td>
                                <span class="category-slug">
                                    {{ $category->slug }}
                                </span>
                            </td>

                            <td>
                                <div class="description-text">
                                    {{ $category->description ?: '—' }}
                                </div>
                            </td>

                            <td>
                                <span class="products-count">
                                    {{ $category->products_count ?? $category->products()->count() }}
                                </span>
                            </td>

                            <td>

                                @if($category->status)

                                    <span class="status-badge active">
                                        <span class="status-dot"></span>
                                        نشط
                                    </span>

                                @else

                                    <span class="status-badge inactive">
                                        <span class="status-dot"></span>
                                        غير نشط
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $category->created_at?->format('Y-m-d') }}
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="action-btn edit"
                                        title="تعديل"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟');"
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

            @if($categories->hasPages())

                <div class="pagination-wrapper">
                    {{ $categories->withQueryString()->links() }}
                </div>

            @endif

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-grid"></i>
                </div>

                <div class="empty-title">
                    لا توجد تصنيفات
                </div>

                <div class="empty-text">
                    لم يتم العثور على أي تصنيفات مطابقة للبحث.
                </div>

                <a
                    href="{{ route('admin.categories.create') }}"
                    class="btn btn-primary-custom"
                >
                    <i class="bi bi-plus-lg ms-1"></i>
                    إضافة أول تصنيف
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
