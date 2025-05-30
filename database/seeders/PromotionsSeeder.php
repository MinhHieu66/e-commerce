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

        ]);
    }
}
