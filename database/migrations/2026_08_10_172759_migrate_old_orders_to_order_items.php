<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $orders = DB::table('orders')
            ->whereNotNull('product_id')
            ->get();

        foreach ($orders as $order) {

            // منع إنشاء OrderItem مكرر
            $exists = DB::table('order_items')
                ->where('order_id', $order->id)
                ->exists();

            if ($exists) {
                continue;
            }

            $product = DB::table('products')
                ->where('id', $order->product_id)
                ->first();

            if (!$product) {
                continue;
            }

            $price = $order->quantity > 0
                ? ($order->subtotal / $order->quantity)
                : $order->subtotal;

            DB::table('order_items')->insert([
                'order_id' => $order->id,
                'product_id' => $order->product_id,
                'product_name' => $product->name,
                'price' => $price,
                'quantity' => $order->quantity,
                'subtotal' => $order->subtotal,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('order_items')->delete();
    }
};
