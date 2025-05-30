<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
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

    public function shop()
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

        //lay danh sach danh muc san pham
        $categories = ProductCategory::all();

        // @dd($categories);
        $data1 = [
            'categories' => $categories,
        ];
        return view('page.shop', $data, $data1);
    }

    public function admin()
    {
        return view('template.admin');
    }

    public function coupon()
    {
        $promotions = Promotion::all();
        return view('crud.coupon-list', ['promotions' => $promotions]);
    }
}