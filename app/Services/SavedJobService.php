<?php

namespace App\Services;

use App\Interfaces\SavedJobRepositoryInterface;

class SavedJobService{

    protected $savedJobRepository;

    public function __construct(SavedJobRepositoryInterface $savedJobRepository){
        $this->savedJobRepository = $savedJobRepository;
    }

    public function getAllSavedJobs(){
        return $this->savedJobRepository->all();
    }

    public function createSavedJob($data){
        return $this->savedJobRepository->create($data);
    }

    public function deleteSavedJob($id){
        return $this->savedJobRepository->delete($id);
    }
}
