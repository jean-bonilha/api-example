<?php

use Illuminate\Database\Seeder;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many sectors you need, defaulting to 5

        $this->command->info("Creating 5 sectors.");

        // Create the sectors

        factory(App\Models\Sector::class, 5)->create();

        $this->command->info('Sectors created!');
    }
}
