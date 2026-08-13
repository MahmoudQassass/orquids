@extends('admin.layouts.app')

@section('title', 'إضافة منتج')

@section('page-title', 'إضافة منتج')

@section('content')

<div class="container-fluid px-0">

```
{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                منتج جديد
            </span>
        </div>

        <h2 class="fw-bold mb-1">
            إضافة منتج جديد
        </h2>

        <p class="text-muted mb-0">
            أضف منتجًا جديدًا إلى متجرك مع تفاصيله وصوره وأسعاره.
        </p>
    </div>

    <a
        href="{{ route('admin.products.index') }}"
        class="btn btn-light border px-4">

        ← العودة إلى المنتجات

    </a>

</div>


{{-- Validation Errors --}}
@if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

        <div class="d-flex gap-3">

            <div class="fs-4">
                ⚠️
            </div>

            <div>

                <strong class="d-block mb-2">
                    يرجى تصحيح الأخطاء التالية:
                </strong>

                <ul class="mb-0 pe-3">

                    @foreach ($errors->all() as $error)

                        <li class="mb-1">
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif


<form
    action="{{ route('admin.products.store') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <div class="row g-4">


        {{-- Main Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-3"
                            style="width:48px;height:48px">

                            📝

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                معلومات المنتج
                            </h5>

                            <p class="text-muted small mb-0">
                                المعلومات الأساسية التي ستظهر للعملاء.
                            </p>

                        </div>

                    </div>


                    {{-- Product Name --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">

                            اسم المنتج

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="مثال: عطر أوركيدس الفاخر"
                            required>

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

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
                                    @selected(old('category_id') == $category->id)>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

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
                                                {{ in_array($country->id, old('countries', [])) ? 'checked' : '' }}
                                            >

                                            <span>
                                                {{ $country->name }}
                                            </span>

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                        @error('countries')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Description --}}
                    <div class="mb-2">

                        <label class="form-label fw-semibold">
                            وصف المنتج
                        </label>

                        <textarea
                            name="description"
                            rows="7"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="اكتب وصفًا واضحًا ومقنعًا للمنتج...">{{ old('description') }}</textarea>

                        @error('description')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                        <div class="form-text">
                            استخدم وصفًا يوضح أهم مزايا المنتج ومواصفاته.
                        </div>

                    </div>

                </div>

            </div>


            {{-- Pricing --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center bg-success-subtle text-success rounded-3"
                            style="width:48px;height:48px">

                            💰

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                التسعير
                            </h5>

                            <p class="text-muted small mb-0">
                                حدد السعر الأساسي وسعر الخصم إن وجد.
                            </p>

                        </div>

                    </div>


                    <div class="row g-4">

                        {{-- Price --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                السعر الأساسي

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <div class="input-group input-group-lg">

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="price"
                                    id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}"
                                    placeholder="0.00"
                                    required>

                                <span class="input-group-text">
                                    $
                                </span>

                            </div>

                            @error('price')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Discount --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                سعر الخصم

                                <span class="text-muted fw-normal">
                                    (اختياري)
                                </span>

                            </label>

                            <div class="input-group input-group-lg">

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="discount_price"
                                    id="discount_price"
                                    class="form-control @error('discount_price') is-invalid @enderror"
                                    value="{{ old('discount_price') }}"
                                    placeholder="0.00">

                                <span class="input-group-text">
                                    $
                                </span>

                            </div>

                            @error('discount_price')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Price Preview --}}
                    <div
                        id="pricePreview"
                        class="mt-4 rounded-4 bg-light border p-4 d-none">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small">
                                    السعر الظاهر للعميل
                                </div>

                                <div
                                    id="finalPrice"
                                    class="fs-3 fw-bold mt-1">
                                    $0.00
                                </div>

                            </div>

                            <div
                                id="discountBadge"
                                class="badge bg-danger rounded-pill px-3 py-2 d-none">

                                خصم 0%

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Images --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div
                            class="d-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-3"
                            style="width:48px;height:48px">

                            🖼️

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                صور المنتج
                            </h5>

                            <p class="text-muted small mb-0">
                                أضف صورًا واضحة وعالية الجودة للمنتج.
                            </p>

                        </div>

                    </div>


                    <label
                        for="images"
                        id="uploadArea"
                        class="border border-2 border-dashed rounded-4 p-5 text-center d-block"
                        style="cursor:pointer">

                        <div class="fs-1 mb-3">
                            📷
                        </div>

                        <h6 class="fw-bold">
                            اضغط لاختيار الصور
                        </h6>

                        <p class="text-muted small mb-2">
                            يمكنك اختيار عدة صور في نفس الوقت
                        </p>

                        <span class="badge bg-light text-dark border">
                            JPG · PNG · WEBP
                        </span>

                        <span class="badge bg-light text-dark border">
                            حتى 5MB للصورة
                        </span>

                    </label>


                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        class="d-none"
                        accept="image/jpeg,image/png,image/webp"
                        multiple>


                    {{-- Preview --}}
                    <div
                        id="imagePreview"
                        class="row g-3 mt-3">
                    </div>

                </div>

            </div>

        </div>


        {{-- Sidebar --}}
        <div class="col-lg-4">


            {{-- Status --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-1">
                        حالة المنتج
                    </h5>

                    <p class="text-muted small mb-4">
                        يمكنك إخفاء المنتج عن المتجر في أي وقت.
                    </p>


                    <div
                        class="border rounded-4 p-3">

                        <div class="form-check form-switch d-flex justify-content-between align-items-center p-0">

                            <div>

                                <label
                                    for="status"
                                    class="form-check-label fw-bold">

                                    المنتج نشط

                                </label>

                                <div class="text-muted small mt-1">
                                    سيظهر المنتج للعملاء.
                                </div>

                            </div>

                            <input
                                class="form-check-input ms-0"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="status"
                                checked
                                style="width:3rem;height:1.5rem">

                        </div>

                    </div>

                </div>

            </div>


            {{-- Summary --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        ملخص المنتج
                    </h5>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            الاسم
                        </span>

                        <strong id="summaryName">
                            —
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            السعر
                        </span>

                        <strong id="summaryPrice">
                            —
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            الصور
                        </span>

                        <strong id="summaryImages">
                            0
                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex align-items-center gap-2 text-success">

                        <span>
                            ✓
                        </span>

                        <span class="small fw-semibold">
                            المنتج جاهز للإضافة
                        </span>

                    </div>

                </div>

            </div>


            {{-- Save --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg w-100 fw-bold">

                        <span class="me-1">
                            ＋
                        </span>

                        حفظ المنتج

                    </button>


                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-light border btn-lg w-100 mt-2">

                        إلغاء

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>
```

</div>

{{-- Page Scripts --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imagesInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');

    const nameInput = document.querySelector('input[name="name"]');

    const priceInput = document.getElementById('price');
    const discountInput = document.getElementById('discount_price');

    const summaryName = document.getElementById('summaryName');
    const summaryPrice = document.getElementById('summaryPrice');
    const summaryImages = document.getElementById('summaryImages');

    const pricePreview = document.getElementById('pricePreview');
    const finalPrice = document.getElementById('finalPrice');
    const discountBadge = document.getElementById('discountBadge');


    /*
    |--------------------------------------------------------------------------
    | Product Name
    |--------------------------------------------------------------------------
    */

    function updateName() {

        summaryName.textContent =
            nameInput.value.trim() || '—';

    }

    nameInput.addEventListener('input', updateName);


    /*
    |--------------------------------------------------------------------------
    | Price
    |--------------------------------------------------------------------------
    */

    function updatePrice() {

        const price =
            parseFloat(priceInput.value) || 0;

        const discount =
            parseFloat(discountInput.value) || 0;

        if (price <= 0) {

            pricePreview.classList.add('d-none');

            summaryPrice.textContent = '—';

            return;

        }

        const final =
            discount > 0 && discount < price
                ? discount
                : price;

        const percentage =
            discount > 0 && discount < price
                ? Math.round(
                    ((price - discount) / price) * 100
                )
                : 0;


        pricePreview.classList.remove('d-none');

        finalPrice.textContent =
            '$' + final.toFixed(2);

        summaryPrice.textContent =
            '$' + final.toFixed(2);


        if (percentage > 0) {

            discountBadge.classList.remove('d-none');

            discountBadge.textContent =
                'خصم ' + percentage + '%';

        } else {

            discountBadge.classList.add('d-none');

        }

    }

    priceInput.addEventListener('input', updatePrice);

    discountInput.addEventListener('input', updatePrice);


    /*
    |--------------------------------------------------------------------------
    | Images Preview
    |--------------------------------------------------------------------------
    */

    imagesInput.addEventListener('change', function () {

        imagePreview.innerHTML = '';

        const files = Array.from(this.files);

        summaryImages.textContent =
            files.length;


        files.forEach(function (file, index) {

            const reader =
                new FileReader();


            reader.onload = function (event) {

                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'col-6 col-md-4';


                wrapper.innerHTML = `

                    <div class="position-relative rounded-4 overflow-hidden border">

                        <img
                            src="${event.target.result}"
                            class="w-100"
                            style="height:150px;object-fit:cover">

                        <span
                            class="position-absolute top-0 end-0 m-2 badge bg-dark rounded-pill">

                            ${index + 1}

                        </span>

                    </div>

                `;

                imagePreview.appendChild(wrapper);

            };


            reader.readAsDataURL(file);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    updateName();
    updatePrice();

});

</script>

@endsection
