<?php

namespace App\Repositories;

use App\Interfaces\PostLikeRepositoryInterface;
use App\Models\PostLike;

class PostLikeRepository implements PostLikeRepositoryInterface{

    public function all(){
        return PostLike::all();
    }

    public function find($id){
        $postLike = PostLike::find($id);
        if (!$postLike){
            throw new \Exception('Lượt thích không tồn tại!');
        }

        return $postLike;
    }

    public function create($data){
        return PostLike::create($data);
    }

    public function delete($id){
        $postLike = $this->find($id);

        return $postLike->delete();
    }
}
