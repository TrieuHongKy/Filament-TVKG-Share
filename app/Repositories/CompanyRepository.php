<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use App\Models\Job;
use App\Models\Post;

class CompanyRepository implements CompanyRepositoryInterface{

    public function all(){
        return Company::paginate(10);
    }

    public function find($slug){
        $company = Company::with(
            'address.province',
            'address.district',
            'address.ward',
            'trackings',
        )->where('slug', $slug)->first();
        if (!$company){
            throw new \Exception('Công ty không tồn tại.');
        }

        return $company;
    }

    public function findByUserId($id){
        $company = Company::with(
            'address.province',
            'address.district',
            'address.ward',
            'trackings',
        )->where('user_id', $id)->first();
        if (!$company){
            throw new \Exception('Công ty không tồn tại.');
        }

        return $company;
    }

    public function getJob($id){
        $jobs = Job::where('company_id', $id)->get();
        if (!$jobs){
            throw new \Exception('Công việc không tồn tại.');
        }

        return $jobs;
    }

    public function getPost($id){
        $posts = Post::withCount('postComments')
                     ->withCount('postLikes')
                     ->where('user_id', $id)
                     ->get();
        if (!$posts){
            throw new \Exception('Bài viết không tồn tại.');
        }

        return $posts;
    }

    public function getCompanyWithJob(){
        $company = Company::with(
            'address.province',
            'address.district',
            'address.ward',
            'jobs',
        )->paginate(10);

        return $company;
    }

    public function create($data){
        return Company::create($data);
    }
}
