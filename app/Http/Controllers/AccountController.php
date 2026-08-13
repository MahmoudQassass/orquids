<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = $user->orders()
            ->latest()
            ->paginate(10);

        return view(
            'store.account.index',
            compact('user', 'orders')
        );
    }


    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],
        ]);


        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
        ]);


        return back()->with(
            'success',
            'تم تحديث بيانات الحساب.'
        );
    }


    public function updateMarketingConsent(Request $request)
    {
        $user = $request->user();

        $consent =
            $request->boolean('marketing_consent');


        $user->update([
            'marketing_consent' => $consent,

            'marketing_consent_at' =>
                $consent
                    ? now()
                    : null,
        ]);


        return back()->with(
            'success',
            $consent
                ? 'تم تفعيل استقبال العروض والتحديثات.'
                : 'تم إيقاف استقبال العروض والتحديثات.'
        );
    }
}
