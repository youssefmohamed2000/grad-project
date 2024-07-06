<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'sex',
        'birth_place',
        'address',
        'job',
        'phone',
        'social_status',
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
        'password' => 'hashed',
    ];

    // relations
    public function details(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function family(): HasOne
    {
        return $this->hasOne(FamilyHistory::class, 'user_id', 'id');
    }

    public function chronicDiseases(): BelongsToMany
    {
        return $this->belongsToMany(
            ChronicDiseases::class,
            'user_chronic_diseases',
            'user_id',
            'chronic_diseases_id'
        );
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class, 'user_id', 'id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complain::class, 'user_id', 'id');
    }
}
