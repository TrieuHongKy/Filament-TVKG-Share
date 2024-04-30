<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Major;
use Exception;

class MajorController extends Controller{

    use ApiResponseTrait;

    public function index(){
        try{
            $majors = Major::all();
            $data   = new MajorCollection($majors);

            return $this->responseWithResourceCollection($data);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }
}
