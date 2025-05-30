<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('promotion_categories')->insert([
            [
                'promotion_id' => 1,
                'category_id'  => 1, // ID của một danh mục đã có
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'promotion_id' => 2,
                'category_id'  => 2,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
