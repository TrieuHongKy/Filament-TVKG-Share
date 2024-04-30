<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SkillRequest extends FormRequest{

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
            'name' => 'required|string|regex:/^[a-zA-ZÀ-Ỹà-ỹ\s]*$/|max:255|unique:skills,name',
            'slug' => 'required',
        ];
    }

    public function updateRules()
    : array{
        return [
            'name' => 'required|string|regex:/^[a-zA-ZÀ-Ỹà-ỹ\s]*$/|max:255|unique:skills,name,' . $this->id,
            'slug' => 'required',
        ];
    }

    public function messages()
    : array{
        return [
            'name.required' => 'Vui lòng nhập :attribute',
            'name.string'   => ':attribute phải là kiểu chuỗi',
            'name.regex'    => ':attribute chỉ được nhập chữ',
            'name.unique'   => ':attribute đã tồn tại',
            'name.max'      => ':attribute vượt quá số kí tự',
            'slug.required' => ':attribute không được bỏ trống',
        ];
    }

    public function attributes()
    : array{
        return [
            'name' => 'Kỹ năng',
            'slug' => 'Slug',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Kỹ năng không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
