<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class EducationRequest extends FormRequest{

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
            'education_name' => 'required|min:8|max:255|regex:/^[a-zA-ZÀ-Ỹà-ỹ\s]*$/',
            'description'    => 'nullable|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date',
            'major'          => 'nullable|string|max:255',
            'institution'    => 'required|string|max:255',
            'city'           => 'nullable|string|max:255',
            'country'        => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    : array{
        return [
            'education_name.required' => ':attribute không được để trống',
            'education_name.string'   => ':attribute phải là chuỗi',
            'education_name.min'      => ':attribute phải có ít nhất 8 ký tự',
            'education_name.max'      => ':attribute không được vượt quá 255 ký tự',
            'education_name.regex'    => ':attribute sai định dạng',
            'description.string'      => ':attribute phải là chuỗi',
            'start_date.required'     => ':attribute không được để trống',
            'start_date.date'         => ':attribute phải là ngày',
            'end_date.required'       => ':attribute không được để trống',
            'end_date.date'           => ':attribute phải là ngày',
            'major.string'            => ':attribute phải là chuỗi',
            'major.max'               => ':attribute không được vượt quá 255 ký tự',
            'institution.required'    => ':attribute không được để trống',
            'institution.string'      => ':attribute phải là chuỗi',
            'institution.max'         => ':attribute không được vượt quá 255 ký tự',
            'city.string'             => ':attribute phải là chuỗi',
            'city.max'                => ':attribute không được vượt quá 255 ký tự',
            'country.string'          => ':attribute phải là chuỗi',
            'country.max'             => ':attribute không được vượt quá 255 ký tự',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    : void{
        $this->merge([
            'start_date' => date('Y-m-d', strtotime($this->start_date)),
            'end_date'   => date('Y-m-d', strtotime($this->end_date)),
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    : array{
        return [
            'education_name' => 'Tên học vấn',
            'description'    => 'Mô tả',
            'start_date'     => 'Ngày bắt đầu',
            'end_date'       => 'Ngày kết thúc',
            'major'          => 'Chuyên ngành',
            'institution'    => 'Tổ chức giáo dục',
            'city'           => 'Thành phố',
            'country'        => 'Quốc gia',
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
