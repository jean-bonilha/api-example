<?php

use Illuminate\Database\Seeder;
use App\Models\Logs\Person;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate people collection on MongoDB
        Person::truncate();
        // How to many people you need, defaulting to 50

        $this->command->info("Creating 50 people.");

        // Create the people

        factory(App\Models\Person::class, 50)->create();

        $this->command->info('People created!');
    }
}
