<?php

namespace App\Policies;

use App\Admin;
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

    /**
     * Determine whether the user can update the admin. // needed for Nova Action to run
     *
     * @param  \App\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function update(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the admin. // needed for Nova Action to run
     *
     * @param  \App\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function delete(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }
}
