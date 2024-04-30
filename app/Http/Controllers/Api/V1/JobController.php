<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\JobService;
use Exception;
use Illuminate\Http\JsonResponse;

// use App\Http\Requests\JobRequest;

class JobController extends Controller{

    use ApiResponseTrait;

    protected $jobService;

    public function __construct(jobService $jobService){
        $this->jobService = $jobService;
    }

    /**
     * get all job
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $job = new JobCollection($this->jobService->getAllJob());

        return $this->responseWithResourceCollection($job);
    }

    /**
     * show job by id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id)
    : JsonResponse{
        try{
            $job = new JobResource($this->jobService->getJobById($id));

            return $this->responseWithResource($job, 'Hiển thị công việc thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }

    public function search(){
        try{
            $keyword    = request()->keyword;
            $province   = request()->province;
            $category   = request()->category;
            $salary     = request()->salary;
            $major      = request()->major;
            $jobType    = request()->jobType;
            $jobStatus  = request()->job_status;
            $attribute  = request()->attribute;
            $salary     = request()->salary;
            $experience = request()->experience;
            $sort       = request()->sort;
            $paginate   = request()->paginate;

            $job = new JobCollection($this->jobService->searchJob(
                $keyword,
                $province,
                $category,
                $major,
                $salary,
                $jobType,
                $jobStatus,
                $attribute,
                $experience,
                $sort,
                $paginate
            ));

            return $this->responseWithResourceCollection($job);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }
}
