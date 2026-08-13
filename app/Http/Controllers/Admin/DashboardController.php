<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Dates
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Orders Statistics
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::count();

        $paidOrders = Order::where('payment_status', 'paid')
            ->count();

        $pendingOrders = Order::where('payment_status', 'pending')
            ->count();

        $failedOrders = Order::where('payment_status', 'failed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Sales
        |--------------------------------------------------------------------------
        */

        $totalSales = Order::where('payment_status', 'paid')
            ->sum('total');


        $todaySales = Order::where('payment_status', 'paid')
            ->whereDate('created_at', $today)
            ->sum('total');


        $monthlySales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [
                $startOfMonth,
                $endOfMonth
            ])
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | Orders Today
        |--------------------------------------------------------------------------
        */

        $todayOrders = Order::whereDate(
            'created_at',
            $today
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Average Order Value
        |--------------------------------------------------------------------------
        */

        $averageOrderValue = Order::where(
            'payment_status',
            'paid'
        )->avg('total') ?? 0;


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'status',
            true
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::with([
            'items.product'
        ])
            ->latest()
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Best Selling Products
        |--------------------------------------------------------------------------
        */

        $bestSellingProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(subtotal) as total_sales')
            )
            ->whereHas('order', function ($query) {
                $query->where(
                    'payment_status',
                    'paid'
                );
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sales Chart - Last 7 Days
        |--------------------------------------------------------------------------
        */

        $salesChart = collect();

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $sales = Order::where(
                    'payment_status',
                    'paid'
                )
                ->whereDate(
                    'created_at',
                    $date
                )
                ->sum('total');


            $salesChart->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->translatedFormat('D'),
                'sales' => (float) $sales,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalOrders',
                'paidOrders',
                'pendingOrders',
                'failedOrders',
                'totalSales',
                'todaySales',
                'monthlySales',
                'todayOrders',
                'averageOrderValue',
                'totalProducts',
                'activeProducts',
                'recentOrders',
                'bestSellingProducts',
                'salesChart'
            )
        );
    }
}
