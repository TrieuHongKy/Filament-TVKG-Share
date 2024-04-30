<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateRequest;
use App\Http\Resources\CandidateCollection;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\SavedJobCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\CandidateService;

class CandidateController extends Controller{

    use ApiResponseTrait;

    protected $candidateService;

    public function __construct(CandidateService $candidateService){
        $this->candidateService = $candidateService;
        // $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $candidates = $this->candidateService->getAllCandidates();
        $data       = new CandidateCollection($candidates);

        return $this->responseWithResourceCollection($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidateRequest $request){
        try{
            $candidate = $this->candidateService->createCandidate($request->validated());
            $data      = new CandidateResource($candidate);

            return $this->responseWithResource($data, 'Lưu thông tin ứng viên thành công.', 201);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        try{
            $candidate = $this->candidateService->getCandidateById($id);
            $data      = new CandidateResource($candidate);

            return $this->responseWithResource($data, 'Lấy thông tin ứng viên thành công.', 200);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    public function showSavedJob(string $id){
        try{
            $jobs = new SavedJobCollection($this->candidateService->showSavedJob($id));

            return $this->responseWithResource(
                $jobs,
                'Hiển thị danh sách công việc đã lưu thành công.'
            );
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CandidateRequest $request, string $id){
        try{
            $candidate = $this->candidateService->updateCandidate($id, $request->validated());
            $data      = new CandidateResource($candidate);

            return $this->responseWithResource($data,
                'Cập nhật thông tin ứng viên thành công.', 200);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        try{
            $candidate = $this->candidateService->deleteCandidate($id);

            return $this->apiResponse([
                'success' => TRUE,
                'message' => 'Xoá thông tin ứng viên thành công.',
            ], 200);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }
}
