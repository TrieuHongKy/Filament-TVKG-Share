<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobTypeCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\JobType;
use Exception;

class JobTypeController extends Controller{

    use ApiResponseTrait;

    public function index(){
        try{
            $jobTypes = JobType::all();
            $data     = new JobTypeCollection($jobTypes);

            return $this->responseWithResourceCollection($data);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }
}
