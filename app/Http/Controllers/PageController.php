<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // public function home()
    // {
    //     // Lấy danh sách sản phẩm
    //     $productList = Product::all();

    //     $today = Carbon::now()->toDateString();
    //     // Lặp qua từng sản phẩm để gắn giảm giá nếu có
    //     foreach ($productList as $product) {
    //         // Tìm khuyến mãi đang áp dụng cho danh mục của sản phẩm
    //         $promotion = DB::table('promotions')
    //             ->join('promotion_categories', 'promotions.id', '=', 'promotion_categories.promotion_id')
    //             ->where('promotion_categories.category_id', $product->category_id)
    //             ->where('promotions.start_date', '<=', $today)
    //             ->where('promotions.end_date', '>=', $today)
    //             ->first();

    //         // Nếu có khuyến mãi, thêm thuộc tính giảm giá vào sản phẩm
    //         if ($promotion) {
    //             $product->discount_rate = $promotion->discount_rate;
    //         } else {
    //             $product->discount_rate = null;
    //         }
    //     }

    //     // dd($productList);
    //     $data = [
    //         "productList" => $productList,
    //     ];
    //     return view('page.home', $data);
    // }
    

    public function home(Request $request)
    {
        $sort = $request->input('sort_by'); // Nhận tham số từ dropdown lọc

        // Khởi tạo query sản phẩm + eager load product_items
        $query = Product::with('product_items');

        // Sắp xếp theo lựa chọn
        if ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'price') {
            // Sắp xếp theo giá thấp nhất của product_items
            $query->withMin('product_items', 'price')
                ->orderBy('product_items_min_price', 'asc');
        }

        // Lấy danh sách sản phẩm
        $productList = $query->get();

        // Ngày hôm nay để lọc khuyến mãi
        $today = now()->toDateString();

        // Gắn discount_rate nếu có khuyến mãi
        foreach ($productList as $product) {
            $promotion = DB::table('promotions')
                ->join('promotion_categories', 'promotions.id', '=', 'promotion_categories.promotion_id')
                ->where('promotion_categories.category_id', $product->category_id)
                ->where('promotions.start_date', '<=', $today)
                ->where('promotions.end_date', '>=', $today)
                ->first();

            $product->discount_rate = $promotion ? $promotion->discount_rate : null;
        }

        return view('page.home', [
            "productList" => $productList,
            "sortBy" => $sort
        ]);
    }

}