<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => 'mahmoud@orquids.com',
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123456789'),
                'is_active' => true,
            ]
        );
    }
}
