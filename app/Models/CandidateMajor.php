<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateMajor extends Model
{
    use HasFactory;

    protected $table = 'candidate_majors';

    protected $fillable = [
        'candidate_id',
        'major_id',
    ];

    /**
     * @return BelongsTo
     */
    public function education()
    : BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
