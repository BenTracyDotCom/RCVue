<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

