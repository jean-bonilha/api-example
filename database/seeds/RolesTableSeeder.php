<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many roles you need, defaulting to 50

        $this->command->info("Creating 50 roles.");

        // Create the roles

        factory(App\Models\Role::class, 50)->create();

        $this->command->info('Roles created!');
    }
}
