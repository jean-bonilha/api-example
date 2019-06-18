<?php

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many people you need, defaulting to 100

        $this->command->info("Creating 100 people.");

        // Create the people

        factory(App\Model\Person::class, 50)->create();

        $this->command->info('People created!');
    }
}
