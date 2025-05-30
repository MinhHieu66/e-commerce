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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("detailed_address", 255);
            $table->foreignId('province_id')
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('district_id')
                ->constrained('districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('ward_id')
                ->constrained('wards')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Đầu tiên phải xóa các khóa ngoại
            $table->dropForeign(['province_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['ward_id']);

        });
        Schema::dropIfExists('addresses');
    }
};