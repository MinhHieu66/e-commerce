<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductItem extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'SKU'          => 'required|alpha_num|unique:product_items,SKU',
            'price'        => 'required|numeric|min:1',
            'qty-in-stock' => 'required|integer|min:1',
            'image'        => 'required|image|mimes:jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Vui lòng nhập tên sản phẩm.',
            'name.string'           => 'Tên sản phẩm phải là chuỗi ký tự.',
            'name.max'              => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'SKU.required'          => 'Vui lòng nhập mã SKU.',
            'SKU.alpha_num'         => 'SKU chỉ được chứa chữ cái và số.',
            'SKU.unique'            => 'SKU đã tồn tại trong hệ thống.',

            'price.required'        => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric'         => 'Giá sản phẩm phải là số.',
            'price.min'             => 'Giá sản phẩm phải lớn hơn 0.',

            'qty-in-stock.required' => 'Vui lòng nhập số lượng tồn kho.',
            'qty-in-stock.integer'  => 'Số lượng tồn kho phải là số nguyên.',
            'qty-in-stock.min'      => 'Số lượng tồn kho phải lớn hơn 0.',

            'image.required'        => 'Vui lòng chọn hình ảnh sản phẩm.',
            'image.image'           => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'           => 'Hình ảnh phải có định dạng jpg hoặc png.',
            'image.max'             => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
    }
}
