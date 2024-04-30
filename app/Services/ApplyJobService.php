<?php

namespace App\Services;

use App\Interfaces\ApplyJobRepositoryInterface;

class ApplyJobService{

    protected $applyJobRepository;

    public function __construct(ApplyJobRepositoryInterface $applyJobRepository){
        $this->applyJobRepository = $applyJobRepository;
    }

    public function createApplyJob($data){
        return $this->applyJobRepository->create($data);
    }

    public function alreadyApplied($candidateId, $jobId){
        return $this->applyJobRepository->alreadyApplied($candidateId, $jobId);
    }
}
