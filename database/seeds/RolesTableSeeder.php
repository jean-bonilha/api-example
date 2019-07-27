<?php

use Illuminate\Database\Seeder;
use App\Models\Logs\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate roles collection on MongoDB
        Role::truncate();
        // How to many roles you need, defaulting to 5

        $this->command->info("Creating 5 roles.");

        // Create the roles

        factory(App\Models\Role::class, 5)->create();

        $this->command->info('Roles created!');
    }
}
