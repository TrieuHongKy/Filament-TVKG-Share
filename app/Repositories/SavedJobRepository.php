<?php

namespace App\Repositories;

use App\Interfaces\SavedJobRepositoryInterface;
use App\Models\SavedJob;

class SavedJobRepository implements SavedJobRepositoryInterface{

    public function all(){
        return SavedJob::paginate(10);
    }

    public function find($id){
        $postLike = SavedJob::find($id);
        if (!$postLike){
            throw new \Exception('Lượt lưu công việc không tồn tại!');
        }

        return $postLike;
    }

    public function create($data){
        return SavedJob::create($data);
    }

    public function delete($id){
        $postLike = $this->find($id);

        return $postLike->delete();
    }
}
