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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string("name", 255);
            $table->string("full_name", 255);
            $table->string("code_name", 50)->unique();

            // Foregin Key
            $table->foreignId('adminnistrative_region_id')
                ->constrained('adminnistrative_regions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('adminnistrative_unit_id')
                ->constrained('adminnistrative_units')
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
        Schema::table('provinces', function (Blueprint $table) {
            // Đầu tiên phải xóa các khóa ngoại
            $table->dropForeign(['administrative_region_id']);
            $table->dropForeign(['administrative_unit_id']);
        });

        Schema::dropIfExists('provinces');
    }
};
