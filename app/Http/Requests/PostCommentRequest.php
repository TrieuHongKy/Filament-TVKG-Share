<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class PostCommentRequest extends FormRequest{

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
        }
    }

    public function createRules()
    : array{
        return [
            'user_id'   => 'required|numeric|exists:users,id',
            'post_id'   => 'required|numeric|exists:posts,id',
            'parent_id' => 'nullable|numeric|exists:post_comments,id',
            'comment'   => 'required|string|max:500',
        ];
    }

    //    public function updateRules()
    //    : array{
    //        return [
    //            'user_id' => 'required|numeric|exists:users,id,' . $this->id,
    //            'post_id' => 'required|numeric|exists:posts,id,' . $this->id,
    //            'parent_id' => 'nullable|numeric|exists:post_comments,id,' . $this->id,
    //            'comment' => 'required|string|max:500',
    //        ];
    //    }

    public function messages()
    : array{
        return [
            'user_id.required'  => ':attribute là bắt buộc.',
            'user_id.numeric'   => ':attribute phải là số.',
            'user_id.exists'    => ':attribute không tồn tại.',
            'post_id.required'  => ':attribute là bắt buộc.',
            'post_id.numeric'   => ':attribute phải là số.',
            'post_id.exists'    => ':attribute không tồn tại.',
            'parent_id.numeric' => ':attribute cha phải là số.',
            'parent_id.exists'  => ':attribute cha không tồn tại.',
            'comment.required'  => ':attribute là bắt buộc.',
            'comment.string'    => ':attribute phải là chuỗi.',
            'comment.max'       => ':attribute không được vượt quá 500 ký tự.',
        ];
    }

    public function attributes()
    : array{
        return [
            'user_id'   => 'ID người dùng',
            'post_id'   => 'ID bài viết',
            'parent_id' => 'ID bình luận',
            'comment'   => 'Nội dung bình luận',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Bình luận không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
