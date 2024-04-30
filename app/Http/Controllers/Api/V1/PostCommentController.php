<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Resources\PostCommentCollection;
use App\Http\Resources\PostCommentResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Post;
use App\Models\PostComment;
use App\Services\PostCommentService;

class PostCommentController extends Controller{

    use ApiResponseTrait;

    protected $postCommentService;

    public function __construct(PostCommentService $postCommentService){
        $this->postCommentService = $postCommentService;
    }

    public function index(){
        $postComments = $this->postCommentService->getAllPostComments();
        $data         = new PostCommentCollection($postComments);

        return $this->responseWithResourceCollection($data);
    }

    public function getCommentByPost($post_id){
        try{
            $post = Post::find($post_id);
            if (!$post){
                return response()->json(['message' => 'Bài viết không tồn tại.'], 404);
            }

            $comments = PostComment::where('post_id', $post_id)->get();
            //            dd($comments);
            $commentResource = PostCommentResource::collection($comments); // Transform collection into a resource

            return $this->responseWithResourceCollection($commentResource);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }

    public function getDependentComment($id){
        try{
            $comments = PostComment::where('parent_id', $id)->paginate();
            $data     = new PostCommentCollection($comments);

            //            dd($data);

            return $this->responseWithResourceCollection($data);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }

    //    public function show($id){
    //        try{
    //            $postComment = new PostCommentResource($this->postCommentService->getPostCommentById($id));
    //
    //            return $this->responseWithResource($postComment, 'Lấy thông tin bình luận thành công');
    //        }catch (\Exception $e){
    //            return $this->responseWithError($e->getMessage(), 404);
    //        }
    //    }

    public function store(PostCommentRequest $request){
        try{
            $postComment = new PostCommentResource($this->postCommentService->createPostComment($request->validated()));

            return $this->responseWithResource($postComment, 'Thêm bình luận thành công', 201);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    //    public function update(PostCommentRequest $request, $id){
    //        try{
    //            $data      = $request->validated();
    //            $postComment = new PostCommentResource($this->postCommentService->updatePostComment($id,
    //                $data));
    //
    //            return $this->responseWithResource($postComment, 'Cập nhật bình luận thành công');
    //        }catch (\Exception $e){
    //            return $this->responseWithError($e->getMessage(), 400);
    //        }
    //    }

    public function destroy($id){
        try{
            $this->postCommentService->deletePostComment($id);

            return $this->responseWithMessage('Xóa bình luận thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
