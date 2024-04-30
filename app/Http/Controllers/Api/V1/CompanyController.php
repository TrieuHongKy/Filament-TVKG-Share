<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyWithJobCollection;
use App\Http\Resources\JobCollection;
use App\Http\Resources\PostCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\JsonResponse;

// use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller{

    use ApiResponseTrait;

    protected $companyService;

    public function __construct(companyService $companyService){
        $this->companyService = $companyService;
    }

    /**
     * get all company
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $company = new companyCollection($this->companyService->getAllCompany());

        return $this->responseWithResourceCollection($company);
    }

    /**
     * show company by slug
     *
     * @param mixed $slug
     *
     * @return JsonResponse
     */
    public function show($slug)
    : JsonResponse{
        try{
            $company = new CompanyResource($this->companyService->getCompany($slug));

            return $this->responseWithResource($company, 'Hiển thị thông tin công ty thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    public function showCompanyByUserId($id)
    : JsonResponse{
        try{
            $company = new CompanyResource($this->companyService->getCompanyByUserId($id));

            return $this->responseWithResource($company, 'Hiển thị thông tin công ty thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * show job by company
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function showJobs($id)
    : JsonResponse{
        try{
            $company = new JobCollection($this->companyService->getJob($id));

            return $this->responseWithResource(
                $company,
                'Hiển thị danh sách công việc thành công.'
            );
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * show post by company
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function showPosts($id)
    : JsonResponse{
        try{
            $company = new PostCollection($this->companyService->getPost($id));

            return $this->responseWithResource(
                $company,
                'Hiển thị danh sách bài viết thành công.'
            );
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    public function showCompanyWithJob(){
        try{
            $company = new CompanyWithJobCollection($this->companyService->getCompanyWithJob());

            return $this->responseWithResourceCollection($company);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }
}
