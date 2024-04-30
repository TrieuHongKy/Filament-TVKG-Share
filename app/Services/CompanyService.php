<?php

namespace App\Services;

use App\Interfaces\CompanyRepositoryInterface;

class CompanyService{

    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository){
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompany(){
        return $this->companyRepository->all();
    }

    public function getCompany($slug){
        return $this->companyRepository->find($slug);
    }

    public function getCompanyByUserId($id){
        return $this->companyRepository->findByUserId($id);
    }

    public function getJob($id){
        return $this->companyRepository->getJob($id);
    }

    public function getPost($id){
        return $this->companyRepository->getPost($id);
    }

    public function getCompanyWithJob(){
        return $this->companyRepository->getCompanyWithJob();
    }

    public function createCompany($data){
        return $this->companyRepository->create($data);
    }
}
