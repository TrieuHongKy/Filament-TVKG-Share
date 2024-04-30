<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostLikeRequest;
use App\Http\Resources\PostLikeCollection;
use App\Http\Resources\PostLikeResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\PostLike;
use App\Services\PostLikeService;

class PostLikeController extends Controller{

    use ApiResponseTrait;

    protected $postLikeService;
    private $postLikeRepository;

    public function __construct(PostLikeService $postLikeService){
        $this->postLikeService = $postLikeService;
    }

    public function index(){
        $postLikes = $this->postLikeService->getAllPostLikes();
        $data      = new PostLikeCollection($postLikes);

        return $this->responseWithResourceCollection($data);
    }

    public function checkLikePost($user_id, $post_id){
        try{
            $likeCheck = PostLike::where('user_id', $user_id)
                                 ->where('post_id', $post_id)
                                 ->first();
            if (!$likeCheck){
                //                throw new Exception('Người dùng này chưa thích bài viết này!');
                return $this->responseWithMessage(
                    'Người Dùng Nãy Chưa Thích Bài Viết', 204);
            }

            return $this->responseWithResource(new PostLikeResource($likeCheck),
                'Người Dùng Nãy Đã Thích Bài Viết');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }
    //    public function show($id){
    //        try{
    //            $postComment = new PostCommentResource($this->postLikeService->getPostCommentById($id));
    //
    //            return $this->responseWithResource($postComment, 'Lấy thông tin bình luận thành công');
    //        }catch (\Exception $e){
    //            return $this->responseWithError($e->getMessage(), 404);
    //        }
    //    }

    public function store(PostLikeRequest $request){
        try{
            $likeCheck = PostLike::where('user_id', $request->user_id)
                                 ->where('post_id', $request->post_id)
                                 ->first();
            if ($likeCheck){
                $this->postLikeService->deletePostLike($likeCheck->id);

                return $this->responseWithMessage('Bỏ thích thành công');
            }else{
                $postLike = new PostLikeResource($this->postLikeService->createPostLike($request->validated()));

                return $this->responseWithResource($postLike, 'Thích bài viết thành công', 201);
            }
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    public function destroy($id){
        try{
            $this->postLikeService->deletePostLike($id);

            return $this->responseWithMessage('Bỏ thích thành công');
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
