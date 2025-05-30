<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductConfiguration;
use App\Models\ProductItem;
use App\Models\VariationOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductItemController extends Controller
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
        $product_items = ProductItem::paginate(10);
        // $product_items = ProductItem::with('product.product_categories')->get();

        $data = [
            'product_items' => $product_items,
        ];

        // dd($data);
        return view('page.product-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product_categories = ProductCategory::all();
        $colors             = VariationOption::whereHas('variation', function ($query) {
            $query->where('name', 'Màu sắc');
        })->get();
        $capacities = VariationOption::whereHas('variation', function ($query) {
            $query->where('name', 'Dung lượng');
        })->get();

        $data = [
            'product_categories' => $product_categories,
            'colors'             => $colors,
            'capacities'         => $capacities,
        ];
        return view('page.add-product', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Upload ảnh nếu có
            if ($request->hasFile('image')) {
                $image     = $request->file('image');
                $imageName = $image->getClientOriginalName(); // giữ nguyên tên file gốc
                $image->move(public_path('images/product/electric'), $imageName);
                $imagePath = 'images/product/electric/' . $imageName;
            }

            // Kiểm tra sản phẩm theo tên
            $product = Product::where('name', $request->name)->first();

            if (! $product) {
                $product = Product::create([
                    'name'          => $request->name,
                    'description'   => strip_tags($request->editor1),
                    'product_image' => $imageName,
                    'category_id'   => $request->product_category,
                ]);
            }

            // dd($product);

            // Kiểm tra SKU trùng
            if (ProductItem::where('SKU', $request->SKU)->exists()) {
                return redirect()->back()->withInput()->withErrors(['SKU' => 'SKU đã tồn tại']);
            }

            // Tạo product_item mới (1 biến thể)
            $item = ProductItem::create([
                'product_id'    => $product->id,
                'SKU'           => $request->SKU,
                'qty_in_stock'  => $request->{'qty-in-stock'},
                'price'         => $request->price,
                'product_image' => $imageName,
            ]);

            // Gắn variation_option_id (vd: capacity và color)
            $variationOptions = [$request->capacity, $request->color];

            foreach ($variationOptions as $optionId) {
                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $optionId,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with([
                'message'    => 'Thêm sản phẩm thành công!',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            // DB::rollBack();
            // // Chuyển hướng về trang trước với thông báo lỗi
            // return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

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
    public function edit($id)
    {
        if (! is_numeric($id)) {
            DB::commit();
            return redirect()->route('admin.products.index')->with([
                'message'    => 'ID không hợp lệ!',
                'alert-type' => 'error',
            ]);
        }

        $product_item = ProductItem::find($id);

        // Nếu không tìm thấy
        if (! $product_item) {
            return redirect()->route('admin.products.index')->with([
                'message'    => 'Không tìm thấy sản phẩm!',
                'alert-type' => 'error',
            ]);
        }

        $product_categories = ProductCategory::all();
        $colors             = VariationOption::whereHas('variation', function ($query) {
            $query->where('name', 'Màu sắc');
        })->get();
        $capacities = VariationOption::whereHas('variation', function ($query) {
            $query->where('name', 'Dung lượng');
        })->get();

        $data = [
            'product_item'       => $product_item,
            'product_categories' => $product_categories,
            'colors'             => $colors,
            'capacities'         => $capacities,
        ];

        return view('page.edit-product', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        DB::beginTransaction();
        try {
            $item = ProductItem::findOrFail($id); // Lấy product_item cũ
                                                  // So sánh updated_at để kiểm tra xung đột giữa các tab
            if ($request->updated_at != $item->updated_at) {
                DB::commit();
                return back()->with([
                    'message'    => 'Dữ liệu đã bị thay đổi. Vui lòng tải lại trang trước khi cập nhật!',
                    'alert-type' => 'error',
                ]);
            }

            $product   = $item->product;
            $imageName = $item->product_image;

            // Nếu có ảnh mới
            if ($request->hasFile('image')) {
                $image     = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/product/electric'), $imageName);
            }

            // Cập nhật sản phẩm cha
            $product->update([
                'name'          => $request->name,
                'description'   => strip_tags($request->editor1),
                'product_image' => $imageName,
                'category_id'   => $request->product_category,
            ]);

            // Kiểm tra SKU trùng (trừ chính nó)
            if (ProductItem::where('SKU', $request->SKU)->where('id', '!=', $item->id)->exists()) {
                return redirect()->back()->withInput()->withErrors(['SKU' => 'SKU đã tồn tại']);
            }

            // Cập nhật biến thể sản phẩm
            $item->update([
                'SKU'           => $request->SKU,
                'qty_in_stock'  => $request->{'qty-in-stock'},
                'price'         => $request->price,
                'product_image' => $imageName,
            ]);

            // Xoá cấu hình cũ
            $item->product_configurations()->delete();

            // Gắn lại variation options mới
            $variationOptions = [$request->capacity, $request->color];
            // dd($variationOptions);
            foreach ($variationOptions as $optionId) {
                ProductConfiguration::create([
                    'product_item_id'     => $item->id,
                    'variation_option_id' => $optionId,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with([
                'message'    => 'Cập nhật sản phẩm thành công!',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product_item = ProductItem::findOrFail($id);
            $product_item->delete();

            return redirect()->route('admin.products.index')->with([
                'message'    => 'Xóa sản phẩm thành công!',
                'alert-type' => 'success',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.products.index')->with([
                'message'    => 'Không tìm thấy sản phẩm cần xóa!',
                'alert-type' => 'error',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with([
                'message', 'Đã xảy ra lỗi khi xóa sản phẩm!',
                'alert-type' => 'error',
            ]);
        }
    }

    public function sortProducts(Request $request)
    {
        $sort = $request->input('sort_by');

        $query = ProductItem::with('product'); // Eager load product info

        if ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'name') {
            $query->join('products', 'product_items.product_id', '=', 'products.id')
                ->orderBy('products.name', 'asc');
        } elseif ($sort === 'price') {
            $query->orderBy('price', 'asc');
        }

        $productList = $query->get();

        return view('page.home', ['productList' => $productList]);
    }
}
