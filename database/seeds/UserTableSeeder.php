<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('slug','admin')->first();
        $write_permission = Permission::where('slug','write')->first();
        $read_permission = Permission::where('slug','read')->first();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('admin');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($write_permission);
        $admin->permissions()->attach($read_permission);

    }
}
