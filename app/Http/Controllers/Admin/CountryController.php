<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'code',
                    'like',
                    "%{$search}%"
                );

            });
        }

        if ($request->filled('status')) {

            $query->where(
                'active',
                $request->status === 'active'
            );
        }

        $countries = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.countries.index',
            compact('countries')
        );
    }

    public function create()
    {
        return view(
            'admin.countries.create'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'size:2',
                'alpha',
                'unique:countries,code',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],

        ], [

            'name.required' =>
                'يرجى إدخال اسم الدولة.',

            'code.required' =>
                'يرجى إدخال رمز الدولة.',

            'code.size' =>
                'رمز الدولة يجب أن يتكون من حرفين.',

            'code.unique' =>
                'رمز الدولة مستخدم بالفعل.',

        ]);

        $validated['code'] =
            strtoupper($validated['code']);

        $validated['active'] =
            $request->boolean('active');

        Country::create($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with(
                'success',
                'تمت إضافة الدولة بنجاح.'
            );
    }

    public function edit(Country $country)
    {
        return view(
            'admin.countries.edit',
            compact('country')
        );
    }

    public function update(
        Request $request,
        Country $country
    ) {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'size:2',
                'alpha',
                Rule::unique(
                    'countries',
                    'code'
                )->ignore($country->id),
            ],

            'active' => [
                'nullable',
                'boolean',
            ],

        ]);

        $validated['code'] =
            strtoupper($validated['code']);

        $validated['active'] =
            $request->boolean('active');

        $country->update($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with(
                'success',
                'تم تحديث الدولة بنجاح.'
            );
    }

    public function destroy(Country $country)
    {
        if ($country->shippingAddresses()->exists()) {

            return back()->with(
                'error',
                'لا يمكن حذف هذه الدولة لأنها مرتبطة بعناوين شحن.'
            );
        }

        $country->delete();

        return back()->with(
            'success',
            'تم حذف الدولة بنجاح.'
        );
    }
}
