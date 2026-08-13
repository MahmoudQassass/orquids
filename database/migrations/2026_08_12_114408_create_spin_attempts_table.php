<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spin_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('spin_prize_id')
                ->nullable()
                ->constrained('spin_prizes')
                ->nullOnDelete();

            // معرف الزائر في حالة عدم وجود تسجيل دخول
            $table->string('visitor_token')
                ->nullable()
                ->index();

            // كود الخصم
            $table->string('coupon_code')
                ->nullable()
                ->unique();

            // هل تم استخدام الجائزة؟
            $table->boolean('is_used')
                ->default(false);

            $table->timestamp('used_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spin_attempts');
    }
};
