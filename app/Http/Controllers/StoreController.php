<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Country;

class StoreController extends Controller
{
    /**
     * ============================================================
     * الصفحة الرئيسية للمتجر
     * ============================================================
     */
    public function index(Request $request)
    {
        $categories = Category::where('status', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->orderBy('name')
            ->get();

        $productsQuery = Product::with([
            'images',
            'category',
        ])
            ->where('status', true)
            ->latest();

        if ($request->filled('category')) {
            $productsQuery->whereHas(
                'category',
                function ($query) use ($request) {
                    $query->where(
                        'slug',
                        $request->category
                    );
                }
            );
        }

        $products = $productsQuery->get();

        return view(
            'store.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /**
     * ============================================================
     * صفحة تفاصيل المنتج
     * ============================================================
     */
    public function showProduct(string $slug)
    {
        $product = Product::with('images')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view(
            'store.products.show',
            compact('product')
        );
    }


    /**
     * ============================================================
     * شراء مباشر
     * ============================================================
     */
    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $product = Product::where(
                'id',
                $validated['product_id']
            )
            ->where('status', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | استبدال السلة بالمنتج المطلوب
        |--------------------------------------------------------------------------
        */

        session()->put('cart', [
            $product->id => $validated['quantity'],
        ]);

        return redirect()
            ->route('store.checkout');
    }


    /**
     * ============================================================
     * صفحة Checkout
     * ============================================================
     */
    public function showCheckout()
    {
        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        if (empty($cart)) {

            session()->forget('checkout_coupon_code');

            return redirect()
                ->route('store.index')
                ->with(
                    'error',
                    'سلة التسوق فارغة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = Product::with('images')
            ->whereIn(
                'id',
                array_keys($cart)
            )
            ->where('status', true)
            ->get();


        if ($products->isEmpty()) {

            session()->forget('cart');
            session()->forget('checkout_coupon_code');

            return redirect()
                ->route('store.index')
                ->with(
                    'error',
                    'لا توجد منتجات متاحة في السلة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Build Cart Items
        |--------------------------------------------------------------------------
        */

        $items = [];

        $subtotal = 0;

        $cartCount = 0;


        foreach ($products as $product) {

            $quantity = (int) (
                $cart[$product->id] ?? 0
            );


            if ($quantity <= 0) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Product Price
            |--------------------------------------------------------------------------
            */

            $price = $product->discount_price
                ?? $product->price;


            $price = (float) $price;


            /*
            |--------------------------------------------------------------------------
            | Item Subtotal
            |--------------------------------------------------------------------------
            */

            $itemSubtotal = round(
                $price * $quantity,
                2
            );


            $subtotal += $itemSubtotal;

            $cartCount += $quantity;


            $items[] = [

                'product' => $product,

                'quantity' => $quantity,

                'price' => $price,

                'subtotal' => $itemSubtotal,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Empty Cart Protection
        |--------------------------------------------------------------------------
        */

        if (empty($items) || $subtotal <= 0) {

            session()->forget('cart');
            session()->forget('checkout_coupon_code');

            return redirect()
                ->route('store.index')
                ->with(
                    'error',
                    'سلة التسوق فارغة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Coupon
        |--------------------------------------------------------------------------
        */

        $coupon = null;

        $discount = 0;

        $total = $subtotal;

        $couponCode = session()->get(
            'checkout_coupon_code'
        );


        /*
        |--------------------------------------------------------------------------
        | Apply Coupon
        |--------------------------------------------------------------------------
        */

        if ($couponCode) {

            $coupon = Coupon::query()
                ->where(
                    'code',
                    strtoupper(trim($couponCode))
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Coupon Validation
            |--------------------------------------------------------------------------
            */

            if (
                !$coupon ||
                $coupon->is_used ||
                (
                    $coupon->expires_at &&
                    $coupon->expires_at->isPast()
                )
            ) {

                session()->forget(
                    'checkout_coupon_code'
                );

                $coupon = null;
            }


            /*
            |--------------------------------------------------------------------------
            | Spin Wheel Coupon
            |--------------------------------------------------------------------------
            */

            if ($coupon && $coupon->spin_attempt_id) {

                $visitorToken = session()->get(
                    'spin_visitor_token'
                );

                $attempt = $coupon->spinAttempt;


                if (
                    !$attempt ||
                    !$visitorToken ||
                    !hash_equals(
                        (string) $attempt->visitor_token,
                        (string) $visitorToken
                    )
                ) {

                    session()->forget(
                        'checkout_coupon_code'
                    );

                    $coupon = null;
                }


                /*
                |--------------------------------------------------------------------------
                | Spin Attempt Already Used
                |--------------------------------------------------------------------------
                */

                if (
                    $coupon &&
                    $attempt &&
                    $attempt->is_used
                ) {

                    session()->forget(
                        'checkout_coupon_code'
                    );

                    $coupon = null;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Discount
            |--------------------------------------------------------------------------
            */

            if ($coupon) {

                $discountPercent = (float) (
                    $coupon->discount_percent ?? 0
                );


                /*
                |--------------------------------------------------------------------------
                | Same protection used by checkout / PayTabs
                |--------------------------------------------------------------------------
                */

                $discountPercent = max(
                    0,
                    min(
                        100,
                        $discountPercent
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | الخصم يحسب من subtotal الحالي
                | وليس من قيمة قديمة محفوظة.
                |
                */

                $discount = round(
                    $subtotal *
                    ($discountPercent / 100),
                    2
                );


                /*
                |--------------------------------------------------------------------------
                | Total
                |--------------------------------------------------------------------------
                */

                $total = max(
                    0,
                    $subtotal - $discount
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency = config(
            'services.paytabs.currency',
            'EGP'
        );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $countries = Country::where('active', true)
            ->orderBy('name')
            ->get();

        return view(
            'store.checkout',
            compact(
                'items',
                'subtotal',
                'cartCount',
                'coupon',
                'discount',
                'total',
                'currency',
                'countries'
            )
        );
    }

    /**
     * ============================================================
     * تطبيق Coupon
     * ============================================================
     */
    public function applyCoupon(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'coupon_code' => [
                'required',
                'string',
                'max:100',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Coupon Code
        |--------------------------------------------------------------------------
        */

        $code = strtoupper(
            trim($request->coupon_code)
        );


        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);


        if (empty($cart)) {

            return back()
                ->with(
                    'coupon_error',
                    'سلة التسوق فارغة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->whereIn(
                'id',
                array_keys($cart)
            )
            ->where('status', true)
            ->get();


        if ($products->isEmpty()) {

            return back()
                ->with(
                    'coupon_error',
                    'لا توجد منتجات متاحة في السلة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Subtotal
        |--------------------------------------------------------------------------
        | نفس منطق checkout() و showCheckout()
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;


        foreach ($products as $product) {

            $quantity = (int) (
                $cart[$product->id] ?? 0
            );


            if ($quantity <= 0) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | نفس السعر المستخدم في PayTabs
            |--------------------------------------------------------------------------
            */

            $price = $product->discount_price
                ?? $product->price;


            $subtotal +=
                $price * $quantity;
        }


        if ($subtotal <= 0) {

            return back()
                ->with(
                    'coupon_error',
                    'قيمة السلة غير صالحة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Find Coupon
        |--------------------------------------------------------------------------
        */

        $coupon = Coupon::query()
            ->where(
                'code',
                $code
            )
            ->first();


        if (!$coupon) {

            return back()
                ->withInput()
                ->with(
                    'coupon_error',
                    'كود الخصم غير صحيح.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Already Used
        |--------------------------------------------------------------------------
        */

        if ($coupon->is_used) {

            return back()
                ->withInput()
                ->with(
                    'coupon_error',
                    'هذا الكوبون مستخدم بالفعل.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Expiration
        |--------------------------------------------------------------------------
        */

        if (
            $coupon->expires_at &&
            $coupon->expires_at->isPast()
        ) {

            return back()
                ->withInput()
                ->with(
                    'coupon_error',
                    'انتهت صلاحية هذا الكوبون.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Discount Percent
        |--------------------------------------------------------------------------
        */

        $discountPercent = (float) (
            $coupon->discount_percent ?? 0
        );


        if (
            $discountPercent <= 0 ||
            $discountPercent > 100
        ) {

            return back()
                ->withInput()
                ->with(
                    'coupon_error',
                    'قيمة كود الخصم غير صالحة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Spin Wheel Coupon
        |--------------------------------------------------------------------------
        */

        if ($coupon->spin_attempt_id) {

            $visitorToken = $request->session()->get(
                'spin_visitor_token'
            );


            $attempt = $coupon->spinAttempt;


            if (
                !$attempt ||
                !$visitorToken ||
                !hash_equals(
                    (string) $attempt->visitor_token,
                    (string) $visitorToken
                )
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'coupon_error',
                        'لا يمكنك استخدام هذا الكوبون.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Spin Attempt Already Used
            |--------------------------------------------------------------------------
            */

            if ($attempt->is_used) {

                return back()
                    ->withInput()
                    ->with(
                        'coupon_error',
                        'تم استخدام هذه الجائزة بالفعل.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Discount
        |--------------------------------------------------------------------------
        */

        $discount = round(
            $subtotal *
            ($discountPercent / 100),
            2
        );


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $total = max(
            0,
            $subtotal - $discount
        );


        /*
        |--------------------------------------------------------------------------
        | Store Coupon
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'checkout_coupon_code',
            $coupon->code
        );


        /*
        |--------------------------------------------------------------------------
        | Store Discount Data
        |--------------------------------------------------------------------------
        |
        | اختياري، لكنه مفيد للعرض مباشرة في الصفحة.
        |
        */

        $request->session()->put(
            'checkout_coupon_discount',
            $discount
        );

        $request->session()->put(
            'checkout_coupon_total',
            $total
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'coupon_success',
                'تم تطبيق كود الخصم بنجاح.'
            );
    }

    /**
     * ============================================================
     * إزالة Coupon
     * ============================================================
     */
    public function removeCoupon(Request $request)
    {
        $request->session()->forget(
            'checkout_coupon_code'
        );

        return back()->with(
            'coupon_success',
            'تمت إزالة كود الخصم.'
        );
    }


    /**
     * ============================================================
     * إنشاء الطلب
     * ============================================================
     */
    public function checkout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'country' => [
                'required',
                'exists:countries,id',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'zip' => [
                'required',
                'string',
                'max:100',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        $cart = session()->get(
            'cart',
            []
        );


        if (empty($cart)) {

            return redirect()
                ->route('store.index')
                ->with(
                    'error',
                    'سلة التسوق فارغة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = Product::whereIn('id', array_keys($cart))
            ->where('status', true)
            ->with('countries:id')
            ->get();

        $unavailableProducts = [];

        foreach ($products as $product) {

            $available = $product->countries
                ->contains('id', $request->country);

            if (!$available) {
                $unavailableProducts[] = $product->name;
            }
        }

        if (!empty($unavailableProducts)) {

            return back()
                ->withInput()
                ->withErrors([
                    'country' =>
                        'عذرًا، المنتجات التالية غير متوفرة للشحن إلى الدولة المختارة: '
                        . implode('، ', $unavailableProducts),
                ]);
        }


        if ($products->isEmpty()) {

            session()->forget('cart');

            return redirect()
                ->route('store.index')
                ->with(
                    'error',
                    'المنتجات الموجودة في السلة غير متوفرة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Coupon
        |--------------------------------------------------------------------------
        */

        $coupon = null;

        $discount = 0;

        $couponCode = session()->get(
            'checkout_coupon_code'
        );


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use (
            $products,
            $cart,
            $validated,
            $couponCode,
            &$coupon,
            &$discount
        ) {

            /*
            |--------------------------------------------------------------------------
            | حساب Subtotal
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;

            $totalQuantity = 0;


            foreach ($products as $product) {

                $quantity = (int) (
                    $cart[$product->id] ?? 0
                );

                if ($quantity <= 0) {
                    continue;
                }

                $price = $product->discount_price
                    ?? $product->price;

                $subtotal +=
                    $price * $quantity;

                $totalQuantity += $quantity;
            }


            if ($subtotal <= 0) {

                throw new \RuntimeException(
                    'قيمة السلة غير صالحة.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | الحصول على Coupon داخل Transaction
            |--------------------------------------------------------------------------
            */

            if ($couponCode) {

                $coupon = Coupon::query()
                    ->where(
                        'code',
                        strtoupper(trim($couponCode))
                    )
                    ->lockForUpdate()
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | التأكد من صلاحية الكوبون
                |--------------------------------------------------------------------------
                */

                if (
                    !$coupon ||
                    $coupon->is_used ||
                    (
                        $coupon->expires_at &&
                        $coupon->expires_at->isPast()
                    )
                ) {

                    throw new \RuntimeException(
                        'كود الخصم غير صالح أو مستخدم بالفعل.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | التحقق من Spin Wheel Coupon
                |--------------------------------------------------------------------------
                */

                if ($coupon->spin_attempt_id) {

                    $visitorToken = session()->get(
                        'spin_visitor_token'
                    );

                    $attempt = $coupon->spinAttempt;


                    if (
                        !$attempt ||
                        !$visitorToken ||
                        !hash_equals(
                            (string) $attempt->visitor_token,
                            (string) $visitorToken
                        )
                    ) {

                        throw new \RuntimeException(
                            'لا يمكنك استخدام هذا الكوبون.'
                        );
                    }


                    if ($attempt->is_used) {

                        throw new \RuntimeException(
                            'تم استخدام هذه الجائزة بالفعل.'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | حساب نسبة الخصم
                |--------------------------------------------------------------------------
                */

                $discountPercent = (float) (
                    $coupon->discount_percent ?? 0
                );


                $discountPercent = max(
                    0,
                    min(100, $discountPercent)
                );


                $discount = round(
                    $subtotal *
                    ($discountPercent / 100),
                    2
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Total
            |--------------------------------------------------------------------------
            */

            $total = max(
                0,
                $subtotal - $discount
            );


            /*
            |--------------------------------------------------------------------------
            | إنشاء Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([

                /*
                |--------------------------------------------------------------------------
                | Token بدلاً من ID في الروابط العامة
                |--------------------------------------------------------------------------
                */

                'user_id' => auth()->id(),

                'payment_token' =>
                    Str::random(64),

                'customer_name' =>
                    $validated['customer_name'],

                'phone' =>
                    $validated['phone'],

                'email' =>
                    $validated['email'] ?? null,

                'country' =>
                    $validated['country'],

                'city' =>
                    $validated['city'],

                'zip' =>
                    $validated['zip'],

                'address' =>
                    $validated['address'],

                'quantity' =>
                    $totalQuantity,

                'subtotal' =>
                    $subtotal,

                'total' =>
                    $total,

                'payment_status' =>
                    'pending',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Order Items
            |--------------------------------------------------------------------------
            */

            foreach ($products as $product) {

                $quantity = (int) (
                    $cart[$product->id] ?? 0
                );


                if ($quantity <= 0) {
                    continue;
                }


                $price = $product->discount_price
                    ?? $product->price;


                $itemSubtotal =
                    $price * $quantity;


                $order->items()->create([

                    'product_id' =>
                        $product->id,

                    'product_name' =>
                        $product->name,

                    'price' =>
                        $price,

                    'quantity' =>
                        $quantity,

                    'subtotal' =>
                        $itemSubtotal,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | ربط الكوبون بالطلب إن كان جدول orders
            | يحتوي على coupon_id
            |--------------------------------------------------------------------------
            |
            | إذا كان عندك coupon_id في orders يمكنك تفعيل هذا:
            |
            | $order->update([
            |     'coupon_id' => $coupon->id,
            | ]);
            |
            */


            /*
            |--------------------------------------------------------------------------
            | Mark Coupon Used
            |--------------------------------------------------------------------------
            |
            | لا نعتبر الكوبون مستخدماً بمجرد الضغط على
            | "تطبيق الكوبون".
            |
            | يصبح مستخدماً عند إنشاء الطلب.
            |--------------------------------------------------------------------------
            */

            if ($coupon) {

                $coupon->update([
                    'is_used'  => true,
                    'order_id' => $order->id,
                    'used_at'  => now(),
                ]);


                /*
                |--------------------------------------------------------------------------
                | تحديث Spin Attempt
                |--------------------------------------------------------------------------
                */

                if ($coupon->spin_attempt_id) {

                    $attempt = $coupon->spinAttempt;

                    if ($attempt) {

                        $attempt->update([
                            'is_used' => true,
                            'used_at' => now(),
                        ]);
                    }
                }
            }


            return $order;
        });


        /*
        |--------------------------------------------------------------------------
        | حذف Coupon من Session
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'checkout_coupon_code'
        );


        /*
        |--------------------------------------------------------------------------
        | يمكن لاحقاً حذف Cart بعد نجاح الدفع
        |--------------------------------------------------------------------------
        |
        | حالياً لا نحذفه هنا لأن PayTabs لم يؤكد الدفع بعد.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | PayTabs
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'payment.pay',
                $order
            )
            ->with(
                'success',
                'تم إنشاء الطلب بنجاح.'
            );
    }


    /**
     * ============================================================
     * صفحة نتيجة الدفع
     * ============================================================
     */
    public function paymentResult(
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


    /**
     * ============================================================
     * صفحة نجاح الدفع
     * ============================================================
     */
    public function success(Request $request)
    {
        return view(
            'store.payment-success'
        );
    }


    /**
     * ============================================================
     * إلغاء الدفع
     * ============================================================
     */
    public function cancel(Request $request)
    {
        return view(
            'store.payment-cancel'
        );
    }

    public function checkAvailability(
        Request $request,
        Country $country
    ) {
        $validated = $request->validate([
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['integer', 'exists:products,id'],
        ]);

        $productIds = $validated['product_ids'];

        $products = Product::whereIn('id', $productIds)
            ->with('countries:id')
            ->get();

        $unavailableProducts = [];

        foreach ($products as $product) {

            $available = $product->countries
                ->contains('id', $country->id);

            if (!$available) {

                $unavailableProducts[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                ];
            }
        }

        return response()->json([
            'available' => empty($unavailableProducts),
            'unavailable_products' => $unavailableProducts,
        ]);
    }
}
