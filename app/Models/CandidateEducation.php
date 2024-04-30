<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateEducation extends Model
{
    use HasFactory;

    protected $table = 'candidate_educations';

    protected $fillable = [
        'candidate_id',
        'education_id',
    ];

    /**
     * @return BelongsTo
     */
    public function education()
    : BelongsTo{
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function candidate()
    : BelongsTo{
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
