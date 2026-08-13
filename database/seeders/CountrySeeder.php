<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            [
                'name' => 'المملكة العربية السعودية',
                'code' => 'SA',
            ],

            [
                'name' => 'الإمارات العربية المتحدة',
                'code' => 'AE',
            ],

            [
                'name' => 'قطر',
                'code' => 'QA',
            ],

            [
                'name' => 'الكويت',
                'code' => 'KW',
            ],

            [
                'name' => 'البحرين',
                'code' => 'BH',
            ],

            [
                'name' => 'سلطنة عُمان',
                'code' => 'OM',
            ],

            [
                'name' => 'الأردن',
                'code' => 'JO',
            ],

            [
                'name' => 'مصر',
                'code' => 'EG',
            ],

            [
                'name' => 'فلسطين',
                'code' => 'PS',
            ],

            [
                'name' => 'العراق',
                'code' => 'IQ',
            ],

            [
                'name' => 'لبنان',
                'code' => 'LB',
            ],

            [
                'name' => 'المغرب',
                'code' => 'MA',
            ],

            [
                'name' => 'الجزائر',
                'code' => 'DZ',
            ],

            [
                'name' => 'تونس',
                'code' => 'TN',
            ],

            [
                'name' => 'ليبيا',
                'code' => 'LY',
            ],

            [
                'name' => 'تركيا',
                'code' => 'TR',
            ],

            [
                'name' => 'إيطاليا',
                'code' => 'IT',
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                [
                    'name' => $country['name'],
                    'active' => true,
                ]
            );
        }
    }
}
