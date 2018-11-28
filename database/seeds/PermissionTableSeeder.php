<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $write = new Permission();
        $write->name = 'Allow Write';
        $write->slug = 'write';
        $write->save();

        $read = new Permission();
        $read->name = 'Allow Read';
        $read->slug = 'read';
        $read->save();
    }
}
