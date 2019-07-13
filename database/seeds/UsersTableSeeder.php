<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How to many users you need, defaulting to 10

        $count = (int)$this->command->ask('How to users do you need ?', 10);

        $this->command->info("Creating {$count} users.");

        // Create the users

        for ($i=1; $i <= $count; $i++) {
            factory(App\User::class, 1)->create()->each(function ($user) {
                $this->call(CompaniesTableSeeder::class);
                $this->call(PeopleTableSeeder::class);
            });
        }


        $this->command->info('Users created!');

        $rootUser = App\User::find(1);

        $rootUser->update([
            'name' => 'Jean Bonilha',
            'email' => 'jeanbonilha.webdev@gmail.com',
            'password' => bcrypt('13690002'),
        ]);

        $rootUser = App\User::find(2);

        $rootUser->update([
            'name' => 'Alessandro Negrao',
            'email' => 'alessandro.negrao.s@gmail.com',
            'password' => bcrypt('12101995'),
        ]);

        $this->command->info('Root user created!');
    }
}
