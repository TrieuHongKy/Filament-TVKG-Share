<?php

namespace App\Interfaces;

interface ApplyJobRepositoryInterface{

    public function create(array $data);

    public function alreadyApplied(int $candidateId, int $jobId);
}
