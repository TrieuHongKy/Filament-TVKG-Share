<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;

class CategoryService{

    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory(){
        return $this->categoryRepository->all();
    }

    public function getCategoryById($id){
        return $this->categoryRepository->find($id);
    }

    public function getCategoryBySlug($slug){
        return $this->categoryRepository->getCategoryBySlug($slug);
    }

    public function getPostsInCategory($slug){
        return $this->categoryRepository->getPostsInCategory($slug);
    }

    public function createCategory($data){
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, $data){
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id){
        return $this->categoryRepository->delete($id);
    }
}
