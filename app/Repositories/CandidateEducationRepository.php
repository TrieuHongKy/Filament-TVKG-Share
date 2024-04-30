<?php

namespace App\Repositories;

use App\Models\CandidateEducation;

class CandidateEducationRepository{

    public function create($data){
        return CandidateEducation::create($data);
    }

    public function update($id, $data){
        $candidateEducation = CandidateEducation::where('candidate_id', $id)->first();

        if (!$candidateEducation){
            $data['candidate_id'] = $id;

            return $this->create($data);
        }

        $candidateEducation->update($data);

        return $candidateEducation;
    }
}
