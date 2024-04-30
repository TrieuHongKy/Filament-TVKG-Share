<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ContactRequest extends FormRequest{

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
    public function rules(){
        if ($this->isMethod('POST')){
            return $this->createRules();
        }elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')){
            return $this->updateRules();
        }
    }

    public function createRules()
    : array{
        return [
            'user_id' => 'required',
            'name'    => 'required',
            'phone'   => 'required',
            'email'   => 'required',
            'address' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    : array{
        return [
            'user_id.required' => ':attribute không được bỏ trống',
            'name.required'    => ':attribute không được bỏ trống',
            'phone.required'   => ':attribute không được bỏ trống',
            'email.required'   => ':attribute không được bỏ trống',
            'address.required' => ':attribute không được bỏ trống',
            'content.required' => ':attribute không được bỏ trống',
        ];
    }

    public function attributes()
    : array{
        return [
            'user_id' => 'Mã người dùng',
            'name'    => 'Họ và tên',
            'phone'   => 'Số điện thoại',
            'email'   => 'Địa chỉ email',
            'address' => 'Địa chỉ',
            'content' => 'Nội dung',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Liên hệ không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
