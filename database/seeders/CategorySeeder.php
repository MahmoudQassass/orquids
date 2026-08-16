<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'fashion'],
            [
                'name' => 'أزياء',
                'description' => 'منتجات الأزياء والملابس والإكسسوارات.',
                'status' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'electronics'],
            [
                'name' => 'إلكترونيات',
                'description' => 'أجهزة إلكترونية وإكسسوارات تقنية متنوعة.',
                'status' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'beauty'],
            [
                'name' => 'عناية وجمال',
                'description' => 'منتجات العناية الشخصية والجمال.',
                'status' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'home-kitchen'],
            [
                'name' => 'منزل ومطبخ',
                'description' => 'منتجات وأدوات المنزل والمطبخ.',
                'status' => true,
            ]
        );
    }
}
