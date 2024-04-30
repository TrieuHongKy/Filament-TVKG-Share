<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;

class PostController extends Controller{

    use ApiResponseTrait;

    protected $postService;

    public function __construct(postService $postService){
        $this->postService = $postService;
    }

    /**
     * get all post
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $post = new PostCollection($this->postService->getAllPost());

        return $this->responseWithResourceCollection($post);
    }

    /**
     * show post by id
     *
     * @param mixed $slug
     *
     * @return JsonResponse
     */
    public function show($slug)
    : JsonResponse{
        try{
            $post = new PostResource($this->postService->getPostBySlug($slug));

            return $this->responseWithResource($post, 'Hiển thị bài viết thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * store new post
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(PostRequest $request)
    : JsonResponse{
        try{
            $image = $request->file('image');
            $request->validated();
            $title        = $request->title;
            $slug         = $request->slug;
            $content      = $request->input('content');
            $published_at = $request->published_at;
            $user_id      = $request->user_id;
            $category_id  = $request->category_id;

            $data = [
                'title'        => $title,
                'slug'         => $slug,
                'content'      => $content,
                'image'        => $image,
                'published_at' => $published_at,
                'category_id'  => $category_id,
                'user_id'      => $user_id
            ];
            //            $image = $request->file('image');
            //            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của file
            //
            //            // Di chuyển file vào thư mục posts trong thư mục public
            //            $image->move(public_path('posts'), $imageName);
            //
            //            // Thêm đường dẫn hình ảnh vào dữ liệu
            //            $data = $request->all();
            //            $data['image'] = asset(env('APP_URL').'/posts/'.$imageName);
            $post = new PostResource($this->postService->createPost($data));

            return $this->responseWithResource($post, 'Tạo bài viết thành công', 201);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    //     public function getPostByCategory($category_id): JsonResponse
    //     {
    //         try {
    //             $post = new PostCollection($this->postService->getPostByCategory($category_id));
    //
    //             return $this->responseWithResourceCollection($post);
    //         } catch (Exception $e) {
    //             return $this->responseWithError($e->getMessage(), 404);
    //         }
    //     }

    /**
     * update post
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(PostRequest $request, $id)
    : JsonResponse{
        try{
            $post = new PostResource($this->postService->updatePost($id, $request->validated()));

            return $this->responseWithResource($post, 'Cập nhật bài viết thành công.', 200);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete post
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($slug)
    : JsonResponse{
        try{
            $this->postService->deletePost($slug);

            return $this->responseWithMessage('Xoá bài viết thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    // public function getPostByCategory($id): JsonResponse
    // {
    //     try {
    //         $post = new PostCollection($this->postService->getPostByCategory($id));

    //         return $this->responseWithResourceCollection($post);
    //     } catch (Exception $e) {
    //         return $this->responseWithError($e->getMessage(), 404);
    //     }
    // }

    // public function getPostByUser($id): JsonResponse
    // {
    //     try {
    //         $post = new PostCollection($this->postService->getPostByUser($id));

    //         return $this->responseWithResourceCollection($post);
    //     } catch (Exception $e) {
    //         return $this->responseWithError($e->getMessage(), 404);
    //     }
    // }

    public function getPostBySlug($slug)
    : JsonResponse{
        try{
            $post = new PostResource($this->postService->getPostBySlug($slug));

            return $this->responseWithResource($post);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    public function showBySlug($slug)
    : JsonResponse{
        try{
            $post = new PostResource($this->postService->getPostBySlug($slug));

            return $this->responseWithResource($post);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }
}
