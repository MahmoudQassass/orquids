<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * عرض السلة
     */
    public function index()
{
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
     * إضافة منتج للسلة
     */
 /**
 * إضافة منتج للسلة
 */
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

    $cart = session()->get('cart', []);

    $currentQuantity = (int) ($cart[$product->id] ?? 0);

    $cart[$product->id] = min(
        $currentQuantity + $validated['quantity'],
        100
    );

    session()->put('cart', $cart);

    /*
    |--------------------------------------------------------------------------
    | AJAX Request
    |--------------------------------------------------------------------------
    */

    if ($request->expectsJson()) {

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج إلى السلة.',
            'cart_count' => array_sum($cart),
            'product_id' => $product->id,
            'quantity' => $cart[$product->id],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Normal Request
    |--------------------------------------------------------------------------
    */

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

    $cart = session()->get('cart', []);

    if (!isset($cart[$product->id])) {

        return redirect()
            ->route('cart.index');
    }

    $cart[$product->id] = $validated['quantity'];

    session()->put('cart', $cart);

    /*
    |--------------------------------------------------------------------------
    | لا نحذف الكوبون
    |--------------------------------------------------------------------------
    |
    | إذا كان هناك كوبون مطبق، يبقى محفوظاً.
    | وعند Checkout سيتم إعادة حساب الخصم
    | بناءً على subtotal الجديد.
    |
    */

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
    $cart = session()->get('cart', []);

    unset($cart[$product->id]);

    session()->put('cart', $cart);

    /*
    |--------------------------------------------------------------------------
    | إذا أصبحت السلة فارغة
    |--------------------------------------------------------------------------
    |
    | نحذف كوبون Checkout حتى لا يبقى
    | كوبون مرتبط بسلة فارغة.
    |
    */

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
    | حذف السلة
    |--------------------------------------------------------------------------
    */

    session()->forget('cart');

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
}
