<?php
namespace Database\Seeders;

use App\Models\ProductConfiguration;
use Illuminate\Database\Seeder;

class ProductConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
                                                                                            // iPhone 15 - 128GB Đen (product_item_id = 1)
        ProductConfiguration::create(['product_item_id' => 1, 'variation_option_id' => 1]); // 128GB
        ProductConfiguration::create(['product_item_id' => 1, 'variation_option_id' => 3]); // Đen

                                                                                            // iPhone 15 - 256GB Trắng (product_item_id = 2)
        ProductConfiguration::create(['product_item_id' => 2, 'variation_option_id' => 2]); // 256GB
        ProductConfiguration::create(['product_item_id' => 2, 'variation_option_id' => 4]); // Trắng
    }
}
