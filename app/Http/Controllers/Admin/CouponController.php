<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * عرض جميع الكوبونات
     */
public function index(Request $request)
{
    $query = Coupon::with('order');

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(
            'code',
            'like',
            '%' . $search . '%'
        );
    }

    if ($request->status === 'available') {

        $query->where('is_used', false)
              ->where(function ($q) {

                  $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());

              });
    }

    if ($request->status === 'used') {

        $query->where('is_used', true);
    }

    if ($request->status === 'expired') {

        $query->where('is_used', false)
              ->whereNotNull('expires_at')
              ->where('expires_at', '<=', now());
    }

    $coupons = $query
        ->latest()
        ->paginate(20)
        ->withQueryString();

    return view(
        'admin.coupons.index',
        compact('coupons')
    );
}


    /**
     * صفحة إنشاء كوبون
     */
    public function create()
    {
        return view('admin.coupons.create');
    }


    /**
     * حفظ كوبون جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:coupons,code',
            ],

            'type' => [
                'required',
                'in:discount,free_shipping',
            ],

            'discount_percent' => [
                'nullable',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],
        ], [

            'code.unique' =>
                'كود الكوبون مستخدم بالفعل.',

            'type.required' =>
                'يرجى اختيار نوع الكوبون.',

            'type.in' =>
                'نوع الكوبون غير صالح.',

            'discount_percent.numeric' =>
                'نسبة الخصم يجب أن تكون رقمًا.',

            'discount_percent.min' =>
                'نسبة الخصم يجب أن تكون أكبر من 0.',

            'discount_percent.max' =>
                'نسبة الخصم لا يمكن أن تتجاوز 100%.',

            'expires_at.after' =>
                'تاريخ الانتهاء يجب أن يكون في المستقبل.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | توليد الكود تلقائيًا
        |--------------------------------------------------------------------------
        */

        if (empty($validated['code'])) {

            do {

                $code = strtoupper(
                    Str::random(10)
                );

            } while (
                Coupon::where('code', $code)->exists()
            );

            $validated['code'] = $code;
        }


        /*
        |--------------------------------------------------------------------------
        | إذا كان شحن مجاني
        |--------------------------------------------------------------------------
        */

        if ($validated['type'] === 'free_shipping') {
            $validated['discount_percent'] = null;
        }


        $validated['is_used'] = false;


        Coupon::create($validated);


        return redirect()
            ->route('admin.coupons.index')
            ->with(
                'success',
                'تم إنشاء الكوبون بنجاح.'
            );
    }


    /**
     * صفحة تعديل كوبون
     */
    public function edit(Coupon $coupon)
    {
        return view(
            'admin.coupons.edit',
            compact('coupon')
        );
    }


    /**
     * تحديث الكوبون
     */
    public function update(
        Request $request,
        Coupon $coupon
    ) {

        /*
        |--------------------------------------------------------------------------
        | منع تعديل الكوبون المستخدم
        |--------------------------------------------------------------------------
        */

        if ($coupon->is_used) {

            return redirect()
                ->route('admin.coupons.index')
                ->with(
                    'error',
                    'لا يمكن تعديل كوبون تم استخدامه.'
                );
        }


        $validated = $request->validate([

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code,' . $coupon->id,
            ],

            'type' => [
                'required',
                'in:discount,free_shipping',
            ],

            'discount_percent' => [
                'nullable',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],
        ], [

            'code.required' =>
                'يرجى إدخال كود الكوبون.',

            'code.unique' =>
                'كود الكوبون مستخدم بالفعل.',

            'type.required' =>
                'يرجى اختيار نوع الكوبون.',

            'discount_percent.numeric' =>
                'نسبة الخصم يجب أن تكون رقمًا.',

            'discount_percent.min' =>
                'نسبة الخصم يجب أن تكون أكبر من 0.',

            'discount_percent.max' =>
                'نسبة الخصم لا يمكن أن تتجاوز 100%.',
        ]);


        if ($validated['type'] === 'free_shipping') {
            $validated['discount_percent'] = null;
        }


        $coupon->update($validated);


        return redirect()
            ->route('admin.coupons.index')
            ->with(
                'success',
                'تم تحديث الكوبون بنجاح.'
            );
    }


    /**
     * حذف كوبون
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->is_used) {

            return redirect()
                ->route('admin.coupons.index')
                ->with(
                    'error',
                    'لا يمكن حذف كوبون تم استخدامه.'
                );
        }


        $coupon->delete();


        return redirect()
            ->route('admin.coupons.index')
            ->with(
                'success',
                'تم حذف الكوبون بنجاح.'
            );
    }


    /**
     * توليد مجموعة كوبونات
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([

            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:500',
            ],

            'type' => [
                'required',
                'in:discount,free_shipping',
            ],

            'discount_percent' => [
                'nullable',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],

        ], [

            'quantity.required' =>
                'يرجى تحديد عدد الكوبونات.',

            'quantity.integer' =>
                'عدد الكوبونات يجب أن يكون رقمًا.',

            'quantity.min' =>
                'يجب إنشاء كوبون واحد على الأقل.',

            'quantity.max' =>
                'يمكن إنشاء 500 كوبون كحد أقصى في العملية الواحدة.',

            'type.required' =>
                'يرجى اختيار نوع الكوبون.',

            'discount_percent.numeric' =>
                'نسبة الخصم يجب أن تكون رقمًا.',

            'discount_percent.max' =>
                'نسبة الخصم لا يمكن أن تتجاوز 100%.',

            'expires_at.after' =>
                'تاريخ الانتهاء يجب أن يكون في المستقبل.',
        ]);


        if (
            $validated['type'] === 'discount'
            && empty($validated['discount_percent'])
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'discount_percent' =>
                        'يجب تحديد نسبة الخصم.'
                ]);
        }


        $created = 0;


        for ($i = 0; $i < $validated['quantity']; $i++) {

            do {

                $code =
                    'ORC-' .
                    strtoupper(
                        Str::random(8)
                    );

            } while (
                Coupon::where('code', $code)->exists()
            );


            Coupon::create([

                'code' => $code,

                'type' =>
                    $validated['type'],

                'discount_percent' =>
                    $validated['type'] === 'discount'
                        ? $validated['discount_percent']
                        : null,

                'expires_at' =>
                    $validated['expires_at'] ?? null,

                'is_used' => false,

            ]);


            $created++;
        }


        return redirect()
            ->route('admin.coupons.index')
            ->with(
                'success',
                "تم توليد {$created} كوبون بنجاح."
            );
    }
}
