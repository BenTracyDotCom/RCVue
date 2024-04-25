<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder{
  public function run(){
    User::all()->each(function ($user) {
      $user->roles()->sync(2);
    });
    User::findOrFail(1)->roles()->sync(1);
  }
}