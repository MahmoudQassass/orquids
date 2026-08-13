<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spin_prizes', function (Blueprint $table) {
            $table->id();

            // اسم الجائزة الظاهر للعميل
            $table->string('name');

            // نوع الجائزة
            // discount = خصم
            // free_shipping = شحن مجاني
            // gift = هدية
            // no_prize = لا يوجد فوز
            $table->string('type');

            // قيمة الخصم بالنسبة المئوية
            // مثال: 10 = 10%
            $table->decimal('discount_percent', 5, 2)
                ->nullable();

            // احتمال الفوز
            // مثال:
            // 5 = احتمال 5%
            // 20 = احتمال 20%
            $table->decimal('probability', 5, 2);

            // هل الجائزة مفعلة؟
            $table->boolean('is_active')
                ->default(true);

            // ترتيب ظهور الجائزة في العجلة
            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spin_prizes');
    }
};
