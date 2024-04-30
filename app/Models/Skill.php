<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model{

    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Get the candidates for the skill.
     *
     * @return BelongsToMany
     */
    public function candidates()
    : BelongsToMany{
        return $this->belongsToMany(Candidate::class, 'candidate_skills', 'skill_id',
            'candidate_id');
    }
}
