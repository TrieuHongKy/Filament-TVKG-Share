<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobType extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];

    /**
     * @return HasMany
     */
    public function jobs()
    : HasMany{
        return $this->hasMany(Job::class);
    }
}
