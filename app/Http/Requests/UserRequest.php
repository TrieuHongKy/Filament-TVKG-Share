<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    : bool{
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    : array{
        if ($this->route()->named('login')){
            return [
                'email'    => 'required|email',
                'password' => 'required',
            ];
        }

        if ($this->route()->named('register')){
            return [
                'name'      => 'required|string|max:255',
                'email'     => 'required|email|unique:users,email,' . $this->route()
                                                                           ->parameter('id'),
                'password'  => 'required|string|min:8|confirmed',
                'user_type' => 'in:candidate,company'
            ];
        }

        if ($this->route()->named('update-user')){
            return [
                'name'    => 'required|string|max:255',
                'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'phone'   => 'nullable|numeric',
                'address' => 'nullable|string'
            ];
        }

        if ($this->route()->named('update-image')){
            return [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    : array{
        return [
            'name.required'      => ':attribute không được để trống!',
            'email.required'     => ':attribute không được để trống!',
            'email.email'        => ':attribute sai định dạng!',
            'email.unique'       => ':attribute đã tồn tại!',
            'password.required'  => ':attribute không được để trống!',
            'password.min'       => ':attribute phải có ít nhất 8 ký tự!',
            'password.confirmed' => ':attribute không khớp!',
            'user_type.required' => ':attribute không được để trống!',
            'user_type.in'       => ':attribute không hợp lệ!',
            'image.image'        => ':attribute không đúng định dạng!',
            'image.mimes'        => ':attribute không đúng định dạng!',
            'image.max'          => ':attribute không được quá 2MB!',
            'phone.numeric'      => ':attribute phải là số!',
            'address.string'     => ':attribute phải là chuỗi!',
            'address.max'        => ':attribute không được quá 255 ký tự!',
            'phone.max'          => ':attribute không được quá 11 ký tự!',
            'phone.min'          => ':attribute không được ít hơn 10 ký tự!',
        ];
    }

    /**
     * Get the custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes()
    : array{
        return [
            'name'      => 'Tên người dùng',
            'email'     => 'Email',
            'password'  => 'Mật khẩu',
            'user_type' => 'Loại người dùng',
            'image'     => 'Ảnh đại diện',
            'phone'     => 'Số điện thoại',
            'address'   => 'Địa chỉ'
        ];
    }
}
