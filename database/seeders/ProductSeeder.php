<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductItem;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 4; $i++) {

            $product = Product::create([
                'name'          => 'Sản phẩm ' . $i,
                'description'   => $faker->paragraph,
                'product_image' => 'iphone_' . $i . '.png', // iphone_10.png
                'category_id'   => 1,                       // Giả sử category_id = 1 là 'Điện thoại'
            ]);

            // Tạo 2 biến thể cho mỗi sản phẩm
            ProductItem::create([
                'product_id'    => $product->id,
                'SKU'           => 'SP' . $i . '-128-BK',
                'qty_in_stock'  => rand(5, 15),
                'price'         => rand(20000000, 25000000),
                'product_image' => 'iphone_15_green.png',
            ]);

            ProductItem::create([
                'product_id'    => $product->id,
                'SKU'           => 'SP' . $i . '-256-WH',
                'qty_in_stock'  => rand(3, 10),
                'price'         => rand(25000000, 30000000),
                'product_image' => 'iphone_15_yellow_256.png',
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {

            // Thêm 1 sản phẩm Laptop (category_id = 2)
            $laptop = Product::create([
                'name'          => 'Laptop Gaming Pro' . $i,
                'description'   => $faker->paragraph,
                'product_image' => 'laptop_1.png',
                'category_id'   => 2, // Giả sử 2 là danh mục Laptop
            ]);

            // Tạo các biến thể cho Laptop
            ProductItem::create([
                'product_id'    => $laptop->id,
                'SKU'           => 'LAP-GAMING-16GB' . $i,
                'qty_in_stock'  => rand(3, 7),
                'price'         => rand(18000000, 22000000),
                'product_image' => 'laptop_1_1.png',
            ]);

            ProductItem::create([
                'product_id'    => $laptop->id,
                'SKU'           => 'LAP-GAMING-32GB' . $i,
                'qty_in_stock'  => rand(2, 5),
                'price'         => rand(25000000, 28000000),
                'product_image' => 'laptop_1_2.png',
            ]);
        }

    }
}
