<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface{

    public function all(){
        return Post::withCount('postComments')->withCount('postLikes')->paginate(10);
    }

    public function find($slug){
        $post = Post::withCount('postComments')
                    ->withCount('postLikes')
                    ->where('slug', $slug)
                    ->first();
        if (!$post){
            throw new \Exception('Bài viết không tồn tại.');
        }

        return $post;
    }

    //    public function getPostByCategory($slug){
    //        $category = Category::where('slug',$slug)->first();
    //        if(!$category){
    //            throw new Exception('Danh mục không tồn tại');
    //        }
    //        $post = Post::withCount('postComments')->withCount('postLikes')->where('category_id', $category->id)->get();
    //
    //        return $post;
    //    }


    public function create($data){
        return Post::create($data);
    }

    public function update($id, $data){
        $post = $this->find($id);
        $post->update($data);

        return $post;
    }

    public function delete($slug){
        $post = $this->find($slug);

        return $post->delete();
    }

    public function findBy($field, $value){
        return Post::where($field, $value)->first();
    }
}
