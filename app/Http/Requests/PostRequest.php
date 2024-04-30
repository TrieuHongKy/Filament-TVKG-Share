<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class PostRequest extends FormRequest
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
            'title'        => 'required|string|max:500|unique:posts,title',
            'slug'         => 'required',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'is_published'   => 'nullable|boolean',
            'published_at' => 'required|date',
            'user_id'      => 'required|numeric|exists:users,id',
            'category_id'  => 'required|numeric|exists:categories,id',
        ];
    }

    public function updateRules(): array
    {
        return [
            'title'        => 'required|string|max:500|unique:posts,title,' . $this->id,
            'slug'         => 'required',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'is_published'   => 'required|boolean',
            'published_at' => 'required|date',
            'user_id'      => 'required|numeric|exists:users,id',
            'category_id'  => 'required|numeric|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Vui lòng nhập :attribute',
            'title.string'          => ':attribute phải là chuỗi',
            'title.max'             => ':attribute tối đa là 500 kí tự',
            'title.unique'          => ':attribute đã tồn tại',
            'slug.required'         => 'Vui lòng điền :attribute',
            'content.required'      => 'Vui lòng nhập :attribute',
            'content.string'        => ':attribute phải là kiểu chuỗi',
            // 'is_published.required'  => ':attribute không được bỏ trống',
            // 'is_published.boolean'  => ':attribute không hợp lệ',
            'published_at.required' => 'Vui lòng nhập :attribute',
            'published_at.date'     => ':attribute không đúng định dạng',
            'user_id.required'      => 'Vui lòng nhập :attribute',
            'user_id.exists'        => 'Không tìm thấy :attribute',
            'user_id.numeric'       => ':attribute không hợp lệ',
            'category_id.required'  => 'Vui lòng nhập :attribute',
            'category_id.exists'    => 'Không tìm thấy :attribute',
            'category_id.numeric'   => ':attribute không hợp lệ',
            'image.image'           => 'File phải là :attribute',
            'image.max'             => ':attribute vượt quá kích thước tối đa cho phép',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'        => 'Tên bài viết',
            'slug'         => 'Slug',
            'content'      => 'Nội dung',
            'image'        => 'Hình ảnh',
            // 'is_published'   => 'Trạng thái',
            'published_at' => 'Thời gian đăng tải',
            'user_id'      => 'Mã người dùng',
            'category_id'  => 'Mã danh mục',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Bài viết không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
