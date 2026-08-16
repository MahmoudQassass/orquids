<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\PayTabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CartItem;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Start Payment
    |--------------------------------------------------------------------------
    */

    public function pay(
        Order $order,
        PayTabsService $payTabs
    ) {
        /*
        |--------------------------------------------------------------------------
        | Prevent paying an already paid order
        |--------------------------------------------------------------------------
        */

        if ($order->payment_status === 'paid') {

            return redirect()->route(
                'payment.result',
                ['token' => $order->payment_token]
            );
        }


        try {

            $returnUrl = route(
                'payment.result',
                ['token' => $order->payment_token]
            );

            // $callbackUrl = route(
            //     'payment.callback'
            // );


            /*
            |--------------------------------------------------------------------------
            | Create PayTabs Payment
            |--------------------------------------------------------------------------
            */

            // $payment = $payTabs->createPayment(

            //     cartId: 'ORDER-' . $order->id,

            //     amount: (float) $order->total,

            //     customer: [

            //         'name' =>
            //             $order->customer_name,

            //         'email' =>
            //             $order->email
            //             ?: 'customer@example.com',

            //         'phone' =>
            //             $order->phone,

            //         'address' =>
            //             $order->address ?? '',

            //         'city' =>
            //             $order->city ?? '',

            //         'state' =>
            //             '',

            //         'country' =>
            //             $order->country ?? '',

            //         'zip' =>
            //             $order->zip ?? '',
            //     ],

            //     returnUrl: $returnUrl,

            //     callbackUrl: $callbackUrl
            // );


            /*
            |--------------------------------------------------------------------------
            | Save Transaction Reference
            |--------------------------------------------------------------------------
            */

            // if (!empty($payment['tran_ref'])) {

            //     $order->update([
            //         'payment_reference' =>
            //             $payment['tran_ref'],
            //     ]);
            // }


            // /*
            // |--------------------------------------------------------------------------
            // | Redirect to PayTabs
            // |--------------------------------------------------------------------------
            // */

            // if (empty($payment['redirect_url'])) {

            //     throw new \RuntimeException(
            //         'PayTabs did not return redirect_url.'
            //     );
            // }


            // return redirect()->away(
            //     $payment['redirect_url']
            // );

            return redirect()->route('test.payment',$order);

        } catch (\Throwable $e) {

            Log::error(
                'PayTabs payment creation failed.',
                [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]
            );



            // return redirect()
            //     ->route(
            //         'payment.result',
            //         $order
            //     )
            //     ->with(
            //         'error',
            //         'حدث خطأ أثناء إنشاء عملية الدفع. يرجى المحاولة مرة أخرى.'
            //     );
                 return redirect()
                ->route(
                    'test.payment.processing',)
                ->with(
                    'error',
                    'حدث خطأ أثناء إنشاء عملية الدفع. يرجى المحاولة مرة أخرى.'
                );
        }


    }


    /*
    |--------------------------------------------------------------------------
    | PayTabs Callback
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| PayTabs Callback
|--------------------------------------------------------------------------
*/

    public function callback(Request $request)
    {
        $payload = $request->all();


        Log::info(
            'PayTabs callback received.',
            [
                'payload' => $payload,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Get Order
        |--------------------------------------------------------------------------
        */

        $cartId = $payload['cart_id'] ?? null;


        if (!$cartId) {

            return response()->json([
                'status' => false,
                'message' => 'Missing cart_id',
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER-21 -> 21
        |--------------------------------------------------------------------------
        */

        $orderId = str_replace(
            'ORDER-',
            '',
            $cartId
        );


        $order = Order::find($orderId);


        if (!$order) {

            Log::warning(
                'PayTabs callback order not found.',
                [
                    'cart_id' => $cartId,
                ]
            );


            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Result
        |--------------------------------------------------------------------------
        */

        $responseStatus =
            $payload['payment_result']['response_status']
            ?? null;


        $tranRef =
            $payload['tran_ref']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Payment Status
        |--------------------------------------------------------------------------
        */

        if ($responseStatus === 'A') {

            /*
            |--------------------------------------------------------------------------
            | Payment Successful
            |--------------------------------------------------------------------------
            */

            $order->update([

                'payment_status' =>
                    'paid',

                'payment_reference' =>
                    $tranRef,
            ]);


            Log::info(
                'Order payment status updated.',
                [
                    'order_id' =>
                        $order->id,

                    'tran_ref' =>
                        $tranRef,

                    'status' =>
                        'paid',
                ]
            );

        } else {

            /*
            |--------------------------------------------------------------------------
            | Payment Failed
            |--------------------------------------------------------------------------
            */

            $order->update([

                'payment_status' =>
                    'failed',

                'status' =>
                    'cancelled',

                'payment_reference' =>
                    $tranRef,
            ]);


            Log::info(
                'Order payment status updated.',
                [
                    'order_id' =>
                        $order->id,

                    'tran_ref' =>
                        $tranRef,

                    'status' =>
                        'failed',
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Clear Cart
        |--------------------------------------------------------------------------
        |
        | سواء كانت العملية:
        |
        | paid
        | failed
        |
        | يتم تفريغ السلة.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | Clear Session Cart
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');


        /*
        |--------------------------------------------------------------------------
        | Clear Coupon
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'checkout_coupon_code'
        );


        /*
        |--------------------------------------------------------------------------
        | Clear Spin Visitor Token
        |--------------------------------------------------------------------------
        |
        | إذا كان الـ spin coupon مرتبطًا بالمحاولة الحالية.
        | يمكن إبقاؤه إذا كنت تستخدمه لأغراض أخرى.
        |
        */

        // session()->forget('spin_visitor_token');


        /*
        |--------------------------------------------------------------------------
        | Clear Database Cart
        |--------------------------------------------------------------------------
        */

        if ($order->user_id) {

            CartItem::where(
                'user_id',
                $order->user_id
            )->delete();


            Log::info(
                'Database cart cleared.',
                [
                    'user_id' =>
                        $order->user_id,

                    'order_id' =>
                        $order->id,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Log Session Cart Clear
        |--------------------------------------------------------------------------
        */

        Log::info(
            'Session cart cleared.',
            [
                'order_id' =>
                    $order->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Result
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Payment Result
    |--------------------------------------------------------------------------
    */

    public function result(
        Request $request,
        string $token
    ) {
        /*
        |--------------------------------------------------------------------------
        | Find Order
        |--------------------------------------------------------------------------
        */

        $order = Order::where(
            'payment_token',
            $token
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Restore Authenticated User
        |--------------------------------------------------------------------------
        |
        | إذا كان الطلب تم إنشاؤه بواسطة مستخدم مسجل الدخول،
        | نحافظ على تسجيل دخوله عند العودة من PayTabs.
        |
        */

        if (
            $order->user_id &&
            !auth()->check()
        ) {

            $user = User::find(
                $order->user_id
            );


            if ($user) {

                auth()->login(
                    $user,
                    true
                );


                /*
                |--------------------------------------------------------------------------
                | Regenerate Session
                |--------------------------------------------------------------------------
                |
                | نحافظ على Session جديدة وآمنة بعد تسجيل الدخول.
                |
                */

                $request->session()->regenerate();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'store.payment-result',
            compact('order')
        );
    }

}
