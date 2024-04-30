<?php

namespace App\Interfaces;

interface PostRepositoryInterface{

    public function all();

    public function find($slug);

    //    public function getPostByCategory($slug);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function findBy($field, $value);
}
