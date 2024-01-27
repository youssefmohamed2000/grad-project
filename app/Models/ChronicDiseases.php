<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChronicDiseases extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // relations 
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_chronic_diseases',
            'chronic_diseases_id',
            'user_id',
        );
    }
}
