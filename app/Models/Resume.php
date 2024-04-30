<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * get resume of the candidate
     *
     * @return BelongsTo
     */
    public function candidate()
    : BelongsTo{
        return $this->belongsTo(Candidate::class);
    }
}
