<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\SkillCollection;
use App\Http\Resources\SkillResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Response\ApiRespone;
use App\Services\SkillService;
use Exception;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller{

    use ApiResponseTrait;

    protected $skillService;

    public function __construct(SkillService $skillService){
        $this->skillService = $skillService;
    }

    /**
     * get all skill
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $skills = new SkillCollection($this->skillService->getAllSkill());

        return $this->responseWithResourceCollection($skills);
    }

    /**
     * show category by id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id)
    : JsonResponse{
        try{
            $skill = new SkillResource($this->skillService->getSkillById($id));

            return $this->responseWithResource($skill, 'Lấy kỹ năng thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * store new skill
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(SkillRequest $request)
    : JsonResponse{
        try{
            $skill = new SkillResource($this->skillService->createSkill($request->all()));

            return $this->responseWithResource($skill, 'Thêm kỹ năng thành công.', 201);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * update skill
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(SkillRequest $request, $id)
    : JsonResponse{
        try{
            $skill = new SkillResource($this->skillService->updateSkill(
                $id,
                $request->validated()
            ));

            return $this->responseWithResource($skill, 'Cập nhật kỹ năng thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete skill
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    : JsonResponse{
        try{
            $this->skillService->deleteSkill($id);

            return $this->responseWithMessage('Xoá kỹ năng thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
