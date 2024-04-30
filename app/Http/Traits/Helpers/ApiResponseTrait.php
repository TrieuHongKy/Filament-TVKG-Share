<?php

namespace App\Http\Traits\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait{

    protected function responseWithResource(
        JsonResource $resource,
        $message = NULL,
        $statusCode = 200,
        $headers = []){
        return $this->apiResponse(
            [
                'success' => TRUE,
                'message' => $message,
                'result'  => $resource
            ],
            $statusCode,
            $headers
        );
    }

    protected function responseWithResourceCollection(
        ResourceCollection $resourceCollection,
        $statusCode = 200,
        $headers = []){
        return $this->apiResponse(
            [
                'success' => TRUE,
                'result'  => $resourceCollection->response()->getData()
            ],
            $statusCode,
            $headers
        );
    }

    protected function responseWithMessage($message, $statusCode = 200, $headers = []){
        return $this->apiResponse(
            [
                'success' => TRUE,
                'message' => $message
            ],
            $statusCode,
            $headers
        );
    }

    protected function responseWithError($message, $statusCode = 500, $headers = []){
        return $this->apiResponse(
            [
                'success' => FALSE,
                'message' => $message
            ],
            $statusCode,
            $headers
        );
    }

    protected function apiResponse($data = [], $statusCode = 200, $headers = []){
        return response()->json(
            $data,
            $statusCode,
            $headers
        );
    }
}
