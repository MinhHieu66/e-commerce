<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductItem;

class SearchController extends Controller
{
    // public function search(Request $request)
    // {
    //     $query = $request->input('prod-search', '');

    //     if (empty($query)) {
    //         return response()->json(['message' => 'Từ khóa tìm kiếm không hợp lệ'], 400);
    //     }

    //     // Tìm kiếm sản phẩm theo tên, kèm theo item
    //     $products = Product::with('product_items')
    //         ->where('name', 'LIKE', "%{$query}%")
    //         ->distinct()
    //         ->get();


    //     // Tìm kiếm theo SKU
    //     $productItems = ProductItem::where('SKU', 'LIKE', "%{$query}%")
    //         ->with('product')
    //         ->get();

    //     // Mảng kết quả
    //     $results = collect();

    //     // Từ kết quả tìm theo tên
    //     foreach ($products as $product) {
    //         if ($product->product_items && $product->product_items->count() > 0) {
    //             foreach ($product->product_items as $item) {
    //                 $results->push([
    //                     'id' => $item->id,
    //                     'name' => $product->name,
    //                     'SKU' => $item->SKU,
    //                     'price' => $item->price ?? 'N/A',
    //                     'product_image' => $item->product_image ?? 'default.png',
    //                 ]);
    //             }
    //         }
    //     }

    //     // Từ kết quả tìm theo SKU
    //     foreach ($productItems as $item) {
    //         $results->push([
    //             'id' => $item->id,
    //             'name' => $item->product->name ?? 'Unknown Product',
    //             'SKU' => $item->SKU,
    //             'price' => $item->price ?? 'N/A',
    //             'product_image' => $item->product_image ?? 'default.png',
    //         ]);
    //     }

    //     return response()->json($results);
    // }

    public function search(Request $request)
    {
        $query = trim($request->input('prod-search', ''));

        if (empty($query)) {
            return response()->json(['message' => 'Từ khóa tìm kiếm không hợp lệ'], 400);
        }

        // Tìm các sản phẩm có tên khớp với từ khóa
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        if ($products->isEmpty()) {
            return response()->json([]);
        }

        // Lấy các product_items liên quan đến các sản phẩm
        $productItems = ProductItem::whereIn('product_id', $products->pluck('id'))
            ->with('product')
            ->get();

        // Chuẩn bị kết quả trả về
        $results = $productItems->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product->name ?? 'Unknown Product',
                'SKU' => $item->SKU,
                'price' => $item->price ?? 'N/A',
                'product_image' => $item->product_image ?? 'default.png',
            ];
        });

        return response()->json($results);
    }
}