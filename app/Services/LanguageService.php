<?php

namespace App\Services;

use App\Interfaces\LanguageRepositoryInterface;

class LanguageService{

    protected $languageRepository;

    public function __construct(LanguageRepositoryInterface $languageRepository){
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguage(){
        return $this->languageRepository->all();
    }

    public function getLanguageById($id){
        return $this->languageRepository->find($id);
    }

    public function createLanguage($data){
        return $this->languageRepository->create($data);
    }

    public function updateLanguage($id, $data){
        return $this->languageRepository->update($id, $data);
    }

    public function deleteLanguage($id){
        return $this->languageRepository->delete($id);
    }
}
