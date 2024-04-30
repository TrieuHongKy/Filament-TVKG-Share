<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface{

    public function all(){
        return Job::join('job_attributes', 'jobs.id', '=', 'job_attributes.job_id')
                  ->orderBy('job_attributes.is_featured', 'desc')
                  ->orderBy('jobs.created_at', 'desc')
                  ->with('detail', 'company', 'category', 'salary', 'jobStatus', 'attribute',
                      'requirements', 'jobType', 'province', 'district', 'ward')
                  ->paginate(10);
    }

    public function find($id){
        $job = Job::with(
            'detail',
            'company',
            'category',
            'salary',
            'jobStatus',
            'attribute',
            'requirements',
            'jobType',
        // 'province',
        // 'district',
        // 'ward',
        )->find($id);

        return $job;
    }

    public function search(
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
        $query = Job::with(
            'detail',
            'company',
            'category',
            'salary',
            'jobStatus',
            'attribute',
            'requirements',
            'jobType',
        )
                    ->keyword($keyword)
                    ->province($province)
                    ->category($category)
                    ->major($major)
                    ->salary($salary)
                    ->jobType($jobType)
                    ->jobStatus($jobStatus)
                    ->experience($experience)
            // ->attribute($attribute)
                    ->sort($sort)
                    ->paginate($paginate);

        return $query;
    }
}
