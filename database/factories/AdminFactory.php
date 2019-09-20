<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'user_id' => $attributes->user_id ?? create('App\User')->id,
        'is_super_admin' => $attributes->is_super_admin ?? 0
    ];
});
