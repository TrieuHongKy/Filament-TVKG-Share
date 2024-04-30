<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class CandidateRequest extends FormRequest{

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
        return [
            'user_id'      => 'required|integer|exists:users,id',
            'major_id'     => 'nullable|integer|exists:majors,id',
            'major_name'   => 'nullable|string',
            'resume_id'    => 'nullable|integer|exists:resumes,id',
            'languages'    => 'nullable|array',
            'skills'       => 'nullable|array',
            'skills.*'     => 'nullable|integer|exists:skills,id',
            'educations'   => 'nullable|array',
            'educations.*' => 'nullable|integer|exists:educations,id',
            'province_id'  => 'nullable|integer|exists:provinces,id',
            'district_id'  => 'nullable|integer|exists:districts,id',
            'ward_id'      => 'nullable|integer|exists:wards,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    : array{
        return [
            'user_id.required'     => 'Vui lòng nhập :attribute!',
            'user_id.integer'      => ':attribute phải là số nguyên!',
            'user_id.exists'       => ':attribute không tồn tại!',
            'major_id.exists'      => ':attribute không tồn tại!',
            'major_id.integer'     => ':attribute phải là số nguyên!',
            'major_name.string'    => ':attribute phải là chuỗi!',
            'resume_id.exists'     => ':attribute không tồn tại!',
            'resume_id.integer'    => ':attribute phải là số nguyên!',
            'languages.array'      => ':attribute phải là mảng!',
            'skills.array'         => ':attribute phải là mảng!',
            'skills.*.integer'     => ':attribute phải là số nguyên!',
            'skills.*.exists'      => ':attribute không tồn tại!',
            'educations.array'     => ':attribute phải là mảng!',
            'educations.*.integer' => ':attribute phải là số nguyên!',
            'educations.*.exists'  => ':attribute không tồn tại!',
            'province_id.integer'  => ':attribute phải là số nguyên!',
            'province_id.exists'   => ':attribute không tồn tại!',
            'district_id.integer'  => ':attribute phải là số nguyên!',
            'district_id.exists'   => ':attribute không tồn tại!',
            'ward_id.integer'      => ':attribute phải là số nguyên!',
            'ward_id.exists'       => ':attribute không tồn tại!',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    : array{
        return [
            'user_id'     => 'ID người dùng',
            'major_id'    => 'ID chuyên ngành',
            'major_name'  => 'Tên chuyên ngành',
            'resume_id'   => 'ID hồ sơ',
            'languages'   => 'Ngôn ngữ',
            'skills'      => 'Kỹ năng',
            'educations'  => 'Học vấn',
            'province_id' => 'ID tỉnh',
            'district_id' => 'ID quận',
            'ward_id'     => 'ID phường',
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
