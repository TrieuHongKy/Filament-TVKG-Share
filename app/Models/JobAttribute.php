<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAttribute extends Model{

    use HasFactory;

    protected $fillable = [
        'job_id',
        'is_active',
        'is_featured',
        'is_published',
        'published_at',
        'expired_at'
    ];

    /**
     * @return BelongsTo
     */
    public function job()
    : BelongsTo{
        return $this->belongsTo(Job::class);
    }
}
