@extends('admin.layouts.app')

@section('title', 'إنشاء كوبون')

@section('page-title', 'إنشاء كوبون')

@section('content')

<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                إنشاء كوبون جديد
            </h2>

            <div class="text-muted small">
                إنشاء كوبون وتوزيعه على العملاء لاحقًا
            </div>

        </div>


        <a
            href="{{ route('admin.coupons.index') }}"
            class="btn btn-light border">

            <i class="bi bi-arrow-right me-1"></i>

            العودة

        </a>

    </div>


    <div class="card">

        <div class="card-header">

            <div class="fw-bold">
                بيانات الكوبون
            </div>

        </div>


        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.coupons.store') }}">

                @csrf

                <div class="row g-4">


                    {{-- Code --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            كود الكوبون
                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                name="code"
                                id="couponCode"
                                class="form-control"
                                value="{{ old('code') }}"
                                placeholder="مثال: ORC-2026">

                            <button
                                type="button"
                                class="btn btn-outline-dark"
                                id="generateCode">

                                <i class="bi bi-magic"></i>

                                توليد

                            </button>

                        </div>

                        <div class="form-text">
                            اتركه فارغًا ليتم توليده تلقائيًا.
                        </div>

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
                            required>

                            <option
                                value="discount"
                                @selected(old('type', 'discount') === 'discount')>

                                خصم بنسبة مئوية

                            </option>

                            <option
                                value="free_shipping"
                                @selected(old('type') === 'free_shipping')>

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
                                value="{{ old('discount_percent', 10) }}"
                                min="0.01"
                                max="100"
                                step="0.01">

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
                            value="{{ old('expires_at') }}">

                        <div class="form-text">
                            اتركه فارغًا إذا لم يكن للكوبون تاريخ انتهاء.
                        </div>

                    </div>


                    <div class="col-12">

                        <div class="alert alert-light border mb-0">

                            <i class="bi bi-info-circle me-1"></i>

                            إذا تركت كود الكوبون فارغًا، سيتم إنشاء كود
                            عشوائي وفريد تلقائيًا.

                        </div>

                    </div>


                    <div class="col-12">

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-dark">

                                <i class="bi bi-check-lg me-1"></i>

                                إنشاء الكوبون

                            </button>


                            <a
                                href="{{ route('admin.coupons.index') }}"
                                class="btn btn-light border">

                                إلغاء

                            </a>

                        </div>

                    </div>

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

    const code =
        document.getElementById('couponCode');

    const generateButton =
        document.getElementById('generateCode');


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


    generateButton.addEventListener(
        'click',
        function () {

            const chars =
                'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

            let result = 'ORC-';

            for (let i = 0; i < 8; i++) {

                result +=
                    chars.charAt(
                        Math.floor(
                            Math.random() *
                            chars.length
                        )
                    );

            }

            code.value = result;

        }
    );

});

</script>

@endpush
