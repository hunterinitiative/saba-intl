<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'fullname',
                'maxLength' => 60,
                'maxLengthKeepWords' => true,
                'onUpdate' => true
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    /**
     * Get the full name for the model.
     *
     * @return string
     */
    public function getFullnameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get a string path for the model.
     *
     * @return string
     */
    public function path() : string
    {
        return "/". $this->getModelAttribute() ."/{$this->slug}";
    }

    /**
     * Get a string path for the model.
     *
     * @return string
     */
    public function getPathAttribute() : string
    {
        return $this->path();
    }

    /**
     * Get the name of the model.
     *
     * @return string
     */
    public function getModelAttribute() : string
    {
        return Str::plural(strtolower(class_basename((get_class($this)))));
    }
}
