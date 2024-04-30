<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'major_id',
        'resume_id',
        'major_name',
    ];

    /**
     * @return HasMany
     */
    public function candidateEducations()
    : HasMany{
        return $this->hasMany(CandidateEducation::class, 'candidate_id');
    }

    /**
     * educations
     *
     * @return BelongsToMany
     */
    public function educations()
    : BelongsToMany{
        return $this->belongsToMany(Education::class, 'candidate_educations', 'candidate_id',
            'education_id');
    }

    /**
     * @return BelongsToMany
     */
    public function languages()
    : BelongsToMany{
        return $this->belongsToMany(
            Language::class,
            'candidate_languages',
            'candidate_id',
            'language_id'
        );
    }

    /**
     * get a list of companies the candidate has followed
     *
     * @return HasMany
     */
    public function trackedCompanies()
    : HasMany{
        return $this->hasMany(CompanyTracking::class, 'follower_id');
    }

    /**
     * get skills for candidate
     *
     * @return BelongsToMany
     */
    public function skills()
    : BelongsToMany{
        return $this->belongsToMany(Skill::class, 'candidate_skills', 'candidate_id', 'skill_id');
    }

    /**
     * get majors for the candidate
     *
     * @return BelongsToMany
     */
    public function majors()
    : BelongsToMany{
        return $this->belongsToMany(Major::class, 'candidate_majors', 'candidate_id', 'major_id');
    }

    /**
     * get resume of the candidate
     *
     * @return HasOne
     */
    public function resume()
    : HasOne{
        return $this->hasOne(Resume::class);
    }

    /**
     * get the candidate's address
     *
     * @return HasOne
     */
    public function address()
    : HasOne{
        return $this->hasOne(CandidateAddress::class);
    }

    /**
     * get the jobs the candidate has applied for
     *
     * @return BelongsToMany
     */
    public function jobs()
    : BelongsToMany{
        return $this->belongsToMany(Job::class, 'apply_jobs', 'candidate_id', 'job_id');
    }

    public function user()
    : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appliedJobs()
    : HasMany{
        return $this->hasMany(ApplyJob::class, 'candidate_id');
    }
}
