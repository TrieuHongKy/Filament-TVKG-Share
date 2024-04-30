<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'slug',
        'company_logo',
        'banner',
        'company_description',
        'website',
        'company_size',
        'company_type',
        'company_industry',
        'company_address',
        'tax_code'
    ];

    public function trackings(){
        return $this->hasMany(CompanyTracking::class);
    }

    /**
     * get the company's address
     *
     * @return HasOne
     */
    public function address()
    : HasOne{
        return $this->hasOne(CompanyAddress::class);
    }

    /**
     * @return HasMany
     */
    public function jobs()
    : HasMany{
        return $this->hasMany(Job::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
