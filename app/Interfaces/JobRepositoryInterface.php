<?php

namespace App\Interfaces;


interface JobRepositoryInterface{

    public function all();

    public function find($id);

    // public function getJobByCategory($slug);
    //
    //    public function create(array $attributes);
    //
    //    public function update($id, array $attributes);

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
        $paginate);
}
