<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Notifications\StoreWelcomeNotification;
use App\Http\Controllers\CartController;

class StoreAuthController extends Controller
{


    public function showForgotPassword()
    {
        return view('store.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.'
            );
        }

        return back()
            ->withErrors([
                'email' => 'لم نتمكن من العثور على حساب بهذا البريد الإلكتروني.',
            ])
            ->withInput();
    }

    public function showResetPassword(
    string $token,
    Request $request
    ) {
        return view('store.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => [
                'required',
            ],

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',

            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',

            'password.required' => 'يرجى إدخال كلمة المرور الجديدة.',

            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('store.login')
                ->with(
                    'status',
                    'تم تغيير كلمة المرور بنجاح. يمكنك تسجيل الدخول الآن.'
                );
        }

        return back()->withErrors([
            'email' => 'رابط إعادة تعيين كلمة المرور غير صالح أو منتهي الصلاحية.',
        ]);
    }
    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('store.account');
        }

        return view('store.auth.register');
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],

            'marketing_consent' => [
                'nullable',
                'boolean',
            ],
        ], [
            'name.required' => 'يرجى إدخال الاسم.',

            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',

            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);


        $marketingConsent =
            $request->boolean('marketing_consent');


        $user = User::create([
            'name' => $validated['name'],

            'email' => $validated['email'],

            'phone' => $validated['phone'] ?? null,

            'password' => $validated['password'],

            'marketing_consent' => $marketingConsent,

            'marketing_consent_at' =>
                $marketingConsent
                    ? now()
                    : null,
        ]);


        Auth::login($user);

        $request->session()->regenerate();

        CartController::mergeSessionCart();

        $user->notify(new StoreWelcomeNotification());

        return redirect()
            ->intended(route('store.account'))
            ->with(
                'success',
                'تم إنشاء حسابك بنجاح.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('store.account');
        }

        return view('store.auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' =>
                'يرجى إدخال البريد الإلكتروني.',

            'email.email' =>
                'يرجى إدخال بريد إلكتروني صحيح.',

            'password.required' =>
                'يرجى إدخال كلمة المرور.',
        ]);


        $remember =
            $request->boolean('remember');


        if (
            ! Auth::attempt(
                [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ],
                $remember
            )
        ) {

            return back()
                ->withErrors([
                    'email' =>
                        'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ])
                ->onlyInput('email');
        }


        $request->session()->regenerate();

        CartController::mergeSessionCart();

        return redirect()
            ->intended(route('store.account'))
            ->with(
                'success',
                'تم تسجيل الدخول بنجاح.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('store.index')
            ->with(
                'success',
                'تم تسجيل الخروج بنجاح.'
            );
    }
}
