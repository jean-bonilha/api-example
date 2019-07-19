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
        // How to many sectors you need, defaulting to 50

        $this->command->info("Creating 50 sectors.");

        // Create the sectors

        factory(App\Models\Sector::class, 50)->create();

        $this->command->info('Sectors created!');
    }
}
