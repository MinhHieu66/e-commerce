<?php
namespace Database\Seeders;

use App\Models\Variation;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Variation::create(['category_id' => 1, 'name' => 'Dung lượng']);
        Variation::create(['category_id' => 1, 'name' => 'Màu sắc']);
    }
}
