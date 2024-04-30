<?php

namespace App\Models;

use App\Enums\ApplyJobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplyJob extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'candidate_id', 'status'];

    protected $casts = ['status' => ApplyJobStatus::class];

    /**
     * @return BelongsTo
     */
    public function detail()
    :BelongsTo {
        return $this->belongsTo(JobDetail::class,'job_id');
    }

    /**
     * @return BelongsTo
     */
    public function candidate()
    : BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * @return BelongsTo
     */
    public function company()
    : BelongsTo{
        return $this->belongsTo(Company::class);
    }

    /**
     * @return BelongsTo
     */
    public function job()
    : BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
