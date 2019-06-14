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

        $count = (int) $this->command->ask('How to users do you need ?', 10);

        $this->command->info("Creating {$count} users.");

        // Create the users

        factory(App\User::class, $count)->create();

        $this->command->info('Users created!');

        $rootUser = App\User::find(1);

        $rootUser->update([
            'name' => 'Jean Bonilha',
            'email' => 'jeanbonilha.webdev@gmail.com',
            'password' => bcrypt('13690002'),
        ]);

        $this->command->info('Root user created!');
    }
}
