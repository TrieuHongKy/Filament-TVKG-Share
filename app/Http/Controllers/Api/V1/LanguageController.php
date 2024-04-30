<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\LanguageResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Http\Requests\LanguageRequest;
use App\Services\LanguageService;
use Exception;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    use ApiResponseTrait;

    protected $languageService;

    public function __construct(languageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * get all language
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $language = new LanguageCollection($this->languageService->getAllLanguage());

        return $this->responseWithResourceCollection($language);
    }

    /**
     * show language by ids
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $language = new LanguageResource($this->languageService->getLanguageById($id));

            return $this->responseWithResource($language, 'Hiển thị ngôn ngữ thành công');
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * store new language
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(LanguageRequest $request): JsonResponse
    {
        try {
            $language = new LanguageResource($this->languageService->createLanguage($request->all()));

            return $this->responseWithResource($language, 'Thêm ngôn ngữ thành công', 201);
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * update language
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(LanguageRequest $request, $id): JsonResponse
    {
        try {
            $language = new LanguageResource($this->languageService->updateLanguage($id, $request->validated()));
            return $this->responseWithResource($language, 'Cập nhật ngôn ngữ thành công.', 200);
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete language
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->languageService->deleteLanguage($id);

            return $this->responseWithMessage('Xoá ngôn ngữ thành công.');
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
