<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Resources\ApplyJobResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\ApplyJobService;

class ApplyJobController extends Controller
{
    use ApiResponseTrait;

    protected $applyJobService;

    public function __construct(ApplyJobService $applyJobService){
        $this->applyJobService = $applyJobService;
    }

    public function store(ApplyJobRequest $request){
        try{
            $applyJob = new ApplyJobResource($this->applyJobService->createApplyJob($request->validated()));

            return $this->responseWithResource($applyJob, 'Apply công việc thành công', 201);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * check Candidate already applied job
     *
     * @param mixed $request
     *
     * @return void
     */
    public function alreadyApplied(ApplyJobRequest $request){
        try{
            $alreadyApplied = $this->applyJobService->alreadyApplied($request->candidate_id,
                $request->job_id);

            $data = new ApplyJobResource($alreadyApplied);

            return $this->responseWithResource($data, 'Kiểm tra thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
