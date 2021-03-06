<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'is_super_admin'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function removeAdmin()
    {
        return $this->user()->first()->removeAdmin();
    }
}
