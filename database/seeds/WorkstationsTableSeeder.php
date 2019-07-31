<?php

use Illuminate\Database\Seeder;
use App\Models\Logs\Workstation;

class WorkstationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate workstations collection on MongoDB
        Workstation::truncate();
        // How to many workstations you need, defaulting to 5

        $this->command->info("Creating 5 workstations.");

        // Create the workstations

        factory(App\Models\Workstation::class, 5)->create();

        $this->command->info('Workstations created!');
    }
}
