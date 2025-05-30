<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductConfiguration;
use App\Models\ProductItem;
use App\Models\VariationOption;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     $faker = Faker::create();

    //     for ($i = 1; $i <= 4; $i++) {

    //         $product = Product::create([
    //             'name'          => 'Sản phẩm ' . $i,
    //             'description'   => $faker->paragraph,
    //             'product_image' => 'iphone_' . $i . '.png', // iphone_10.png
    //             'category_id'   => 1,                       // Giả sử category_id = 1 là 'Điện thoại'
    //         ]);

    //         // Tạo 2 biến thể cho mỗi sản phẩm
    //         ProductItem::create([
    //             'product_id'    => $product->id,
    //             'SKU'           => 'SP' . $i . '-128-BK',
    //             'qty_in_stock'  => rand(5, 15),
    //             'price'         => rand(20000000, 25000000),
    //             'product_image' => 'iphone_15_green.png',
    //         ]);

    //         ProductItem::create([
    //             'product_id'    => $product->id,
    //             'SKU'           => 'SP' . $i . '-256-WH',
    //             'qty_in_stock'  => rand(3, 10),
    //             'price'         => rand(25000000, 30000000),
    //             'product_image' => 'iphone_15_yellow_256.png',
    //         ]);
    //     }

    //     for ($i = 1; $i <= 4; $i++) {

    //         // Thêm 1 sản phẩm Laptop (category_id = 2)
    //         $laptop = Product::create([
    //             'name'          => 'Laptop Gaming Pro' . $i,
    //             'description'   => $faker->paragraph,
    //             'product_image' => 'laptop_1.png',
    //             'category_id'   => 2, // Giả sử 2 là danh mục Laptop
    //         ]);

    //         // Tạo các biến thể cho Laptop
    //         ProductItem::create([
    //             'product_id'    => $laptop->id,
    //             'SKU'           => 'LAP-GAMING-16GB' . $i,
    //             'qty_in_stock'  => rand(3, 7),
    //             'price'         => rand(18000000, 22000000),
    //             'product_image' => 'laptop_1_1.png',
    //         ]);

    //         ProductItem::create([
    //             'product_id'    => $laptop->id,
    //             'SKU'           => 'LAP-GAMING-32GB' . $i,
    //             'qty_in_stock'  => rand(2, 5),
    //             'price'         => rand(25000000, 28000000),
    //             'product_image' => 'laptop_1_2.png',
    //         ]);
    //     }

    // }

    public function run()
    {
        $faker = Faker::create();

                                                                             // Lấy các option
        $capacityOptions = VariationOption::where('variation_id', 1)->get(); // Dung lượng
        $colorOptions    = VariationOption::where('variation_id', 2)->get(); // Màu sắc

        $phoneNames = [
            'iPhone 15 Pro Max', 'iPhone 15', 'Samsung Galaxy S24 Ultra', 'Samsung A54',
            'Xiaomi 14 Ultra', 'OPPO Find X7', 'Vivo V30', 'Realme GT Neo 6',
            'Nokia X30', 'Asus ROG Phone 8', 'OnePlus 12', 'Pixel 8 Pro',
        ];

        for ($i = 1; $i <= 4; $i++) {
            $product = Product::create([
                'name'          => $faker->randomElement($phoneNames),
                'description'   => $faker->paragraph,
                'product_image' => 'iphone_' . $i . '.png',
                'category_id'   => 1,
            ]);

            // Shuffle lại danh sách để tránh trùng
            $shuffledCapacities = $capacityOptions->shuffle();
            $shuffledColors     = $colorOptions->shuffle();

            for ($j = 0; $j < 2; $j++) {
                $capacity = $shuffledCapacities[$j]; // không trùng
                $color    = $shuffledColors[$j];     // không trùng
                if ($j == 0) {
                    $image = 'iphone_15_yellow_256.png';
                } else {
                    $image = "iphone_15_green.png";
                }
                $item = ProductItem::create([
                    'product_id'    => $product->id,
                    'SKU'           => 'SP' . $i . '-' . $capacity->value . '-' . Str::slug($color->value),
                    'qty_in_stock'  => rand(3, 15),
                    'price'         => rand(20000000, 30000000),
                    'product_image' => $image,
                ]);

                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $capacity->id, // dung lượng
                ]);

                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $color->id, // màu sắc
                ]);
            }
        }

        for ($i = 1; $i <= 4; $i++) {
            $laptop = Product::create([
                'name'          => $faker->randomElement([
                    'Asus ROG Zephyrus', 'Dell XPS 15', 'MSI Gaming GE76',
                    'MacBook Pro M2', 'HP Omen 16', 'Acer Predator Helios',
                ]) . ' ' . $faker->randomElement(['2023', '2024', 'Plus', 'SE']),
                'description'   => $faker->paragraph,
                'product_image' => 'laptop_1.png',
                'category_id'   => 2, // Laptop
            ]);

            // Shuffle lại danh sách để tránh trùng
            $shuffledCapacities = $capacityOptions->shuffle();
            $shuffledColors     = $colorOptions->shuffle();

            // Tạo 2 biến thể cho mỗi laptop
            for ($j = 1; $j <= 2; $j++) {
                                                     // Chọn ngẫu nhiên 1 RAM và 1 màu (không trùng)
                $capacity = $shuffledCapacities[$j]; // không trùng
                $color    = $shuffledColors[$j];     // không trùng
                                                     // $randomRamId   = $faker->randomElement($ramOptions);
                                                     // $randomColorId = $faker->randomElement($colorOptions);

                $item = ProductItem::create([
                    'product_id'    => $laptop->id,
                    'SKU'           => 'LAP-' . Str::slug($laptop->name) . "-{$j}",
                    'qty_in_stock'  => rand(2, 6),
                    'price'         => rand(18000000, 30000000),
                    'product_image' => 'laptop_1_' . $j . '.png',
                ]);

                // Gán RAM và màu sắc cho biến thể
                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $capacity->id, // dung lượng
                ]);

                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $color->id, // màu sắc
                ]);
            }
        }
    }
}
