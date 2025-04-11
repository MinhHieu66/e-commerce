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
        Schema::create('shopping_cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')
                ->constrained('shopping_carts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_item_id')
                ->constrained('product_items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer("qty");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shopping_cart_items', function (Blueprint $table) {
            // Đầu tiên phải xóa các khóa ngoại
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_item_id']);
        });
        Schema::dropIfExists('shopping_cart_items');
    }
};
