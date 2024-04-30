<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavedJobRequest;
use App\Http\Resources\SavedJobCollection;
use App\Http\Resources\SavedJobResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\SavedJob;
use App\Services\SavedJobService;

class SavedJobController extends Controller{

    use ApiResponseTrait;

    protected $savedJobService;
    private $savedJobRepository;

    public function __construct(SavedJobService $savedJobService){
        $this->savedJobService = $savedJobService;
    }

    public function index(){
        $savedJobs = $this->savedJobService->getAllSavedJobs();
        $data      = new SavedJobCollection($savedJobs);

        return $this->responseWithResourceCollection($data);
    }

    public function checkSavedJob($candidate_id, $job_id){
        try{
            $savedCheck = SavedJob::where('candidate_id', $candidate_id)
                                  ->where('job_id', $job_id)
                                  ->first();
            if (!$savedCheck){
                return $this->responseWithMessage(
                    'Người Dùng Chưa Lưu Công Việc Này', 205);
            }

            return $this->responseWithResource(new SavedJobResource($savedCheck),
                'Người Dùng Đã Lưu Công Việc Này');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }
    //    public function show($id){
    //        try{
    //            $postComment = new PostCommentResource($this->savedJobService->getPostCommentById($id));
    //
    //            return $this->responseWithResource($postComment, 'Lấy thông tin bình luận thành công');
    //        }catch (\Exception $e){
    //            return $this->responseWithError($e->getMessage(), 404);
    //        }
    //    }

    public function store(SavedJobRequest $request){
        try{
            $likeCheck = SavedJob::where('candidate_id', $request->candidate_id)
                                 ->where('job_id', $request->job_id)
                                 ->first();
            if ($likeCheck){
                $this->savedJobService->deleteSavedJob($likeCheck->id);

                return $this->responseWithMessage('Bỏ lưu công việc thành công');
            }else{
                $savedJob = new SavedJobResource($this->savedJobService->createSavedJob($request->validated()));

                return $this->responseWithResource($savedJob, 'Lưu công việc thành công', 201);
            }
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    public function destroy($id){
        try{
            $this->savedJobService->deleteSavedJob($id);

            return $this->responseWithMessage('Bỏ lưu công việc thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
