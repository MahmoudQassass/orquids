@extends('admin.layouts.app')

@section('title', 'تعديل التصنيف')

@section('page-title', 'تعديل التصنيف')

@section('content')

<style>
    .form-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e9e7ef;
        border-radius: 18px;
        box-shadow: 0 3px 15px rgba(25, 20, 50, .035);
        overflow: hidden;
    }

    .form-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eeeaf2;
    }

    .form-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #29243a;
    }

    .form-card-description {
        margin: 5px 0 0;
        color: #8b8697;
        font-size: 13px;
    }

    .form-card-body {
        padding: 25px;
    }

    .field-label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #403b4c;
        margin-bottom: 8px;
    }

    .field-label span {
        color: #c04a5a;
    }

    .form-control,
    .form-select {
        border: 1px solid #e1dce8;
        border-radius: 11px;
        min-height: 45px;
        font-size: 13px;
        box-shadow: none !important;
    }

    textarea.form-control {
        min-height: 125px;
        resize: vertical;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #8b68d1;
    }

    .field-help {
        color: #96909f;
        font-size: 11px;
        margin-top: 6px;
    }

    .status-box {
        background: #faf9fc;
        border: 1px solid #ebe7f0;
        border-radius: 12px;
        padding: 14px 15px;
    }

    .status-title {
        font-size: 13px;
        font-weight: 800;
        color: #403b4c;
        margin-bottom: 4px;
    }

    .status-description {
        font-size: 11px;
        color: #918b9b;
        margin-bottom: 10px;
    }

    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.35em;
        margin-left: 8px;
        float: none;
        vertical-align: middle;
    }

    .form-actions {
        padding: 18px 25px;
        background: #faf9fc;
        border-top: 1px solid #eeeaf2;
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .btn-save {
        background: #6f42c1;
        border: 0;
        color: #fff;
        border-radius: 10px;
        padding: 11px 22px;
        font-weight: 800;
        font-size: 13px;
    }

    .btn-save:hover {
        background: #5e35aa;
        color: #fff;
    }

    .btn-cancel {
        background: #fff;
        border: 1px solid #ded9e5;
        color: #625d70;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
    }

    .invalid-feedback {
        font-size: 11px;
    }

    .category-meta {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .meta-badge {
        background: #f5f2f9;
        color: #6f42c1;
        border-radius: 7px;
        padding: 5px 9px;
        font-size: 11px;
        font-weight: 700;
    }
</style>

<div class="form-page">

    <div class="form-card">

        <div class="form-card-header">

            <h2 class="form-card-title">
                تعديل التصنيف
            </h2>

            <p class="form-card-description">
                تعديل بيانات التصنيف: {{ $category->name }}
            </p>

            <div class="category-meta">

                <span class="meta-badge">
                    {{ $category->products_count ?? $category->products()->count() }}
                    منتج
                </span>

                <span class="meta-badge">
                    {{ $category->created_at?->format('Y-m-d') }}
                </span>

            </div>

        </div>

        <form
            method="POST"
            action="{{ route('admin.categories.update', $category) }}"
        >

            @csrf
            @method('PUT')

            <div class="form-card-body">

                @if($errors->any())

                    <div class="alert alert-danger border-0 rounded-3 small mb-4">
                        <i class="bi bi-exclamation-circle ms-1"></i>
                        يرجى تصحيح الأخطاء الموجودة في النموذج.
                    </div>

                @endif

                <div class="row g-4">

                    <div class="col-12">

                        <label class="field-label">
                            اسم التصنيف <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-12">

                        <label class="field-label">
                            الرابط المختصر
                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $category->slug) }}"
                            class="form-control @error('slug') is-invalid @enderror"
                            dir="ltr"
                        >

                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-12">

                        <label class="field-label">
                            الوصف
                        </label>

                        <textarea
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                        >{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-12">

                        <div class="status-box">

                            <div class="status-title">
                                حالة التصنيف
                            </div>

                            <div class="status-description">
                                يمكنك إخفاء التصنيف دون حذفه من النظام.
                            </div>

                            <div class="form-check form-switch">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="active"
                                    value="1"
                                    id="active"
                                    {{ old('status', $category->status) ? 'checked' : '' }}
                                >

                                <label class="form-check-label small fw-bold" for="active">
                                    تصنيف نشط
                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="form-actions">

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="btn-cancel"
                >
                    إلغاء
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-check-lg ms-1"></i>
                    حفظ التعديلات
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
