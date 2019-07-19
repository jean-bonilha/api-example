<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many employee you need, defaulting to 50

        $this->command->info("Creating 50 employee.");

        // Create the employee

        factory(App\Models\Employee::class, 50)->create();

        $this->command->info('Employee created!');
    }
}
