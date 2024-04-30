<?php

namespace App\Interfaces;

interface PostLikeRepositoryInterface{

    public function all();

    public function find($id);

    //    public function findByUserAndPost($userId, $postId);

    public function create($data);

    //    public function update($id, $data);

    public function delete($id);
}
