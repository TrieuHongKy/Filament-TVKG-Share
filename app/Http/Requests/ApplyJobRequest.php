<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ApplyJobRequest extends FormRequest{

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules()
    : array{
        return [
            'candidate_id'      => 'required|integer|exists:candidates,id',
            'job_id'            => 'required|integer|exists:jobs,id',
            'status' => 'nullable|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    : array{
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    : void{
        $this->merge([
            //
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    : array{
        return [
            'candidate_id'  => 'Mã ứng viên',
            'job_id'        => 'Mã công việc',
            'status'        => 'Trạng thái'
        ];
    }

    /**
     * Get the response for a forbidden operation.
     */
    public function forbiddenResponse()
    : JsonResponse{
        return response()->json([
            'message' => 'Bạn không có quyền thực hiện hành động này!',
        ], 403);
    }

    /**
     * Get the response for a validation failure.
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    : JsonResponse{
        $response = response()->json([
            'message' => 'Dữ liệu không hợp lệ!',
            'errors'  => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
