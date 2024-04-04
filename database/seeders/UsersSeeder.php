<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $users = [
          [
            'id' => 1,
            'username' => 'brengeley',
            'email' => 'b.rob.tracy@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => null,
          ],
          [
            'id' => 2,
            'username' => 'rando',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'remember_token' => null,
          ]  ,
          ];
          User::insert($users);
    }
}
