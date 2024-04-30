<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTracking extends Model{

    use HasFactory;

    protected $fillable = [
        'company_id',
        'follower_id',
        'tracking_date',
    ];
}
