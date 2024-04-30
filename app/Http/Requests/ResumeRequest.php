<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ResumeRequest extends FormRequest{

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
            'name'        => 'required|string|max:255|unique:resumes,name',
            'description' => 'nullable',
        ];
    }

    public function updateRules()
    : array{
        return [
            'name'        => 'required|string|max:255|unique:resumes,name,' . $this->id,
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    : array{
        return [
            'name.required'      => 'Tên :attribute không được bỏ trống',
            'name.string'        => ':attribute không hợp lệ',
            'name.unique'        => ':attribute đã tồn tại',
            'name.max'           => ':attribute vượt quá số kí tự',
            'description.string' => ':attribute không hợp lệ',
        ];
    }

    public function attributes()
    : array{
        return [
            'name'        => 'Sơ yếu lý lịch',
            'description' => 'Mô tả',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Sơ yếu lý lịch không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
