<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Resources\EducationCollection;
use App\Http\Resources\EducationResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\EducationService;

class EducationController extends Controller{

    use ApiResponseTrait;

    protected $educationService;

    public function __construct(EducationService $educationService){
        $this->educationService = $educationService;
    }

    public function index(){
        $educations = $this->educationService->getAllEducations();
        $data       = new EducationCollection($educations);

        return $this->responseWithResourceCollection($data);
    }

    public function show($id){
        try{
            $education = new EducationResource($this->educationService->getEducationById($id));

            return $this->responseWithResource($education, 'Lấy thông tin học vấn thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    public function store(EducationRequest $request){
        try{
            $education = new EducationResource($this->educationService->createEducation($request->validated()));

            return $this->responseWithResource($education, 'Thêm học vấn thành công', 201);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    public function update(EducationRequest $request, $id){
        try{
            $data      = $request->validated();
            $education = new EducationResource($this->educationService->updateEducation($id,
                $data));

            return $this->responseWithResource($education, 'Cập nhật học vấn thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    public function destroy($id){
        try{
            $this->educationService->deleteEducation($id);

            return $this->responseWithMessage('Xóa học vấn thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
