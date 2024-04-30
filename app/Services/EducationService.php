<?php

namespace App\Services;

use App\Interfaces\EducationRepositoryInterface;

class EducationService{

    protected $educationRepository;

    public function __construct(EducationRepositoryInterface $educationRepository){
        $this->educationRepository = $educationRepository;
    }

    public function getAllEducations(){
        return $this->educationRepository->all();
    }

    public function getEducationById($id){
        return $this->educationRepository->find($id);
    }

    public function createEducation($data){
        return $this->educationRepository->create($data);
    }

    public function updateEducation($id, $data){
        return $this->educationRepository->update($id, $data);
    }

    public function deleteEducation($id){
        return $this->educationRepository->delete($id);
    }

    // public function getEducationByCandidateId ($id)
    // {
    //     return $this->educationRepository->getEducationByCandidateId($id);
    // }
}
