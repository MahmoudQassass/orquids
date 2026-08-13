<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayTabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            $callbackUrl = route(
                'payment.callback'
            );


            /*
            |--------------------------------------------------------------------------
            | Create PayTabs Payment
            |--------------------------------------------------------------------------
            */

            $payment = $payTabs->createPayment(

                cartId: 'ORDER-' . $order->id,

                amount: (float) $order->total,

                customer: [

                    'name' =>
                        $order->customer_name,

                    'email' =>
                        $order->email
                        ?: 'customer@example.com',

                    'phone' =>
                        $order->phone,

                    'address' =>
                        $order->address ?? '',

                    'city' =>
                        $order->city ?? '',

                    'state' =>
                        '',

                    'country' =>
                        $order->country ?? '',

                    'zip' =>
                        $order->zip ?? '',
                ],

                returnUrl: $returnUrl,

                callbackUrl: $callbackUrl
            );


            /*
            |--------------------------------------------------------------------------
            | Save Transaction Reference
            |--------------------------------------------------------------------------
            */

            if (!empty($payment['tran_ref'])) {

                $order->update([
                    'payment_reference' =>
                        $payment['tran_ref'],
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Redirect to PayTabs
            |--------------------------------------------------------------------------
            */

            if (empty($payment['redirect_url'])) {

                throw new \RuntimeException(
                    'PayTabs did not return redirect_url.'
                );
            }


            return redirect()->away(
                $payment['redirect_url']
            );


        } catch (\Throwable $e) {

            Log::error(
                'PayTabs payment creation failed.',
                [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]
            );


            return redirect()
                ->route(
                    'payment.result',
                    $order
                )
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

        $cartId =
            $payload['cart_id'] ?? null;


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

        $orderId =
            str_replace(
                'ORDER-',
                '',
                $cartId
            );


        $order =
            Order::find($orderId);


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
        | Update Order
        |--------------------------------------------------------------------------
        */

        if ($responseStatus === 'A') {

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

            $order->update([

                'payment_status' =>
                    'failed',

                'status' =>  'cancelled',

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


        return response()->json([
            'status' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Result
    |--------------------------------------------------------------------------
    */

    public function result(
        Request $request,
        string $token
    ) {

        $order = Order::where(
                'payment_token',
                $token
            )->firstOrFail();
        return view(
            'store.payment-result',
            compact('order')
        );
    }
}
