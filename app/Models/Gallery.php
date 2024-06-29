<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['image'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($gallery) {
            if ($gallery->image) {
                Storage::disk('public')->delete('gallery/' . $gallery->image);
            }
        });
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->image) ? null : url(Storage::url('public/gallery/' . $this->image))
        );
    }
}
