<?php

namespace App\Services;

use App\Interfaces\PostLikeRepositoryInterface;

class PostLikeService{

    protected $postLikeRepository;

    public function __construct(PostLikeRepositoryInterface $postLikeRepository){
        $this->postLikeRepository = $postLikeRepository;
    }

    public function getAllPostLikes(){
        return $this->postLikeRepository->all();
    }

    public function createPostLike($data){
        return $this->postLikeRepository->create($data);
    }

    public function deletePostLike($id){
        return $this->postLikeRepository->delete($id);
    }
}
