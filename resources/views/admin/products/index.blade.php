@extends('admin.layouts.app')

@section('title', 'المنتجات')

@section('page-title', 'المنتجات')

@section('content')

<div class="container-fluid px-0">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-2">

                <h2 class="fw-bold mb-0">
                    المنتجات
                </h2>

                <span class="badge rounded-pill bg-light text-dark border">
                    {{ $products->total() }}
                </span>

            </div>

            <p class="text-muted mb-0">
                إدارة المنتجات والأسعار والصور والتصنيفات وحالة العرض في المتجر.
            </p>

        </div>

        <a
            href="{{ route('admin.products.create') }}"
            class="btn btn-dark px-4 py-2">

            <span class="me-1">+</span>
            إضافة منتج

        </a>

    </div>


    {{-- =========================================================
         ALERT
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">

            <span class="fs-5">
                ✓
            </span>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- =========================================================
         FILTERS
    ========================================================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-3 p-md-4">

            <form
                method="GET"
                action="{{ route('admin.products.index') }}">

                <div class="row g-3 align-items-end">


                    {{-- Search --}}

                    <div class="col-lg-5">

                        <label class="form-label fw-semibold">
                            البحث
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control form-control-lg rounded-3"
                            placeholder="ابحث باسم المنتج أو الرابط...">

                    </div>


                    {{-- Category --}}

                    <div class="col-md-4 col-lg-3">

                        <label class="form-label fw-semibold">
                            التصنيف
                        </label>

                        <select
                            name="category_id"
                            class="form-select form-select-lg rounded-3">

                            <option value="">
                                جميع التصنيفات
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected((string) request('category_id') === (string) $category->id)>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Status --}}

                    <div class="col-md-4 col-lg-2">

                        <label class="form-label fw-semibold">
                            الحالة
                        </label>

                        <select
                            name="status"
                            class="form-select form-select-lg rounded-3">

                            <option value="">
                                جميع المنتجات
                            </option>

                            <option
                                value="1"
                                @selected(request('status') === '1')>

                                المنتجات النشطة

                            </option>

                            <option
                                value="0"
                                @selected(request('status') === '0')>

                                المنتجات المتوقفة

                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}

                    <div class="col-md-4 col-lg-2 d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-dark btn-lg flex-grow-1">

                            بحث

                        </button>


                        @if(request()->hasAny(['search', 'status', 'category_id']))

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="btn btn-outline-secondary btn-lg">

                                إعادة

                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         PRODUCTS
    ========================================================== --}}

    @if($products->count())

        <div class="row g-4">

            @foreach($products as $product)

                <div class="col-xl-4 col-lg-6">

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card">


                        {{-- Product Image --}}

                        <div
                            class="position-relative bg-light"
                            style="height:250px;">

                            @if($product->images->first())

                                <img
                                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-100 h-100"
                                    style="object-fit:cover;">

                            @else

                                <div
                                    class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">

                                    <div
                                        class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-2"
                                        style="width:60px;height:60px;">

                                        <span class="fs-4">
                                            📷
                                        </span>

                                    </div>

                                    <small>
                                        لا توجد صورة
                                    </small>

                                </div>

                            @endif


                            {{-- Status --}}

                            <div class="position-absolute top-0 end-0 m-3">

                                @if($product->status)

                                    <span class="badge rounded-pill bg-success px-3 py-2 shadow-sm">

                                        <span class="me-1">
                                            ●
                                        </span>

                                        نشط

                                    </span>

                                @else

                                    <span class="badge rounded-pill bg-secondary px-3 py-2 shadow-sm">
                                        متوقف
                                    </span>

                                @endif

                            </div>


                            {{-- Discount --}}

                            @if($product->discount_price)

                                @php

                                    $discountPercentage = $product->price > 0
                                        ? round(
                                            (($product->price - $product->discount_price)
                                            / $product->price) * 100
                                        )
                                        : 0;

                                @endphp

                                <div class="position-absolute top-0 start-0 m-3">

                                    <span class="badge rounded-pill bg-danger px-3 py-2 shadow-sm">

                                        خصم {{ $discountPercentage }}%

                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- Content --}}

                        <div class="card-body p-4 d-flex flex-column">


                            {{-- Product Name + Category --}}

                            <div class="mb-2">

                                <div class="d-flex justify-content-between align-items-start gap-2">

                                    <h5 class="fw-bold mb-1">
                                        {{ $product->name }}
                                    </h5>


                                    @if($product->category)

                                        <span class="badge bg-light text-dark border rounded-pill">

                                            {{ $product->category->name }}

                                        </span>

                                    @endif

                                </div>


                                <small class="text-muted">
                                    /{{ $product->slug }}
                                </small>

                            </div>


                            {{-- Description --}}

                            @if($product->description)

                                <p
                                    class="text-muted small mb-3"
                                    style="
                                        display:-webkit-box;
                                        -webkit-line-clamp:2;
                                        -webkit-box-orient:vertical;
                                        overflow:hidden;
                                    ">

                                    {{ $product->description }}

                                </p>

                            @endif


                            {{-- Price --}}

                            <div class="mb-3">

                                @if($product->discount_price)

                                    <div class="d-flex align-items-center gap-2">

                                        <span class="fs-4 fw-bold text-danger">

                                            {{ number_format($product->discount_price, 2) }}

                                        </span>

                                        <span class="text-muted text-decoration-line-through">

                                            {{ number_format($product->price, 2) }}

                                        </span>

                                    </div>

                                @else

                                    <span class="fs-4 fw-bold">

                                        {{ number_format($product->price, 2) }}

                                    </span>

                                @endif


                                <small class="text-muted ms-1">

                                    {{ config('services.paytabs.currency', 'USD') }}

                                </small>

                            </div>


                            {{-- Meta --}}

                            <div class="border-top pt-3 mt-auto">

                                <div class="d-flex justify-content-between align-items-center text-muted small">

                                    <span>

                                        🖼️

                                        {{ $product->images->count() }}

                                        {{ $product->images->count() == 1 ? 'صورة' : 'صور' }}

                                    </span>


                                    <span>

                                        {{ $product->created_at->format('Y-m-d') }}

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Actions --}}

                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">

                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-dark flex-grow-1">

                                    تعديل المنتج

                                </a>


                                <form
                                    action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger"
                                        style="min-width:48px;"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟ سيتم حذف المنتج وصوره المرتبطة به.')">

                                        🗑️

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- Pagination --}}

        <div class="d-flex justify-content-center mt-5">

            {{ $products->withQueryString()->links() }}

        </div>


    @else

        {{-- Empty State --}}

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <div
                    class="rounded-circle bg-light mx-auto mb-4 d-flex align-items-center justify-content-center"
                    style="width:90px;height:90px;">

                    <span style="font-size:40px;">
                        📦
                    </span>

                </div>


                <h4 class="fw-bold mb-2">
                    لا توجد منتجات
                </h4>


                <p class="text-muted mb-4">
                    لم يتم العثور على منتجات مطابقة للبحث الحالي.
                </p>


                @if(request()->hasAny(['search', 'status', 'category_id']))

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-outline-dark me-2">

                        عرض جميع المنتجات

                    </a>

                @endif


                <a
                    href="{{ route('admin.products.create') }}"
                    class="btn btn-dark">

                    + إضافة منتج

                </a>

            </div>

        </div>

    @endif

</div>


{{-- =========================================================
     STYLE
========================================================== --}}

<style>

    .product-card {

        transition:
            transform .2s ease,
            box-shadow .2s ease;

    }


    .product-card:hover {

        transform: translateY(-4px);

        box-shadow:
            0 15px 35px rgba(0, 0, 0, .08) !important;

    }


    .product-card img {

        transition:
            transform .35s ease;

    }


    .product-card:hover img {

        transform: scale(1.03);

    }


    .product-card .btn {

        border-radius: 10px;

    }


    @media (max-width: 575px) {

        .product-card {

            border-radius: 18px !important;

        }

    }

</style>

@endsection
