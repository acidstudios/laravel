<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $write_permission = Permission::where('slug','write')->first();
        $read_permission = Permission::where('slug','read')->first();

        $admin = new Role();
        $admin->name = 'Administrator';
        $admin->slug = 'admin';
        $admin->save();
        $admin->permissions()->attach($write_permission);
        $admin->permissions()->attach($read_permission);
    }
}
