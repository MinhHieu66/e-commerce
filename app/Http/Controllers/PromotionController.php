<?php
namespace App\Http\Controllers;

use App\Http\Requests\postCouponRequest;
use App\Http\Requests\updateCouponRequest;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    // const MAX_RECORDS = 10;
    /**
     * List of Promotions
     */
    public function listPromotion()
    {
        $promotions = Promotion::paginate(5);
        return view('crudPromotion.coupon-list', ['promotions' => $promotions]);

        // return redirect("login")->withSuccess('You are not allowed to access');
    }

    /**
     * Create Promotion page
     */
    public function createPromotion()
    {
        return view('crudPromotion.coupon-create');
    }

    public function postPromotion(postCouponRequest $request)
    {
        try {
            $data = $request->validated();

            $promotion = Promotion::create([
                'name'          => $data['name'],
                'description'   => $data['description'] ?? null,
                'discount_rate' => $data['discount_rate'],
                'start_date'    => $data['start_date'],
                'end_date'      => $data['end_date'] ?? null,
            ]);

            return redirect()->route('admin.coupon')->with('success', 'Thêm mới khuyến mãi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tạo mới khuyến mãi thất bại!')->withInput();
        }

    }

    /**
     * Delete promotion by id
     */
    public function deletePromotion(Request $request)
    {
        $promotion_id = $request->get('id');

        try {
            $promotion = Promotion::findOrFail($promotion_id);
            $name      = $promotion->name;

            $promotion->delete();

            return redirect()->route("admin.coupon")
                ->with('success', "Chương trình khuyến mãi $name đã được xóa thành công!");
        } catch (ModelNotFoundException $e) {
            return redirect()->route("admin.coupon")
                ->with('error', "Không tìm thấy chương trình khuyến mãi với ID: $promotion_id");
        }
    }

    /**
     * Form update promotion page
     */
    public function updatePromotion(Request $request)
    {
        $id = $request->get('id');

        // Kiểm tra ID hợp lệ (phải là số nguyên dương)
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route("admin.coupon")
                ->with('error', 'Không tìm thấy trang.');
        }

        $promotion = Promotion::find($id);

        if (! $promotion) {
            return redirect()->route("admin.coupon")
                ->with('error', 'Không tìm thấy trang.');
        }
        // $promotion_id = $request->get('id');
        // $promotion    = Promotion::find($promotion_id);
        // if (! $promotion) {
        //     return redirect()->route("admin.coupon")
        //         ->with('error', "Không tìm thấy chương trình khuyến mãi với ID: $id");
        // }

        return view('crudPromotion.coupon-update', ['promotion' => $promotion]);
    }

    /**
     * Submit form update promotion
     */
    public function postUpdatePromotion(updateCouponRequest $request, $id)
    {
        // Lỗi id không hợp lệ
        // Bước 1: Validate ID là số nguyên dương
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            // Nếu ID không hợp lệ (ví dụ abc), trả về lỗi giống nhau
            return redirect()->route('admin.coupon')->with('error', 'Không tìm thấy trang.');
        }

        try {
            $input = $request->validated();

            $promotion = Promotion::findOrFail($id);

            $formTimestamp    = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('updated_at'))->toDateTimeString();
            $currentTimestamp = $promotion->updated_at->format('Y-m-d H:i:s');

            if ($formTimestamp !== $currentTimestamp) {
                return redirect()
                    ->route('coupon.updatePromotion', ['id' => $id])
                    ->with('error', 'Dữ liệu đã thay đổi ở một nơi khác. Vui lòng tải lại trang trước khi cập nhật.');
            }

            $promotion->name          = $input['name'];
            $promotion->description   = $input['description'];
            $promotion->start_date    = $input['start_date'];
            $promotion->end_date      = $input['end_date'];
            $promotion->discount_rate = $input['discount_rate'];

            $promotion->save();

            return redirect()->route('admin.coupon')->with('success', 'Sửa khuyến mãi thành công!');
        } catch (ModelNotFoundException $e) {
            // return abort(404, "Không tìm thấy trang");
            return redirect()->route("admin.coupon")
                ->with('error', "Không tìm thấy trang.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sửa khuyến mãi thất bại!')->withInput();
        }

    }

    public function searchPromotion(Request $request)
    {
        $search     = $request->input('search');
        $promotions = Promotion::where('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->paginate(5);
        return view('crudPromotion.coupon-list', ['promotions' => $promotions]);
    }
}
