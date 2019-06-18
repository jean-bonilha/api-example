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

        $count = (int)$this->command->ask('How to companies do you need ?', 10);

        $this->command->info("Creating {$count} companies.");

        // Create the companies

        factory(App\Model\Company::class, $count)->create();

        $this->command->info('Companies created!');
    }
}
