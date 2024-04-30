<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Major extends Model{

    use HasFactory;

    protected $fillable = ['name', 'short_name', 'slug'];

    /**
     * Get the candidates for the major.
     *
     * @return BelongsToMany
     */
    public function candidates()
    : BelongsToMany{
        return $this->belongsToMany(Candidate::class, 'candidate_majors', 'major_id',
            'candidate_id');
    }
}
