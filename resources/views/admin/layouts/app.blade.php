<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'لوحة التحكم') | أوركيدس
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    {{-- Google Font --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    <style>

        :root {

            --sidebar-width: 270px;

            --primary: #111827;

            --primary-hover: #1f2937;

            --background: #f6f7fb;

            --card: #ffffff;

            --border: #e9ebf0;

            --text: #111827;

            --muted: #6b7280;

            --sidebar: #111827;

            --sidebar-hover: #1f2937;

            --sidebar-active: #ffffff;

            --sidebar-text: #9ca3af;

        }


        * {
            box-sizing: border-box;
        }


        html {
            min-height: 100%;
        }


        body {

            margin: 0;

            min-height: 100vh;

            background: var(--background);

            color: var(--text);

            font-family:
                'Tajawal',
                Arial,
                sans-serif;

            font-size: 15px;

        }


        a {
            text-decoration: none;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .admin-sidebar {

            position: fixed;

            top: 0;

            right: 0;

            width: var(--sidebar-width);

            height: 100vh;

            background: var(--sidebar);

            color: white;

            z-index: 1050;

            display: flex;

            flex-direction: column;

            transition: transform .25s ease;

            box-shadow:
                -10px 0 30px rgba(0,0,0,.05);

        }


        /* Logo */

        .sidebar-brand {

            height: 78px;

            padding: 0 24px;

            display: flex;

            align-items: center;

            gap: 12px;

            border-bottom:
                1px solid rgba(255,255,255,.07);

        }


        .brand-icon {

            width: 40px;

            height: 40px;

            border-radius: 12px;

            background: white;

            color: #111827;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            font-weight: 800;

        }


        .brand-name {

            font-size: 19px;

            font-weight: 800;

            color: white;

            letter-spacing: -.3px;

        }


        .brand-subtitle {

            display: block;

            font-size: 10px;

            color: #6b7280;

            margin-top: 1px;

        }


        /* Navigation */

        .sidebar-content {

            flex: 1;

            overflow-y: auto;

            padding: 22px 14px;

        }


        .sidebar-section {

            color: #6b7280;

            font-size: 11px;

            font-weight: 700;

            margin:

                10px 12px

                10px;

            text-transform: uppercase;

            letter-spacing: .5px;

        }


        .sidebar-nav {

            list-style: none;

            padding: 0;

            margin: 0 0 24px;

        }


        .sidebar-nav li {
            margin-bottom: 5px;
        }


        .sidebar-link {

            position: relative;

            display: flex;

            align-items: center;

            gap: 12px;

            width: 100%;

            min-height: 46px;

            padding: 0 14px;

            border-radius: 12px;

            color: var(--sidebar-text);

            font-weight: 600;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;

        }


        .sidebar-link i {

            width: 22px;

            text-align: center;

            font-size: 17px;

        }


        .sidebar-link:hover {

            color: white;

            background: var(--sidebar-hover);

            transform: translateX(-2px);

        }


        .sidebar-link.active {

            color: #111827;

            background: white;

            box-shadow:
                0 8px 20px rgba(0,0,0,.12);

        }


        .sidebar-link.active i {
            color: #111827;
        }


        .sidebar-badge {

            margin-right: auto;

            font-size: 10px;

            padding: 3px 7px;

            border-radius: 20px;

            background: #374151;

            color: #d1d5db;

        }


        /* Sidebar bottom */

        .sidebar-footer {

            padding: 16px;

            border-top:
                1px solid rgba(255,255,255,.07);

        }


        .admin-profile {

            display: flex;

            align-items: center;

            gap: 11px;

            padding: 10px;

            border-radius: 12px;

            background:
                rgba(255,255,255,.04);

        }


        .profile-avatar {

            width: 38px;

            height: 38px;

            border-radius: 11px;

            background: #374151;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-weight: 800;

        }


        .profile-name {

            color: white;

            font-weight: 700;

            font-size: 13px;

        }


        .profile-role {

            color: #6b7280;

            font-size: 11px;

            margin-top: 2px;

        }


        /* =========================================================
           MAIN
        ========================================================= */

        .admin-main {

            margin-right: var(--sidebar-width);

            min-height: 100vh;

        }


        /* =========================================================
           TOPBAR
        ========================================================= */

        .admin-topbar {

            position: sticky;

            top: 0;

            z-index: 1000;

            height: 78px;

            background:
                rgba(255,255,255,.94);

            backdrop-filter: blur(12px);

            border-bottom:
                1px solid var(--border);

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                0 34px;

        }


        .topbar-left {

            display: flex;

            align-items: center;

            gap: 14px;

        }


        .mobile-menu-btn {

            display: none;

            width: 42px;

            height: 42px;

            border: 1px solid var(--border);

            background: white;

            border-radius: 11px;

            align-items: center;

            justify-content: center;

            font-size: 19px;

        }


        .page-heading {

            font-size: 20px;

            font-weight: 800;

            margin: 0;

            color: #111827;

        }


        .page-breadcrumb {

            margin-top: 3px;

            color: var(--muted);

            font-size: 12px;

        }


        .topbar-actions {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .topbar-btn {

            width: 42px;

            height: 42px;

            border-radius: 11px;

            border: 1px solid var(--border);

            background: white;

            color: #4b5563;

            display: flex;

            align-items: center;

            justify-content: center;

            transition: .2s ease;

        }


        .topbar-btn:hover {

            background: #f9fafb;

            color: #111827;

        }


        .store-btn {

            height: 42px;

            padding: 0 15px;

            border-radius: 11px;

            border: 1px solid var(--border);

            background: white;

            color: #111827;

            display: flex;

            align-items: center;

            gap: 8px;

            font-size: 13px;

            font-weight: 700;

        }


        .store-btn:hover {
            background: #f9fafb;
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .admin-content {

            padding:
                32px 34px 45px;

        }


        /* =========================================================
           CARDS
        ========================================================= */

        .card {

            border:

                1px solid var(--border) !important;

            border-radius: 16px !important;

            box-shadow:
                0 4px 20px rgba(17,24,39,.035) !important;

        }


        .card-header {

            background: white !important;

            border-bottom:
                1px solid var(--border) !important;

            padding: 18px 22px !important;

        }


        .card-body {
            padding: 22px !important;
        }


        /* =========================================================
           FORMS
        ========================================================= */

        .form-label {

            font-weight: 700;

            font-size: 13px;

            margin-bottom: 8px;

            color: #374151;

        }


        .form-control,
        .form-select {

            min-height: 46px;

            border-color: #e5e7eb;

            border-radius: 11px;

            padding:
                8px 13px;

            font-family:
                'Tajawal',
                Arial,
                sans-serif;

        }


        textarea.form-control {
            min-height: auto;
        }


        .form-control:focus,
        .form-select:focus {

            border-color: #9ca3af;

            box-shadow:
                0 0 0 3px rgba(17,24,39,.07);

        }


        /* =========================================================
           BUTTONS
        ========================================================= */

        .btn {

            border-radius: 10px;

            font-weight: 700;

            font-family:
                'Tajawal',
                Arial,
                sans-serif;

        }


        .btn-primary {

            background: #111827;

            border-color: #111827;

        }


        .btn-primary:hover {

            background: #1f2937;

            border-color: #1f2937;

        }


        .btn-dark {

            background: #111827;

            border-color: #111827;

        }


        /* =========================================================
           TABLE
        ========================================================= */

        .table {

            margin-bottom: 0;

        }


        .table thead th {

            background: #f9fafb;

            color: #6b7280;

            font-size: 12px;

            font-weight: 800;

            border-bottom:
                1px solid var(--border);

            padding:
                14px 16px;

            white-space: nowrap;

        }


        .table tbody td {

            padding:
                15px 16px;

            border-color:
                #f0f1f4;

            font-size: 13px;

        }


        .table-hover tbody tr:hover {

            background:
                #fafafa;

        }


        /* =========================================================
           BADGES
        ========================================================= */

        .badge {

            border-radius: 20px;

            padding:
                6px 10px;

            font-size: 11px;

            font-weight: 700;

        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {

            border-radius: 13px;

            border: none;

            font-weight: 600;

        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination {

            margin-bottom: 0;

        }


        .page-link {

            color: #111827;

            border-color:
                #e5e7eb;

            border-radius: 8px !important;

            margin: 0 2px;

        }


        .page-item.active .page-link {

            background: #111827;

            border-color: #111827;

        }


        /* =========================================================
           MOBILE OVERLAY
        ========================================================= */

        .sidebar-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0,0,0,.45);

            z-index: 1040;

        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991.98px) {

            .admin-sidebar {

                transform:
                    translateX(100%);

            }


            .admin-sidebar.show {

                transform:
                    translateX(0);

            }


            .sidebar-overlay.show {

                display: block;

            }


            .admin-main {

                margin-right: 0;

            }


            .mobile-menu-btn {

                display: flex;

            }


            .admin-topbar {

                padding:
                    0 20px;

            }


            .admin-content {

                padding:
                    24px 20px 35px;

            }


            .store-btn span {

                display: none;

            }

        }


        @media (max-width: 575.98px) {

            .admin-topbar {

                height: 70px;

            }


            .page-heading {

                font-size: 17px;

            }


            .page-breadcrumb {

                display: none;

            }


            .admin-content {

                padding:
                    20px 14px 30px;

            }


            .topbar-actions {

                gap: 6px;

            }


            .topbar-btn,
            .mobile-menu-btn {

                width: 39px;

                height: 39px;

            }


            .store-btn {

                width: 39px;

                height: 39px;

                padding: 0;

                justify-content: center;

            }


            .card-body {

                padding: 17px !important;

            }

        }

        :root {
    --sidebar-width: 270px;
    --sidebar-collapsed-width: 78px;
}


/* =========================================================
   SIDEBAR
========================================================= */

.admin-sidebar {
    position: fixed;

    top: 0;
    right: 0;

    width: var(--sidebar-collapsed-width);
    height: 100vh;

    background: var(--sidebar);

    z-index: 1050;

    display: flex;
    flex-direction: column;

    overflow: hidden;

    transition: width .28s cubic-bezier(.4, 0, .2, 1);

    box-shadow:
        -10px 0 30px rgba(0,0,0,.05);
}


/* عندما يكون الماوس فوق الـSidebar */

.admin-sidebar:hover {
    width: var(--sidebar-width);
}


/* =========================================================
   MAIN
========================================================= */

.admin-main {
    margin-right: var(--sidebar-collapsed-width);

    min-height: 100vh;

    transition:
        margin-right .28s cubic-bezier(.4, 0, .2, 1);
}


/* عندما يفتح الـSidebar */

.admin-sidebar:hover ~ .admin-main {
    margin-right: var(--sidebar-width);
}


/* =========================================================
   BRAND
========================================================= */

.sidebar-brand {
    height: 78px;

    padding: 0 19px;

    display: flex;
    align-items: center;

    gap: 12px;

    border-bottom:
        1px solid rgba(255,255,255,.07);

    white-space: nowrap;
}


/* اسم المتجر */

.brand-info {
    opacity: 0;

    width: 0;

    overflow: hidden;

    transition:
        opacity .18s ease,
        width .28s ease;
}


/* عند فتح Sidebar */

.admin-sidebar:hover .brand-info {
    opacity: 1;
    width: 150px;
}


/* زر الفتح لم يعد مطلوبًا */

.sidebar-toggle {
    display: none !important;
}


/* =========================================================
   CONTENT
========================================================= */

.sidebar-content {
    flex: 1;

    overflow-y: auto;

    padding: 22px 10px;
}


/* =========================================================
   SECTION
========================================================= */

.sidebar-section {
    color: #6b7280;

    font-size: 0;

    font-weight: 700;

    height: 10px;

    margin: 10px 4px;

    white-space: nowrap;

    overflow: hidden;

    transition:
        font-size .2s ease,
        height .28s ease,
        margin .28s ease;
}


/* عند الفتح */

.admin-sidebar:hover .sidebar-section {
    font-size: 11px;

    height: auto;

    margin:
        10px 12px;
}


/* =========================================================
   NAV
========================================================= */

.sidebar-nav {
    list-style: none;

    padding: 0;

    margin: 0 0 24px;
}


.sidebar-nav li {
    margin-bottom: 5px;
}


/* =========================================================
   LINKS
========================================================= */

.sidebar-link {
    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    width: 100%;

    min-height: 46px;

    padding: 0;

    border-radius: 12px;

    color: var(--sidebar-text);

    font-weight: 600;

    white-space: nowrap;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;
}


/* عند فتح Sidebar */

.admin-sidebar:hover .sidebar-link {
    justify-content: flex-start;

    padding: 0 14px;
}


/* =========================================================
   ICON
========================================================= */

.sidebar-link i {
    width: 22px;

    min-width: 22px;

    text-align: center;

    font-size: 17px;
}


/* =========================================================
   TEXT
========================================================= */

.sidebar-link span {
    display: none;

    overflow: hidden;

    opacity: 0;

    transition: opacity .15s ease;
}


.admin-sidebar:hover .sidebar-link span {
    display: inline;

    opacity: 1;
}


/* =========================================================
   BADGE
========================================================= */

.sidebar-badge {
    display: none;
}


.admin-sidebar:hover .sidebar-badge {
    display: inline-block;

    margin-right: auto;
}


/* =========================================================
   HOVER
========================================================= */

.sidebar-link:hover {
    color: white;

    background: var(--sidebar-hover);

    transform: translateX(-2px);
}


/* =========================================================
   ACTIVE
========================================================= */

.sidebar-link.active {
    color: #111827;

    background: white;

    box-shadow:
        0 8px 20px rgba(0,0,0,.12);
}


.sidebar-link.active i {
    color: #111827;
}


/* =========================================================
   PROFILE
========================================================= */

.sidebar-footer {
    padding: 12px 10px;

    border-top:
        1px solid rgba(255,255,255,.07);
}


.admin-profile {
    display: flex;

    align-items: center;

    justify-content: center;

    gap: 11px;

    padding: 8px;

    border-radius: 12px;

    background:
        rgba(255,255,255,.04);
}


.admin-sidebar:hover .admin-profile {
    justify-content: flex-start;

    padding: 10px;
}


.profile-name,
.profile-role {
    display: none;
}


.admin-sidebar:hover .profile-name,
.admin-sidebar:hover .profile-role {
    display: block;
}


/* =========================================================
   LOGOUT
========================================================= */

.admin-sidebar .sidebar-footer form .sidebar-link {
    justify-content: center;
}


.admin-sidebar:hover .sidebar-footer form .sidebar-link {
    justify-content: flex-start;

    padding: 0 14px;
}


/* =========================================================
   TOOLTIP
========================================================= */

.sidebar-link::after {
    content: attr(title);

    position: absolute;

    right: calc(100% + 10px);

    top: 50%;

    transform: translateY(-50%);

    background: #111827;

    color: white;

    padding: 7px 10px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    white-space: nowrap;

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition: .15s ease;

    z-index: 2000;
}


/* Tooltip يظهر فقط عندما يكون Sidebar مغلق */

.admin-sidebar:not(:hover) .sidebar-link:hover::after {
    opacity: 1;

    visibility: visible;
}

@media (max-width: 991.98px) {

    .admin-sidebar {
        width: var(--sidebar-width);

        transform: translateX(100%);

        transition:
            transform .28s cubic-bezier(.4, 0, .2, 1);
    }

    .admin-sidebar:hover {
        width: var(--sidebar-width);
    }

    .admin-sidebar.show {
        transform: translateX(0);
    }

    .admin-main {
        margin-right: 0;
    }

    .admin-sidebar:hover ~ .admin-main {
        margin-right: 0;
    }

    /* إظهار المحتوى كاملًا في الموبايل */

    .admin-sidebar .brand-info,
    .admin-sidebar .sidebar-link span,
    .admin-sidebar .profile-name,
    .admin-sidebar .profile-role {
        display: block;

        opacity: 1;

        width: auto;
    }

    .admin-sidebar .sidebar-section {
        font-size: 11px;

        height: auto;

        margin: 10px 12px;
    }

    .admin-sidebar .sidebar-link {
        justify-content: flex-start;

        padding: 0 14px;
    }

    .admin-sidebar .admin-profile {
        justify-content: flex-start;
    }

    .sidebar-toggle {
        display: none !important;
    }
}

    </style>

    @stack('styles')

</head>


<body>


{{-- =========================================================
     SIDEBAR
========================================================= --}}

<aside
    id="adminSidebar"
    class="admin-sidebar">


    {{-- Brand --}}

    <div class="sidebar-brand">

        <div class="brand-icon">

            <i class="bi bi-shop"></i>

        </div>

        <div>

            <div class="brand-name">
                أوركيدس
            </div>

            <span class="brand-subtitle">
                نظام إدارة المتجر
            </span>

        </div>

        <button
            type="button"
            class="mobile-menu-btn btn btn-light rounded-3 shadow-sm border"
            aria-label="فتح القائمة"
        >
            <i class="bi bi-list fs-5"></i>
        </button>

    </div>


    {{-- Navigation --}}

    <div class="sidebar-content">


        <div class="sidebar-section">
            الرئيسية
        </div>


        <ul class="sidebar-nav">


            <li>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="sidebar-link
                    {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-grid-1x2-fill"></i>

                    <span>
                        لوحة التحكم
                    </span>

                </a>

            </li>


        </ul>


        <div class="sidebar-section">
            المتجر
        </div>


        <ul class="sidebar-nav">


            <li>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="sidebar-link
                    {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">

                    <i class="bi bi-box-seam-fill"></i>

                    <span>
                        المنتجات
                    </span>

                </a>

            </li>


            <li>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="sidebar-link
                    {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">

                    <i class="bi bi-receipt-cutoff"></i>

                    <span>
                        الطلبات
                    </span>

                </a>

            </li>

            <li>

                <a
                    href="{{ route('admin.coupons.index') }}"
                    class="sidebar-link
                    {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">

                    <i class="bi bi-ticket-perforated-fill"></i>

                    <span>
                        الكوبونات
                    </span>

                </a>

            </li>

           <li class="sidebar-item">
                <a
                    href="{{ route('admin.customers.index') }}"
                    class="sidebar-link d-flex align-items-center gap-3 px-3 py-2 rounded-3
                    {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                    title="العملاء"
                >
                    <span class="sidebar-icon d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill"></i>
                    </span>

                    <span class="sidebar-text">
                        العملاء
                    </span>
                </a>
            </li>

             <li>
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                >
                    <i class="bi bi-tags-fill"></i>

                    <span>
                        التصنيفات
                    </span>
                </a>
            </li>

            <li>
                <a
                    href="{{ route('admin.countries.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}"
                >
                    <i class="bi bi-globe2"></i>

                    <span>
                        الدول
                    </span>
                </a>
            </li>


        </ul>


        <div class="sidebar-section">
            روابط سريعة
        </div>


        <ul class="sidebar-nav">


            <li>

                <a
                    href="{{ route('store.index') }}"
                    target="_blank"
                    class="sidebar-link">

                    <i class="bi bi-globe2"></i>

                    <span>
                        زيارة المتجر
                    </span>

                    <i
                        class="bi bi-box-arrow-up-left"
                        style="font-size:12px;width:auto;margin-right:auto">
                    </i>

                </a>

            </li>


        </ul>


    </div>


    {{-- Profile --}}

    <div class="sidebar-footer">

        <div class="admin-profile">


            <div class="profile-avatar">

                <i class="bi bi-person-fill"></i>

            </div>


            <div>

                <div class="profile-name">
                    المدير
                </div>

                <div class="profile-role">
                    مدير المتجر
                </div>

            </div>


        </div>


        <form
            action="{{ route('admin.logout') }}"
            method="POST"
            class="mt-2">

            @csrf

            <button
                type="submit"
                class="sidebar-link border-0 bg-transparent w-100 text-start">

                <i class="bi bi-box-arrow-right"></i>

                <span>
                    تسجيل الخروج
                </span>

            </button>

        </form>

    </div>


</aside>


{{-- Overlay --}}

<div
    id="sidebarOverlay"
    class="sidebar-overlay">
</div>


{{-- =========================================================
     MAIN
========================================================= --}}

<div class="admin-main">


    {{-- =====================================================
         TOPBAR
    ====================================================== --}}

    <header class="admin-topbar">


        <div class="topbar-left">


            <button
                id="mobileMenuButton"
                type="button"
                class="mobile-menu-btn">

                <i class="bi bi-list"></i>

            </button>


            <div>

                <h1 class="page-heading">

                    @yield(
                        'page-title',
                        'لوحة التحكم'
                    )

                </h1>

                <div class="page-breadcrumb">

                    الرئيسية

                    @hasSection('page-title')

                        <span class="mx-1">
                            /
                        </span>

                        @yield('page-title')

                    @endif

                </div>

            </div>


        </div>


        <div class="topbar-actions">


            {{-- Store --}}

            <a
                href="{{ route('store.index') }}"
                target="_blank"
                class="store-btn">

                <i class="bi bi-shop"></i>

                <span>
                    زيارة المتجر
                </span>

            </a>


            {{-- Notifications --}}

            <button
                type="button"
                class="topbar-btn"
                title="الإشعارات">

                <i class="bi bi-bell"></i>

            </button>


        </div>


    </header>


    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <main class="admin-content">


        {{-- Success --}}

        @if(session('success'))

            <div
                class="alert alert-success d-flex align-items-center gap-2 mb-4">

                <i class="bi bi-check-circle-fill"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- Error --}}

        @if(session('error'))

            <div
                class="alert alert-danger d-flex align-items-center gap-2 mb-4">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- Validation Errors --}}

        @if($errors->any())

            <div
                class="alert alert-danger mb-4">

                <div class="fw-bold mb-2">

                    <i class="bi bi-exclamation-circle me-1"></i>

                    يرجى تصحيح الأخطاء التالية:

                </div>


                <ul class="mb-0 pe-3">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        @yield('content')


    </main>


</div>


{{-- Bootstrap JS --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            const sidebar =
                document.getElementById(
                    'adminSidebar'
                );


            const overlay =
                document.getElementById(
                    'sidebarOverlay'
                );


            const menuButton =
                document.getElementById(
                    'mobileMenuButton'
                );


            function openSidebar() {

                sidebar.classList.add('show');

                overlay.classList.add('show');

                document.body.style.overflow =
                    'hidden';

            }


            function closeSidebar() {

                sidebar.classList.remove('show');

                overlay.classList.remove('show');

                document.body.style.overflow =
                    '';

            }


            if (menuButton) {

                menuButton.addEventListener(
                    'click',
                    openSidebar
                );

            }


            if (overlay) {

                overlay.addEventListener(
                    'click',
                    closeSidebar
                );

            }


            document
                .querySelectorAll(
                    '.sidebar-link'
                )
                .forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth <= 991
                            ) {

                                closeSidebar();

                            }

                        }
                    );

                });


            window.addEventListener(
                'resize',
                function () {

                    if (
                        window.innerWidth > 991
                    ) {

                        closeSidebar();

                    }

                }
            );


        }
    );

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const menuButton = document.querySelector('.mobile-menu-btn');

    if (!sidebar) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Sidebar
    |--------------------------------------------------------------------------
    */

    function openMobileSidebar() {
        sidebar.classList.add('show');

        if (overlay) {
            overlay.classList.add('show');
        }

        document.body.classList.add('sidebar-open');
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('show');

        if (overlay) {
            overlay.classList.remove('show');
        }

        document.body.classList.remove('sidebar-open');
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile Menu Button
    |--------------------------------------------------------------------------
    */

    if (menuButton) {
        menuButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (sidebar.classList.contains('show')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Overlay
    |--------------------------------------------------------------------------
    */

    if (overlay) {
        overlay.addEventListener('click', function () {
            closeMobileSidebar();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Close Mobile Sidebar When Clicking Link
    |--------------------------------------------------------------------------
    */

    const sidebarLinks = sidebar.querySelectorAll('a');

    sidebarLinks.forEach(function (link) {
        link.addEventListener('click', function () {

            if (window.innerWidth <= 991) {
                closeMobileSidebar();
            }

        });
    });


    /*
    |--------------------------------------------------------------------------
    | Desktop Hover Sidebar
    |--------------------------------------------------------------------------
    |
    | لا نستخدم click أو localStorage هنا.
    |
    | CSS هو المسؤول عن التمدد والانكماش:
    |
    | collapsed -> default
    | expanded  -> mouse hover
    |
    */

    function handleResponsiveSidebar() {

        if (window.innerWidth > 991) {

            // التأكد من إزالة حالة الموبايل
            sidebar.classList.remove('show');

            if (overlay) {
                overlay.classList.remove('show');
            }

            document.body.classList.remove('sidebar-open');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Resize
    |--------------------------------------------------------------------------
    */

    window.addEventListener('resize', handleResponsiveSidebar);

    handleResponsiveSidebar();


    /*
    |--------------------------------------------------------------------------
    | Prevent Body Scroll On Mobile
    |--------------------------------------------------------------------------
    */

    const observer = new MutationObserver(function () {

        if (
            window.innerWidth <= 991 &&
            sidebar.classList.contains('show')
        ) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }

    });

    observer.observe(sidebar, {
        attributes: true,
        attributeFilter: ['class']
    });


    /*
    |--------------------------------------------------------------------------
    | Escape Key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            sidebar.classList.contains('show')
        ) {
            closeMobileSidebar();
        }

    });

});
</script>


@stack('scripts')

</body>

</html>
