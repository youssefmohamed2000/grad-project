<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parents_relative',
        'parents_same_complain',
        'genetic_diseases',
    ];

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
