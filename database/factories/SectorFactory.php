<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
