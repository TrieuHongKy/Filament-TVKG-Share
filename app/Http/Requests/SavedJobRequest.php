<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SavedJobRequest extends FormRequest{

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
            'candidate_id' => 'required|numeric|exists:candidates,id',
            'job_id'       => 'required|numeric|exists:jobs,id',
        ];
    }

    //    public function updateRules()
    //    : array{
    //        return [
    //            'candidate_id' => 'required|numeric|exists:users,id,' . $this->id,
    //            'post_id' => 'required|numeric|exists:posts,id,' . $this->id,
    //            'parent_id' => 'nullable|numeric|exists:post_comments,id,' . $this->id,
    //            'comment' => 'required|string|max:500',
    //        ];
    //    }

    public function messages()
    : array{
        return [
            'candidate_id.required' => ':attribute là bắt buộc.',
            'candidate_id.numeric'  => ':attribute phải là số.',
            'candidate_id.exists'   => ':attribute không tồn tại.',
            'job_id.required'       => ':attribute là bắt buộc.',
            'job_id.numeric'        => ':attribute phải là số.',
            'job_id.exists'         => ':attribute không tồn tại.',
        ];
    }

    public function attributes()
    : array{
        return [
            'candidate_id' => 'ID ứng viên',
            'job_id'       => 'ID công việc'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = new JsonResponse([
            'meta' => [
                'message' => 'Lưu công việc không hợp lệ.',
                'errors'  => $validator->errors()
            ]
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
