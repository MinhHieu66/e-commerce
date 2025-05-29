<?php
namespace Database\Seeders;

use App\Models\VariationOption;
use Illuminate\Database\Seeder;

class VariationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dung lượng (variation_id = 1)
        VariationOption::create(['variation_id' => 1, 'value' => '128GB']);
        VariationOption::create(['variation_id' => 1, 'value' => '256GB']);

        // Màu sắc (variation_id = 2)
        VariationOption::create(['variation_id' => 2, 'value' => 'Đen']);
        VariationOption::create(['variation_id' => 2, 'value' => 'Trắng']);
    }
}
