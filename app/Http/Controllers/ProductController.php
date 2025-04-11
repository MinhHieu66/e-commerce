<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function detail($id)
    {
        $product = Product::find($id);
        // dd($product);

        $today = Carbon::now()->toDateString();
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

        $product_items = ProductItem::where('product_id', $id)->get();

        foreach ($product_items as &$item) {
            foreach ($item->variation_options as $option) {
                if ($option->variations->name === 'Màu sắc') {
                    $item->color = $option->value;
                }

                if ($option->variations->name === 'Dung lượng') {
                    $item->storage = $option->value;
                }
                $item->discount_rate = $product->discount_rate;
            }
        }
        // dd($product_items);
        // $colors = VariationOption::whereHas('variations', function ($query) {
        //     $query->where('name', 'Màu sắc');
        // })->whereHas('product_configurations', function ($query) {
        //     $query->whereHas('product_items.products', function ($subQuery) {
        //         $subQuery->where('name', 'iPhone 15');
        //     });
        // })->pluck('value')->unique();

        // $storages = VariationOption::whereHas('variations', function ($query) {
        //     $query->where('name', 'Dung lượng');
        // })->whereHas('product_configurations', function ($query) {
        //     $query->whereHas('product_items.products', function ($subQuery) {
        //         $subQuery->where('name', 'iPhone 15');
        //     });
        // })->pluck('value')->unique();

        $data = [
            'product'       => $product,
            'product_items' => $product_items,
        ];
        return view('product.detail', $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
