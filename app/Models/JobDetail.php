<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobDetail extends Model{

    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'address',
        'job_id'
    ];

    /**
     * @return BelongsTo
     */
    public function job()
    : BelongsTo{
        return $this->belongsTo(Job::class);
    }
}
