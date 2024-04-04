<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleTableSeeder extends Seeder{
  public function run(){
  Role::findOrFail(1)->permissions()->sync([1,2,3]);
  Role::findOrFail(2)->permissions()->sync([1]);
  }
}