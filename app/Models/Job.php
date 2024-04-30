<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job extends Model{

    use HasFactory;

    protected $fillable =
        [
            'company_id',
            'category_id',
            'province_id',
            'district_id',
            'ward_id',
            'job_type_id',
            'job_status_id',
        ];

    /**
     * @return HasOne
     */
    public function detail()
    : HasOne{
        return $this->hasOne(JobDetail::class);
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
    public function category()
    : BelongsTo{
        return $this->belongsTo(Category::class);
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

    /**
     * @return BelongsTo
     */
    public function jobType()
    : BelongsTo{
        return $this->belongsTo(JobType::class);
    }

    /**
     * @return BelongsTo
     */
    public function jobStatus()
    : BelongsTo{
        return $this->belongsTo(JobStatus::class);
    }

    /**
     * @return HasOne
     */
    public function requirements()
    : HasOne{
        return $this->hasOne(JobRequirement::class);
    }

    /**
     * @return HasOne
     */
    public function salary()
    : HasOne{
        return $this->hasOne(JobSalary::class);
    }

    /**
     * candidates who have applied for this job
     *
     * @return BelongsToMany
     */
    public function candidates()
    : BelongsToMany{
        return $this->belongsToMany(Candidate::class, 'apply_jobs', 'job_id', 'candidate_id');
    }

    public function attribute()
    : HasOne{
        return $this->hasOne(JobAttribute::class);
    }

    public function scopeKeyword($query, $keyword){
        if ($keyword){
            return $query->whereHas('detail', function ($query) use ($keyword){
                $query
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        return $query;
    }

    public function scopeProvince($query, $province){
        if ($province){
            return $query->where('province_id', $province);
        }

        return $query;
    }

    public function scopeCategory($query, $category){
        if ($category){
            return $query->where('category_id', $category);
        }

        return $query;
    }

    public function scopeExperience($query, $experience){
        if ($experience){
            return $query->whereHas('requirements', function ($query) use ($experience){
                $query->where('experience_id', $experience);
            });
        }

        return $query;
    }

    // public function scopeSalary($query, $salary)
    // {
    //     if ($salary) {
    //         return $query->whereHas('salary', function ($query) use ($salary) {
    //             $query->where('salary', $salary);
    //         });
    //     }

    //     return $query;
    // }

    public function scopeSalary($query, $salary){
        if ($salary){
            $salaries  = explode('-', $salary);
            $minSalary = $salaries[0];
            $maxSalary = $salaries[1] ?? NULL;

            if ($maxSalary){
                return $query->whereHas('salary', function ($query) use ($minSalary, $maxSalary){
                    $query->whereBetween('min_salary', [$minSalary, $maxSalary])
                          ->orWhereBetween('max_salary', [$minSalary, $maxSalary])
                          ->orWhereBetween('fixed_salary', [$minSalary, $maxSalary]);
                });
            }else{
                return $query->whereHas('salary', function ($query) use ($minSalary){
                    $query->where('min_salary', '>=', $minSalary)
                          ->orWhere('max_salary', '>=', $minSalary)
                          ->orWhere('fixed_salary', '>=', $minSalary);
                });
            }
        }

        return $query;
    }


    public function scopeJobType($query, $jobType){
        if ($jobType){
            return $query->where('job_type_id', $jobType);
        }

        return $query;
    }

    public function scopeRequirement($query, $requirement){
        if ($requirement){
            return $query->whereHas('requirements', function ($query) use ($requirement){
                $query->where('requirement', $requirement);
            });
        }

        return $query;
    }

    public function scopeDegree($query, $degree){
        if ($degree){
            return $query->whereHas('requirements', function ($query) use ($degree){
                $query->where('degree_id', $degree);
            });
        }

        return $query;
    }

    public function scopeMajor($query, $major){
        if ($major){
            return $query->whereHas('requirements', function ($query) use ($major){
                $query->where('major_id', $major);
            });
        }

        return $query;
    }

    public function scopeJobStatus($query, $jobStatus){
        if ($jobStatus){
            return $query->where('job_status_id', $jobStatus);
        }

        return $query;
    }


    public function scopeSort($query, $sort){
        if ($sort){
            return $query->orderBy('created_at', $sort);
        }

        return $query;
    }

    public function scopePaginate($query, $paginate){
        if ($paginate){
            return $query->paginate($paginate);
        }

        return $query;
    }

    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }

    public function scopeGetJobByCategory($query, $slug){
        return $query->whereHas('category', function ($query) use ($slug){
            $query->where('slug', $slug);
        });
    }

    public function scopeGetJobByCompany($query, $slug){
        return $query->whereHas('company', function ($query) use ($slug){
            $query->where('slug', $slug);
        });
    }

    public function scopeGetJobByProvince($query, $slug){
        return $query->whereHas('province', function ($query) use ($slug){
            $query->where('slug', $slug);
        });
    }
}
