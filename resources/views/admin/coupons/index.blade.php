@extends('admin.layouts.app')

@section('title', 'الكوبونات')

@section('page-title', 'الكوبونات')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                إدارة الكوبونات
            </h2>

            <div class="text-muted small">
                إنشاء وإدارة كوبونات الخصم والشحن المجاني
            </div>
        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-dark"
                data-bs-toggle="modal"
                data-bs-target="#generateCouponsModal">

                <i class="bi bi-magic me-1"></i>

                توليد كوبونات
            </button>

            <a
                href="{{ route('admin.coupons.create') }}"
                class="btn btn-outline-dark">

                <i class="bi bi-plus-lg me-1"></i>

                كوبون جديد
            </a>

        </div>

    </div>


    {{-- Filters --}}
    <div class="card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.coupons.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-5">

                        <label class="form-label">
                            البحث
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="ابحث بكود الكوبون...">

                    </div>


                    <div class="col-lg-3">

                        <label class="form-label">
                            الحالة
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">
                                جميع الحالات
                            </option>

                            <option
                                value="available"
                                @selected(request('status') === 'available')>

                                متاح
                            </option>

                            <option
                                value="used"
                                @selected(request('status') === 'used')>

                                مستخدم
                            </option>

                            <option
                                value="expired"
                                @selected(request('status') === 'expired')>

                                منتهي
                            </option>

                        </select>

                    </div>


                    <div class="col-lg-2">

                        <button
                            type="submit"
                            class="btn btn-dark w-100">

                            <i class="bi bi-search me-1"></i>

                            بحث

                        </button>

                    </div>


                    <div class="col-lg-2">

                        <a
                            href="{{ route('admin.coupons.index') }}"
                            class="btn btn-light border w-100">

                            إعادة ضبط

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Table --}}
    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <div class="fw-bold">

                    جميع الكوبونات

                </div>

                <span class="text-muted small">

                    {{ $coupons->total() }} كوبون

                </span>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>الكود</th>
                        <th>النوع</th>
                        <th>الخصم</th>
                        <th>الحالة</th>
                        <th>المستخدم</th>
                        <th>الهاتف</th>
                        <th>الانتهاء</th>
                        <th class="text-end">الإجراءات</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($coupons as $coupon)

                        <tr>

                            <td>
                                {{ $coupon->id }}
                            </td>


                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <code class="fw-bold">
                                        {{ $coupon->code }}
                                    </code>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light border copy-code"
                                        data-code="{{ $coupon->code }}"
                                        title="نسخ الكود">

                                        <i class="bi bi-copy"></i>

                                    </button>

                                </div>

                            </td>


                            <td>

                                @if($coupon->type === 'discount')

                                    <span class="badge bg-primary">
                                        خصم
                                    </span>

                                @else

                                    <span class="badge bg-info text-dark">
                                        شحن مجاني
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($coupon->type === 'discount')

                                    {{ $coupon->discount_percent }}%

                                @else

                                    —

                                @endif

                            </td>


                            <td>

                                @if($coupon->is_used)

                                    <span class="badge bg-secondary">
                                        مستخدم
                                    </span>

                                @elseif($coupon->expires_at && $coupon->expires_at->isPast())

                                    <span class="badge bg-danger">
                                        منتهي
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        متاح
                                    </span>

                                @endif

                            </td>

                            {{-- USER NAME --}}
                            <td>

                                @if($coupon->order)

                                    <div class="fw-semibold">
                                        {{ $coupon->order->customer_name }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- USER PHONE --}}
                            <td>

                                @if($coupon->order)

                                    <a
                                        href="tel:{{ $coupon->order->phone }}"
                                        class="text-decoration-none">

                                        {{ $coupon->order->phone }}

                                    </a>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($coupon->expires_at)

                                    <span
                                        title="{{ $coupon->expires_at->format('Y-m-d H:i') }}">

                                        {{ $coupon->expires_at->format('Y-m-d') }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        بدون انتهاء
                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="d-flex justify-content-end gap-1">

                                    @if(!$coupon->is_used)

                                        <a
                                            href="{{ route('admin.coupons.edit', $coupon) }}"
                                            class="btn btn-sm btn-light border"
                                            title="تعديل">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <form
                                            action="{{ route('admin.coupons.destroy', $coupon) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الكوبون؟');">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="حذف">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    @else

                                        <span class="text-muted small px-2">
                                            مستخدم
                                        </span>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i
                                        class="bi bi-ticket-perforated"
                                        style="font-size:40px">
                                    </i>

                                    <div class="mt-2 fw-bold">
                                        لا توجد كوبونات
                                    </div>

                                    <div class="small mt-1">
                                        ابدأ بإنشاء كوبون جديد
                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($coupons->hasPages())

            <div class="card-body border-top">

                {{ $coupons->links() }}

            </div>

        @endif

    </div>

</div>


{{-- Generate Modal --}}
<div
    class="modal fade"
    id="generateCouponsModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    <i class="bi bi-magic me-1"></i>

                    توليد كوبونات

                </h5>

                <button
                    type="button"
                    class="btn-close ms-0 me-auto"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form
                method="POST"
                action="{{ route('admin.coupons.generate') }}">

                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            عدد الكوبونات
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            class="form-control"
                            min="1"
                            max="500"
                            value="10"
                            required>

                        <div class="form-text">
                            الحد الأقصى 500 كوبون في العملية الواحدة.
                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            نوع الكوبون
                        </label>

                        <select
                            name="type"
                            id="generateType"
                            class="form-select"
                            required>

                            <option value="discount">
                                خصم بنسبة مئوية
                            </option>

                            <option value="free_shipping">
                                شحن مجاني
                            </option>

                        </select>

                    </div>


                    <div
                        class="mb-3"
                        id="generateDiscountContainer">

                        <label class="form-label">
                            نسبة الخصم
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="discount_percent"
                                class="form-control"
                                min="0.01"
                                max="100"
                                step="0.01"
                                value="10">

                            <span class="input-group-text">
                                %
                            </span>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            تاريخ الانتهاء
                        </label>

                        <input
                            type="datetime-local"
                            name="expires_at"
                            class="form-control">

                        <div class="form-text">
                            اتركه فارغًا إذا كان الكوبون بدون انتهاء.
                        </div>

                    </div>


                    <div class="alert alert-light border mb-0">

                        <i class="bi bi-info-circle me-1"></i>

                        سيتم توليد كود فريد لكل كوبون تلقائيًا.

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        إلغاء

                    </button>

                    <button
                        type="submit"
                        class="btn btn-dark">

                        <i class="bi bi-magic me-1"></i>

                        توليد الكوبونات

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Copy Coupon
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.copy-code')
        .forEach(function(button) {

            button.addEventListener('click', function() {

                const code = this.dataset.code;

                navigator.clipboard.writeText(code)
                    .then(() => {

                        const original =
                            this.innerHTML;

                        this.innerHTML =
                            '<i class="bi bi-check-lg text-success"></i>';

                        setTimeout(() => {

                            this.innerHTML =
                                original;

                        }, 1200);

                    });

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Generate Type
    |--------------------------------------------------------------------------
    */

    const type =
        document.getElementById('generateType');

    const discountContainer =
        document.getElementById(
            'generateDiscountContainer'
        );


    function updateDiscountVisibility() {

        if (type.value === 'discount') {

            discountContainer.style.display =
                'block';

        } else {

            discountContainer.style.display =
                'none';

        }

    }


    type.addEventListener(
        'change',
        updateDiscountVisibility
    );


    updateDiscountVisibility();

});

</script>

@endpush
