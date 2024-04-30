<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model{

    use HasFactory;

    protected $fillable = ['user_id', 'name', 'phone', 'email', 'address', 'content','status'];

    /**
     * @return BelongsTo
     */
    public function author()
    : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
