<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductConfiguration;
use App\Models\ProductItem;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Danh mục
        $category = ProductCategory::create([
            'category_name' => 'Điện thoại',
        ]);

        // 2. Sản phẩm iPhone
        $product = Product::create([
            'category_id'   => $category->id,
            'name'          => 'iPhone 15 Pro',
            'description'   => 'Điện thoại iPhone 15 Pro, thiết kế titan mới, chip A17 Pro, hỗ trợ 5G.',
            'product_image' => 'iphone15pro.png',
        ]);

        // 3. Variations
        $color = Variation::create([
            'category_id' => $category->id,
            'name'        => 'Màu sắc',
        ]);

        $storage = Variation::create([
            'category_id' => $category->id,
            'name'        => 'Dung lượng',
        ]);

        // 4. Variation Options
        $black = VariationOption::create([
            'variation_id' => $color->id,
            'value'        => 'Đen',
        ]);

        $white = VariationOption::create([
            'variation_id' => $color->id,
            'value'        => 'Trắng',
        ]);

        $gb128 = VariationOption::create([
            'variation_id' => $storage->id,
            'value'        => '128GB',
        ]);

        $gb256 = VariationOption::create([
            'variation_id' => $storage->id,
            'value'        => '256GB',
        ]);

        // 5. Tạo các biến thể iPhone

        // SKU001 - iPhone Đen 128GB
        $item1 = ProductItem::create([
            'product_id'    => $product->id,
            'SKU'           => 'SKU001',
            'qty_in_stock'  => 15,
            'product_image' => 'iphone15pro_black_128.png',
            'price'         => 27990000,
        ]);

        // SKU002 - iPhone Trắng 256GB
        $item2 = ProductItem::create([
            'product_id'    => $product->id,
            'SKU'           => 'SKU002',
            'qty_in_stock'  => 10,
            'product_image' => 'iphone15pro_white_256.png',
            'price'         => 30990000,
        ]);

        // 6. Cấu hình biến thể
        // item1: Đen + 128GB
        ProductConfiguration::create([
            'product_item_id'     => $item1->id,
            'variation_option_id' => $black->id,
        ]);
        ProductConfiguration::create([
            'product_item_id'     => $item1->id,
            'variation_option_id' => $gb128->id,
        ]);

        // item2: Trắng + 256GB
        ProductConfiguration::create([
            'product_item_id'     => $item2->id,
            'variation_option_id' => $white->id,
        ]);
        ProductConfiguration::create([
            'product_item_id'     => $item2->id,
            'variation_option_id' => $gb256->id,
        ]);
    }
}
