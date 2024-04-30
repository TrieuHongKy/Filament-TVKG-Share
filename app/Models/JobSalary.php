<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSalary extends Model{

    use HasFactory;

    protected $fillable = [
        'job_id',
        'min_salary',
        'max_salary',
        'fixed_salary'
    ];

    /**
     * @return BelongsTo
     */
    public function job()
    : BelongsTo{
        return $this->belongsTo(Job::class);
    }
}
