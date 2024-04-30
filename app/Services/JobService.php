<?php

namespace App\Services;

use App\Interfaces\JobRepositoryInterface;

class JobService{

    protected $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository){
        $this->jobRepository = $jobRepository;
    }

    public function getAllJob(){
        return $this->jobRepository->all();
    }

    public function getJobById($id){
        return $this->jobRepository->find($id);
    }

    public function searchJob(
        $keyword,
        $province,
        $category,
        $major,
        $salary,
        $jobType,
        $jobStatus,
        $attribute,
        $experience,
        $sort,
        $paginate){
        return $this->jobRepository->search($keyword, $province, $category, $major, $salary,
            $jobType, $jobStatus, $attribute, $experience, $sort, $paginate);
    }
}
