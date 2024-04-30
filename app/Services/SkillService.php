<?php

namespace App\Services;

use App\Interfaces\SkillRepositoryInterface;

class SkillService{

    protected $skillRepository;

    public function __construct(SkillRepositoryInterface $skillRepository){
        $this->skillRepository = $skillRepository;
    }

    public function getAllSkill(){
        return $this->skillRepository->all();
    }

    public function getSkillById($id){
        return $this->skillRepository->find($id);
    }

    public function createSkill($data){
        return $this->skillRepository->create($data);
    }

    public function updateSkill($id, $data){
        return $this->skillRepository->update($id, $data);
    }

    public function deleteSkill($id){
        return $this->skillRepository->delete($id);
    }
}
