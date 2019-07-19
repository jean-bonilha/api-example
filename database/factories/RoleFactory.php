<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
