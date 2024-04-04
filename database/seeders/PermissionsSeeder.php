<?php

namespace Database\Seeders;

use App\Models\Permission;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
  public function run()
  {
    // TODO: add permissions
    $permissions = [
      [
        'id' => 1,
        'title' => 'part_create'
      ],
      [
        'id' => 2,
        'title' => 'part_edit'
      ],
      [
        'id' => 3,
        'title' => 'part_destroy'
      ],
    ];
    Permission::insert($permissions);
  }
}
