<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PromotionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('promotions')->insert([
            [
                'name'          => 'Summer Sale',
                'description'   => 'Giảm giá mùa hè lên tới 30%',
                'discount_rate' => 0.3,
                'start_date'    => Carbon::now()->subDays(5),
                'end_date'      => Carbon::now()->addDays(10),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'New Year Sale',
                'description'   => 'Khuyến mãi Tết Nguyên Đán',
                'discount_rate' => 0.2,
                'start_date'    => Carbon::now()->subDays(5),
                'end_date'      => Carbon::now()->addDays(10),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Loa Sony Extra Bass',
                'description'   => 'Giảm giá 20% cho sản phẩm Loa Sony Extra Bass',
                'discount_rate' => 0.2,
                'start_date'    => Carbon::now()->subDays(5),
                'end_date'      => Carbon::now()->addDays(10),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Laptop Dell XPS 13',
                'description'   => 'Giảm giá 15% cho sản phẩm Laptop Dell XPS 13',
                'discount_rate' => 0.15,
                'start_date'    => Carbon::now()->subDays(3),
                'end_date'      => Carbon::now()->addDays(7),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Laptop MacBook Air M2',
                'description'   => 'Giảm giá 10% cho sản phẩm MacBook Air M2',
                'discount_rate' => 0.1,
                'start_date'    => Carbon::now()->subDay(),
                'end_date'      => Carbon::now()->addDays(14),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Đồng hồ Apple Watch S9',
                'description'   => 'Giảm giá 20% cho sản phẩm Apple Watch Series 9',
                'discount_rate' => 0.2,
                'start_date'    => Carbon::now()->subDays(2),
                'end_date'      => Carbon::now()->addDays(10),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Đồng hồ Xiaomi Watch 2',
                'description'   => 'Giảm giá 45% cho sản phẩm Xiaomi Watch 2',
                'discount_rate' => 0.45,
                'start_date'    => Carbon::now()->subDays(1),
                'end_date'      => Carbon::now()->addDays(15),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá iPhone 15 Pro',
                'description'   => 'Giảm giá 20% cho sản phẩm iPhone 15 Pro',
                'discount_rate' => 0.2,
                'start_date'    => '2025-06-01',
                'end_date'      => '2025-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá iPhone 14 Pro',
                'description'   => 'Giảm giá 10% cho sản phẩm iPhone 14 Pro',
                'discount_rate' => 0.1,
                'start_date'    => '2025-06-01',
                'end_date'      => '2025-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Samsung Galaxy S24',
                'description'   => 'Giảm giá 35% cho sản phẩm Samsung Galaxy S24',
                'discount_rate' => 0.35,
                'start_date'    => '2025-06-01',
                'end_date'      => '2025-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Samsung A55',
                'description'   => 'Giảm giá 30% cho sản phẩm Samsung A55',
                'discount_rate' => 0.3,
                'start_date'    => '2025-06-01',
                'end_date'      => '2025-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Giảm giá Loa Bluetooth JBL',
                'description'   => 'Giảm giá 25% cho sản phẩm Loa Bluetooth JBL',
                'discount_rate' => 0.25,
                'start_date'    => '2025-06-01',
                'end_date'      => '2025-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
