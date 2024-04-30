<?php

namespace App\Repositories;

use App\Models\CandidateAddress;

class CandidateAddressRepository{

    public function create($data){
        return CandidateAddress::create($data);
    }

    public function update($id, $data){
        $candidateAddress = CandidateAddress::where('candidate_id', $id)->first();

        if (!$candidateAddress){
            $data['candidate_id'] = $id;

            return $this->create($data);
        }

        $candidateAddress->update($data);

        return $candidateAddress;
    }

    public function delete($id){
        return CandidateAddress::where('candidate_id', $id)->delete();
    }
}
