<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return HasMany
     */
    public function districts()
    : HasMany{
        return $this->hasMany(District::class);
    }

    /**
     * @return HasMany
     */
    public function jobs()
    : HasMany{
        return $this->hasMany(Job::class);
    }
}
