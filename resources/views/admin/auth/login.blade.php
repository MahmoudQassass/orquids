<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>
        تسجيل دخول الإدارة
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet">

    <style>

        body {
            min-height: 100vh;
            background: #f5f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: 0;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .08);
        }

        .login-title {
            font-weight: 700;
        }

        .login-button {
            width: 100%;
            padding: 13px;
            font-weight: 700;
        }

    </style>

</head>

<body>

<div class="container px-3">

    <div class="card login-card mx-auto">

        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">

                <h2 class="login-title">
                    لوحة الإدارة
                </h2>

                <p class="text-muted mb-0">
                    تسجيل الدخول إلى حساب المدير
                </p>

            </div>


            {{-- Success --}}

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Error --}}

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif


            {{-- Validation Errors --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.login.submit') }}">

                @csrf


                <div class="mb-3">

                    <label class="form-label">
                        البريد الإلكتروني
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        كلمة المرور
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg"
                        autocomplete="current-password"
                        required>

                </div>


                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        value="1"
                        id="remember">

                    <label
                        class="form-check-label"
                        for="remember">

                        تذكرني

                    </label>

                </div>


                <button
                    type="submit"
                    class="btn btn-dark login-button">

                    تسجيل الدخول

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>
