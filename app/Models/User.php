<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserType;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements FilamentUser, JWTSubject{

    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'major_id',
        'resume_id',
        'major_name',
        'skill',
        'email_verified_at',
        'password',
        'user_type',
        'address',
        'google_id',
        'tax_code',
        'company_name',
        'slug',
        'company_logo',
        'company_address',
        'banner',
        'company_description',
        'website',
        'company_size',
        'company_type',
        'company_industry'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'user_type'         => UserType::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->hasAnyRole([
                'super_admin',
                'admin',
                'blogger',
                'moderator'
            ]);
        }

        if ($panel->getId() === 'business') {
            return $this->hasAnyRole([
                'super_admin',
                'admin',
                'business'
            ]);
        }

        return TRUE;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }

    public function candidates()
    : HasOne{
        return $this->hasOne(Candidate::class, 'user_id');
    }

    public function companies()
    : HasOne{
        return $this->hasOne(Company::class, 'user_id');
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function postComments(){
        return $this->hasMany(PostComment::class);
    }

    public function postLikes(){
        return $this->hasMany(PostLike::class);
    }
}
