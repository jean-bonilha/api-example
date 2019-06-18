<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many companies you need, defaulting to 10

        $this->command->info("Creating 5 companies.");

        // Create the companies

        factory(App\Models\Company::class, 5)->create();

        $this->command->info('Companies created!');
    }
}
