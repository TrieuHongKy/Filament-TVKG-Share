<?php

namespace App\Repositories;

use App\Interfaces\ResumeRepositoryInterface;
use App\Models\Resume;

class ResumeRepository implements ResumeRepositoryInterface{

    public function all(){
        return Resume::paginate(10);
    }

    public function find($id){
        $resume = Resume::find($id);
        if (!$resume){
            throw new \Exception('Sơ yếu lý lịch không tồn tại');
        }

        return $resume;
    }

    public function create($data){
        return Resume::create($data);
    }

    public function update($id, $data){
        $resume = $this->find($id);
        $resume->update($data);

        return $resume;
    }

    public function delete($id){
        $resume = $this->find($id);

        return $resume->delete();
    }
}
