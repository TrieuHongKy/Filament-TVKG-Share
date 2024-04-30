<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResumeCollection;
use App\Http\Resources\ResumeResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Http\Requests\ResumeRequest;
use App\Response\ApiRespone;
use App\Services\ResumeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResumeController extends Controller{

    use ApiResponseTrait;

    protected $resumeService;

    public function __construct(ResumeService $resumeService){
        $this->resumeService = $resumeService;
    }

    /**
     * get all resumes
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $resumes = new ResumeCollection($this->resumeService->getAllResume());

        return $this->responseWithResourceCollection($resumes);
    }

    /**
     * show resume by id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id)
    : JsonResponse{
        try{
            $resume = new ResumeResource($this->resumeService->getResumeById($id));

            return $this->responseWithResource($resume, 'Lấy sơ yếu lý lịch thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * store new resume
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(ResumeRequest $request)
    : JsonResponse{
        try{
            $resume = new ResumeResource($this->resumeService->createResume($request->all()));

            return $this->responseWithResource($resume, 'Tạo sơ yếu lý lịch thành công.', 201);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * update resume
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(ResumeRequest $request, $id)
    : JsonResponse{
        try{
            $resume = new ResumeResource($this->resumeService->updateResume($id,
                $request->validated()));

            return $this->responseWithResource($resume, 'Cập nhật sơ yếu lý lịch thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete resume
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    : JsonResponse{
        try{
            $this->resumeService->deleteResume($id);

            return $this->responseWithMessage('Xoá sơ yếu lý lịch thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
