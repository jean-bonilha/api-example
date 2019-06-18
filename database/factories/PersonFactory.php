<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'rg' => $faker->randomNumber(8),
        'data_nascimento' => $faker->dateTimeBetween('-60 years', '-15 years'),
        'sexo' => $faker->randomElement(['M', 'F', 'T', 'O']),
    ];
});
