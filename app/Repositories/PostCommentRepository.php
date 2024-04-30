<?php

namespace App\Repositories;

use App\Interfaces\PostCommentRepositoryInterface;
use App\Models\PostComment;

class PostCommentRepository implements PostCommentRepositoryInterface{

    public function all(){
        return PostComment::all();
    }

    public function find($id){
        $postComment = PostComment::find($id);
        if (!$postComment){
            throw new \Exception('Bình luận không tồn tại!');
        }

        return $postComment;
    }

    public function create($data){
        return PostComment::create($data);
    }

    //    public function update($id, $data){
    //        $postComment = $this->find($id);
    //        $postComment->update($data);
    //
    //        return $postComment;
    //    }

    public function delete($id){
        $postComment = $this->find($id);

        return $postComment->delete();
    }
}
