<?php

namespace App\Policies;

use App\Models\Operation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OperationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Operation $operation): bool
    {
        return $user->id == $operation->user_id;
    }
}
