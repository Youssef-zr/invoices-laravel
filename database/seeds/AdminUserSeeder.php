<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /*** Run the database seeds.** @return void*/
    public function run()
    {
        $user = User::create([
            'name' => 'youssef',
            'email' => 'yn-neinaa@hotmail.com',
            'password' => bcrypt('123456'),
            'roles_name' => ['مدير'],
            "status" => 'مفعل',
        ]);

        $role = Role::create(['name' => 'مدير']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
