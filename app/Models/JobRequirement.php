<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobRequirement extends Model{

    use HasFactory;

    protected $fillable = [
        'job_id',
        'major_id',
        'degree_id',
        'experience_id',
    ];

    /**
     * @return BelongsTo
     */
    public function job()
    : BelongsTo{
        return $this->belongsTo(Job::class);
    }

    /**
     * @return BelongsTo
     */
    public function major()
    : BelongsTo{
        return $this->belongsTo(Major::class);
    }

    /**
     * @return BelongsTo
     */
    public function degree()
    : BelongsTo{
        return $this->belongsTo(Degree::class);
    }

    /**
     * @return BelongsTo
     */
    public function experience()
    : BelongsTo{
        return $this->belongsTo(Experience::class);
    }
}
