<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string("name", 255)->unique();
            $table->text("description")->nullable();
            $table->decimal('discount_rate', 5, 2)
                ->check('discount_rate > 0 AND discount_rate < 100');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });

        Schema::table('promotions', function (Blueprint $table) {
            // Sử dụng DB::statement để thêm check constraint
            DB::statement('ALTER TABLE promotions ADD CONSTRAINT check_end_date CHECK (end_date > start_date)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};