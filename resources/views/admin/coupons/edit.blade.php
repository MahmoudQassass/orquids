@extends('admin.layouts.app')

@section('title', 'تعديل الكوبون')

@section('page-title', 'تعديل الكوبون')

@section('content')

<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                تعديل الكوبون
            </h2>

            <div class="text-muted small">
                تعديل بيانات الكوبون
            </div>

        </div>


        <a
            href="{{ route('admin.coupons.index') }}"
            class="btn btn-light border">

            <i class="bi bi-arrow-right me-1"></i>

            العودة

        </a>

    </div>


    @if($coupon->is_used)

        <div class="alert alert-warning">

            <i class="bi bi-exclamation-triangle-fill me-1"></i>

            هذا الكوبون تم استخدامه بالفعل ولا يمكن تعديله.

        </div>

    @endif


    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <div class="fw-bold">
                    {{ $coupon->code }}
                </div>

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

            </div>

        </div>


        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.coupons.update', $coupon) }}">

                @csrf

                @method('PUT')


                <div class="row g-4">


                    {{-- Code --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            كود الكوبون
                        </label>

                        <input
                            type="text"
                            name="code"
                            class="form-control"
                            value="{{ old('code', $coupon->code) }}"
                            required
                            @disabled($coupon->is_used)>

                    </div>


                    {{-- Type --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            نوع الكوبون
                        </label>

                        <select
                            name="type"
                            id="couponType"
                            class="form-select"
                            required
                            @disabled($coupon->is_used)>

                            <option
                                value="discount"
                                @selected(old('type', $coupon->type) === 'discount')>

                                خصم بنسبة مئوية

                            </option>

                            <option
                                value="free_shipping"
                                @selected(old('type', $coupon->type) === 'free_shipping')>

                                شحن مجاني

                            </option>

                        </select>

                    </div>


                    {{-- Discount --}}
                    <div
                        class="col-md-6"
                        id="discountContainer">

                        <label class="form-label">
                            نسبة الخصم
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="discount_percent"
                                class="form-control"
                                value="{{ old('discount_percent', $coupon->discount_percent) }}"
                                min="0.01"
                                max="100"
                                step="0.01"
                                @disabled($coupon->is_used)>

                            <span class="input-group-text">
                                %
                            </span>

                        </div>

                    </div>


                    {{-- Expiration --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            تاريخ الانتهاء
                        </label>

                        <input
                            type="datetime-local"
                            name="expires_at"
                            class="form-control"
                            value="{{ old(
                                'expires_at',
                                $coupon->expires_at
                                    ? $coupon->expires_at->format('Y-m-d\TH:i')
                                    : ''
                            ) }}"
                            @disabled($coupon->is_used)>

                    </div>


                    @if($coupon->is_used)

                        <div class="col-md-6">

                            <label class="form-label">
                                تاريخ الاستخدام
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $coupon->used_at?->format('Y-m-d H:i') }}"
                                disabled>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                رقم الطلب
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $coupon->order_id ?? '—' }}"
                                disabled>

                        </div>

                    @endif


                    @unless($coupon->is_used)

                        <div class="col-12">

                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-dark">

                                    <i class="bi bi-check-lg me-1"></i>

                                    حفظ التعديلات

                                </button>


                                <a
                                    href="{{ route('admin.coupons.index') }}"
                                    class="btn btn-light border">

                                    إلغاء

                                </a>

                            </div>

                        </div>

                    @endunless

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const type =
        document.getElementById('couponType');

    const discountContainer =
        document.getElementById(
            'discountContainer'
        );


    function updateType() {

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
        updateType
    );


    updateType();

});

</script>

@endpush
