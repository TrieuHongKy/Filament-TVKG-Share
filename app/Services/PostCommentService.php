<?php

namespace App\Services;

use App\Interfaces\PostCommentRepositoryInterface;

class PostCommentService{

    protected $postCommentRepository;

    public function __construct(PostCommentRepositoryInterface $postCommentRepository){
        $this->postCommentRepository = $postCommentRepository;
    }

    public function getAllPostComments(){
        return $this->postCommentRepository->all();
    }

    //    public function getPostCommentByPostId($id){
    //        return $this->postCommentRepository->find($id);
    //    }

    public function createPostComment($data){
        return $this->postCommentRepository->create($data);
    }

    //    public function updatePostComment($id, $data){
    //        return $this->postCommentRepository->update($id, $data);
    //    }

    public function deletePostComment($id){
        return $this->postCommentRepository->delete($id);
    }
}
