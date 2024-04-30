<?php

namespace App\Services;

use App\Interfaces\CandidateRepositoryInterface;
use App\Repositories\CandidateAddressRepository;
use App\Repositories\CandidateEducationRepository;
use App\Repositories\CandidateLanguageRepository;

class CandidateService{

    protected $candidateRepository;
    protected $candidateAddressRepository;
    protected $candidateEducationRepository;
    protected $candidateLanguageRepository;

    public function __construct(
        CandidateRepositoryInterface $candidateRepository,
        CandidateAddressRepository $candidateAddressRepository,
        CandidateEducationRepository $candidateEducationRepository,
        CandidateLanguageRepository $candidateLanguageRepository
    ){
        $this->candidateRepository          = $candidateRepository;
        $this->candidateAddressRepository   = $candidateAddressRepository;
        $this->candidateEducationRepository = $candidateEducationRepository;
        $this->candidateLanguageRepository  = $candidateLanguageRepository;
    }

    public function getAllCandidates(){
        return $this->candidateRepository->all();
    }

    public function getCandidateById($id){
        return $this->candidateRepository->find($id);
    }

    public function createCandidate($data){
        $candidate = $this->candidateRepository->create($data);

        $this->createCandidateAddress($candidate->id, $data);

        $this->createCandidateEducation($candidate->id, $data);

        if (isset($data['skills'])){
            $candidate->skills()->sync($data['skills']);
        }

        if (isset($data['languages'])){
            $candidate->languages()->sync($data['languages']);
        }

        $candidate->load('educations', 'skills', 'languages', 'address.province',
            'address.district', 'address.ward');

        return $candidate;
    }

    public function updateCandidate($id, $data){
        $candidate = $this->candidateRepository->find($id);

        $this->updateCandidateAddress($candidate->id, $data);

        $this->updateCandidateEducation($candidate->id, $data);

        if (isset($data['skills'])){
            $candidate->skills()->sync($data['skills']);
        }

        if (isset($data['languages'])){
            $candidate->languages()->sync($data['languages']);
        }

        $candidate = $this->candidateRepository->update($id, $data);
        $candidate->load('skills', 'educations', 'languages', 'address.province',
            'address.district', 'address.ward');

        return $candidate;
    }

    private function createCandidateAddress($candidateId, $data){
        if (isset($data['district_id']) || isset($data['province_id']) || isset($data['ward_id'])){
            $data['candidate_id'] = $candidateId;
            $this->candidateAddressRepository->create($data);
        }
    }

    private function createCandidateEducation($candidateId, $data){
        if (isset($data['educations'])){
            $data['candidate_id'] = $candidateId;
            $this->candidateEducationRepository->create($data);
        }
    }

    private function updateCandidateAddress($candidateId, $data){
        if (isset($data['district_id']) || isset($data['province_id']) || isset($data['ward_id'])){
            $this->candidateAddressRepository->update($candidateId, $data);
        }
    }

    private function updateCandidateEducation($candidateId, $data){
        if (isset($data['educations'])){
            $candidate = $this->candidateRepository->find($candidateId);
            $candidate->educations()->sync($data['educations']);
        }
    }

    public function showSavedJob($id){
        return $this->candidateRepository->showSavedJob($id);
    }

    public function deleteCandidate($id){
        return $this->candidateRepository->delete($id);
    }
}
