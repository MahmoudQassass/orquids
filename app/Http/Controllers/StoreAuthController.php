<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StoreAuthController extends Controller
{
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
                Password::min(8),
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
