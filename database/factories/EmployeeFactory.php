<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'company_id' => DB::table('companies')->inRandomOrder()->get()->id,
        'person_id' => DB::table('people')->inRandomOrder()->get()->id,
        'sector_id' => DB::table('sectors')->inRandomOrder()->get()->id,
        'role_id' => DB::table('roles')->inRandomOrder()->get()->id,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
