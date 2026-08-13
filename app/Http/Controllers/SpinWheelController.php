<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\SpinAttempt;
use App\Models\SpinPrize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpinWheelController extends Controller
{
    public function spin(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent multiple spins in the same session
        |--------------------------------------------------------------------------
        */

        if ($request->session()->has('spin_wheel_used')) {
            return response()->json([
                'success' => false,
                'message' => 'لقد استخدمت فرصة الدوران بالفعل.',
            ], 429);
        }

        /*
        |--------------------------------------------------------------------------
        | Get active prizes
        |--------------------------------------------------------------------------
        */

        $prizes = SpinPrize::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($prizes->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد عروض متاحة حاليًا.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Validate probabilities
        |--------------------------------------------------------------------------
        */

        $totalProbability = $prizes->sum(
            fn ($prize) => (float) $prize->probability
        );

        if ($totalProbability <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'إعدادات العجلة غير صحيحة.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Secure random selection
        |--------------------------------------------------------------------------
        */

        $random = random_int(
            1,
            (int) round($totalProbability * 100)
        ) / 100;

        $current = 0;
        $selectedPrize = null;

        foreach ($prizes as $prize) {
            $current += (float) $prize->probability;

            if ($random <= $current) {
                $selectedPrize = $prize;
                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        if (!$selectedPrize) {
            $selectedPrize = $prizes->last();
        }

        /*
        |--------------------------------------------------------------------------
        | Visitor token
        |--------------------------------------------------------------------------
        */

        $visitorToken = $request->session()->get(
            'spin_visitor_token'
        );

        if (!$visitorToken) {
            $visitorToken = Str::random(64);

            $request->session()->put(
                'spin_visitor_token',
                $visitorToken
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create attempt + coupon
        |--------------------------------------------------------------------------
        */

        $result = DB::transaction(function () use (
            $selectedPrize,
            $visitorToken
        ) {
            $couponCode = null;
            $coupon = null;

            /*
            |--------------------------------------------------------------------------
            | Generate coupon for discount / free shipping
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $selectedPrize->type,
                    ['discount', 'free_shipping'],
                    true
                )
            ) {
                do {
                    $couponCode = 'ORC-' .
                        strtoupper(Str::random(8));
                } while (
                    Coupon::where('code', $couponCode)->exists()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Create spin attempt
            |--------------------------------------------------------------------------
            */

            $attempt = SpinAttempt::create([
                'spin_prize_id' => $selectedPrize->id,
                'visitor_token' => $visitorToken,
                'coupon_code' => $couponCode,
                'is_used' => false,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create coupon
            |--------------------------------------------------------------------------
            */

            if ($couponCode) {
                $coupon = Coupon::create([
                    'code' => $couponCode,

                    'type' => $selectedPrize->type,

                    'discount_percent' =>
                        $selectedPrize->type === 'discount'
                            ? $selectedPrize->discount_percent
                            : null,

                    'spin_attempt_id' => $attempt->id,

                    'is_used' => false,

                    'order_id' => null,

                    'used_at' => null,

                    // صلاحية 7 أيام
                    'expires_at' => now()->addDays(7),
                ]);
            }

            return [
                'attempt' => $attempt,
                'coupon' => $coupon,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Mark session as used
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'spin_wheel_used',
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Store coupon in session
        |--------------------------------------------------------------------------
        */

        if ($result['coupon']) {
            $request->session()->put(
                'spin_coupon_code',
                $result['coupon']->code
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Return result
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'prize' => [
                'id' => $selectedPrize->id,
                'name' => $selectedPrize->name,
                'type' => $selectedPrize->type,
                'discount_percent' =>
                    $selectedPrize->discount_percent,
            ],

            'coupon_code' =>
                $result['coupon']?->code,

            'attempt_id' =>
                $result['attempt']->id,
        ]);
    }
}
