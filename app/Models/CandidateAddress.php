<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateAddress extends Model{

    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'province_id',
        'district_id',
        'ward_id',
    ];

    /**
     * @return BelongsTo
     */
    public function candidate()
    : BelongsTo{
        return $this->belongsTo(Candidate::class);
    }

    /**
     * @return BelongsTo
     */
    public function province()
    : BelongsTo{
        return $this->belongsTo(Province::class);
    }

    /**
     * @return BelongsTo
     */
    public function district()
    : BelongsTo{
        return $this->belongsTo(District::class);
    }

    /**
     * @return BelongsTo
     */
    public function ward()
    : BelongsTo{
        return $this->belongsTo(Ward::class);
    }
}
