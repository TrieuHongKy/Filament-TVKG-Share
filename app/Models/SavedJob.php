<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model{

    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'job_id'
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
