<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'district_id',
    ];

    /**
     * @return BelongsTo
     */
    public function district()
    : BelongsTo{
        return $this->belongsTo(District::class);
    }

    /**
     * @return HasMany
     */
    public function jobs()
    : HasMany{
        return $this->hasMany(Job::class);
    }
}
