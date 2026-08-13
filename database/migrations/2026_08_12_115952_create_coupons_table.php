<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // كود الكوبون
            $table->string('code')->unique();

            // discount / free_shipping
            $table->string('type');

            // مثال: 10 = خصم 10%
            $table->decimal('discount_percent', 5, 2)->nullable();

            // الكوبون القادم من عجلة العروض
            $table->foreignId('spin_attempt_id')
                ->nullable()
                ->constrained('spin_attempts')
                ->nullOnDelete();

            // هل تم استخدام الكوبون؟
            $table->boolean('is_used')->default(false);

            // رقم الطلب الذي استخدم معه
            $table->unsignedBigInteger('order_id')->nullable();

            $table->timestamp('used_at')->nullable();

            // تاريخ انتهاء اختياري
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('is_used');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
