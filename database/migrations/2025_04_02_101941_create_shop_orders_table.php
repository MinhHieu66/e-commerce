<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('payment_method_id')
                ->constrained('user_payment_methods')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('shipping_addess')
                ->constrained('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('shipping_method')
                ->constrained('shipping_methods')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('order_status')
                ->constrained('order_statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamp("order_date");
            $table->decimal("order_total", 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            // Đầu tiên phải xóa các khóa ngoại
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['shipping_addess']);
            $table->dropForeign(['shipping_method']);
            $table->dropForeign(['order_status']);
        });
        Schema::dropIfExists('shop_orders');
    }
};