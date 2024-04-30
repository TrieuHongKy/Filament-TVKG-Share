<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model{

    use HasFactory;

    protected $fillable =
        [
            'title',
            'slug',
            'content',
            'image',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

    /**
     * @return BelongsTo
     */
    public function category()
    : BelongsTo{
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function postComments(){
        return $this->hasMany(PostComment::class);
    }

    public function postLikes(){
        return $this->hasMany(PostLike::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
