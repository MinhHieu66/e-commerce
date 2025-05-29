<?php
namespace Database\Seeders;

use App\Models\ProductItem;
use Illuminate\Database\Seeder;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ProductItem::create([
            'product_id'    => 1,
            'SKU'           => 'IP15-128-BK',
            'qty_in_stock'  => 10,
            'price'         => 29000000,
            'product_image' => 'ip15-black.jpg',
        ]);

        ProductItem::create([
            'product_id'    => 1,
            'SKU'           => 'IP15-256-WH',
            'qty_in_stock'  => 5,
            'price'         => 31900000,
            'product_image' => 'ip15-white.jpg',
        ]);
    }
}
