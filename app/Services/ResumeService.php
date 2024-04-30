<?php

namespace App\Services;

use App\Interfaces\ResumeRepositoryInterface;

class ResumeService{

    protected $resumeRepository;

    public function __construct(ResumeRepositoryInterface $resumeRepository){
        $this->resumeRepository = $resumeRepository;
    }

    public function getAllResume(){
        return $this->resumeRepository->all();
    }

    public function getResumeById($id){
        return $this->resumeRepository->find($id);
    }

    public function createResume($data){
        return $this->resumeRepository->create($data);
    }

    public function updateResume($id, $data){
        return $this->resumeRepository->update($id, $data);
    }

    public function deleteResume($id){
        return $this->resumeRepository->delete($id);
    }
}
