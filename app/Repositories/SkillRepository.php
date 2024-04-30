<?php

namespace App\Repositories;

use App\Interfaces\SkillRepositoryInterface;
use App\Models\Skill;

class SkillRepository implements SkillRepositoryInterface{

    public function all(){
        return Skill::all();
    }

    public function find($id){
        $skill = Skill::find($id);
        if (!$skill){
            throw new \Exception('Kỹ năng không tồn tại');
        }

        return $skill;
    }

    public function create($data){
        return Skill::create($data);
    }

    public function update($id, $data){
        $skill = $this->find($id);
        $skill->update($data);

        return $skill;
    }

    public function delete($id){
        $skill = $this->find($id);

        return $skill->delete();
    }
}
