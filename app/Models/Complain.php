<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * @mixin Builder
 */
class Complain extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'complain',
        'start_date',
        'increase_with',
        'decrease_with',
    ];

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function diagnose(): HasOne
    {
        return $this->hasOne(Diagnose::class, 'complain_id', 'id');
    }
}
