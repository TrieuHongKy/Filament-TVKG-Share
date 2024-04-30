<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface{

    public function all();

    public function find($id);

    public function getCategoryBySlug($slug);

    public function getPostsInCategory($slug);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
