<?php

namespace App\Repositories;

use App\Interfaces\ApplyJobRepositoryInterface;
use App\Models\ApplyJob;

class ApplyJobRepository implements ApplyJobRepositoryInterface{

    public function create(array $data){
        return ApplyJob::create($data);
    }

    public function find(int $id){
        return ApplyJob::find($id);
    }

    public function alreadyApplied(int $candidateId, int $jobId){
        $applyJob = ApplyJob::where('candidate_id', $candidateId)->where('job_id', $jobId)->first();

        if (!$applyJob){
            throw new \Exception('Bạn chưa ứng tuyển công việc này');
        }

        return $applyJob;
    }
}
