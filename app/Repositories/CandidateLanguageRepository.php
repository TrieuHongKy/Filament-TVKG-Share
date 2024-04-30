<?php

namespace App\Repositories;

use App\Models\CandidateLanguage;

class CandidateLanguageRepository{

    public function createCandidateLanguage($candidateId, $data){
        $candidateLanguage = CandidateLanguage::create([
            'candidate_id'   => $candidateId,
            'language_id'    => $data['language_id'],
            'language_level' => $data['language_level'] || 0,
        ]);

        return $candidateLanguage;
    }

    public function updateCandidateLanguage($candidateId, $data){
        $candidateLanguage = CandidateLanguage::where('candidate_id', $candidateId)->first();

        $candidateLanguage->update([
            'language_id'    => $data['language_id'],
            'language_level' => $data['language_level'],
        ]);

        return $candidateLanguage;
    }

    public function deleteCandidateLanguage($candidateId){
        $candidateLanguage = CandidateLanguage::where('candidate_id', $candidateId)->first();

        $candidateLanguage->delete();

        return $candidateLanguage;
    }
}
