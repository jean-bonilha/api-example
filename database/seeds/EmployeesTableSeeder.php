<?php

use Illuminate\Database\Seeder;
use App\Models\Logs\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate employees collection on MongoDB
        Employee::truncate();
        // How to many employee you need, defaulting to 50

        $this->command->info("Creating 50 employee.");

        // Create the employee

        factory(App\Models\Employee::class, 50)->create();

        $this->command->info('Employee created!');
    }
}
