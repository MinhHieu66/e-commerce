<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $sort = $request->input('sort_by');

        // Khởi tạo query sản phẩm + eager load product_items
        $query = Product::with('product_items');

        // Sắp xếp theo lựa chọn
        if ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'price') {
            // Sắp xếp theo giá thấp nhất của product_items
            // Đảm bảo rằng chỉ những sản phẩm có product_items mới được xét
            // Nếu bạn muốn hiển thị cả sản phẩm không có product_items nhưng không có giá,
            // bạn có thể bỏ whereHas, nhưng cần xử lý kỹ hơn ở view.
            $query->whereHas('product_items', function ($q) {
                $q->whereNotNull('price'); // Chỉ xét những product_item có giá
            })
                ->withMin('product_items', 'price')
                ->orderBy('product_items_min_price', 'asc');
        }

        // Lấy danh sách sản phẩm
        $productList = $query->get();

        // Ngày hôm nay để lọc khuyến mãi
        $today = Carbon::now()->toDateString();

        // Gán discount_rate và giá cho mỗi sản phẩm
        foreach ($productList as $product) {
            // 1. Gắn discount_rate nếu có khuyến mãi
            $promotion = DB::table('promotions')
                ->join('promotion_categories', 'promotions.id', '=', 'promotion_categories.promotion_id')
                ->where('promotion_categories.category_id', $product->category_id)
                ->where('promotions.start_date', '<=', $today)
                ->where('promotions.end_date', '>=', $today)
                ->first();

            $product->discount_rate = $promotion ? $promotion->discount_rate : null;

            // 2. Gán giá hiện tại (price_current_price) và giá cũ (price_old_price)
            // Lấy product_item có giá thấp nhất làm giá hiện tại
            // Đảm bảo rằng $product->product_items không rỗng trước khi truy cập
            if ($product->product_items && $product->product_items->isNotEmpty()) {
                // Sắp xếp product_items theo giá để lấy giá thấp nhất (nếu có nhiều product_item)
                $minPriceItem = $product->product_items->sortBy('price')->first();

                // Gán giá hiện tại
                $product->price_current_price = $minPriceItem->price;

                // Gán giá cũ (nếu có trường old_price trong ProductItem hoặc logic tính toán khác)
                // Ví dụ: Nếu có trường 'old_price' trong ProductItem
                // $product->price_old_price = $minPriceItem->old_price ?? null;
                // Nếu không, bạn cần định nghĩa logic cho price_old_price
                $product->price_old_price = null; // Mặc định là null, bạn có thể thay đổi dựa trên logic kinh doanh của bạn
            } else {
                // Nếu không có product_items liên quan, gán giá là null để tránh lỗi
                $product->price_current_price = null;
                $product->price_old_price = null;
            }
        }

        // Lấy 8 ProductItem mới nhất kèm theo thông tin Product cha
        $newArrivalProductItems = ProductItem::with('product')
            ->latest()
            ->take(8)
            ->get();

        return view('page.home', [
            "productList" => $productList,
            "newArrivalProductItems" => $newArrivalProductItems,
            "sortBy" => $sort,
        ]);
    }
}