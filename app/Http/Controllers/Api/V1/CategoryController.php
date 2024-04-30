<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Response\ApiRespone;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller{

    use ApiResponseTrait;

    protected $categoryService;

    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    /**
     * get all categories
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $categories = new CategoryCollection($this->categoryService->getAllCategory());

        return $this->responseWithResourceCollection($categories);
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
            $category = new CategoryResource($this->categoryService->getCategoryById($id));

            return $this->responseWithResource($category, 'Lấy danh mục thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    public function getCategoryBySlug($slug)
    : JsonResponse{
        try{
            $category = new CategoryResource($this->categoryService->getCategoryBySlug($slug));

            return $this->responseWithResource($category, 'Lấy danh mục thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 500);
        }
    }

    public function getPostsInCategory($slug)
    : JsonResponse{
        try{
            $post = new PostCollection($this->categoryService->getPostsInCategory($slug));

            //            dd($post)
            return $this->responseWithResourceCollection($post, 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }

    /**
     * store new category
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(CategoryRequest $request)
    : JsonResponse{
        try{
            $category = new CategoryResource($this->categoryService->createCategory($request->all()));

            return $this->responseWithResource($category, 'Thêm danh mục thành công.', 201);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * update category
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    : JsonResponse{
        try{
            $category = new CategoryResource($this->categoryService->updateCategory($id,
                $request->validated()));

            return $this->responseWithResource($category, 'Cập nhật danh mục thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete category
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    : JsonResponse{
        try{
            $this->categoryService->deleteCategory($id);

            return $this->responseWithMessage('Xoá danh mục thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
