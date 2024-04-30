<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'province_id',
    ];

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function wards(){
        return $this->hasMany(Ward::class);
    }

    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
