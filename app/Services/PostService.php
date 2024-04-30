<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;

class PostService{

    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository){
        $this->postRepository = $postRepository;
    }

    public function getAllPost(){
        return $this->postRepository->all();
    }

    public function getPostBySlug($slug){
        return $this->postRepository->find($slug);
    }

    //    public function getPostByCategory($category_id){
    //        return $this->postRepository->getPostByCategory($category_id);
    //    }

    public function createPost($data){
        //        dd($data->image);
        $image     = $data['image'];
        $imageName = $image->getClientOriginalName(); // Lấy tên gốc của file

        // Di chuyển file vào thư mục posts trong thư mục public
        $image->move(storage_path('posts'), $imageName);

        // Thêm đường dẫn hình ảnh vào dữ liệu
        $data['image'] = asset(env('APP_URL') . '/storage/posts/' . $imageName);

        return $this->postRepository->create($data);
    }

    public function updatePost($id, $data){
        return $this->postRepository->update($id, $data);
    }

    public function deletePost($slug){
        return $this->postRepository->delete($slug);
    }

}
