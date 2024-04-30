<?php

namespace App\Interfaces;


interface CompanyRepositoryInterface{

    public function all();

    public function find($slug);

    public function findByUserId($id);

    public function getJob($id);

    public function getPost($id);

    public function getCompanyWithJob();

    public function create($data);
}
