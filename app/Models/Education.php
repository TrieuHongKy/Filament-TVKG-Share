<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model{

    use HasFactory;

    protected $table = "educations";

    protected $fillable = [
        'education_name',
        'description',
        'start_date',
        'end_date',
        'major',
        'institution',
        'city',
        'country',
    ];

    public function candidates(){
        return $this->belongsToMany(Candidate::class, 'candidate_educations', 'education_id',
            'candidate_id');
    }

    public function degrees(){
        return $this->belongsToMany(Degree::class, 'education_degrees', 'education_id',
            'degree_id');
    }
}
