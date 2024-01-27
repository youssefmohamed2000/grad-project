<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnose extends Model
{
    use HasFactory;

    protected $fillable = [
        'complain_id',
        'doctor_id',
        'diagnose',
    ];
    
    // relations
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function complain(): BelongsTo
    {
        return $this->belongsTo(Complain::class, 'complain_id', 'id');
    }
}
