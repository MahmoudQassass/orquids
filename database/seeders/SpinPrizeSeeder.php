<?php

namespace Database\Seeders;

use App\Models\SpinPrize;
use Illuminate\Database\Seeder;

class SpinPrizeSeeder extends Seeder
{
    public function run(): void
    {
        SpinPrize::query()->delete();

        SpinPrize::create([
            'name' => 'خصم 5%',
            'type' => 'discount',
            'discount_percent' => 5,
            'probability' => 35,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        SpinPrize::create([
            'name' => 'خصم 10%',
            'type' => 'discount',
            'discount_percent' => 10,
            'probability' => 25,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        SpinPrize::create([
            'name' => 'خصم 15%',
            'type' => 'discount',
            'discount_percent' => 15,
            'probability' => 15,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        SpinPrize::create([
            'name' => 'خصم 20%',
            'type' => 'discount',
            'discount_percent' => 20,
            'probability' => 5,
            'is_active' => true,
            'sort_order' => 4,
        ]);

        SpinPrize::create([
            'name' => 'شحن مجاني',
            'type' => 'free_shipping',
            'discount_percent' => null,
            'probability' => 20,
            'is_active' => true,
            'sort_order' => 5,
        ]);
    }
}
