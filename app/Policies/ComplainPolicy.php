<?php

namespace App\Policies;

use App\Models\Complain;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComplainPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Complain $complain): bool
    {
        return $user->id == $complain->user_id;
    }
}
