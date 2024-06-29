<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'section_id',
        'name',
        'email',
        'password',
        'phone',
        'image'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($doctor) {
            if ($doctor->image) {
                Storage::disk('public')->delete('doctor/' . $doctor->image);
            }
        });
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->image) ? null : url(Storage::url('public/doctors/' . $this->image))
        );
    }

    // relations
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnose::class, 'doctor_id', 'id');
    }
}
