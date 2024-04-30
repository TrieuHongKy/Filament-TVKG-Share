<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Models\Post;

class CategoryRepository implements CategoryRepositoryInterface{

    public function all(){
        return Category::withCount('posts')->paginate(10);
    }

    public function find($id){
        $category = Category::find($id);
        if (!$category){
            throw new \Exception('Danh mục này không tồn tại');
        }

        return $category;
    }

    public function getCategoryBySlug($slug){
        $category = Category::where('slug', $slug)->first();
        if (!$category){
            throw new \Exception('Danh mục không tồn tại');
        }

        return $category;
    }

    public function getPostsInCategory($slug){
        $category = $this->getCategoryBySlug($slug);
        if (!$category){
            throw new \Exception('Danh mục không tồn tại');
        }
        $post = Post::withCount('postComments')
                    ->withCount('postLikes')
                    ->where('category_id', $category->id)
                    ->paginate(10);

        return $post;
    }

    public function create($data){
        return Category::create($data);
    }

    public function update($id, $data){
        $category = $this->find($id);
        $category->update($data);

        return $category;
    }

    public function delete($id){
        $category = $this->find($id);

        return $category->delete();
    }
}
