<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any admins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function modify(User $user)
    {
        return $user->isSuperAdmin();
    }
}
