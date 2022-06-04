<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = User::create([
      'name' => 'Qusay',
      'email' => 'qusay@gmail.com',
      'password' => bcrypt('qusay2001'),
    ]);

    $role = Role::create(['name' => 'owner']);

    $permissions = Permission::pluck('id')->all();

    $role->syncPermissions($permissions);

    $user->assignRole([$role->id]);
  }
}
