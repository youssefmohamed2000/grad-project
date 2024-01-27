<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'drugs',
        'blood_transfusion',
        'allergy',
        'children_no',
        'last_child_age',
        'booked_before',
        'booked_reason',
        'booked_duration',
    ];

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
