<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Experience;

class ExperienceController extends Controller{

    use ApiResponseTrait;

    public function index(){
        $experinces = ExperienceResource::collection(Experience::all());

        return $this->responseWithResourceCollection($experinces);
    }
}
