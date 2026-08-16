<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * عرض السلة
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | المستخدم المسجل
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            $cartItems = Auth::user()
                ->cartItems()
                ->with([
                    'product' => function ($query) {
                        $query->with('images')
                            ->where('status', true);
                    },
                ])
                ->get();

            $items = [];

            $subtotal = 0;

            $cartCount = 0;

            foreach ($cartItems as $cartItem) {

                $product = $cartItem->product;

                /*
                |--------------------------------------------------------------------------
                | إذا أصبح المنتج غير متوفر
                |--------------------------------------------------------------------------
                */

                if (!$product) {

                    $cartItem->delete();

                    continue;
                }

                $quantity = (int) $cartItem->quantity;

                if ($quantity <= 0) {
                    continue;
                }

                $price = $product->discount_price
                    ?? $product->price;

                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

                $cartCount += $quantity;

                $image = $product->images->first()->url;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                    'image' => $image,
                ];
            }

            return view('store.cart', compact(
                'items',
                'subtotal',
                'cartCount'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | الزائر
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        $products = Product::with('images')
            ->whereIn('id', array_keys($cart))
            ->where('status', true)
            ->get();

        $items = [];

        $subtotal = 0;

        $cartCount = 0;

        foreach ($products as $product) {

            $quantity = (int) ($cart[$product->id] ?? 0);

            if ($quantity <= 0) {
                continue;
            }

            $price = $product->discount_price
                ?? $product->price;

            $itemSubtotal = $price * $quantity;

            $subtotal += $itemSubtotal;

            $cartCount += $quantity;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $itemSubtotal,
            ];
        }

        return view('store.cart', compact(
            'items',
            'subtotal',
            'cartCount'
        ));
    }


    /**
     * إضافة منتج إلى السلة
     */
    public function add(Request $request, Product $product)
    {
        abort_unless($product->status, 404);

        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $quantity = (int) $validated['quantity'];


        /*
        |--------------------------------------------------------------------------
        | المستخدم المسجل
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            $cartItem = Auth::user()
                ->cartItems()
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {

                $newQuantity = min(
                    $cartItem->quantity + $quantity,
                    100
                );

                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);

            } else {

                $newQuantity = $quantity;

                Auth::user()
                    ->cartItems()
                    ->create([
                        'product_id' => $product->id,
                        'quantity' => $newQuantity,
                    ]);
            }

            $cartCount = Auth::user()
                ->cartItems()
                ->sum('quantity');

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => true,
                    'message' => 'تمت إضافة المنتج إلى السلة.',
                    'cart_count' => $cartCount,
                    'product_id' => $product->id,
                    'quantity' => $newQuantity,
                ]);
            }

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تمت إضافة المنتج إلى السلة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | الزائر
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        $currentQuantity = (int) ($cart[$product->id] ?? 0);

        $cart[$product->id] = min(
            $currentQuantity + $quantity,
            100
        );

        session()->put('cart', $cart);

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة المنتج إلى السلة.',
                'cart_count' => array_sum($cart),
                'product_id' => $product->id,
                'quantity' => $cart[$product->id],
            ]);
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'تمت إضافة المنتج إلى السلة.'
            );
    }


    /**
     * تحديث الكمية
     */
    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $quantity = (int) $validated['quantity'];


        /*
        |--------------------------------------------------------------------------
        | المستخدم المسجل
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            $cartItem = Auth::user()
                ->cartItems()
                ->where('product_id', $product->id)
                ->first();

            if (!$cartItem) {

                return redirect()
                    ->route('cart.index');
            }

            $cartItem->update([
                'quantity' => $quantity,
            ]);

            return redirect()
                ->route('cart.index')
                ->with(
                    'success',
                    'تم تحديث السلة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | الزائر
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {

            return redirect()
                ->route('cart.index');
        }

        $cart[$product->id] = $quantity;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'تم تحديث السلة.'
            );
    }


    /**
     * حذف منتج
     */
    public function remove(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | المستخدم المسجل
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            Auth::user()
                ->cartItems()
                ->where('product_id', $product->id)
                ->delete();

            /*
            |----------------------------------------------------------------------
            | إذا أصبحت السلة فارغة
            |----------------------------------------------------------------------
            */

            if (
                !Auth::user()
                    ->cartItems()
                    ->exists()
            ) {
                session()->forget(
                    'checkout_coupon_code'
                );
            }

            return redirect()
                ->route('cart.index')
                ->with(
                    'success',
                    'تم حذف المنتج من السلة.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | الزائر
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        unset($cart[$product->id]);

        session()->put('cart', $cart);

        if (empty($cart)) {

            session()->forget(
                'checkout_coupon_code'
            );
        }

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'تم حذف المنتج من السلة.'
            );
    }


    /**
     * تفريغ السلة
     */
    public function clear()
    {
        /*
        |--------------------------------------------------------------------------
        | المستخدم المسجل
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            Auth::user()
                ->cartItems()
                ->delete();

        } else {

            /*
            |--------------------------------------------------------------------------
            | الزائر
            |--------------------------------------------------------------------------
            */

            session()->forget('cart');
        }


        /*
        |--------------------------------------------------------------------------
        | حذف كوبون Checkout
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'checkout_coupon_code'
        );


        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'تم تفريغ السلة.'
            );
    }


    /**
     * دمج سلة الـ Session مع سلة المستخدم
     *
     * نستدعيها بعد تسجيل الدخول.
     */
    public static function mergeSessionCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $user = Auth::user();

        foreach ($sessionCart as $productId => $quantity) {

            $quantity = (int) $quantity;

            if ($quantity <= 0) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | نتأكد أن المنتج موجود ومتاح
            |--------------------------------------------------------------------------
            */

            $productExists = Product::where('id', $productId)
                ->where('status', true)
                ->exists();

            if (!$productExists) {
                continue;
            }

            $cartItem = $user
                ->cartItems()
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {

                $cartItem->update([
                    'quantity' => min(
                        $cartItem->quantity + $quantity,
                        100
                    ),
                ]);

            } else {

                $user->cartItems()->create([
                    'product_id' => $productId,
                    'quantity' => min($quantity, 100),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | بعد الدمج نحذف سلة الـ Session
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');
    }
}
