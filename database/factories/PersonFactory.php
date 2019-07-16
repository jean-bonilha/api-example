<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Person;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Person::class, function (Faker $faker) {

    $addNumber = function ($char, $numbersToPlus, $faker) {
        for ($i=0; $i < $numbersToPlus; $i++) {
            $char .= $faker->randomDigit;
        }
        return $char;
    };

    $cpf = '' ;
    $cpf =+ $addNumber($cpf, 11, $faker);
    $cnh = $cpf;
    $nis = $cpf;
    $ctps_numero = $cpf;
    $ctps_serie = $cpf;

    return [
        'nome' => $faker->name,
        'rg' => $faker->randomNumber(8),
        'data_nascimento' => $faker->dateTimeBetween('-60 years', '-15 years'),
        'sexo' => $faker->randomElement(['M', 'F', 'T', 'O']),
        'rg_orgao_uf_emissao' => 'SSP/AM',
        'rg_data_expedicao' => $faker->dateTimeBetween('-30 years', 'now'),
        'cpf' => $cpf,
        'cnh' => $cnh,
        'cnh_categoria' => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
        'nis' => $nis,
        'raca_cor' => $faker->randomElement(['Branco', 'Preto', 'Pardo']),
        'estado_civil' => $faker->randomElement(['Solteiro', 'Casado', 'Divorciado', 'Viuvo']),
        'grau_instrucao' => $faker->randomElement(['Ensino Medio', 'Superior', 'Pos graduacao']),
        'nome_social' => '',
        'minicipio' => '',
        'uf' => '',
        'codigo_pais_nascimento' => '',
        'nome_mae' => '',
        'nome_pai' => '',
        'ctps_numero' => $ctps_numero,
        'ctps_serie' => $ctps_serie,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
