<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $cnpj = '';
    for ($i=0; $i < 18; $i++) {
        $cnpj .= $faker->randomDigit;
    }
    return [
        'razao_social' => $faker->company,
        'nome_fantasia' => $faker->company,
        'cnpj' => $cnpj,
        'codigo_descricao' => $faker->text,
        'grau_risco' => $faker->randomNumber(2),
        'grupo_risco' => $faker->randomNumber(5),
        'municipio' => $faker->city,
        'uf' => $faker->stateAbbr
    ];
});
