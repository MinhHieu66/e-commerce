<?php
namespace App\Http\Controllers;

use App\Models\Product; // Thêm Product model để truy cập product->name
use App\Models\ProductItem;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Thêm Log để ghi nhật ký lỗi

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kiểm tra giỏ hàng ? Nếu giỏ hàng chưa có tạo giỏ hàng rỗng
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }

        $cart = Session::get('cart');
        $totalMoney = 0;
        $updatedCart = []; // Mảng mới để lưu các item hợp lệ sau khi xử lý

        foreach ($cart as $key => $item) { // Thêm $key để có thể unset nếu cần, và không cần &item ở đây
            $product_item = ProductItem::find($item["product_item_id"]);

            if ($product_item) {
                // Kiểm tra xem product liên quan có tồn tại không trước khi truy cập name
                // Nếu product không tồn tại, product_item->product sẽ là null
                $productName = $product_item->product ? $product_item->product->name : 'Sản phẩm chính không xác định';

                $item["image"] = $product_item->product_image;
                $item["name"] = $productName . " " . ($item['color'] ?? '') . " " . ($item['storage'] ?? ''); // Thêm kiểm tra null cho color và storage
                $item["price"] = $product_item["price"];
                $item["total"] = $item["quantity"] * $item["price"];
                $totalMoney += $item["total"];
                $updatedCart[] = $item; // Thêm item hợp lệ vào mảng mới
            } else {
                // Xử lý trường hợp không tìm thấy ProductItem.
                // Log lỗi để dễ debug sau này.
                Log::warning("ProductItem with ID " . ($item["product_item_id"] ?? 'UNKNOWN') . " not found in cart. Item removed.");
                // Bạn có thể chọn cách xử lý:
                // 1. Bỏ qua item này hoàn toàn (chỉ đơn giản là không thêm vào $updatedCart)
                // 2. Gán giá trị mặc định để vẫn hiển thị nhưng báo lỗi
                // Hiện tại, việc không thêm vào $updatedCart đồng nghĩa với việc loại bỏ nó.
            }
        }
        Session::put('cart', $updatedCart); // Cập nhật lại session với các item hợp lệ

        $data = [
            'cart' => $updatedCart, // Trả về $updatedCart
            'totalMoney' => $totalMoney,
        ];
        return view("cart.index", $data);
    }

    public function checkout()
    {
        // Logic cho trang thanh toán.
        // Tương tự, bạn nên kiểm tra và xử lý giỏ hàng ở đây nếu nó hiển thị thông tin sản phẩm.
        $cart = Session::get('cart', []);
        $totalMoney = 0;
        $processedCart = [];

        foreach ($cart as $item) {
            $product_item = ProductItem::find($item["product_item_id"]);
            if ($product_item) {
                $productName = $product_item->product ? $product_item->product->name : 'Sản phẩm chính không xác định';
                $item["image"] = $product_item->product_image;
                $item["name"] = $productName . " " . ($item['color'] ?? '') . " " . ($item['storage'] ?? '');
                $item["price"] = $product_item["price"];
                $item["total"] = $item["quantity"] * $item["price"];
                $totalMoney += $item["total"];
                $processedCart[] = $item;
            } else {
                Log::warning("ProductItem with ID " . ($item["product_item_id"] ?? 'UNKNOWN') . " not found during checkout. Item skipped.");
                // Có thể hiển thị thông báo cho người dùng rằng một số sản phẩm đã bị loại bỏ
            }
        }
        Session::put('cart', $processedCart); // Cập nhật lại giỏ hàng sau khi xử lý

        $provinces = Provinces::all();
        $data = [
            'cart' => $processedCart,
            'totalMoney' => $totalMoney,
            'provinces' => $provinces,
        ];

        return view('cart.checkout', $data); // Giả sử bạn có view checkout.blade.php
    }


    public function checkoutSuccess()
    {
        // Kiểm tra giỏ hàng ? Nếu giỏ hàng chưa có tạo giỏ hàng rỗng
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }

        $cart = Session::get('cart');
        $totalMoney = 0;
        $updatedCart = []; // Mảng mới để lưu các item hợp lệ sau khi xử lý

        foreach ($cart as $key => $item) {
            $product_item = ProductItem::find($item["product_item_id"]);
            if ($product_item) {
                // Kiểm tra xem product liên quan có tồn tại không trước khi truy cập name
                $productName = $product_item->product ? $product_item->product->name : 'Sản phẩm chính không xác định';

                $item["image"] = $product_item->product_image;
                $item["name"] = $productName . " " . ($item['color'] ?? '') . " " . ($item['storage'] ?? '');
                $item["price"] = $product_item["price"];
                $item["total"] = $item["quantity"] * $item["price"];
                $totalMoney += $item["total"];
                $updatedCart[] = $item; // Thêm item hợp lệ vào mảng mới
            } else {
                Log::warning("ProductItem with ID " . ($item["product_item_id"] ?? 'UNKNOWN') . " not found in cart for checkout success. Item removed.");
                // Item sẽ tự động bị loại bỏ do không được thêm vào $updatedCart
            }
        }
        Session::put('cart', $updatedCart); // Cập nhật lại session với các item hợp lệ

        $provinces = Provinces::all();
        $data = [
            'cart' => $updatedCart, // Trả về $updatedCart
            'totalMoney' => $totalMoney,
            "provinces" => $provinces,
        ];
        return view('cart.success', $data);
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
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }

        $inCart = false;
        // TH1: Sản phẩm có trong giỏ hàng -> Tăng số lượng sản phẩm
        $cart = Session::get("cart");

        // Tìm ProductItem trước để đảm bảo nó tồn tại
        $requestedProductItem = ProductItem::find($request->input("product_item_id"));

        if (!$requestedProductItem) {
            // Xử lý nếu product_item_id không hợp lệ (không tìm thấy trong DB)
            Log::error("Attempted to add non-existent ProductItem to cart: ID " . $request->input("product_item_id"));
            return redirect()->back()->with('error', 'Sản phẩm bạn muốn thêm không tồn tại.');
        }

        foreach ($cart as &$item) {
            if ($request->input("product_item_id") === $item["product_item_id"]) {
                $item["quantity"] += $request->input("quantity");
                Session::put("cart", $cart);
                $inCart = true;
                break;
            }
        }
        // TH2: Sản phẩm không có trong giỏ hàng -> Thêm sản phẩm vào giỏ hàng
        if (!$inCart) {
            Session::push('cart', [
                'product_item_id' => $request->input("product_item_id"),
                'quantity' => $request->input("quantity"),
                'color' => $request->input("color"), // Đảm bảo các trường này luôn có giá trị
                'storage' => $request->input("storage"), // Đảm bảo các trường này luôn có giá trị
            ]);
        }

        // Không cần tìm lại $product_item ở đây vì đã tìm ở trên
        // $product_item = ProductItem::find($request->input('product_item_id')); // Dòng này không cần thiết

        $product = $requestedProductItem->product; // Sử dụng $requestedProductItem đã kiểm tra

        // Kiểm tra xem $product có tồn tại không trước khi truy cập id
        if (!$product) {
            Log::error("Product not found for ProductItem ID: " . $request->input('product_item_id'));
            return redirect()->back()->with('error', 'Không thể tìm thấy sản phẩm chính liên quan.');
        }

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
        $cart = Session::get('cart', []);
        $cartTotal = 0;
        $itemTotal = 0;
        $updatedCart = []; // Khởi tạo mảng mới để xây dựng lại giỏ hàng

        foreach ($cart as &$item) { // Vẫn giữ &item nếu bạn muốn sửa đổi trực tiếp, nhưng cẩn thận hơn
            if ($item["product_item_id"] == $id) {
                $product_item = ProductItem::find($id); // Tìm product_item

                if ($product_item) { // Kiểm tra nếu product_item tồn tại
                    $item["quantity"] = $request->input("quantity");
                    $item['price'] = $request->input("quantity") * $product_item['price']; // Tính lại giá item
                    $itemTotal = $item['price'];
                } else {
                    Log::warning("ProductItem with ID " . $id . " not found during cart update. Item might be removed.");
                    // Nếu không tìm thấy, không thêm vào updatedCart hoặc xử lý khác
                    continue; // Bỏ qua item này nếu không tìm thấy product_item
                }
            }
            // Thêm item vào mảng mới. Nếu item bị bỏ qua ở trên, nó sẽ không được thêm vào đây.
            $updatedCart[] = $item;
        }

        // Tính lại tổng giỏ hàng từ $updatedCart
        foreach ($updatedCart as $item) {
            $cartTotal += $item['total'] ?? ($item['quantity'] * ($item['price'] ?? 0)); // Đảm bảo total có giá trị
        }


        // Ghi lại vào session
        Session::put('cart', $updatedCart); // Cập nhật lại giỏ hàng với các item hợp lệ
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