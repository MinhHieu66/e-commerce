<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address',
            'phone_number' => [
                'required',
                'regex:/^(0|\+84)[0-9]{8,10}$/',
            ],
            'password' => 'required|string|min:6|confirmed',
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập họ và tên.',
            'name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'email_address.required' => 'Bạn chưa nhập email.',
            'email_address.email' => 'Email chưa đúng định dạng. Vd: giang123@gmail.com.',
            'email_address.unique' => 'Email đã được sử dụng. Vui lòng nhập email khác.',
            'phone_number.required' => 'Bạn chưa nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại phải bắt đầu bằng số 0 hoặc +84 và chỉ chứa các chữ số.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ];
    }
}
