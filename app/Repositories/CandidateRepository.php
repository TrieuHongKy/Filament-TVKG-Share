<?php

namespace App\Repositories;

use App\Interfaces\CandidateRepositoryInterface;
use App\Models\Candidate;
use App\Models\SavedJob;
use App\Models\User;

class CandidateRepository implements CandidateRepositoryInterface{

    public function all(){
        return Candidate::with(
            'skills',
            'educations',
            'languages',
            'address.province',
            'address.district',
            'address.ward'
        )->paginate(10);
    }

    public function find($id){
        $user = User::where('id', $id)
                    ->orWhere('google_id', $id)
                    ->first();

        if (!$user){
            throw new \Exception("Ứng viên không tồn tại!");
        }

        $candidate = Candidate::with(
            'skills',
            'educations',
            'languages',
            'user',
            'address.province',
            'address.district',
            'address.ward'
        )
                              ->where('user_id', $user->id)
                              ->first();

        return $candidate;
    }


    public function create($data){
        return Candidate::create($data);
    }

    public function showSavedJob($id){
        $jobs = SavedJob::where('candidate_id', $id)->get();
        if (!$jobs){
            throw new \Exception('Ứng viên không tồn tại.');
        }

        return $jobs;
    }

    public function update($id, $data){
        $candidate = $this->find($id);
        $candidate->update($data);

        return $candidate;
    }

    public function delete($id){
        $candidate = $this->find($id);

        return $candidate->delete();
    }
}
