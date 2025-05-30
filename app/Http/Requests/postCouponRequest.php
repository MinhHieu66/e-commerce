<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class postCouponRequest extends FormRequest
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
            'name'          => 'required|string|max:255|unique:promotions,name',
            'description'   => 'nullable|string|max:500',
            'discount_rate' => 'required|numeric|gt:0|lt:100',
            'start_date'    => 'required|date',
            'end_date'      => 'nullable|date|after:start_date',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'          => 'Bạn chưa nhập tên mã khuyến mãi',
            'name.string'            => 'Tên mã khuyến mãi không hợp lệ.',
            'name.max'               => 'Tên mã khuyến mãi không được vượt quá 255 ký tự.',
            'discount_rate.required' => 'Bạn chưa nhập tỷ lệ chiết khấu.',             
            'discount_rate.numeric'  => 'Tỷ lệ chiết khấu phải là một số.',
            'discount_rate.gt'       => 'Tỷ lệ chiết khấu phải lớn hơn 0.',
            'discount_rate.lt'       => 'Tỷ lệ chiết khấu phải nhỏ hơn 100.',
            'start_date.required'    => 'Bạn chưa nhập ngày bắt đầu.',
            'start_date.date'        => 'Ngày bắt đầu không đúng định dạng ngày.',
            'end_date.date'          => 'Ngày kết thúc không đúng định dạng ngày.',
            'end_date.after'         => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ];
    }
}