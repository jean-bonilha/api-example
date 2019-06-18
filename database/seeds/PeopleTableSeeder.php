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

        $count = (int)$this->command->ask('How to people do you need ?', 100);

        $this->command->info("Creating {$count} people.");

        // Create the people

        factory(App\Model\Person::class, $count)->create();

        $this->command->info('People created!');
    }
}
