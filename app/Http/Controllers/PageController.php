<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        // Lấy danh sách sản phẩm
        $productList = Product::all();

        $today = Carbon::now()->toDateString();
        // Lặp qua từng sản phẩm để gắn giảm giá nếu có
        foreach ($productList as $product) {
            // Tìm khuyến mãi đang áp dụng cho danh mục của sản phẩm
            $promotion = DB::table('promotions')
                ->join('promotion_categories', 'promotions.id', '=', 'promotion_categories.promotion_id')
                ->where('promotion_categories.category_id', $product->category_id)
                ->where('promotions.start_date', '<=', $today)
                ->where('promotions.end_date', '>=', $today)
                ->first();

            // Nếu có khuyến mãi, thêm thuộc tính giảm giá vào sản phẩm
            if ($promotion) {
                $product->discount_rate = $promotion->discount_rate;
            } else {
                $product->discount_rate = null;
            }
        }

        // dd($productList);
        $data = [
            "productList" => $productList,
        ];
        return view('page.home', $data);
    }
}
