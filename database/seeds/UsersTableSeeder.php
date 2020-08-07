<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Empty table
        User::truncate();

        //$faker = \Faker\Factory::create();
        $password = Hash::make('rootUser123#');

        User::create([
            'name' => 'Administrator',
            'address' => 'Burwood',
            'email' => 'admin@laravel.com',
            'role'  => 'admin',
            'password' => $password
        ])->save();

        $password2 = Hash::make('apiUser123#');

        User::create([
            'name' => 'Administrator',
            'address' => 'Camberwell',
            'email' => 'user@laravel.com',
            'role'  => 'user',
            'password' => $password2
        ])->save();

        // can create fake users if needed
        /*for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
            ])->save();
        }*/
    }
}
