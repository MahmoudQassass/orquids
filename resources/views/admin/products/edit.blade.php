@extends('admin.layouts.app')

@section('title', 'تعديل المنتج')

@section('page-title', 'تعديل المنتج')

@section('content')

<div class="container-fluid px-0">

```
{{-- =========================================================
     HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <div class="d-flex align-items-center gap-2 mb-2">

            <h2 class="fw-bold mb-0">
                تعديل المنتج
            </h2>

            @if($product->status)

                <span class="badge rounded-pill bg-success px-3 py-2">
                    نشط
                </span>

            @else

                <span class="badge rounded-pill bg-secondary px-3 py-2">
                    متوقف
                </span>

            @endif

        </div>

        <p class="text-muted mb-0">
            تعديل بيانات المنتج والأسعار والصور.
        </p>

    </div>


    <a
        href="{{ route('admin.products.index') }}"
        class="btn btn-outline-secondary px-4">

        ← العودة إلى المنتجات

    </a>

</div>


{{-- =========================================================
     ALERTS
========================================================== --}}

@if(session('success'))

    <div
        class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">

        <span class="fs-5">
            ✓
        </span>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if($errors->any())

    <div
        class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">

        <div class="fw-bold mb-2">
            يرجى تصحيح الأخطاء التالية:
        </div>

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<form
    id="product-form"
    action="{{ route('admin.products.update', $product) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @method('PUT')


    <div class="row g-4">


        {{-- =================================================
             LEFT
        ================================================== --}}

        <div class="col-xl-8">


            {{-- =================================================
                 BASIC INFORMATION
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="mb-4">

                        <h5 class="fw-bold mb-1">
                            معلومات المنتج
                        </h5>

                        <p class="text-muted small mb-0">
                            البيانات الأساسية التي ستظهر للعملاء.
                        </p>

                    </div>


                    {{-- Name --}}

                    <div class="mb-4">

                        <label class="form-label fw-semibold">

                            اسم المنتج

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control form-control-lg rounded-3"
                            value="{{ old('name', $product->name) }}"
                            placeholder="مثال: عطر أوركيدس الفاخر"
                            required>

                    </div>

                    @php
                        $selectedCountries = old(
                            'countries',
                            $product->countries->pluck('id')->toArray()
                        );
                    @endphp

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            الدول المتاح الشحن إليها
                        </label>

                        <div class="border rounded-3 p-3">

                            <div class="row g-2">

                                @foreach($countries as $country)

                                    <div class="col-md-4 col-lg-3">

                                        <label
                                            class="d-flex align-items-center gap-2 p-2 rounded-2 border"
                                            style="cursor:pointer;"
                                        >

                                            <input
                                                type="checkbox"
                                                name="countries[]"
                                                value="{{ $country->id }}"
                                                class="form-check-input m-0"
                                                {{ in_array($country->id, $selectedCountries) ? 'checked' : '' }}
                                            >

                                            <span>
                                                {{ $country->name }}
                                            </span>

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            التصنيف
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                            required>

                            <option value="">
                                اختر التصنيف
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old(
                                            'category_id',
                                            $product->category_id
                                        ) == $category->id
                                    )>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Slug --}}

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            رابط المنتج
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light text-muted">
                                /products/
                            </span>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $product->slug }}"
                                disabled>

                        </div>

                        <div class="form-text">
                            يتم استخدام هذا الرابط لصفحة المنتج.
                        </div>

                    </div>


                    {{-- Description --}}

                    <div>

                        <label class="form-label fw-semibold">
                            وصف المنتج
                        </label>

                        <textarea
                            name="description"
                            rows="7"
                            class="form-control rounded-3"
                            placeholder="اكتب وصفًا واضحًا ومقنعًا للمنتج...">{{ old('description', $product->description) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 PRICING
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="mb-4">

                        <h5 class="fw-bold mb-1">
                            التسعير
                        </h5>

                        <p class="text-muted small mb-0">
                            حدد السعر الأساسي وسعر البيع بعد الخصم.
                        </p>

                    </div>


                    <div class="row g-4">


                        {{-- Regular Price --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                السعر الأساسي

                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-group input-group-lg">

                                <input
                                    type="number"
                                    name="price"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('price', $product->price) }}"
                                    required>

                                <span class="input-group-text">
                                    {{ config('services.paytabs.currency', 'USD') }}
                                </span>

                            </div>

                        </div>


                        {{-- Discount Price --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                سعر الخصم

                                <span class="text-muted fw-normal">
                                    اختياري
                                </span>

                            </label>

                            <div class="input-group input-group-lg">

                                <input
                                    type="number"
                                    name="discount_price"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('discount_price', $product->discount_price) }}"
                                    placeholder="بدون خصم">

                                <span class="input-group-text">
                                    {{ config('services.paytabs.currency', 'USD') }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Discount Preview --}}

                    <div
                        id="discount-preview"
                        class="mt-4 rounded-3 bg-light p-3"
                        style="display:none;">

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="text-muted">
                                نسبة الخصم
                            </span>

                            <strong
                                id="discount-percentage"
                                class="text-danger">
                                0%
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 CURRENT IMAGES
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="fw-bold mb-1">
                                صور المنتج
                            </h5>

                            <p class="text-muted small mb-0">
                                الصور الموجودة حاليًا للمنتج.
                            </p>

                        </div>


                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                            {{ $product->images->count() }}

                            صورة

                        </span>

                    </div>


                    @if($product->images->count())

                        <div class="row g-3">

                            @foreach($product->images as $image)

                                <div class="col-6 col-md-4 col-lg-3">

                                    <div class="image-card position-relative overflow-hidden rounded-4 border">

                                        <img
                                        src="{{ $image->url }}"
                                        alt="{{ $product->name }}"
                                        class="w-100"
                                        style="height:180px;object-fit:cover;">


                                        @if($loop->first)

                                            <div class="position-absolute top-0 start-0 m-2">

                                                <span class="badge bg-dark rounded-pill">

                                                    الصورة الرئيسية

                                                </span>

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div
                            class="text-center bg-light rounded-4 py-5">

                            <div class="fs-1 mb-2">
                                📷
                            </div>

                            <div class="fw-bold">
                                لا توجد صور
                            </div>

                            <div class="text-muted small">
                                أضف صورًا للمنتج من القسم أدناه.
                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 ADD IMAGES
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="mb-4">

                        <h5 class="fw-bold mb-1">
                            إضافة صور جديدة
                        </h5>

                        <p class="text-muted small mb-0">
                            يمكنك اختيار عدة صور في نفس الوقت.
                        </p>

                    </div>


                    <label
                        for="images"
                        class="upload-area w-100 rounded-4 p-4 text-center">

                        <div class="upload-icon mb-3">
                            📸
                        </div>

                        <div class="fw-bold mb-1">
                            اختر صور المنتج
                        </div>

                        <div class="text-muted small">
                            JPG, PNG أو WEBP
                        </div>

                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            class="d-none"
                            accept="image/jpeg,image/png,image/webp"
                            multiple>

                    </label>


                    {{-- Preview --}}

                    <div
                        id="image-preview"
                        class="row g-3 mt-3">

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             RIGHT
        ================================================== --}}

        <div class="col-xl-4">


            {{-- =================================================
                 STATUS
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        حالة المنتج
                    </h5>


                    <label
                        class="status-option d-flex align-items-center justify-content-between p-3 rounded-3 border cursor-pointer">

                        <div>

                            <div class="fw-bold">
                                المنتج نشط
                            </div>

                            <div class="text-muted small mt-1">
                                سيظهر المنتج للعملاء في المتجر.
                            </div>

                        </div>


                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                name="status"
                                value="1"
                                style="width:45px;height:23px;"
                                @checked($product->status)>

                        </div>

                    </label>

                </div>

            </div>


            {{-- =================================================
                 PRODUCT SUMMARY
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        ملخص المنتج
                    </h5>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            رقم المنتج
                        </span>

                        <strong>
                            #{{ $product->id }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            الصور
                        </span>

                        <strong>
                            {{ $product->images->count() }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            تاريخ الإنشاء
                        </span>

                        <strong>
                            {{ $product->created_at->format('Y-m-d') }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            آخر تحديث
                        </span>

                        <strong>
                            {{ $product->updated_at->format('Y-m-d') }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 ACTIONS
            ================================================== --}}

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <button
                        type="submit"
                        form="product-form"
                        class="btn btn-dark btn-lg w-100 rounded-3 mb-2">

                        حفظ التعديلات

                    </button>


                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-outline-secondary btn-lg w-100 rounded-3">

                        إلغاء

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>
```

</div>

{{-- =========================================================
JAVASCRIPT
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const priceInput = document.querySelector('[name="price"]');

    const discountInput = document.querySelector('[name="discount_price"]');

    const preview = document.getElementById('discount-preview');

    const percentage = document.getElementById('discount-percentage');

    const imageInput = document.getElementById('images');

    const imagePreview = document.getElementById('image-preview');


    /*
    |--------------------------------------------------------------------------
    | Discount Calculator
    |--------------------------------------------------------------------------
    */

    function calculateDiscount() {

        const price = parseFloat(priceInput.value);

        const discount = parseFloat(discountInput.value);


        if (
            !isNaN(price) &&
            !isNaN(discount) &&
            price > 0 &&
            discount > 0 &&
            discount < price
        ) {

            const result =
                Math.round(
                    ((price - discount) / price) * 100
                );


            percentage.textContent =
                result + '%';


            preview.style.display =
                'block';

        } else {

            preview.style.display =
                'none';

        }

    }


    priceInput.addEventListener(
        'input',
        calculateDiscount
    );


    discountInput.addEventListener(
        'input',
        calculateDiscount
    );


    calculateDiscount();


    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    imageInput.addEventListener(
        'change',
        function () {

            imagePreview.innerHTML = '';


            const files =
                Array.from(this.files);


            files.forEach(function (file) {

                if (!file.type.startsWith('image/')) {
                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        const column =
                            document.createElement('div');

                        column.className =
                            'col-6 col-md-4 col-lg-3';


                        column.innerHTML = `

                            <div class="border rounded-4 overflow-hidden bg-light">

                                <img
                                    src="${event.target.result}"
                                    class="w-100"
                                    style="height:150px;object-fit:cover;">

                            </div>

                        `;


                        imagePreview.appendChild(
                            column
                        );

                    };


                reader.readAsDataURL(file);

            });

        }
    );

});

</script>

<style>

.product-card {

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.image-card {

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.image-card:hover {

    transform: translateY(-3px);

    box-shadow:
        0 10px 25px rgba(0,0,0,.08);

}


.upload-area {

    display: block;

    border: 2px dashed #dee2e6;

    background: #fafafa;

    cursor: pointer;

    transition:
        border-color .2s ease,
        background .2s ease;

}


.upload-area:hover {

    border-color: #212529;

    background: #f8f9fa;

}


.upload-icon {

    width: 60px;

    height: 60px;

    margin-left: auto;

    margin-right: auto;

    border-radius: 50%;

    background: white;

    box-shadow:
        0 5px 15px rgba(0,0,0,.06);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 26px;

}


.status-option {

    cursor: pointer;

    transition:
        background .2s ease,
        border-color .2s ease;

}


.status-option:hover {

    background: #f8f9fa;

}


.form-control,
.form-select,
.input-group-text {

    border-color: #e5e7eb;

}


.form-control:focus,
.form-select:focus {

    border-color: #111827;

    box-shadow:
        0 0 0 .2rem rgba(17,24,39,.08);

}


@media (max-width: 767px) {

    .card-body {

        padding: 1.25rem !important;

    }

}

</style>

@endsection
