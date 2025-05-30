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
        Schema::create('promotion_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('promotion_id');

            // Đặt khóa chính tổng hợp
            $table->primary(['category_id', 'promotion_id']);

            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotion_categories', function (Blueprint $table) {
            // Đầu tiên phải xóa các khóa ngoại
            $table->dropForeign(['category_id']);
            $table->dropForeign(['promotion_id']);
        });
        Schema::dropIfExists('promotion_categories');
    }
};