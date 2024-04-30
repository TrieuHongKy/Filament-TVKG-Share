<?php

namespace App\Services;

use App\Interfaces\ContactRepositoryInterface;

class ContactService{

    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository){
        $this->contactRepository = $contactRepository;
    }

    public function getAllContact(){
        return $this->contactRepository->all();
    }

    public function getContactById($id){
        return $this->contactRepository->find($id);
    }

    public function createContact($data){
        return $this->contactRepository->create($data);
    }

    public function deleteContact($id){
        return $this->contactRepository->delete($id);
    }
}
