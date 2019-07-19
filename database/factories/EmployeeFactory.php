<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Employee;
use Faker\Generator as Faker;
use App\Models\Company;
use App\Models\Person;
use App\Models\Sector;
use App\Models\Role;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'company_id' => Company::inRandomOrder()->first()->id,
        'person_id' => Person::inRandomOrder()->first()->id,
        'sector_id' => Sector::inRandomOrder()->first()->id,
        'role_id' => Role::inRandomOrder()->first()->id,
        'registered_by' => DB::table('users')->orderBy('id', 'desc')->first()->id,
    ];
});
