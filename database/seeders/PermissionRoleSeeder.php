<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class PermissionRoleSeeder extends Seeder{
  public function run(){

  Role::findOrFail(1)->permissions()->sync([1,2,3]);
  
}
}