<?php
namespace App\Traits;

use App\Admin;
use App\Exceptions\AdminAlreadyExistsException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

trait Administrates
{
    public function isAdmin()
    {
        return $this->admin()->exists();
    }

    public function isSuperAdmin()
    {
        return $this->admin()->where('is_super_admin', 1)->exists();
    }

    public function admin()
    {
        return $this->hasOne('App\Admin');
    }

    public function makeAdmin($superAdmin = 0)
    {
        if (Auth::user()->can('modify', 'App\Admin')) {
            
            // If a user is a superAdmin, or the user is just an admin and you are not trying to make them a superAdmin
            if ($this->isSuperAdmin() || $isAdmin = $this->isAdmin() && ! $superAdmin)
                throw new AdminAlreadyExistsException('This user is already an administrator');

            // If the user is just an admin and you want to make them a superAdmin
            if($isAdmin && $superAdmin == 1) {
                return Admin::where('user_id', $this->id)->update(['is_super_admin' => $superAdmin]);
            }

            // otherwise, if the user is neither a superAdmin nor an admin, proceed to make them one or the other
            return Admin::create([
                'user_id' => $this->id,
                'is_super_admin' => $superAdmin
            ]);
        } else {
            throw new AuthorizationException('You are not authorized to create admin users.');
        }
    }

    public function removeAdmin()
    {
        if (Auth::user()->can('modify', 'App\Admin')) {

            return $this->admin()->delete();
            
        } else {
            throw new AuthorizationException('You are not authorized to remove admin users.');
        }
    }
}
