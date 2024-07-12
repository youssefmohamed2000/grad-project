<?php

namespace App\Policies;

use App\Models\Diagnose;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiagnosePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Diagnose $diagnose): bool
    {
        return $user->id == $diagnose->user_id;
    }
}
