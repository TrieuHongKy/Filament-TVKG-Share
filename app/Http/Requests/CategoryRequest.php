<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class CategoryRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->updateRules();
        }
    }
    public function createRules(): array
    {
        return [
            'name'        => 'required|string|regex:/^[a-zA-ZÀ-Ỹà-ỹ\s]*$/|max:255|unique:categories,name',
            'slug'        => 'required',
            'description' => 'string',
            'parent_id'   => 'numeric|exists:categories,id',
            'image'       => 'nullable|image|max:1024',
            'status'      => 'required|boolean',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name'        => 'required|string|regex:/^[a-zA-ZÀ-Ỹà-ỹ\s]*$/|max:255|unique:categories,name,' . $this->id,
            'slug'        => 'required',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|numeric|exists:categories,id',
            'image'       => 'nullable|image|max:1024',
            'status'      => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => ':attribute không được bỏ trống',
            'name.string'       => ':attribute phải là kiểu chuỗi',
            'name.unique'       => ':attribute đã tồn tại',
            'name.regex'        => ':attribute chỉ được nhập chữ',
            'name.max'          => ':attribute vượt quá số kí tự',
            'slug.required'     => ':attribute không được bỏ trống',
            'parent_id.exists'  => ':attribute không tồn tại',
            'parent_id.numeric' => ':attribute phải là một số nguyên',
//            'image.image'       => ':attribute không đúng định dạng',
//            'image.max'         => ':attribute vượt quá kích thước tối đa cho phép',
            'status.required'   => ':attribute không được bỏ trống',
            'status.boolean'    => ':attribute không hợp lệ',
        ];
    }
    public function attributes(): array
    {
        return [
            'name'        => 'Tên danh mục',
            'slug'        => 'Slug',
            'description' => 'Mô tả',
            'parent_id'   => 'Parent ID',
            'image'       => 'Hình ảnh',
            'status'      => 'Trạng thái',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Danh mục không hợp lệ.',
                'errors' => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
