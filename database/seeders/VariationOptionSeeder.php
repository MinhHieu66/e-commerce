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
        $capacities = ['64GB', '128GB', '256GB', '512GB', '1TB', '2TB'];
        foreach ($capacities as $capacity) {
            VariationOption::create(['variation_id' => 1, 'value' => $capacity]);
        }

        // Màu sắc (variation_id = 2)
        $colors = ['Đen', 'Trắng', 'Xanh', 'Đỏ', 'Vàng', 'Tím', 'Hồng', 'Xám', 'Xanh Lá', 'Cam'];
        foreach ($colors as $color) {
            VariationOption::create(['variation_id' => 2, 'value' => $color]);
        }

    }
}
