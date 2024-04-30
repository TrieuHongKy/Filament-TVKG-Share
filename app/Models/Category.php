<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model{

    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'image', 'status'];

    /**
     * @return HasMany
     */
    public function posts()
    : HasMany{
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function children()
    : HasMany{
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    : BelongsTo{
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function jobs()
    : HasMany{
        return $this->hasMany(Job::class);
    }
}
