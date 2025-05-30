<?php
namespace App\Http\Controllers;

use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Kiểm tra giỏ hàng ? Nếu giỏ hàng chưa có tạo giỏ hàng rỗng
        if (! Session::has('cart')) {
            Session::put('cart', []);
        }

        $cart       = Session::get('cart');
        $totalMoney = 0;
        foreach ($cart as &$item) {

            $product_item  = ProductItem::find($item["product_item_id"]);
            $item["image"] = $product_item->product_image;
            $item["name"]  = $product_item->products->name . " " . $item['color'] . " " . $item['storage'];
            $item["price"] = $product_item["price"];
            $item["total"] = $item["quantity"] * $item["price"];
            $totalMoney += $item["total"];
        }

        $data = [
            'cart'       => $cart,
            'totalMoney' => $totalMoney,
        ];
        return view("cart.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Lưu giỏ hàng
     */
    public function store(Request $request)
    {
        //Kiểm tra giỏ hàng có chưa ? Nếu chưa tạo giỏ hàng rỗng
        if (! Session::has('cart')) {
            Session::put('cart', []);
        }

        $inCart = false;
        // TH1: Sản phẩm có trong giỏ hàng -> Tăng số lượng sản phẩm
        $cart = Session::get("cart");
        foreach ($cart as &$item) {
            if ($request->input("product_item_id") === $item["product_item_id"]) {
                $item["quantity"] += $request->input("quantity");
                Session::put("cart", $cart);
                $inCart = true;
                break;
            }
        }
        // TH2: Sản phẩm không có trong giỏ hàng -> Thêm sản phẩm vào giỏ hàng
        if (! $inCart) {
            Session::push('cart', [
                'product_item_id' => $request->input("product_item_id"),
                'quantity'        => $request->input("quantity"),
                'color'           => $request->input("color"),
                'storage'         => $request->input("storage"),
            ]);
        }
        $product_item = ProductItem::find($request->input('product_item_id'));
        $product      = $product_item->products;
        return redirect()->route('product.detail', ['id' => $product->id]);
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
        $cart      = Session::get('cart');
        $cartTotal = 0;
        $itemTotal = 0;
        foreach ($cart as &$item) {
            if ($item["product_item_id"] == $id) {
                $item["quantity"] = $request->input("quantity");
                $product_item     = ProductItem::find($id);
                $item['price']    = $request->input("quantity") * $product_item['price'];
                $itemTotal        = $item['price'];
                $cartTotal        = +$item['price'];
            }
        }
        // Ghi lại vào session
        Session::put('cart', $cart);
        return response()->json([
            'item_total_formatted' => number_format($itemTotal, 0, ',', '.') . '₫',
            'cart_total_formatted' => number_format($cartTotal, 0, ',', '.') . '₫',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Session::get('cart', []);

        // Tạo mảng mới để lưu lại các sản phẩm còn lại
        $updatedCart = [];

        foreach ($cart as $item) {
            if ($item['product_item_id'] != $id) {
                $updatedCart[] = $item;
            }
        }

        // Ghi lại vào session
        Session::put('cart', $updatedCart);
        return redirect()->route('cart.index');

    }
}