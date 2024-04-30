<?php

namespace App\Repositories;

use App\Interfaces\EducationRepositoryInterface;
use App\Models\Education;

class EducationRepository implements EducationRepositoryInterface{

    public function all(){
        return Education::paginate(10);
    }

    public function find($id){
        $education = Education::find($id);
        if (!$education){
            throw new \Exception('Học vấn không tồn tại!');
        }

        return $education;
    }

    public function getWidget($key){
        return Education::where('key', $key)->first();
    }

    public function create(array $data){
        return Education::create($data);
    }

    public function update($id, array $data){
        $education = $this->find($id);
        $education->update($data);

        return $education;
    }

    public function delete($id){
        $education = $this->find($id);

        return $education->delete();
    }
}
