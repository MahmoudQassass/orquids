<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $marketing = $request->input('marketing');

        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Marketing filter
        |--------------------------------------------------------------------------
        */

        if ($marketing === 'subscribed') {

            $query->where('marketing_consent', true);

        } elseif ($marketing === 'unsubscribed') {

            $query->where('marketing_consent', false);

        }

        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $customers = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalCustomers = User::count();

        $subscribedCustomers = User::where(
            'marketing_consent',
            true
        )->count();

        $unsubscribedCustomers = User::where(
            'marketing_consent',
            false
        )->count();

        return view(
            'admin.customers.index',
            compact(
                'customers',
                'totalCustomers',
                'subscribedCustomers',
                'unsubscribedCustomers'
            )
        );
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with(
                'success',
                'تم حذف العميل بنجاح.'
            );
    }
}
