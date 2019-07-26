<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Workstation;
use Faker\Generator as Faker;

$factory->define(Workstation::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
